<?php
$MATERIAL  = strtoupper($_REQUEST['values']);
if(is_numeric($MATERIAL))
{
	$materialLenth  = count($MATERIAL);
	if($materialLenth < 18) { $MATERIAL = str_pad($MATERIAL, 18, 0, STR_PAD_LEFT); } else { $MATERIAL = substr($MATERIAL, -18); }
}
$technical = $model;
$t_headers = Controller::technical_names('BAPI_MRP_STOCK_DETAIL');	
?>
<h3 style="border-bottom:1px solid #cecece;">MATERIAL : <?php echo $MATERIAL;?> <div onClick='ccls()' style="position:relative;float:right;cursor:pointer">close</div></h3>
<div class="prod_material">
<?php
foreach($SalesOrder as $prod=>$keys)
{ if($t_headers[$prod]!='') {?>
<div class="span5 daw" style="padding:10px;margin:0px;">
<li style="font-weight:bold;margin-left:6px;"><?php echo $t_headers[$prod];?>:</li>
<li style="text-align:left;border:1px solid #cecece;border-radius:5px;margin-left:5px;"><span style="padding-left:3px;"><?php echo $keys;?></span></li>
</div>
<?php  }
}
?>
</div>