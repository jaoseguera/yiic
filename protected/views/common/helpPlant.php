<?php
    $salesOrg= $_REQUEST['salesOrg'];
    $distChan = $_REQUEST['distChan'];
    $ids = $_REQUEST['ids'];
    $_SESSION['look_ids'] = $ids;
    $_SESSION['row_look'] = 30;
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
global $rfc, $fce;
$imp = new BapiImport();
$res = $fce->invoke(['LV_SALORG'=>$salesOrg, 'LV_DIST'=>$distChan]);


$rowsagt = count($res["IT_TAB"]);
$_SESSION['look_row'] = $rowsagt;

$rows = 30;
if ($rowsagt < $rows) {
    $rows = $rowsagt;
}

/*for ($j = 1; $j <= $rowsagt; $j++) {
    $SalesOrderts[] = saprfc_table_read($fce, "IT_TAB", $j);    
}*/
for ($j = 0; $j <= $rowsagt; $j++) {
    $SalesOrderts[] = $res["IT_TAB"][$j];   
}
$_SESSION['look_sales'] = $SalesOrderts1;
$_SESSION['look_row1'] = $rowsagt1;

?>
<div>
    <div id="lookup_head">
        <div id="lookup_header" class="lookup_hed"></div>
    </div>
    <table class="rot_t myTable scrollableFixedHeaderTable" width='95%' id="help" >
        <thead>
            <tr class="hd_tr">
                 <?php
                    $calsses = "show_header";
                ?>
                 <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_PLANT?>
                </th> 
                 <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_NAME?>
                </th>  
                <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_NAME?>
                </th> 
                 <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_SORT?>
                </th> 
                <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_CITY?>
                </th>       
                <th style="white-space:nowrap;" class="look_header <?php echo $calsses; ?> display_0" alt='display_0' >
                    <?=_POSTALCODE?>
                </th>                                
            </tr>
        </thead>
        <tbody>
            <?php        
            $j=1;                                            
            foreach ($SalesOrderts as $form) {                                                
                ?>
                <tr class="ort df<?php echo $j; ?>" id='df<?php echo $j; ?>'>
                     <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["WERKS"]); ?></td>
                    
                     <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["NAME1"]); ?></td>

                      <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["NAME2"]); ?></td>

                       <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["SORT1"]); ?></td>

                        <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["CITY1"]); ?></td>

                        <td onclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form["WERKS"]); ?>','PLANT','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form["WERKS"]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form["POST_CODE"]); ?></td>

               </tr>                
                <?php
                        $j++;
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