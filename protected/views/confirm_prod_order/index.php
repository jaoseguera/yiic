<?php
$customize = $model;
$ORDER_NUMBER="";
$FIN_CONF="";
$trg_qt="";
if(isset($_REQUEST['value']))
{
	$ORDER_NUMBER=strtoupper($_REQUEST['value']);
	$json=$_REQUEST['json'];
	$js=json_decode($json,true);
	$trg_qt=$js['TARGET_QUANTITY'];
}

if(isset($_REQUEST['titl']))
{
    ?><script>
    $(document).ready(function()
    {
        parent.titl('<?php echo $_REQUEST["titl"];?>');
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    })
    </script><?php
}
?>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section" style="padding-bottom:20px;">
	<div class="row-fluid">
		<div class="utopia-widget-content">
			<form id="validation3" action="javascript:submit_ajaxform('validation3')" class="form-horizontal">
				<!--
					<div class="span5 utopia-form-freeSpace">
						<fieldset>
							<div class="control-group">
								<input type="hidden" name='page' value="bapi">
								<input type="hidden" name="url" value="confirm_prod_order"/>
								<input type="hidden" name="bapiName" value="BAPI_PRODORDCONF_CREATE_HDR"/>
								<label class="control-label cutz" alt="Production Order" for="date"><?php echo Controller::customize_label('Production Order');?><span> *</span>:</label>
								
								<div class="controls myspace1">
									<input alt="Production Order"  type="text" class="input-fluid  validate[required]" name="ORDER_NUMBER" value="<?php echo $ORDER_NUMBER;?>" tabindex="1" onKeyUp="jspt('ORDER_NUMBER',this.value,event)" autocomplete="off" id="ORDER_NUMBER">
								</div>
							</div>
						</fieldset>
					</div>
				-->
				
				<div class="span12 utopia-form-freeSpace">
					<fieldset>
						<div class="span3 utopia-form-freeSpace">
							<fieldset>
<label class="control-label1 cutz" alt="Production Order" style="width: 165px;"  for="date"><?php echo Controller::customize_label('Production Order Number');?><span> *</span>:</label>
								<input type="hidden" name='page' value="bapi">
								<input type="hidden" name="url" value="confirm_prod_order"/>
								<input type="hidden" name="key" value="confirm_prod_order"/>
								<input alt="Production Order"  type="text" class="input-fluid  validate[required]" name="ORDER_NUMBER" value="<?php echo $ORDER_NUMBER;?>"  onKeyUp="jspt('ORDER_NUMBER',this.value,event)" autocomplete="off" id="ORDER_NUMBER">
							</fieldset>
						</div>
						
						<div class="span3 utopia-form-freeSpace">
							<fieldset>
								<label class="control-label1 cutz" alt="Confirmed Qty" for="input01"><?php echo Controller::customize_label('Confirmed Qty');?><span> *</span>:</label>
								<input alt="Material" type="text" style="width:90%;" id='confirmed_qty' name='confirmed_qty' class="input-fluid validate[required] getval radiu" title="Material"  onKeyUp="jspt('confirmed_qty',this.value,event)" autocomplete="off" value="<?php echo $trg_qt;?>"/>
							</fieldset>
						</div>
						
						<div class="span3 utopia-form-freeSpace">
							<fieldset>
								<label style="margin-top:25px;" class="control-label1" for="input01" ><span class='cutz' alt="Final Confirmation" style="color:#333;"><?php echo Controller::customize_label('Final Confirmation');?></span> : <input type="checkbox" name="final_conf" value="X"/></label>
							</fieldset>
						</div>
						
						<div class="span3 utopia-form-freeSpace">
							<fieldset>
								<br>
								<button class="btn btn-primary span3 bbt" type="submit" id="subt" style="min-width:80px" >Submit</button>
							</fieldset>
						</div>
					</fieldset>
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
       jQuery("#validation3").validationEngine();
    });
	
</script>

