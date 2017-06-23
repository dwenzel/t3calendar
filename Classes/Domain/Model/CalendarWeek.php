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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalendarWeek
 * @package DWenzel\T3calendar\Domain\Model
 */
class CalendarWeek
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3calendar\Domain\Model\CalendarDay>
     */
    protected $days;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * You may modify the constructor of this class instead
         */
        $this->days = new ObjectStorage();
    }

    /**
     * Gets the days
     *
     * @return ObjectStorage
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Sets the Days
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3calendar\Domain\Model\CalendarDay> $days
     */
    public function setDays(ObjectStorage $days)
    {
        $this->days = $days;
    }

    /**
     * Adds a day
     *
     * @param CalendarDay $day
     */
    public function addDay(CalendarDay $day)
    {
        $this->days->attach($day);
    }

    /**
     * Removes a day
     *
     * @param CalendarDay $day
     */
    public function removeDay(CalendarDay $day)
    {
        $this->days->detach($day);
    }
}
