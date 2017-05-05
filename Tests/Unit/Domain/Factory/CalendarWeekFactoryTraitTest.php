<?php
namespace DWenzel\T3calendar\Tests\Unit\Domain\Factory;

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

use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarWeekFactoryTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarWeekFactoryTraitTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarWeekFactoryTraitTest extends UnitTestCase
{
    /**
     * @var CalendarWeekFactoryTrait | \PHPUnit_Framework_MockObject_MockObject
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
        $this->subject = $this->getMockForTrait(
            CalendarWeekFactoryTrait::class);
    }

    /**
     * @test
     */
    public function calenderWeekFactoryCanBeInjected()
    {
        $mockFactory = $this->getMockForAbstractClass(
            CalendarWeekFactoryInterface::class
        );
        $this->subject->injectCalendarWeekFactory($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'calendarWeekFactory',
            $this->subject
        );
    }

}
