<?php

namespace DWenzel\T3calendar\Tests\Unit\ViewHelpers\Format;

use DWenzel\T3calendar\ViewHelpers\Format\DateViewHelper;
use Nimut\TestingFramework\TestCase\UnitTestCase;

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
class DateViewHelperTest extends UnitTestCase
{
    /**
     * @var DateViewHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getMock(DateViewHelper::class, ['renderChildren']);
    }

    /**
     * @test
     */
    public function renderReturnsDateTimeFormattedWithDefaultFormat()
    {
        unset($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);
        $date = new \DateTime();

        $expectedString = $date->format(DateViewHelper::DEFAULT_DATE_FORMAT);

        $this->assertSame(
            $expectedString,
            $this->subject->render($date)
        );
    }

    /**
     * @test
     */
    public function renderReturnsDateTimeFormattedWithFormatFromGlobals()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy'] = 'd.m.Y';

        $date = new \DateTime();

        $expectedString = $date->format($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);

        $this->assertSame(
            $expectedString,
            $this->subject->render($date)
        );
    }

    /**
     * @test
     */
    public function renderReturnsDateTimeFormattedWithFormatFromArgument()
    {
        $format = 'Y/m/d';
        $date = new \DateTime();

        $expectedString = $date->format($format);

        $this->assertSame(
            $expectedString,
            $this->subject->render($date, $format)
        );
    }

    /**
     * @test
     * @expectedException \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @expectedExceptionCode 1241722579
     */
    public function renderThrowsExceptionForInvalidRenderChildrenResult()
    {
        $renderChildrenResult = 'foo';
        $this->subject->expects($this->once())
            ->method('renderChildren')
            ->will($this->returnValue($renderChildrenResult));
        $this->assertSame(
            $renderChildrenResult,
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function renderReturnsResultForValidRenderChildrenResult()
    {
        unset($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);
        $renderChildrenResult = '2016-01-01';
        $expectedDateTime = new \DateTime(
            $renderChildrenResult,
            new \DateTimeZone(date_default_timezone_get())
        );

        $this->subject->expects($this->once())
            ->method('renderChildren')
            ->will($this->returnValue($renderChildrenResult));
        $this->assertSame(
            $expectedDateTime->format(DateViewHelper::DEFAULT_DATE_FORMAT),
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function renderReturnsEmptyStringIfRenderChildrenResultIsNull()
    {
        $renderChildrenResult = null;
        $expectedResult = '';

        $this->subject->expects($this->once())
            ->method('renderChildren')
            ->will($this->returnValue($renderChildrenResult));

        $this->assertSame(
            $expectedResult,
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function renderReturnsResultNowIfRenderChildrenResultIsEmptyString()
    {
        unset($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);
        $renderChildrenResult = '';
        $expectedDateTime = new \DateTime(
            'now',
            new \DateTimeZone(date_default_timezone_get())
        );

        $this->subject->expects($this->once())
            ->method('renderChildren')
            ->will($this->returnValue($renderChildrenResult));
        $this->assertSame(
            $expectedDateTime->format(DateViewHelper::DEFAULT_DATE_FORMAT),
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function renderReturnsResultNowIfArgumentDateIsEmptyString()
    {
        $date = '';
        unset($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);
        $expectedDateTime = new \DateTime(
            'now',
            new \DateTimeZone(date_default_timezone_get())
        );

        $this->subject->expects($this->never())
            ->method('renderChildren');
        $this->assertSame(
            $expectedDateTime->format(DateViewHelper::DEFAULT_DATE_FORMAT),
            $this->subject->render($date)
        );
    }

    /**
     * @test
     */
    public function renderReturnsStrftimeFormattedValue()
    {
        $format = '%a';
        $date = 12345;
        $expectedValue = strftime($format, $date);

        $this->assertSame(
            $expectedValue,
            $this->subject->render($date, $format)
        );
    }

    /**
     * @test
     */
    public function renderAddsTimeFromArgument()
    {
        $format = 'Y-m-d h:m';
        $date = new \DateTime('today');
        $time = 3600;
        $expectedDate = clone($date);
        $expectedDate->setTimestamp($expectedDate->getTimestamp() + $time);

        $this->assertSame(
            $expectedDate->format($format),
            $this->subject->render($date, $format, $time)
        );
    }

    /**
     * @test
     */
    public function renderInterpretsRelativeDateWithBase()
    {
        $format = 'Y-m-d h:m';
        $date = '+ 6 days';
        $time = null;
        $base = new \DateTime('today');
        $timeStamp = strtotime($date, $base->format('U'));
        $expectedDate = new \DateTime();
        $expectedDate->setTimestamp($timeStamp);

        $this->assertSame(
            $expectedDate->format($format),
            $this->subject->render($date, $format, $time, $base)
        );
    }
}
