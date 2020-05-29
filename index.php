<?php

// To test svn post commit hook
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once($yii);
Yii::createWebApplication($config);
if(isset($_SESSION['USER_LANG'])){     	
            include "lang_".strtolower($_SESSION['USER_LANG']).".php";
            include "country_opt_".strtolower($_SESSION['USER_LANG']).".php";
}else{
            include "lang_en.php";
            include "country_opt_en.php";
} 
Yii::app()->run();
?>