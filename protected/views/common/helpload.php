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

$columns = count($gs);
if($type == 'MATERIAL') { $columns = 2; }

$order = "0,1,2";
if(isset($doc->$type->order)) { $order=$doc->$type->order; }

$vals           = explode(",",$order);
$ids            = $_SESSION['look_ids'];
$p              = $_SESSION['look_p'];
$offset         = $_SESSION['look_offset'];
$leng           = $_SESSION['look_leng'];
$text           = $_SESSION['look_text'];
$SalesOrderts   = $_SESSION['look_sales'];
$rowsagt1       = $_SESSION['look_row1'];

for ($j=$irows+1;$j<=$iend;$j++)
{
    $SalesOrdert = $SalesOrderts[$j];
    foreach($SalesOrdert as $form)
    { 
        $metrial= substr($form,9,40);
        ?><tr class="ort df<?php echo $j;?>" id='df<?php echo $j;?>'><?php
        $t_len=0;
        $as=1;
        for($i=0;$i<$rowsagt1;$i++)
        {
            $form1[$i]= substr($form,$offset[$i],$leng[$i]);
            if($type != "MATERIAL") { $form1[$i]= ltrim($form1[$i], "0"); }
            if($i==$p) { $sd[0]=$form1[$i]; }
            else {
                $sd[$as]=$form1[$i];
                $as++;
            }
        }
        //var_dump($sd);
        $metrial=str_replace(" ","",$metrial);
        $ij=0;
        for($i=0;$i<$rowsagt1;$i++)
        {
            $calsses="show_header";
            if($i<$columns)
            {
                ?><td onclick="getval('<?php echo $form1[$p]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo $form1[$p]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'double')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses;?> display_<?php echo $sq[$i];?> " alt="display_<?php echo $sq[$i];?>"><?php echo $sd[$sq[$i]];?></td><?php 
                $ij++;
            }
            else
            { 
                ?><td onclick="getval('<?php echo $form1[$p]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'single')" ondblclick="getval('<?php echo $form1[$p]; ?>','<?php echo $type; ?>','<?php echo $j; ?>','<?php echo $ids; ?>','<?php echo $form1[1]; ?>', 'double')"style="cursor:pointer;white-space:nowrap;"class="hide_header display_<?php echo $sq[$i];?> " alt="display_<?php echo $sq[$i];?>"><?php echo $sd[$sq[$i]];?></td><?php 
            }
        }
        ?></tr><?php
    }
    $form1=NULL;
    $form=NULL;
}
?><tr id="scr_lod">
<td class="hide_header"></td><?php
for($i=0;$i<$rowsagt1;$i++)
{
    $calsses="hide_header";
    if($i!=$p)
    {
        if (!in_array($ij, $gs)) {
            $calsses="hide_header";
        }
        ?><td class="<?php echo $calsses;?>">fg</td><?php
    }
}
?></tr><?php
$iend=NULL;
$irows=NULL;
?>