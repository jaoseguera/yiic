<?php
/* @var $this LoginController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Table Headers';

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
                    <?php endif; ?>
                    <div class="form">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
								'id' => 'login-form',
								'clientOptions' => array('enableAjaxValidation' => false),
								'htmlOptions' => array('class' => 'utopia')
							));
                        ?>
                        <div id='form'>
							<div>
								<?php echo $form->labelEx($model, 'bapiName'); ?>
								<?php echo $form->textField($model, 'bapiName', array('class' => 'validate[required] utopia-fluid-input span12', 'onKeyUp' => "jspt(this.id, this.value,event)")); ?>
								<?php echo $form->error($model, 'bapiName'); ?>
							</div>
							<div>
								<button id="mybtnSubmit" type="submit" class="btn span4">Submit</button>
							</div>
							<div class="clear"></div>
						</div>
						<div id="dataHTML" style="display: none;">
							<div id="data"></div>
							<input id="mybtnBack" type="button" value="<?php echo _BACK ?>" class="btn span4" />
						</div>
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
        $(document).ready( function() {
            $('form:not(.filter) :input:visible:first').focus();
            $("#mybtnBack").click(function(){
				$("#form").show();
				$("#dataHTML").hide();
			});
			
            $("#login-form").validationEngine({
                onValidationComplete: function(form, status)
                {
					if($(".flash-error").length == 1 && $(".flash-error").attr("id") == undefined)
						return false;
                    if(status)
                    {
						$("#data").removeClass("flash-success");
						$("#data").removeClass("flash-error");
						$("#data").html(" ");
                        $('#mybtnSubmit').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif' />");
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo Yii::app()->createAbsoluteUrl("countrystate/store"); ?>',
                            data: form.serialize(),
                            success:function(data){
								var n = data.indexOf("success, ");
								var data = data.replace("success, ", ""); 
								if(n == 0)
								{
									$("#data").addClass("flash-success");
									$("#mybtnBack").val("New");
								}
								else
								{
									$("#data").addClass("flash-error");
									$("#mybtnBack").val("Back");
								}
								$("#form").hide();
								$("#dataHTML").show();
								$("#data").html(data);
								$('#mybtnSubmit').html("Submit");
                            }                        
                        });
                    }
                }  
            });
        });
    }
</script>