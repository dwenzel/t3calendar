<?php

namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

use DWenzel\T3calendar\Domain\Factory\CalendarDayFactory;
use DWenzel\T3calendar\Domain\Model\CalendarDay;
use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;
use TYPO3\CMS\Core\Tests\UnitTestCase;
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
class CalendarDayFactoryTest extends UnitTestCase
{
    /**
     * @var CalendarDayFactory | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * Object manager
     * @var ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarDayFactory::class, ['dummy']
        );
        $this->objectManager = $this->getMock(ObjectManager::class, ['get']);
        $this->subject->injectObjectManager($this->objectManager);
    }

    /**
     * @test
     */
    public function objectManagerCanBeInjected()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarDayFactory::class, ['dummy']
        );

        $mockObjectManager = $this->getMock(ObjectManager::class);
        $this->subject->injectObjectManager($mockObjectManager);
        $this->assertAttributeSame(
            $mockObjectManager,
            'objectManager',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function createAddsItemsWithMatchingDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMock(
            CalendarDay::class, ['addItem'], [$date]
        );

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));
        $mockItemWithMatchingDate = $this->getMockForAbstractClass(
            CalendarItemInterface::class, ['getDate']
        );
        $mockItemWithMatchingDate->expects($this->atLeastOnce())
            ->method('getDate')
            ->will($this->returnValue($date));

        $this->subject->create($date, [$mockItemWithMatchingDate]);
    }

    /**
     * @test
     */
    public function createSetsCurrent()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMock(
            CalendarDay::class, ['setIsCurrent'], [$date]
        );

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));
        $mockCalendarDay->expects($this->once())
            ->method('setIsCurrent')
            ->with(true);

        $this->subject->create($date, null, true);
    }

    /**
     * @test
     */
    public function createReturnsObject()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $date = new \DateTime('now', $timeZone);
        $mockCalendarDay = $this->getMock(
            CalendarDay::class, [], [$date]
        );

        $this->objectManager->expects($this->once())
            ->method('get')
            ->with(CalendarDay::class, $date)
            ->will($this->returnValue($mockCalendarDay));

        $this->assertSame(
            $mockCalendarDay,
            $this->subject->create($date)
        );
    }

}