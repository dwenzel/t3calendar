<?php

namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarYearFactory;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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
 * Class CalendarYearFactoryTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarYearFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarYearFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * Object manager
     * @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * @var CalendarMonthFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarMonthFactory;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(CalendarYearFactory::class)
            ->setMethods(['dummy'])->getMock();
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)->setMethods(['get'])->getMock();
        $this->subject->injectObjectManager($this->objectManager);
        $this->calendarMonthFactory = $this->getMockBuilder(CalendarMonthFactory::class)
            ->setMethods(['create'])
            ->getMock();
        /** @var CalendarMonth|\PHPUnit_Framework_MockObject_MockObject $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->calendarMonthFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));
        $this->subject->injectCalendarMonthFactory($this->calendarMonthFactory);
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();
        /** @var CalendarYear|\PHPUnit_Framework_MockObject_MockObject $mockCalendarYear */
        $mockCalendarYear = $this->getMockBuilder(CalendarYear::class)->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarYear::class)
            ->will($this->returnValue($mockCalendarYear));

        $this->assertSame(
            $mockCalendarYear,
            $this->subject->create($startDate, $currentDate)
        );
    }

    /**
     * @test
     */
    public function createSetsStartDate()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();
        /** @var CalendarYear|\PHPUnit_Framework_MockObject_MockObject $mockCalendarYear */
        $mockCalendarYear = $this->getMockBuilder(CalendarYear::class)
            ->setMethods(['setStartDate'])->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendarYear));
        $mockCalendarYear->expects($this->once())
            ->method('setStartDate')
            ->with($startDate);

        $this->subject->create($startDate, $currentDate);
    }

    /**
     * @test
     */
    public function createAddsCalendarMonths()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();
        /** @var CalendarYear|\PHPUnit_Framework_MockObject_MockObject $mockCalendarYear */
        $mockCalendarYear = $this->getMockBuilder(CalendarYear::class)->setMethods(['addMonth'])->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendarYear));

        /** @var CalendarMonth $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->calendarMonthFactory->expects($this->exactly(12))
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));
        $mockCalendarYear->expects($this->exactly(12))
            ->method('addMonth')
            ->with($mockCalendarMonth);

        $this->subject->create($startDate, $currentDate);
    }
}
