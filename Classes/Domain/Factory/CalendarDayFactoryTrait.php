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
 * Class CalendarDayFactoryTrait
 * Provides a CalendarDayFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
trait CalendarDayFactoryTrait
{
    /**
     * @var CalendarDayFactoryInterface
     */
    protected $calendarDayFactory;

    /**
     * injects a calendar day factory
     * @param CalendarDayFactoryInterface $calendarDayFactory
     */
    public function injectCalendarDayFactory(CalendarDayFactoryInterface $calendarDayFactory)
    {
        $this->calendarDayFactory = $calendarDayFactory;
    }
}
