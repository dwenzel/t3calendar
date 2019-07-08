<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function () {

    $emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3calendar']);

    // assets
    if (!empty($settings['includeJQuery'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3calendar/Resources/Private/TypoScript/jQuery.typoScript">');
    }
    if (!empty($settings['includeJavaScript'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3calendar/Resources/Private/TypoScript/javaScript.typoScript">');
    }


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
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$identifier]['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\NullBackend';
    }

    unset($identifier, $emSettings);
};

$boot();
unset($boot);
