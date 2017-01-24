<?php
namespace DWenzel\T3calendar\ViewHelpers\Widget\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DWenzel\T3calendar\Cache\CacheManagerTrait;
use DWenzel\T3calendar\Domain\Factory\CalendarFactoryTrait;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class CalendarController
 * @package DWenzel\T3calendar\ViewHelpers\Widget\Controller
 */
class CalendarController extends AbstractWidgetController
{
    use CacheManagerTrait, CalendarFactoryTrait;

    /**
     * @var CalendarConfiguration
     */
    protected $configuration;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array|\Iterator
     */
    protected $objects;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend
     */
    protected $contentCache;

    /**
     * @return void
     */
    public function initializeAction()
    {
        $this->objects = $this->widgetConfiguration['objects'];
        $this->configuration = $this->widgetConfiguration['configuration'];
        $this->id = $this->widgetConfiguration['id'];
    }

    /**
     * Lifecycle method
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->contentCache = $this->cacheManager->getCache('t3calendar_content');
    }


    /**
     * index action
     */
    public function indexAction()
    {
        return $this->getContent();
    }

    /**
     * Day action
     *
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     * @return mixed|string
     */
    public function dayAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_DAY);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_DAY, $shift, $origin);

        return $this->getContent();
    }

    /**
     * Week action
     *
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     * @return mixed|string
     */
    public function weekAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_WEEK);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_WEEK, $shift, $origin);

        return $this->getContent();
    }

    /**
     * Month action
     *
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     * @return mixed|string
     */
    public function monthAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_MONTH);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_MONTH, $shift, $origin);

        return $this->getContent();
    }

    /**
     * Quarter action
     *
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     * @return mixed|string
     */
    public function quarterAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_QUARTER);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_QUARTER, $shift, $origin);

        return $this->getContent();
    }

    /**
     * Year action
     *
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     * @return mixed|string
     */
    public function yearAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_YEAR);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_YEAR, $shift, $origin);

        return $this->getContent();
    }

    /**
     * Determines the startDate depending on the display period
     *
     * @param int $period Display period: one of CalendarConfiguration::PERIOD_ constants
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    protected function adjustStartDate($period, $shift = null, $origin = null)
    {
        /** @var \DateTimeZone $timeZone */
        $timeZone = new \DateTimeZone(date_default_timezone_get());

        if (null === $origin) {
            $origin = $this->configuration->getStartDate()->getTimestamp();
        }

        if (null !== $origin) {
            $initialStartDate = new \DateTime('@' . $origin);
            $initialStartDate->setTimezone($timeZone);
            $this->configuration->setStartDate($initialStartDate);
        }

        if (null !== $shift) {
            $interval = $this->getInterval($shift);
        }

        if ($interval === false || empty($shift)) {
            switch ($period) {
                case CalendarConfiguration::PERIOD_WEEK:
                    $dateString = 'monday this week';
                    break;
                case CalendarConfiguration::PERIOD_MONTH:
                    $dateString = 'first day of this month 00:00:00';
                    break;
                case CalendarConfiguration::PERIOD_QUARTER:
                    $dateString = date(sprintf('Y-%s-01', floor((date('n') - 1) / 3) * 3 + 1));
                    break;
                case CalendarConfiguration::PERIOD_YEAR:
                    $dateString = date('Y') . '-01-01';
                    break;
                default:
                    $dateString = 'today';
            }

            $startDate = new \DateTime($dateString, $timeZone);
        }

        if ($interval instanceof \DateInterval) {
            $startDate = new \DateTime('@' . $origin);
            $startDate->setTimezone($timeZone);
            $startDate->add($interval);
        }

        $this->configuration->setStartDate($startDate);
    }

    /**
     * @param $shift
     * @return bool|\DateInterval
     */
    protected function getInterval($shift)
    {
        if (!($shift === 'next' OR $shift === 'previous')) {
            return false;
        }
        switch ($this->configuration->getDisplayPeriod()) {
            case CalendarConfiguration::PERIOD_DAY:
                $intervalString = 'P1D';
                break;
            case CalendarConfiguration::PERIOD_WEEK:
                $intervalString = 'P1W';
                break;
            case CalendarConfiguration::PERIOD_MONTH:
                $intervalString = 'P1M';
                break;
            case CalendarConfiguration::PERIOD_QUARTER:
                $intervalString = 'P3M';
                break;
            case CalendarConfiguration::PERIOD_YEAR:
                $intervalString = 'P1Y';
                break;
            default:
                $intervalString = '';
        }
        if ($intervalString === '') {
            return false;
        }

        $interval = new \DateInterval($intervalString);
        if ($shift === 'previous') {
            $interval->invert = 1;
        }

        return $interval;
    }

    /**
     * @return mixed|string
     */
    protected function getContent()
    {
        $identifier = sha1(serialize($this->configuration));
        $content = $this->contentCache->get($identifier);
        if ($content === false) {
            $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
            $this->view->assignMultiple(
                [
                    'configuration' => $this->configuration,
                    'calendar' => $calendar,
                    'calendarId' => $this->id
                ]
            );

            $content = $this->view->render();
            $this->contentCache->set($identifier, $content);
        }

        return $content;
    }

    /**
     * Prevent from overriding template path in parent method
     * @see initializeView
     *
     * @param ViewInterface $view
     * @return void
     */
    protected function setViewConfiguration(ViewInterface $view)
    {
    }

    /**
     * Allows the widget template and partial root paths to be overridden via the framework configuration,
     * e.g. plugin.tx_extension.view.widget.<WidgetViewHelperClassName>.templateRootPaths
     * Note: we use the new syntax (plural: *Paths) here and allow the old (*Path) too
     *
     * @param ViewInterface $view
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        $templateRootPaths = [];
        if (method_exists($view, 'getTemplateRootPaths')) {
            $templateRootPaths = $view->getTemplateRootPaths();
        }

        $frameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $widgetViewHelperClassName = $this->request->getWidgetContext()->getWidgetViewHelperClassName();

        if (isset($frameworkConfiguration['view']['widget'][$widgetViewHelperClassName])) {
            $widgetViewHelperConfiguration = $frameworkConfiguration['view']['widget'][$widgetViewHelperClassName];

            $widgetProperties = [
                'partialRootPaths' => [
                    'fallback' => $this->getDefaultPartialRootPaths(),
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

                    $additionalPaths = $this->getWidgetViewProperty($widgetViewHelperConfiguration, $propertyName, $deprecatedKey);
                    if ($additionalPaths) {
                        $rootPaths = $additionalPaths + $rootPaths;
                    }
                    $view->$viewFunctionName($rootPaths);
                }
            }
        }
    }

    /**
     * Handles the path resolving for *rootPath(s)
     * singular one is deprecated and will be removed two versions after 6.2
     * if deprecated setting is found, use it as the very last fallback target
     *
     * numerical arrays get ordered by key ascending
     *
     * @param array $widgetConfiguration
     * @param string $setting parameter name from TypoScript
     * @param string $deprecatedSetting parameter name from TypoScript
     *
     * @return array
     */
    protected function getWidgetViewProperty($widgetConfiguration, $setting, $deprecatedSetting = '')
    {

        $values = [];

        if (
            !empty($widgetConfiguration[$setting])
            && is_array($widgetConfiguration[$setting])
        ) {
            $values = ArrayUtility::sortArrayWithIntegerKeys($widgetConfiguration[$setting]);
            $values = array_reverse($values, true);
        }

        // @todo remove handling of deprecatedSetting two versions after 6.2
        if (
            isset($widgetConfiguration[$deprecatedSetting])
            && strlen($widgetConfiguration[$deprecatedSetting]) > 0
        ) {
            $values[] = $widgetConfiguration[$deprecatedSetting];
        }

        return $values;
    }

    /**
     * Get the partial root paths (for this extension)
     * @return array
     */
    protected function getDefaultPartialRootPaths()
    {
        return array(ExtensionManagementUtility::extPath($this->request->getControllerExtensionKey()) . 'Resources/Private/Partials');
    }
}
