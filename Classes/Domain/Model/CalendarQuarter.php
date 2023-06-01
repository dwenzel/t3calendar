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


/**
 * Class CalendarQuarter
 * @package DWenzel\T3calendar\Domain\Model
 */
class CalendarQuarter
{
    use  MonthTrait, StartDateTrait;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Gets the quarter
     */
    public function getQuarter(): ?int
    {
        if ($this->startDate !== null) {
            return ceil($this->startDate->format('n')/3);
        }

        return null;
    }
}
