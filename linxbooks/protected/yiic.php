<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = __DIR__ . '/config/console.php';

Yii::createApplication(\CConsoleApplication::class, $config);
Yii::app()->commandRunner->addCommands(YII_PATH.'/cli/commands');
Yii::app()->run();
