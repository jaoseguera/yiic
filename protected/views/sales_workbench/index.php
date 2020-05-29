<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
$s_wid = "";
global $rfc,$fce;
if (!isset($_REQUEST['I_BACK'])) {    
    
    /*
        GEZG 06/20/2018
        Changing SAPRFC methods
    */    
    $options = ['rtrim'=>true];
    $res = $fce->invoke(["I_QUERY"=>""],$options);   
    $todayorders = NULL;        
    $rowsag1 = count($res["T_TODAYORDERS"]);    

    if($rowsag1 > 0 ){
        $todayorders = $res["T_TODAYORDERS"];
    }

    if ($todayorders != NULL) {
        $tables_today = "VBELN,KUNNR,AUDAT,BSTKD,NETWR";
        $labels_today = "VBELN,KUNNR,AUDAT,BSTKD,NETWR";
        $tableField1 = $screen . '_Todays_Orders';
        if (isset($doc->customize->$tableField1->Table_order)) {
            $labels_today = $doc->customize->$tableField1->Table_order;
        }
        $exps1 = explode(',', $tables_today);
        $exp = explode(',', $labels_today);
        if (count($exp) < 6) {
            for ($j = count($exp) - 1; $j < count($exps1); $j++) {
                $exp[$j] = $exps1[$j];
            }
        }

        foreach ($todayorders as $val_t => $retur) {
            if($retur['AUART'] == 'TA')
                $retur['AUART'] = 'OR';
            $order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
            unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
            $today = $retur;
            $todayorders[$val_t] = array_merge((array) $order_t, (array) $today);
        }
    }
    $todayorders_json = json_encode($todayorders);
    $_SESSION['table_today'] = $todayorders;
    $_SESSION['row1'] = $rowsag1;
} else {
    $s_wid = 1200;
    $todayorders = $_SESSION['table_today'];
    $rowsag1 = $_SESSION['row1'];
}
//.............................................................

if (!isset($_REQUEST['I_BACK'])) {    
    $backorders = NULL;
    $rowsag2 = count($res["T_BACKORDERS"]);
    $backorders = NULL;
    if($rowsag2 > 0){
        $backorders = $res["T_BACKORDERS"];
    }
    $_SESSION['backorders'] = $backorders;
    $_SESSION['row2'] = $rowsag2;
} else {
    $returnorders = $_SESSION['backorders'];
    $rowsag2 = $_SESSION['row2'];
}
//.....................................................................
if (!isset($_REQUEST['I_BACK'])) {
    $rowsag3 =  count($res["T_RETURNORDERS"]);
    $returnorders = NULL;
    if($rowsag3 > 0){
        $returnorders = $res["T_RETURNORDERS"];
    }

    $tables_return = "VBELN,KUNNR,NAME_WE,VKORG,LEDAT";
    $labels_return = "VBELN,KUNNR,NAME_WE,VKORG,LEDAT";
    $tableField1 = $screen . '_Return_Orders';
    if (isset($doc->customize->$tableField1->Table_order)) {
        $labels_return = $doc->customize->$tableField1->Table_order;
    }
    $exps1 = explode(',', $tables_return);
    $exp = explode(',', $labels_return);
    if (count($exp) < 6) {
        for ($j = count($exp) - 1; $j < count($exps1); $j++) {
            $exp[$j] = $exps1[$j];
        }
    }

    foreach ($returnorders as $val_re => $re_t) {
        $order_re = array($exp[0] => $re_t[$exp[0]], $exp[1] => $re_t[$exp[1]], $exp[2] => $re_t[$exp[2]], $exp[3] => $re_t[$exp[3]], $exp[4] => $re_t[$exp[4]]);
        unset($re_t[$exp[0]], $re_t[$exp[1]], $re_t[$exp[2]], $re_t[$exp[3]], $re_t[$exp[4]]);
        $deliery_re = $re_t;
        $returnorders[$val_re] = array_merge((array) $order_re, (array) $deliery_re);
    }
    $_SESSION['table_return'] = $returnorders;
    $_SESSION['row3'] = $rowsag3;
} else {
    $returnorders = $_SESSION['table_return'];
    $rowsag3 = $_SESSION['row3'];
}
//.......................................................................
if (!isset($_REQUEST['I_BACK'])) {
    $deliverydue = NULL;    
    $rowsag4 = count($res["T_DELIVERYDUE"]);
    if($rowsag4 > 0){
        $deliverydue = $res["T_DELIVERYDUE"]; 
    }

    $tables_deliv = "VBELN,KUNNR,NAME_WE,VKORG,LEDAT";
    $labels_deliv = "VBELN,KUNNR,NAME_WE,VKORG,LEDAT";
    $tableField1 = $screen . '_Sales_Orders_Due_for_Delivery';
    if (isset($doc->customize->$tableField1->Table_order)) {
        $labels_deliv = $doc->customize->$tableField1->Table_order;
    }
    $exps1 = explode(',', $tables_deliv);
    $exp = explode(',', $labels_deliv);
    if (count($exp) < 6) {
        for ($j = count($exp) - 1; $j < count($exps1); $j++) {
            $exp[$j] = $exps1[$j];
        }
    }

    foreach ($deliverydue as $val_d => $deil) {
        $order_d = array($exp[0] => $deil[$exp[0]], $exp[1] => $deil[$exp[1]], $exp[2] => $deil[$exp[2]], $exp[3] => $deil[$exp[3]], $exp[4] => $deil[$exp[4]]);
        unset($deil[$exp[0]], $deil[$exp[1]], $deil[$exp[2]], $deil[$exp[3]], $deil[$exp[4]]);
        $deliery = $deil;
        $deliverydue[$val_d] = array_merge((array) $order_d, (array) $deliery);
    }
    $_SESSION['table_delivery'] = $deliverydue;
    $_SESSION['row4'] = $rowsag4;
} else {
    $deliverydue = $_SESSION['table_delivery'];
    $rowsag4 = $_SESSION['row4'];
}
//......................................................................

