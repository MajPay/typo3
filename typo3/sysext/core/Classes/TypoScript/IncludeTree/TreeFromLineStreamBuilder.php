<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Core\TypoScript\IncludeTree;

use TYPO3\CMS\Core\Resource\Security\FileNameValidator;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\AtImportInclude;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\ConditionElseInclude;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\ConditionInclude;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\ConditionStopInclude;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\DefaultTypoScriptMagicKeyInclude;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\IncludeInterface;
use TYPO3\CMS\Core\TypoScript\IncludeTree\IncludeNode\SegmentInclude;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\ConditionElseLine;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\ConditionLine;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\ConditionStopLine;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\ImportLine;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\LineInterface;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Line\LineStream;
use TYPO3\CMS\Core\TypoScript\Tokenizer\Token\Token;
use TYPO3\CMS\Core\TypoScript\Tokenizer\TokenizerInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Helper class of TreeBuilder classes: This class gets a node with a LineStream - a node
 * created from a sys_template 'constants' or 'setup' field, or created from a
 * file import or a string. It then looks for conditions and imports in the attached LineStream
 * and splits the node into child nodes if needed.
 *
 * So while SysTemplateTreeBuilder is all about creating includes from sys_template records
 * in correct order, this class takes care of conditions and @import within single
 * source streams.
 *
 * This class has no cache-implementation itself: The higher level class caches
 * include trees of token streams.
 *
 * @internal: Internal tree structure.
 */
final class TreeFromLineStreamBuilder
{
    /** @var 'constants'|'setup'|'other' */
    private string $type;
    private TokenizerInterface $tokenizer;
    private bool $enableMagicIncludes = false;

    /**
     * Using "@import" with wildcards, the file ending depends on the given type:
     * With Frontend TypoScript, .typoscript is allowed, with TsConfig, .tsconfig
     * and .typoscript is allowed. This property maps types to their file suffixes.
     *
     * @var array<string, array<int, string>>
     */
    private array $atImportTypeToSuffixMap = [
        'constants' => ['typoscript'],
        'setup' => ['typoscript'],
        'other' => ['typoscript'],
        'tsconfig' => ['typoscript', 'tsconfig'],
    ];

    public function __construct(
        private readonly FileNameValidator $fileNameValidator,
    ) {}

    public function buildTree(IncludeInterface $node, string $type, TokenizerInterface $tokenizer, bool $enableMagicIncludes = true): void
    {
        if (!in_array($type, ['constants', 'setup', 'tsconfig', 'other'], true)) {
            // Type "constants" and "setup" trigger the weird addStaticMagicFromGlobals() resolving, while "other" ignores it.
            throw new \RuntimeException('type must be either "constants", "setup", "tsconfig" or "other"', 1652741356);
        }
        $this->type = $type;
        $this->tokenizer = $tokenizer;
        $this->enableMagicIncludes = $enableMagicIncludes;
        $this->buildTreeInternal($node);
    }

