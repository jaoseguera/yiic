<?php
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
global $rfc,  $fce;

//error_reporting(0);
$val = $_REQUEST['val'];
$type = $_REQUEST['type'];
$ids = $_REQUEST['ids'];
$_SESSION['look_ids'] = $ids;
$_SESSION['row_look'] = 30;

$gs = array(0, 1, 2);
$em = array('KUNNR','SORTL','ORT01', 'NAME1');
$rowsagt1 = 4;
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
$em_ex = explode(",", $em);
$val_ex = explode(",", $val);

$importTable = array();
foreach ($em_ex as $keys => $values) {
    $vals = strtoupper($val_ex[$keys]);
    if ($vals != "") {
        $SELECTION_FOR_HELPVALUES = array("SELECT_FLD" => $values, "SIGN" => "I", "OPTION" => "CP", "LOW" => $vals , "HIGH" => "");
        array_push($importTable, $SELECTION_FOR_HELPVALUES);
    }
}

$options = ['rtrim'=>true];
$res = $fce->invoke([
        "VKORG"=>$val_ex[0]
        ],$options);

$mtrl_lookup = false;
$create_sales_order_lookup = false;
for ($j = 0; $j < $rowsagt1; $j++) {
    $SalesOrdert1 = $res["DESCRIPTION_FOR_HELPVALUES"][$j];
	if($field == trim($SalesOrdert1['FIELDNAME']))
		$p = ($j);
	
	if("MATNR" == trim($SalesOrdert1['FIELDNAME']))
		$mtrl_lookup = true;

    $fieldname_arr = ["AUART","AUART1","AUART2","/BEV1/RPORDTYP","/BEV1/TSAUART","ORDER_TYPE","ORDER_TYPE6","DOC_TYPE","DOC_TYP","AD01SDAUART","SDAUART","SD_DOC_TYP","PREC_DOC_TYPE","CLAIM_DOC_TYPE","OPTIONS_FOR_DOC_TYPE","AUART_SD","KAART","AUART_TO","AUART_OP","AUARTK","AUART_ORD","AUART_RET","SD_AUART","SDOC_TYPE_SD","DOCART","AUART_CONTRACT","SD_COO_TYPE","AUARTTO","ORD_TYPE","AUART_EXT","AUART_BIS","AUART_SD_KG_KG","AUART_SD_KG","AUARTS","SO_AUART","SD_DOCTYPE","SD_ORDER_TYPE","SALESDOCTYP_QUOT","SALESDOCTYP_STAT","SALESDOCTYP_STOK","SOURCE_AUART","DEST_AUART"];
    if(in_array(trim($SalesOrdert1['FIELDNAME']),$fieldname_arr)){
        $create_sales_order_lookup=true;
        $pval[] = $j-1;
    }

    $offset[] = $SalesOrdert1['OFFSET'];
    $leng[] = $SalesOrdert1['LENG'];
    // $text[] = $SalesOrdert1['SCRTEXT_L'];
    $text[] = (trim($SalesOrdert1['SCRTEXT_L']) != "") ? trim($SalesOrdert1['SCRTEXT_L']) : trim($SalesOrdert1['REPTEXT']);
    //var_dump($SalesOrdert1);
}

$_SESSION['look_offset'] = $offset;
$_SESSION['look_leng'] = $leng;
$_SESSION['look_text'] = $text;
$_SESSION['look_p'] = $p;
//var_dump($text);
//............................................................................................................
    $sap_table_result = "HELPVALUES";
    $rowsagt = count($res[$sap_table_result]);

$rowsagt = count($res[$sap_table_result]);
$_SESSION['look_row'] = $rowsagt;
//echo $rowsagt; 
$rows = 30;
if ($rowsagt < $rows) {
    $rows = $rowsagt;
}
for ($j = 0; $j < $rowsagt; $j++) {
    $SalesOrderts[] = $res[$sap_table_result][$j];
    if($create_sales_order_lookup){
        $helpvalue = $SalesOrderts[$j];
        $doctype = trim($helpvalue['HELPVALUES']);
        for ($k = 0; $k < $rowsagt1; $k++) {
            if(in_array($k,$pval) && trim(substr($doctype, $offset[$k], $leng[$k])) == "TA")
                $doctype = substr_replace($doctype, 'OR  ', $offset[$k] , $leng[$k]);
            
			$SalesOrderts1[$j] = array($sap_table_result => $doctype);
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
                        $form=$SalesOrderts1[$j-1];  
                        ?>
                        <tr class="ort df<?php echo $j; ?>" id='df<?php echo $j; ?>'>
                            <?php
                            
                            for ($i = 0; $i < $rowsagt1; $i++) {
                                $calsses = "show_header";
                                if ($i == $p) {
                                    ?>
                                    <td onclick="getval('<?php echo ltrim($form['KUNNR'],'0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['KUNNR']; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form['KUNNR'],'0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo ltrim($form['KUNNR'],'0'); ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form['KUNNR'],'0'); ?></td>
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
                                    <td onclick="getval('<?php echo ltrim($form['KUNNR'], '0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['KUNNR']; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form['KUNNR'], '0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['KUNNR']; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_<?php echo $ij + 1; ?> " alt="display_<?php echo $ij + 1; ?>"><?php echo ltrim($form[$em[$ij+1]]); ?></td>
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