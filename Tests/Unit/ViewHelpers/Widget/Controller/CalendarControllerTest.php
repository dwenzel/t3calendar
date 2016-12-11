<?php
namespace DWenzel\T3calendar\Tests\ViewHelpers\Widget\Controller;

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

use DWenzel\T3calendar\Domain\Factory\CalendarFactory;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfigurationFactoryInterface;
use DWenzel\T3calendar\ViewHelpers\Widget\Controller\CalendarController;
use TYPO3\CMS\Core\Tests\AccessibleObjectInterface;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class CalendarControllerTest
 * @package DWenzel\T3calendar\Tests\ViewHelpers\Widget\Controller
 */
class CalendarControllerTest extends UnitTestCase
{
    /**
     * @var CalendarController|\PHPUnit_Framework_MockObject_MockObject|AccessibleObjectInterface
     */
    protected $subject;

    /**
     * @var ViewInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $view;

    /**
     * @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;

    /**
     * @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configuration;

    /**
     * @var CalendarConfigurationFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarFactory;

    /**
     * @var array
     */
    protected $objects = [];

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarController::class, ['dummy']
        );
        $this->view = $this->getMock(ViewInterface::class);
        $this->subject->_set('view', $this->view);
        $this->configuration = $this->getMock(CalendarConfiguration::class, ['getDisplayPeriod']);
        $this->subject->_set('configuration', $this->configuration);
        $this->objectManager = $this->getMock(ObjectManagerInterface::class);
        $this->subject->injectObjectManager($this->objectManager);
        $this->calendarFactory = $this->getMock(
            CalendarFactory::class, ['create']
        );
        $this->calendarFactory->method('create')->will($this->returnValue($this->configuration));
        $this->subject->injectCalendarFactory($this->calendarFactory);
        $this->subject->_set('objects', $this->objects);

    }

    /**
     * @test
     */
    public function initializeActionSetsObjectsFromWidgetConfiguration()
    {
        $objects = $this->getMock(QueryResultInterface::class);
        $widgetConfiguration = [
            'objects' => $objects
        ];
        $this->subject->_set('widgetConfiguration', $widgetConfiguration);
        $this->subject->initializeAction();
        $this->assertAttributeSame(
            $objects,
            'objects',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function initializeActionSetsConfigurationFromWidgetConfiguration()
    {
        $configuration = $this->getMock(CalendarConfiguration::class);
        $widgetConfiguration = [
            'configuration' => $configuration
        ];
        $this->subject->_set('widgetConfiguration', $widgetConfiguration);
        $this->subject->initializeAction();
        $this->assertAttributeSame(
            $configuration,
            'configuration',
            $this->subject
        );
    }


    /**
     * @test
     */
    public function initializeActionSetsIdFromWidgetId()
    {
        $id = 'foo';
        $widgetConfiguration = [
            'id' => $id
        ];
        $this->subject->_set('widgetConfiguration', $widgetConfiguration);
        $this->subject->initializeAction();
        $this->assertAttributeSame(
            $id,
            'id',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function indexActionGetsCalendarFromFactory()
    {
        $this->calendarFactory->expects($this->once())
            ->method('create')
            ->with($this->configuration, $this->objects);
        $this->subject->indexAction();
    }

    /**
     * @test
     */
    public function indexActionAssignsVariablesToView()
    {
        $this->view->expects($this->once())
            ->method('assignMultiple');

        $this->subject->indexAction();

    }
}
