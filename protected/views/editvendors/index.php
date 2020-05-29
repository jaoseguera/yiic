<?php
// print_r($_REQUEST);
$customer = NULL;
$cust_num = NULL;
$btn = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $cust_num = "300000";
}

if(isset($_REQUEST['VENDOR']))
{
    $cust_num = $_REQUEST['VENDOR'];
    $cusLenth = count($cust_num);
    //if($cusLenth < 10 && $cust_num != '') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
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
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader2.gif' style="display:none"><?php 
$this->renderPartial('smarttable');
$customize = $model;
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content" style="z-index:100;">
            <form id="validation_editcustomers" action='javascript:getvendor("validation_editcustomers")' class="form-horizontal">
				<input type="hidden" name="url" value="editvendors"/>
                <input type="hidden" name="btn" value="btn-primary"/>
                    <div class="span5 utopia-form-freeSpace">
                        <fieldset >
                            <div class="control-group">
                                <label class="control-label cutz" for="input01" alt='Customer Number'><?php echo Controller::customize_label('Vendor Number');?><span> *</span>:</label>
                                <div class="controls myspace1">
                                    <input type="text" alt="Vendor Number" class="input-fluid validate[required] radius" name='VENDOR' value="<?php echo $cust_num;?>" id="VENDOR" autocomplete="off" /><!--<span  class='minw3'  onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
                                    <!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_ID',this.value,event)" -->
                                </div>
                            </div>
                        </fieldset>
                    </div>			
                <div>
                    <button class="btn btn-primary back_b iphone_edit_cust iphone_editcust_submit <?php echo $btn;?> " type="submit" id='submit' style="width:80px;margin-top:20px">Submit</button>				
                </div>
            </form>
        </div>
    </div>
</section><div class="row-fluid" >
    <div>
        <div class="utopia-widget-content utopia-form-tabs" >
           
             
                        <div id="edit_form"></div>
                    

        </div>
    </div>
</div>
<div class="material_pop"></div>

<script type="text/javascript">
$(document).ready(function() 
{<?php
    if(isset($_REQUEST['type'])) {
        ?>$('#submit').trigger('click'); $('#submit').css('visibility','hidden');<?php
    }
?>$('.search_int').keyup(function () {
        sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
});	


$('.head_fix').css({display:'none'});
$(document).scroll(function() { $('.head_fix').css({display:'none'}); });

var wids=$('.table').width();
if(wids<180)
{
    wids=$('#out_put').width()-100;
}
$('.head_icons').css({ width:wids+'px'});
});
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    jQuery("#validation").validationEngine();
    jQuery("#validation1").validationEngine();
    jQuery("#validation_editcustomers").validationEngine();
});

function getvendor(ids)
{
	$('#loading').show();
	$("body").css("opacity","0.4"); 
	$("body").css("filter","alpha(opacity=40)");
	$.ajax(
	{
		type:'POST', 
		data:$('#'+ids).serialize(), 
		url: 'editvendors/edit_vendors',
		success: function(response) 
		{		
			//alert(response);
			$('#loading').hide();
			$("body").css("opacity","1"); 
			$('#edit_form').show();
			$('#edit_form').html(response);
		}
	});
}
</script>