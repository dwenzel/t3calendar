<?php

namespace DWenzel\T3calendar\Tests\Unit\Utility;

use DWenzel\T3calendar\Utility\TemplateUtility;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Class TemplateUtilityTest
 */
class TemplateUtilityTest extends UnitTestCase
{
    /**
     * @var TemplateUtility |\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * set up the subject
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(TemplateUtility::class)
            ->setMethods(['dummy'])->getMock();
    }

    /**
     * @test
     */
    public function getDefaultPartialRootPathReturnsDefaultValue()
    {
        $extensionName = 't3calendar';
        $expectedValue = [
            ExtensionManagementUtility::extPath($extensionName) . TemplateUtility::RESOURCES_PATH . TemplateUtility::PARTIAL_PATH_SEGMENT
        ];

        $this->assertSame(
            $expectedValue,
            $this->subject->getDefaultPartialRootPaths($extensionName)
        );
    }

    /**
     * @test
     */
    public function getPathsInitiallyReturnsEmptyArray()
    {
        $config = [];
        $propertyName = 'foo';
        $this->assertSame(
            [],
            $this->subject->getPaths($config, $propertyName)
        );
    }

    /**
     * @test
     */
    public function getPathsReturnsPropertiesSortedByKeyDescending()
    {
        $propertyName = 'foo';
        $configuration = [
            $propertyName => [
                10 => 'foo',
                20 => 'bar',
            ]
        ];

        $expectedValue = [
            20 => 'bar',
            10 => 'foo'
        ];

        $this->assertSame(
            $expectedValue,
            $this->subject->getPaths($configuration, $propertyName)
        );
    }

    /**
     * @test
     */
    public function getPathsReturnsAddsValueForDeprecatedKey(){
        $propertyName = 'foo';
        $deprecatedKey = 'boom';
        $configuration = [
            $propertyName => [
                10 => 'bar',
            ],
            $deprecatedKey => 'baz'
        ];

        $expectedValue = [
            10 => 'bar',
            11 => 'baz'
        ];

        $this->assertSame(
            $expectedValue,
            $this->subject->getPaths($configuration, $propertyName, $deprecatedKey)
        );
    }

    /**
     * @test
     */
    public function configureTemplatePathsSetsFallbackTemplateRootPathsFromView()
    {
        $templateRootPathsFromView = ['foo'];
        $configuration = [];
        /** @var ViewInterface |\PHPUnit_Framework_MockObject_MockObject $view */
        $view = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(['getTemplateRootPaths', 'setTemplateRootPath'])
            ->getMockForAbstractClass();
        $view->expects($this->once())
            ->method('getTemplateRootPaths')
            ->willReturn($templateRootPathsFromView);

        $this->subject->configureTemplatePaths($view, $configuration);
    }

    /**
     * @test
     */
    public function configureTemplatePathsSetsFallbackPartialRootPaths()
    {
        $configuration = [];
        $expectedPartialPaths = $this->subject->getDefaultPartialRootPaths('t3calendar');

        /** @var ViewInterface |\PHPUnit_Framework_MockObject_MockObject $view */
        $view = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(['setPartialRootPaths'])
            ->getMockForAbstractClass();

        $view->expects($this->once())
            ->method('setPartialRootPaths')
            ->with($expectedPartialPaths);

        $this->subject->configureTemplatePaths($view, $configuration);
    }

    /**
     * @test
     */
    public function configureTemplatePathsAddsAdditionalPathsFromConfiguration(){
        $configuration = [
            'templateRootPaths' => [
                10 => 'templatePathFromConfig'
            ],
            'partialRootPaths' => [
                20 => 'partialPathFromConfig'
            ]
        ];
        $fallbackPartialPaths = $this->subject->getDefaultPartialRootPaths('t3calendar');
        $templateRootPathsFromView = ['foo'];

        $expectedTemplatePaths = [
            0 =>$templateRootPathsFromView[0],
            10 => $configuration['templateRootPaths'][10],
        ];
        $expectedPartialPaths = [
            0 => $fallbackPartialPaths[0],
            20 => $configuration['partialRootPaths'][20]
        ];

        /** @var ViewInterface |\PHPUnit_Framework_MockObject_MockObject $view */
        $view = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(
                [
                    'getTemplateRootPaths',
                    'setPartialRootPaths',
                    'setTemplateRootPaths']
            )->getMockForAbstractClass();

        $view->expects($this->once())
            ->method('getTemplateRootPaths')
            ->willReturn($templateRootPathsFromView);

        $view->expects($this->once())
            ->method('setPartialRootPaths')
            ->with($expectedPartialPaths);

        $view->expects($this->once())
            ->method('setTemplateRootPaths')
            ->with($expectedTemplatePaths);

        $this->subject->configureTemplatePaths($view, $configuration);
    }
}
