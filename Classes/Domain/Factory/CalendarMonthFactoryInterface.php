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

use DWenzel\T3calendar\Domain\Model\CalendarMonth;

/**
 * Class CalendarMonthFactory
 * @package DWenzel\T3calendar\Domain\Factory
 */
interface CalendarMonthFactoryInterface
{
    /**
     * creates a CalendarMonth object
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array|\Iterator|null $items
     * @return CalendarMonth
     */
    public function create(\DateTime $startDate, \DateTime $currentDate, $items = null);
}