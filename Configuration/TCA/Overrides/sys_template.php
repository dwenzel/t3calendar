<?php

$emSettings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
)->get('t3calendar');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('t3calendar', 'Configuration/TypoScript', 'Calendar');

// assets
if (!empty($settings['includeJQuery'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3calendar/Resources/Private/TypoScript/jQuery.typoScript">');
}
if (!empty($settings['includeJavaScript'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:t3calendar/Resources/Private/TypoScript/javaScript.typoScript">');
}
