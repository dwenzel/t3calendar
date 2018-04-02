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

use DateTime;
use DWenzel\T3calendar\Domain\Factory\CalendarDayFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactory;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarWeekFactoryTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarWeekFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarWeekFactory | \PHPUnit_Framework_MockObject_MockObject
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
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarWeekFactory::class, ['dummy']
        );
        /** @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject objectManager */
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)->setMethods(['get'])->getMock();
        $this->subject->injectObjectManager($this->objectManager);
        $this->calendarDayFactory = $this->getMockForAbstractClass(
            CalendarDayFactoryInterface::class
        );
        $this->subject->injectCalendarDayFactory($this->calendarDayFactory);
    }

    /**
     * @test
     */
    public function calenderDayFactoryCanBeInjected()
    {
        /** @var CalendarDayFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $mockFactory */
        $mockFactory = $this->getMockForAbstractClass(CalendarDayFactoryInterface::class);
        $this->subject->injectCalendarDayFactory($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'calendarDayFactory',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        /** @var CalendarWeek|\PHPUnit_Framework_MockObject_MockObject $mockCalendarWeek */
        $mockCalendarWeek = $this->getMockBuilder(CalendarWeek::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarWeek::class)
            ->will($this->returnValue($mockCalendarWeek));
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)->getMock();
        $this->calendarDayFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockCalendarDay));

        $this->assertSame(
            $mockCalendarWeek,
            $this->subject->create($date, $date)
        );
    }

    /**
     * @test
     */
    public function createAddsDays()
    {
        $items = [];
        /** @var DateTime|\PHPUnit_Framework_MockObject_MockObject $mockStartDate */
        $mockStartDate = $this->getMockBuilder(DateTime::class)->setMethods(['add'])->getMock();
        /** @var DateTime|\PHPUnit_Framework_MockObject_MockObject $mockCurrentDate */
        $mockCurrentDate = $this->getMockBuilder(DateTime::class)->getMock();
        /** @var CalendarWeek|\PHPUnit_Framework_MockObject_MockObject $mockCalendarWeek */
        $mockCalendarWeek = $this->getMockBuilder(CalendarWeek::class)->setMethods(['addDay'])->getMock();
        $expectedIntervals = [];
        for ($dayOfWeek = 1; $dayOfWeek < 7; $dayOfWeek++) {
            $expectedIntervals[] = [new \DateInterval('P' . $dayOfWeek . 'D')];
        }
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)->getMock();
        $mockStartDate->expects($this->exactly(6))
            ->method('add')
            ->withConsecutive(
                $expectedIntervals[0],
                $expectedIntervals[1],
                $expectedIntervals[2],
                $expectedIntervals[3],
                $expectedIntervals[4],
                $expectedIntervals[5]
            );

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarWeek::class)
            ->will($this->returnValue($mockCalendarWeek));

        $this->calendarDayFactory->expects($this->exactly(7))
            ->method('create')
            ->with($this->isInstanceOf(DateTime::class), $items)
            ->will($this->returnValue($mockCalendarDay));

        $mockCalendarWeek->expects($this->exactly(7))
            ->method('addDay')
            ->with($mockCalendarDay);

        $this->subject->create($mockStartDate, $mockCurrentDate, $items);
    }
}
