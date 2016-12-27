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
 * Class CalendarQuarterFactoryTrait
 * Provides a CalendarQuarterFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
trait CalendarQuarterFactoryTrait
{
    /**
     * @var CalendarQuarterFactoryInterface
     */
    protected $calendarQuarterFactory;

    /**
     * injects a calendar quarter factory
     * @param CalendarQuarterFactoryInterface $calendarQuarterFactory
     */
    public function injectCalendarQuarterFactory(CalendarQuarterFactoryInterface $calendarQuarterFactory)
    {
        $this->calendarQuarterFactory = $calendarQuarterFactory;
    }
}
