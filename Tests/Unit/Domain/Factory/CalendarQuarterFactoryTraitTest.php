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

use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactoryInterface;
use DWenzel\T3calendar\Domain\Factory\CalendarQuarterFactoryTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CalendarQuarterFactoryTraitTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CalendarQuarterFactoryTraitTest extends UnitTestCase
{
    /**
     * @var CalendarQuarterFactoryTrait | \PHPUnit_Framework_MockObject_MockObject
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
            CalendarQuarterFactoryTrait::class);
    }

    /**
     * @test
     */
    public function calenderQuarterFactoryCanBeInjected()
    {
        $mockFactory = $this->getMockForAbstractClass(
            CalendarQuarterFactoryInterface::class
        );
        $this->subject->injectCalendarQuarterFactory($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'calendarQuarterFactory',
            $this->subject
        );
    }

}
