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
use TYPO3\CMS\Core\Tests\AccessibleObjectInterface;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class CalendarViewHelperTest
 * @package DWenzel\T3calendar\Tests\Unit\ViewHelpers\Widget
 */
class CalendarViewHelperTest extends UnitTestCase
{
    /**
     * @var CalendarViewHelper|\PHPUnit_Framework_MockObject_MockObject|AccessibleObjectInterface
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarViewHelper::class, ['hasArgument', 'initiateSubRequest']
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
        $this->subject->expects($this->once())
            ->method('initiateSubRequest');
        $this->subject->render([]);
    }
}