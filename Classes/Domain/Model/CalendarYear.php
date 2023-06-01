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
 * Class CalendarYear
 * @package DWenzel\T3calendar\Domain\Model
 */
class CalendarYear
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
     * Gets the year
     *
     * @param string $format A format as understood by date(). Default 'y'
     */
    public function getYear($format = 'Y'): ?string
    {
        if ($this->startDate !== null) {
            return $this->startDate->format($format);
        }

        return null;
    }
}
