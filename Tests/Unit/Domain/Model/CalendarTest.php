<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Model;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Tests\UnitTestCase;
use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\CalendarQuarter;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;

/**
 * Class CalendarTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model
 * @coversDefaultClass \DWenzel\T3calendar\Domain\Model\Calendar
 */
class CalendarTest extends UnitTestCase {

	/**
	 * @var Calendar
	 */
	protected $subject;

	public function setUp() {
		$this->subject = $this->getAccessibleMock(
			'DWenzel\\T3calendar\\Domain\\Model\\Calendar',
			['dummy'], [], '', true
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentMonth
	 */
	public function getCurrentMonthReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getCurrentMonth()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentMonth
	 */
	public function setCurrentMonthForObjectSetsCurrentMonth() {
		$month = new CalendarMonth();
		$this->subject->setCurrentMonth($month);

		$this->assertSame(
			$month,
			$this->subject->getCurrentMonth()
		);
	}

	/**
	 * @test
	 * @covers ::getViewMode
	 */
	public function getViewModeReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::setViewMode
	 */
	public function setViewModeForIntegerSetsViewMode() {
		$this->subject->setViewMode(CalendarConfiguration::VIEW_MODE_MINI_MONTH);
		$this->assertSame(
			CalendarConfiguration::VIEW_MODE_MINI_MONTH,
			$this->subject->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::getDisplayPeriod
	 */
	public function getDisplayPeriodReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getDisplayPeriod()
		);
	}

	/**
	 * @test
	 * @covers ::setDisplayPeriod
	 */
	public function setDisplayPeriodForIntegerSetsDisplayPeriod() {
		$this->subject->setDisplayPeriod(CalendarConfiguration::PERIOD_MONTH);
		$this->assertSame(
			CalendarConfiguration::PERIOD_MONTH,
			$this->subject->getDisplayPeriod()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentWeek
	 */
	public function getCurrentWeekReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getCurrentWeek()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentWeek
	 */
	public function setCurrentWeekForObjectSetsCurrentWeek() {
		$week = new CalendarWeek();
		$this->subject->setCurrentWeek($week);

		$this->assertSame(
			$week,
			$this->subject->getCurrentWeek()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentYear
	 */
	public function getCurrentYearReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getCurrentYear()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentYear
	 */
	public function setCurrentYearForObjectSetsCurrentYear() {
		$year = new CalendarYear();
		$this->subject->setCurrentYear($year);

		$this->assertSame(
			$year,
			$this->subject->getCurrentYear()
		);
	}

    /**
     * @test
     * @covers ::getCurrentQuarter
     */
    public function getCurrentQuarterReturnsInitiallyNull() {
        $this->assertNull(
            $this->subject->getCurrentQuarter()
        );
    }

    /**
     * @test
     * @covers ::setCurrentQuarter
     */
    public function setCurrentQuarterForObjectSetsCurrentQuarter() {
        $quarter = new CalendarQuarter();
        $this->subject->setCurrentQuarter($quarter);

        $this->assertSame(
            $quarter,
            $this->subject->getCurrentQuarter()
        );
    }

    /**
	 * @test
	 * @covers ::getCurrentDay
	 */
	public function getCurrentDayReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getCurrentDay()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentDay
	 */
	public function setCurrentDayForObjectSetsCurrentDay() {
		$day = new CalendarDay();
		$this->subject->setCurrentDay($day);

		$this->assertSame(
			$day,
			$this->subject->getCurrentDay()
		);
	}

    /**
     * weekday label dataprovider
     */
    public function weekDayLabelDataProvider()
    {
        $modeFormats = [
            0 => '%A',
            CalendarConfiguration::VIEW_MODE_MINI_MONTH => '%a'
        ];

        $dataSets = [];

        foreach ($modeFormats as $mode=>$format) {
            $weekDayLabels = [];
            for ($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++) {

                $weekDayLabels[] = strftime($format, strtotime('next Monday +' . $dayOfWeek . ' days'));
            }
            // mode, expectedLabels
            $dataSets[] = [
                $mode, $weekDayLabels
            ];
        }

        return $dataSets;
    }

    /**
     * @test
     * @dataProvider weekDayLabelDataProvider
     * @param int $mode A CalendarConfiguration::VIEW_MODE_* constant
     * @param array $weekDayLabels
     */
	public function getWeekDayLabelsInitiallyReturnsLabelsInCorrectFormat($mode, $weekDayLabels)
    {
        $this->subject->setViewMode($mode);
        $this->assertSame(
            $weekDayLabels,
            $this->subject->getWeekDayLabels()
        );
    }

    /**
     * @test
     */
    public function getMonthLabelsReturnsLabels()
    {
        $monthNames = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthNames[] = date('F', mktime(0, 0, 0, $month));
        }
        $this->assertSame(
            $monthNames,
            $this->subject->getMonthLabels()
        );
    }
}
