<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3calendar".
 *
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Calendar',
    'description' => 'Calendar',
    'category' => 'plugin',
    'version' => '0.1.0-dev',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearcacheonload' => 0,
    'author' => 'Dirk Wenzel',
    'author_email' => 't3events@gmx.de',
    'constraints' =>
        array(
            'depends' =>
                array(
                    'typo3' => '6.2.0-8.99.99',
                    'php' => '5.5.0-0.0.0',
                ),
            'conflicts' =>
                [],
            'suggests' =>
                [],
        ),
    '_md5_values_when_last_written' => 'foo',
);
