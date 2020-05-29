<?php
global $rfc,$fce;
$val = $_REQUEST['val'];
$val_ex = explode(",", $val);

$MATERIAL_FROM = $val_ex[0];
$MATERIAL_TO = $val_ex[1];

$PLANT_FROM = $val_ex[2];
$PLANT_TO = $val_ex[3];

$STGE_LOC_FROM = $val_ex[4];
$STGE_LOC_TO = $val_ex[5];

$BATCH_FROM = $val_ex[6];
$BATCH_TO = $val_ex[7];

$SPEC_STOCK_FROM = $val_ex[8];
$SPEC_STOCK_TO = $val_ex[9];

$TR_EV_TYPE_FROM = $val_ex[10];
$TR_EV_TYPE_TO = $val_ex[11];

$PSTNG_DATE_FROM = $val_ex[12];
$PSTNG_DATE_TO = $val_ex[13];

$VENDOR_FROM = $val_ex[14];
$VENDOR_TO = $val_ex[15];

$USERNAME_FROM = $val_ex[16];
$USERNAME_TO = $val_ex[17];



$em = $_REQUEST['em'];
$val = $_REQUEST['val'];
$sh = $_REQUEST['sh'];
$type = $_REQUEST['type'];
$_SESSION['look_type'] = $type;
$ids = $_REQUEST['ids'];
$_SESSION['look_ids'] = $ids;
$_SESSION['row_look'] = 30;
$parameter = $_REQUEST['para'];

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
$importTableMATERIAL = array();
$importTablePLANT = array();
$importTableBATCH = array();
$importTableSTGELOC = array();


if($MATERIAL_FROM!="" || $MATERIAL_TO!=""){

    $frm_Lenth = count($MATERIAL_FROM);
    if($frm_Lenth < 18 && $MATERIAL_FROM != "" && is_numeric($MATERIAL_FROM)) {
        $MATERIAL_FROM = str_pad($MATERIAL_FROM, 18, 0, STR_PAD_LEFT);
    }
    $to_Lenth = count($MATERIAL_TO);
    if($to_Lenth < 18 && $MATERIAL_TO != "" && is_numeric($MATERIAL_TO)) {
        $MATERIAL_TO = str_pad($MATERIAL_TO, 18, 0, STR_PAD_LEFT);
    }

    if($MATERIAL_FROM!="" && $MATERIAL_TO!="")
        $mat_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$MATERIAL_FROM,'HIGH'=>$MATERIAL_TO);
    elseif($MATERIAL_FROM!="" && $MATERIAL_TO=="")
        $mat_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$MATERIAL_FROM,'HIGH'=>"");
    array_push($importTableMATERIAL,$mat_param);
}

if($PLANT_FROM!="" || $PLANT_TO!=""){
    if($PLANT_FROM!="" && $PLANT_TO!="")
        $pla_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$PLANT_FROM,'HIGH'=>$PLANT_TO);
    elseif($PLANT_FROM!="" && $MATERIAL_TO=="")
        $pla_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$PLANT_FROM,'HIGH'=>"");
    array_push($importTablePLANT,$pla_param);
}


if($BATCH_FROM!="" || $BATCH_TO!=""){
    if($BATCH_FROM!="" && $BATCH_TO!="")
        $bat_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$BATCH_FROM,'HIGH'=>$BATCH_TO);
    elseif($BATCH_FROM!="" && $BATCH_TO=="")
        $bat_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$BATCH_FROM,'HIGH'=>"");    
    array_push($importTableBATCH, $bat_param);
}



if($STGE_LOC_FROM!="" || $STGE_LOC_TO!=""){
    if($STGE_LOC_FROM!="" && $STGE_LOC_TO!="")
        $str_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$STGE_LOC_FROM,'HIGH'=>$STGE_LOC_TO);
    elseif($STGE_LOC_FROM!="" && $STGE_LOC_TO=="")
        $str_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$STGE_LOC_FROM,'HIGH'=>"");
    array_push($importTableSTGELOC,$str_param);
}


$importTableSTOCKFORM = array();
if($SPEC_STOCK_FROM!="" || $SPEC_STOCK_TO!=""){
    if($SPEC_STOCK_FROM!="" && $SPEC_STOCK_TO!="")
        $spe_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$SPEC_STOCK_FROM,'HIGH'=>$SPEC_STOCK_TO);
    elseif($SPEC_STOCK_FROM!="" && $SPEC_STOCK_TO=="")
        $spe_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$SPEC_STOCK_FROM,'HIGH'=>"");
    $imp->setTable('SPEC_STOCK_RA',$spe_param);
}

if($TR_EV_TYPE_FROM!="" || $TR_EV_TYPE_TO!=""){
    if($TR_EV_TYPE_FROM!="" && $TR_EV_TYPE_TO!="")
        $tr_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$TR_EV_TYPE_FROM,'HIGH'=>$TR_EV_TYPE_TO);
    elseif($TR_EV_TYPE_FROM!="" && $TR_EV_TYPE_TO=="")
        $tr_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$TR_EV_TYPE_FROM,'HIGH'=>"");
    array_push($importTableSTOCKFORM,$tr_param);
}


$importTablePSTINGDATE = array();
if($PSTNG_DATE_FROM!="" || $PSTNG_DATE_TO!=""){
    if($PSTNG_DATE_FROM!="" && $PSTNG_DATE_TO!="")
        $psd_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$PSTNG_DATE_FROM,'HIGH'=>$PSTNG_DATE_TO);
    elseif($PSTNG_DATE_FROM!="" && $PSTNG_DATE_TO=="")
        $psd_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$PSTNG_DATE_FROM,'HIGH'=>"");
    array_push($importTablePSTINGDATE, $psd_param);
}

