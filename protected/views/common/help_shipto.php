<?php
global $rfc,$fce;
//error_reporting(0);
//$em = $_REQUEST['em'];
$val = $_REQUEST['val'];
$sh = $_REQUEST['sh'];
$type = $_REQUEST['type'];
$_SESSION['look_type'] = $type;
$ids = $_REQUEST['ids'];
$_SESSION['look_ids'] = $ids;
$_SESSION['row_look'] = 30;
$parameter = $_REQUEST['para'];
//$client = new couchClient ('http://'.$admin.'localhost:5984','thinui');
//$docs= $client->getDoc($_SESSION['user_id']);
$order = "";
if (isset($docs->lookup->$type->order)) {
    $order = $docs->lookup->$type->order;
} else {
	 $client = Controller::couchDbconnection();
    $doc = $client->getDoc('lookup');
    if (isset($doc->$type->order)) {
        $order = $doc->$type->order;
    }
}
$gs = array(0, 1, 2);
if (isset($docs->lookup->$type->display)) {
    $disp = $docs->lookup->$type->display;
    $gs = explode(',', $disp);
} else {
    $doc = $client->getDoc('lookup');
    if (isset($doc->$type->display)) {
        $disp = $doc->$type->display;
        $gs = explode(',', $disp);
    }
}
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/table.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ColReorder.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
        var oTable = $('#help').dataTable({
            "bPaginate": false,
            "bSort": false,
            "sDom": 'R',
            "oColReorder": {
                "aiOrder": [ <?php echo $order; ?> ]
            }
        });
        //alert($('#dialog').scrollTop()+','+$('.rot_t').height());
    });
</script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css" rel="stylesheet" type="text/css"/>
<style>
    .rot_t
    {
        background:#fff;
        padding:5px;
        text-align:center;
    }
    .rot_t th,
    .rot_t td
    {
        padding-bottom:3px;
        padding-top:3px;
        border:1px solid #CCCCCC;
        font-size:12px;
        font-family:Arial, Helvetica, sans-serif;
    }
    .rot_t tr
    {
        background:#fff;
    }
    .ort:hover
    {
        background:#F5F5F5;
        color:#333333;
    }
    .ort
    {
        color:#666;
        height:15px;
    }
    .hd_tr
    {

        color:#333333;
        font-weight:bold;
    }
</style>
<?php

//GEZG 06/22/2018
//Changing SAPRFC methods
$options = ['rtrim'=>true];

$partn=$val;
$cusLenth=count($partn);
if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }

$res = $fce->invoke(["KUNNR"=>$partn],$options);

$em = array('KUNNR','NAME1','NAME2', 'STREET', 'PSTLZ', 'ORT01', 'LANDX');
$rowsagt1 = 7;
$mtrl_lookup = false;
$create_sales_order_lookup = false;

	$text = array("0"=>_SHIPPARTY, "1"=>_NAME, "2"=>_NAME . '2', "3"=>_STREET,"4"=>_POSTALCODE, "5"=>_CITY, "6"=>_COUNTRY);

/*$_SESSION['look_offset'] = $offset;
$_SESSION['look_leng'] = $leng;
$_SESSION['look_text'] = $text;
$_SESSION['look_p'] = $p; */
$p=0;
//var_dump($text);
//.............................................................................................................
$rowsagt = count($res["ITEMTAB"]);
$_SESSION['look_row'] = $rowsagt;
//echo $rowsagt;
$rows = 30;
if ($rowsagt < $rows) {
    $rows = $rowsagt;
}
for ($j = 0; $j < $rowsagt; $j++) {
    $SalesOrderts[] = $res["ITEMTAB"][$j];
    if($create_sales_order_lookup){
        $helpvalue = $SalesOrderts[$j-1];
        $doctype = $helpvalue['ITEMTAB'];
        for ($k = 0; $k < $rowsagt1; $k++) {
            if(in_array($k,$pval) && trim(substr($doctype, $offset[$k], $leng[$k])) == "TA")
                $doctype = substr_replace($doctype, 'OR  ', $offset[$k] , $leng[$k]);
            
			$SalesOrderts1[$j-1] = array("ITEMTAB" => $doctype);
        }
    }else
        $SalesOrderts1 = $SalesOrderts;
}

$_SESSION['look_sales'] = $SalesOrderts1;
$_SESSION['look_row1'] = $rowsagt1;
//var_dump($rowsagt);
?>
<div>
    <div id="lookup_head">
        <div id="lookup_header" class="lookup_hed"></div>
    </div>
    <table class="rot_t myTable scrollableFixedHeaderTable" width='95%' id="help" >
        <thead>
            <tr class="hd_tr">
                <?php
                for ($j = 0; $j < $rowsagt1; $j++) {
                    $calsses = "show_header";
                    if ($j == $p) {
                        ?>
                            <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' title="<?php echo $type; ?>" id='542'><?php echo $text[$j]; ?></th>
                    <?php
                    }
                }
                $ji = 0;
                for ($j = 0; $j < $rowsagt1; $j++) {
                    $calsses = "show_header";
                    if ($j != $p) {
                        if (!in_array($ji, $gs)) {
                            $calsses = "hide_header";
                        }
                        ?>
                        <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_<?php echo $ji + 1; ?>" alt="display_<?php echo $ji + 1; ?>" title="<?php echo $type; ?>" id="<?php echo $ji; ?>"><?php echo $text[$j]; ?></th>
                        <?php
                        $ji++;
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                for ($j = 1; $j <= $rows; $j++) {                    
                    ?>
                    <?php
//                    foreach ($SalesOrderts1 as $form) {
$form=$SalesOrderts1[$j-1];  
  //$metrial = substr($form, 9, 40);
                        ?>
                        <tr class="ort df<?php echo $j; ?>" id='df<?php echo $j; ?>'>
                            <?php
                            
                            for ($i = 0; $i < $rowsagt1; $i++) {
                                $calsses = "show_header";
                                if ($i == $p) {
                                    ?>
                                    <td onclick="getval('<?php echo ltrim($form['KUNNR'],"0"); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['KUNNR']; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form['KUNNR'],"0"); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo ltrim($form['KUNNR'],"0"); ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form['KUNNR'],"0"); ?></td>
                                    <?php
                                }
                            }
                            $ij = 0;
                            for ($i = 0; $i < $rowsagt1; $i++) {
                                $calsses = "show_header";
                                if ($i != $p) {
                                    if (!in_array($ij, $gs)) {
                                        $calsses = "hide_header";
                                    }
                                    ?>
                                    <td onclick="getval('<?php echo ltrim($form['NAME1']); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['NAME1']; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form['NAME1']); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['NAME1']; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_<?php echo $ij + 1; ?> " alt="display_<?php echo $ij + 1; ?>"><?php echo ltrim($form[$em[$ij+1]]); ?></td>
                                    <?php
                                    $ij++;
                                }
                            }
                            ?>
                        </tr>
                        <?php
                   // }
                  
                    $form = NULL;
                }
            ?>
            <tr id="scr_lod">
                <td class="hide_header"></td>
                <?php
                for ($i = 0; $i < $rowsagt1; $i++) {
                    $calsses = "hide_header";
                    if ($i != $p) {
                        if (!in_array($ij, $gs)) {
                            $calsses = "hide_header";
                        }
                        ?>
                        <td class="<?php echo $calsses; ?>">as</td>
                        <?php
                    }
                }
                ?>
            </tr>
        </tbody>
    </table>
</div>