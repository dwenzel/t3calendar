<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Calendar',
    'description' => 'Calendar',
    'category' => 'plugin',
    'version' => '0.7.2',
    'state' => 'beta',
    'clearcacheonload' => 1,
    'author' => 'Dirk Wenzel',
    'author_email' => 't3events@gmx.de',
    'constraints' =>
        [
            'depends' =>
                ['typo3' => '11.5.0-11.5.99'],
            'conflicts' =>
                [],
            'suggests' =>
                []
        ],
];

