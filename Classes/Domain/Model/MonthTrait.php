<?php

namespace DWenzel\T3calendar\Domain\Model;

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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Trait MonthTrait
 */
trait MonthTrait
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3calendar\Domain\Model\CalendarMonth>
     */
    protected $months;

    /**
     * Gets the months
     *
     * @return ObjectStorage
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * Sets the months
     */
    public function setMonths(ObjectStorage $months)
    {
        $this->months = $months;
    }

    /**
     * Adds a month
     */
    public function addMonth(CalendarMonth $month)
    {
        $this->months->attach($month);
    }

    /**
     * Removes a month
     */
    public function removeMonth(CalendarMonth $month)
    {
        $this->months->detach($month);
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->months = new ObjectStorage();
    }
}
