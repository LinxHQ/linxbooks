<?php
@ob_start();
@session_start();

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('highcharts', dirname(__FILE__).'/../extensions/yii-highcharts-4.0.4/highcharts');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

define('SUCCESS', 'success');
define('FAILURE', 'failure');
define('APP_NO_PERMISSION', 'noPermission');
define('YES', 1);
define('NO', 0);

require_once(dirname(__FILE__).'/db.php');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LinxBooks',
	'behaviors' => array('AppConfigBehavior'),
         'defaultController' => isset(Yii::app()->user)? LbInvoice::model()->getActionURL('dashboard'):'site/login',
	'theme' => 'bootstrap',
        'language'=>(isset($_SESSION["sess_lang"])) ? $_SESSION["sess_lang"] : "en",

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.commands.*',
		'ext.yii-mail.YiiMailMessage',
		'editable.*',
		'ext.xupload.models.*',
		'application.modules.lbCustomer.models.*',
		'application.modules.lbCustomerAddress.models.*',
		'application.modules.lbCustomerContact.models.*',
		'application.modules.lbInvoice.models.*',
                'application.modules.lbPayment.models.*',
                'application.modules.lbQuotation.models.*',
                'application.modules.lbContract.models.*',
                'application.modules.lbExpenses.models.*',
                'application.modules.lbDocument.models.*',
                'application.modules.lbBankAccount.models.*',
                'application.modules.permission.models.*',
                'application.modules.paypal.models.*',
                'application.modules.process_checklist.models.*',
                'application.modules.process_checklist.controllers.*',
                'application.modules.lbReport.models.*',
                'application.modules.lbVendor.models.*',
                'application.modules.lbComment.models.*',
                'application.modules.lbDocument.models.*',
                'application.modules.lbEmployee.models.*',
		//'ext.ajaxmenu.AjaxMenu',
	),
		
	'aliases' => array(
            //If you used composer your path should be
            'xupload' => 'ext.vendor.asgaroth.xupload',
            //If you manually installed it
            'xupload' => 'ext.xupload'
	),
		
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'woUiMustFail2013',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
		'lbCustomer','lbCustomerAddress',
		'lbCustomerContact','lbInvoice',
                'lbPayment',
                'lbQuotation',
                'lbContract',
                'lbPayment',
                'lbQuotation',
                'lbContract',
                'lbContract',
                'lbExpenses',
                'permission',
                'paypal',
                'lbVendor',
                'process_checklist',
                'lbReport',
                'lbComment',
                'lbDocument',
                'lbEmployee',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