if (!isset($_REQUEST['I_BACK'])) {
    $billingdue = NULL;    
    $rowsag5 = count($res["T_BILLINGDUE"]);
    if($rowsag5 > 0){
        $billingdue = $res["T_BILLINGDUE"]; 
    }

    $tables_bill = "VBELN,FKDAT,KUNNR,FKART,NETWR";
    $labels_bill = "VBELN,FKDAT,KUNNR,FKART,NETWR";
    $tableField1 = $screen . '_Delivery_Due_for_Billing';
    if (isset($doc->customize->$tableField1->Table_order)) {
        $labels_bill = $doc->customize->$tableField1->Table_order;
    }
    $exps1 = explode(',', $tables_bill);
    $exp = explode(',', $labels_bill);
    if (count($exp) < 6) {
        for ($j = count($exp) - 1; $j < count($exps1); $j++) {
            $exp[$j] = $exps1[$j];
        }
    }

    foreach ($billingdue as $val => $bill) {
        $order_b = array($exp[0] => $bill[$exp[0]], $exp[1] => $bill[$exp[1]], $exp[2] => $bill[$exp[2]], $exp[3] => $bill[$exp[3]], $exp[4] => $bill[$exp[4]]);
        unset($bill[$exp[0]], $bill[$exp[1]], $bill[$exp[2]], $bill[$exp[3]], $bill[$exp[4]]);
        $billing = $bill;
        $billingdue[$val] = array_merge((array) $order_b, (array) $billing);
    }
    $_SESSION['table_billing'] = $billingdue;
    $_SESSION['row5'] = $rowsag5;
} else {
    $billingdue = $_SESSION['table_billing'];
    $rowsag5 = $_SESSION['row5'];
}

$row1 = 10;
if ($rowsag1 < 10) {
    $row1 = $rowsag1;
}

$sut = max($rowsag1, $rowsag2, $rowsag3, $rowsag4, $rowsag5);
$s = $sut;
$s = $s / 4;
$sut = $sut + $s;
$deli_tab = "";
$bill_tab = "";
$today_tab = "";

if (isset($_REQUEST['tab'])) {
    $bill_tab = 'active';
} else {
    if (isset($_REQUEST['tabs'])) {
        $deli_tab = 'active';
    } else {
        $today_tab = "active";
    }
}
?>
<script>
    function show_bar(ids)
    {
        $('.active').removeClass('active')
        $('#'+ids).trigger('click');
    }
