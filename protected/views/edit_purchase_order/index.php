<?php
$PURCHASE_ORDER = "";

if(isset($_REQUEST['PURCHASE_ORDER']))
   $PURCHASE_ORDER = $_REQUEST['PURCHASE_ORDER'];
?>
<style>
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.check { display:none !important; }
</style>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
	<div class="row-fluid">
		<div class="utopia-widget-content">
			<form id="validation3" action="javascript:submit_form('validation3');" class="form-horizontal">
				<div class="form-horizontal">
					<div class="span7 utopia-form-freeSpace">
						<fieldset>
							<div class="control-group">
								<input type="hidden" name='page' value="bapi">
								<input type="hidden" name="url" value="edit_purchase_order"/>
								<input type="hidden" name="key" value="edit_purchase_order"/>
								<label class="control-labels cutz" style="width:160px" alt="Purchase Order Number" for="date"><?php echo Controller::customize_label('Purchase Order Number');?><span> *</span>:&nbsp;</label>
								<div class="span7 controls">
									<input alt="1" class="input-fluid validate[required] radius" type="text" name='PURCHASE_ORDER' id="PURCHASE_ORDER" value="<?php echo $PURCHASE_ORDER;?>" onKeyUp="jspt('PURCHASE_ORDER',this.value,event)" autocomplete="off" onChange='number(this.value)'> <span  class='minw3'  onclick="lookup('Purchase order number','PURCHASE_ORDER','po_number')" >&nbsp;</span>
                                    <!--<span  class='minw3'  onclick="tipup('BUS2012','GETDETAIL1','POHEADER','PO_NUMBER','Purchase order number','PURCHASE_ORDER','4@MEKKM')" >&nbsp;</span>-->

								</div>
							</div>
						</fieldset>
					</div>
					<div>
						<button class="span2 btn btn-primary back_b iphone_sales_disp <?php echo $btn; ?>" type="submit" id='submit' style='margin-left:100px;margin-top:20px'>Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		jQuery("#validation3").validationEngine();
	});
</script>
<?php
	if(isset($_REQUEST['PURCHASE_ORDER']))
		$this->renderPartial('editpo');
	
	if(isset($_REQUEST['titl']))
	{
		?>
		<script>
			$(document).ready(function()
			{
				parent.titl('<?php echo $_REQUEST["titl"]; ?>');
			});
		</script>
		<?php
	}
?>