<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Model\Dto;

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
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;

/**
 * Class CalendarConfigurationTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model\Dto
 * @coversDefaultClass DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration
 */
class CalendarConfigurationTest extends UnitTestCase {

	/**
	 * @var CalendarConfiguration
	 */
	protected $subject;

	public function setUp() {
		$this->subject = new CalendarConfiguration();
	}

	/**
	 * @test
	 * @covers ::getStartDate
	 */
	public function getStartDateForDateTimeReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getStartDate()
		);
	}

	/**
	 * @test
	 * @covers ::setStartDate
	 */
	public function setStartDateForDateTimeSetsStartDate() {
		$startDate = new \DateTime();
		$this->subject->setStartDate($startDate);
		$this->assertSame(
			$startDate,
			$this->subject->getStartDate()
		);
	}

	/**
	 * @test
	 * @covers ::getCurrentDate
	 */
	public function getCurrentDateForDateTimeReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getCurrentDate()
		);
	}

	/**
	 * @test
	 * @covers ::setCurrentDate
	 */
	public function setCurrentDateForDateTimeSetsCurrentDate() {
		$currentDate = new \DateTime();
		$this->subject->setCurrentDate($currentDate);
		$this->assertSame(
			$currentDate,
			$this->subject->getCurrentDate()
		);
	}

	/**
	 * @test
	 * @covers ::getDisplayPeriod
	 */
	public function getDisplayPeriodForIntegerReturnsInitiallyNull() {
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
	 * @covers ::getViewMode
	 */
	public function getViewModeForIntegerReturnsInitiallyNull() {
		$this->assertNull(
			$this->subject->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::setViewMode
	 */
	public function setViewModeForIntegerSetsViewMode() {
		$this->subject->setViewMode(CalendarConfiguration::VIEW_MODE_COMBO_PANE);
		$this->assertSame(
			CalendarConfiguration::VIEW_MODE_COMBO_PANE,
			$this->subject->getViewMode()
		);
	}

	/**
	 * @test
	 * @covers ::getAjaxEnabled
	 */
	public function getAjaxEnabledForBoolReturnsInitiallyFalse() {
		$this->assertFalse(
			$this->subject->getAjaxEnabled()
		);
	}

	/**
	 * @test
	 * @covers ::setAjaxEnabled
	 */
	public function setAjaxEnabledForBoolSetsAjaxEnabled() {
		$this->subject->setAjaxEnabled(true);
		$this->assertSame(
			true,
			$this->subject->getAjaxEnabled()
		);
	}
}