</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<div id='resId'></div><?php

$this->renderPartial('smarttable');
?><input type="hidden" name="test" value="test" />    
<div class="span8 barch">
    <section class="utopia-widget">
        <div class="utopia-widget-title">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/stats_bars.png" class="utopia-widget-icon">
            <span class='cutz sub_titles' alt='Bar chart'><?php echo Controller::customize_label('Bar chart', 'sales_workbench'); ?></span>
        </div>
        <div class="utopia-widget-content">
            <table border="0" class="shaw">
                <tr>
                    <td>
                        <div class='bar_tip'>
                            <ul>
                                <li style="border:0px;"><?php echo round($s * 5); ?></li>
                                <li><?php echo round($s * 4); ?></li>
                                <li><?php echo round($s * 3); ?></li>
                                <li><?php echo round($s * 2); ?></li>
                                <li><?php echo round($s * 1); ?></li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <table class="grf">
                            <tr>
                                <td class="gap"></td>
                                <td onClick="show_bar('t1')" style="vertical-align:bottom; cursor:pointer;background:#F9F9F9;" href="#tab1" data-toggle="tab">
                                    <div style="height:<?php echo ($rowsag1 * 180) / $sut; ?>px;background:#F8E7B2;width:40px;border:1px solid #EDC243;border-bottom:0px;" onClick="show_bar('t_od')" tip="Today's Orders<br><?php echo $rowsag1; ?>" class="blue"></div></td>
                                <td class="gap"></td>
                                <td onClick="show_bar('t2')" style="vertical-align:bottom; cursor:pointer;background:#F9F9F9;" href="#tab2" data-toggle="tab">
                                    <div style="height:<?php echo ($rowsag2 * 180) / $sut; ?>px; background:#8c4d88;opacity:0.8;" onClick="show_bar('t_od')"  tip="Back Orders<br><?php echo $rowsag2; ?>" class="blue"></div></td>
                                <td class="gap"></td>
                                <td onClick="show_bar('t3')" style="vertical-align:bottom; cursor:pointer;background:#F9F9F9;" href="#tab3" data-toggle="tab">
                                    <div style="height:<?php echo 1 + ($rowsag3 * 180) / $sut; ?>px; background:#DFEFFC;border:1px solid #AFD8F8;border-bottom:0px;" onClick="show_bar('t_od')"  tip="Return Orders<br><?php echo $rowsag3; ?>" class="blue"></div></td>
                                <td class="gap"></td>
                                <td onClick="show_bar('t4')" style="vertical-align:bottom; cursor:pointer;background:#F9F9F9;" href="#tab4" data-toggle="tab">
                                    <div style="height:<?php echo ($rowsag4 * 180) / $sut; ?>px; background:#EAB7B7;width:40px;border:1px solid #CB4B4B;border-bottom:0px;"  tip="Sales Orders Due for Delivery<br><?php echo $rowsag4; ?>" class="blue"></div></td>
                                <td class="gap"></td>
                                <td onClick="show_bar('t5')" style="vertical-align:bottom; cursor:pointer;background:#F9F9F9; " href="#tab5" data-toggle="tab">
                                    <div style="height:<?php echo ($rowsag5 * 180) / $sut; ?>px; background:#B2D7B2;border:1px solid #4DA74D;border-bottom:0px;" onClick="show_bar('t_od')"  tip="Documents Due for Billing<br><?php echo $rowsag5; ?>" class="blue"></div></td>
                                <td class="gap"></td>
                            </tr>
                        </table>
                    </td>
                    <td valign="" style="padding-top:20px;padding-left:10px;">
                        <table border="0" class="leng" style="min-width:200px;">
                            <tr>
                                <td class="tods"></td><td  style="cursor:pointer;" onClick="show_bar('t1')" href="#tab1" data-toggle="tab" alt="Today's Orders"><?php echo Controller::customize_label("Today's Orders", 'sales_workbench'); ?></td></tr>
                                <tr><td class="bak"></td><td style="cursor:pointer;" onClick="show_bar('t2')" href="#tab2" data-toggle="tab" alt='Back Orders'><?php echo Controller::customize_label('Back Orders', 'sales_workbench'); ?></td></tr>
                                <tr><td class="reo"></td><td style="cursor:pointer;" onClick="show_bar('t3')" href="#tab3" data-toggle="tab" alt='Return Orders'><?php echo Controller::customize_label('Return Orders', 'sales_workbench'); ?></td></tr>
                                <tr><td class="sb"></td><td style="cursor:pointer;" onClick="show_bar('t4')" href="#tab4" data-toggle="tab" alt='Sales Orders Due for Delivery'><?php echo Controller::customize_label('Sales Orders Due for Delivery', 'sales_workbench'); ?></td></tr>
                                <tr><td class="sd"></td><td style="cursor:pointer;" onClick="show_bar('t5')" href="#tab5" data-toggle="tab" alt='Documents Due for Billing'><?php echo Controller::customize_label('Documents Due for Billing', 'sales_workbench'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan='3' align='center' class='strip'>Sales Orders</td>
                </tr>
            </table> 
        </div>
    </section>
</div>  
<input type="hidden" name="url" value="sales_workbench" />
<input type="hidden" name="page" value="bapi" />

<div class="row-fluid">
    <div class='span12'>
        <div class="row-fluid">
            <div class="tabbable">
                <ul class="nav nav-tabs menu_tab">
                    <li id='li_1' class='<?php if (isset($today_tab)) echo $today_tab; ?>'><a href="#tab1" data-toggle="tab" id='t1' onclick='return getBapitable("table_today","/KYK/SERPSLS_GENDOC_FLAGS_STS","example","L","nones@<?php echo $s_wid; ?>","Todays_Orders","tab")' alt="Today's Orders"><?php echo Controller::customize_label("Today's Orders", 'sales_workbench'); ?></a></li>
                    <li id='li_2'><a href="#tab2" data-toggle="tab" id='t2' onClick='return getBapitable("backorders","ZBAPI_SLS_LIST_ORDERS_OUT","example1","L","nones@<?php echo $s_wid; ?>","Back_Orders","tab")' alt='Back Orders'><?php echo Controller::customize_label('Back Orders', 'sales_workbench'); ?></a></li>
                    <li id='li_3'><a href="#tab3" data-toggle="tab" id='t3' onClick='return getBapitable("table_return","ZBAPI_SLS_LIST_ORDERS_OUT","example2","L","nones@<?php echo $s_wid; ?>","Return_Orders","tab")'  alt='Return Orders'><?php echo Controller::customize_label('Return Orders', 'sales_workbench'); ?></a></li>
                    <li id='li_4' class='<?php if (isset($deli_tab)) echo $deli_tab; ?>'><a href="#tab4" data-toggle="tab" id='t4' onClick='return getBapitable("table_delivery","ZBAPI_SLS_LIST_ORDERS_OUT","example3","L","nones@<?php echo $s_wid; ?>","Sales_Orders_Due_for_Delivery","tab")' alt='Sales Orders Due for Delivery'><?php echo Controller::customize_label('Sales Orders Due for Delivery', 'sales_workbench'); ?></a></li>
                    <li id='li_5' class='<?php if (isset($bill_tab)) echo $bill_tab; ?>'><a href="#tab5" data-toggle="tab" id='t5' onClick='return getBapitable("table_billing","/KYK/S_POWL_BILLDUE","example4","L","nones@<?php echo $s_wid; ?>","Delivery_Due_for_Billing","tab")' alt='Documents Due for Billing'><?php echo Controller::customize_label('Documents Due for Billing', 'sales_workbench'); ?></a></li>
                    <li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px" onClick="more_menu()">
                        <div id='pos_tab'></div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="labl pos_pop">
                        <div class='pos_center'></div>
                        <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
                        <button  class="btn"  id="p_ch"  style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
                    </div>
                    <div id="exp_pop" style="display:none;" class="labl">
                        <div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
                        <div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                        <div  style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
                        <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
                        <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
                        <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
                    </div>
                    <div class="tab-pane <?php if (isset($today_tab)) echo $today_tab; ?>" id="tab1"><?php
if (isset($_SESSION['table_today']) && $_SESSION['table_today'] != NULL) {
    ?><input type="hidden" class='tbName_example' value='/KYK/SERPSLS_GENDOC_FLAGS_STS'>
                            <div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                                <div class="head_icons">
                                    <span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example')"></span>
                                    <table cellpadding='0px' cellspacing='0px' class="table_head">
                                        <tr>
                                            <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example_table')"></span></td>
                                            <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example')"></span></td>
                                            <td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example')"></span></td>
                                            <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example')"></span></td>
                                            <td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example_table')"></span></td>
                                            <td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example')"></span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id='table_today'></div><?php
    if (isset($rowsag1) && $rowsag1 > 10) {
        ?><div class='testr table_today' onClick='return getBapitable("table_today","/KYK/SERPSLS_GENDOC_FLAGS_STS","example","S","show_menu@<?php echo $s_wid; ?>","Todays_Orders","show_more")'>Show more</div>
                                    <div id='example_num' style="display:none;">10</div><?php
    }
    ?></div><?php
} else {
    echo "<h3>No Today's Orders Found</h3>";
}
?></div>
                    <div class="tab-pane" id="tab2"><?php
if (isset($_SESSION['backorders']) && $_SESSION['backorders'] != NULL) {
    ?><input type="hidden" class='tbName_example1' value='/KYK/SERPSLS_GENDOC_FLAGS_STS'>
                            <div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                                <div class="head_icons">
                                    <span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example1')"></span>
                                    <table cellpadding='0px' cellspacing='0px' class="table_head">
                                        <tr>
                                            <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example1_table')"></span></td>
                                            <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example1')"></span></td>
                                            <td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example1')"></span></td>
                                            <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example1')"></span></td>
                                            <td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example1_table')"></span></td>
                                            <td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example1')"></span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div id='table_today'></div><?php
    if (isset($rowsag1) && $rowsag1 > 10) {
        ?><div class='testr table_today' onClick='return getBapitable("table_today","/KYK/SERPSLS_GENDOC_FLAGS_STS","example","S","show_menu@<?php echo $s_wid; ?>","Todays_Orders","show_more")'>Show more</div>
                                    <div id='example_num' style="display:none;">10</div><?php
                    }
                    ?></div><?php
                } else {
                    echo "<h3>No Back Orders Found</h3>";
                }
?></div>
                    <div class="tab-pane" id="tab3"><?php
                if ($_SESSION['table_return'] != NULL) {
                    ?><input type="hidden" class='tbName_example2' value='ZBAPI_SLS_LIST_ORDERS_OUT'>
                            <div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                                <div class="head_icons">
                                    <span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example2')"></span>
                                    <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
                                            <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example2_table')"></span></td>
                                            <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example2')"></span></td>
                                            <td  ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example2')"></span></td>
                                            <td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example2')"></span></td>
                                            <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example2_table')"></span></td>
                                            <td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example2')"></span></td>
                                        </tr></table>
                                </div>
                                <div id="table_return"></div><?php
                    if (isset($rowsag3) && $rowsag3 > 10) {
        ?><div class='testr table_return' onClick='return getBapitable("table_return","ZBAPI_SLS_LIST_ORDERS_OUT","example2","S","nones@<?php echo $s_wid; ?>","Return_Orders","show_more")'>Show more</div>
                                    <div id='example3_num' style="display:none;">10</div><?php
                    }
    ?></div><?php
                        } else {
                            echo "<h3>No Return Orders Found</h3>";
                        }
?></div>
                    <div class="tab-pane <?php if (isset($deli_tab)) echo $deli_tab; ?>" id="tab4"><?php
                        if ($_SESSION['table_delivery'] != NULL) {
                            ?><div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                               <!-- <form id="ContactForm1" onSubmit="return submitForm1();" >
                                    <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="delivery_and_billing"/>
                                    <input type="hidden" name="bapiName" value="ZBAPI_POWL_CREATE_DELIVERY"/>-->
                                    <input type="hidden" class='tbName_example3' value='ZBAPI_SLS_LIST_ORDERS_OUT'>

                                    <div  class="head_icons">
                                        <span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example3')"></span>
                                        <table cellpadding='0px' cellspacing='0px' class="table_head">
                                            <tr>
                                                <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example3_table')"></span></td>
                                                <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example3')"></span></td>
                                                <td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example3')"></span></td>
                                                <td  class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example3')"></span></td>

                                                <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example3_table')"></span></td>
                                                <!--<td><button id='cd' tip=" Create Delivery " class="yellow"  type="submit"></button></td>-->
                                                <td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example3')"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="table_delivery"></div><?php
                            if (isset($rowsag4) && $rowsag4 > 10) {
        ?><div class='testr table_delivery' onClick='return getBapitable("table_delivery","ZBAPI_SLS_LIST_ORDERS_OUT","example3","S","nones@<?php echo $s_wid; ?>","Sales_Orders_Due_for_Delivery","show_more")'>Show more</div>
                                        <div id='example3_num' style="display:none;">10</div><?php
                    }
    ?> <!--</form>-->
                            </div><?php
                    } else {
                        echo _NORECORDS;
                    }
?></div>
                    <div class="tab-pane <?php if (isset($bill_tab)) echo $bill_tab; ?>" id="tab5"><?php
                    if ($_SESSION['table_billing'] != NULL) {
                        ?><div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
                             <!--   <form id="ContactForm" onSubmit="return submitForm();">
                                    <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="delivery_and_billing"/>
                                    <input type="hidden" name="bapiName" value="ZBAPI_POWL_CREATE_BILLING"/>-->
                                    <input type="hidden" class='tbName_example4' value='/KYK/S_POWL_BILLDUE'>
                                    <div  class="head_icons">
                                        <span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example4')"></span>
                                        <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
                                                <td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example4_table')"></span></td>
                                                <td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example4')"></span></td>

                                                <td  ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example4')"></span></td>
                                                <td  class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example4')"></span></td>
                                                <td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example4_table')"></span></td>
                                                <!--<td><button id='cb' tip=" Create Billing " class="yellow"  type="submit"></button></td>-->
                                                <td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example4')"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="table_billing"></div><?php
                        if (isset($rowsag5) && $rowsag5 > 10) {
        ?><div class='testr table_billing' onClick='return getBapitable("table_billing","/KYK/S_POWL_BILLDUE","example4","S","nones@<?php echo $s_wid; ?>","Delivery_Due_for_Billing","show_more")'>Show more</div>
                                        <div id='example4_num' style="display:none;">10</div><?php }
    ?>
                             <!--   </form>-->
                            </div><?php
                    } else {
                        echo _NORECORDS;
                    }
?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id='export_table' style="display:none"></div>
<div id='export_table_view' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div><?php
                        if ($_SESSION['table_today'] != NULL) {
                            ?><script>
                    $(document).ready(function () 
                    {
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
                        });
                    });
    </script><?php
                        }
                        ?><script type="text/javascript">       
        $(document).ready(function () {
            getBapitable("table_today","/KYK/SERPSLS_GENDOC_FLAGS_STS","example","L","nones@<?php echo $s_wid; ?>","Todays_Orders","tab");
            $('.tabbable ul li a').click(function()
            {
                $.cookie('tabs',$(this).attr('id'));
            })            
            $('.search_int').keyup(function () 
            {
                sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
            });
            $('#'+$.cookie('tabs')).trigger('click');
            $('.head_fix').css({display:'none'});
            $(document).scroll(function()
            {
                $('.head_fix').css({display:'none'});
                $('#examplefix').css({display:'block'});
            });
            $('#t4').click(function()
            {
                $('.head_fix').css({display:'none'});
                $(document).scroll(function()
                {
                    $('.head_fix').css({display:'none'});
                    $('#example3fix').css({display:'block'});
                });
            })
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
            $('#t3').click(function()
            {
                $('.head_fix').css({display:'none'});
                $(document).scroll(function()
                {
                    $('.head_fix').css({display:'none'});
                });
            })
            $('#t5').click(function()
            {
                $('.head_fix').css({display:'none'});
                $(document).scroll(function()
                {
                    $('.head_fix').css({display:'none'});
                });
            })
            var wids=$('.table').width();
            $('.head_icons').css({ width:wids+'px' });
        });
        /* gauge end */
</script>
