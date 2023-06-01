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

/**
 * Class CalendarMonthFactoryTrait
 * Provides a CalendarMonthFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
trait CalendarMonthFactoryTrait
{
    /**
     * @var CalendarMonthFactoryInterface
     */
    protected $calendarMonthFactory;

    /**
     * injects a calendar month factory
     */
    public function injectCalendarMonthFactory(CalendarMonthFactoryInterface $calendarMonthFactory)
    {
        $this->calendarMonthFactory = $calendarMonthFactory;
    }
}
