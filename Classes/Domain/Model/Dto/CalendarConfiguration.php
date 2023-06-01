<?php

namespace DWenzel\T3calendar\Domain\Model\Dto;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class CalendarConfiguration
 * @package DWenzel\T3calendar\Domain\Model\Dto
 */
class CalendarConfiguration
{
    final public const PERIOD_DAY = 0;
    final public const PERIOD_WEEK = 1;
    final public const PERIOD_MONTH = 2;
    final public const PERIOD_QUARTER = 3;
    final public const PERIOD_SEMESTER = 5;
    final public const PERIOD_YEAR = 6;
    final public const VIEW_MODE_COMBO_PANE = 1;
    final public const VIEW_MODE_MINI_MONTH = 2;

    /**
     * Start date
     *
     * @var \DateTime
     */
    protected $startDate;

    /**
     * Selected date and time
     *
     * @var \DateTime
     */
    protected $currentDate;

    /**
     * Display period
     * see constants PERIOD for available options
     *
     * @var integer
     */
    protected $displayPeriod;

    /**
     * View mode
     * See constants VIEW_MODE for available options
     *
     * @var integer
     */
    protected $viewMode;

    /**
     * @var bool
     */
    protected $ajaxEnabled = false;

    /**
     * @var bool
     */
    protected $showNavigation = false;

    /**
     * Gets the start date
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the start date
     *
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Gets the current date
     *
     * @return \DateTime
     */
    public function getCurrentDate()
    {
        return $this->currentDate;
    }

    /**
     * Sets the current date
     *
     * @param \DateTime $currentDate
     */
    public function setCurrentDate($currentDate)
    {
        $this->currentDate = $currentDate;
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
     * @param $viewMode
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

    public function getAjaxEnabled()
    {
        return $this->ajaxEnabled;
    }

    /**
     * Sets the ajax enabled state
     *
     * @param bool $enabled
     */
    public function setAjaxEnabled($enabled)
    {
        $this->ajaxEnabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function isShowNavigation()
    {
        return $this->showNavigation;
    }

    /**
     * @param boolean $showNavigation
     */
    public function setShowNavigation($showNavigation)
    {
        $this->showNavigation = $showNavigation;
    }
}
