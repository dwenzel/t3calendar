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

use TYPO3\CMS\Core\SingletonInterface;
use DWenzel\T3calendar\Domain\Model\CalendarQuarter;

/**
 * Class CalendarQuarterFactory
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarQuarterFactory implements CalendarQuarterFactoryInterface, SingletonInterface
{
    use ObjectManagerTrait, CalendarMonthFactoryTrait;

    /**
     * creates a CalendarQuarter object
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array|\Iterator|null $items
     * @return CalendarQuarter
     */
    public function create(\DateTime $startDate, \DateTime $currentDate, $items = null)
    {
        /** @var CalendarQuarter $calendarQuarter */
        $calendarQuarter = $this->objectManager->get(CalendarQuarter::class);
        $calendarQuarter->setStartDate($startDate);

        for ($monthOfQuarter = 0; $monthOfQuarter < 3; $monthOfQuarter++) {
            $startDateOfMonth = clone $startDate;

            if ($monthOfQuarter > 0) {
                $interval = new \DateInterval('P' . $monthOfQuarter . 'M');
                $startDateOfMonth->add($interval);
            }

            $currentMonth = $this->calendarMonthFactory->create($startDateOfMonth, $currentDate, $items);
            $calendarQuarter->addMonth($currentMonth);
        }

        return $calendarQuarter;
    }

}
