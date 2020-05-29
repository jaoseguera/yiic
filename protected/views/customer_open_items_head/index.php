
<?php
$cust_num = "";
$sale     = "";
$busi     = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $cust_num="10000051";
    $sale="1000";
    $busi="10";
    $cusLenth = count($cust_num);
    //if($cusLenth < 10 && $cust_num!='') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
}

?>
<script>

var s="Customer_open_items_head";			
function submitForm() 
{
if(s=="Customer_open_items_head")
{
var url = $("#validation input[name='url']").val();
$('#loading').show();
$("body").css("opacity","0.4");
$("body").css("filter","alpha(opacity=40)");
var datastr=$('#validation').serialize();
datastr = datastr;
$.ajax(
	{
		type:'POST',
		data:datastr,
		url: url+'/header',
		success: function(response)
		{
		$('#utopia-wizard').show();
		$('#head').html(response);
		getBapitable("table_todays","BAPI3007_2","examples","L","show_menu@<?php echo $s_wid;?>",s,"submit");
		}
	});

	
//submit_form('validation');
//getBapitable("table_todays","BAPI3007_2","examples","L","show_menu@<?php echo $s_wid;?>",s,"submit");
}else	
	getBapitable("table_todays","BAPI3007_2","examples","L","show_menu@<?php echo $s_wid;?>",s,"submit");

}
$(document).ready(function() 
{
    $(".theme-changer a").on('click', function() 
    {
        $('link[href*="utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
});

function resetform()
{
    document.getElementById("sname").value=null;
    document.getElementById("sstreet").value=null;
    document.getElementById("scity").value=null;
    document.getElementById("scountry").value=null;
    document.getElementById("sstate").value=null;
}

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
        document.getElementById('CUSTOMER_NUMBER').value=str;
    }
}
</script>

<?php
if(isset($_REQUEST['titl']))
{
    ?><script>
    $(document).ready(function()
    {
        parent.titl("<?php echo $_REQUEST['titl'];?>");
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    })
    </script><?php 
}
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;
$this->renderPartial('smarttable',array('count' => $count));
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
	<div class="row-fluid">
		<div class="utopia-widget-content inval38">
			<form id="validation"  action="javascript:submitForm()" class="form-horizontal">
				<input type="hidden" name='page' value="bapi">
				<input type="hidden" name="url" value="customer_open_items_head"/>
				<input type="hidden" name="key" value="customer_open_items_head"/>
				
				<input type="hidden" class='tbName_examples' value='BAPI3007_2'>

				<fieldset class="span12 iphone_sales_textBox" >
					<div class="span3 utopia-form-freeSpace">
						<fieldset>
							<label style="text-align: left;" class="control-label cutz" alt="Customer Number" for="input01"><?=Controller::customize_label(_CUSTOMERNUMBER);?><span> *</span>:</label>
							<input alt="Customer Number" class="input-fluid validate[required,custom[customer]] radius" type="text" name='CUSTOMER_NUMBER' value="<?php echo $cust_num;?>" id="CUSTOMER_NUMBER" autocomplete="off"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_NUMBER','4@DEBIA')" >&nbsp;</span>--><span  class='minw' onclick="lookup('<?=Controller::customize_label(_CUSTOMERNUMBER);?>', 'CUSTOMER_NUMBER', 'sold_to_customer')" >&nbsp;</span>
							<!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_NUMBER',this.value,event)" -->
						</fieldset>
						<br/>
						<fieldset>
							<label style="text-align: left;" class="control-label cutz fod" alt="Date" for="inputError"><?=Controller::customize_label(_KEYDATE);?><span> *</span>:</label>
							<input alt="Date" type="text" name='sales_order_date' id='datepicker'  class="input-fluid getval radius validate[required] fod" />&nbsp;<br/>
						</fieldset>
					</div>

					<div class="span3 utopia-form-freeSpace">
						<fieldset>
							<label style="text-align: left;" class="control-label cutz" alt="Company code" for="inputError"><?=Controller::customize_label(_COMPANYCODE);?><span> *</span>:</label>
							<input alt="Company Code"  id='COMPANY_CODE' type="text" name='COMPANY_CODE'  class="input-fluid validate[required] radius" value="<?php echo $sale;?>" autocomplete="off">
                          
                            <span class='minw' onclick="lookup('<?=Controller::customize_label(_COMPANYCODE);?>', 'COMP_CODE', 'company_code')" >&nbsp;</span>
                            <br/>
							<!-- onKeyUp="jspt('SALES_ORGANIZATION',this.value,event)"  -->
						</fieldset>
						<br/>
						<fieldset>
							<label style="text-align: left;" class="control-label cutz tod" alt="To Date" for="inputError"><?=Controller::customize_label(_POSTINGDATE);?><span> *</span>:</label>
							<input alt="To Date" type="text" name='sales_order_dateto' id='datepicker1' class="input-fluid getval radius validate[required] tod" />&nbsp;</span><br/>
						</fieldset>
					</div>

				

					<div class="span4 utopia-form-freeSpace">
						<fieldset>
						<br/>
						<input type='radio' onclick="changeradio(this);" name='items' value='open' checked>&nbsp;<span><?=_OPENITEMS?></span>  &nbsp;&nbsp;&nbsp;
						<input type='radio' onclick="changeradio(this);" name='items' value='all'>&nbsp;<span><?=_ALLITEMS?> </span> 
						</fieldset>
						
					</div>
					
				</fieldset>

				<div class="span3 utopia-form-freeSpace" style="margin-bottom:10px; float:right; padding-left:33px;">
						<input type="submit" name="submit" id="submit" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" 
						onclick="" style="min-width:90px;" value="<?=_SUBMIT?>" />
				</div>                   
			</form>
		</div>
	</div>
</section>  
<section id='utopia-wizard' class="utopia-widget utopia-form-box">
	<div class="row-fluid">
		<div class="utopia-widget-content inval38">
 <div  class="form-horizontal" id="head">
         
      
   </div>
  </div>
  </div>
</section>
<div class="">
	<div class="row-fluid">
		<!-- Body start -->
		<div>
			<div>
				<div>
					<div style="overflow-y:hidden;padding-bottom:55px;" class="edge"><?php 
					// if($SalesOrder==NULL) {
						?>
						<div class="labl pos_pop">
							<div class='pos_center'></div>
							<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
							<button class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
						</div>

						<div class="head_icons" style="width:872px;">
							<span id='post' tip="<?=Controller::customize_label(_TABLECOLUMS);?>" class="yellow post_col" onClick="table_cells('examples')"></span>
							<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
								<td><span id='mailto' tip="<?=Controller::customize_label(_SENDMAIL);?>" class="yellow" onClick="mailtoview('examples_table')"></span></td>
								<td ><span id='tech' tip='<?=Controller::customize_label(_TECHNICALNAMES);?>' class="yellow" onClick="tech('examples')"></span></td>
								<td ><span id='sumr' tip="<?=Controller::customize_label(_SUMNETVALUES);?>" class="yellow" onClick="ssum('examples')"></span></td>
								<td class="tab_lit"><span id='sort' tip='<?=Controller::customize_label(_MULTISORT);?>' class="yellow" onClick="sorte('examples')"></span></td>
								<td><span id='excel' tip=" &nbsp;<?=Controller::customize_label(_EXPORT);?> " class="yellow" onClick="eporte('examples_table')"></span></td>
								<td><span id='filtes1' tip='&nbsp; <?=Controller::customize_label(_FILTERS);?> ' class="yellow" onClick="filtes1('examples')"></span></td>
							</tr></table>
						</div>

						<div id="exp_pop" style="display:none;" class="labl">
							<div style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTALL?></h4></div>
							<div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
							<div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
							<div class='pdf_link exp_link' style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
							<div style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTVIEW?></h4></div>
							<div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
							<div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
							<div class='pdf_link exp_link' style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
						</div><?php 
						// }
						?><div id='table_todays'></div>

						<div class='testr table_todays all' onClick='getBapitable("table_todays","BAPI3007_2","examples","S","show_menu@<?php echo $s_wid;?>","Customer_all_items","show_more")'><?=_SHOWMORE?></div>
						<div id='examples_num' style="display:none;">10</div>
						<div class='testr table_todays open' onClick='getBapitable("table_todays","BAPI3007_2","examples","S","show_menu@<?php echo $s_wid;?>","Customer_open_items_head","show_more")'><?=_SHOWMORE?></div>
						<div id='examples_num' style="display:none;">10</div>
					</div>
				</div>
			</div>
		</div><!-- Body end -->
	</div><!-- Maincontent end -->
</div> <!-- end of container -->

<div id='export_table' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div>
<div id='examples_table' style="display:none">
<?php 
$technical = $model;
$t_headers=Controller::technical_names('ZBAPI_RVKRED_TS_POST');
foreach($SalesOrder as $number_keys => $array_values)
{
    foreach($array_values as $header_values => $row_values)
    {
        $header_values1 = $t_headers[$header_values];
        unset($array_values[$header_values]);
        $array_values[$header_values1] = $row_values;
    }
    $SalesOrder[$number_keys] = $array_values;
}
echo json_encode($SalesOrder);
?>
</div>
<script>
$(document).ready(function(e) 
{

		$('#utopia-wizard').hide();
        $(".head_icons").hide();
        $(".testr").text('');
		$('.tod').hide();
		$('.all').hide();
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

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>

<script type="text/javascript">


$(document).ready(function() {     
 
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
var ly= today.getFullYear()-1;
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
var today = mm+'/'+dd+'/'+yyyy;
var last = mm+'/'+dd+'/'+ly;
$('#datepicker').val(today);

$('#datepicker').datepicker({
format: 'mm/dd/yyyy',
weekStart: '0',
        autoclose:true
}).on('changeDate', function()
{
$('.datepickerformError').hide();
});            
jQuery("#validation").validationEngine();
});

function changeradio(name)
			{
			if(name.value=='open')
			{
			$('#datepicker').val(today);
			s="Customer_open_items_head";
			$('.all').hide();
			$('.open').show();
			$('.tod').hide();
			$('.fod').html('Key Date <span> *</span>:');
			}else {
			s="Customer_all_items";
			$('.all').show();
			$('.open').hide();
			$('.tod').show();
			$('#datepicker').val(last);
			$('#datepicker1').val(today);
			$('.fod').html('Posting From Date <span> *</span>:')
			}
			}
/*$(document).ready(function() 
{
    $(document).ready(function() 
    { 
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
        $('#datepicker').val(today);

        $('#datepicker').datepicker({
                format: 'mm/dd/yyyy',
                weekStart: '0'
        });
        $('#datepicker').focusout(function() 
        {
                $('.dropdown-menu').hide();
        });
        jQuery("#validation").validationEngine();
    });

    jQuery("#validation").validationEngine();
    jQuery("#validation1").validationEngine();
    $('.head_fix').css({display:'none'});
    $(document).scroll(function()
    {
        $('#examplefix').css({display:'block'});
    });
}); */
</script>