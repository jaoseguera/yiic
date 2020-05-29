<?php
error_reporting(0);
session_start();
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'ThinUI by Emergys',
    // new theme - thinui theme
    // 'theme' => 'utopia3',
    // preloading 'log' component
    'preload'=>array('log'),
    // autoloading model and component classes
    'import'=>array(                
		'application.models.*',
		'application.components.*',
		'application.components.lib.*',
		'application.components.couchNew.Adapter.*',		
		'application.components.couchNew.Dotenv.*',		
		'application.components.couchNew.*',		
		'application.controllers.*',
		'ext.YiiMailer.YiiMailer',
		'ext.excel.*',
		'ext.pdf.*',
		'ext.pdf.lib.*',
    ),
    'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			// 'ipFilters'=>array('127.0.0.1','::1'),
		),
		'arthrex',
		'datamigration'
    ),    
    'defaultController'=>'login',
    // application components
    'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('login/index'),
			'returnUrl'=> array('host/'),
		),
		'epassgen'=>array(
			'class'=>'ext.epasswordgenerator.EPasswordGenerator',
        ),
		// Jquery 1.10.2 Include
		'clientScript'=>array(
			'packages'=>array(
				'jquery'=>array(
					'baseUrl'=>'js/',
					'js'=>array('jquery-1.10.2.min.js'),
				),
				'jquery.ui'=>array(
					'baseUrl'=>'js/',
					'js'=>array('jquery-ui-1.10.3.min.js'),
				),
			),
		),
		// Caching
        /*
            'cache'=>array(
                'class'=>'system.caching.CMemCache',
                'servers'=>array(
                    array('host'=>'server1', 'port'=>11211, 'weight'=>60),
                    array('host'=>'server2', 'port'=>11211, 'weight'=>40),
                ),
            ),
		*/
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			// true - index.php will show in url, false -index.php will not show in url.(.htaccess file must be included in the project folder)
			'showScriptName' => false,                 
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'UKPhoneValidator'=>array(
			'class'=>'ext.UKPhoneValidator.UKPhoneValidator',
		),
		
		// 'db'=>array('connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/thinui-yii.db',),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=thinui-yii',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'login/error',
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
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'appname'=>'Cloud ERP With SAP',
        'adminEmail'=>'help@emergyscorp.com',
        'adminName'=>'Emergys Thinui Admin',
		'smtpconfig'=>array(
            'mailhost'=>'192.155.95.212',
            'securetype'=>'tls',
            'host'=>'smtp.gmail.com',
            'port'=>587,
			'username'=>'help.thinui@emergyscorp.com',
			'password'=>'9y=67eHH1'
        ),
		'couchdb'=>array(
            'admin'=>'admin:admin123@',
            'host'=>'localhost:5984',
            /*'admin'=>'Emergys:thinui@',
            'host'=>'build.thinui.com:5984',*/
            'thinuidb'=>'thinui',
			'companydb'=>'thinuicompanies',
			'userdb'=>'thinuiusers',
			'thinuiolddb'=>'thinuiold',
        ),
        'EC4_LOGIN' => array (
            "ASHOST"=>"76.191.119.98", // your host address here "76.191.119.98
            "SYSNR"=>"10",
            "SYSID"=>"EC4",
            "CLIENT"=>"210",
            "USER"=>"msreekanth", // your username here
            "PASSWD"=>"admin123", // your logon password here
            "LANG"=>"EN",
        ),
		'accountgroup'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'ACCN.properties',
		'update'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'CouchDBupdate.php',
		'file'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'file.json',
		'logoPath'=>dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR,
		'salt'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'salt.properties'
    ),
);
