<?php
namespace DWenzel\T3calendar\Domain\Factory;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class CalendarFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarFactory implements SingletonInterface, CalendarFactoryInterface
{
    use ObjectManagerTrait, CalendarDayFactoryTrait,
        CalendarWeekFactoryTrait, CalendarMonthFactoryTrait,
        CalendarQuarterFactoryTrait, CalendarYearFactoryTrait;

    /**
     * Creates a Calendar from configuration.
     * Items will be added to matching CalendarDays
     *
     * @param QueryResultInterface|array|\Iterator $items Array holding CalendarItemInterface objects
     * @return Calendar
     */
    public function create(CalendarConfiguration $configuration, $items)
    {

        /** @var Calendar $calendar */
        $calendar = $this->objectManager->get(Calendar::class);
        $viewMode = $configuration->getViewMode();
        $calendar->setViewMode($viewMode);
        $displayPeriod = $configuration->getDisplayPeriod();
        $calendar->setDisplayPeriod($displayPeriod);

        $startDate = $configuration->getStartDate();
        $currentDate = $configuration->getCurrentDate();
        if ($viewMode === CalendarConfiguration::VIEW_MODE_MINI_MONTH) {
            $calendarMonth = $this->calendarMonthFactory->create($startDate, $currentDate, $items);
            $calendar->setCurrentMonth($calendarMonth);
        }

        if ($viewMode == CalendarConfiguration::VIEW_MODE_COMBO_PANE) {
            switch ($displayPeriod) {
                case CalendarConfiguration::PERIOD_DAY:
                    $isCurrent = ($startDate == $currentDate) ? true : false;
                    $calendarDay = $this->calendarDayFactory->create($startDate, $items, $isCurrent);
                    $calendar->setCurrentDay($calendarDay);
                    break;
                case CalendarConfiguration::PERIOD_WEEK:
                    $calendarWeek = $this->calendarWeekFactory->create($startDate, $currentDate, $items);
                    $calendar->setCurrentWeek($calendarWeek);
                    break;
                case CalendarConfiguration::PERIOD_MONTH:
                    $calendarMonth = $this->calendarMonthFactory->create($startDate, $currentDate, $items);
                    $calendar->setCurrentMonth($calendarMonth);
                    break;
                case CalendarConfiguration::PERIOD_YEAR:
                    $calendarYear = $this->calendarYearFactory->create($startDate, $currentDate, $items);
                    $calendar->setCurrentYear($calendarYear);
                    break;
                case CalendarConfiguration::PERIOD_QUARTER:
                    $calendarQuarter = $this->calendarQuarterFactory->create($startDate, $currentDate, $items);
                    $calendar->setCurrentQuarter($calendarQuarter);
                    break;
                default:
            }
        }

        return $calendar;
    }
}
