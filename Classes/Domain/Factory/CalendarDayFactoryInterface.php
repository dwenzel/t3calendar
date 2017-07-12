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

use DWenzel\T3calendar\Domain\Model\CalendarDay;

/**
 * Class CalendarDayFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
interface CalendarDayFactoryInterface
{
    /**
     * Creates a calender day
     *
     * @param \DateTime $date Day
     * @param \Iterator|array|null $items Items to add
     * @param bool $current Mark created calendar day as current, default: false
     * @return CalendarDay
     */
    public function create(\DateTime $date, $items = null, $current = false);
}
