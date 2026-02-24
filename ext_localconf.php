<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

$boot = function () {

    $emSettings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('t3calendar');

    // caching
    $identifier = 't3calendar_content';
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier] = [];
    }

    // register t3calendar content cache with pages group
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier]['groups'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier]['groups'] = ['pages', 'all'];
    }

    // disable cache
    if (
        !(bool)$emSettings['enableWidgetCache']
        && !isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier]['backend'])
    ) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
    }

    unset($identifier, $emSettings);
};

$boot();
unset($boot);
