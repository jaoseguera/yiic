<?php

	global $rfc,$fce;
	$i_vbeln        = strtoupper($_REQUEST['I_VBELN']);	
	$sales_org      = strtoupper($_REQUEST['SALES_ORG']);	
	$partn          = strtoupper($_REQUEST['PARTN_NUMB']);
	$cusLenth       = count($partn);	
	$partn_old      = strtoupper($_REQUEST['PARTN_NUMB_OLD']);
	$cusLenthOld    = count($partn_old);	
	$DISTR_CHAN     = strtoupper($_REQUEST['DISTR_CHAN']);
	$DOC_TYPE       = strtoupper($_REQUEST["DOC_TYPE"]);
	$DIVISION       = strtoupper($_REQUEST['DIVISION']);
	$Delivery       = strtoupper($_REQUEST['Delivery']);
	$PURCH_NO_C 	= strtoupper($_REQUEST['PURCH_NO_C']);
	
	$item       	= $_REQUEST['item'];
	$material   	= $_REQUEST['material'];
	$description 	= $_REQUEST['description'];
	$Order_quantity = $_REQUEST['Order_quantity'];
	$Price 			= $_REQUEST['Price'];
	$Currency		= $_REQUEST['Currency'];
	$su          	= $_REQUEST['su'];
	//echo urldecode($_REQUEST['flag']);
	$flag=explode(',',urldecode($_REQUEST['flag']));
	if(trim($_REQUEST['flag_d'])!='')
	{
	$flag_d=explode(',',$_REQUEST['flag_d']);
	}
	
	if(isset($_COOKIE['deldata']) && $_COOKIE['deldata']!='')
	{
	$arr = explode("&", substr($_COOKIE['deldata'], 0, -1));
	
	$rows_arr = ["ITM_NUMBER", "MATERIAL", "REQ_QTY", "TARGET_QU","SHORT_TEXT"];
	
	foreach($arr as $ak => $av)
	{
		$ctrl_id = strstr($av, "=", true);
		$ctrl_val = substr(strstr($av, "=", false), 1);
		if(in_array($ctrl_id, $rows_arr))
		{
			$ctrl[] = $ctrl_id;
			$arr_val[$ctrl_id][] = $ctrl_val;
		}
	}
	
	}
	$date_one    	= explode('/',$Delivery);
	$date        	= $date_one[2].$date_one[0].$date_one[1];
	
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }
	if($cusLenthOld < 10) { $partn_old = str_pad((int) $partn_old, 10, 0, STR_PAD_LEFT); } else { $partn_old = substr($partn_old, -10); }
	//................................................................................
	
	
	//print_r($ORDER_HEADER_IN);
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];	
	$importTableITEMIN = array();
	$importTableITEMINX = array();
	$importTableCONDITIONIN = array();
	$importTableCONDITIONINX = array();
	$importTablePARTNERCHANGES = array();
	$importTableSCHEDULELINES = array();
	$importTableSCHEDULELINESX = array();
	//............................................................
	
	
	$ORDER_HEADER_IN = array(
		
		"SALES_ORG"=>$sales_org,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"DIVISION"=>$DIVISION,
		"REQ_DATE_H"=>$date
	);	
	
	$ORDER_HEADER_INX = array(
		"UPDATEFLAG"=>"U",
		"SALES_ORG"=>"X",
		"DISTR_CHAN"=>"X",
		"DIVISION"=>"X",
		"REQ_DATE_H"=>"X"
	);
	
	//...............................................................................

	
	$ORDER_PARTNERS = array("DOCUMENT"=>$i_vbeln,"ITM_NUMBER"=>"000000","UPDATEFLAG"=>"U","PARTN_ROLE"=>"AG","P_NUMB_OLD"=>$partn_old,"P_NUMB_NEW"=>$partn);
	array_push($importTablePARTNERCHANGES,$ORDER_PARTNERS);	
	$i=1;
	$j=0;
	//..................................................................................................................
	
	//.................................................................................................................
	//print_r($flag);
	if(isset($_COOKIE['deldata']) && $_COOKIE['deldata']!='')
	{
	foreach($arr_val['ITM_NUMBER'] as $avk => $avv) { 
		$itm_num	= $avv;
		$mater	= $arr_val['MATERIAL'][$avk];
		$dmeter	= $arr_val['SHORT_TEXT'][$avk];
		$order_q	= $arr_val['REQ_QTY'][$avk];
		$sus			= $arr_val['TARGET_QU'][$avk];
		if(in_array($avv,$item))
		{
		$u_item[]=$avv;
		}else
		{
		if(is_numeric($mater))
		{
		$materLenth  = count($mater);
		if($materLenth < 18) { $mater = str_pad($mater, 18, 0, STR_PAD_LEFT); } else { $mater = substr($mater, -18); }									
		}
		$ORDER_ITEMS_IN = array(
			"ITM_NUMBER"=>$itm_num,
			"MATERIAL"=>strtoupper($mater),
			"TARGET_QTY"=>floatval($order_q),
			"TARGET_QU"=>strtoupper($sus),
			"SHORT_TEXT"=>$dmater,
		);
		//print_r($ORDER_ITEMS_IN);
		array_push($importTableITEMIN,$ORDER_ITEMS_IN);
		//.............................................................$fg[1],....................

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$itm_num,"UPDATEFLAG"=>'D',"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X");
		array_push($importTableITEMINX,$ORDER_ITEMS_INX);
		}									
	}
		
	}
	foreach($item as $keys=>$vals)
	{
		if(is_numeric($material[$keys]))
		{
			$materialLenth  = count($material[$keys]);
			if($materialLenth < 18) { $material[$keys] = str_pad($material[$keys], 18, 0, STR_PAD_LEFT); } else { $material[$keys] = substr($material[$keys], -18); }
		}
		
		$fg=explode('G1S',$flag[$j]);
		$ORDER_ITEMS_IN = array(
			"ITM_NUMBER"=>$vals,
			"MATERIAL"=>strtoupper($material[$keys]),
			"TARGET_QTY"=>floatval($Order_quantity[$keys]),
			"TARGET_QU"=>strtoupper($su[$keys]),
			"SHORT_TEXT"=>$description[$keys],
		);
		//print_r($ORDER_ITEMS_IN);
		array_push($importTableITEMIN, $ORDER_ITEMS_IN);
		//.................................................................................
		if(in_array($vals,$u_item))
			$fg[1]='U';

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$vals,"UPDATEFLAG"=>$fg[1],"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X");
		array_push($importTableITEMINX, $ORDER_ITEMS_INX);
		//.................................................................................
		
		$CONDITIONS_IN=array("ITM_NUMBER"=>$vals,"COND_TYPE"=>"PR00","COND_VALUE"=>floatval($Price[$keys]),"CURRENCY"=>$Currency[$keys]);
		array_push($importTableCONDITIONIN, $CONDITIONS_IN);
		//.................................................................................
		
		$CONDITIONS_INX=array("ITM_NUMBER"=>$vals,"UPDATEFLAG"=>"U","COND_TYPE"=>"PR00","COND_VALUE"=>"X","CURRENCY"=>"X");
		array_push($importTableCONDITIONINX, $CONDITIONS_INX);
		//.................................................................................
		
		$SCHEDULES_LINES=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>$i,"REQ_QTY"=>$Order_quantity[$keys]);
		array_push($importTableSCHEDULELINES, $SCHEDULES_LINES);
		//print_r($SCHEDULES_LINES);
		//.................................................................................

		$SCHEDULES_LINESX=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>$i,"UPDATEFLAG"=>$fg[1],"REQ_QTY"=>"X");
		array_push($importTableSCHEDULELINESX, $SCHEDULES_LINESX);
		//.................................................................................
		// $i++;
		$j++;
	}
	$res = $fce->invoke(["SALESDOCUMENT"=>$i_vbeln,
						"ORDER_HEADER_IN"=>$ORDER_HEADER_IN,
						"ORDER_HEADER_INX"=>$ORDER_HEADER_INX,
						"ORDER_ITEM_IN"=>$importTableITEMIN,
						"ORDER_ITEM_INX"=>$importTableITEMINX,
						"CONDITIONS_IN"=>$importTableCONDITIONIN,
						"CONDITIONS_INX"=>$importTableCONDITIONINX,
						"PARTNERCHANGES"=>$importTablePARTNERCHANGES/*,	
						"SCHEDULES_LINES"=>$importTableSCHEDULELINES,
						"SCHEDULES_LINESX"=>$importTableSCHEDULELINESX*/],$options);	


	$SalesOrder = $res['RETURN'];	
	//print_r($SalesOrder);
	$mm = NULL;
	$type = array();
	foreach($SalesOrder as $msg)
	{
		$type[] = $msg['TYPE'];
		$mm.= $msg['MESSAGE']."<br>";
	}
	
	if(in_array("E", $type) || in_array("A", $type))
		$msgtype = "E";
	else
		$msgtype = "S";
	
	echo $mm."@".$msgtype;
	
?>