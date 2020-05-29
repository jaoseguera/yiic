<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page  
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.feedBackBox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<?php
	$this->renderpartial("//create_customers/index");
?>