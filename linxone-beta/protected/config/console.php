<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
require_once(dirname(__FILE__).'/../config/db.php');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
        'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.commands.*',
		'application.modules.lbCustomer.models.*',
		'application.modules.lbCustomerAddress.models.*',
		'application.modules.lbCustomerContact.models.*',
		'application.modules.lbInvoice.models.*',
                'application.modules.lbPayment.models.*',
                'application.modules.lbQuotation.models.*',
                'application.modules.lbContract.models.*',
                'application.modules.lbComment.models.*',
        ),
	// application components
	'components'=>array(
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		'db'=>array(
			'connectionString' => $dbConfig['connectionString'],
			'emulatePrepare' => true,
			'username' => $dbConfig['username'],
			'password' => $dbConfig['password'],
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);
