<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

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

use DWenzel\T3calendar\Domain\Factory\CalendarDayFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactoryInterface;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarMonthFactoryTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarMonthFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarMonthFactory | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * Object manager
     * @var ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * @var CalendarDayFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarDayFactory;

    /**
     * @var CalendarWeekFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarWeekFactory;

    /**
     * @var CacheManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cacheManager;

    /**
     * @var \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $monthCache;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class, ['dummy', 'addWeeks']
        );
        $this->objectManager = $this->getMock(ObjectManager::class, ['get']);
        $this->subject->injectObjectManager($this->objectManager);
        $this->calendarDayFactory = $this->getMockForAbstractClass(
            CalendarDayFactoryInterface::class
        );
        $this->subject->injectCalendarDayFactory($this->calendarDayFactory);
        $this->calendarWeekFactory = $this->getMockForAbstractClass(
            CalendarWeekFactoryInterface::class
        );
        $this->subject->injectCalendarWeekFactory($this->calendarWeekFactory);

        $this->monthCache = $this->getMock(VariableFrontend::class, ['get', 'set'], [], '', false);
        $this->monthCache->expects($this->any())
            ->method('get')
            ->will($this->returnValue(false));
        $this->inject(
            $this->subject,
            'monthCache',
            $this->monthCache
        );
        $this->cacheManager = $this->getMock(CacheManager::class, ['getCache']);
        $this->cacheManager->expects($this->any())
            ->method('getCache')
            ->will($this->returnValue($this->monthCache));
        $this->subject->injectCacheManager($this->cacheManager);
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, []
        );
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));
        $mockCalendarDay = $this->getMock(CalendarDay::class);
        $this->calendarDayFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockCalendarDay));

        $this->assertSame(
            $mockCalendarMonth,
            $this->subject->create($date, $date)
        );
    }

    /**
     * @test
     */
    public function addDaysOfPreviousMonthAddsCorrectNumberOfDays()
    {
        $startDate = new \DateTime('today');
        $daysOfMonth = [];
        $expectedNumberOfDays = (int)$startDate->format('N') - 1;
        $mockCalendarDay = $this->getMock(CalendarDay::class);
        $this->calendarDayFactory->expects($this->exactly($expectedNumberOfDays))
            ->method('create')
            ->will($this->returnValue($mockCalendarDay));
        $this->subject->addDaysOfPreviousMonth($startDate, $daysOfMonth);
        $this->assertSame(
            $expectedNumberOfDays,
            count($daysOfMonth)
        );
    }

    /**
     * @test
     */
    public function addDaysOfCurrentMonthAddsCorrectNumberOfDays()
    {
        $startDate = new \DateTime('2000-01-01');
        $currentDate = new \DateTime('2000-01-05');
        $daysOfMonth = [];
        $expectedNumberOfDays = (int)$startDate->format('t');
        $mockCalendarDay = $this->getMock(CalendarDay::class);
        $this->calendarDayFactory->expects($this->exactly($expectedNumberOfDays))
            ->method('create')
            ->will($this->returnValue($mockCalendarDay));

        $this->subject->addDaysOfCurrentMonth($startDate, $currentDate, $daysOfMonth);
        $this->assertSame(
            $expectedNumberOfDays,
            count($daysOfMonth)
        );
    }

    /**
     * @test
     */
    public function addDaysOfNextMonthAddsCorrectNumberOfDays()
    {
        $startDate = new \DateTime('2000-01-01');
        $daysInMonth = (int)$startDate->format('t');
        $prependDays = (int)$startDate->format('N') - 1;
        $numberOfWeeks = (int)ceil(($daysInMonth + $prependDays) / 7);
        $daysOfMonth = [];
        $expectedNumberOfDays = $numberOfWeeks * 7 - $daysInMonth - $prependDays;

        $this->subject->addDaysOfNextMonth($startDate, $daysOfMonth);
        $this->assertSame(
            $expectedNumberOfDays,
            count($daysOfMonth)
        );
    }

    /**
     * @test
     */
    public function createAddsDaysOfPreviousMonth()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class,
            ['addDaysOfPreviousMonth', 'addDaysOfCurrentMonth', 'addDaysOfNextMonth', 'addWeeks']
        );
        $this->subject->injectObjectManager($this->objectManager);
        $this->inject($this->subject, 'monthCache', $this->monthCache);
        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');
        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, []
        );
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));

        $this->subject->expects($this->once())
            ->method('addDaysOfPreviousMonth')
            ->with($startDate);

        $this->subject->create($startDate, $currentDate);
    }

    /**
     * @test
     */
    public function createAddsDaysOfCurrentMonth()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class,
            ['addDaysOfPreviousMonth', 'addDaysOfCurrentMonth', 'addDaysOfNextMonth', 'addWeeks']
        );
        $this->subject->injectObjectManager($this->objectManager);
        $this->inject($this->subject, 'monthCache', $this->monthCache);
        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');
        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, []
        );
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));

        $this->subject->expects($this->once())
            ->method('addDaysOfCurrentMonth')
            ->with($startDate, $currentDate);

        $this->subject->create($startDate, $startDate);
    }

    /**
     * @test
     */
    public function createAddsDaysOfNextMonth()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class,
            ['addDaysOfPreviousMonth', 'addDaysOfCurrentMonth', 'addDaysOfNextMonth', 'addWeeks']
        );
        $this->subject->injectObjectManager($this->objectManager);
        $this->inject($this->subject, 'monthCache', $this->monthCache);
        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');
        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, []
        );
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));

        $this->subject->expects($this->once())
            ->method('addDaysOfNextMonth')
            ->with($startDate);

        $this->subject->create($startDate, $startDate);
    }

    /**
     * @test
     */
    public function createAddsWeeks()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class, ['getDaysOfMonth']
        );
        $this->subject->injectObjectManager($this->objectManager);
        $this->inject($this->subject, 'monthCache', $this->monthCache);

        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');
        $items = [];

        $daysOfMonth = [];

        $daysInMonth = (int)$startDate->format('t');
        $prependDays = (int)$startDate->format('N') - 1;
        $numberOfWeeks = (int)ceil(($daysInMonth + $prependDays) / 7);
        $numberOfCalendarDays = (int)$numberOfWeeks * 7;

        for ($numberOfDay = 0; $numberOfDay < $numberOfCalendarDays; $numberOfDay++) {
            $daysOfMonth[] = $this->getMock(CalendarDay::class);
        }

        $this->subject->expects($this->once())
            ->method('getDaysOfMonth')
            ->with($startDate, $currentDate, $items)
            ->will($this->returnValue($daysOfMonth));

        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, ['addWeek']
        );
        $mockCalendarWeek = $this->getMock(
            CalendarWeek::class
        );
        $this->objectManager->expects($this->at(0))
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));

        for ($weekNumber = 0; $weekNumber < $numberOfWeeks; $weekNumber++) {
            $this->objectManager->expects($this->at($weekNumber + 1))
                ->method('get')
                ->with(CalendarWeek::class)
                ->will($this->returnValue($mockCalendarWeek));
        }

        $mockCalendarMonth->expects($this->exactly($numberOfWeeks))
            ->method('addWeek')
            ->with($mockCalendarWeek);

        $this->subject->create($startDate, $currentDate, $items);
    }

    /**
     * @test
     */
    public function createSetsStartDate()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarMonthFactory::class,
            ['addDaysOfPreviousMonth', 'addDaysOfCurrentMonth', 'addDaysOfNextMonth', 'addWeeks']
        );
        $this->subject->injectObjectManager($this->objectManager);
        $this->inject($this->subject, 'monthCache', $this->monthCache);

        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');
        $mockCalendarMonth = $this->getMock(
            CalendarMonth::class, ['setStartDate']
        );
        $this->objectManager->expects($this->at(0))
            ->method('get')
            ->with(CalendarMonth::class)
            ->will($this->returnValue($mockCalendarMonth));
        $mockCalendarMonth->expects($this->once())
            ->method('setStartDate')
            ->with($startDate);

        $this->subject->create($startDate, $currentDate);
    }

    /**
     * @test
     */
    public function initializeObjectGetsCalendarCacheFromManager()
    {
        $this->cacheManager->expects($this->once())
            ->method('getCache')
            ->with('t3calendar_month');
        $this->subject->initializeObject();
    }

    /**
     * @test
     */
    public function createAddsObjectToCache()
    {
        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');

        $expectedCacheIdentifier = sha1(serialize($startDate) . serialize($currentDate));
        $mockCalendarMonth = $this->getMock(CalendarMonth::class);

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendarMonth));
        $this->monthCache->expects($this->once())
            ->method('set')
            ->with($expectedCacheIdentifier, $mockCalendarMonth);

        $this->subject->create($startDate, $currentDate);
    }

    /**
     * @test
     */
    public function createReturnsObjectFromCache()
    {
        $startDate = new \DateTime('now');
        $currentDate = new \DateTime('now');

        $expectedCacheIdentifier = sha1(serialize($startDate) . serialize($currentDate));
        $this->monthCache = $this->getMock(VariableFrontend::class, ['get'], [], '', false);
        $this->inject($this->subject, 'monthCache', $this->monthCache);

        $mockCalendarMonth = $this->getMock(CalendarMonth::class);

        $this->objectManager->expects($this->never())->method('get');
        $this->monthCache->expects($this->once())
            ->method('get')
            ->with($expectedCacheIdentifier)
            ->will($this->returnValue($mockCalendarMonth));

        $this->assertSame(
            $mockCalendarMonth,
            $this->subject->create($startDate, $currentDate)
        );
    }
}
