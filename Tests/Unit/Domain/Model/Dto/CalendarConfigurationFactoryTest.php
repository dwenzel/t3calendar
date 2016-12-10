<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Model\Dto;

use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfigurationFactory;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Core\Tests\UnitTestCase;
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
class CalendarConfigurationFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarConfigurationFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getMock(
            CalendarConfigurationFactory::class, ['dummy']
        );
        $this->objectManager = $this->getMockForAbstractClass(
            ObjectManagerInterface::class
        );
        $this->subject->injectObjectManager($this->objectManager);
    }

    /**
     * Gets a CalendarConfiguration mock object
     * @return CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockConfiguration()
    {
        $mockConfiguration = $this->getMock(
            CalendarConfiguration::class,
            ['setDisplayPeriod', 'getDisplayPeriod', 'setStartDate', 'setCurrentDate', 'setViewMode', 'setAjaxEnabled']
        );
        $this->objectManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($mockConfiguration));

        return $mockConfiguration;
    }
    /**
     * @test
     */
    public function createReturnsObjectFromObjectManager()
    {
        $settings = [];
        $mockConfiguration = $this->getMock(CalendarConfiguration::class);
        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarConfiguration::class)
            ->will($this->returnValue($mockConfiguration));

        $this->assertSame(
            $mockConfiguration,
            $this->subject->create($settings)
        );
    }

    /**
     * data provider for displayPeriod
     * @return array
     */
    public function displayPeriodDataProvider()
    {
        return [
            [null, CalendarConfiguration::PERIOD_MONTH],
            [0, CalendarConfiguration::PERIOD_DAY],
            ['0', CalendarConfiguration::PERIOD_DAY],
            ['2', CalendarConfiguration::PERIOD_MONTH],
            [2, CalendarConfiguration::PERIOD_MONTH],
            ['1', CalendarConfiguration::PERIOD_WEEK],
            [1, CalendarConfiguration::PERIOD_WEEK],
            ['6', CalendarConfiguration::PERIOD_YEAR],
            [6, CalendarConfiguration::PERIOD_YEAR]
        ];
    }

    public function startDateDataProvider() {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $currentDate = new \DateTime('today', $timeZone);

        return [
            ['0', CalendarConfiguration::PERIOD_DAY,  'first day of this month'],
            ['1', CalendarConfiguration::PERIOD_WEEK, 'monday this week'],
            ['6', CalendarConfiguration::PERIOD_YEAR, 'first day of january ' . $currentDate->format('Y')],
        ];
    }

    /**
     * @test
     * @dataProvider displayPeriodDataProvider
     * @param int|string|null $value
     * @param int $expectedPeriod
     */
    public function createSetsDisplayPeriod($value, $expectedPeriod)
    {
        $settings = [
            'displayPeriod' => $value
        ];
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with($expectedPeriod);

        $this->subject->create($settings);
    }

    /**
     * @test
     * @dataProvider startDateDataProvider
     * @param $value
     * @param int $displayPeriod
     * @param string $modifier
     */
    public function createSetsStartDateByDisplayPeriod($value, $displayPeriod, $modifier)
    {
        $settings = [
            'displayPeriod' => $value
        ];
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('today', $timeZone);
        $expectedStartDate->modify($modifier);
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('getDisplayPeriod')
            ->will($this->returnValue($displayPeriod));
        $mockConfiguration->expects($this->once())
            ->method('setStartDate')
            ->with($expectedStartDate);

        $this->subject->create($settings);
    }

    /**
     * @test
     */
    public function createSetsCurrentDate()
    {
        $settings = [];
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedCurrentDate = new \DateTime('today', $timeZone);
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setCurrentDate')
            ->with($expectedCurrentDate);

        $this->subject->create($settings);
    }


    /**
     * @test
     */
    public function createSetsStartDateFromSettings()
    {
        $settings = [
            'startDate' => 'first day of july 2000'
        ];
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('today', $timeZone);
        $expectedStartDate->modify($settings['startDate']);
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setStartDate')
            ->with($expectedStartDate);

        $this->subject->create($settings);
    }

    /**
     * @test
     */
    public function createSetsDefaultViewMode()
    {
        $settings = [];
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setViewMode')
            ->with(CalendarConfiguration::VIEW_MODE_COMBO_PANE);

        $this->subject->create($settings);
    }

    /**
     * @test
     */
    public function createSetsViewModeFromSettings()
    {
        $settings = [
            'viewMode' => '5'
        ];
        $expectedViewMode = (int)$settings['viewMode'];
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setViewMode')
            ->with($expectedViewMode);

        $this->subject->create($settings);
    }

    /**
     * Data provider for setting ajaxEnabled
     *
     * @return array
     */
    public function ajaxEnabledDataProvider()
    {
        return [
            ['', false],
            ['foo', true],
            ['0', false],
            [0, false],
            ['1', true],
            [1, true]
        ];
    }

    /**
     * @test
     * @dataProvider ajaxEnabledDataProvider
     */
    public function createSetAjaxEnabled($valueFromSettings, $expectedValue)
    {
        $settings = [
            'ajaxEnabled' => $valueFromSettings
        ];
        $mockConfiguration = $this->mockConfiguration();
        $mockConfiguration->expects($this->once())
            ->method('setAjaxEnabled')
            ->with($expectedValue);

        $this->subject->create($settings);
    }

}