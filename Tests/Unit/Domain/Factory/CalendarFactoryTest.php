<?php

namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;
use DWenzel\T3calendar\Domain\Factory\CalendarDayFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarMonthFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarYearFactory;
use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactory;
use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use DWenzel\T3calendar\Domain\Model\CalendarQuarter;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
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
        $this->subject = $this->getMock(
            CalendarFactory::class, ['dummy']
        );
        $this->objectManager = $this->getMock(ObjectManager::class, ['get']);
        $this->subject->injectObjectManager($this->objectManager);

        $this->calendarDayFactory = $this->getMock(CalendarDayFactory::class, ['create']);
        $this->subject->injectCalendarDayFactory($this->calendarDayFactory);

        $this->calendarWeekFactory = $this->getMock(CalendarWeekFactory::class, ['create']);
        $this->subject->injectCalendarWeekFactory($this->calendarWeekFactory);

        $this->calendarMonthFactory = $this->getMock(CalendarMonthFactory::class, ['create']);
        $this->subject->injectCalendarMonthFactory($this->calendarMonthFactory);
        $mockCalendarMonth = $this->getMock(CalendarMonth::class);
        $this->calendarMonthFactory->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockCalendarMonth));
        $this->calendarQuarterFactory = $this->getMock(CalendarQuarterFactory::class, ['create']);
        $this->subject->injectCalendarQuarterFactory($this->calendarQuarterFactory);

        $this->calendarYearFactory = $this->getMock(CalendarYearFactory::class, ['create']);
        $this->subject->injectCalendarYearFactory($this->calendarYearFactory);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockConfiguration()
    {
        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        $mockConfiguration = $this->getMock(
            CalendarConfiguration::class,
            ['getStartDate', 'getCurrentDate', 'getViewMode', 'getDisplayPeriod']
        );
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
    public function createReturnsObject()
    {
        $mockConfiguration = $this->mockConfiguration();

        $items = [];

        $mockCalendar = $this->getMock(
            Calendar::class
        );

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
     * @test
     */
    public function createSetsViewMode()
    {
        $viewMode = 999;
        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(
            Calendar::class
        );

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

        $mockCalendar = $this->getMock(Calendar::class);

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

        $mockConfiguration = $this->getMock(
            CalendarConfiguration::class,
            ['getStartDate', 'getCurrentDate', 'getViewMode']
        );
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarMonth = $this->getMock(CalendarMonth::class);
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

        $currentDate = new \DateTime();

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarDay = $this->getMock(CalendarDay::class);
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockCalendar));
        $mockConfiguration->expects($this->once())
            ->method('getViewMode')
            ->will($this->returnValue($viewMode));
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));

        $this->calendarDayFactory->expects($this->once())
            ->method('create')
            ->with($currentDate, $items, true)
            ->will($this->returnValue($mockCalendarDay));

        $mockCalendar->expects($this->once())
            ->method('setCurrentDay')
            ->with($mockCalendarDay);

        $this->subject->create($mockConfiguration, $items);
    }

    /**
     * @test
     */
    public function createSetsCurrentWeekForDisplayPeriodWeekAndViewModeComboPane()
    {
        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        $displayPeriod = CalendarConfiguration::PERIOD_WEEK;

        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarWeek = $this->getMock(CalendarWeek::class);
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
            ->with($startDate, $currentDate, $items)
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

        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarYear = $this->getMock(CalendarYear::class);
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
            ->with($startDate, $currentDate, $items)
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

        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarQuarter = $this->getMock(CalendarQuarter::class);
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
            ->with($startDate, $currentDate, $items)
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

        $startDate = new \DateTime();
        $currentDate = new \DateTime();

        $mockConfiguration = $this->mockConfiguration();
        $items = [];

        $mockCalendar = $this->getMock(Calendar::class);
        $mockCalendarMonth = $this->getMock(CalendarMonth::class);
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
            ->with($startDate, $currentDate, $items)
            ->will($this->returnValue($mockCalendarMonth));

        $mockCalendar->expects($this->once())
            ->method('setCurrentMonth')
            ->with($mockCalendarMonth);

        $this->subject->create($mockConfiguration, $items);
    }
}
