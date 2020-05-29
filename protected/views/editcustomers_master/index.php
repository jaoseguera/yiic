<?php
// This is a Proof-of-Concept version that has not been reviewed.
// print_r($_REQUEST);
$customer = NULL;
$cust_num = NULL;
$btn = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $cust_num = "10000051";
}

if(isset($_REQUEST['CUSTOMER_ID']))
{
    $cust_num = $_REQUEST['CUSTOMER_ID'];
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

?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content" style="z-index:100;">
            <form id="validation_editcustomers" action=""  class="form-horizontal">
                <input type="hidden" name="url" value="editcustomers"/>
                <input type="hidden" name="btn" value="btn-primary"/>
                    <div class="span5 utopia-form-freeSpace">
                        <fieldset >
                            <div class="control-group">
                                <label class="control-label cutz" for="input01" alt='Customer Number'><?php echo Controller::customize_label('Customer Number');?><span> *</span>:</label>
                                <div class="controls myspace1">
                                    <input type="text" alt="Customer Number" class="input-fluid validate[required,custom[customer]] radius" name='CUSTOMER_ID' value="" id="CUSTOMER_ID" autocomplete="off" /><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_ID','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'CUSTOMER_ID', 'sold_to_customer')" >&nbsp;</span>
                                    <!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_ID',this.value,event)" -->
                                </div>
                            </div>
                        </fieldset>
                    </div>			
                <div>
                    <button class="btn btn-primary back_b iphone_edit_cust iphone_editcust_submit <?php echo $btn;?> " onclick="return displayCustomer()" type="submit" id='submit' style="width:80px;margin-top:20px">Submit</button>				
                </div>
            </form>
        </div>
    </div>
</section><?php 

?><div class="utopia-widget " style="z-index:100;"><div class="row-fluid" id='calt' style="">
   </div> </div>
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
data_table('example40');
$('#example40').each(function(){
    $(this).dragtable({
        placeholder: 'dragtable-col-placeholder test3',
        items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
        appendTarget: $(this).parent(),
        tableId: 'example40',
        tableSess: 'example40_today',
        scroll: true
    });
})

$('.head_fix').css({display:'none'});
$(document).scroll(function() { $('.head_fix').css({display:'none'}); });
$('#t1').click(function()
{
    $('.head_fix').css({display:'none'});
    $(document).scroll(function()
    {
        $('.head_fix').css({display:'none'});
    });
})

$('#t2').click(function()
{
    $('.head_fix').css({display:'none'});
    $(document).scroll(function()
    {
        $('.head_fix').css({display:'none'});
        $('#examplefix').css({display:'block'});
    });
})
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

if($.cookie("css")) {
    $('link[href*="utopia-white.css"]').attr("href",$.cookie("css"));
    $('link[href*="utopia-dark.css"]').attr("href",$.cookie("css"));
}
$(document).ready(function() {
    $('#t42').click(function(){ $('.editcustomers_page').hide(); });
    $('#t41').click(function(){ $('.editcustomers_page').show(); });
    $(".theme-changer a").on('click', function() {
        $('link[href*="utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
});

function cancels()
{		
    $('#calt').hide();
}

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) { str = '0' + str; }
        document.getElementById('CUSTOMER_ID').value = str;
    }
}
function displayCustomer()
{
$("#validation_editcustomers").validationEngine();
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)");
  $.ajax({type:'POST',
            url: 'editcustomers_master/displaycustomer', 
            data:$('#validation_editcustomers').serialize(), 
            success: function(response) {
                    $('#loading').hide();
                    $("body").css("opacity","1"); 
                   $('#calt').html(response);
			$(".read").attr('readonly','readonly');
			}
			
    });	
return false;
}
</script>