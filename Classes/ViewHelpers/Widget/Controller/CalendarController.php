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

use DWenzel\T3calendar\Domain\Factory\CalendarFactoryTrait;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class CalendarController
 * @package DWenzel\T3calendar\ViewHelpers\Widget\Controller
 */
class CalendarController extends AbstractWidgetController
{
    use CalendarFactoryTrait;

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
     * @return void
     */
    public function initializeAction()
    {
        $this->objects = $this->widgetConfiguration['objects'];
        $this->configuration = $this->widgetConfiguration['configuration'];
        $this->id = $this->widgetConfiguration['id'];
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);

        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
    }

    /**
     * Day action
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    public function dayAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_DAY);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_DAY, $shift, $origin);
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
    }

    /**
     * Week action
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    public function weekAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_WEEK);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_WEEK, $shift, $origin);
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
    }

    /**
     * Month action
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    public function monthAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_MONTH);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_MONTH, $shift, $origin);
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
    }

    /**
     * Quarter action
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    public function quarterAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_QUARTER);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_QUARTER, $shift, $origin);
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
    }

    /**
     * Year action
     * @param string $shift Shift action. Allowed: 'previous' and 'next'.
     * @param int $origin Timestamp indicating the current start date of calendar.
     */
    public function yearAction($shift = null, $origin = null)
    {
        $this->configuration->setDisplayPeriod(CalendarConfiguration::PERIOD_YEAR);
        $this->adjustStartDate(CalendarConfiguration::PERIOD_YEAR, $shift, $origin);
        $calendar = $this->calendarFactory->create($this->configuration, $this->objects);
        $this->view->assignMultiple(
            [
                'configuration' => $this->configuration,
                'calendar' => $calendar,
                'calendarId' => $this->id
            ]
        );
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
}