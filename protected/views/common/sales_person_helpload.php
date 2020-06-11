<?php
$type   = $_SESSION['look_type'];
$irows  = $_REQUEST['irows'];
$pre    = $_REQUEST['pre'];
$sq     = explode(',',$pre);

if(isset($_SESSION['row_look']))
{
    if($_SESSION['row_look']=='END') { echo "END"; exit; }
}

$rwos    = $_SESSION['row_look'];
$rowsagt = $_SESSION['look_row'];
$iend    = $irows+30;

if($rowsagt<=$iend)
{
    $iend=$rowsagt-1;
    $_SESSION['row_look']="END";
}

$ids            = $_SESSION['look_ids'];
$SalesOrderts   = $_SESSION['look_sales'];
$rowsagt1       = $_SESSION['look_row1'];
$labels = "KUNNR,SORTL,ORT01,NAME1";
$labels   = explode(',',$labels);

for ($j=$irows+1;$j<=$iend;$j++) {
    $form= $SalesOrderts[$j];
        ?><tr class="ort df<?php echo $j;?>" id='df<?php echo $j;?>'><?php

        for ($i = 0; $i < $rowsagt1; $i++) {
            $calsses = "show_header";
            ?>
            <td onclick="getval('<?php echo ltrim($form['KUNNR'],'0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form['KUNNR']; ?>', 'single')" ondblclick="getval('<?php echo ltrim($form['KUNNR'],'0'); ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo ltrim($form['KUNNR'],'0'); ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses; ?> display_0" alt='display_0'><?php echo ltrim($form[$labels[$i]],'0'); ?></td>
            <?php
        }
        ?></tr><?php
    $form=NULL;
}
?><?php
$iend=NULL;
$irows=NULL;
?>