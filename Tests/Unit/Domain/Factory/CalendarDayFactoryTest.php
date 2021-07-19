<?php

namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

use DWenzel\T3calendar\Domain\Factory\CalendarDayFactory;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;
use DWenzel\T3calendar\Persistence\CalendarItemStorage;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class DummyItemWithEndDate implements CalendarItemInterface
{
    public function __construct($date)
    {
    }

    public function getDate()
    {
    }

    public function getEndDate()
    {
    }
}

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
class CalendarDayFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarDayFactory | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * Object manager
     * @var ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarDayFactory::class, ['dummy']
        );
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])->getMock();
        $this->subject->injectObjectManager($this->objectManager);
    }

    /**
     * @test
     */
    public function objectManagerCanBeInjected()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarDayFactory::class, ['dummy']
        );

        /** @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject $mockObjectManager */
        $mockObjectManager = $this->getMockBuilder(ObjectManager::class)->disableOriginalConstructor()->getMock();
        $this->subject->injectObjectManager($mockObjectManager);
        $this->assertAttributeSame(
            $mockObjectManager,
            'objectManager',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function createAddsItemsWithMatchingDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setConstructorArgs([$date])
            ->setMethods()
            ->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));
        $mockItemWithMatchingDate = $this->getMockBuilder(CalendarItemInterface::class)
            ->setMethods(['getDate'])
            ->getMockForAbstractClass();
        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));

        $this->subject->create($date, [$mockItemWithMatchingDate]);
    }

    /**
     * @test
     */
    public function createSetsItemsFromCalendarItemStorage()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setConstructorArgs([$date])
            ->setMethods(['addItem'])
            ->getMock();

        $mockCalendarItemStorage = $this->getMockBuilder(CalendarItemStorage::class)
            ->setMethods(['getByDate'])
            ->getMock();

        $mockObjectStorage = $this->getMockBuilder(ObjectStorage::class)
            ->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));

        $mockCalendarDay->expects($this->never())
            ->method('addItem');

        $mockCalendarItemStorage->expects($this->atLeastOnce())
            ->method('getByDate')
            ->with($date)
            ->will($this->returnValue($mockObjectStorage));
        $this->subject->create($date, $mockCalendarItemStorage);

        $this->assertSame(
            $mockObjectStorage,
            $mockCalendarDay->getItems()
        );
    }

    /**
     * @test
     */
    public function createSetsCurrent()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setMethods(['setCurrent'])
            ->setConstructorArgs([$date])
            ->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));
        $mockCalendarDay->expects($this->once())
            ->method('setCurrent')
            ->with(true);

        $this->subject->create($date, null, true);
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setConstructorArgs([$date])
            ->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));

        $this->assertSame(
            $mockCalendarDay,
            $this->subject->create($date)
        );
    }

    /**
     * @test
     */
    public function createAddsItemWithMatchingStartAndEndDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $calendarDayDate = new \DateTime('today', $timeZone);
        $date = new \DateTime('yesterday', $timeZone);
        $endDate = new \DateTime('tomorrow', $timeZone);
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setMethods(['addItem', 'getDate'])
            ->setConstructorArgs([$date])
            ->getMock();
        $mockCalendarDay->expects($this->atLeastOnce())
            ->method('getDate')->willReturn($calendarDayDate);

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $calendarDayDate)
            ->will($this->returnValue($mockCalendarDay));
        /** @var DummyItemWithEndDate|\PHPUnit_Framework_MockObject_MockObject $mockItemWithMatchingDate */
        $mockItemWithMatchingDate = $this->getMockBuilder(DummyItemWithEndDate::class)
            ->setMethods(['getDate', 'getEndDate'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getDate')
            ->willReturn($date);
        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getEndDate')
            ->willReturn($endDate);
        $mockCalendarDay->expects($this->once())
            ->method('addItem')
            ->with($mockItemWithMatchingDate);

        $this->subject->create($calendarDayDate, [$mockItemWithMatchingDate]);
    }

    /**
     * @test
     */
    public function createDoesNotAddItemWithPastEndDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $calendarDayDate = new \DateTime('today', $timeZone);
        $date = new \DateTime('yesterday', $timeZone);
        $endDate = new \DateTime('yesterday', $timeZone);
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setMethods(['addItem', 'getDate'])
            ->setConstructorArgs([$date])
            ->getMock();

        $mockCalendarDay->expects($this->atLeastOnce())
            ->method('getDate')->willReturn($calendarDayDate);

        $this->objectManager->expects($this->once())
            ->method('get')->with(CalendarDay::class, $calendarDayDate)
            ->will($this->returnValue($mockCalendarDay));
        /** @var DummyItemWithEndDate|\PHPUnit_Framework_MockObject_MockObject $mockItemWithMatchingDate */
        $mockItemWithMatchingDate = $this->getMockBuilder(DummyItemWithEndDate::class)
            ->setMethods(['getDate', 'getEndDate'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getDate')->willReturn($date);
        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getEndDate')->willReturn($endDate);
        $mockCalendarDay->expects($this->never())
            ->method('addItem');

        $this->subject->create($calendarDayDate, [$mockItemWithMatchingDate]);
    }

    /**
     * @test
     */
    public function createDoesNotAddItemWithFutureEndDateBeforeStartDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $calendarDayDate = new \DateTime('yesterday', $timeZone);
        $date = new \DateTime('today', $timeZone);
        $endDate = new \DateTime('today', $timeZone);
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)
            ->setMethods(['addItem', 'getDate'])
            ->setConstructorArgs([$date])
            ->getMock();

        $mockCalendarDay->expects($this->atLeastOnce())
            ->method('getDate')->willReturn($calendarDayDate);

        $this->objectManager->expects($this->once())
            ->method('get')->with(CalendarDay::class, $calendarDayDate)
            ->will($this->returnValue($mockCalendarDay));
        /** @var DummyItemWithEndDate|\PHPUnit_Framework_MockObject_MockObject $mockItemWithMatchingDate */
        $mockItemWithMatchingDate = $this->getMockBuilder(DummyItemWithEndDate::class)
            ->setMethods(['getDate', 'getEndDate'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getDate')->willReturn($date);
        $mockItemWithMatchingDate->expects($this->any())
            ->method('getEndDate')->willReturn($endDate);
        $mockCalendarDay->expects($this->never())
            ->method('addItem');

        $this->subject->create($calendarDayDate, [$mockItemWithMatchingDate]);
    }
}
