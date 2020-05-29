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
if(isset($_REQUEST['CUSTOMER_NUMBER']))
{
    $cust_num = $_REQUEST['CUSTOMER_NUMBER'];
    $cusLenth = count($cust_num);
    //if($cusLenth < 10) { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
}
?>
<script>            
function submitForm()
{
getBapitable('table_todays','ZEMG_STRU_SD_BLOCKED_ORDER','examples','L','show_menu@<?php echo $s_wid;?>','Display_list_approve','submit');
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
$this->renderPartial('smarttable', array('count'=>$count));
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content inval38">
            <form id="validation" action="javascript:submitForm()"  class="form-horizontal">
                <input type="hidden" name='page' value="bapi">
                <input type="hidden" name="url" value="display_list_approve"/>
                
                <input type="hidden" class='tbName_examples' value='ZEMG_STRU_SD_BLOCKED_ORDER'>

                <fieldset class="span12 iphone_sales_textBox" >
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label style="text-align: left;" class="control-label cutz" alt="Sales Organization" for="inputError"><?=Controller::customize_label(_SALESORGANIZATION);?><span> *</span>:</label>
                            <input alt="Sales Organization"  id='SALES_ORGANIZATION' type="text" name='SALES_ORGANIZATION'  class="input-fluid validate[required,custom[salesorder]] radius" value="<?php echo $sale;?>" autocomplete="off">
                            <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORGANIZATION','0')" >&nbsp;</span>-->
                            <span class='minw' onclick="lookup('<?=Controller::customize_label(_SALESORGANIZATION);?>', 'SALES_ORGANIZATION', 'sales_org')" >&nbsp;</span>
                            <br/>
                            <!-- onKeyUp="jspt('SALES_ORGANIZATION',this.value,event)"  -->
                        </fieldset>
                        <br/>
                        <fieldset>
                            <label style="text-align: left;" class="control-label cutz" alt="Date" for="inputError"><?=Controller::customize_label(_FROMDATE);?>:</label>
                            <input alt="Date" type="text" name='sales_order_date' id='datepicker' class="input-fluid getval radius" />&nbsp;</span><br/>
                        </fieldset>
                    </div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label style="text-align: left;" class="control-label cutz" alt="Customer Number" for="input01"><?=Controller::customize_label(_CUSTOMERNUMBER);?>:</label>
                            <input alt="Customer Number" class="input-fluid validate[custom[customer]] radius" type="text" name='CUSTOMER_NUMBER' value="<?php echo $cust_num;?>" id="CUSTOMER_NUMBER" autocomplete="off"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_NUMBER','4@DEBIA')" >&nbsp;</span>--><span  class='minw' onclick="lookup('<?=Controller::customize_label(_CUSTOMERNUMBER);?>', 'CUSTOMER_NUMBER', 'sold_to_customer')" >&nbsp;</span>
                            <!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_NUMBER',this.value,event)" -->
                        </fieldset>
                        <br/>
                        <fieldset>
                            <label style="text-align: left;" class="control-label cutz" alt="To Date" for="inputError"><?=Controller::customize_label(_TODATE);?>:</label>
                            <input alt="To Date" type="text" name='sales_order_dateto' id='datepicker1' class="input-fluid getval radius" />&nbsp;</span><br/>
                        </fieldset>
                    </div>
                    
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label style="text-align: left;" class="control-label cutz" alt="Document Number" for="input01"><?=Controller::customize_label(_DOCUMENTNUMBER);?>:</label>
                            <input alt="Document Number" class="input-fluid  radius" type="text" name='DOCUMENT_NUMBER' value="" id="DOCUMENT_NUMBER" autocomplete="off"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_NUMBER','4@DEBIA')" >&nbsp;</span>-->
                            <!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_NUMBER',this.value,event)" -->
                        </fieldset>
                    </div>  

                </fieldset>

                <div class="span3 utopia-form-freeSpace" style="margin-bottom:10px; float:right; padding-left:33px;">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" 
                        onclick="" style="min-width:90px;" value="<?=Controller::customize_label(_SUBMIT);?>" />
                </div>                   
            </form>
        </div>
    </div>
</section><?php 
// if(isset($_REQUEST['CUSTOMER_NUMBER'])!=""){ 
?>
<div class="container-fluid">
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
                            <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'><?=_CANCEL?></button>
                            <button class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;"><?=_CANCEL?></button>
                        </div>

                        <div class="head_icons" style="width:872px;">
                            <span id='post' tip="<?=Controller::customize_label(_TABLECOLUMS);?>" class="yellow post_col" onClick="table_cells('examples')"></span>
                            <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
                                <td><span id='mailto' tip="<?=Controller::customize_label(_SENDMAIL);?>" class="yellow" onClick="mailto('examples_table')"></span></td>
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

                        <div class='testr table_todays' onClick='getBapitable("table_todays","ZEMG_STRU_SD_BLOCKED_ORDER","examples","S","show_menu@<?php echo $s_wid;?>","Display_list_approve","show_more")'><?=_SHOWMORE?></div>
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
$t_headers=Controller::technical_names('BAPIORDERS');
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
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>

<script type="text/javascript">
$(document).ready(function() {      
/*
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
$('#datepicker').val(today);
*/
$('#datepicker, #datepicker1').datepicker({
format: 'mm/dd/yyyy',
weekStart: '0',
        autoclose:true
}).on('changeDate', function()
{
$('.datepickerformError').hide();
});            
jQuery("#validation").validationEngine();
});
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