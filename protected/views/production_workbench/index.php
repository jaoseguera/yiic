<?php
global $rfc,$fce;
if(Yii::app()->user->hasState("extended"))
{
    $extended = Yii::app()->user->getState('extended');
    // $rfc = Yii::app()->user->setState('rfc');
}
else { $extended = ""; }

if($extended!='on')
{
	$ORDER_NUMBER_RANGE=array("SIGN"=>"I","OPTION"=>"BT","LOW"=>"0","HIGH"=>"999999999999");
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$importTableORDERNUMBER = array();	
	array_push($importTableORDERNUMBER, $ORDER_NUMBER_RANGE);
	$t_date=$_SESSION['t_date'];
	$res = $fce->invoke(['ORDER_NUMBER_RANGE'=>$importTableORDERNUMBER],$options);		
	$SalesOrder=$res['ORDER_HEADER'];

}
else
{
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$res = $fce->invoke([],$options);	
	$over_due_createt=$res['ORDER_HEADER_OVERDUE'];
	$over_due_releaset=$res['ORDER_HEADER_OVERDUE_REL'];
	$todays_prod_orderst=$res['ORDER_HEADER_TODAY'];
	$todays_released_orderst=$res['ORDER_HEADER_REL_TODAY'];
	$last_prod_orderst=$res['ORDER_HEADER_LAST7DAYS'];
	$last_released_orderst=$res['ORDER_HEADER_REL_LAST7DAYS'];
}
$labels_today="ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,MATERIAL,TARGET_QUANTITY";

if(isset($doc->customize->production_workbench->Table_order))
{
	$labels_today=$doc->customize->production_workbench->Table_order;
}
$exp=explode(',',$labels_today);
if($extended!='on')
{
	$sd=1;
	$labels_today="ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,MATERIAL,TARGET_QUANTITY";
	if(isset($doc->customize->production_workbench->Table_order))
	{
		$labels_today=$doc->customize->production_workbench->Table_order;
	}
	$exp=explode(',',$labels_today);
	foreach($SalesOrder as $val_t=>$retur)
	{
		$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
		unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
		$today=$retur;
		$SalesOrder[$sd] = array_merge((array)$order_t, (array)$today);
		$sd++;
	}	

	//var_dump($SalesOrder);
	$date=explode('/',$t_date);
	$today_date=trim($date[2]).trim($date[0]).trim($date[1]);
	$last_seven_days=trim($date[2]).trim($date[0]).trim($date[1]-7);
	//var_dump($SalesOrder);
	$p1=1;$p2=1;$p3=1;$p4=1;$p5=1;
	$over_due_create=NULL;
	$over_due_release=NULL;
	$todays_prod_orders=NULL;
	$todays_released_orders=NULL;
	$last_prod_orders=NULL;
	$last_released_orders=NULL;
	
	foreach($SalesOrder as $hs=>$ej)
	{
		if($ej['START_DATE']==$today_date&&$ej['ACTUAL_START_DATE']==00000000&&$ej['ACTUAL_RELEASE_DATE']==00000000)
		{
			$over_due_create[]=$ej;
		}
		if($ej['START_DATE']==$today_date&&$ej['ACTUAL_START_DATE']==00000000&&$ej['ACTUAL_RELEASE_DATE']!=00000000)
		{
			$over_due_release[$p1]=$ej;
			$p1++;
		}
		if($ej['START_DATE']==$today_date)
		{
			$todays_prod_orders[$p2]=$ej;
			$p2++;
		}
		if($ej['SCHED_RELEASE_DATE']==$today_date)
		{
			$todays_released_orders[$p3]=$ej;
			$p3++;
		}
		if($ej['START_DATE']<=$today_date&&$ej['START_DATE']>$last_seven_days)
		{
			$last_prod_orders[$p4]=$ej;
			$p4++;
		}
		if($ej['SCHED_RELEASE_DATE']<=$today_date&&$ej['SCHED_RELEASE_DATE']>=$last_seven_days)
		{
			$last_released_orders[$p5]=$ej;
			$p5++;
		}
	}
}
if($extended=='on')
{
	$over_due_create=NULL;
	$over_due_release=NULL;
	$todays_prod_orders=NULL;
	$todays_released_orders=NULL;
	$last_prod_orders=NULL;
	$last_released_orders=NULL;
	$asd=1;
	if($over_due_createt!=NULL)
	{
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach($over_due_createt as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$over_due_create[$asd] = array_merge((array)$order_t, (array)$today);
			$asd++;
		}
	}
	if($over_due_releaset!=NULL)
	{
		$asd=1;
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach($over_due_releaset as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$over_due_release[$asd] = array_merge((array)$order_t, (array)$today);

			$asd++;
		}	
	}
	if($todays_prod_orderst!=NULL)
	{
		$asd=1;		
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		
		foreach($todays_prod_orderst as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$todays_prod_orders[$asd] = array_merge((array)$order_t, (array)$today);
			$asd++;
		}
	}
	if($todays_released_orderst!=NULL)
	{
		$asd=1;
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach($todays_released_orderst as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$todays_released_orders[$asd] = array_merge((array)$order_t, (array)$today);
			$asd++;
		}
	}
	if($last_prod_orderst!=NULL)
	{
		$asd=1;
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach($last_prod_orderst as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$last_prod_orders[$asd] = array_merge((array)$order_t, (array)$today);
			$asd++;
		}
	}
	if($last_released_orderst!=NULL)
	{
		$asd=1;
		$table_labels = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$labels       = "ORDER_NUMBER,PRODUCTION_PLANT,MRP_CONTROLLER,TARGET_QUANTITY,CONF_CNT";
		$tableField1  = $screen.'_production_workbench';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_labels);
		$exp   = explode(',',$labels);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach($last_released_orderst as $val_t=>$retur )
		{
			$order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
			unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
			$today=$retur;
			$last_released_orders[$asd] = array_merge((array)$order_t, (array)$today);
			$asd++;
		}
	}
}
	
