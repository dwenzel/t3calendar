<?php
namespace DWenzel\T3calendar\Domain\Factory;

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

use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use TYPO3\CMS\Core\SingletonInterface;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;

/**
 * Class CalendarMonthFactory
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarMonthFactory implements CalendarMonthFactoryInterface, SingletonInterface
{
    use ObjectManagerTrait, CalendarDayFactoryTrait, CalendarWeekFactoryTrait;

    /**
     * creates a CalendarMonth object
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array|\Iterator|null $items
     * @return CalendarMonth
     */
    public function create(\DateTime $startDate, \DateTime $currentDate, $items = null)
    {
        $calendarMonth = $this->objectManager->get(CalendarMonth::class);
        $daysOfMonth = $this->getDaysOfMonth($startDate, $currentDate, $items);
        $this->addWeeks($startDate, $calendarMonth, $daysOfMonth);

        return $calendarMonth;
    }

    /**
     * Appends the calendar days of the previous month
     * to the daysOfMonth array
     *
     * @param \DateTime $startDate
     * @param array $daysOfMonth
     */
    public function addDaysOfPreviousMonth(\DateTime $startDate, array &$daysOfMonth)
    {
        $prependDays = (int)$startDate->format('N') - 1;
        for ($i = $prependDays; $i > 0; $i--) {
            $timestamp = $startDate->getTimestamp() - ($i * 86400);
            $dateOfDay = new \DateTime('@' . $timestamp);
            $daysOfMonth[] = $this->calendarDayFactory->create($dateOfDay);
        }
    }

    /**
     * Appends the last calendar days of current month to the
     * daysOfMonth array. Current month and number of
     * days in month are determined by startDate.
     * CalendarItemInterface objects will be added to the matching
     * CalendarDay
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array $daysOfMonth An array holding the days of month.
     * @param array $items An array of CalendarItemInterface objects
     */
    public function addDaysOfCurrentMonth(\DateTime $startDate, \DateTime $currentDate, array  &$daysOfMonth, $items = [])
    {
        $daysInMonth = (int)$startDate->format('t');
        $month = (int)$startDate->format('n');
        $year = (int)$startDate->format('Y');

        for ($dayOfMonth = 1; $dayOfMonth <= $daysInMonth; $dayOfMonth++) {
            $timestamp = mktime(0, 0, 0, $month, $dayOfMonth, $year);
            $isCurrent = ($currentDate->getTimestamp() === $timestamp) ? true : false;
            $dateOfDay = new \DateTime('@' . $timestamp);
            $daysOfMonth[] = $this->calendarDayFactory->create($dateOfDay, $items, $isCurrent);
        }
    }

    /**
     * Appends the first calendar days of next month to the
     * daysOfMonth array. Current month and number of
     * days in month are determined by startDate.
     *
     * @param \DateTime $startDate
     * @param array $daysOfMonth
     */
    public function addDaysOfNextMonth(\DateTime $startDate, array &$daysOfMonth)
    {
        $daysInMonth = (int)$startDate->format('t');
        $year = (int)$startDate->format('Y');
        $prependDays = (int)$startDate->format('N') - 1;
        $numberOfWeeks = (int)ceil(($daysInMonth + $prependDays) / 7);
        $numberOfDaysOfNextMonth = $numberOfWeeks * 7 - $daysInMonth - $prependDays;
        $month = (int)$startDate->format('n');
        $nextMonth = ($month == 12) ? 1 : $month + 1;

        for ($appendDay = 1; $appendDay <= $numberOfDaysOfNextMonth; $appendDay++) {
            $timestamp = mktime(0, 0, 0, $nextMonth, $appendDay, ($nextMonth == 1) ? $year++ : $year);
            $dateOfDay = new \DateTime('@' . $timestamp);
            $daysOfMonth[] = $this->calendarDayFactory->create($dateOfDay);
        }
    }

    /**
     * Gets the days of month
     * The days of this month will be padded by
     * the last few days of previous month and
     * the first few days of next month in order to
     * get a total number of days divisible by seven.
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param $items
     * @return array An array of CalendarDays
     */
    protected function getDaysOfMonth(\DateTime $startDate, \DateTime $currentDate, $items)
    {
        $daysOfMonth = [];
        $this->addDaysOfPreviousMonth($startDate, $daysOfMonth);
        $this->addDaysOfCurrentMonth($startDate, $currentDate, $daysOfMonth, $items);
        $this->addDaysOfNextMonth($startDate, $daysOfMonth);

        return $daysOfMonth;
    }

    /**
     * Spreads the CalendareDay objects hold by
     * $daysOfMonth evenly over a number of weeks
     * @param \DateTime $startDate
     * @param CalendarMonth $calendarMonth
     * @param array $daysOfMonth
     */
    protected function addWeeks(\DateTime $startDate, CalendarMonth $calendarMonth, array $daysOfMonth)
    {
        $daysInMonth = (int)$startDate->format('t');
        $prependDays = (int)$startDate->format('N') - 1;
        $numberOfWeeks = (int)ceil(($daysInMonth + $prependDays) / 7);

        for ($weekNumber = 0; $weekNumber < $numberOfWeeks; $weekNumber++) {
            /** @var CalendarWeek $week */
            $week = $this->objectManager->get(CalendarWeek::class);
            for ($weekDay = 0; $weekDay < 7; $weekDay++) {
                $week->addDay(array_shift($daysOfMonth));
            }
            $calendarMonth->addWeek($week);
        }
    }
}