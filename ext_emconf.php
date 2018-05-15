<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3calendar".
 *
 * Auto generated 28-08-2017 09:14
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Calendar',
  'description' => 'Calendar',
  'category' => 'plugin',
  'version' => '0.6.0',
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
      'typo3' => '8.7.0-9.1.99'
    ),
    'conflicts' =>
    array (
    ),
    'suggests' =>
    array (
    ),
  ),
  '_md5_values_when_last_written' => 'a:101:{s:9:"ChangeLog";s:4:"88f0";s:9:"README.md";s:4:"189d";s:13:"composer.json";s:4:"66b4";s:21:"ext_conf_template.txt";s:4:"9b13";s:17:"ext_localconf.php";s:4:"399b";s:14:"ext_tables.php";s:4:"0ba8";s:35:"Classes/Cache/CacheManagerTrait.php";s:4:"166d";s:45:"Classes/Domain/Factory/CalendarDayFactory.php";s:4:"1d9d";s:54:"Classes/Domain/Factory/CalendarDayFactoryInterface.php";s:4:"a602";s:50:"Classes/Domain/Factory/CalendarDayFactoryTrait.php";s:4:"bca5";s:42:"Classes/Domain/Factory/CalendarFactory.php";s:4:"26ab";s:51:"Classes/Domain/Factory/CalendarFactoryInterface.php";s:4:"0909";s:47:"Classes/Domain/Factory/CalendarFactoryTrait.php";s:4:"212f";s:47:"Classes/Domain/Factory/CalendarMonthFactory.php";s:4:"febb";s:56:"Classes/Domain/Factory/CalendarMonthFactoryInterface.php";s:4:"9cdf";s:52:"Classes/Domain/Factory/CalendarMonthFactoryTrait.php";s:4:"0b14";s:49:"Classes/Domain/Factory/CalendarQuarterFactory.php";s:4:"9b0f";s:58:"Classes/Domain/Factory/CalendarQuarterFactoryInterface.php";s:4:"062c";s:54:"Classes/Domain/Factory/CalendarQuarterFactoryTrait.php";s:4:"287d";s:46:"Classes/Domain/Factory/CalendarWeekFactory.php";s:4:"165c";s:55:"Classes/Domain/Factory/CalendarWeekFactoryInterface.php";s:4:"c03a";s:51:"Classes/Domain/Factory/CalendarWeekFactoryTrait.php";s:4:"b820";s:46:"Classes/Domain/Factory/CalendarYearFactory.php";s:4:"519f";s:55:"Classes/Domain/Factory/CalendarYearFactoryInterface.php";s:4:"28af";s:51:"Classes/Domain/Factory/CalendarYearFactoryTrait.php";s:4:"1ea2";s:45:"Classes/Domain/Factory/ObjectManagerTrait.php";s:4:"1faa";s:33:"Classes/Domain/Model/Calendar.php";s:4:"b188";s:36:"Classes/Domain/Model/CalendarDay.php";s:4:"2b7c";s:46:"Classes/Domain/Model/CalendarItemInterface.php";s:4:"aaf2";s:38:"Classes/Domain/Model/CalendarMonth.php";s:4:"e208";s:40:"Classes/Domain/Model/CalendarQuarter.php";s:4:"281d";s:37:"Classes/Domain/Model/CalendarWeek.php";s:4:"8fdb";s:37:"Classes/Domain/Model/CalendarYear.php";s:4:"f978";s:35:"Classes/Domain/Model/MonthTrait.php";s:4:"e7bb";s:39:"Classes/Domain/Model/StartDateTrait.php";s:4:"f36c";s:50:"Classes/Domain/Model/Dto/CalendarConfiguration.php";s:4:"3cbc";s:57:"Classes/Domain/Model/Dto/CalendarConfigurationFactory.php";s:4:"2172";s:66:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryInterface.php";s:4:"6849";s:62:"Classes/Domain/Model/Dto/CalendarConfigurationFactoryTrait.php";s:4:"594f";s:43:"Classes/Persistence/CalendarItemStorage.php";s:4:"7008";s:35:"Classes/Utility/TemplateUtility.php";s:4:"0504";s:45:"Classes/ViewHelpers/Format/DateViewHelper.php";s:4:"de9c";s:49:"Classes/ViewHelpers/Widget/CalendarViewHelper.php";s:4:"9f5e";s:60:"Classes/ViewHelpers/Widget/Controller/CalendarController.php";s:4:"6c47";s:38:"Configuration/TypoScript/constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/setup.txt";s:4:"5a91";s:29:"Documentation/Introduction.md";s:4:"7ce7";s:39:"Documentation/Configuration/Calendar.md";s:4:"a7f5";s:36:"Documentation/Configuration/Paths.md";s:4:"356f";s:55:"Documentation/DevelopersManual/CalendarConfiguration.md";s:4:"dd48";s:41:"Documentation/Images/comboViewQuarter.png";s:4:"2b79";s:38:"Documentation/Images/comboViewYear.png";s:4:"b9c5";s:34:"Documentation/Images/monthView.png";s:4:"5f60";s:34:"Documentation/UsersManual/Cache.md";s:4:"4e09";s:40:"Documentation/ViewHelpers/ViewHelpers.md";s:4:"c185";s:50:"Documentation/ViewHelpers/Format/DateViewHelper.md";s:4:"415f";s:54:"Documentation/ViewHelpers/Widget/CalendarViewHelper.md";s:4:"c844";s:44:"Resources/Private/Partials/Calendar/Day.html";s:4:"0b1e";s:45:"Resources/Private/Partials/Calendar/Item.html";s:4:"408d";s:46:"Resources/Private/Partials/Calendar/Month.html";s:4:"d4b0";s:53:"Resources/Private/Partials/Calendar/PeriodSwitch.html";s:4:"52be";s:48:"Resources/Private/Partials/Calendar/Quarter.html";s:4:"71f5";s:45:"Resources/Private/Partials/Calendar/Week.html";s:4:"d97c";s:45:"Resources/Private/Partials/Calendar/Year.html";s:4:"05d4";s:64:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Day.html";s:4:"f29f";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Index.html";s:4:"e4ab";s:66:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Month.html";s:4:"ede8";s:68:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Quarter.html";s:4:"66be";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Week.html";s:4:"82e0";s:65:"Resources/Private/Templates/ViewHelpers/Widget/Calendar/Year.html";s:4:"43d8";s:33:"Resources/Public/CSS/calendar.css";s:4:"fe40";s:39:"Resources/Public/JavaScript/calendar.js";s:4:"68fc";s:43:"Resources/Public/JavaScript/jquery-2.1.4.js";s:4:"d64c";s:25:"Tests/Build/UnitTests.xml";s:4:"2f36";s:42:"Tests/Unit/Cache/CacheManagerTraitTest.php";s:4:"22d8";s:52:"Tests/Unit/Domain/Factory/CalendarDayFactoryTest.php";s:4:"18c3";s:57:"Tests/Unit/Domain/Factory/CalendarDayFactoryTraitTest.php";s:4:"b289";s:49:"Tests/Unit/Domain/Factory/CalendarFactoryTest.php";s:4:"ec97";s:54:"Tests/Unit/Domain/Factory/CalendarFactoryTraitTest.php";s:4:"d54d";s:54:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTest.php";s:4:"d339";s:59:"Tests/Unit/Domain/Factory/CalendarMonthFactoryTraitTest.php";s:4:"d1a5";s:56:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTest.php";s:4:"0503";s:61:"Tests/Unit/Domain/Factory/CalendarQuarterFactoryTraitTest.php";s:4:"210b";s:53:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTest.php";s:4:"6825";s:58:"Tests/Unit/Domain/Factory/CalendarWeekFactoryTraitTest.php";s:4:"1bdc";s:53:"Tests/Unit/Domain/Factory/CalendarYearFactoryTest.php";s:4:"de24";s:58:"Tests/Unit/Domain/Factory/CalendarYearFactoryTraitTest.php";s:4:"5765";s:43:"Tests/Unit/Domain/Model/CalendarDayTest.php";s:4:"09a0";s:45:"Tests/Unit/Domain/Model/CalendarMonthTest.php";s:4:"8a9a";s:47:"Tests/Unit/Domain/Model/CalendarQuarterTest.php";s:4:"7615";s:40:"Tests/Unit/Domain/Model/CalendarTest.php";s:4:"6b23";s:44:"Tests/Unit/Domain/Model/CalendarWeekTest.php";s:4:"84fa";s:44:"Tests/Unit/Domain/Model/CalendarYearTest.php";s:4:"8c39";s:64:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTest.php";s:4:"a8b6";s:69:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationFactoryTraitTest.php";s:4:"3c18";s:57:"Tests/Unit/Domain/Model/Dto/CalendarConfigurationTest.php";s:4:"151f";s:50:"Tests/Unit/Persistence/CalendarItemStorageTest.php";s:4:"7327";s:42:"Tests/Unit/Utility/TemplateUtilityTest.php";s:4:"8c90";s:52:"Tests/Unit/ViewHelpers/Format/DateViewHelperTest.php";s:4:"fc93";s:56:"Tests/Unit/ViewHelpers/Widget/CalendarViewHelperTest.php";s:4:"82a6";s:67:"Tests/Unit/ViewHelpers/Widget/Controller/CalendarControllerTest.php";s:4:"bc83";}',
);

