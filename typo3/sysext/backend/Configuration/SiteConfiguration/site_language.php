<?php

return [
    'ctrl' => [
        'label' => 'languageId',
        'label_userFunc' => \TYPO3\CMS\Backend\Configuration\TCA\UserFunctions::class . '->getSiteLanguageTitle',
        'title' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.ctrl.title',
        'typeicon_classes' => [
            'default' => 'mimetypes-x-content-domain',
        ],
    ],
    'columns' => [
        'languageId' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.languageId',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => \TYPO3\CMS\Backend\Configuration\TCA\ItemsProcessorFunctions::class . '->populateAvailableLanguagesFromSites',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.title',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'required' => true,
                'eval' => 'trim',
                'placeholder' => 'English',
            ],
        ],
        'navigationTitle' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.navigationTitle',
            'description' => 'LLL:EXT:backend/Resources/Private/Language/siteconfiguration_fieldinformation.xlf:site_language.navigationTitle',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim',
                'placeholder' => 'English',
            ],
        ],
        'base' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.base',
            'description' => 'LLL:EXT:backend/Resources/Private/Language/siteconfiguration_fieldinformation.xlf:site_language.base',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
                'size' => 15,
                'default' => '/',
                'placeholder' => '/',
            ],
        ],
        'websiteTitle' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.websiteTitle',
            'description' => 'LLL:EXT:backend/Resources/Private/Language/siteconfiguration_fieldinformation.xlf:site_language.websiteTitle',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'locale' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.locale',
            'description' => 'LLL:EXT:backend/Resources/Private/Language/siteconfiguration_fieldinformation.xlf:site_language.locale',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
                'size' => 20,
                'placeholder' => 'en-US',
                'valuePicker' => [
                    'mode' => '',
                    'items' => \TYPO3\CMS\Backend\Configuration\TCA\UserFunctions::getAllSystemLocales(),
                ],
            ],
        ],
        'hreflang' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.hreflang',
            'description' => 'LLL:EXT:backend/Resources/Private/Language/siteconfiguration_fieldinformation.xlf:site_language.hreflang',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => 6,
                'default' => '',
                'placeholder' => 'en-US',
            ],
        ],
        'enabled' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'flag' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.flag',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'global', 'value' => 'global', 'icon' => 'flags-multiple'],
                    ['label' => 'en-us-gb', 'value' => 'en-us-gb', 'icon' => 'flags-en-us-gb'],
                    // Countries/Regions
                    ['label' => 'ad', 'value' => 'ad', 'icon' => 'flags-ad'],
                    ['label' => 'ae', 'value' => 'ae', 'icon' => 'flags-ae'],
                    ['label' => 'af', 'value' => 'af', 'icon' => 'flags-af'],
                    ['label' => 'ag', 'value' => 'ag', 'icon' => 'flags-ag'],
                    ['label' => 'ai', 'value' => 'ai', 'icon' => 'flags-ai'],
                    ['label' => 'al', 'value' => 'al', 'icon' => 'flags-al'],
                    ['label' => 'am', 'value' => 'am', 'icon' => 'flags-am'],
                    ['label' => 'ao', 'value' => 'ao', 'icon' => 'flags-ao'],
                    ['label' => 'aq', 'value' => 'aq', 'icon' => 'flags-aq'],
                    ['label' => 'ar', 'value' => 'ar', 'icon' => 'flags-ar'],
                    ['label' => 'as', 'value' => 'as', 'icon' => 'flags-as'],
                    ['label' => 'at', 'value' => 'at', 'icon' => 'flags-at'],
                    ['label' => 'au', 'value' => 'au', 'icon' => 'flags-au'],
                    ['label' => 'aw', 'value' => 'aw', 'icon' => 'flags-aw'],
                    ['label' => 'ax', 'value' => 'ax', 'icon' => 'flags-ax'],
                    ['label' => 'az', 'value' => 'az', 'icon' => 'flags-az'],
                    ['label' => 'ba', 'value' => 'ba', 'icon' => 'flags-ba'],
                    ['label' => 'bb', 'value' => 'bb', 'icon' => 'flags-bb'],
                    ['label' => 'bd', 'value' => 'bd', 'icon' => 'flags-bd'],
                    ['label' => 'be', 'value' => 'be', 'icon' => 'flags-be'],
                    ['label' => 'bf', 'value' => 'bf', 'icon' => 'flags-bf'],
                    ['label' => 'bg', 'value' => 'bg', 'icon' => 'flags-bg'],
                    ['label' => 'bh', 'value' => 'bh', 'icon' => 'flags-bh'],
                    ['label' => 'bi', 'value' => 'bi', 'icon' => 'flags-bi'],
                    ['label' => 'bj', 'value' => 'bj', 'icon' => 'flags-bj'],
                    ['label' => 'bl', 'value' => 'bl', 'icon' => 'flags-bl'],
                    ['label' => 'bm', 'value' => 'bm', 'icon' => 'flags-bm'],
                    ['label' => 'bn', 'value' => 'bn', 'icon' => 'flags-bn'],
                    ['label' => 'bo', 'value' => 'bo', 'icon' => 'flags-bo'],
                    ['label' => 'bq', 'value' => 'bq', 'icon' => 'flags-bq'],
                    ['label' => 'br', 'value' => 'br', 'icon' => 'flags-br'],
                    ['label' => 'bs', 'value' => 'bs', 'icon' => 'flags-bs'],
                    ['label' => 'bt', 'value' => 'bt', 'icon' => 'flags-bt'],
                    ['label' => 'bv', 'value' => 'bv', 'icon' => 'flags-bv'],
                    ['label' => 'bw', 'value' => 'bw', 'icon' => 'flags-bw'],
                    ['label' => 'by', 'value' => 'by', 'icon' => 'flags-by'],
                    ['label' => 'bz', 'value' => 'bz', 'icon' => 'flags-bz'],
                    ['label' => 'ca', 'value' => 'ca', 'icon' => 'flags-ca'],
                    ['label' => 'ca-qc', 'value' => 'ca-qc', 'icon' => 'flags-ca-qc'],
                    ['label' => 'cc', 'value' => 'cc', 'icon' => 'flags-cc'],
                    ['label' => 'cd', 'value' => 'cd', 'icon' => 'flags-cd'],
                    ['label' => 'cf', 'value' => 'cf', 'icon' => 'flags-cf'],
                    ['label' => 'cg', 'value' => 'cg', 'icon' => 'flags-cg'],
                    ['label' => 'ch', 'value' => 'ch', 'icon' => 'flags-ch'],
                    ['label' => 'ci', 'value' => 'ci', 'icon' => 'flags-ci'],
                    ['label' => 'ck', 'value' => 'ck', 'icon' => 'flags-ck'],
                    ['label' => 'cl', 'value' => 'cl', 'icon' => 'flags-cl'],
                    ['label' => 'cm', 'value' => 'cm', 'icon' => 'flags-cm'],
                    ['label' => 'cn', 'value' => 'cn', 'icon' => 'flags-cn'],
                    ['label' => 'co', 'value' => 'co', 'icon' => 'flags-co'],
                    ['label' => 'cr', 'value' => 'cr', 'icon' => 'flags-cr'],
                    ['label' => 'cu', 'value' => 'cu', 'icon' => 'flags-cu'],
                    ['label' => 'cv', 'value' => 'cv', 'icon' => 'flags-cv'],
                    ['label' => 'cw', 'value' => 'cw', 'icon' => 'flags-cw'],
                    ['label' => 'cx', 'value' => 'cx', 'icon' => 'flags-cx'],
                    ['label' => 'cy', 'value' => 'cy', 'icon' => 'flags-cy'],
                    ['label' => 'cz', 'value' => 'cz', 'icon' => 'flags-cz'],
                    ['label' => 'de', 'value' => 'de', 'icon' => 'flags-de'],
                    ['label' => 'dj', 'value' => 'dj', 'icon' => 'flags-dj'],
                    ['label' => 'dk', 'value' => 'dk', 'icon' => 'flags-dk'],
                    ['label' => 'dm', 'value' => 'dm', 'icon' => 'flags-dm'],
                    ['label' => 'do', 'value' => 'do', 'icon' => 'flags-do'],
                    ['label' => 'dz', 'value' => 'dz', 'icon' => 'flags-dz'],
                    ['label' => 'ec', 'value' => 'ec', 'icon' => 'flags-ec'],
                    ['label' => 'ee', 'value' => 'ee', 'icon' => 'flags-ee'],
                    ['label' => 'eg', 'value' => 'eg', 'icon' => 'flags-eg'],
                    ['label' => 'eh', 'value' => 'eh', 'icon' => 'flags-eh'],
                    ['label' => 'er', 'value' => 'er', 'icon' => 'flags-er'],
                    ['label' => 'es', 'value' => 'es', 'icon' => 'flags-es'],
                    ['label' => 'es-ct', 'value' => 'es-ct', 'icon' => 'flags-es-ct'],
                    ['label' => 'es-ga', 'value' => 'es-ga', 'icon' => 'flags-es-ga'],
                    ['label' => 'et', 'value' => 'et', 'icon' => 'flags-et'],
                    ['label' => 'eu', 'value' => 'eu', 'icon' => 'flags-eu'],
                    ['label' => 'fi', 'value' => 'fi', 'icon' => 'flags-fi'],
                    ['label' => 'fj', 'value' => 'fj', 'icon' => 'flags-fj'],
                    ['label' => 'fk', 'value' => 'fk', 'icon' => 'flags-fk'],
                    ['label' => 'fm', 'value' => 'fm', 'icon' => 'flags-fm'],
                    ['label' => 'fo', 'value' => 'fo', 'icon' => 'flags-fo'],
                    ['label' => 'fr', 'value' => 'fr', 'icon' => 'flags-fr'],
                    ['label' => 'ga', 'value' => 'ga', 'icon' => 'flags-ga'],
                    ['label' => 'gb', 'value' => 'gb', 'icon' => 'flags-gb'],
                    ['label' => 'gb-eng', 'value' => 'gb-eng', 'icon' => 'flags-gb-eng'],
                    ['label' => 'gb-nir', 'value' => 'gb-nir', 'icon' => 'flags-gb-nir'],
                    ['label' => 'gb-sct', 'value' => 'gb-sct', 'icon' => 'flags-gb-sct'],
                    ['label' => 'gb-wls', 'value' => 'gb-wls', 'icon' => 'flags-gb-wls'],
                    ['label' => 'gd', 'value' => 'gd', 'icon' => 'flags-gd'],
                    ['label' => 'ge', 'value' => 'ge', 'icon' => 'flags-ge'],
                    ['label' => 'gf', 'value' => 'gf', 'icon' => 'flags-gf'],
                    ['label' => 'gg', 'value' => 'gg', 'icon' => 'flags-gg'],
                    ['label' => 'gh', 'value' => 'gh', 'icon' => 'flags-gh'],
                    ['label' => 'gi', 'value' => 'gi', 'icon' => 'flags-gi'],
                    ['label' => 'gl', 'value' => 'gl', 'icon' => 'flags-gl'],
                    ['label' => 'gm', 'value' => 'gm', 'icon' => 'flags-gm'],
                    ['label' => 'gn', 'value' => 'gn', 'icon' => 'flags-gn'],
                    ['label' => 'gp', 'value' => 'gp', 'icon' => 'flags-gp'],
                    ['label' => 'gq', 'value' => 'gq', 'icon' => 'flags-gq'],
                    ['label' => 'gr', 'value' => 'gr', 'icon' => 'flags-gr'],
                    ['label' => 'gs', 'value' => 'gs', 'icon' => 'flags-gs'],
                    ['label' => 'gt', 'value' => 'gt', 'icon' => 'flags-gt'],
                    ['label' => 'gu', 'value' => 'gu', 'icon' => 'flags-gu'],
                    ['label' => 'gw', 'value' => 'gw', 'icon' => 'flags-gw'],
                    ['label' => 'gy', 'value' => 'gy', 'icon' => 'flags-gy'],
                    ['label' => 'hk', 'value' => 'hk', 'icon' => 'flags-hk'],
                    ['label' => 'hm', 'value' => 'hm', 'icon' => 'flags-hm'],
                    ['label' => 'hn', 'value' => 'hn', 'icon' => 'flags-hn'],
                    ['label' => 'hr', 'value' => 'hr', 'icon' => 'flags-hr'],
                    ['label' => 'ht', 'value' => 'ht', 'icon' => 'flags-ht'],
                    ['label' => 'hu', 'value' => 'hu', 'icon' => 'flags-hu'],
                    ['label' => 'id', 'value' => 'id', 'icon' => 'flags-id'],
                    ['label' => 'ie', 'value' => 'ie', 'icon' => 'flags-ie'],
                    ['label' => 'il', 'value' => 'il', 'icon' => 'flags-il'],
                    ['label' => 'im', 'value' => 'im', 'icon' => 'flags-im'],
                    ['label' => 'in', 'value' => 'in', 'icon' => 'flags-in'],
                    ['label' => 'io', 'value' => 'io', 'icon' => 'flags-io'],
                    ['label' => 'iq', 'value' => 'iq', 'icon' => 'flags-iq'],
                    ['label' => 'ir', 'value' => 'ir', 'icon' => 'flags-ir'],
                    ['label' => 'is', 'value' => 'is', 'icon' => 'flags-is'],
                    ['label' => 'it', 'value' => 'it', 'icon' => 'flags-it'],
                    ['label' => 'jm', 'value' => 'jm', 'icon' => 'flags-jm'],
                    ['label' => 'jo', 'value' => 'jo', 'icon' => 'flags-jo'],
                    ['label' => 'jp', 'value' => 'jp', 'icon' => 'flags-jp'],
                    ['label' => 'ke', 'value' => 'ke', 'icon' => 'flags-ke'],
                    ['label' => 'kg', 'value' => 'kg', 'icon' => 'flags-kg'],
                    ['label' => 'kh', 'value' => 'kh', 'icon' => 'flags-kh'],
                    ['label' => 'ki', 'value' => 'ki', 'icon' => 'flags-ki'],
                    ['label' => 'km', 'value' => 'km', 'icon' => 'flags-km'],
                    ['label' => 'kn', 'value' => 'kn', 'icon' => 'flags-kn'],
                    ['label' => 'kp', 'value' => 'kp', 'icon' => 'flags-kp'],
                    ['label' => 'kr', 'value' => 'kr', 'icon' => 'flags-kr'],
                    ['label' => 'kw', 'value' => 'kw', 'icon' => 'flags-kw'],
                    ['label' => 'ky', 'value' => 'ky', 'icon' => 'flags-ky'],
                    ['label' => 'kz', 'value' => 'kz', 'icon' => 'flags-kz'],
                    ['label' => 'la', 'value' => 'la', 'icon' => 'flags-la'],
                    ['label' => 'lb', 'value' => 'lb', 'icon' => 'flags-lb'],
                    ['label' => 'lc', 'value' => 'lc', 'icon' => 'flags-lc'],
                    ['label' => 'li', 'value' => 'li', 'icon' => 'flags-li'],
                    ['label' => 'lk', 'value' => 'lk', 'icon' => 'flags-lk'],
                    ['label' => 'lr', 'value' => 'lr', 'icon' => 'flags-lr'],
                    ['label' => 'ls', 'value' => 'ls', 'icon' => 'flags-ls'],
                    ['label' => 'lt', 'value' => 'lt', 'icon' => 'flags-lt'],
                    ['label' => 'lu', 'value' => 'lu', 'icon' => 'flags-lu'],
                    ['label' => 'lv', 'value' => 'lv', 'icon' => 'flags-lv'],
                    ['label' => 'ly', 'value' => 'ly', 'icon' => 'flags-ly'],
                    ['label' => 'ma', 'value' => 'ma', 'icon' => 'flags-ma'],
                    ['label' => 'mc', 'value' => 'mc', 'icon' => 'flags-mc'],
                    ['label' => 'md', 'value' => 'md', 'icon' => 'flags-md'],
                    ['label' => 'me', 'value' => 'me', 'icon' => 'flags-me'],
                    ['label' => 'mf', 'value' => 'mf', 'icon' => 'flags-mf'],
                    ['label' => 'mg', 'value' => 'mg', 'icon' => 'flags-mg'],
                    ['label' => 'mh', 'value' => 'mh', 'icon' => 'flags-mh'],
                    ['label' => 'mk', 'value' => 'mk', 'icon' => 'flags-mk'],
                    ['label' => 'ml', 'value' => 'ml', 'icon' => 'flags-ml'],
                    ['label' => 'mm', 'value' => 'mm', 'icon' => 'flags-mm'],
                    ['label' => 'mn', 'value' => 'mn', 'icon' => 'flags-mn'],
                    ['label' => 'mo', 'value' => 'mo', 'icon' => 'flags-mo'],
                    ['label' => 'mp', 'value' => 'mp', 'icon' => 'flags-mp'],
                    ['label' => 'mq', 'value' => 'mq', 'icon' => 'flags-mq'],
                    ['label' => 'mr', 'value' => 'mr', 'icon' => 'flags-mr'],
                    ['label' => 'ms', 'value' => 'ms', 'icon' => 'flags-ms'],
                    ['label' => 'mt', 'value' => 'mt', 'icon' => 'flags-mt'],
                    ['label' => 'mu', 'value' => 'mu', 'icon' => 'flags-mu'],
                    ['label' => 'mv', 'value' => 'mv', 'icon' => 'flags-mv'],
                    ['label' => 'mw', 'value' => 'mw', 'icon' => 'flags-mw'],
                    ['label' => 'mx', 'value' => 'mx', 'icon' => 'flags-mx'],
                    ['label' => 'my', 'value' => 'my', 'icon' => 'flags-my'],
                    ['label' => 'mz', 'value' => 'mz', 'icon' => 'flags-mz'],
                    ['label' => 'na', 'value' => 'na', 'icon' => 'flags-na'],
                    ['label' => 'nc', 'value' => 'nc', 'icon' => 'flags-nc'],
                    ['label' => 'ne', 'value' => 'ne', 'icon' => 'flags-ne'],
                    ['label' => 'nf', 'value' => 'nf', 'icon' => 'flags-nf'],
                    ['label' => 'ng', 'value' => 'ng', 'icon' => 'flags-ng'],
                    ['label' => 'ni', 'value' => 'ni', 'icon' => 'flags-ni'],
                    ['label' => 'nl', 'value' => 'nl', 'icon' => 'flags-nl'],
                    ['label' => 'no', 'value' => 'no', 'icon' => 'flags-no'],
                    ['label' => 'np', 'value' => 'np', 'icon' => 'flags-np'],
                    ['label' => 'nr', 'value' => 'nr', 'icon' => 'flags-nr'],
                    ['label' => 'nu', 'value' => 'nu', 'icon' => 'flags-nu'],
                    ['label' => 'nz', 'value' => 'nz', 'icon' => 'flags-nz'],
                    ['label' => 'om', 'value' => 'om', 'icon' => 'flags-om'],
                    ['label' => 'pa', 'value' => 'pa', 'icon' => 'flags-pa'],
                    ['label' => 'pe', 'value' => 'pe', 'icon' => 'flags-pe'],
                    ['label' => 'pf', 'value' => 'pf', 'icon' => 'flags-pf'],
                    ['label' => 'pg', 'value' => 'pg', 'icon' => 'flags-pg'],
                    ['label' => 'ph', 'value' => 'ph', 'icon' => 'flags-ph'],
                    ['label' => 'pk', 'value' => 'pk', 'icon' => 'flags-pk'],
                    ['label' => 'pl', 'value' => 'pl', 'icon' => 'flags-pl'],
                    ['label' => 'pm', 'value' => 'pm', 'icon' => 'flags-pm'],
                    ['label' => 'pn', 'value' => 'pn', 'icon' => 'flags-pn'],
                    ['label' => 'pr', 'value' => 'pr', 'icon' => 'flags-pr'],
                    ['label' => 'ps', 'value' => 'ps', 'icon' => 'flags-ps'],
                    ['label' => 'pt', 'value' => 'pt', 'icon' => 'flags-pt'],
                    ['label' => 'pw', 'value' => 'pw', 'icon' => 'flags-pw'],
                    ['label' => 'py', 'value' => 'py', 'icon' => 'flags-py'],
                    ['label' => 'qa', 'value' => 'qa', 'icon' => 'flags-qa'],
                    ['label' => 're', 'value' => 're', 'icon' => 'flags-re'],
                    ['label' => 'ro', 'value' => 'ro', 'icon' => 'flags-ro'],
                    ['label' => 'rs', 'value' => 'rs', 'icon' => 'flags-rs'],
                    ['label' => 'ru', 'value' => 'ru', 'icon' => 'flags-ru'],
                    ['label' => 'rw', 'value' => 'rw', 'icon' => 'flags-rw'],
                    ['label' => 'sa', 'value' => 'sa', 'icon' => 'flags-sa'],
                    ['label' => 'sb', 'value' => 'sb', 'icon' => 'flags-sb'],
                    ['label' => 'sc', 'value' => 'sc', 'icon' => 'flags-sc'],
                    ['label' => 'sd', 'value' => 'sd', 'icon' => 'flags-sd'],
                    ['label' => 'se', 'value' => 'se', 'icon' => 'flags-se'],
                    ['label' => 'sg', 'value' => 'sg', 'icon' => 'flags-sg'],
                    ['label' => 'sh', 'value' => 'sh', 'icon' => 'flags-sh'],
                    ['label' => 'si', 'value' => 'si', 'icon' => 'flags-si'],
                    ['label' => 'sj', 'value' => 'sj', 'icon' => 'flags-sj'],
                    ['label' => 'sk', 'value' => 'sk', 'icon' => 'flags-sk'],
                    ['label' => 'sl', 'value' => 'sl', 'icon' => 'flags-sl'],
                    ['label' => 'sm', 'value' => 'sm', 'icon' => 'flags-sm'],
                    ['label' => 'sn', 'value' => 'sn', 'icon' => 'flags-sn'],
                    ['label' => 'so', 'value' => 'so', 'icon' => 'flags-so'],
                    ['label' => 'sr', 'value' => 'sr', 'icon' => 'flags-sr'],
                    ['label' => 'ss', 'value' => 'ss', 'icon' => 'flags-ss'],
                    ['label' => 'st', 'value' => 'st', 'icon' => 'flags-st'],
                    ['label' => 'sv', 'value' => 'sv', 'icon' => 'flags-sv'],
                    ['label' => 'sx', 'value' => 'sx', 'icon' => 'flags-sx'],
                    ['label' => 'sy', 'value' => 'sy', 'icon' => 'flags-sy'],
                    ['label' => 'sz', 'value' => 'sz', 'icon' => 'flags-sz'],
                    ['label' => 'tc', 'value' => 'tc', 'icon' => 'flags-tc'],
                    ['label' => 'td', 'value' => 'td', 'icon' => 'flags-td'],
                    ['label' => 'tf', 'value' => 'tf', 'icon' => 'flags-tf'],
                    ['label' => 'tg', 'value' => 'tg', 'icon' => 'flags-tg'],
                    ['label' => 'th', 'value' => 'th', 'icon' => 'flags-th'],
                    ['label' => 'tj', 'value' => 'tj', 'icon' => 'flags-tj'],
                    ['label' => 'tk', 'value' => 'tk', 'icon' => 'flags-tk'],
                    ['label' => 'tl', 'value' => 'tl', 'icon' => 'flags-tl'],
                    ['label' => 'tm', 'value' => 'tm', 'icon' => 'flags-tm'],
                    ['label' => 'tn', 'value' => 'tn', 'icon' => 'flags-tn'],
                    ['label' => 'to', 'value' => 'to', 'icon' => 'flags-to'],
                    ['label' => 'tr', 'value' => 'tr', 'icon' => 'flags-tr'],
                    ['label' => 'tt', 'value' => 'tt', 'icon' => 'flags-tt'],
                    ['label' => 'tv', 'value' => 'tv', 'icon' => 'flags-tv'],
                    ['label' => 'tw', 'value' => 'tw', 'icon' => 'flags-tw'],
                    ['label' => 'tz', 'value' => 'tz', 'icon' => 'flags-tz'],
                    ['label' => 'ua', 'value' => 'ua', 'icon' => 'flags-ua'],
                    ['label' => 'ug', 'value' => 'ug', 'icon' => 'flags-ug'],
                    ['label' => 'us', 'value' => 'us', 'icon' => 'flags-us'],
                    ['label' => 'uy', 'value' => 'uy', 'icon' => 'flags-uy'],
                    ['label' => 'uz', 'value' => 'uz', 'icon' => 'flags-uz'],
                    ['label' => 'va', 'value' => 'va', 'icon' => 'flags-va'],
                    ['label' => 'vc', 'value' => 'vc', 'icon' => 'flags-vc'],
                    ['label' => 've', 'value' => 've', 'icon' => 'flags-ve'],
                    ['label' => 'vg', 'value' => 'vg', 'icon' => 'flags-vg'],
                    ['label' => 'vi', 'value' => 'vi', 'icon' => 'flags-vi'],
                    ['label' => 'vn', 'value' => 'vn', 'icon' => 'flags-vn'],
                    ['label' => 'vu', 'value' => 'vu', 'icon' => 'flags-vu'],
                    ['label' => 'wf', 'value' => 'wf', 'icon' => 'flags-wf'],
                    ['label' => 'ws', 'value' => 'ws', 'icon' => 'flags-ws'],
                    ['label' => 'ye', 'value' => 'ye', 'icon' => 'flags-ye'],
                    ['label' => 'yt', 'value' => 'yt', 'icon' => 'flags-yt'],
                    ['label' => 'za', 'value' => 'za', 'icon' => 'flags-za'],
                    ['label' => 'zm', 'value' => 'zm', 'icon' => 'flags-zm'],
                    ['label' => 'zw', 'value' => 'zw', 'icon' => 'flags-zw'],
                    // Colors
                    ['label' => 'black', 'value' => 'black', 'icon' => 'flags-black'],
                    ['label' => 'white', 'value' => 'white', 'icon' => 'flags-white'],
                    ['label' => 'blue', 'value' => 'blue', 'icon' => 'flags-blue'],
                    ['label' => 'indigo', 'value' => 'indigo', 'icon' => 'flags-indigo'],
                    ['label' => 'purple', 'value' => 'purple', 'icon' => 'flags-purple'],
                    ['label' => 'pink', 'value' => 'pink', 'icon' => 'flags-pink'],
                    ['label' => 'orange', 'value' => 'orange', 'icon' => 'flags-orange'],
                    ['label' => 'yellow', 'value' => 'yellow', 'icon' => 'flags-yellow'],
                    ['label' => 'green', 'value' => 'green', 'icon' => 'flags-green'],
                    ['label' => 'teal', 'value' => 'teal', 'icon' => 'flags-teal'],
                    ['label' => 'cyan', 'value' => 'cyan', 'icon' => 'flags-cyan'],
                    ['label' => 'rainbow', 'value' => 'rainbow', 'icon' => 'flags-rainbow'],
                ],
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ],
        ],
        'fallbackType' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.fallbackType',
            'displayCond' => 'FIELD:languageId:>:0',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.fallbackType.strict', 'value' => 'strict'],
                    ['label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.fallbackType.fallback', 'value' => 'fallback'],
                    ['label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.fallbackType.free', 'value' => 'free'],
                ],
            ],
        ],
        'fallbacks' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.fallbacks',
            'displayCond' => 'FIELD:languageId:>:0',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => \TYPO3\CMS\Backend\Configuration\TCA\ItemsProcessorFunctions::class . '->populateFallbackLanguages',
                'size' => 5,
                'min' => 0,
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '--palette--;;default, --palette--;;rendering-related, flag, --palette--;;languageIdPalette',
        ],
    ],
    'palettes' => [
        'default' => [
            'showitem' => 'title, enabled, --linebreak--, locale, hreflang, --linebreak--, base',
        ],
        'languageIdPalette' => [
            'showitem' => 'languageId',
            'isHiddenPalette' => true,
        ],
        'rendering-related' => [
            'label' => 'LLL:EXT:backend/Resources/Private/Language/locallang_siteconfiguration_tca.xlf:site_language.palette.frontend',
            'showitem' => 'websiteTitle, navigationTitle, --linebreak--, fallbackType, --linebreak--, fallbacks',
        ],
    ],
];
