<?php

include("Template.php");

$engine = new Template('extra.tmpl');
$engine->setVar('Name','Abdallah');
$engine->setVar('Stuff', array(
    [
        'Thing' => 'roses',
        'Desc' => 'red'
    ],
    [
        'Thing' => 'violets',
        'Desc' => 'blue'
    ],
    [
        'Thing' => 'you',
        'Desc' => 'able to solve this'
    ],
    [
        'Thing' => 'we',
        'Desc' => 'interested in you'
    ],
));
$engine->render();
