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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use DWenzel\T3calendar\Domain\Model\CalendarYear;
use DWenzel\T3calendar\Domain\Model\CalendarMonth;

/**
 * Class CalendarYearTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model
 * @coversDefaultClass \DWenzel\T3calendar\Domain\Model\CalendarYear
 */
class CalendarYearTest extends UnitTestCase
{

    /**
     * @var CalendarYear
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarYear::class,
            ['dummy'], [], '', true
        );
    }

    /**
     * @test
     * @covers ::getMonths
     */
    public function getMonthsReturnsInitiallyEmptyObjectStorage()
    {
        $emptyObjectStorage = new ObjectStorage();

        $this->assertEquals(
            $emptyObjectStorage,
            $this->subject->getMonths()
        );
    }

    /**
     * @test
     * @covers ::setMonths
     */
    public function setMonthsForObjectStorageSetsMonths()
    {
        $emptyObjectStorage = new ObjectStorage();
        $this->subject->setMonths($emptyObjectStorage);

        $this->assertSame(
            $emptyObjectStorage,
            $this->subject->getMonths()
        );
    }

    /**
     * @test
     * @covers ::addMonth
     */
    public function addMonthForObjectAddsEvent()
    {
        $month = new CalendarMonth();
        $this->subject->addMonth($month);
        $this->assertTrue(
            $this->subject->getMonths()->contains($month)
        );
    }

    /**
     * @test
     * @covers ::removeMonth
     */
    public function removeMonthForObjectRemovesEvent()
    {
        $month = new CalendarMonth();
        $objectStorageContainingOneMonth = new ObjectStorage();
        $objectStorageContainingOneMonth->attach($month);

        $this->subject->setMonths($objectStorageContainingOneMonth);
        $this->subject->removeMonth($month);
        $this->assertFalse(
            $this->subject->getMonths()->contains($month)
        );
    }

    /**
     * @test
     * @covers ::getYear
     */
    public function getYearReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getYear()
        );
    }

    /**
     * @test
     * @covers ::getYear
     */
    public function getYearForStringReturnsYear()
    {
        $timeStamp = 1_441_065_600;
        $dateTime = new \DateTime('@' . $timeStamp);
        $expectedYear = date('Y', $timeStamp);
        $this->subject->setStartDate($dateTime);
        $this->assertSame(
            $expectedYear,
            $this->subject->getYear()
        );
    }

    /**
     * @test
     * @covers ::getStartDate
     */
    public function getStartDateReturnsInitiallyNull()
    {
        $this->assertNull(
            $this->subject->getStartDate()
        );
    }

    /**
     * @test
     * @covers ::setStartDate
     */
    public function setStartDateForObjectSetsStartDate()
    {
        $expectedStartDate = new \DateTime();
        $this->subject->setStartDate($expectedStartDate);
        $this->assertSame(
            $expectedStartDate,
            $this->subject->getStartdate()
        );
    }

    /**
     * @test
     */
    public function constructorInitializesStorageObjects()
    {
        $expectedObjectStorage = new ObjectStorage();
        $this->subject->__construct();

        $this->assertEquals(
            $expectedObjectStorage,
            $this->subject->getMonths()
        );
    }
}
