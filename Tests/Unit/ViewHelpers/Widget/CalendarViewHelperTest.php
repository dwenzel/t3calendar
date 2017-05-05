<?php

namespace DWenzel\T3calendar\Tests\Unit\ViewHelpers\Widget;

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


use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use DWenzel\T3calendar\ViewHelpers\Widget\CalendarViewHelper;
use Nimut\TestingFramework\MockObject\AccessibleMockObjectInterface;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalendarViewHelperTest
 * @package DWenzel\T3calendar\Tests\Unit\ViewHelpers\Widget
 */
class CalendarViewHelperTest extends UnitTestCase
{
    /**
     * @var CalendarViewHelper|\PHPUnit_Framework_MockObject_MockObject|AccessibleMockObjectInterface
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarViewHelper::class, ['hasArgument', 'initiateSubRequest', 'registerArgument']
        );
    }

    /**
     * @test
     */
    public function initializeSetsAjaxEnabled()
    {
        $mockConfiguration = $this->getMock(CalendarConfiguration::class, ['getAjaxEnabled']);
        $arguments = [
            'configuration' => $mockConfiguration
        ];
        $ajaxEnabled = true;
        $this->subject->_set('arguments', $arguments);
        $this->subject->expects($this->once())
            ->method('hasArgument')
            ->will($this->returnValue(true));
        $mockConfiguration->expects($this->once())
            ->method('getAjaxEnabled')
            ->will($this->returnValue($ajaxEnabled));
        $this->subject->initialize();
        $this->assertAttributeSame(
            $ajaxEnabled,
            'ajaxWidget',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function renderInitiatesSubRequest()
    {
        $arguments = [
            'objects' => []
        ];
        $this->subject->setArguments($arguments);
        $this->subject->expects($this->once())
            ->method('initiateSubRequest');
        $this->subject->render();
    }

    /**
     * @test
     */
    public function initializeArgumentsRegistersArguments()
    {
        $this->subject->expects($this->exactly(4))
            ->method('registerArgument')
            ->withConsecutive(
                ['objects', 'mixed', 'Required: Array or instance of \Iterator or \TYPO3\CMS\Extbase\Persistence\QueryResultInterface or \DWenzel\T3calendar\Persistence\CalendarItemStorage', true],
                ['configuration', 'mixed', 'Required: Instance of \DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration or array'],
                ['id', 'string', 'Optional: String, identifier for widget'],
                ['parameters', 'array', 'Optional: Array of parameters']
            )
            ->willReturn($this->subject);

        $this->subject->initializeArguments();
    }

    public function invalidObjectDataProvider()
    {
        return [
            [5],
            ['foo'],
            [new ObjectStorage()],
            [new \stdClass()]
        ];
    }

    /**
     * @test
     * @dataProvider invalidObjectDataProvider
     * @expectedException \UnexpectedValueException
     * @expectedExceptionCode 1493322353
     */
    public function renderThrowsExceptionForInvalidTypesOfObjects($invalidObject)
    {
        $arguments = [
            'objects' => $invalidObject
        ];
        $this->subject->setArguments($arguments);

        $this->subject->render();
    }

    public function invalidConfigurationDataProvider()
    {
        return [
            [5],
            ['foo'],
            [new ObjectStorage()],
            [new \stdClass()]
        ];
    }

    /**
     * @test
     * @dataProvider invalidConfigurationDataProvider
     * @expectedException \UnexpectedValueException
     * @expectedExceptionCode 1493322353
     */
    public function renderThrowsExceptionForInvalidTypesOfConfiguration($invalidConfiguration)
    {
        $arguments = [
            'objects' => [],
            'configuration' => $invalidConfiguration
        ];
        $this->subject->setArguments($arguments);
        $this->subject->expects($this->once())
            ->method('hasArgument')
            ->with('configuration')
            ->willReturn(true);
        $this->subject->render();
    }
}
