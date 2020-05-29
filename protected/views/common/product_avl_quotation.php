<?php
$MATERIAL  = strtoupper($_REQUEST['MATERIAL']);
if(is_numeric($MATERIAL)){
	$materialLenth  = count($MATERIAL);
	if($materialLenth < 18) { $MATERIAL = str_pad($MATERIAL, 18, 0, STR_PAD_LEFT); } else { $MATERIAL = substr($MATERIAL, -18); }
}?>
<h3 style="border-bottom:1px solid #cecece;">MATERIAL : <?php echo $MATERIAL;?> <div onClick='ccls()' style="position:relative;float:right;cursor:pointer">close</div></h3>
<div class="prod_material">
<?php
$t_headers = Controller::technical_names('BAPI_PROD_AVAIL');	
foreach($SalesOrder as $prod=>$keys){ ?>
	<div class="span5" style="padding:10px;">
      	<span class="span6" style="font-weight:bold;"><?php echo $t_headers[$prod];?>:</span>
    	<span class="span6" style="text-align:left;border:1px solid #cecece;border-radius:5px;margin-left:5px;">
    		<span style="padding-left:3px;"><?php echo $keys;?></span>
    	</span>
    </div>
<?php
    }
?>