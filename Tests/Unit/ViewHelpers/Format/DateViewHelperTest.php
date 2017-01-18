<?php

namespace DWenzel\T3calendar\Tests\Unit\ViewHelpers\Format;
use DWenzel\T3calendar\ViewHelpers\Format\DateViewHelper;
use TYPO3\CMS\Core\Tests\UnitTestCase;


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
        $this->subject = $this->getMock(DateViewHelper::class, ['dummy']);
    }

    /**
     * @test
     */
    public function renderReturnsDateTimeFormattedWithDefaultFormat()
    {
        unset($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy']);
        $defaultFormat = 'Y-m-d';
        $date = new \DateTime();

        $expectedString = $date->format($defaultFormat);

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
}