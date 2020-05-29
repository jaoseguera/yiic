<?php
	$id         = $_REQUEST['id'];
	$val        = $_REQUEST['val'];
	$ses        = $_REQUEST['ses'];
	$table_name = $_REQUEST['table_name'];
	$tec_name   = $_REQUEST['tbname'];
	$sess       = explode('@',$ses);
	$t_id       = $sess[1];
	$SalesOrder = $_SESSION[$sess[0]];
	
	$rows = $_COOKIE['table_cell'];
	$technical  = $model;
	$t_headers  = Controller::technical_names($tec_name);
	$split_rows = explode(",",$rows);
	
	if(isset($_SESSION['combine']))
	{
		$combine=$_SESSION['combine'];
	}
	
	if($val != NULL)
	{
		foreach($SalesOrder as $keys=>$values)
		{
			foreach($values as $sd=>$gf)
			{
				$date = Controller::dateValue($t_headers, $sd, $gf);
				if($date != false)
					$gf = $date;
				
				$pos = strpos(strtolower($gf), strtolower($val));
				if($sd == $id && $pos !== false)
					$gd[] = $keys;
			}
		}
	}
	else
	{
		?><script>
		$(document).ready(function(e) 
		{
			rowShort('<?php echo $t_id;?>','L','<?php echo $tec_name; ?>','<?php echo $sess[0]; ?>');
			$('.testr').show();		
		});
		</script><?php 
	}
	
	$inc = 1;
	if(isset($gd))
	{
		if(isset($_REQUEST['kiu']))
			$gf = $_REQUEST['kiu'];
		
		foreach($gd as $fd)
		{
			if($inc <= $gf)
			{
				$SalesOrders = $SalesOrder[$fd];
				$this->renderPartial('/bapi_tablerender/tablebody', array('SalesOrders' => $SalesOrders, 'split_rows' => $split_rows, 't_headers' => $t_headers, 't_id' => $t_id, 'tec_name' => $tec_name, 'table_name' => $_REQUEST['table_name'], 'array23' => $array23, 'i' => $inc));
			}
			$inc++;
		}
	}
	else
	{
		?><h3 style="text-align:center;">Match not found</h3><?php 
	}
?>
<script>
	$("#<?php echo $t_id;?>_row").val('<?php echo count($gd); ?>');
    var $disptablerow = $("#<?php echo $t_id; ?> tbody tr");
    //displaytrimzero($disptablerow);
</script>