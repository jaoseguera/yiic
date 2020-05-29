<?php
$em   = $_REQUEST['em'];
$val  = $_REQUEST['val'];
$sh   = $_REQUEST['sh'];
$type = $_REQUEST['type'];
$ids  = $_REQUEST['ids'];
$parameter = $_REQUEST['para'];

$_SESSION['look_type'] = $type;
$_SESSION['look_ids'] = $ids;
$_SESSION['row_look'] = 30;

$order = "";
if(isset($docs->lookup->$type->order)) {
    $order = $docs->lookup->$type->order;
}
else
{    
    $doc = $client->getDoc('lookup');    
    if(isset($doc->$type->order))
        $order = $doc->$type->order; 
}

$gs = array(0,1,2);
if(isset($docs->lookup->$type->display))
{
    $disp = $docs->lookup->$type->display;
    $gs   = explode(',',$disp);
}
else
{
    $doc = $client->getDoc('lookup');
    if(isset($doc->$type->display))
    {
        $disp = $doc->$type->display;
        $gs = explode(',',$disp);
    }
}

?><script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/table.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ColReorder.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready( function () {  var oTable = $('#help').dataTable({ "bPaginate": false, "bSort": false, "sDom": 'R', "oColReorder": { "aiOrder": [ <?php  echo $order;?> ] } }); });
</script>

<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/table.css" rel="stylesheet" type="text/css"/>
<style>
.rot_t { background:#fff; padding:5px; text-align:center; }
.rot_t th, .rot_t td { padding-bottom:3px; padding-top:3px; border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif; }
.rot_t tr { background:#fff; }
.ort:hover { background:#F5F5F5; color:#333333; }
.ort { color:#666; height:15px; }
.hd_tr { color:#333333; font-weight:bold; }
</style>

<?php
global $rfc,$fce;
$em_ex  = explode(",",$em);
$val_ex = explode(",",$val);
$findme = '@';
$p      = $_REQUEST['sel'];
$pos    = strpos($p,$findme);

if($pos!==false)
{
    $ss = explode('@',$p);
    $p  = $ss[0];
}
$_SESSION['look_p'] = $p;

$EXPLICIT_SHLP = array("SHLPNAME"=>$sh,"SHLPTYPE"=>"SH","TITLE"=>"","REPTEXT"=>"");
$create_from   = $_REQUEST['method'];
$BUS           = $_REQUEST['obj'];

//GEZG 06/22/2018
//Changing SAPRFC methods
$options = ['rtrim'=>true];
$importTableHelpValues = array();


foreach($em_ex as $keys=>$values)
{
    $vals = strtoupper($val_ex[$keys]);
    if($vals!="")
    {
        $SELECTION_FOR_HELPVALUES=array("SELECT_FLD"=>$values,"SIGN"=>"I","OPTION"=>"CP","LOW"=>$vals."*","HIGH"=>"");
        array_push($importTableHelpValues, $SELECTION_FOR_HELPVALUES);        
    }
}
$res = $fce->invoke(["OBJTYPE"=>$BUS,
            "OBJNAME"=>"",
            "METHOD"=>$create_from,
            "PARAMETER"=>$parameter,
            "FIELD"=>$type,
            "EXPLICIT_SHLP"=>$EXPLICIT_SHLP,
            "SELECTION_FOR_HELPVALUES"=>$importTableHelpValues],$options);

$rowsagt1 = count($res["DESCRIPTION_FOR_HELPVALUES"]);

for ($j=0;$j<$rowsagt1;$j++)
{
    $SalesOrdert1 = $res["DESCRIPTION_FOR_HELPVALUES"][$j];
    $offset[]=$SalesOrdert1['OFFSET'];
    $leng[]=$SalesOrdert1['LENG'];
    $text[]=$SalesOrdert1['SCRTEXT_L'];
}
$_SESSION['look_offset']=$offset;
$_SESSION['look_leng']=$leng;
$_SESSION['look_text']=$text;

$rowsagt = count($res["HELPVALUES"]);
$_SESSION['look_row']=$rowsagt;
$rows=30;
if($rowsagt<$rows) $rows=$rowsagt;
for ($j=0;$j<$rowsagt;$j++){
    $SalesOrderts[] = $res["HELPVALUES"][$j];
}
$_SESSION['look_sales']=$SalesOrderts;
$_SESSION['look_row1']=$rowsagt1;
?>
<div>
<div id="lookup_head">
<div id="lookup_header" class="lookup_hed"></div>
</div>
<table class="rot_t myTable scrollableFixedHeaderTable" width='95%' id="help" >
<thead>
<tr class="hd_tr"><?php 
for ($j=0;$j<$rowsagt1;$j++)
{ 
    $calsses="show_header";
    if($j==$p) ?><th style="white-space:nowrap;" class="look_header <?php echo $calsses;?> display_0" alt='display_0' title="<?php echo $type;?>" id='542'><?php echo $text[$j];?></th><?php 
}
$ji=0;
for ($j=0;$j<$rowsagt1;$j++)
{ 
    $calsses="show_header";
    if($j!=$p)
    {
        if (!in_array($ji,$gs)) $calsses="hide_header";
        ?><th style="white-space:nowrap;" class="look_header <?php echo $calsses;?> display_<?php echo $ji+1;?>" alt="display_<?php echo $ji+1;?>" title="<?php echo $type;?>" id="<?php echo $ji;?>"><?php echo $text[$j];?></th><?php 
        $ji++;
    }
}
?></tr>
</thead>
<tbody><?php 
for ($j=0;$j<$rows;$j++)
{
    $SalesOrdert = $res["HELPVALUES"][$j];
    foreach($SalesOrdert as $form)
    { 
        $metrial= substr($form,9,40);
        ?><tr class="ort df<?php echo $j;?>" id='df<?php echo $j;?>'><?php
        $t_len=0;
        for($i=0;$i<$rowsagt1;$i++)
        {
            $form1[$i]= substr($form,$offset[$i],$leng[$i]);
        }
        $metrial=str_replace(" ","",$metrial);
        for($i=0;$i<$rowsagt1;$i++)
        {
            $calsses="show_header";
            if($i==$p) ?><td onclick="getval('<?php echo $form1[$p];?>','<?php echo $type;?>','<?php echo $j ;?>','<?php echo $ids;?>','<?php echo $form1[1];?>')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses;?> display_0" alt='display_0'><?php echo $form1[$i];?></td><?php 
        }
        $ij=0;
        for($i=0;$i<$rowsagt1;$i++)
        {
            $calsses="show_header";
            if($i!=$p)
            {
                if (!in_array($ij, $gs)) $calsses="hide_header";
                ?><td  onclick="getval('<?php echo $form1[$p];?>','<?php echo $type;?>','<?php echo $j ;?>','<?php echo $ids;?>','<?php echo $form1[1];?>')" style="cursor:pointer;white-space:nowrap;"class="<?php echo $calsses;?> display_<?php echo $ij+1;?> " alt="display_<?php echo $ij+1;?>"><?php echo $form1[$i];?></td><?php 
                $ij++;
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
        if (!in_array($ij, $gs)) $calsses="hide_header";        
        ?><td class="<?php echo $calsses;?>">as</td><?php
    }
}
?></tr>
</tbody>
</table>
</div>