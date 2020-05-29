<?php
/* @var $this LoginController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>
<!--
	<div class="error">
		<?php // echo CHtml::encode($message); ?>
	</div>
-->

<div class="errorSummary">
    <p>
    Sorry, it seems like a(n) <?php echo $code; ?> error has occured during your request.
    </p>

    <p><strong>Message:</strong> <?php echo CHtml::encode($message); ?></p>
</div>