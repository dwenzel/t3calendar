<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3calendar".
 *
 * Auto generated 12-05-2017 13:32
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Calendar',
  'description' => 'Calendar',
  'category' => 'plugin',
  'version' => '0.4.0',
  'state' => 'beta',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearcacheonload' => 1,
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
  '_md5_values_when_last_written' => 'a:99:{s:9:"ChangeLog";s:4:"bb8f";s:9:"README.md";s:4:"bd65";s:13:"composer.json";s:4:"7526";s:21:"ext_conf_template.txt";s:4:"9b13";s:17:"ext_localconf.php";s:4:"0ddf";s:14:"ext_tables.php";s:4:"aa09";s:35:"Classes/Cache/CacheManagerTrait.php";s:4:"166d";s:45:"Classes/Domain/Factory/CalendarDayFactory.php";s:4:"dcbf";s:54:"Classes/Domain/Factory/CalendarDayFactoryInterface.php";s:4:"fe3b";s:50:"Classes/Domain/Factory/CalendarDayFactoryTrait.php";s:4:"cf5d";s:42:"Classes/Domain/Factory/CalendarFactory.php";s:4:"26ab";s:51:"Classes/Domain/Factory/CalendarFactoryInterface.php";s:4:"1a85";s:47:"Classes/Domain/Factory/CalendarFactoryTrait.php";s:4:"c612";s:47:"Classes/Domain/Factory/CalendarMonthFactory.php";s:4:"febb";s:56:"Classes/Domain/Factory/CalendarMonthFactoryInterface.php";s:4:"dee9";s:52:"Classes/Domain/Factory/CalendarMonthFactoryTrait.php";s:4:"1b50";s:49:"Classes/Domain/Factory/CalendarQuarterFactory.php";s:4:"5966";s:58:"Classes/Domain/Factory/CalendarQuarterFactoryInterface.php";s:4:"412e";s:54:"Classes/Domain/Factory/CalendarQuarterFactoryTrait.php";s:4:"287d";s:46:"Classes/Domain/Factory/CalendarWeekFactory.php";s:4:"b1c1";s:55:"Classes/Domain/Factory/CalendarWeekFactoryInterface.php";s:4:"c03a";s:51:"Classes/Domain/Factory/CalendarWeekFactoryTrait.php";s:4:"502d";s:46:"Classes/Domain/Factory/CalendarYearFactory.php";s:4:"519f";s:55:"Classes/Domain/Factory/CalendarYearFactoryInterface.php";s:4:"28af";s:51:"Classes/Domain/Factory/CalendarYearFactoryTrait.php";s:4:"1ea2";s:45:"Classes/Domain/Factory/ObjectManagerTrait.php";s:4:"99b2";s:33:"Classes/Domain/Model/Calendar.php";s:4:"b188";s:36:"Classes/Domain/Model/CalendarDay.php";s:4:"1a4e";s:46:"Classes/Domain/Model/CalendarItemInterface.php";s:4:"2189";s:38:"Classes/Domain/Model/CalendarMonth.php";s:4:"e512";s:40:"Classes/Domain/Model/CalendarQuarter.php";s:4:"3b04";s:37:"Classes/Domain/Model/CalendarWeek.php";s:4:"6673";s:37:"Classes/Domain/Model/CalendarYear.php";s:4:"35a1";s:50:"Classes/Domain/Model/Dto/CalendarConfiguration.php";s:4:"6cd8";s:57:"Classes/Domain/Model/Dto/CalendarConfigurationFactory.php";s:4:"ef52";s:66:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryInterface.php";s:4:"a615";s:62:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryTrait.php";s:4:"adbb";s:43:"Classes/Persistence/CalendarItemStorage.php";s:4:"7008";s:35:"Classes/Utility/TemplateUtility.php";s:4:"b204";s:45:"Classes/ViewHelpers/Format/DateViewHelper.php";s:4:"de9c";s:49:"Classes/ViewHelpers/Widget/CalendarViewHelper.php";s:4:"cc4c";s:60:"Classes/ViewHelpers/Widget/Controller/CalendarController.php";s:4:"e08e";s:38:"Configuration/TypoScript/constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/setup.txt";s:4:"5a91";s:29:"Documentation/Introduction.md";s:4:"7ce7";s:39:"Documentation/Configuration/Calendar.md";s:4:"a7f5";s:36:"Documentation/Configuration/Paths.md";s:4:"356f";s:55:"Documentation/DevelopersManual/CalendarConfiguration.md";s:4:"c248";s:41:"Documentation/Images/comboViewQuarter.png";s:4:"2b79";s:38:"Documentation/Images/comboViewYear.png";s:4:"b9c5";s:34:"Documentation/Images/monthView.png";s:4:"5f60";s:34:"Documentation/UsersManual/Cache.md";s:4:"4e09";s:40:"Documentation/ViewHelpers/ViewHelpers.md";s:4:"c185";s:50:"Documentation/ViewHelpers/Format/DateViewHelper.md";s:4:"415f";s:54:"Documentation/ViewHelpers/Widget/CalendarViewHelper.md";s:4:"c844";s:44:"Resources/Private/Partials/Calendar/Day.html";s:4:"12e8";s:45:"Resources/Private/Partials/Calendar/Item.html";s:4:"408d";s:46:"Resources/Private/Partials/Calendar/Month.html";s:4:"8e1a";s:53:"Resources/Private/Partials/Calendar/PeriodSwitch.html";s:4:"52be";s:48:"Resources/Private/Partials/Calendar/Quarter.html";s:4:"2cf1";s:45:"Resources/Private/Partials/Calendar/Week.html";s:4:"f0e4";s:45:"Resources/Private/Partials/Calendar/Year.html";s:4:"f003";s:64:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Day.html";s:4:"f29f";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Index.html";s:4:"e4ab";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Month.html";s:4:"ede8";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Quarter.html";s:4:"66be";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Week.html";s:4:"82e0";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Year.html";s:4:"43d8";s:33:"Resources/Public/CSS/calendar.css";s:4:"fe40";s:39:"Resources/Public/JavaScript/calendar.js";s:4:"68fc";s:43:"Resources/Public/JavaScript/jquery-2.1.4.js";s:4:"d64c";s:25:"Tests/Build/UnitTests.xml";s:4:"2f36";s:42:"Tests/Unit/Cache/CacheManagerTraitTest.php";s:4:"22d8";s:52:"Tests/Unit/Domain/Factory/CalendarDayFactoryTest.php";s:4:"1ded";s:57:"Tests/Unit/Domain/Factory/CalendarDayFactoryTraitTest.php";s:4:"056b";s:49:"Tests/Unit/Domain/Factory/CalendarFactoryTest.php";s:4:"3369";s:54:"Tests/Unit/Domain/Factory/CalendarFactoryTraitTest.php";s:4:"8594";s:54:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTest.php";s:4:"d339";s:59:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTraitTest.php";s:4:"c5a9";s:56:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTest.php";s:4:"0503";s:61:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTraitTest.php";s:4:"a648";s:53:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTest.php";s:4:"d587";s:58:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTraitTest.php";s:4:"a890";s:53:"Tests/Unit/Domain/Factory/CalendarYearFactoryTest.php";s:4:"de24";s:58:"Tests/Unit/Domain/Factory/CalendarYearFactoryTraitTest.php";s:4:"6dfb";s:43:"Tests/Unit/Domain/Model/CalendarDayTest.php";s:4:"c9b1";s:45:"Tests/Unit/Domain/Model/CalendarMonthTest.php";s:4:"ad14";s:47:"Tests/Unit/Domain/Model/CalendarQuarterTest.php";s:4:"7615";s:40:"Tests/Unit/Domain/Model/CalendarTest.php";s:4:"4b80";s:44:"Tests/Unit/Domain/Model/CalendarWeekTest.php";s:4:"84fa";s:44:"Tests/Unit/Domain/Model/CalendarYearTest.php";s:4:"8c39";s:64:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTest.php";s:4:"8895";s:69:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTraitTest.php";s:4:"e4bd";s:57:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationTest.php";s:4:"30a0";s:50:"Tests/Unit/Persistence/CalendarItemStorageTest.php";s:4:"6b1a";s:42:"Tests/Unit/Utility/TemplateUtilityTest.php";s:4:"8942";s:52:"Tests/Unit/ViewHelpers/Format/DateViewHelperTest.php";s:4:"68ec";s:56:"Tests/Unit/ViewHelpers/Widget/CalendarViewHelperTest.php";s:4:"82a6";s:67:"Tests/Unit/ViewHelpers/Widget/Controller/CalendarControllerTest.php";s:4:"ab23";}',
);

