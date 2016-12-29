<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// register caches
foreach (['calendar', 'year', 'quarter', 'month', 'week'] as $period)
{
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3calendar_' . $period])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3calendar_' . $period] = [];
    }
}
