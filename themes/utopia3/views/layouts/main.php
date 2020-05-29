<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=0">
    <meta name="description" content="A complete admin panel theme">
	
	<link  rel="SHORTCUT ICON" HREF="<?php echo Yii::app()->request->baseUrl; ?>/image/thin-ui.ico" />	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/utopia-white.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/utopia-responsive.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.cleditor.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/alerts.css" type="text/css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/colorpicker.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/color/bundle.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/utopia-growl.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/page-scrller.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/social_icon/icons.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.feedBackBox.css" rel="stylesheet" type="text/css">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body><?php echo $content; ?></body>
</html>