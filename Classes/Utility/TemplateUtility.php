<?php

namespace DWenzel\T3calendar\Utility;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;

/**
 * Class TemplateUtility
 */
class TemplateUtility
{
    const RESOURCES_PATH = 'Resources/';
    const PARTIAL_PATH_SEGMENT = 'Private/Partials';

    /**
     * Handles the path resolving for *rootPath(s)
     * singular one is deprecated and will be removed two versions after 6.2
     * if deprecated setting is found, use it as the very last fallback target
     *
     * numerical arrays get ordered by key ascending
     *
     * @param array $widgetConfiguration
     * @param string $propertyName parameter name from TypoScript
     * @param string $deprecatedKey Deprecated parameter name from TypoScript
     *
     * @return array
     */
    public function getPaths($widgetConfiguration, $propertyName, $deprecatedKey = null)
    {
        $values = [];

        if (
            !empty($widgetConfiguration[$propertyName])
            && is_array($widgetConfiguration[$propertyName])
        ) {
            $values = ArrayUtility::sortArrayWithIntegerKeys($widgetConfiguration[$propertyName]);
            $values = array_reverse($values, true);
        }

        // remove handling of deprecated key two versions after 6.2
        if (
            $deprecatedKey !== null
            && isset($widgetConfiguration[$deprecatedKey])
        ) {
            $values[] = $widgetConfiguration[$deprecatedKey];
        }

        return $values;
    }

    /**
     * Gets the default partial root path for an extension
     *
     * @param string $extensionName
     * @return array An array with root paths
     */
    public function getDefaultPartialRootPaths($extensionName)
    {
        return [ExtensionManagementUtility::extPath($extensionName) . 'Resources/Private/Partials'];
    }

    /**
     * Configures the template paths of a given view
     * by interpreting a given configuration
     *
     * @param ViewInterface $view
     * @param array $configuration Widget view helper configuration from framework
     * @param string $extensionName
     */
    public function configureTemplatePaths(ViewInterface $view, $configuration, $extensionName = 't3calendar')
    {
        $partialRootPaths = $this->getDefaultPartialRootPaths($extensionName);
        $templateRootPaths = [];
        if (method_exists($view, 'getTemplateRootPaths')) {
            $templateRootPaths = $view->getTemplateRootPaths();
        }

        $widgetProperties = [
            'partialRootPaths' => [
                'fallback' => $partialRootPaths,
                'deprecatedKey' => 'partialRootPath'
            ],
            'templateRootPaths' => [
                'fallback' => $templateRootPaths,
                'deprecatedKey' => 'templateRootPath'
            ]
        ];

        foreach ($widgetProperties as $propertyName => $config) {
            $viewFunctionName = 'set' . ucfirst($propertyName);
            if (method_exists($view, $viewFunctionName)) {
                $deprecatedKey = $config['deprecatedKey'];
                $rootPaths = $config['fallback'];

                $additionalPaths = $this->getPaths(
                    $configuration, $propertyName, $deprecatedKey
                );
                if ($additionalPaths) {
                    $rootPaths = $additionalPaths + $rootPaths;
                }
                $view->$viewFunctionName($rootPaths);
            }
        }
    }
}