    /**
     * This method is a bit tricky and not too easy to follow: It loops over
     * a given source stream of lines exactly once, but creates a two-level
     * include node structure from it:
     *
     * For instance, when a condition is encountered, it creates a node for the
     * condition, and the "body" lines of the condition are child nodes of the
     * condition node. The $previousNode <-> $node juggling handles this: When
     * the condition body ends (new condition, or [end] or similar), the
     * next include needs to be attached to the former parent node again.
     *
     * Essentially, a single source stream is split into multiple child nodes
     * when there are conditions or imports. A node that is "split" into
     * child nodes gets the "split" toggle set, indicating that the entire
     * source stream is represented by its child nodes.
     *
     * A condition body may have more than one child: When there are multiple
     * file includes, each one creates an own node, which may have children
     * again. This also means the method is called recursive, since the source
     * stream of an included file may need to be split into segments again, so
     * it calls this method again with itself as entry node.
     */
    private function buildTreeInternal(IncludeInterface $node): void
    {
        $parentNode = $node;
        $givenTokenLineStream = $node->getLineStream();
        $lineStream = new LineStream();
        $childNode = new SegmentInclude();
        $childNode->setName($node->getName());
        $childNode->setPath($node->getPath());

        foreach ($givenTokenLineStream->getNextLine() as $line) {
            if ($line instanceof ConditionLine && $node instanceof ConditionInclude) {
                // Finish current condition when this line is another condition
                $node->setSplit();
                if (!$lineStream->isEmpty()) {
                    $childNode->setLineStream($lineStream);
                    $node->addChild($childNode);
                    $lineStream = new LineStream();
                }
                $node = $parentNode;
            }

            if ($line instanceof ConditionLine) {
                // A new condition not yet in condition context
                $node->setSplit();
                $conditionValueToken = $line->getTokenValue();
                if (!$lineStream->isEmpty()) {
                    $childNode->setLineStream($lineStream);
                    $node->addChild($childNode);
                    $lineStream = new LineStream();
                }
                $childNode = new ConditionInclude();
                $childNode->setSplit();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $childNode->setConditionToken($conditionValueToken);
                $lineStream->append($line);
                $childNode->setLineStream($lineStream);
                $node->addChild($childNode);
                $parentNode = $node;
                $node = $childNode;
                $childNode = new SegmentInclude();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $lineStream = new LineStream();
                continue;
            }

            if (($node instanceof ConditionInclude || $node instanceof ConditionElseInclude)
                && $line instanceof ConditionStopLine
            ) {
                // Finish condition segment due to [end] or [global] line
                $node->setSplit();
                $childNode->setLineStream($lineStream);
                $node->addChild($childNode);
                $node = $parentNode;
                $childNode = new ConditionStopInclude();
                $childNode->setName($node->getName());
                $childNode->setLineStream((new LineStream())->append($line));
                $node->addChild($childNode);
                $childNode = new SegmentInclude();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $lineStream = new LineStream();
                continue;
            }

            if ($line instanceof ConditionStopLine) {
                // [end] or [global] not within open condition context. Fishy. Still finish current
                // segment, mark node split, add new ConditionStopInclude(), open a new segment.
                $node->setSplit();
                if (!$lineStream->isEmpty()) {
                    $childNode->setLineStream($lineStream);
                    $node->addChild($childNode);
                }
                $childNode = new ConditionStopInclude();
                $childNode->setName($node->getName());
                $childNode->setLineStream((new LineStream())->append($line));
                $node->addChild($childNode);
                $childNode = new SegmentInclude();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $lineStream = new LineStream();
                continue;
            }

            if ($node instanceof ConditionInclude && $line instanceof ConditionElseLine) {
                // Active condition into [else] condition
                $node->setSplit();
                if (!$lineStream->isEmpty()) {
                    $childNode->setLineStream($lineStream);
                    $node->addChild($childNode);
                }
                $conditionToken = $node->getConditionToken();
                $node = $parentNode;
                $childNode = new ConditionElseInclude();
                $childNode->setSplit();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $childNode->setConditionToken($conditionToken);
                $lineStream = new LineStream();
                $lineStream->append($line);
                $childNode->setLineStream($lineStream);
                $node->addChild($childNode);
                $parentNode = $node;
                $node = $childNode;
                $childNode = new SegmentInclude();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $lineStream = new LineStream();
                continue;
            }

            if ($line instanceof ImportLine) {
                $node->setSplit();
                $atImportValueToken = $line->getValueToken();
                if (!$lineStream->isEmpty()) {
                    $childNode->setLineStream($lineStream);
                    $node->addChild($childNode);
                    $lineStream = new LineStream();
                }
                $childNode = new SegmentInclude();
                $childNode->setName($node->getName());
                $childNode->setPath($node->getPath());
                $allowedSuffixes = $this->atImportTypeToSuffixMap[$this->type];
                foreach ($allowedSuffixes as $allowedSuffix) {
                    $this->processAtImport($allowedSuffix, $node, $atImportValueToken, $line);
                }
                continue;
            }

            $lineStream->append($line);
        }

        if ($node->isSplit() && !$lineStream->isEmpty()) {
            $childNode->setLineStream($lineStream);
            $node->addChild($childNode);
        }
    }

