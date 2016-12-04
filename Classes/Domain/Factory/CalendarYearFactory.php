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
use DWenzel\T3calendar\Domain\Model\CalendarYear;

/**
 * Class CalendarYearFactory
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarYearFactory implements CalendarYearFactoryInterface, SingletonInterface
{
    use ObjectManagerTrait, CalendarMonthFactoryTrait;

    /**
     * creates a CalendarYear object
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array|\Iterator|null $items
     * @return CalendarYear
     */
    public function create(\DateTime $startDate, \DateTime $currentDate, $items = null)
    {
        /** @var CalendarYear $calendarYear */
        $calendarYear = $this->objectManager->get(CalendarYear::class);
        $calendarYear->setStartDate($startDate);

        for ($monthOfYear = 0; $monthOfYear < 12; $monthOfYear++) {
            $startDateOfMonth = clone $startDate;

            if ($monthOfYear > 0) {
                $interval = new \DateInterval('P' . $monthOfYear . 'M');
                $startDateOfMonth->add($interval);
            }

            $currentMonth = $this->calendarMonthFactory->create($startDateOfMonth, $currentDate, $items);
            $calendarYear->addMonth($currentMonth);
        }

        return $calendarYear;
    }

}