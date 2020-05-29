<?php
// This is a Proof-of-Concept version that has not been reviewed.
// print_r($_REQUEST);
$customer = NULL;
$cust_num = NULL;
$btn = "";
$customize 	= $model;
	$client 	= Controller::userDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$all_docs 	= $client->getAllDocs();
	$cmp=Controller::companyDbconnection();
	$cmpdoc=$cmp->getDoc($Company_ID);
	$roles=array();
	foreach($cmpdoc->roles as $key=>$val)
	{
	array_push($roles,$key);
	}
	array_push($roles,'Primary');
	$usr=Yii::app()->user->getState("user_id");
	$u_doc=$client->getDoc($usr);
	$userRole=$doc->profile->roles;
	if(isset($cmpdoc->roles->$userRole->customer->approvecustomers))
	{
	foreach ($all_docs->rows as $key => $row)
	{
		$sel='';
		$doc	= $client->getDoc($row->id);
		if($doc->company_id != $Company_ID || (!in_array($doc->profile->roles,$roles)))
			unset($all_docs->rows[$key]);
	}
	}else
	{
	foreach ($all_docs->rows as $key => $row)
	{
		$sel='disabled';
		if($row->id!=$usr)
			unset($all_docs->rows[$key]);
	}
	}
	
$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');


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
<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader2.gif' style="display:none">
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content" style="z-index:100;">
            <form id="validation" action="" onsubmit='javascript:return getBapitable("example40_today","BAPI0012_2","example40","L","show_menu@<?php echo 1032;?>","Editcostcenter_master","submit")'  class="form-horizontal">
                <input type="hidden" name="url" value="list_costcenter"/>
                <input type="hidden" name="btn" value="btn-primary"/>
                    <div class="span5 utopia-form-freeSpace">
                        <fieldset >
                            
							<div class="control-group">
								<label class="control-label cutz" for="date" alt='Postal Date'><?php echo Controller::customize_label('Control Area');?><span>*</span>:</label>
								<div class="controls">
									<input class="input-fluid validate[required] minw1 span10" type="text"  name="C_AREA"  id='C_AREA' > 
								</div>
							</div>
						</fieldset>
                    </div>
					<div class="span5 utopia-form-freeSpace">
						<fieldset>
						
						<div class="control-group">
							<label class="control-label cutz" for="date" alt='Postal Date'><?php echo Controller::customize_label('Company Code');?><span>*</span>:</label>
							<div class="controls">
								<input class="input-fluid validate[required] minw1" type="text"  name="C_CODE"  id='C_CODE' > 
								<span class='minw' onclick="lookup('Company Code', 'COMP_CODE', 'company_code')" >&nbsp;</span>
							</div>
						</div>
						</fieldset>
					</div>
				<div class="span12">
                    <button class="btn btn-primary back_b iphone_edit_cust  iphone_editcust_submit <?php echo $btn;?> "  type="submit" id='submit' style="width:80px;margin-bottom:10px;margin-left:80%">Submit</button>				
                </div>
            </form>
        </div>
    </div>
</section>
<div class="row-fluid" id='calt' style="display:none">
    <div>
        <div class="utopia-widget-content utopia-form-tabs" >
            <div class="tabbable" >
                <ul class="nav nav-tabs menu_tab">
                    <li id='li_2' class="active"><a href="#tab42" data-toggle="tab" id="t42"  class="cutz" alt='Orders'><?php echo Controller::customize_label('List');?></a></li>
                    <li id='li_1' ><a href="#tab41"  id="t41" class="cutz" alt='Customer Details'><?php echo Controller::customize_label('Costcenter Details');?></a></li>
					<li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px">
                        <div id='pos_tab' ></div>
                    </li>
                </ul>
                <div class="tab-content" >
                    <div id="exp_pop" style="" class="labl">
                        <div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
                        <div class='csv_link exp_link tab_lit' onClick="csv('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link exp_link tab_lit' onClick="excel('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                        <div style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
                        <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                    </div>
                    <div class="tab-pane active" id="tab41" style="overflow:hidden;display:none">
                        <div id="edit_form"></div>
                    </div>

                    <div class="" id="tab42">
                        <?php 
                        /*if($rowsag1>0) 
                        {*/
                            ?><div class="container-fluid">
                                 <div class="head_icons example40" >
                                    <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
                                        <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example40_table')"></span></td>
                                        <td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example40')"></span></td>
                                        <td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example40')"></span></td>
                                        <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example40')"></span></td>
                                        <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example40_table')"></span></td>
                                        <td><span id='filtes1' tip="&nbsp; Filters "  class="yellow" onClick="filtes1('example40')"></span></td>
                                    </tr></table>
                                </div>
                                <div class="row-fluid">
                                    <!-- Body start -->
                                    <div>
                                        <div>
                                            <div>
                                                <div  style="overflow-y:hidden;padding-bottom:55px;" class="edge1"><?php 
                                                /*if($SalesOrder!=NULL)
                                                {*/
                                                    ?>
													
													<div id='example40_today'>
													
													</div><?php 
                                                    /*if($rowsag1>10) 
                                                    {*/
                                                        ?><div class='testr example40_today' onClick='return getBapitable("example40_today","ZMDRHDR","example40","S","show_menu@<?php echo 1032;?>","Approve_customers_master","show_more")'>Show more</div>
                                                        <div id='example40_num' style="display:none;">10</div><?php 
                                                    //}										
                                                //} 
                                                ?><div id='example40_table' style="display:none"><?php echo json_encode($SalesOrder);?></div>
                                                <div id='export_table' style="display:none"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- Body end -->
                                </div><!-- Maincontent end -->
                            </div><?php 
                        /*} 
                        else 
                        { 
                            echo "Match Not Found"; 
                        }*/
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="material_pop"></div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
function changecalt()
{
$('#calt').show();
}
$(document).ready(function() 
{
$('#datepicker, #datepicker1').datepicker({
format: 'mm/dd/yyyy',
weekStart: '0',
        autoclose:true
}).on('changeDate', function()
{
$('.datepickerformError').hide();
});            
jQuery("#validation").validationEngine();

<?php
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
    $('#t42').click(function(){ $('#tab41').css({display:'none'}); $('#tab42').css({display:'block'}); });
	$('#t41').click(function(){ $('#li_1').addClass("active");
$('#li_2').removeClass("active");
$('#tab41').addClass("active");
$('#tab42').css({display:'none'});
 $('#tab41').css({display:'block'});
});
    
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
function change(vl)
{

title=$('#t41').html();

$('#li_1').addClass("active");
$('#li_2').removeClass("active");
$('#tab41').addClass("active");
$('#tab42').css({display:'none'});
  $('#loading').show();
  $("body").css("opacity","0.4"); 
  $("body").css("filter","alpha(opacity=40)"); 
            var datastr = $('#validation').serialize();

   $.ajax(
    {
        type:'POST', 
        url: 'editcostcenter_master/costcenter_details',
		data:'cust='+vl+'&'+datastr,
        success: function(response) 
        {
		$('#edit_form').html(response);
		$('#loading').hide();
            $("body").css("opacity", "1"); 
		}
		}); 
		$('#t41').html('Cost Center-'+vl);
$('#tab41').css({display:'block'});

}
</script>