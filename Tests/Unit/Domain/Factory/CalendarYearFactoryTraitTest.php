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

use DWenzel\T3calendar\Domain\Factory\CalendarYearFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarYearFactoryTrait;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarYearFactoryTraitTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarYearFactoryTraitTest extends UnitTestCase
{
    /**
     * @var CalendarYearFactoryTrait | \PHPUnit_Framework_MockObject_MockObject
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
            CalendarYearFactoryTrait::class);
    }

    /**
     * @test
     */
    public function calenderYearFactoryCanBeInjected()
    {
        $mockFactory = $this->getMockForAbstractClass(
            CalendarYearFactoryInterface::class
        );
        $this->subject->injectCalendarYearFactory($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'calendarYearFactory',
            $this->subject
        );
    }

}
