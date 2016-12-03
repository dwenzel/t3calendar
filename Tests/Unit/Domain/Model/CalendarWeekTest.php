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
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;

/**
 * Class CalendarMonthTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model
 * @coversDefaultClass \DWenzel\T3calendar\Domain\Model\CalendarWeek
 */
class CalendarWeekTest extends UnitTestCase {

	/**
	 * @var CalendarWeek
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = $this->getAccessibleMock(
			'DWenzel\\T3calendar\\Domain\\Model\\CalendarWeek',
			['dummy'], [], '', true
		);
	}

	/**
	 * @test
	 * @covers ::getDays
	 */
	public function getDaysReturnsInitiallyEmptyObjectStorage() {
		$emptyObjectStorage = new ObjectStorage();

		$this->assertEquals(
			$emptyObjectStorage,
			$this->fixture->getDays()
		);
	}

	/**
	 * @test
	 * @covers ::setDays
	 */
	public function setDaysForObjectStorageSetsWeeks() {
		$emptyObjectStorage = new ObjectStorage();
		$this->fixture->setDays($emptyObjectStorage);

		$this->assertSame(
			$emptyObjectStorage,
			$this->fixture->getDays()
		);
	}

	/**
	 * @test
	 * @covers ::addDay
	 */
	public function addDayForObjectAddsEvent() {
		$day = new CalendarDay();
		$this->fixture->addDay($day);
		$this->assertTrue(
			$this->fixture->getDays()->contains($day)
		);
	}

	/**
	 * @test
	 * @covers ::removeDay
	 */
	public function removeDayForObjectRemovesEvent() {
		$day = new CalendarDay();
		$objectStorageContainingOneDay = new ObjectStorage();
		$objectStorageContainingOneDay->attach($day);

		$this->fixture->setDays($objectStorageContainingOneDay);
		$this->fixture->removeDay($day);
		$this->assertFalse(
			$this->fixture->getDays()->contains($day)
		);
	}

	/**
	 * @test
	 */
	public function constructorInitializesStorageObjects() {
		$expectedObjectStorage = new ObjectStorage();
		$this->fixture->__construct();

		$this->assertEquals(
			$expectedObjectStorage,
			$this->fixture->getDays()
		);
	}
}
