<?php
require_once(dirname(__FILE__).'/../config/db.php');

return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Cron',
		'preload'=>array('log'),
		'import'=>array(
				'application.components.*',
				'application.models.*',
                                'application.commands.*',
				'ext.yii-mail.YiiMailMessage',
		),
		// application components
		'components'=>array(
				'db'=>array(
						'connectionString' => $dbConfig['connectionString'],
						'emulatePrepare' => true,
						'username' => $dbConfig['username'],
						'password' => $dbConfig['password'],
						'charset' => 'utf8',
						'enableProfiling' => true,
				),
				'log'=>array(
						'class'=>'CLogRouter',
						'routes'=>array(
								array(
										'class'=>'CFileLogRoute',
										'logFile'=>'cron.log',
										'levels'=>'error, warning',
								),
								array(
										'class'=>'CFileLogRoute',
										'logFile'=>'cron_trace.log',
										'levels'=>'trace',
								),
						),
				),
				'functions'=>array(
						'class'=>'application.extensions.functions.Functions',
				),
				'mail' => array(
						'class' => 'ext.yii-mail.YiiMail',
						'transportType' => 'smtp', // smtp or php
						
						'transportOptions' => array( // only if use smtp
								'host' => 'yourserver',
								//'encryption' => 'ssl',
								'username' => 'uremail@linxbooks.com',
								'password' => 'yourpass',
								'port' => 25,
						),
						//'viewPath' => 'application.views.mails',
				),
				'user' => array(
						'class' => 'ConsoleUser', // later each cron process will add its own.
						),
		),
);

$yii= dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';
require_once($yii);
Yii::createConsoleApplication($config)->run();
?>
