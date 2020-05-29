<style>
.span1{
min-width:80px;
margin-top:-5px;
}

@media all and (min-width:750px) and (max-width:1024px)
{
.span1
{
min-width:80px;
margin-top:10px
}
}

</style>
<?php
$customize = $model;
$ORDER_NUMBER="";
$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
	$ORDER_NUMBER="1000080";
}
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section">
    <div class="row-fluid">
        <div class="utopia-widget-content">
			<form id="validation" action="javascript:submit_ajaxform('validation');" class="form-horizontal">
				<div class="span5 utopia-form-freeSpace">
					<fieldset>
						<div class="control-group">
							<input type="hidden" name='page' value="bapi">
							<input type="hidden" name="url" value="release_prod_order"/>
							<input type="hidden" name="key" value="release_prod_order"/>
							<!--<input type="hidden" name="key" value="BAPI_PRODORD_RELEASE"/>-->
							<label class="control-label cutz" alt="Production Order" style="width: 168px" for="date"><?php echo Controller::customize_label('Production Order Number');?><span> *</span>:&nbsp;&nbsp;</label>
							<div class="controls myspace1">
								<input  alt="Production Order" type="text"   class="input-fluid  validate[required,custom[number]]" name="ORDER_NUMBER" id='ORDER_NUMBER' value="<?php echo $ORDER_NUMBER;?>" tabindex="1" onKeyUp="jspt('ORDER_NUMBER',this.value,event)" autocomplete="off">
							</div>
						</div>
					</fieldset>
				</div>
				<div class="utopia-form-freeSpace">
					<div class="controls">
						<br>
						<button class="btn btn-primary span1 bbt" type="submit" id="subt" >Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
       jQuery("#validation").validationEngine();
    });
</script>