// var_dump($over_due_create);
$_SESSION['table_today'] = $over_due_create;
$rowsag1 = count($over_due_create);
$_SESSION['pr2'] = $over_due_release;
$rowsag2=count($over_due_release);
$_SESSION['pr3'] = $todays_prod_orders;
$rowsag3=count($todays_prod_orders);
$_SESSION['pr4'] = $todays_released_orders;
$rowsag4=count($todays_released_orders);
$_SESSION['pr5'] = $last_prod_orders;
$rowsag5=count($last_prod_orders);
$_SESSION['pr6'] = $last_released_orders;
$rowsag6=count($last_released_orders);

$sut = max($rowsag1,$rowsag2,$rowsag3,$rowsag4,$rowsag5,$rowsag6);
$s   = $sut;
$s   = $s/4;
$sut = $sut+$s;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>sap in (beta), by Emergys</title>
<meta name="description" content="A complete admin panel theme">
<meta name="author" content="theemio">
<!-- styles -->
<style type="text/css" title="currentStyle">
.table th { min-width:180px; }
</style>
<script>
/*
function submitForm1() 
{
	jAlert('loading...', 'Create Delivery');
	$.ajax({type:'POST', url: '../lib/controller.php', data:$('#ContactForm1').serialize(), success: function(response) {
	jAlert('<b>SAP System Message:</b><br>'+response, 'Create Delivery');
	}});
	return false;
}

function submitForm() 
{
	jAlert('loading...', 'Create Billing');
	$.ajax({type:'POST', url: '../lib/controller.php', data:$('#ContactForm').serialize(), success: function(response) {
	jAlert('<b>SAP System Message: </b><br>'+response, 'Create Billing');
	}});
	return false;
}

$(document).ready(function() 
{
	$('#deli_ch').click(function()
	{
	if($('#deli_ch').is(':checked'))
	{
	$('.deli_check').attr('checked', true);
	}
	else
	{
	$('.deli_check').attr('checked', false);
	}
	})
})

$(document).ready(function() 
{
	$('#bill_ch').click(function()
	{
	if($('#bill_ch').is(':checked'))
	{
	$('.bill_check').attr('checked', true);
	}
	else
	{
	$('.bill_check').attr('checked', false);
	}
	})
})
*/
function show_bar(ids)
{
	$('.active').removeClass('active')
	$('#'+ids).trigger('click');
}
</script>

