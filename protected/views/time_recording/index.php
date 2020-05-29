<?php
	$po_order	= "";
	$emp_id		= "";

	$sysnr = Yii::app()->user->getState('SYSNR');
	$sysid = Yii::app()->user->getState('SYSID');
	$clien = Yii::app()->user->getState('CLIENT');

	if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
	{
		$po_order	= "1000004";
		$emp_id		= "1000002";
	}
	
	if(isset($_REQUEST['titl']))
	{
		?>
		<script>
			$(document).ready(function()
			{
				parent.titl("<?php echo $_REQUEST['titl'];?>");
				parent.subtu('<?php echo $_REQUEST["tabs"];?>');
			});
		</script>
		<?php 
	}
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
	<div class="row-fluid">
		<div class="utopia-widget-content inval38">
			<!--<form id="validation" action="" onsubmit="javascript:return getBapitable('table_todays','BAPI_ORDER_OPERATION1','examples','L','show_menu@<?php // echo $s_wid;?>','time_recording','submit')" class="form-horizontal">-->
			<form id="validation" method="post" onsubmit="javascript:return getoperations();" class="form-horizontal">
				<input type="hidden" name='from' value="<?php echo _SUBMIT ?>">
				<input type="hidden" name='t_id' value="table_todays">
				<input type="hidden" name='page' value="bapi">
				<input type="hidden" name="url" value="time_recording"/>
				<input type="hidden" class='tbName_examples' value='BAPI_ORDER_OPERATION1'>
				<fieldset class="span12 iphone_sales_textBox" >
					<div class="span3 utopia-form-freeSpace">
						<fieldset>
							<label style="text-align: left;" class="control-label cutz" alt="Production Order" for="input01"><?php echo Controller::customize_label('Production Order');?><span> *</span>:</label>
							<input alt="Production Order" class="input-fluid validate[required] radius" type="text" name='Production_Order' value="<?php echo $po_order;?>" id="Production_Order" autocomplete="off"><!--<span class='minw' onclick="tipup('BUS2005','CHECKMATERIALAVAILABILITY','ORDERS','ORDER_NUMBER','Production Order Number','Production_Order','0')" >&nbsp;</span>-->
						</fieldset>
					</div>
					<div class="span3 utopia-form-freeSpace">
						<fieldset>
							<label style="text-align: left;" class="control-label cutz" alt="Employee ID" for="inputError"><?php echo Controller::customize_label('Employee ID');?><span> *</span>:</label>
							<input alt="Employee ID"  id='Employee_ID' type="text" name='Employee_ID' class="input-fluid validate[required]" value="<?php echo $emp_id;?>" autocomplete="off"><br/>
						</fieldset>
					</div>
					<div class="span3 utopia-form-freeSpace">
						<br /><input type="submit" name="submit" id="submit" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" style="min-width:90px;" value="<?php echo _SUBMIT ?>" />
					</div>
				</fieldset>
			</form>
			<br /><br /><br />
		</div>
	</div>
</section>

<div class="container-fluid">
	<div class="row-fluid">
		<div id='table_todays'></div>
	</div><!-- Maincontent end -->
</div> <!-- end of container -->
<script>
$(document).ready(function(e) 
{
        $(".head_icons").hide();
        $(".testr").text('');
        var wids=$('#utopia-wizard-form').width()-60;
        if(wids<180)
        {
            wids=$('#out_put').width()-100;
        }
        $('.head_icons').css(
        {
            'min-width':wids+'px'
        });
        $('.search_int').keyup(function () 
        {
            sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
        })

        data_table('examples');
        $('#examples').each(function()
        {
            $(this).dragtable(
            {
                placeholder: 'dragtable-col-placeholder test3',
                items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                appendTarget: $(this).parent(),
                tableId: 'examples',
                tableSess: 'table_todays',
                scroll: true
            });
        })
        var wids=$('.table').width();
        $('.head_icons').css({
            width:wids+'px'
        });
});
</script><?php 
// }

?><div class="material_pop" ></div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	jQuery("#validation").validationEngine();
});

function getoperations()
{
	jQuery("#operations_table_form").validationEngine('hideAll');
	sts = jQuery("#validation").validationEngine('validate');
	if(sts)
	{
		dataStrings = $('#validation').serialize();
		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->createAbsoluteUrl("time_recording/tabledata"); ?>",
			data: dataStrings,
			success: function(data)
			{
				$('#loading').hide();
				$("body").css("opacity","1");
				$('#table_todays').html(data);
			}
		});
	}
	return false;
}
</script>