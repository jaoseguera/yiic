<?php
	$this->pageTitle=Yii::app()->name . ' - Register';
	$this->breadcrumbs=array( 'Register', );
?>
<style> 
	.utopia-login { margin-left:auto; margin-right:auto; margin-top:10%; }
	label.error {  border: none !important; }
	.control-group { margin-bottom: 10px !important;}
	.main_div { min-height: 492px !important; }
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12" >
			<div class="header-top">
				<div class="header-wrapper">
					<a href="index" class="sapin-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-125x50.png"  /></a>
					<div class="user-panel header-divider body_con" style="border:none;"></div>
					<div class="header-right">
						<div class="header-divider">
							<a href="index" style='padding-right:30px;color:#fff;' class="re_login">Login</a>
						</div>
					</div><!-- End header right -->
				</div><!-- End header wrapper -->
			</div><!-- End header -->
		</div>
	</div>
	<section id='utopia-wizard-form' class="utopia-widget  section row-fluid main_div" >
		<div class="utopia-widget-title" style="display:block;" id='r_title'>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
			<span>Create an Account</span>
		</div>
		<div style="padding:15px;">
			<!------------------------------------------------------------------------------>
			<div class="utopia-widget-content" id="company_registration_form">
				<?php
					$form=$this->beginWidget('CActiveForm', array(
						'id'=>'company-register-form',
						'enableAjaxValidation'=>false,
						'htmlOptions'=>array( 'onsubmit'=>"return chk_step(this);", 'class'=>"form-horizontal create_account", ),
					));
				?>
				<div class="span12 utopia-form-freeSpace myspace">
					<input type="hidden" name="bapiName" id="bapiName" value="/EMG/AWS_CHANGE_ES_DATA"/>
					<div class="errorMessage" id="formResult"></div>
					<div id="AjaxLoader" style="position: absolute; top: 350px; left: 600px;  display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div>
					<fieldset>
						<div class="span6">
							<legend>Company Data</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_legalname', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_legalname', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'Legal Name', 'tabindex'=>'1')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_legalname'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_street', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_street', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Street', 'tabindex'=>'2')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_street'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_houseno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_houseno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'House Number', 'tabindex'=>'3')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_houseno'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_city', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_city', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'City', 'tabindex'=>'4')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_city'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_state', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_state', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'State', 'tabindex'=>'5')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_state'); ?></span></label>
								</div>
							</div>
						</div>
						<div class="span6">
							<legend>&nbsp;</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_postalcode', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_postalcode', array('class'=>'validate[required, custom[integer], maxSize[10]] input-fluid span8', 'placeholder'=>'Postal Code', 'tabindex'=>'6', 'maxlength'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_postalcode'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_telephone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_telephone', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Telephone', 'tabindex'=>'7', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_telephone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_fax', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_fax', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Fax', 'tabindex'=>'8', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_fax'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_timezone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_timezone', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Time Zone', 'tabindex'=>'9')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_timezone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'compy_tinno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'compy_tinno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Tax Number USA(TIN)', 'tabindex'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'compy_tinno'); ?></span></label>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="span6">
							<legend>Plant Data</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_legalname', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_legalname', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'Legal Name', 'tabindex'=>'1')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_legalname'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_street', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_street', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Street', 'tabindex'=>'2')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_street'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_houseno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_houseno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'House Number', 'tabindex'=>'3')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_houseno'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_city', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_city', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'City', 'tabindex'=>'4')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_city'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_state', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_state', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'State', 'tabindex'=>'5')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_state'); ?></span></label>
								</div>
							</div>
						</div>
						<div class="span6">
							<legend>&nbsp;</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_postalcode', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_postalcode', array('class'=>'validate[required, custom[integer], maxSize[10]] input-fluid span8', 'placeholder'=>'Postal Code', 'tabindex'=>'6', 'maxlength'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_postalcode'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_telephone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_telephone', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Telephone', 'tabindex'=>'7', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_telephone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_fax', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_fax', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Fax', 'tabindex'=>'8', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_fax'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_timezone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_timezone', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Time Zone', 'tabindex'=>'9')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_timezone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'plant_tinno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'plant_tinno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Tax Number USA(TIN)', 'tabindex'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'plant_tinno'); ?></span></label>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="span6">
							<legend>Sales Organisation Data</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_legalname', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_legalname', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'Legal Name', 'tabindex'=>'1')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_legalname'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_street', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_street', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Street', 'tabindex'=>'2')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_street'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_houseno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_houseno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'House Number', 'tabindex'=>'3')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_houseno'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_city', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_city', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'City', 'tabindex'=>'4')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_city'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_state', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_state', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'State', 'tabindex'=>'5')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_state'); ?></span></label>
								</div>
							</div>
						</div>
						<div class="span6">
							<legend>&nbsp;</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_postalcode', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_postalcode', array('class'=>'validate[required, custom[integer], maxSize[10]] input-fluid span8', 'placeholder'=>'Postal Code', 'tabindex'=>'6', 'maxlength'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_postalcode'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_telephone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_telephone', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Telephone', 'tabindex'=>'7', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_telephone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_fax', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_fax', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Fax', 'tabindex'=>'8', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_fax'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_timezone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_timezone', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Time Zone', 'tabindex'=>'9')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_timezone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'sales_tinno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'sales_tinno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Tax Number USA(TIN)', 'tabindex'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'sales_tinno'); ?></span></label>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="span6">
							<legend>Purchase Organisation Data</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_legalname', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_legalname', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'Legal Name', 'tabindex'=>'1')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_legalname'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_street', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_street', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Street', 'tabindex'=>'2')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_street'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_houseno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_houseno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'House Number', 'tabindex'=>'3')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_houseno'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_city', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_city', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'City', 'tabindex'=>'4')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_city'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_state', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_state', array('class'=>'validate[required, custom[onlyLetterSp]] input-fluid span8', 'placeholder'=>'State', 'tabindex'=>'5')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_state'); ?></span></label>
								</div>
							</div>
						</div>
						<div class="span6">
							<legend>&nbsp;</legend>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_postalcode', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_postalcode', array('class'=>'validate[required, custom[integer], maxSize[10]] input-fluid span8', 'placeholder'=>'Postal Code', 'tabindex'=>'6', 'maxlength'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_postalcode'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_telephone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_telephone', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Telephone', 'tabindex'=>'7', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_telephone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_fax', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_fax', array('class'=>'validate[required, custom[integer], maxSize[12]] input-fluid span8', 'placeholder'=>'Fax', 'tabindex'=>'8', 'maxlength'=>'12')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_fax'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_timezone', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_timezone', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Time Zone', 'tabindex'=>'9')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_timezone'); ?></span></label>
								</div>
							</div>
							<div class="control-group">
								<?php echo $form->labelEx($model, 'purch_tinno', array('class'=>'control-label')); ?>
								<div class="controls">
									<label><?php echo $form->textField($model, 'purch_tinno', array('class'=>'validate[required] input-fluid span8', 'placeholder'=>'Tax Number USA(TIN)', 'tabindex'=>'10')); ?>
									<span style="color:red;"><?php echo $form->error($model, 'purch_tinno'); ?></span></label>
								</div>
							</div>
						</div>
						<div class="form-actions span11">
							<div class="span6">
								<?php echo CHtml::submitButton('Submit', array('id'=>'mybtnSubmit', 'tabindex'=>'11', 'class'=>'btn spanbt btn-primary span3 offset8',)); ?>
							</div>
							<div class="span6">
								<?php echo CHtml::button('Cancel', array('onclick' => 'js:document.location.href="login/index"', 'class'=>'btn spanbt span3')); ?>
							</div>
						</div>
					</fieldset>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</section>
</div>
<?php $cs = Yii::app()->getClientScript(); $cs->registerCoreScript('jquery'); Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine1.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.formToWizard.js" type="text/javascript"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.alerts.css" type="text/css" rel="stylesheet" />
<script>    
	if (typeof jQuery === "undefined") {    
		 alert('Jquery Not Included');
	} else {
		
		function chk_step(form)
		{
			var steps = $("#steps").find("li");
			var total_size = steps.size()-1;
			var current_step = $("#steps").find("li.current").index();
			if(total_size == current_step)
			{
				if(form.validationEngine())
					form.submit();
			}
			else
				return false;
		}
		
		$( function() {
			var $registerForm = $('#company-register-form');
			
			$registerForm.keyup(function( event ) {
				if ( event.which == 13 ) {
					$registerForm.formToWizard( 'NextStep' );
				}
			});
			
            $registerForm.validationEngine();
            
            $registerForm.formToWizard({
                submitButton: 'SaveAccount',
                showProgress: true, //default value for showProgress is also true
                showStepNo: false,
                nextBtnName : 'Next',
                prevBtnName : 'Back',
                validateBeforeNext: function() {
                    return $registerForm.validationEngine( 'validate' );
                }
            });
        });
	}
</script>