<style>
.grf { border:1px solid #cecece; height:180px; }
.grf td div { width:40px; }
.gap { width:10px; }
.bar_tip { height:180px; font-size:12px; color:#666; }
.bar_tip ul li { list-style:none; height:36px; border-top:1px solid #cecece; }
.bar_tip ul { float:right; margin-top:6px; }
.sb { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/sales_delivery.png') no-repeat; }
.sd { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/sales_billing.png') no-repeat; }
.sdt { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/sdt.png') no-repeat; }
.tods { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/todays.png') no-repeat; }
.bak { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/back_order.png') no-repeat; }
.reo { width:12px; height:12px; background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/return_orders.png') no-repeat; }
.leng { color:#666; font-size:10px; }
.leng td { padding:4px; }
.commt td { padding-top:6px; }
.strip { position:absolute; padding-left:150px; margin-top:-10px; }
</style> 
<!--[if IE 8]>
<link href="../css/ie8.css" rel="stylesheet">
<![endif]-->
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]><script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script><![endif]-->

</head>
<body style="overflow:hidden;">
<?php
$customize = $model;
$technical=$model;
$this->renderPartial('smarttable');

$extable_th  = ""; $ex2table_th = "";
$ex3table_th = ""; $ex4table_th = "";
$extable_td  = ""; $ex2table_td = "";
$ex3table_td = ""; $ex4table_td = "";
$ex1table_th = ""; $ex1table_td = "";
$ex5table_th = ""; $ex5table_td = "";
$th_example  = ""; $th_example1 = "";
$th_example2 = ""; $th_example3 = "";
$th_example4 = ""; $th_example5 = "";

?><div class="span7">
	<section class="utopia-widget" style="min-width:550px;">
		<div class="utopia-widget-title">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/stats_bars.png" class="utopia-widget-icon">
			<span class='cutz sub_titles' alt='Bar charts'><?php echo Controller::customize_label('Bar charts');?></span>
		</div>
		
		<div class="utopia-widget-content">
			<table border="0" class="shaw"><tr>
				<td><div class='bar_tip'>
					<ul>
						<li style="border:0px;"><?php echo round($s*5);?></li>
						<li><?php echo round($s*4);?></li>
						<li><?php echo round($s*3);?></li>
						<li><?php echo round($s*2);?></li>
						<li><?php echo round($s*1);?></li>
					</ul>
				</div></td>
				<td>
					<table class="grf"><tr>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t1')" style="cursor:pointer;background:#F9F9F9;" href="#tab1" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo ($rowsag1*180)/$sut;?>px;background:#F8E7B2;width:40px;border:1px solid #EDC243;border-bottom:0px;" onClick="show_bar('t_od')" tip="Over Due Created<br><?php echo $rowsag1;?>" class="blue"></div></td>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t2')" style="cursor:pointer;background:#F9F9F9;" href="#tab2" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo ($rowsag2*180)/$sut;?>px;background:#BF8CBC;width:40px;border:1px solid #8C4D88;border-bottom:0px;" onClick="show_bar('t_od')" tip="Over Due Created<br><?php echo $rowsag2;?>" class="blue"></div></td>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t3')" style="cursor:pointer;background:#F9F9F9;" href="#tab3" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo 1+($rowsag3*180)/$sut;?>px; background:#DFEFFC;border:1px solid #AFD8F8;border-bottom:0px;" onClick="show_bar('t_od')"  tip="Today's Prod Orders<br><?php echo $rowsag3;?>" class="blue"></div></td>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t4')" style="cursor:pointer;background:#F9F9F9;" href="#tab4" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo ($rowsag4*180)/$sut;?>px; background:#EAB7B7;width:40px;border:1px solid #CB4B4B;border-bottom:0px;"  tip="Today's released Orders<br><?php echo $rowsag4;?>" class="blue"></div></td>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t5')" style="cursor:pointer;background:#F9F9F9; " href="#tab5" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo ($rowsag5*180)/$sut;?>px; background:#B2D7B2;border:1px solid #4DA74D;border-bottom:0px;" onClick="show_bar('t_od')"  tip="Last 7 Days Prod Orders<br><?php echo $rowsag5 ;?>" class="blue"></div></td>
						<td class="gap"></td>
						<td valign="bottom" onClick="show_bar('t6')" style="cursor:pointer;background:#F9F9F9; " href="#tab6" data-toggle="tab">
						<div style="height:<?php if($sut != 0) echo ($rowsag6*180)/$sut;?>px; background:#ffb588;border:1px solid #ff7019;border-bottom:0px;" onClick="show_bar('t_od')"  tip="Last 7 Days released Prod Orders<br><?php echo $rowsag6 ;?>" class="blue"></div></td>
						<td class="gap"></td>
					</tr></table>
				</td>
				<td valign="top" style="padding-top:20px;padding-left:10px;">
					<table border="0" class="leng">
						<tr><td class="tods"></td><td  style="cursor:pointer;" onClick="show_bar('t1')" href="#tab1" data-toggle="tab">Over Due Created</td></tr>
						<tr><td class="bak"></td><td style="cursor:pointer;" onClick="show_bar('t2')" href="#tab2" data-toggle="tab">Over Due Released</td></tr>
						<tr><td class="reo"></td><td style="cursor:pointer;" onClick="show_bar('t3')" href="#tab3" data-toggle="tab">Today's Prod Orders</td></tr>
						<tr><td class="sb"></td><td style="cursor:pointer;" onClick="show_bar('t4')" href="#tab4" data-toggle="tab">Today's released Orders</td></tr>
						<tr><td class="sd"></td><td style="cursor:pointer;" onClick="show_bar('t5')" href="#tab5" data-toggle="tab">Last 7 Days Prod Orders</td></tr>
						<tr><td class="sdt"></td><td style="cursor:pointer;" onClick="show_bar('t6')" href="#tab5" data-toggle="tab">Last 7 Days released Prod Orders</td></tr>
					</table>
				</td>
			</tr>
			<tr><td colspan='3' align='center' class='strip'>Production Workbench</td></tr></table>
		</div>
	</section>
</div>

<div class="row-fluid">
	<div  class='span12'>	
		<div class="row-fluid">
			<div class="tabbable">
				<ul class="nav nav-tabs menu_tab">
					<li id='li1' class="active"><a href="#tab1" data-toggle="tab" id='t1'>Over Due Created</a></li>
					<li id='li2'><a href="#tab2" data-toggle="tab" id='t2' onClick='return getBapitable("pr2","BAPI_ORDER_HEADER1","example1","L","show_conf@<?php echo $s_wid;?>","production_workbench","tab")'>Over Due Released</a></li>
					<li id='li3'><a href="#tab3" data-toggle="tab" id='t3'  onClick='return getBapitable("pr3","BAPI_ORDER_HEADER1","example2","L","show_rels@<?php echo $s_wid;?>","production_workbench","tab")'>Today's Prod Orders</a></li>
					<li id='li4'><a href="#tab4" data-toggle="tab" id='t4'  onClick='return getBapitable("pr4","BAPI_ORDER_HEADER1","example3","L","show_conf@<?php echo $s_wid;?>","production_workbench","tab")'>Today's released Orders</a></li>
					<li id='li5'><a href="#tab5" data-toggle="tab" id='t5'  onClick='return getBapitable("pr5","BAPI_ORDER_HEADER1","example4","L","show_rels@<?php echo $s_wid;?>","production_workbench","tab")'>Last 7 Days Prod Orders</a></li>
					<li id='li6'><a href="#tab6" data-toggle="tab" id='t6'  onClick='return getBapitable("pr6","BAPI_ORDER_HEADER1","example5","L","show_conf@<?php echo $s_wid;?>","production_workbench","tab")'>Last 7 Days released Prod Orders</a></li>
					<li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px" onClick="more_menu()">
					<div id='pos_tab'></div></li>
				</ul>
				
				<div class="tab-content" style="overflow-y:hidden;padding-bottom:55px;">
					<div class="pos_pop">
						<div class='pos_center'></div>
						<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
						<button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
					</div>
					<div id="exp_pop" style="display:none;" class="labl">
						<div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
						<div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
						<div  style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
						<div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
					</div>
					<div class="tab-pane active" id="tab1"><?php 
					if($over_due_create!=NULL)
					{
						?><input type="hidden" class="tbName_example" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example')"></span></td>
									</tr>
								</table>
							</div>
							<div id='table_today'>
								<!--
								<table  class="table table-striped table-bordered" id="example" alt="production_workbench"><?php
								$table_th="";
								$table_td="";
								$th_example="";

								$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
								foreach($over_due_create as $hs=>$ej)
								{
									if($hs==0) 
									{ 
										?><thead><tr><?php 
										foreach($ej as $inner=>$value)
										{
											?><th onclick="rowShort('<?php echo $inner;?>',this,'BAPI_ORDER_HEADER1','table_today')">
												<div class="example_<?php  echo $inner?> cutz" alt='<?php echo $t_headers[$inner];?>'><span class="ddrg dragtable-drag-handle">&nbsp;</span><span class="notdraggable"><?php echo Controller::customize_label($t_headers[$inner]);?></span></div>
												<div class="example_th example_<?php  echo $inner?>_hid" name='<?php  echo $inner?>' style="display:none;"><?php  echo $t_headers[$inner]?></div>
												<div class="example_tech" style="display:none;"><?php  echo $inner."@".$t_headers[$inner];?></div>
											</th><?php
										} 
										?></tr>
										<tr style="display:none;" class="example_filter"><?php 
										$s=1;
										foreach($ej as $inner=>$value )
										{ 
											?><th><input type="text"  class="search_int" value="" alt='<?php echo $s;?>' name="table_today@example"></th><?php
											$s++;
										}
										?></tr></thead><?php
									} 
									if($hs==0) 
									{
										?><tbody id='example_tbody'><?php 
									} 
									?><tr Onclick="thisrow(this,'<?php echo $i;?>',event)"><?php
									$col=0;
									foreach($ej as $inner=>$value)
									{
										?><td class="example_cl<?php echo  $col;?>"><?php 
										if($t_headers[$inner]=="Order")
										{ 
											$id=$value;
											?><div  id="<?php echo trim($id.'_'.$col);?>" style="cursor:pointer;color:#00AFF0;">
												<div  onClick="show_rels('<?php echo trim($id.'_'.$col);?>','<?php echo $value;?>','BAPI_ORDER_HEADER1','production_workbench')" title="Release Production order"><?php echo $value;?></div>
											</div><?php 
										} 
										else
										{
											if (is_numeric(trim($value))) 
											{
												echo round(trim($value),2);
											}
											else
											{
												echo $value;
											}
										}
										?></td><?php
										$col++;
									}
									?></tr><?php
									if($hs==(count($SalesOrder)-1)) 
									{	
										?></tbody><?php 
									}
								}
								?></table>
								-->
							</div><?php 
							if($rowsag1>10) 
							{
								?><div class='testr table_today' onClick='return getBapitable("table_today","BAPI_ORDER_HEADER1","example","S","show_conf@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					} 
					else 
					{
						echo "Match Not Found"; 
					}  
					?></div>
					<div class="tab-pane" id="tab2"><?php 
					if($over_due_release!=NULL)
					{
						?><input type="hidden" class="tbName_example1" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example1')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example1_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example1')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example1')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example1_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example1')"></span></td>
								</tr></table>
							</div>
							<div id='pr2'></div><?php 
							if($rowsag2>10) 
							{
								?><div class='testr pr2' onClick='return getBapitable("pr2","BAPI_ORDER_HEADER1","example1","S","show_conf@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example1_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					}  
					else 
					{ 
						echo "Match Not Found"; 
					} 
					?></div>
					<div class="tab-pane" id="tab3"><?php 
					if($todays_prod_orders!=NULL)
					{
						?><input type="hidden" class="tbName_example2" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example2')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example2_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example2')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example2')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example2')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example2_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example2')"></span></td>
								</tr></table>
							</div>
							<div id='pr3'></div><?php 
							if($rowsag3>10) 
							{
								?><div class='testr pr3' onClick='return getBapitable("pr3","BAPI_ORDER_HEADER1","example2","S","show_rels@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example2_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					}  
					else 
					{ 
						echo "Match Not Found"; 
					} 
					?></div>
					<div class="tab-pane" id="tab4"><?php 
					if($todays_released_orders!=NULL)
					{
						?><input type="hidden" class="tbName_example3" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example3')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example3_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example3')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example3')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example3')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example3_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example3')"></span></td>
								</tr></table>
							</div>
							<div id='pr4'></div><?php 
							if($rowsag4>10) 
							{
								?><div class='testr pr4' onClick='return getBapitable("pr4","BAPI_ORDER_HEADER1","example3","S","show_conf@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example3_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					}  
					else 
					{ 
						echo "Match Not Found"; 
					} 
					?></div>
					<div class="tab-pane" id="tab5"><?php 
					if($last_prod_orders!=NULL)
					{
						?><input type="hidden" class="tbName_example4" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example4')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example4_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example4')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example4')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example4')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example4_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example4')"></span></td>
								</tr></table>
							</div>
							<div id='pr5'></div><?php 
							if($rowsag5>10) 
							{
								?><div class='testr pr5' onClick='return getBapitable("pr5","BAPI_ORDER_HEADER1","example4","S","show_rels@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example4_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					}  
					else 
					{ 
						echo "Match Not Found"; 
					} 
					?></div>
					<div class="tab-pane" id="tab6"><?php 
					if($last_released_orders!=NULL)
					{
						?><input type="hidden" class="tbName_example5" value="BAPI_ORDER_HEADER1" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons">
								<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example5')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example5_table')"></span></td>
									<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example5')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example5')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example5')"></span></td>
									<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example5_table')"></span></td>
									<td ><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example5')"></span></td>
								</tr></table>
							</div>
							<div id='pr6'></div><?php 
							if($rowsag6>10) 
							{
								?><div class='testr pr6' onClick='return getBapitable("pr6","BAPI_ORDER_HEADER1","example5","S","show_conf@<?php echo $s_wid;?>","production_workbench","show_more")'>Show more</div>
								<div id='example5_num' style="display:none;">10</div><?php 
							}
						?></div><?php 
					}  
					else 
					{ 
						echo "Match Not Found"; 
					} 
					?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id='example_table' style="display:none"><?php // echo json_encode($over_due_create);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($over_due_create as $number_keys => $array_values)
{
	foreach($array_values as $header_values => $row_values)
	{
		$header_values1 = $t_headers[$header_values];
		unset($array_values[$header_values]);
		$array_values[$header_values1] = $row_values;
	}
	$over_due_create[$number_keys] = $array_values;
}
echo json_encode($over_due_create);
?></div>
<div id='example1_table' style="display:none"><?php // echo json_encode($over_due_release);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($over_due_release as $number_keys => $array_values)
{
	foreach($array_values as $header_values => $row_values)
	{
		$header_values1 = $t_headers[$header_values];
		unset($array_values[$header_values]);
		$array_values[$header_values1] = $row_values;
	}
	$over_due_release[$number_keys] = $array_values;
}
echo json_encode($over_due_release);
?></div>
<div id='example2_table' style="display:none"><?php // echo json_encode($todays_prod_orders);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($todays_prod_orders as $number_keys => $array_values)
{
	foreach($array_values as $header_values => $row_values)
	{
		$header_values1 = $t_headers[$header_values];
		unset($array_values[$header_values]);
		$array_values[$header_values1] = $row_values;
	}
	$todays_prod_orders[$number_keys] = $array_values;
}
echo json_encode($todays_prod_orders);
?></div>
<div id='example3_table' style="display:none"><?php // echo json_encode($todays_released_orders);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($todays_released_orders as $number_keys => $array_values)
{
foreach($array_values as $header_values => $row_values)
{
$header_values1 = $t_headers[$header_values];
unset($array_values[$header_values]);
$array_values[$header_values1] = $row_values;
}
$todays_released_orders[$number_keys] = $array_values;
}
echo json_encode($todays_released_orders);
?></div>
<div id='example4_table' style="display:none"><?php // echo json_encode($last_prod_orders);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($last_prod_orders as $number_keys => $array_values)
{
foreach($array_values as $header_values => $row_values)
{
$header_values1 = $t_headers[$header_values];
unset($array_values[$header_values]);
$array_values[$header_values1] = $row_values;
}
$last_prod_orders[$number_keys] = $array_values;
}
echo json_encode($last_prod_orders);
?></div>
<div id='example5_table' style="display:none"><?php // echo json_encode($last_released_orders);

$t_headers=Controller::technical_names('BAPI_ORDER_HEADER1');
foreach($last_released_orders as $number_keys => $array_values)
{
foreach($array_values as $header_values => $row_values)
{
$header_values1 = $t_headers[$header_values];
unset($array_values[$header_values]);
$array_values[$header_values1] = $row_values;
}
$last_released_orders[$number_keys] = $array_values;
}
echo json_encode($last_released_orders);
?></div>
<div id='export_table' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div><?php 
if($over_due_create!=NULL)
{
	?><script type="text/javascript">
	$(document).ready(function () 
	{ 
		data_table('example');
		$('#example').each(function()
		{
			$(this).dragtable(
			{
				placeholder: 'dragtable-col-placeholder test3',
				items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
				appendTarget: $(this).parent(),
				tableId: 'example',
				tableSess: 'table_today',
				scroll: true
			});
		})
	});
	</script>
	<?php 
} 
?><script type="text/javascript">
$(document).ready(function () 
{
	$(".grf").find("td").each(function() {
		valign = $(this).attr("valign");
		if(valign != undefined)
			$(this).css("vertical-align", "bottom");
	});
	
	getBapitable("table_today","BAPI_ORDER_HEADER1","example","L","nones@<?php echo $s_wid;?>","production_workbench","submit");
	
	$('#loading').hide();
	$("body").css("opacity","1");
	
	$('#t1').click(function() 
	{
		$('.head_fix').remove();
	});
	$('.tabbable ul li a').click(function()
	{
		//alert($(this).attr('id'));
		$.cookie('tabs',$(this).attr('id'));
	})
	$('#'+$.cookie('tabs')).trigger('click');
	$('.search_int').keyup(function () 
	{
		sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
	})
	// data_table('example');
	var wids=$('.table').width();
	$('.head_icons').css(
	{
		width:wids+'px'
	});
	$('.head_fix').css({display:'none'});
	$(document).scroll(function()
	{
		// $('.head_fix').css({display:'none'});
	});
});
</script>
</body>
</html>