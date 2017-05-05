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
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarWeek;

/**
 * Class CalendarMonthTest
 *
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Model
 * @coversDefaultClass \DWenzel\T3calendar\Domain\Model\CalendarWeek
 */
class CalendarWeekTest extends UnitTestCase
{

    /**
     * @var CalendarWeek
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarWeek::class,
            ['dummy'], [], '', true
        );
    }

    /**
     * @test
     * @covers ::getDays
     */
    public function getDaysReturnsInitiallyEmptyObjectStorage()
    {
        $emptyObjectStorage = new ObjectStorage();

        $this->assertEquals(
            $emptyObjectStorage,
            $this->subject->getDays()
        );
    }

    /**
     * @test
     * @covers ::setDays
     */
    public function setDaysForObjectStorageSetsWeeks()
    {
        $emptyObjectStorage = new ObjectStorage();
        $this->subject->setDays($emptyObjectStorage);

        $this->assertSame(
            $emptyObjectStorage,
            $this->subject->getDays()
        );
    }

    /**
     * @test
     * @covers ::addDay
     */
    public function addDayForObjectAddsEvent()
    {
        $day = new CalendarDay();
        $this->subject->addDay($day);
        $this->assertTrue(
            $this->subject->getDays()->contains($day)
        );
    }

    /**
     * @test
     * @covers ::removeDay
     */
    public function removeDayForObjectRemovesEvent()
    {
        $day = new CalendarDay();
        $objectStorageContainingOneDay = new ObjectStorage();
        $objectStorageContainingOneDay->attach($day);

        $this->subject->setDays($objectStorageContainingOneDay);
        $this->subject->removeDay($day);
        $this->assertFalse(
            $this->subject->getDays()->contains($day)
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
            $this->subject->getDays()
        );
    }
}
