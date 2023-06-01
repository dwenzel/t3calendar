<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function () {

    $TYPO3_CONF_VARS = [];
    $emSettings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    )->get('t3calendar');

    // caching
    $identifier = 't3calendar_content';
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$identifier] = [];
    }

    // register t3calendar content cache with pages group
    if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$identifier]['groups'])) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$identifier]['groups'] = ['pages', 'all'];
    }

    // disable cache
    if (
        !(bool)$emSettings['enableWidgetCache']
        && !isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$identifier]['backend'])
    ) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$identifier]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
    }

    unset($identifier, $emSettings);
};

$boot();
unset($boot);
