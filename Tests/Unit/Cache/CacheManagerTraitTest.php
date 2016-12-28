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

use DWenzel\T3calendar\Cache\CacheManagerTrait;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class CacheManagerTraitTest
 * @package DWenzel\T3calendar\Tests\Unit\Domain\Factory
 */
class CacheManagerTraitTest extends UnitTestCase
{
    /**
     * @var CacheManagerTrait | \PHPUnit_Framework_MockObject_MockObject
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
            CacheManagerTrait::class);
    }

    /**
     * @test
     */
    public function calenderFactoryCanBeInjected()
    {
        $mockFactory = $this->getMock(
            CacheManager::class
        );
        $this->subject->injectCacheManager($mockFactory);
        $this->assertAttributeSame(
            $mockFactory,
            'cacheManager',
            $this->subject
        );
    }
}