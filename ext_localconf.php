<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

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