    /**
     * Process a single '@import'. May add multiple children when '*' wildcards are involved.
     * Warning: Calls buildTree() recursive for each included file.
     * Warning: Calls itself recursive for 'relative' lookups.
     */
    private function processAtImport(string $fileSuffix, IncludeInterface $node, Token $atImportValueToken, LineInterface $atImportLine, bool $tryRelative = false): void
    {
        $atImportValue = $atImportValueToken->getValue();
        $atImportName = $atImportValue;
        if ($tryRelative) {
            if (empty($node->getPath())) {
                return;
            }
            $parentPath = rtrim(dirname($node->getPath()), '/') . '/';
            $atImportValue = ltrim($atImportValue, './');
            $atImportName = preg_replace('#([:/])[^:/]+$#', '$1', $node->getName()) . $atImportValue;
            $atImportValue = $parentPath . $atImportValue;
        }
        $absoluteFileName = rtrim(GeneralUtility::getFileAbsFileName($atImportValue), '/');
        if ($absoluteFileName === '') {
            return;
        }
        if (str_ends_with($absoluteFileName, '.' . $fileSuffix) && is_file($absoluteFileName)) {
            // Simple file with allowed file suffix
            if ($this->fileNameValidator->isValid($absoluteFileName)) {
                $this->addSingleAtImportFile($node, $absoluteFileName, $atImportValue, $atImportName, $atImportLine);
                $this->addStaticMagicFromGlobals($node, $atImportValue);
            }
        } elseif (is_dir($absoluteFileName)) {
            // Directories with and without ending /
            $filesAndDirs = scandir($absoluteFileName);
            foreach ($filesAndDirs as $potentialInclude) {
                if (!str_ends_with($potentialInclude, '.' . $fileSuffix)
                    || is_dir($absoluteFileName . '/' . $potentialInclude)
                    || !$this->fileNameValidator->isValid($absoluteFileName . '/' . $potentialInclude)
                ) {
                    continue;
                }
                $singleAbsoluteFileName = $absoluteFileName . '/' . $potentialInclude;
                $identifier = rtrim($atImportValue, '/') . '/' . $potentialInclude;
                $this->addSingleAtImportFile($node, $singleAbsoluteFileName, $identifier, $identifier, $atImportLine);
                $this->addStaticMagicFromGlobals($node, $identifier);
            }
        } elseif (is_file($absoluteFileName . '.' . $fileSuffix)) {
            // File without .typoscript / .tsconfig suffix, but exists when suffix is added
            if ($this->fileNameValidator->isValid($absoluteFileName . '.' . $fileSuffix)) {
                $singleAbsoluteFileName = $absoluteFileName . '.' . $fileSuffix;
                $identifier = $atImportValue . '.' . $fileSuffix;
                $this->addSingleAtImportFile($node, $singleAbsoluteFileName, $identifier, $identifier, $atImportLine);
                $this->addStaticMagicFromGlobals($node, $identifier);
            }
        } elseif (str_contains($absoluteFileName, '*')) {
            // Something with *
            $directory = rtrim(dirname($absoluteFileName) . '/');
            $directoryExists = is_dir($directory);
            if (!$directoryExists && str_starts_with($atImportValue, './') && !$tryRelative) {
                // See if we can import some relative wildcard like "./Setup/*" or "./Setup/*.typoscript"
                $this->processAtImport($fileSuffix, $node, $atImportValueToken, $atImportLine, true);
                return;
            }
            if (!$directoryExists) {
                // Absolute directory. There is nothing to import if the directory does not exist.
                return;
            }
            $filePattern = basename($absoluteFileName);
            if (!str_contains($filePattern, '*')) {
                // The * wildcard must occur in the filename, wildcards in directories are not handled.
                return;
            }
            if (mb_substr_count($filePattern, '*') > 1) {
                // Only one wildcard character is allowed, foo*.bar*.typoscript is considered an invalid pattern.
                return;
            }
            // Normalize right side, making sure it always ends with $fileSuffix ".typoscript" / ".tsconfig"
            if (str_ends_with($filePattern, $fileSuffix)) {
                $filePattern = mb_substr($filePattern, 0, -1 * strlen($fileSuffix));
                $filePattern = rtrim($filePattern, '.');
            }
            $filePattern = $filePattern . '.' . $fileSuffix;
            $wildcardPosition = mb_strpos($filePattern, '*');
            $leftPrefix = mb_substr($filePattern, 0, $wildcardPosition);
            $rightPrefix = mb_substr($filePattern, $wildcardPosition + 1);
            $filesAndDirs = scandir($directory);
            foreach ($filesAndDirs as $potentialInclude) {
                if ($potentialInclude === '.'
                    || $potentialInclude === '..'
                    || !str_starts_with($potentialInclude, $leftPrefix)
                    || !str_ends_with($potentialInclude, $rightPrefix)
                    || is_dir($directory . $potentialInclude)
                    || !$this->fileNameValidator->isValid($directory . $potentialInclude)
                ) {
                    continue;
                }
                $singleAbsoluteFileName = $directory . $potentialInclude;
                $identifier = rtrim(dirname($atImportValue), '/') . '/' . $potentialInclude;
                $this->addSingleAtImportFile($node, $singleAbsoluteFileName, $identifier, $identifier, $atImportLine);
                $this->addStaticMagicFromGlobals($node, $identifier);
            }
        } elseif (!$tryRelative) {
            // See if we can import relative "./foo.typoscript" or "foo.typoscript"
            $this->processAtImport($fileSuffix, $node, $atImportValueToken, $atImportLine, true);
        }
    }

