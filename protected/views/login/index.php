<?php
/* @var $this LoginController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';

$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page 
?><script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>

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
                    <?php if(Yii::app()->user->hasFlash('success')): ?>
						<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
						<?php Yii::app()->clientScript->registerScript( 'myHideEffect', '$(".flash-success").animate({opacity: 1.0}, 3000).fadeOut("slow");', CClientScript::POS_READY ); ?>
                    <?php endif; ?>
                    <?php if(Yii::app()->user->hasFlash('error')): ?>
						<div class="flash-error"><?php echo Yii::app()->user->getFlash('error'); ?></div>
						<?php Yii::app()->clientScript->registerScript( 'myHideEffect', '$(".flash-error").animate({opacity: 1.0}, 3000).fadeOut("slow");', CClientScript::POS_READY ); ?>
                    <?php endif; ?>
                    <div class='thinui-login'><a class="sapin-logo" >
					<?php
					try
					{					                    
					$company = Controller::companyDbconnection();					
                    $user = Controller::userDbconnection();
					$thinui = Controller::couchDbconnection();
					$user=$user->databaseExists();
					$thinui=$thinui->databaseExists();
					$compdetail=$company->getDoc('emgadmin'); 
					$errs = "";
                    if($user==0 || $thinui==0)
					{
					Yii::log('CDND01-Database does not exist',CLogger::LEVEL_ERROR,'couchUnauthorizedException');
					$errs='Please notify your administrator that the system has encountered a configuration error CDND01. System is unable to process your login at this time.';
					
					}
					}
					catch(Exception $exception)
					{
					$e=$exception->getmessage();
					$e=$e.'CDUP01 - CouchDB access not configured correctly. Check main.php';
					Yii::log($e,CLogger::LEVEL_ERROR,'couchUnauthorizedException');
					$errs='Please notify your administrator that the system has encountered a configuration error CDUP01. System is unable to process your login at this time.';
					} 
					$logo='';
					
					if(isset($compdetail->logo) && file_exists($compdetail->logo))
					{					
						$logo=$compdetail->logo;
						echo '<img src="'.Yii::app()->request->baseUrl."/upload/".basename($logo).'"/>';
						echo '</a><h5 style="color:#fff;" align="center">Powered by Emergys thinui</h5>';
					}else
					{
						echo '<img src="'.Yii::app()->request->baseUrl.'/images/thinui-logo-125x50.png"/></a>';
					} 
					?>
					
					</div>
					<div id='errorsw'>&nbsp;</div>
                    <div class="form">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form', 'clientOptions' => array('enableAjaxValidation' => false),
                            'htmlOptions' => array('class' => 'utopia')
                                ));
                        ?>
                        <div id='error'></div>
						<div id='errors'><?php echo $errs; ?></div>
                        <div>
							<?php echo $form->labelEx($model, 'username'); ?>
							<?php echo $form->textField($model, 'username', array('class' => 'validate[required, custom[email]] utopia-fluid-input span12', 'onKeyUp' => "jspt(this.id, this.value,event)")); ?>
							<?php echo $form->error($model, 'username'); ?>
                        </div>

                        <div>
							<?php echo $form->labelEx($model, 'password'); ?>
							<?php echo $form->passwordField($model, 'password', array('class' => 'validate[required, custom[password]] utopia-fluid-input span12')); ?>
							<?php echo $form->error($model, 'password'); ?>
							<?php echo $form->hiddenField($model, 'datetime', array('value' => '')); ?>
                        </div>

                        <div class="rememberMe">
							<?php echo $form->checkBox($model, 'rememberMe', array('style' => 'float: left; margin: 3px;')); ?>
							<?php echo $form->label($model, 'rememberMe'); ?>
							<?php echo $form->error($model, 'rememberMe'); ?>
                        </div>

                        <div class="clear"></div>

                        <div class="submit">
                            <div class="span6">
								<?php //echo CHtml::submitButton('Login', array('class'=>'btn span8', 'id'=>'mybtnSubmit'));  ?>
                                <button id="mybtnSubmit" type="submit" class="btn span8">Login</button>
                            </div>
                            <div class="span6" align="right">
                                <a class="zocial icon facebook" href="#"></a>
                                <a class="zocial icon googleplus" href="#"></a>
                            </div>
                        </div>

                        <?php if(!Controller::checkHost()): ?>
							<!--<div><?php // echo CHtml::link('Create an Account', array('login/register')); ?></div>-->
						<?php endif; ?>
                        <div><a href="<?php echo Yii::app()->createAbsoluteUrl("forget_password/"); ?>">Forgot Your Password</a></div>

						<?php $this->endWidget(); ?>
                    </div><!-- form -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine1.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.feedBackBox.js" type="text/javascript"></script>

<script>    
    if (typeof jQuery === "undefined") {    
        alert('Jquery Not Included');
    } else {
        var currentdate = new Date(); 
        var datetime =  (currentdate.getMonth()+1)
            + "/" + currentdate.getDate()
            + "/" + currentdate.getFullYear()
            + " @ " + currentdate.getHours()
            + ":" + currentdate.getMinutes()
            + ":" + currentdate.getSeconds();
        $("#IndexForm_datetime").val(datetime);
    
        $(document).ready( function() {
		$('#errors').css({ 'color':'#e00909' });
            $('form:not(.filter) :input:visible:first').focus();
            $("#login-form").validationEngine({
                onValidationComplete: function(form, status)
                {
                    if(status)
                    {
                        $('#mybtnSubmit').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif' />");
                        var de=0;
                        $('.selected').each(function(index, element) {
                            de=1;
                            var fq=$('.selected').attr('name');
                            $('#'+fq).val($('.selected').text());
                            $('.dynamicDiv').remove();
                            return false;
                        });
					
                        if(de!=1)
                        {
                            $('input[type="text"]').each(function(index, element) {
                                var names=$(this).attr('id');
                                var values=$(this).val();
                                // alert(idss);
                                var cook=$.cookie(names);
                                //var myw= cook.split(',');
                                // alert(cook.indexOf(values));
                                var name_cook=values;
							
                                if(cook!=null)
                                    name_cook=cook+','+values;
							
                                if($.cookie(names))
                                {
                                    var str=$.cookie(names);
                                    var n=str.search(values);
								
                                    if(n==-1)
                                        $.cookie(names, name_cook);
                                }
                                else
                                    $.cookie(names, name_cook, { expires: 365 });
							
                                //alert($.cookie(names));
                            });
                        }
					
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo Yii::app()->createAbsoluteUrl("login/index"); ?>',
                            data: form.serialize()+'&err='+$('#errors').html(),
                            success:function(data){                                                                
                                if(data != 'undone' && $('#errors').html()=='') 
                                    window.location.replace('<?php echo Yii::app()->createAbsoluteUrl("host/"); ?>');                            
                                else if(data == 'undone')
                                {
                                    $('#mybtnSubmit').html("Login");
									if($('#errors').html()=='')
										$('#error').html('Your access is invalid. Please correct your login credentials or contact your admin');
                                    $('#error').css({ 'color':'#e00909' });
                                    $('#IndexForm_username').css({ border:'1px solid #e00909'});
                                    $('#IndexForm_password').css({ border:'1px solid #e00909'});
                                }else if($('#error').html()!='')
								{
									$('#mybtnSubmit').html("Login");
									$('#error').css({ 'color':'#e00909' });
                                    $('#IndexForm_username').css({ border:'1px solid #e00909'});
                                    $('#IndexForm_password').css({ border:'1px solid #e00909'});
								}else
								{
									alert(data);
								$('#mybtnSubmit').html("Login");
								}
							}                        
                        });
                    }
                }  
            });
        });
    }
</script>