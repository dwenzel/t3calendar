<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3calendar".
 *
 * Auto generated 30-12-2016 21:10
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Calendar',
  'description' => 'Calendar',
  'category' => 'plugin',
  'version' => '0.1.1',
  'state' => 'beta',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearcacheonload' => 0,
  'author' => 'Dirk Wenzel',
  'author_email' => 't3events@gmx.de',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '6.2.0-8.99.99',
      'php' => '5.5.0-0.0.0',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  '_md5_values_when_last_written' => 'a:80:{s:9:"ChangeLog";s:4:"ae7c";s:9:"README.md";s:4:"7124";s:13:"composer.json";s:4:"f657";s:17:"ext_localconf.php";s:4:"7232";s:14:"ext_tables.php";s:4:"aa09";s:35:"Classes/Cache/CacheManagerTrait.php";s:4:"166d";s:45:"Classes/Domain/Factory/CalendarDayFactory.php";s:4:"4838";s:54:"Classes/Domain/Factory/CalendarDayFactoryInterface.php";s:4:"fe3b";s:50:"Classes/Domain/Factory/CalendarDayFactoryTrait.php";s:4:"cf5d";s:42:"Classes/Domain/Factory/CalendarFactory.php";s:4:"7d4e";s:51:"Classes/Domain/Factory/CalendarFactoryInterface.php";s:4:"1a85";s:47:"Classes/Domain/Factory/CalendarFactoryTrait.php";s:4:"c612";s:47:"Classes/Domain/Factory/CalendarMonthFactory.php";s:4:"6c3b";s:56:"Classes/Domain/Factory/CalendarMonthFactoryInterface.php";s:4:"dee9";s:52:"Classes/Domain/Factory/CalendarMonthFactoryTrait.php";s:4:"1b50";s:49:"Classes/Domain/Factory/CalendarQuarterFactory.php";s:4:"1e26";s:58:"Classes/Domain/Factory/CalendarQuarterFactoryInterface.php";s:4:"412e";s:54:"Classes/Domain/Factory/CalendarQuarterFactoryTrait.php";s:4:"287d";s:46:"Classes/Domain/Factory/CalendarWeekFactory.php";s:4:"0020";s:55:"Classes/Domain/Factory/CalendarWeekFactoryInterface.php";s:4:"c03a";s:51:"Classes/Domain/Factory/CalendarWeekFactoryTrait.php";s:4:"502d";s:46:"Classes/Domain/Factory/CalendarYearFactory.php";s:4:"4353";s:55:"Classes/Domain/Factory/CalendarYearFactoryInterface.php";s:4:"28af";s:51:"Classes/Domain/Factory/CalendarYearFactoryTrait.php";s:4:"1ea2";s:45:"Classes/Domain/Factory/ObjectManagerTrait.php";s:4:"99b2";s:33:"Classes/Domain/Model/Calendar.php";s:4:"b188";s:36:"Classes/Domain/Model/CalendarDay.php";s:4:"39e1";s:46:"Classes/Domain/Model/CalendarItemInterface.php";s:4:"2189";s:38:"Classes/Domain/Model/CalendarMonth.php";s:4:"e512";s:40:"Classes/Domain/Model/CalendarQuarter.php";s:4:"3b04";s:37:"Classes/Domain/Model/CalendarWeek.php";s:4:"6673";s:37:"Classes/Domain/Model/CalendarYear.php";s:4:"35a1";s:50:"Classes/Domain/Model/Dto/CalendarConfiguration.php";s:4:"cf9d";s:57:"Classes/Domain/Model/Dto/CalendarConfigurationFactory.php";s:4:"a19e";s:66:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryInterface.php";s:4:"a615";s:62:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryTrait.php";s:4:"de9d";s:49:"Classes/ViewHelpers/Widget/CalendarViewHelper.php";s:4:"9d2d";s:60:"Classes/ViewHelpers/Widget/Controller/CalendarController.php";s:4:"5ec3";s:38:"Configuration/TypoScript/constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/setup.txt";s:4:"5a91";s:44:"Resources/Private/Partials/Calendar/Day.html";s:4:"12e8";s:46:"Resources/Private/Partials/Calendar/Month.html";s:4:"abab";s:53:"Resources/Private/Partials/Calendar/PeriodSwitch.html";s:4:"7c89";s:48:"Resources/Private/Partials/Calendar/Quarter.html";s:4:"789a";s:45:"Resources/Private/Partials/Calendar/Week.html";s:4:"7cb9";s:45:"Resources/Private/Partials/Calendar/Year.html";s:4:"5032";s:64:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Day.html";s:4:"eda7";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Index.html";s:4:"4dfe";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Month.html";s:4:"dbf6";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Quarter.html";s:4:"1806";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Week.html";s:4:"03fd";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Year.html";s:4:"997d";s:33:"Resources/Public/CSS/calendar.css";s:4:"1787";s:39:"Resources/Public/JavaScript/calendar.js";s:4:"6a76";s:43:"Resources/Public/JavaScript/jquery-2.1.4.js";s:4:"d64c";s:25:"Tests/Build/UnitTests.xml";s:4:"c970";s:42:"Tests/Unit/Cache/CacheManagerTraitTest.php";s:4:"11a9";s:52:"Tests/Unit/Domain/Factory/CalendarDayFactoryTest.php";s:4:"3c14";s:57:"Tests/Unit/Domain/Factory/CalendarDayFactoryTraitTest.php";s:4:"f1b6";s:49:"Tests/Unit/Domain/Factory/CalendarFactoryTest.php";s:4:"4a2e";s:54:"Tests/Unit/Domain/Factory/CalendarFactoryTraitTest.php";s:4:"56fa";s:54:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTest.php";s:4:"139a";s:59:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTraitTest.php";s:4:"a9ab";s:56:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTest.php";s:4:"d42f";s:61:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTraitTest.php";s:4:"61b6";s:53:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTest.php";s:4:"92c9";s:58:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTraitTest.php";s:4:"526d";s:53:"Tests/Unit/Domain/Factory/CalendarYearFactoryTest.php";s:4:"720e";s:58:"Tests/Unit/Domain/Factory/CalendarYearFactoryTraitTest.php";s:4:"2f1f";s:43:"Tests/Unit/Domain/Model/CalendarDayTest.php";s:4:"6aa8";s:45:"Tests/Unit/Domain/Model/CalendarMonthTest.php";s:4:"fcc4";s:47:"Tests/Unit/Domain/Model/CalendarQuarterTest.php";s:4:"4793";s:40:"Tests/Unit/Domain/Model/CalendarTest.php";s:4:"29bb";s:44:"Tests/Unit/Domain/Model/CalendarWeekTest.php";s:4:"88f1";s:44:"Tests/Unit/Domain/Model/CalendarYearTest.php";s:4:"74e2";s:64:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTest.php";s:4:"af2d";s:69:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTraitTest.php";s:4:"b247";s:57:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationTest.php";s:4:"d3e1";s:56:"Tests/Unit/ViewHelpers/Widget/CalendarViewHelperTest.php";s:4:"756e";s:67:"Tests/Unit/ViewHelpers/Widget/Controller/CalendarControllerTest.php";s:4:"38f2";}',
);

