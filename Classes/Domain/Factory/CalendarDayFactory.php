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
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarDayFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarDayFactory
{
    /**
     * Object manager
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Creates a calender day
     *
     * @param \DateTime $date Day
     * @param \Iterator|array|null $items Items to add
     * @param bool $current Mark created calendar day as current, default: false
     * @return CalendarDay
     */
    public function create(\DateTime $date, $items = null, $current = false)
    {
        /** @var CalendarDay $calendarDay */
        $calendarDay = $this->objectManager->get(CalendarDay::class, $date);
        if (count($items)) {
            foreach ($items as $item) {
                if (
                    $item instanceof CalendarItemInterface
                    && $item->getDate() == $calendarDay->getDate()
                ) {
                    $calendarDay->addItem($item);
                }
            }
        }

        $calendarDay->setIsCurrent(true);

        return $calendarDay;
    }

    /**
     * Gets the default time zone
     *
     * @return \DateTimeZone
     */
    protected function getDefaultTimeZone()
    {
        return new \DateTimeZone(date_default_timezone_get());
    }

}