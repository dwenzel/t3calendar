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
use DWenzel\T3calendar\Domain\Model\CalendarMonth;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;

/**
 * Class CalendarMonthTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model
 * @coversDefaultClass \DWenzel\T3calendar\Domain\Model\CalendarMonth
 */
class CalendarMonthTest extends UnitTestCase {

	/**
	 * @var CalendarMonth
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = $this->getAccessibleMock(
			'DWenzel\\T3calendar\\Domain\\Model\\CalendarMonth',
			['dummy'], [], '', true
		);
	}

	/**
	 * @test
	 * @covers ::getWeeks
	 */
	public function getWeeksReturnsInitiallyEmptyObjectStorage() {
		$emptyObjectStorage = new ObjectStorage();

		$this->assertEquals(
			$emptyObjectStorage,
			$this->fixture->getWeeks()
		);
	}

	/**
	 * @test
	 * @covers ::setWeeks
	 */
	public function setWeeksForObjectStorageSetsWeeks() {
		$emptyObjectStorage = new ObjectStorage();
		$this->fixture->setWeeks($emptyObjectStorage);

		$this->assertSame(
			$emptyObjectStorage,
			$this->fixture->getWeeks()
		);
	}

	/**
	 * @test
	 * @covers ::addWeek
	 */
	public function addWeekForObjectAddsEvent() {
		$week = new CalendarWeek();
		$this->fixture->addWeek($week);
		$this->assertTrue(
			$this->fixture->getWeeks()->contains($week)
		);
	}

	/**
	 * @test
	 * @covers ::removeWeek
	 */
	public function removeWeekForObjectRemovesEvent() {
		$week = new CalendarWeek();
		$objectStorageContainingOneWeek = new ObjectStorage();
		$objectStorageContainingOneWeek->attach($week);

		$this->fixture->setWeeks($objectStorageContainingOneWeek);
		$this->fixture->removeWeek($week);
		$this->assertFalse(
			$this->fixture->getWeeks()->contains($week)
		);
	}

	/**
	 * @test
	 * @covers ::getMonth
	 */
	public function getMonthReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getMonth()
		);
	}

	/**
	 * @test
	 * @covers ::getMonth
	 */
	public function getMonthForStringReturnsMonth() {
		$timeStamp = 1441065600;
		$dateTime = new \DateTime('@' . $timeStamp);
		$expectedMonth = date('n', $timeStamp);
		$this->fixture->setStartDate($dateTime);
		$this->assertSame(
			$expectedMonth,
			$this->fixture->getMonth()
		);
	}

	/**
	 * @test
	 * @covers ::getStartDate
	 */
	public function getStartDateReturnsInitiallyNull() {
		$this->assertNull(
			$this->fixture->getStartDate()
		);
	}

	/**
	 * @test
	 * @covers ::setStartDate
	 */
	public function setStartDateForObjectSetsStartDate() {
		$expectedStartDate = new \DateTime();
		$this->fixture->setStartDate($expectedStartDate);
		$this->assertSame(
			$expectedStartDate,
			$this->fixture->getStartdate()
		);
	}

	/**
	 * @test
	 */
	public function constructInitializesStorageObjects() {
		$expectedObjectStorage = new ObjectStorage();
		$this->fixture->__construct();

		$this->assertEquals(
			$expectedObjectStorage,
			$this->fixture->getWeeks()
		);
	}
}
