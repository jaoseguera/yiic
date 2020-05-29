<?php
if(!isset($_REQUEST['CUSTOMER_NUMBER']))
{
    $cuid="";
}
else
{
    $cuid=$_REQUEST['CUSTOMER_NUMBER'];
    $cusLenth = count($cuid);
    //if($cusLenth < 10 && $cuid != '') { $cuid = str_pad((int) $cuid, 10, 0, STR_PAD_LEFT); } else { $cuid = substr($cuid, -10); }
}

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $cuid = "10000051";
    $cusLenth = count($cuid);
    //if($cusLenth < 10 && $cuid != '') { $cuid = str_pad((int) $cuid, 10, 0, STR_PAD_LEFT); } else { $cuid = substr($cuid, -10); }
}

?><script>
if($.cookie("css")) {
    $('link[href*="utopia-white.css"]').attr("href",$.cookie("css"));
    $('link[href*="utopia-dark.css"]').attr("href",$.cookie("css"));
}

function resetform()
{			
    document.getElementById("sname").value=null;
    document.getElementById("sstreet").value=null;
    document.getElementById("scity").value=null;
    document.getElementById("scountry").value=null;
    document.getElementById("sstate").value=null;
}
function show_bar(ids)
{
    $('.active').removeClass('active')
    $('#'+ids).trigger('click');
}

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) { str = '0' + str; }
        document.getElementById('CUSTOMER_NUMBER').value=str;
    }
}
</script>
</head>

    <div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php
    $customize = $model;
    $this->renderPartial('smarttable');
    ?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box" style="overflow-y:hidden">
        <div class="row-fluid">
            <div class="utopia-widget-content inval28">
                <h4 class="filter_note">Note : Use at least one filter for fast search results</h4>
                <form id="validation" action="" class="form-horizontal">
                    <input type="hidden" name="url" value="sales_order_dashboard"/>
                    
                    <div class="span5 utopia-form-freeSpace">					
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label cutz" alt="Customer Number" for="input01"><?php echo Controller::customize_label('Customer Number');?><span> *</span>:</label>
                                <div class="controls myspace1">
                                    <input  alt="Customer Number" class="input-fluid validate[required,custom[customer]] radius" type="text" name='CUSTOMER_NUMBER' value="<?php echo $cuid;?>" id="CUSTOMER_NUMBER" onKeyUp="jspt('CUSTOMER_NUMBER',this.value,event)" autocomplete="off"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER_NUMBER','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'CUSTOMER_NUMBER', 'sold_to_customer')" >&nbsp;</span>
                                    <!-- onchange = "number(this.value)"  -->
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="span2 utopia-form-freeSpace">
                        <table cellpadding="5" style="margin-top:-8px;">
                            <tr>
                                <td><button class="btn btn-primary spanbt bbt back_b" type="submit" onclick='return getBapitable("table_today","BAPIORDERS","example","L","show_menu@<?php echo $s_wid;?>","Sales_order_dashboard","submit")'>Submit</button></td>
                            </tr>
                        </table>
                    </div>                         
                </form>
            </div>
        </div>
    </section><?php 
    /* if(isset($_REQUEST['CUSTOMER_NUMBER'])!="")
    { 
        if($SalesOrder==NULL)
        {
            echo 'Match Not Found';
            exit;
        }
        */
        ?>
        <div class="container-fluid" style="display:none;">
            <div class="row-fluid">
                    <div class="span5 barch" id="graph"></div>

                    <!-- Body start -->
                <div class="row-fluid edge2" >
                    <div class="span12">
                        <ul id="menu_tab" class="nav nav-tabs menu_tab" >
                                <li id='li_1' class="active count_li">
                                        <a href="#tab1" data-toggle="tab" id='t1' onClick='getBapitable("table_today","BAPIORDERS","example","L","show_prod@<?php echo $s_wid;?>","Sales_order_dashboard","tab")'>Sales Order</a>
                                </li>
                                <li id='li_2' class="count_li">
                                        <a href="#tab2" data-toggle="tab" id='t2' onClick='getBapitable("table_deliv","BAPIDLVHDR","example2","L","show_dilv@<?php echo $s_wid;?>","Sales_order_dashboard_delivery","tab")'>Delivery List</a><!-- Sales_order_dashboard_delivery -->
                                </li>
                                <li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px">
                                        <div id='pos_tab'></div>
                                        <span style="display:none;"></span>
                                </li>
                        </ul>
                        <div id="tab-content" class="tab-content">
                            <div class="labl pos_pop">
                                    <div class='pos_center'></div>
                                    <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
                                    <button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
                            </div>

                            <div id="exp_pop" style="display:none;" class="labl">
                                <div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
                                <div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                                <div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                                <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                                <div style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
                                <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                                <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                                <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                            </div>

                            <div class="tab-pane active edge1" id="tab1" style="overflow-y:hidden;padding-bottom:55px;">
                                    <input type="hidden" class="tbName_example" value="BAPIORDERS" />								
                                    <div class="head_icons" style="width:981px"><span id='post' tip="Table columns" class="yellow" onClick="table_cells('example')"></span>
                                        <table cellpadding='0px' cellspacing='0px' class="table_head">
                                            <tr>
                                                <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example_table')"></span></td>
                                                <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example')"></span></td>
                                                <td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example')"></span></td>
                                                <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example')"></span></td>
                                                <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example_table')"></span></td>
                                                <td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example')"></span></td>
                                            </tr>
                                        </table>
                                    </div>								
                                    <div id='table_today'></div>
                                    <div class='testr table_today' onClick='getBapitable("table_today","BAPIORDERS","example","S","show_menu@<?php echo $s_wid;?>","Sales_order_dashboard","show_more")'>Show More</div>
                                    <div id='example_num' style="display:none;">10</div>
                            </div>
                            <div class="tab-pane" id="tab2" style="overflow-y:hidden;padding-bottom:55px;">
                                <input type="hidden" class="tbName_example2" value="BAPIDLVHDR" />
                                <div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                                    <div class="head_icons"><span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example2')"></span>
                                        <table cellpadding='0px' cellspacing='0px' class="table_head">
                                            <tr>
                                                <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example2_table')"></span></td>	
                                                <td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example2')"></span></td>
                                                <td><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example2')"></span></td>
                                                <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example2')"></span></td>
                                                <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example2_table')"></span></td>
                                                <td><span id='filtes1' tip='&nbsp; Filters ' class="yellow" onClick="filtes1('example2')"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="table_deliv"></div>
                                    <?php /*if($rowsag5>10) 
                                    {*/
                                        ?><div class='testr table_deliv' onClick='getBapitable("table_deliv","BAPIDLVHDR","example2","S","show_dilv@<?php echo $s_wid;?>","Sales_order_dashboard","show_more")'>Show More</div><!-- Sales_order_dashboard_delivery -->
                                        <div id='example2_num' style="display:none;">10</div><?php 
                                // } 
                                ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Body end -->
        </div><!-- Maincontent end -->
        <!--</div>  end of container -->
        <div class="material_pop"></div>
        <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>

        <script>
        $(document).ready(function(e) 
        {
            $(".head_icons").hide();
            $(".testr").text('');
            $('.menu_tab li a').click(function()
            {
                $.cookie('tabs',$(this).attr('id'));
            })
            $('.search_int').keyup(function () 
            {
                sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
            })

            // $('#'+$.cookie('tabs')).trigger('click');			
            data_table('example');
            $('#example').each(function()
            {
                $(this).dragtable(
                {
                    placeholder: 'dragtable-col-placeholder test3',
                    items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                    appendTarget: $(this).parent(),
                    tableId: 'example',
                    tableSess: 'table_today',
                    scroll: true
                });
            })
            var wids=$('.table').width();
            $('.head_icons').css({ width:wids+'px' });
        });
        </script><?php 
    // }
?>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{
    if($('.count_li').length<=2) $('.more_menu').hide();
    $('.head_fix').css({display:'none'});
    $(document).scroll(function()
    {
        $('#examplefix').css({display:'block'});
    });

    $('#t1').click(function()
    {
        $('.head_fix').css({display:'none'});
        $(document).scroll(function()
        {
            $('.head_fix').css({display:'none'});
            $('#examplefix').css({display:'block'});
        });
    })	
    $('#t2').click(function()
    {
        $('.head_fix').css({display:'none'});
        $(document).scroll(function()
        {
            $('.head_fix').css({display:'none'});
        });
    })
    jQuery("#validation").validationEngine();
});
</script>
