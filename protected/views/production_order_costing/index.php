<style>
.span1
{
min-width:80px;
margin-top:20px
}
@media all and (min-width:750px) and (max-width:1024px)
{
.span1
{
min-width:80px;
margin-top:40px
}
}

</style>
<?php
$customize = $model;
?>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section">
	<div class="row-fluid">
		<div class="utopia-widget-content">
			<form id="validation" action="javascript:submit_form('validation')" class="form-horizontal">
				<div class="span5 utopia-form-freeSpace">
					<fieldset>
						<div class="control-group">
							<input type="hidden" name='page' value="bapi">
							<input type="hidden" name="url" value="production_order_costing"/>
							<input type="hidden" name="key" value="production_order_costing"/>
							<label class="control-label cutz" style="width: 168px" alt="Production Order" for="date"><?php echo Controller::customize_label('Production Order Number');?><span> *</span>:&nbsp;&nbsp;

              </label>
							
							<div class="controls myspace1">
								<input alt="Production Order" type="text" class="input-fluid  validate[required]" name="ORDER_NUMBER" value="<?php echo $ORDER_NUMBER;?>" tabindex="1" onKeyUp="jspt('ORDER_NUMBER',this.value,event)" autocomplete="off" id="ORDER_NUMBER"><span class='minw' onclick="lookup('Production Number', 'ORDER_NUMBER', 'prod_order_number')" >&nbsp;</span>
							</div>
						</div>
					</fieldset>
				</div>
				
				<div>
					
					<button class="btn btn-primary span1 bbt" type="submit" id="subt" >Submit</button>
				</div>
			</form>
		</div>
	</div>
</section>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script type="text/javascript">
	function number(num)
	{
		if(num!="")
		{
			var str = '' + num;
			while (str.length < 12)
			{
				str = '0' + str;
			}
			document.getElementById('ORDER_NUMBER').value=str;
		}
	}
	
    $(document).ready(function() {
       jQuery("#validation").validationEngine();
    });
</script>