    /**
     * Get content of a single @import file and add to current node as child.
     *
     * Warning: Recursively calls buildTree() to process includes of included content.
     */
    private function addSingleAtImportFile(
        IncludeInterface $parentNode,
        string $absoluteFileName,
        string $path,
        string $name,
        LineInterface $atImportLine
    ): void {
        $content = file_get_contents($absoluteFileName);
        $newNode = new AtImportInclude();
        $newNode->setName($name);
        $newNode->setPath($path);
        $newNode->setLineStream($this->tokenizer->tokenize($content));
        $newNode->setOriginalLine($atImportLine);
        $this->buildTreeInternal($newNode);
        $parentNode->addChild($newNode);
    }

    /**
     * A rather weird lookup in $GLOBALS['TYPO3_CONF_VARS']['FE'] for magic includes.
     * See ExtensionManagementUtility::addTypoScript() for more details on this.
     * Warning: Yes, this is recursive again.
     */
    private function addStaticMagicFromGlobals(IncludeInterface $parentNode, string $path): void
    {
        if (!in_array($this->type, ['constants', 'setup'], true) || !str_starts_with($path, 'EXT:')) {
            // This magic method is relevant for Frontend TypoScript only, indicated by
            // $this->type being either "constants" or "setup".
            return;
        }
        $includeStaticFileWithoutExt = substr($path, 4);
        $includeStaticFileExtKeyAndPath = GeneralUtility::trimExplode('/', $includeStaticFileWithoutExt, true, 2);
        $extensionKey = $includeStaticFileExtKeyAndPath[0];
        $extensionKeyWithoutUnderscores = str_replace('_', '', $extensionKey);
        if (!$extensionKeyWithoutUnderscores || !ExtensionManagementUtility::isLoaded($extensionKey)) {
            return;
        }
        // example: 'Configuration/TypoScript/MyStaticInclude/'
        $pathSegmentWithAppendedSlash = rtrim(dirname($includeStaticFileExtKeyAndPath[1])) . '/';
        $file = basename($path);
        $type = GeneralUtility::trimExplode('.', $file, false, 2)[0] ?? '';
        if ($type !== $this->type) {
            return;
        }
        $globalsLookup = $extensionKeyWithoutUnderscores . '/' . $pathSegmentWithAppendedSlash;

        if (!$this->enableMagicIncludes) {
            return;
        }
        // If this is a template of type "default content rendering", see if other extensions have added their TypoScript that should be included.
        if (in_array($globalsLookup, $GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'], true)) {
            $source = $GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_' . $type . '.']['defaultContentRendering'] ?? null;
            if (!empty($source)) {
                $node = new DefaultTypoScriptMagicKeyInclude();
                $node->setName('TYPO3_CONF_VARS defaultContentRendering for ' . $path);
                $node->setLineStream($this->tokenizer->tokenize($source));
                $this->buildTreeInternal($node);
                $parentNode->addChild($node);
            }
        }
    }
}
