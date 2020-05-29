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
$this->renderPartial('smarttable',array('count'=>$count));
$customize = $model;
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content" style="z-index:100;">
            <form id="validation_editcustomers" action="" onsubmit='javascript:return getBapitable("example40_today","BAPIORDERS","example40","L","show_menu@<?php echo 1032;?>","Sales_orders","submit")' class="form-horizontal">
                <input type="hidden" name="url" value="editcustomers"/>
                <input type="hidden" name="btn" value="btn-primary"/>
                    <div class="span5 utopia-form-freeSpace">
                        <fieldset >
                            <div class="control-group">
                                <label class="control-label cutz" for="input01" alt='Customer Number'><?php echo Controller::customize_label(_CUSTOMERNUMBER);?><span> *</span>:</label>
                                <div class="controls myspace1">
                                    <input type="text" alt="Customer Number" class="input-fluid validate[required,custom[customer]] radius" name='CUSTOMER_ID' value="<?php echo $cust_num;?>" id="CUSTOMER_ID" autocomplete="off" /><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_ID','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'CUSTOMER_ID', 'sold_to_customer')" >&nbsp;</span>
                                    <!-- onchange="number(this.value)" onKeyUp="jspt('CUSTOMER_ID',this.value,event)" -->
                                </div>
                            </div>
                        </fieldset>
                    </div>          
                <div>
                    <button class="btn btn-primary back_b iphone_edit_cust iphone_editcust_submit <?php echo $btn;?> " type="submit" id='submit' style="width:80px;margin-top:20px"><?=_SUBMIT?></button>             
                </div>
            </form>
        </div>
    </div>
</section><?php 

?><div class="row-fluid" id='calt' style="display:none;">
    <div>
        <div class="utopia-widget-content utopia-form-tabs" >
            <div class="tabbable" >
                <ul class="nav nav-tabs menu_tab">
                    <li id='li_1' class="active"><a href="#tab41" data-toggle="tab" id="t41" class="cutz" alt='Customer Details'><?php echo Controller::customize_label(_CUSTOMERDETAILS);?></a></li>
                    <li id='li_2'><a href="#tab42" data-toggle="tab" id="t42" onclick='return getBapitable("example40_today","BAPIORDERS","example40","L","show_menu@<?php echo 1032;?>","Sales_orders","tab")' class="cutz" alt='Orders'><?php echo Controller::customize_label(_CUSTOMERORDERS);?></a></li>
                    <li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px">
                        <div id='pos_tab' ></div>
                    </li>
                </ul>
                <div class="tab-content" >
                    <div class="labl pos_pop">
                        <div class='pos_center'></div>
                        <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'><?=_CANCEL?></button>
                        <button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;"><?=_SUBMIT?></button>
                    </div>

                    <div id="exp_pop" style="display:none;" class="labl">
                        <div  style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTALL?></h4></div>
                        <div class='csv_link exp_link tab_lit' onClick="csv('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link exp_link tab_lit' onClick="excel('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                        <div style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTVIEW?></h4></div>
                        <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example40_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                    </div>
                    <div class="tab-pane active" id="tab41" style="overflow:hidden;">
                        <div id="edit_form"></div>
                    </div>

                    <div class="tab-pane" id="tab42">
                        <?php 
                        /*if($rowsag1>0) 
                        {*/
                            ?><div class="container-fluid">
                                <div class="head_icons example40" >
                                    <span id='post' tip="<?=_TABLECOLUMS?>" class="yellow post_col" onClick="table_cells('example40')"></span>
                                    <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
                                        <td><span id='mailto' tip="<?=_SENDAMAIL?>" class="yellow" onClick="mailto('example40_table')"></span></td>
                                        <td ><span id='tech' tip='<?=_TECHNICALNAMES?>' class="yellow" onClick="tech('example40')"></span></td>
                                        <td ><span id='sumr' tip="<?=_SUMNETVALUES?>" class="yellow" onClick="ssum('example40')"></span></td>
                                        <td class="tab_lit"><span id='sort' tip='<?=_MULTISORT?>' class="yellow" onClick="sorte('example40')"></span></td>
                                        <td><span id='excel' tip=" &nbsp;<?=_EXPORT?> " class="yellow" onClick="eporte('example40_table')"></span></td>
                                        <td><span id='filtes1' tip="&nbsp;<?=_FILTERS?> "  class="yellow" onClick="filtes1('example40')"></span></td>
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
                                                    ?><div id='example40_today'></div><?php 
                                                    /*if($rowsag1>10) 
                                                    {*/
                                                        ?><div class='testr example40_today' onClick='return getBapitable("example40_today","BAPIORDERS","example40","S","show_menu@<?php echo 1032;?>","Sales_orders","show_more")'><?=_SHOWMORE?></div>
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
</script>