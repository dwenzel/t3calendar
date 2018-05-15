<?php

namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

use DWenzel\T3calendar\Domain\Factory\CalendarDayFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarYearFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarYearFactoryInterface;
use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarQuarter;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
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
class CalendarFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var CalendarDayFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarDayFactory;

    /**
     * @var CalendarWeekFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarWeekFactory;

    /**
     * @var CalendarMonthFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarMonthFactory;

    /**
     * @var CalendarYearFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarYearFactory;

    /**
     * @var CalendarQuarterFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarQuarterFactory;

    /**
     * @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    public function setUp()
    {
        $this->subject = $this->getMockBuilder(CalendarFactory::class)
            ->setMethods(['dummy'])
            ->getMock();
        /** @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject objectManager */
        $this->objectManager = $this->getMockBuilder(ObjectManager::class)
            ->setMethods(['get'])
            ->getMock();
        $this->subject->injectObjectManager($this->objectManager);

        /** @var CalendarFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarDayFactory */
        $this->calendarDayFactory = $this->getMockBuilder(CalendarDayFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->subject->injectCalendarDayFactory($this->calendarDayFactory);

        /** @var CalendarWeekFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarWeekFactory */
        $this->calendarWeekFactory = $this->getMockBuilder(CalendarWeekFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->subject->injectCalendarWeekFactory($this->calendarWeekFactory);

        /** @var CalendarMonthFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarMonthFactory */
        $this->calendarMonthFactory = $this->getMockBuilder(CalendarMonthFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->subject->injectCalendarMonthFactory($this->calendarMonthFactory);

        /** @var CalendarMonth|\PHPUnit_Framework_MockObject_MockObject $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->calendarMonthFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));

        /** @var CalendarQuarterFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarQuarterFactory */
        $this->calendarQuarterFactory = $this->getMockBuilder(CalendarQuarterFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->subject->injectCalendarQuarterFactory($this->calendarQuarterFactory);

        /** @var CalendarYearFactoryInterface calendarYearFactory */
        $this->calendarYearFactory = $this->getMockBuilder(CalendarYearFactory::class)
            ->setMethods(['create'])
            ->getMock();
        $this->subject->injectCalendarYearFactory($this->calendarYearFactory);
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $mockConfiguration = $this->mockConfiguration();

        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(Calendar::class)
            ->will($this->returnValue($mockCalendar));

        $this->assertSame(
            $mockCalendar,
            $this->subject->create($mockConfiguration, $items)
        );
    }

    /**
     * @return CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockConfiguration()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        /** @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject $mockConfiguration */
        $mockConfiguration = $this->getMockBuilder(CalendarConfiguration::class)
            ->setMethods(['getStartDate', 'getCurrentDate', 'getViewMode', 'getDisplayPeriod'])
            ->getMock();
        $mockConfiguration->expects($this->any())
            ->method('getStartDate')
            ->will($this->returnValue($startDate));
        $mockConfiguration->expects($this->any())
            ->method('getCurrentDate')
            ->will($this->returnValue($currentDate));
        return $mockConfiguration;
    }

    /**
     * @test
     */
    public function createSetsViewMode()
    {
        $viewMode = 999;
        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->atLeastOnce())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));

        $mockCalendar->expects($this->once())
            ->method('setViewMode')
            ->with($viewMode);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsDisplayPeriod()
    {
        $displayPeriod = CalendarConfiguration::PERIOD_DAY;

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->atLeastOnce())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));
        $mockCalendar->expects($this->once())
            ->method('setDisplayPeriod');

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentMonthForViewModeMiniMonth()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();
        $viewMode = CalendarConfiguration::VIEW_MODE_MINI_MONTH;

        /** @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject $mockConfiguration */
        $mockConfiguration = $this->getMockBuilder(CalendarConfiguration::class)
            ->setMethods(['getStartDate', 'getCurrentDate', 'getViewMode'])
            ->getMock();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();
        /** @var CalendarMonth|\PHPUnit_Framework_MockObject_MockObject $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->atLeastOnce())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->atLeastOnce())
            ->method('getStartDate')
            ->will($this->returnValue($startDate));
        $mockConfiguration->expects($this->atLeastOnce())
            ->method('getCurrentDate')
            ->will($this->returnValue($currentDate));

        $this->calendarMonthFactory->expects($this->once())
            ->method('create')
            ->with($startDate, $currentDate, $items)
            ->will($this->returnValue($mockCalendarMonth));

        $mockCalendar->expects($this->once())
            ->method('setCurrentMonth')
            ->with($mockCalendarMonth);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentDayForDisplayPeriodDayAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_DAY;


        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();
        /** @var CalendarDay|\PHPUnit_Framework_MockObject_MockObject $mockCalendarDay */
        $mockCalendarDay = $this->getMockBuilder(CalendarDay::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $mockCalendar->expects($this->once())
            ->method('setCurrentDay')
            ->with($mockCalendarDay);

        $this->calendarDayFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockCalendarDay));


        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentWeekForDisplayPeriodWeekAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_WEEK;

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        /** @var CalendarWeek|\PHPUnit_Framework_MockObject_MockObject $mockCalendarWeek */
        $mockCalendarWeek = $this->getMockBuilder(CalendarWeek::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $this->calendarWeekFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockCalendarWeek));

        $mockCalendar->expects($this->once())
            ->method('setCurrentWeek')
            ->with($mockCalendarWeek);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentYearForDisplayPeriodYearAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_YEAR;

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        /** @var CalendarYear|\PHPUnit_Framework_MockObject_MockObject $mockCalendarYear */
        $mockCalendarYear = $this->getMockBuilder(CalendarYear::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $this->calendarYearFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockCalendarYear));

        $mockCalendar->expects($this->once())
            ->method('setCurrentYear')
            ->with($mockCalendarYear);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentQuarterForDisplayPeriodQuarterAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_QUARTER;

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();

        /** @var CalendarQuarter|\PHPUnit_Framework_MockObject_MockObject $mockCalendarQuarter */
        $mockCalendarQuarter = $this->getMockBuilder(CalendarQuarter::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $this->calendarQuarterFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockCalendarQuarter));

        $mockCalendar->expects($this->once())
            ->method('setCurrentQuarter')
            ->with($mockCalendarQuarter);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentMonthForDisplayPeriodMonthAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_MONTH;

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        /** @var Calendar|\PHPUnit_Framework_MockObject_MockObject $mockCalendar */
        $mockCalendar = $this->getMockBuilder(Calendar::class)->getMock();
        /** @var CalendarMonth|\PHPUnit_Framework_MockObject_MockObject $mockCalendarMonth */
        $mockCalendarMonth = $this->getMockBuilder(CalendarMonth::class)->getMock();
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $this->calendarMonthFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));

        $mockCalendar->expects($this->once())
            ->method('setCurrentMonth')
            ->with($mockCalendarMonth);

        $this->subject->create($mockConfiguration, $items);
    }
}
