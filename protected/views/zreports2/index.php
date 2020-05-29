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
$this->renderPartial('smarttable');
?>
<style>
.cust-submit
{
	margin-bottom:10px;
	float:right !important;
	margin-right:30px !important;
	margin-top:30px !important;
}
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section">
    <div class="row-fluid">
        <div class="utopia-widget-content">
			<form id="validation" action="javascript:custom_ajaxform('validation','zreports2');" class="form-horizontal">
				<div class="span5 utopia-form-freeSpace">
					<fieldset>
						<div class="control-group">
							<input type="hidden" name='page' value="bapi">
							<input type="hidden" name="url" value="zreports2"/>
							<input type="hidden" name="key" value="zreports1"/>
							<label class="control-label cutz" alt="Production Order" for="date"><?php echo Controller::customize_label('Report Name');?><span> *</span>:</label>
							<div class="controls myspace1">
								<input  alt="Report Name" type="text" class="input-fluid  validate[required]" name="REPORT_NAME" id='REPORT_NAME' value="" tabindex="1" onKeyUp="jspt('REPORT_NAME',this.value,event)" autocomplete="off">
							</div>
						</div>
					</fieldset>
				</div>
                <div id='customfiles'></div>
				<div class="utopia-form-freeSpace">
					<div class="controls">
						<br>
						<button class="btn btn-primary span1 bbt custms-btn" type="submit" id="subt" style="min-width:80px;">Submit</button>
					</div>
				</div>
			</form>
             
		</div>
	</div>
</section>
<div class="reports_text" style="display:none;"><?php
$this->renderPartial('tabletop');
?></div>
<div id='report_text'></div>
<div class='testr report_text' style="display:none;" onClick='getBapitable("report_text","ZREPORTS","example","S","show_cus@<?php echo $s_wid;?>","zreports2","show_more")'>Show more</div>
                                <div id='example_num' style="display:none;">10</div>
                                <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>
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
	  $(document).ready(function(e) 
        {
            $('.search_int').keyup(function () 
            {
                sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
            })
            //data_table('example');
            $('#example').each(function()
            {})

            $('.head_fix').css({display:'none'});
            $(document).scroll(function()
            {
                $('.head_fix').css({display:'none'});
                $('#examplefix').css({display:'block'});
            });
            var wids=$('.table').width();
            $('.head_icons').css({ width:wids+'px' });
        });
</script>

