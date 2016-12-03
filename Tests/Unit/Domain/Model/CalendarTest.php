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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;

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
	protected $fixture;

	public function setUp() {
		$this->fixture = $this->getAccessibleMock(
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
			$this->fixture->getCurrentMonth()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentMonth
	 */
	public function setCurrentMonthForObjectSetsCurrentMonth() {
		$month = new CalendarMonth();
		$this->fixture->setCurrentMonth($month);

		$this->assertSame(
			$month,
			$this->fixture->getCurrentMonth()
		);
	}

	/**
	 * @test
	 * @covers ::getViewMode
	 */
	public function getViewModeReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::setViewMode
	 */
	public function setViewModeForIntegerSetsViewMode() {
		$this->fixture->setViewMode(CalendarConfiguration::VIEW_MODE_MINI_MONTH);
		$this->assertSame(
			CalendarConfiguration::VIEW_MODE_MINI_MONTH,
			$this->fixture->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::getDisplayPeriod
	 */
	public function getDisplayPeriodReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getDisplayPeriod()
		);
	}

	/**
	 * @test
	 * @covers ::setDisplayPeriod
	 */
	public function setDisplayPeriodForIntegerSetsDisplayPeriod() {
		$this->fixture->setDisplayPeriod(CalendarConfiguration::PERIOD_MONTH);
		$this->assertSame(
			CalendarConfiguration::PERIOD_MONTH,
			$this->fixture->getDisplayPeriod()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentWeek
	 */
	public function getCurrentWeekReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getCurrentWeek()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentWeek
	 */
	public function setCurrentWeekForObjectSetsCurrentWeek() {
		$week = new CalendarWeek();
		$this->fixture->setCurrentWeek($week);

		$this->assertSame(
			$week,
			$this->fixture->getCurrentWeek()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentYear
	 */
	public function getCurrentYearReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getCurrentYear()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentYear
	 */
	public function setCurrentYearForObjectSetsCurrentYear() {
		$year = new CalendarYear();
		$this->fixture->setCurrentYear($year);

		$this->assertSame(
			$year,
			$this->fixture->getCurrentYear()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentDay
	 */
	public function getCurrentDayReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getCurrentDay()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentDay
	 */
	public function setCurrentDayForObjectSetsCurrentDay() {
		$day = new CalendarDay();
		$this->fixture->setCurrentDay($day);

		$this->assertSame(
			$day,
			$this->fixture->getCurrentDay()
		);
	}
}
