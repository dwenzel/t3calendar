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
}
unset($identifier);
