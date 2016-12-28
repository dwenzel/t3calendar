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

use DWenzel\T3calendar\Cache\CacheManagerTrait;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class CalendarWeek
 * @package DWenzel\T3calendar\Domain\Factory
 */
class CalendarWeekFactory implements CalendarWeekFactoryInterface, SingletonInterface
{
    use CacheManagerTrait, ObjectManagerTrait, CalendarDayFactoryTrait;

    /**
     * @var \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend
     */
    protected $weekCache;

    /**
     * Lifecycle method
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->weekCache = $this->cacheManager->getCache('t3calendar_week');
    }

    /**
     * creates a CalendarWeek object
     *
     * @param \DateTime $startDate
     * @param \DateTime $currentDate
     * @param array|\Iterator|null $items
     * @return CalendarWeek
     */
    public function create(\DateTime $startDate, \DateTime $currentDate, $items = null)
    {
        $cacheIdentifier = sha1(serialize($startDate) . serialize($currentDate));
        $calendarWeek = $this->weekCache->get($cacheIdentifier);

        if ($calendarWeek === false) {
            /** @var CalendarWeek $calendarWeek */
            $calendarWeek = $this->objectManager->get(CalendarWeek::class);

            for ($weekDay = 0; $weekDay < 7; $weekDay++) {
                $dateOfDay = clone $startDate;
                if ($weekDay > 0) {
                    $interval = new \DateInterval('P' . $weekDay . 'D');
                    $dateOfDay->add($interval);
                }
                $current = ($currentDate == $dateOfDay) ? true : false;

                $day = $this->calendarDayFactory->create(
                    $dateOfDay,
                    $items,
                    $current
                );
                $calendarWeek->addDay($day);
            }

            $this->weekCache->set($cacheIdentifier, $calendarWeek);
        }

        return $calendarWeek;
    }
}

