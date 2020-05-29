<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array( 'Login', );

?>

<style> 
	.utopia-login { margin-left:auto; margin-right:auto; margin-top:10%; }
	label.error {  border: none !important; } 
</style>
<div class="container-fluid" >
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="en_cookies">We use cookies to improve your experience of build.thinui.com. By continuing to explore without changing your settings, you are agreeing to accept them. To learn how to change these settings, please see our <a href='#'>privacy policy.</a></div>
				<div class="utopia-login" >
					<div class='thinui-login'><a href="index.php" class="sapin-logo" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-125x50.png"  /></a></div>
					<div id='errorsw'>&nbsp;</div>
					
					<div class="form"><form method="post" class="utopia" id="logform">
						<?php 
							$form = $this->beginWidget('CActiveForm', array( 'id'=>'login-form', 'enableClientValidation'=>true, 'clientOptions'=>array(
								'validateOnSubmit'=>true, ),
							)); 
						?>
						<!--<label>Fields with <span>*</span> are required.</label>-->
						<?php echo $form->labelEx($model,'username'); ?>
						<?php echo $form->textField($model,'username',array('class'=>'span12')); ?>
						<label><span><?php echo $form->error($model,'username'); ?></span></label>
						
						<label><?php echo $form->labelEx($model,'password'); ?>				
						<?php echo $form->passwordField($model,'password',array('class'=>'span12')); ?>
						<span><?php echo $form->error($model,'password'); ?></span></label>
					
						<table border="0" width="100%">
							<tr>
								<td><?php echo CHtml::submitButton('Login',array('class'=>'btn span4')); ?></td>
								<td align="right" width="20px"><a class="zocial icon facebook" href="#"></a></td>
								<td align="right" width="20px"><a href="#" class="zocial icon googleplus" id="loginText"></a></td>
							</tr>
							<tr>
								<td colspan="3">
									<label><?php echo $form->checkBox($model,'rememberMe'); ?>
									<?php echo $form->label($model,'rememberMe'); ?>									
									<span><?php echo $form->error($model,'rememberMe'); ?></span></label>
								</td></tr>
								<tr><td colspan="3" ><a href="#">Create an Account</a></td>								
							</tr>
							<tr>
								<td colspan="3"><a href="#">Forgot Your Password</a></td>
							</tr>
						</table>
					</form></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>