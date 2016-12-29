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

use DWenzel\T3calendar\Domain\Factory\CalendarFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarFactoryTrait;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarFactoryTraitTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarFactoryTraitTest extends UnitTestCase
{
    /**
     * @var CalendarFactoryTrait | \PHPUnit_Framework_MockObject_MockObject
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
            CalendarFactoryTrait::class);
    }

    /**
     * @test
     */
    public function calenderFactoryCanBeInjected()
    {
        $mockFactory = $this->getMockForAbstractClass(
            CalendarFactoryInterface::class
        );
        $this->subject->injectCalendarFactory($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'calendarFactory',
            $this->subject
        );
    }

}