<?php
namespace DWenzel\T3calendar\Domain\Model;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;

/**
 * Class Calendar
 * @package DWenzel\T3calendar\Domain\Model
 */
class Calendar
{

    /**
     * @var CalendarMonth
     */
    protected $currentMonth;

    /**
     * @var CalendarDay
     */
    protected $currentDay;

    /**
     * @var CalendarWeek
     */
    protected $currentWeek;

    /**
     * @var CalendarQuarter
     */
    protected $currentQuarter;

    /**
     * @var CalendarYear
     */
    protected $currentYear;

    /**
     * View Mode
     *
     * @var int
     */
    protected $viewMode;

    /**
     * Display Period
     *
     * @var int
     */
    protected $displayPeriod;

    /**
     * Gets the current month
     *
     * @return CalendarMonth
     */
    public function getCurrentMonth()
    {
        return $this->currentMonth;
    }

    /**
     * Sets the current month
     */
    public function setCurrentMonth(CalendarMonth $calendarMonth)
    {
        $this->currentMonth = $calendarMonth;
    }

    /**
     * Gets the current week
     *
     * @return CalendarWeek
     */
    public function getCurrentWeek()
    {
        return $this->currentWeek;
    }

    /**
     * Sets the current week
     */
    public function setCurrentWeek(CalendarWeek $calendarWeek)
    {
        $this->currentWeek = $calendarWeek;
    }

    /**
     * Gets the current quarter
     *
     * @return CalendarQuarter
     */
    public function getCurrentQuarter()
    {
        return $this->currentQuarter;
    }

    /**
     * Sets the current quarter
     */
    public function setCurrentQuarter(CalendarQuarter $currentQuarter)
    {
        $this->currentQuarter = $currentQuarter;
    }

    /**
     * Gets the current day
     *
     * @return CalendarDay
     */
    public function getCurrentDay()
    {
        return $this->currentDay;
    }

    /**
     * Sets the current day
     */
    public function setCurrentDay(CalendarDay $calendarDay)
    {
        $this->currentDay = $calendarDay;
    }

    /**
     * Gets the current year
     *
     * @return CalendarYear
     */
    public function getCurrentYear()
    {
        return $this->currentYear;
    }

    /**
     * Sets the current year
     */
    public function setCurrentYear(CalendarYear $calendarYear)
    {
        $this->currentYear = $calendarYear;
    }

    /**
     * Gets the view mode
     *
     * @return int
     */
    public function getViewMode()
    {
        return $this->viewMode;
    }

    /**
     * Sets the view mode
     *
     * @param int $viewMode
     */
    public function setViewMode($viewMode)
    {
        $this->viewMode = $viewMode;
    }

    /**
     * Gets the display period
     *
     * @return int
     */
    public function getDisplayPeriod()
    {
        return $this->displayPeriod;
    }

    /**
     * Sets the display period
     *
     * @param int $displayPeriod
     */
    public function setDisplayPeriod($displayPeriod)
    {
        $this->displayPeriod = $displayPeriod;
    }

    /**
     * Gets an array of week day labels according to current locale
     *
     * @return array
     */
    public function getWeekDayLabels()
    {
        $weekDays = [];
        $monthFormat = match ($this->getViewMode()) {
            CalendarConfiguration::VIEW_MODE_MINI_MONTH => '%a',
            default => '%A',
        };

        for ($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++) {
            $weekDays[] = strftime($monthFormat, strtotime('next Monday +' . $dayOfWeek . ' days'));
        }

        return $weekDays;
    }

    /**
     * Gets an array of localized month names
     *
     * @return array
     */
    public function getMonthLabels()
    {
        $monthNames = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthNames[] = date('F', mktime(0, 0, 0, $month));
        }

        return $monthNames;
    }
}
