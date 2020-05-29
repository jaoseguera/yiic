<?php
$type   = $_SESSION['look_type'];
$rwos   = 60;
$irows  = $_REQUEST['irows'];
$pre    = $_REQUEST['pre'];
$sq     = explode(',',$pre);

if(isset($_SESSION['row_look']))
{
    if($_SESSION['row_look']=='END') { echo "END"; exit; }
    //$_SESSION['row_look']=$_SESSION['row_look']+30;
}
else { //$_SESSION['row_look']=$rwos;
}

$rwos    = $_SESSION['row_look'];
$rowsagt = $_SESSION['look_row'];
$iend    = $irows+30;

if($rowsagt<$iend)
{
    $iend=$rowsagt-1;
    $_SESSION['row_look']="END";
}

$userid = Yii::app()->user->getState('user_id');
$client = Controller::userDbconnection();
$docs = $client->getDoc($userid);

if(isset($docs->lookup->$type)) {  $doc = $docs->lookup; }
else {
	$client = Controller::couchDbconnection(); 
$doc = $client->getDoc('lookup'); }

$gs  = array(0,1,2);
if(isset($doc->$type->display))
{
    $disp=$doc->$type->display;
    $gs=explode(',',$disp);
}
$order = "0,1,2";
if(isset($doc->$type->order)) { $order=$doc->$type->order; }

$vals           = explode(",",$order);
$ids            = $_SESSION['look_ids'];
$leng           = $_SESSION['look_leng'];
$text           = $_SESSION['look_text'];
$SalesOrderts   = $_SESSION['look_sales'];
$rowsagt1       = $_SESSION['look_row1'];
$theaders  = Controller::technical_names("BAPI2017_GM_HEAD_02");
$labels = "MAT_DOC,DOC_YEAR,DOC_DATE,PSTNG_DATE,TR_EV_TYPE";
$labels   = explode(',',$labels);

for ($j=$irows+1;$j<=$iend;$j++)
{
    $form= $SalesOrderts[$j];
        ?><tr class="ort df<?php echo $j;?>" id='df<?php echo $j;?>'><?php

        $ij = 0;
        for ($i = 0; $i < count($labels); $i++) {
            $calsses = "show_header";
            if($i<3)
                $calsses = "show_header";
            else
                $calsses = "hide_header";


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
        ?></tr><?php
    $form=NULL;
}
?><tr id="scr_lod">
<td class="hide_header"></td><?php
for ($i = 1; $i < count($labels); $i++)
{
    $calsses="hide_header";

        if (!in_array($ij, $gs)) {
            $calsses="hide_header";
        }
        ?><td class="<?php echo $calsses;?>">fg</td><?php

}
?></tr><?php
$iend=NULL;
$irows=NULL;
?>