<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// register caches
foreach (['content'] as $identifier)
{
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3calendar_' . $identifier])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3calendar_' . $identifier] = [];
    }
    // register t3calendar content cache with pages group
    if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['t3calendar_' .$identifier]['groups'])) {
        $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['t3calendar_' . $identifier]['groups'] = array('pages');
    }
}
unset($identifier);

