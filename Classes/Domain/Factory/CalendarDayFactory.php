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
use DWenzel\T3calendar\Persistence\CalendarItemStorage;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class CalendarDayFactory
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarDayFactory implements CalendarDayFactoryInterface, SingletonInterface
{
    use ObjectManagerTrait;

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
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $calendarDay = $this->objectManager->get(CalendarDay::class, $date);

        if ($items instanceof CalendarItemStorage)
        {
            $calendarDay->setItems($items->getByDate($date));
        } elseif (count($items)) {
            foreach ($items as $item) {
                if ($this->shouldAddItem($item, $calendarDay)) {
                    $calendarDay->addItem($item);
                }
            }
        }

        $calendarDay->setIsCurrent($current);

        return $calendarDay;
    }

    /**
     * @param object | array $item
     * @param CalendarDay $calendarDay
     * @return bool
     */
    protected function shouldAddItem($item, $calendarDay)
    {
        $calendarDayDate = $calendarDay->getDate();
        if ($item instanceof CalendarItemInterface
            && $item->getDate() == $calendarDayDate
        ) {
            return true;
        }
        if ($item instanceof CalendarItemInterface
            && $item->getDate() <= $calendarDayDate
            && method_exists($item, 'getEndDate')
            && $item->getEndDate() >= $calendarDayDate
        ) {
            return true;
        }

        return false;
    }
}
