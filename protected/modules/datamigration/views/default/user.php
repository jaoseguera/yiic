<?php
	$this->pageTitle = Yii::app()->name . ' - User Migration';
	$cs = Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page 
	
	$client = Controller::companyDbconnection();
	$doc    = $client->getAllDocs();
	
	$users	= Controller::userDbconnection();
	
	$mainusers		= Controller::mainuserDbconnection();
	$mainuserdoc    = $mainusers->getAllDocs();
?>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>

<style> 
    .utopia-login { margin-left:auto; margin-right:auto; margin-top:10%; width: 100% !important; }
    label.error {  border: none !important; } 
	.form { margin-top: 10%; }
	.form input {
		margin-right: 10px;
	}
</style>
<div class="container-fluid" >
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="en_cookies">We use cookies to improve your experience of build.thinui.com. By continuing to explore without changing your settings, you are agreeing to accept them. To learn how to change these settings, please see our <a href='#'>privacy policy.</a></div>
                <div class="span4 offset4 form">
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
							<div class="control-group">
								<label class="control-label" for="input01">Company<span> *</span>:</label>
								<div class="controls">
									<select id="company" data-placeholder="Select your Company" class="validate[required]" name="company">
										<option value="">Select your Company</option>
										<?php
											foreach($doc->rows as $key => $val)
												echo '<option value="'.$val->id.'">'.$val->id.'</option>';
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input01">Users<span> *</span>:</label>
								<div class="controls">
									<?php
										echo '<ul>';
										foreach($mainuserdoc->rows as $key => $val)
										{
											try
											{
												$doc = $users->getDoc($val->id);
											}
											catch(Exception $e) 
											{
												if($e->getCode() == 404) 
												{
													$pos = strpos($val->id, "@");
													if($pos !== false)
														echo '<li><input class="validate[minCheckbox[1]] checkbox" type="checkbox" name="user[]" value="'.$val->id.'">'.$val->id."</li>";
												}
											}
										}
										echo '</ul>';
									?>
								</div>
							</div>
							<div>
								<button id="mybtnSubmit" type="submit" class="btn btn-primary span2">Submit</button>
							</div>
							<div class="clear"></div>
						</div>
						<div id="dataHTML" style="display: none;">
							<div id="data"></div>
							<input id="mybtnBack" type="button" value="BACK" class="btn span4" />
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
<script>
    if (typeof jQuery === "undefined") {    
        alert('Jquery Not Included');
    } else {
        $(document).ready( function() {
            $('form:not(.filter) :input:visible:first').focus();
			
            $("#login-form").validationEngine();
        });
    }
</script>