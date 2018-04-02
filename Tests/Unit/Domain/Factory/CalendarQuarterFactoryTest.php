<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactory;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarQuarter;
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
 * Class CalendarQuarterFactoryTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarQuarterFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarQuarterFactory|\PHPUnit_Framework_MockObject_MockObject
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
        $this->subject = $this->getMockBuilder(CalendarQuarterFactory::class)
            ->setMethods(['dummy'])->getMock();
        /** @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject objectManager */
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)
            ->setMethods(['get'])->getMock();
        $this->subject->injectObjectManager($this->objectManager);

        /** @var CalendarMonthFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarMonthFactory */
        $this->calendarMonthFactory = $this->getMockBuilder(CalendarMonthFactory::class)
            ->setMethods(['create'])->getMock();
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
        /** @var CalendarQuarter|\PHPUnit_Framework_MockObject_MockObject $mockCalendarQuarter */
        $mockCalendarQuarter = $this->getMockBuilder(CalendarQuarter::class)->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarQuarter::class)
            ->will($this->returnValue($mockCalendarQuarter));

        $this->assertSame(
            $mockCalendarQuarter,
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
        /** @var CalendarQuarter|\PHPUnit_Framework_MockObject_MockObject $mockCalendarQuarter */
        $mockCalendarQuarter = $this->getMockBuilder(CalendarQuarter::class)
            ->setMethods(['setStartDate'])->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendarQuarter));
        $mockCalendarQuarter->expects($this->once())
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
        /** @var CalendarQuarter|\PHPUnit_Framework_MockObject_MockObject $mockCalendarQuarter */
        $mockCalendarQuarter = $this->getMockBuilder(CalendarQuarter::class)
            ->setMethods(['addMonth'])->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendarQuarter));

        /** @var CalendarMonth|\PHPUnit_Framework_MockObject_MockObject $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->calendarMonthFactory->expects($this->exactly(3))
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));
        $mockCalendarQuarter->expects($this->exactly(3))
            ->method('addMonth')
            ->with($mockCalendarMonth);

        $this->subject->create($startDate, $currentDate);
    }
}