//                       'authTimeout' => 10
		),
		
		'session' => array(
			'class' => 'system.web.CDbHttpSession',
			'timeout' => 60*60*24*254, // never timeout
			'connectionID' => 'db',
		),
			
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'caseSensitive'=>false,
			//'showScriptName' => false,
			'rules'=>array(
				// REST patterns for Web Service API
				/**
				 * E.g:
				 *     	View all posts: index.php/api/posts (HTTP method GET)
				 *		View a single posts: index.php/api/posts/123 (also GET )
				 *		Create a new post: index.php/api/posts (POST)
				 *		Update a post: index.php/api/posts/123 (PUT)
				 *		Delete a post: index.php/api/posts/123 (DELETE)
				 */
                array('api/authenticate', 'pattern'=>'api/authenticate', 'verb'=>'POST'),
				array('api/emailExists', 'pattern'=>'api/emailExists', 'verb'=>'GET'),
				array('api/list', 'pattern'=>'api/<model:\w+>', 'verb'=>'GET'),
				array('api/list', 'pattern'=>'api/<model:\w+>/criteria/*', 'verb'=>'GET'),
				array('api/view', 'pattern'=>'api/<model:\w+>/id/<id:\d+>', 'verb'=>'GET'),
				array('api/update', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
				array('api/delete', 'pattern'=>'api/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
				array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
				
                                
				/** 
				 * Friendly URLs
				 */
                                 // format get public url
                                "<module:\w+>/p/<encode>"=>"/<module>/default/GetPublicPDF/p/<encode>",
                                //"pdf/<encode>"=>"lbInvoice/default/PublicPDF/p/<encode>",
                               
                                 
				// home
				'<subscription_id:\d+>'
					=>'invoice/index/subscription/<subscription_id>',
				
				// generic view: subscription/controller/id-title
				'<subscription_id:\d+>/<module:\w+>/<id:\d+><sep:\-*><title:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'<module>/default/view/id/<id>/subscription/<subscription_id>',
				// generic action for a module: subscription/mod/controller/action
				'<subscription_id:\d+>/<module:\w+>/<action:\w+>'
					=>'<module>/default/<action>',
				
				'<subscription_id:\d+>/invoice/<invoice_id:\d+><sep:\-*><customer_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'invoice/view/id/<invoice_id>/subscription/<subscription_id>',
				'<subscription_id:\d+>/quotation/<quotation_id:\d+><sep:\-*><customer_name:[\pL\d-()$?%`~!@#^&*-+=]*>/task/<task_id:\d+><sep1:\-+><task_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'task/view/id/<task_id>/subscription/<subscription_id>',
				'<subscription_id:\d+>/project/<project_id:\d+><sep:\-*><project_name:[\pL\d-()$?%`~!@#^&*-+=]*>/issue/<issue_id:\d+><sep1:\-+><issue_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'issue/view/id/<issue_id>/subscription/<subscription_id>',
				'<subscription_id:\d+>/project/<project_id:\d+><sep:\-*><project_name:[\pL\d-()$?%`~!@#^&*-+=]*>/implementation/<implementation_id:\d+><sep1:\-+><implementation_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'implementation/view/id/<implementation_id>/subscription/<subscription_id>',
				'<subscription_id:\d+>/project/<project_id:\d+><sep:\-*><project_name:[\pL\d-()$?%`~!@#^&*-+=]*>/wiki/<wiki_id:\d+><sep1:\-+><wiki_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'wikiPage/view/id/<wiki_id>/subscription/<subscription_id>',
				'<subscription_id:\d+>/wiki/<wiki_id:\d+><sep1:\-+><wiki_name:[\pL\d-()$?%`~!@#^&*-+=]*>'
					=>'wikiPage/view/id/<wiki_id>/subscription/<subscription_id>',
					
				'<subscription_id:\d+>/configuration/'=>'configuration/index',
					
                            
				'<subscription_id:\d+>/wiki'=>'wikiPage/index',
				'<subscription_id:\d+>/resource/go'=>'resource/go',
				'<subscription_id:\d+>/progress'=>'project/progress',
				'<subscription_id:\d+>/calendar'=>'calendar/index',
				'<subscription_id:\d+>/team'=>'accountTeamMember/admin',
				'<subscription_id:\d+>/contact'=>'site/contact',
				'<subscription_id:\d+>/logout'=>'site/logout',
				'<subscription_id:\d+>/subscription/<id:\d+>'=>'site/subscription/<id>',
                            
				'<subscription_id:\d+>/<module:\w+>/<controller:\w+>/<action:\w+>'
					=>'<module>/<controller>/<action>',
                                '<subscription_id:\d+>/<module:\w+>/<controller:\w+>/<id:\d+><sep:\-*><name:[\pL\d-()$?%`~!@#^&*-+=]*>'
                                                                =>'<module>/<controller>/view/id/<id>',
                            // tu dong
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            
			),
		),
		
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => $dbConfig['connectionString'],
			'emulatePrepare' => true,
			'username' => $dbConfig['username'],
			'password' => $dbConfig['password'],
			'charset' => 'utf8',
		),
		
		'mail' => array(
				'class' => 'ext.yii-mail.YiiMail',
				'transportType' => 'smtp', // php
				
				'transportOptions' => array( // only if use smtp
						'host' => 'mail.lionsoftwaresolutions.com',
						//'encryption' => 'ssl',
						'username' => 'postmaster@lionsoftwaresolutions.com',
						'password' => 'yourpass',
						'port' => 25,
				),
//				//'viewPath' => 'application.views.mails',
		),
		
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
		
		//X-editable config
		'editable' => array(
				'class'     => 'editable.EditableConfig',
				'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain'
				'mode'      => 'popup',            //mode: 'popup' or 'inline'
				'defaults'  => array(              //default settings for all editable elements
					'emptytext' => 'Click to edit'
				)
		),
			
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                'ePdf' => array(
                        'class'         => 'ext.yii-pdf.EYiiPdf',
                        'params'        => array(
                            'HTML2PDF' => array(
                                'librarySourcePath' => 'application.vendor.html2pdf.*',
                                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                                'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                                    'orientation' => 'P', // landscape or portrait orientation
                                    'format'      => 'A4', // format A4, A5, ...
                                    'language'    => 'en', // language: fr, en, it ...
                                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                                )
                            )
                        ),
                    ),
                    //...
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminID'=>1,
		'adminEmail'=>'admin@linxbooks.com',
		'emailSignature' => 'Have a nice day!<br/>Admin.', // this can contain html
		'documentRootDir' => 'documents/',
		'profilePhotosDir' => 'profile_photos/',
		'enableMobileWeb'=>0,
                'languages'=>array('en_us'=>'English', 'fr'=>'French', 'fa_ir'=>'فارسی'),
            'LINXHQ_SSO_URL'=>'http://accounts.linxenterprisedemo.com/',
            //'LINXHQ_SSO_URL'=>'http://localhost:8080/LinxHQ/',
	),
);
