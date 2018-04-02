<?php
namespace DWenzel\T3calendar\Tests\Unit\Persistence;

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

use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;
use DWenzel\T3calendar\Persistence\CalendarItemStorage;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalendarItemStorageTest
 * @package DWenzel\T3calendar\Tests\Unit\Persistence
 */
class CalendarItemStorageTest extends UnitTestCase
{
    /**
     * @var CalendarItemStorage|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(CalendarItemStorage::class)
            ->setMethods(['dummy'])->getMock();
    }

    /**
     * @test
     */
    public function hasItemsForDateInitiallyReturnsFalse()
    {
        $date = new \DateTime();
        $this->assertFalse(
            $this->subject->hasItemsForDate($date)
        );
    }

    /**
     * @test
     */
    public function getByDateInitiallyReturnsEmptyObjectStorage()
    {
        $date = new \DateTime();
        $expectedStorage = new ObjectStorage();
        $this->assertEquals(
            $expectedStorage,
            $this->subject->getByDate($date)
        );
    }

    /**
     * @test
     */
    public function attachAddsItems()
    {
        $date = new \DateTime();
        $item = $this->getMockForAbstractClass(CalendarItemInterface::class);
        $item->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));
        $this->subject->attach($item);

        $this->assertTrue(
            $this->subject->contains($item)
        );
        $this->assertTrue(
            $this->subject->getByDate($date)->contains($item)
        );
    }

    /**
     * @test
     */
    public function detachUnsetDateIfLastItemHasBeenRemoved()
    {
        $date = new \DateTime();
        $item = $this->getMockForAbstractClass(CalendarItemInterface::class);
        $item->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));
        $this->subject->attach($item);
        $this->subject->detach($item);
        $this->assertAttributeEmpty(
            'dateStorage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function attachAddsItemWithEndDateForEachDay()
    {
        $date = new \DateTime('today');
        $endDate = new \DateTime('tomorrow');
        /** @var CalendarItemInterface|\PHPUnit_Framework_MockObject_MockObject $item */
        $item = $this->getMockBuilder(CalendarItemInterface::class)
            ->setMethods(['getDate', 'getEndDate'])->getMock();
        $item->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));
        $item->expects($this->atLeastOnce())
            ->method('getEndDate')
            ->will($this->returnValue($endDate));
        $this->subject->attach($item);

        $this->assertTrue(
            $this->subject->contains($item)
        );
        $this->assertTrue(
            $this->subject->getByDate($date)->contains($item)
        );
        $this->assertTrue(
            $this->subject->getByDate($endDate)->contains($item)
        );
    }

    /**
     * @test
     */
    public function attachDoesNotAddItemForInvalidEndDate()
    {
        $date = new \DateTime('tomorrow');
        $endDate = new \DateTime('today');
        /** @var CalendarItemInterface|\PHPUnit_Framework_MockObject_MockObject $item */
        $item = $this->getMockBuilder(CalendarItemInterface::class)
            ->setMethods(['getDate', 'getEndDate'])->getMock();
        $item->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));
        $item->expects($this->atLeastOnce())
            ->method('getEndDate')
            ->will($this->returnValue($endDate));
        $this->subject->attach($item);

        $this->assertTrue(
            $this->subject->contains($item)
        );
        $this->assertTrue(
            $this->subject->getByDate($date)->contains($item)
        );
        $this->assertFalse(
            $this->subject->getByDate($endDate)->contains($item)
        );
    }
}
