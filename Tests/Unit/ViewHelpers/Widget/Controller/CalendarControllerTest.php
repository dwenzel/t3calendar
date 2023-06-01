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
use DWenzel\T3calendar\Domain\Factory\CalendarFactoryInterface;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfigurationFactory;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfigurationFactoryInterface;
use DWenzel\T3calendar\Utility\TemplateUtility;
use DWenzel\T3calendar\ViewHelpers\Widget\Controller\CalendarController;
use Nimut\TestingFramework\MockObject\AccessibleMockObjectInterface;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\Core\Widget\WidgetContext;
use TYPO3\CMS\Fluid\Core\Widget\WidgetRequest;

/**
 * Class CalendarControllerTest
 * @package DWenzel\T3calendar\Tests\ViewHelpers\Widget\Controller
 */
class CalendarControllerTest extends UnitTestCase
{
    /**
     * @var CalendarController|\PHPUnit_Framework_MockObject_MockObject|AccessibleMockObjectInterface
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
     * @var TemplateUtility | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $templateUtility;

    /**
     * @var CalendarFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarFactory;

    /**
     * @var array
     */
    protected $objects = [];

    /**
     * @var CacheManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cacheManager;

    /**
     * @var \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contentCache;

    /**
     * @var RequestInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var WidgetContext | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $widgetContext;

    /**
     * @var ConfigurationManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configurationManager;

    /**
     * @var CalendarConfigurationFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $calendarConfigurationFactory;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            CalendarController::class, ['dummy']
        );
        $this->view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $this->view);
        $this->mockConfiguration();
        /** @var ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject objectManager */
        $this->objectManager = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $this->subject->injectObjectManager($this->objectManager);
        /** @var CalendarFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarFactory */
        $this->calendarFactory = $this->getMockBuilder(CalendarFactory::class)
            ->setMethods(['create'])->getMock();
        $this->calendarFactory->method('create')->will($this->returnValue($this->configuration));
        $this->subject->injectCalendarFactory($this->calendarFactory);
        $this->subject->_set('objects', $this->objects);
        /** @var VariableFrontend|\PHPUnit_Framework_MockObject_MockObject contentCache */
        $this->contentCache = $this->getMockBuilder(VariableFrontend::class)
            ->setMethods(['get', 'set'])
            ->disableOriginalConstructor()->getMock();
        $this->contentCache->expects($this->any())
            ->method('get')
            ->will($this->returnValue(false));
        $this->inject(
            $this->subject,
            'contentCache',
            $this->contentCache
        );
        /** @var CacheManager|\PHPUnit_Framework_MockObject_MockObject cacheManager */
        $this->cacheManager = $this->getMockBuilder(CacheManager::class)
            ->setMethods(['getCache'])->getMock();
        $this->cacheManager->expects($this->any())
            ->method('getCache')
            ->will($this->returnValue($this->contentCache));
        $this->subject->injectCacheManager($this->cacheManager);
        $this->templateUtility = $this->getMockBuilder(TemplateUtility::class)
            ->setMethods(['configureTemplatePaths'])->getMock();
        $this->subject->injectTemplateUtility($this->templateUtility);
        $this->widgetContext = $this->getMockBuilder(WidgetContext::class)
            ->setMethods(['getWidgetViewHelperClassName'])->getMock();
        $this->request = $this->getMockBuilder(WidgetRequest::class)
            ->setMethods(['getWidgetContext'])
            ->getMock();
        $this->inject($this->subject, 'request', $this->request);
        $this->request->expects($this->any())
            ->method('getWidgetContext')
            ->willReturn($this->widgetContext);
        $this->configurationManager = $this->getMockBuilder(ConfigurationManagerInterface::class)
            ->setMethods(['getConfiguration'])->getMockForAbstractClass();
        $this->inject($this->subject, 'configurationManager', $this->configurationManager);
        /** @var CalendarConfigurationFactoryInterface|\PHPUnit_Framework_MockObject_MockObject calendarConfigurationFactory */
        $this->calendarConfigurationFactory = $this->getMockBuilder(CalendarConfigurationFactory::class)
            ->setMethods(['create'])->getMock();
        $this->subject->injectCalendarConfigurationFactory($this->calendarConfigurationFactory);
    }

    /**
     * mocks the configuration
     */
    protected function mockConfiguration()
    {
        /** @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject configuration */
        $this->configuration = $this->getMockBuilder(CalendarConfiguration::class)
            ->setMethods(['getDisplayPeriod', 'setDisplayPeriod'])->getMock();
        $startDate = new \DateTime();
        $this->configuration->setStartDate($startDate);

        $this->subject->_set('configuration', $this->configuration);
    }

    /**
     * @test
     */
    public function templateUtilityCanBeInjected()
    {
        /** @var TemplateUtility|\PHPUnit_Framework_MockObject_MockObject $templateUtility */
        $templateUtility = $this->getMockBuilder(TemplateUtility::class)
            ->getMock();
        $this->subject->injectTemplateUtility($templateUtility);
        $this->assertAttributeSame(
            $templateUtility,
            'templateUtility',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function initializeActionSetsObjectsFromWidgetConfiguration()
    {
        /** @var QueryResultInterface|\PHPUnit_Framework_MockObject_MockObject $objects */
        $objects = $this->getMockBuilder(QueryResultInterface::class)->getMock();
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
        /** @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject $configuration */
        $configuration = $this->getMockBuilder(CalendarConfiguration::class)->getMock();
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
    public function initializeActionSetsParametersFromWidgetConfiguration()
    {
        $parameters = ['foo'];
        $widgetConfiguration = [
            'parameters' => $parameters
        ];
        $this->subject->_set('widgetConfiguration', $widgetConfiguration);
        $this->subject->initializeAction();
        $this->assertAttributeSame(
            $parameters,
            'parameters',
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

    /**
     * @test
     */
    public function dayActionSetsDisplayPeriod()
    {
        $this->configuration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with(CalendarConfiguration::PERIOD_DAY);

        $this->subject->dayAction();
    }

    /**
     * @test
     */
    public function dayActionSetsDefaultStartDateToday()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('today', $timeZone);
        $this->subject->dayAction();

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * provides valid shift and origin arguments for dayAction
     * @return array
     */
    public function dayActionShiftOriginDataProvider()
    {
        return [
            [1_234_567, 'next', 'P1D', false],
            [1_234_567, 'previous', 'P1D', true]
        ];
    }

    /**
     * @test
     * @dataProvider dayActionShiftOriginDataProvider
     * @param int $origin
     * @param string $shift
     * @param string $interval Interval spec
     * @param bool $invertInterval
     */
    public function dayActionAdjustsStartDateByShiftAndOrigin($origin, $shift, $interval, $invertInterval)
    {
        $expectedInterval = new \DateInterval($interval);
        $expectedInterval->invert = $invertInterval;
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('@' . $origin, $timeZone);
        $expectedStartDate->add($expectedInterval);

        $this->subject->dayAction($shift, $origin);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function dayActionSetsDefaultStartDateForInvalidShift()
    {
        $invalidShift = 'foo';

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('today', $timeZone);
        $this->subject->dayAction($invalidShift);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function weekActionSetsDisplayPeriod()
    {
        $this->configuration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with(CalendarConfiguration::PERIOD_WEEK);

        $this->subject->weekAction();
    }

    /**
     * @test
     */
    public function weekActionSetsDefaultStartDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('monday this week', $timeZone);
        $this->subject->weekAction();

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function weekActionSetsDefaultStartDateForInvalidShift()
    {
        $invalidShift = 'foo';

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('monday this week', $timeZone);
        $this->subject->weekAction($invalidShift);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * provides valid shift and origin arguments for weekAction
     * @return array
     */
    public function weekActionShiftOriginDataProvider()
    {
        return [
            [1_482_706_800, 'next', 'P1W', false],
            [1_482_706_800, 'previous', 'P1W', true],
        ];
    }

    /**
     * @test
     * @dataProvider weekActionShiftOriginDataProvider
     * @param int $origin
     * @param string $shift
     * @param string $interval Interval spec
     * @param bool $invertInterval
     */
    public function weekActionAdjustsStartDateByShiftAndOrigin($origin, $shift, $interval, $invertInterval)
    {
        $this->configuration->expects($this->atLeast(1))
            ->method('getDisplayPeriod')
            ->will($this->returnValue(CalendarConfiguration::PERIOD_WEEK));
        $expectedInterval = new \DateInterval($interval);
        $expectedInterval->invert = $invertInterval;
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('@' . $origin);
        $expectedStartDate->setTimezone($timeZone);
        $expectedStartDate->add($expectedInterval);

        $this->subject->weekAction($shift, $origin);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function monthActionSetsDisplayPeriod()
    {
        $this->configuration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with(CalendarConfiguration::PERIOD_MONTH);

        $this->subject->monthAction();
    }

    /**
     * @test
     */
    public function monthActionSetsDefaultStartDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('first day of this month 00:00:00', $timeZone);
        $this->subject->monthAction();

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function monthActionSetsDefaultStartDateForInvalidShift()
    {
        $invalidShift = 'foo';

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('first day of this month 00:00:00', $timeZone);
        $this->subject->monthAction($invalidShift);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * provides valid shift and origin arguments for monthAction
     * @return array
     */
    public function monthActionShiftOriginDataProvider()
    {
        return [
            [1_482_706_800, 'next', 'P1M', false],
            [1_482_706_800, 'previous', 'P1M', true],
        ];
    }

    /**
     * @test
     * @dataProvider monthActionShiftOriginDataProvider
     * @param int $origin
     * @param string $shift
     * @param string $interval Interval spec
     * @param bool $invertInterval
     */
    public function monthActionAdjustsStartDateByShiftAndOrigin($origin, $shift, $interval, $invertInterval)
    {
        $this->configuration->expects($this->atLeast(1))
            ->method('getDisplayPeriod')
            ->will($this->returnValue(CalendarConfiguration::PERIOD_MONTH));
        $expectedInterval = new \DateInterval($interval);
        $expectedInterval->invert = $invertInterval;
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('@' . $origin);
        $expectedStartDate->setTimezone($timeZone);
        $expectedStartDate->add($expectedInterval);

        $this->subject->monthAction($shift, $origin);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function yearActionSetsDisplayPeriod()
    {
        $this->configuration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with(CalendarConfiguration::PERIOD_YEAR);

        $this->subject->yearAction();
    }

    /**
     * @test
     */
    public function yearActionSetsDefaultStartDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime(date('Y') . '-01-01', $timeZone);
        $this->subject->yearAction();

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function yearActionSetsDefaultStartDateForInvalidShift()
    {
        $invalidShift = 'foo';

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime(date('Y') . '-01-01', $timeZone);
        $this->subject->yearAction($invalidShift);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * provides valid shift and origin arguments for yearAction
     * @return array
     */
    public function yearActionShiftOriginDataProvider()
    {
        return [
            [1_482_706_800, 'next', 'P1Y', false],
            [1_482_706_800, 'previous', 'P1Y', true],
        ];
    }

    /**
     * @test
     * @dataProvider yearActionShiftOriginDataProvider
     * @param int $origin
     * @param string $shift
     * @param string $interval Interval spec
     * @param bool $invertInterval
     */
    public function yearActionAdjustsStartDateByShiftAndOrigin($origin, $shift, $interval, $invertInterval)
    {
        $this->configuration->expects($this->atLeast(1))
            ->method('getDisplayPeriod')
            ->will($this->returnValue(CalendarConfiguration::PERIOD_YEAR));
        $expectedInterval = new \DateInterval($interval);
        $expectedInterval->invert = $invertInterval;
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('@' . $origin);
        $expectedStartDate->setTimezone($timeZone);
        $expectedStartDate->add($expectedInterval);

        $this->subject->yearAction($shift, $origin);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }
    //

    /**
     * @test
     */
    public function quarterActionSetsDisplayPeriod()
    {
        $this->configuration->expects($this->once())
            ->method('setDisplayPeriod')
            ->with(CalendarConfiguration::PERIOD_QUARTER);

        $this->subject->quarterAction();
    }

    /**
     * @test
     */
    public function quarterActionSetsDefaultStartDate()
    {
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $dateString = date(sprintf('Y-%s-01', floor((date('n') - 1) / 3) * 3 + 1));
        $expectedStartDate = new \DateTime($dateString, $timeZone);
        $this->subject->quarterAction();

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function quarterActionSetsDefaultStartDateForInvalidShift()
    {
        $invalidShift = 'foo';

        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $dateString = date(sprintf('Y-%s-01', floor((date('n') - 1) / 3) * 3 + 1));
        $expectedStartDate = new \DateTime($dateString, $timeZone);
        $this->subject->quarterAction($invalidShift);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * provides valid shift and origin arguments for quarterAction
     * @return array
     */
    public function quarterActionShiftOriginDataProvider()
    {
        return [
            [1_482_706_800, 'next', 'P3M', false],
            [1_482_706_800, 'previous', 'P3M', true],
        ];
    }

    /**
     * @test
     * @dataProvider quarterActionShiftOriginDataProvider
     * @param int $origin
     * @param string $shift
     * @param string $interval Interval spec
     * @param bool $invertInterval
     */
    public function quarterActionAdjustsStartDateByShiftAndOrigin($origin, $shift, $interval, $invertInterval)
    {
        $this->configuration->expects($this->atLeast(1))
            ->method('getDisplayPeriod')
            ->will($this->returnValue(CalendarConfiguration::PERIOD_QUARTER));
        $expectedInterval = new \DateInterval($interval);
        $expectedInterval->invert = $invertInterval;
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        $expectedStartDate = new \DateTime('@' . $origin);
        $expectedStartDate->setTimezone($timeZone);
        $expectedStartDate->add($expectedInterval);

        $this->subject->quarterAction($shift, $origin);

        $this->assertEquals(
            $expectedStartDate,
            $this->configuration->getStartDate()
        );
    }

    /**
     * @test
     */
    public function initializeObjectGetsCalendarCacheFromManager()
    {
        $this->cacheManager->expects($this->once())
            ->method('getCache')
            ->with('t3calendar_content');
        $this->subject->initializeObject();
    }

    /**
     * @test
     */
    public function initializeViewConfiguresTemplatePaths()
    {
        $viewHelperClassName = 'foo';
        $widgetViewHelperConfig = ['baz'];
        $frameWorkConfiguration = [
            'view' => [
                'widget' => [
                    $viewHelperClassName => $widgetViewHelperConfig
                ]
            ]
        ];
        $this->configurationManager->expects($this->once())
            ->method('getConfiguration')
            ->with(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)
            ->willReturn($frameWorkConfiguration);
        $this->widgetContext->expects($this->once())
            ->method('getWidgetViewHelperClassName')
            ->willReturn($viewHelperClassName);

        $view = $this->getMockBuilder(ViewInterface::class)
            ->getMockForAbstractClass();
        $this->templateUtility->expects($this->once())
            ->method('configureTemplatePaths')
            ->willReturn($view, $widgetViewHelperConfig);

        $this->subject->_callRef(
            'initializeView', $view);
    }

    /**
     * @test
     */
    public function initializeActionCreatesConfigurationFromArray()
    {
        $configuration = [];
        $widgetConfiguration = [
            'configuration' => $configuration
        ];
        /** @var CalendarConfiguration|\PHPUnit_Framework_MockObject_MockObject $mockConfiguration */
        $mockConfiguration = $this->getMockBuilder(CalendarConfiguration::class)->getMock();
        $this->subject->_set('widgetConfiguration', $widgetConfiguration);
        $this->calendarConfigurationFactory->expects($this->once())
            ->method('create')
            ->with($configuration)
            ->will($this->returnValue($mockConfiguration));

        $this->subject->initializeAction();

        $this->assertAttributeSame(
            $mockConfiguration,
            'configuration',
            $this->subject
        );
    }
}