$importTableVENDORFORM = array();
if($VENDOR_FROM!="" || $VENDOR_TO!=""){
    if($VENDOR_FROM!="" && $VENDOR_TO!="")
        $ven_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$VENDOR_FROM,'HIGH'=>$VENDOR_TO);
    elseif($VENDOR_FROM!="" && $VENDOR_TO=="")
        $ven_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$VENDOR_FROM,'HIGH'=>"");
    array_push($importTableVENDORFORM,$ven_param);
}

$importTableUSERNAME = array();
if($USERNAME_FROM!="" || $USERNAME_TO!=""){
    if($USERNAME_FROM!="" && $USERNAME_TO!="")
        $usr_param = array('SIGN'=>"I",'OPTION'=>"BT",'LOW'=>$USERNAME_FROM,'HIGH'=>$USERNAME_TO);
    elseif($USERNAME_FROM!="" && $USERNAME_TO=="")
        $usr_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>$USERNAME_FROM,'HIGH'=>"");
    array_push($importTableUSERNAME, $usr_param);
}


$importTableMOVETYPE = array();
$movtype_param = array('SIGN'=>"I",'OPTION'=>"EQ",'LOW'=>"313",'HIGH'=>"");
array_push($importTableMOVETYPE,$movtype_param);

$res = $fce->invoke(['MATERIAL_RA'=>$importTableMATERIAL,
                    'PLANT_RA'=>$importTablePLANT,
                    'BATCH_RA'=>$importTableBATCH,
                    'STGE_LOC_RA'=>$importTableSTGELOC,
                    'SPEC_STOCK_RA'=>$importTableSTOCKFORM,
                    'PSTNG_DATE_RA'=>$importTablePSTINGDATE,
                    'VENDOR_RA'=>$importTableVENDORFORM,
                    'USERNAME_RA'=>$importTableUSERNAME,
                    'MOVE_TYPE_RA'=>$importTableMOVETYPE],$options);

$SalesOrderts1 = $res['GOODSMVT_HEADER'];
$rowsagt1 = count($res["GOODSMVT_HEADER"]);


$_SESSION['look_offset'] = $offset;
$_SESSION['look_leng'] = $leng;
$_SESSION['look_text'] = $text;
$_SESSION['look_p'] = $p;
//var_dump($text);
//.............................................................................................................

$_SESSION['look_row'] = $rowsagt1;
$rows = 30;
if ($rowsagt1 < $rows) {
    $rows = $rowsagt1;
}

$_SESSION['look_sales'] = $SalesOrderts1;
$_SESSION['look_row1'] = $rowsagt1;
//var_dump($rowsagt);
$t_headers = Controller::technicalNames("BAPI2017_GM_HEAD_02","");
$theaders  = Controller::technical_names("BAPI2017_GM_HEAD_02");
$labels = "MAT_DOC,DOC_YEAR,DOC_DATE,PSTNG_DATE,TR_EV_TYPE";
$labels   = explode(',',$labels);
?>
<div>
    <div id="lookup_head">
        <div id="lookup_header" class="lookup_hed"></div>
    </div>
    <table class="rot_t myTable scrollableFixedHeaderTable" width='95%' id="help" >
        <thead>
            <tr class="hd_tr">
                <?php

                $ji = 0;
                //if($SalesOrderts1 != ""){
                for ($j = 0; $j < count($labels); $j++) {
                    $calsses = "show_header";
                        if (!in_array($ji, $gs)) {
                            $calsses = "hide_header";
                        }
                        ?>
                        <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_<?php echo $ji+1; ?>" alt="display_<?php echo $ji + 1; ?>" title="<?php echo $type; ?>" id="<?php echo $ji+1; ?>"><?php echo $theaders[$labels[$j]]; ?></th>
                        <?php
                        $ji++;
                }
                //}
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                for ($j = 1; $j <= $rows; $j++) {
                    ?>
                    <?php
                    $form= $SalesOrderts1[$j-1];

                        ?>
                        <tr class="ort df<?php echo $j; ?>" id='df<?php echo $j; ?>'>
                            <?php
                            $ij = 0;
                            for ($i = 0; $i < count($labels); $i++) {
                                $calsses = "show_header";
                                    if (!in_array($ij, $gs)) {
                                        $calsses = "hide_header";
                                    }

                                $date = Controller::dateValue($t_headers, $labels[$i], $form[$labels[$i]]);
                                    if($date != false)
                                        $vales = $date;
                                    else
                                        $vales = $form[$labels[$i]];
                                    ?>

                                    <td onclick="getval('<?php echo $form[$labels[0]]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form[$labels[1]]; ?>', 'single')"
                                        ondblclick="getval('<?php echo $form[$labels[0]]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form[$labels[1]]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_<?php echo $ij + 1; ?> " alt="display_<?php echo $ij + 1; ?>"><?php echo $vales; ?></td>
                                    <?php
                                    $ij++;
                            }
                            ?>
                        </tr>
                        <?php
                    $form = NULL;
                }
            ?>

            <tr id="scr_lod">
                <td class="hide_header"></td>
                <?php
                for ($i = 1; $i < count($labels); $i++) {
                    $calsses = "hide_header";
                        if (!in_array($ij, $gs)) {
                            $calsses = "hide_header";
                        }
                        ?>
                        <td class="<?php echo $calsses; ?>">as</td>
                        <?php
                }
                ?>
            </tr>

        </tbody>
    </table>
</div>