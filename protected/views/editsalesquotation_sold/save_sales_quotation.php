<?php

	global $rfc,$fce;
	$i_vbeln        = strtoupper($_REQUEST['I_VBELN']);	
	$sales_org      = strtoupper($_REQUEST['SALES_ORG']);	
	$partn          = strtoupper($_REQUEST['PARTN_NUMB']);
	$partn1          = strtoupper($_REQUEST['PARTN_NUMB1']);
	$partn2          = strtoupper($_REQUEST['PARTN_NUMB2']);
	$cusLenth       = count($partn);	
	$cusLenth1       = count($partn1);	
	$cusLenth2       = count($partn2);	
	$partn_old      = strtoupper($_REQUEST['PARTN_NUMB_OLD']);
	$cusLenthOld    = count($partn_old);	
	$DISTR_CHAN     = strtoupper($_REQUEST['DISTR_CHAN']);
	$DOC_TYPE       = strtoupper($_REQUEST["DOC_TYPE"]);
	$percentageDiscount = trim($_REQUEST['PERCENTAGE_DISCOUNT']);
	$amountDiscount = trim($_REQUEST['AMOUNT_DISCOUNT']);

	$DIVISION       = strtoupper($_REQUEST['DIVISION']);
	//$Delivery       = strtoupper($_REQUEST['Delivery']);
	$PURCH_NO_C 	= strtoupper($_REQUEST['QTDate']);
	$COND_UNIT      = $_REQUEST['unit_of_measure'];

	$item       	= $_REQUEST['item'];
	$material   	= $_REQUEST['material'];
	$description 	= $_REQUEST['description'];
	$Order_quantity = $_REQUEST['Order_quantity'];
	$Price 			= $_REQUEST['Price'];
	$Currency		= $_REQUEST['currency'];
	$headCurrency	= $_REQUEST['HEAD_CURRENCY'];
	$Plant			= $_REQUEST['Plant'];
	$su          	= $_REQUEST['su'];
	$per_unit		= $_REQUEST['per_unit'];	

	//echo urldecode($_REQUEST['flag']);
	$flag=explode(',',urldecode($_REQUEST['flag']));
	$h_text    		=$_REQUEST['HEADER_TEXT'];
	$i_text    		=$_REQUEST['ITEM_TEXT'];
	$s_text    		=$_REQUEST['SALES_TEXT'];
	//Adding free charge flag
	$free_charge 	=$_REQUEST['FREE_CHARGE']; 
	//Adding is component flag
	$is_component 	= $_REQUEST['component']; 
	$item_categ 	= $_REQUEST['category']; 
	$high_level_item = $_REQUEST['high_level'];

	$lang           =$_REQUEST['LANGUAGE'];
	if(trim($_REQUEST['flag_d'])!='')
	{
	$flag_d=explode(',',$_REQUEST['flag_d']);
	}
	if(isset($_COOKIE['deldata']) && $_COOKIE['deldata']!='')
	{
	$arr = explode("&", substr($_COOKIE['deldata'], 0, -1));
	
	$rows_arr = ["ITM_NUMBER", "MATERIAL", "REQ_QTY", "TARGET_QU","SALES_UNIT","SHORT_TEXT","ITEM_CATEG"];
	
	foreach($arr as $ak => $av)
	{
		$ctrl_id = strstr($av, "=", true);
		$ctrl_val = substr(strstr($av, "=", false), 1);
		if(in_array($ctrl_id, $rows_arr))
		{
			$ctrl = [];
			$ctrl[] = $ctrl_id;
			$arr_val[$ctrl_id] = [];
			$arr_val[$ctrl_id][] = $ctrl_val;
		}
	}
	
	}
	/*$Delivery='11/01/2016';
	
	$date_one    	= explode('/',$Delivery);
	$date        	= $date_one[2].$date_one[0].$date_one[1];*/
	
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }
	if($cusLenthOld < 10) { $partn_old = str_pad((int) $partn_old, 10, 0, STR_PAD_LEFT); } else { $partn_old = substr($partn_old, -10); }
	if($cusLenth1 < 10) { $partn1 = str_pad((int) $partn1, 10, 0, STR_PAD_LEFT); } else { $partn1 = substr($partn1, -10); }
	
	if($cusLenth2 < 10) { $partn2 = str_pad((int) $partn2, 10, 0, STR_PAD_LEFT); } else { $partn2 = substr($partn2, -10); }
	
	
	//................................................................................
	
	
	//print_r($ORDER_HEADER_IN);
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$importTableITEMIN = array();
	$importTableITEMINX = array();	
	$importTableCONDTITIONIN = array();
	$importTableCONDTITIONINX = array();
	$importTableTEXT = array();
	$importTableSCHEDULELINES = array();
	$importTableSCHEDULELINESX = array();
	//.......................................
	//............................................................
	
	
	$ORDER_HEADER_IN = array(
		
		"SALES_ORG"=>$sales_org,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"DIVISION"=>$DIVISION
	);
	$ORDER_HEADER_INX = array(
		"UPDATEFLAG"=>"U",
		"SALES_ORG"=>"X",
		"DISTR_CHAN"=>"X",
		"DIVISION"=>"X"
	);
	//...............................................................................
	

	
	$LOGIC_SWITCH=array("ATP_WRKMOD"=>"X","SCHEDULING"=>"X","NOSTRUCTURE"=>"X","COND_HANDL"=>"X","ADDR_CHECK"=>"X");
	$h_text_split=str_split($h_text,132);
	foreach($h_text_split as $k=>$v)
	{
		$QUOTATION_TEXT = array(
		"TEXT_ID"=>"ZN01",
		"LANGU"=>$lang,
		"TEXT_LINE"=>$v
	);
	array_push($importTableTEXT,$QUOTATION_TEXT);
	}

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
		$i_categ 	= $arr_val['ITEM_CATEG'][$avk];	
		$item_plant = $arr_val["PLANT"][$avk];	
		if(in_array($avv,$item))
		{
		$u_item = [];
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
			"TARGET_QTY"=>doubleval($order_q),
			"TARGET_QU"=>strtoupper($sus),
			"SALES_UNIT"=>strtoupper($sus),
			"SHORT_TEXT"=>$dmater,
			"PLANT"=>$item_plant
		);
		//GEZG 09/14/2018
		//IF free charge flag is on, set ITEM CATEG to AGNN
		if($i_categ != ""){
			$ORDER_ITEMS_IN["ITEM_CATEG"] = $i_categ;
		}
		array_push($importTableITEMIN, $ORDER_ITEMS_IN);
		//.............................................................$fg[1],....................

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$itm_num,"UPDATEFLAG"=>'D',"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X","SALES_UNIT"=>"X","SHORT_TEXT"=>"X","PLANT"=>"X");	
		if($i_categ != ""){
			$ORDER_ITEMS_INX["ITEM_CATEG"] = "X";
		}
		array_push($importTableITEMINX, $ORDER_ITEMS_INX);
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
			"TARGET_QTY"=>doubleval($Order_quantity[$keys]),
			"TARGET_QU"=>strtoupper($su[$keys]),
			"SALES_UNIT"=>strtoupper($su[$keys]),
			"SHORT_TEXT"=>$description[$keys],
			"HG_LV_ITEM"=>"",
			"ITEM_CATEG"=>"AGN",
			"PLANT"=>$Plant[$keys]
		);
		//GEZG 09/14/2018
		//IF free charge flag is on, set ITEM CATEG to AGNN		
		if($item_categ[$keys] != ""){
			if($free_charge[$keys] == "1"){
				$ORDER_ITEMS_IN["ITEM_CATEG"] = "AGNN";
			}
			else{
				$ORDER_ITEMS_IN["ITEM_CATEG"] = $item_categ[$keys];	
				if($high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0){				
					$ORDER_ITEMS_IN["HG_LV_ITEM"] = $high_level_item[$keys];
				}				
			}		
		}else if($item_categ[$keys] == "" && $high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0 ){
			$ORDER_ITEMS_IN["ITEM_CATEG"] = "ZTAE";
		}								
		array_push($importTableITEMIN, $ORDER_ITEMS_IN);
		//.............................................................$fg[1],....................
		if(in_array($vals,$u_item))
			$fg[1]='U';

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$vals,"UPDATEFLAG"=>$fg[1],"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X","SALES_UNIT"=>"X","HG_LV_ITEM"=>"X","SHORT_TEXT"=>"X","ITEM_CATEG"=>"X","PLANT"=>"X");
		//GEZG 09/14/2018
		//IF free charge flag is on, activate ITEM CATEG FLAG
		/*if($free_charge[$keys] == "1" || $item_categ[$keys] != ""){
			$ORDER_ITEMS_INX["ITEM_CATEG"]="X";
			if($high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0){				
				$ORDER_ITEMS_INX["HG_LV_ITEM"] = "X";
			}
		}*/
		array_push($importTableITEMINX, $ORDER_ITEMS_INX);	

		//.................................................................................
		
		if($is_component[$keys] != "1"){
			$CONDITIONS_IN=array("ITM_NUMBER"=>$vals,"COND_TYPE"=>"PR00","COND_VALUE"=>doubleval(str_replace(',','',$Price[$keys])),"COND_UNIT"=>strtoupper($COND_UNIT[$keys]),"COND_P_UNT"=>doubleval($per_unit[$keys]),"CURRENCY"=>strtoupper($Currency[$keys]),"COND_COUNT"=>"00");
			array_push($importTableCONDTITIONIN,$CONDITIONS_IN);
		}
		if($percentageDiscount != ""){
			$CONDITIONS_IN = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZRA0",
				"COND_VALUE"=>doubleval($percentageDiscount)		
			);	
			array_push($importTableCONDTITIONIN,$CONDITIONS_IN);	
		}
		if($amountDiscount != ""){
			$CONDITIONS_IN = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZHB2",
				"COND_VALUE"=>doubleval($amountDiscount),
				"CURRENCY"=>$headCurrency
			);	
			array_push($importTableCONDTITIONIN,$CONDITIONS_IN);	
		}

		//.................................................................................
		if($is_component[$keys] != "1"){
			$CONDITIONS_INX=array("ITM_NUMBER"=>$vals,"COND_TYPE"=>"PR00","COND_COUNT"=>"00","COND_VALUE"=>"X","CURRENCY"=>"X","COND_P_UNT"=>"X","COND_UNIT"=>"X");
			array_push($importTableCONDTITIONINX,$CONDITIONS_INX);
		}

		if($percentageDiscount != ""){
			$CONDITIONS_INX = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZRA0",
				"COND_VALUE"=>"X"		
			);
			array_push($importTableCONDTITIONINX,$CONDITIONS_INX);		
		}

		if($amountDiscount != ""){
			$CONDITIONS_INX = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZHB2",
				"COND_VALUE"=>"X",
				"CURRENCY"=>"X"
			);
			array_push($importTableCONDTITIONINX,$CONDITIONS_INX);		
		}

		//.................................................................................
		$SCHEDULES_LINES=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>strval($i),"REQ_QTY"=>doubleval($Order_quantity[$keys]));
		array_push($importTableSCHEDULELINES,$SCHEDULES_LINES);
		//print_r($SCHEDULES_LINES);
		//.................................................................................

		$SCHEDULES_LINESX=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>strval($i),"UPDATEFLAG"=>$fg[1],"REQ_QTY"=>"X");
		array_push($importTableSCHEDULELINESX,$SCHEDULES_LINESX);
		$i_text_split=str_split($i_text[$keys],132);
		foreach($i_text_split as $ik=>$iv)
		{
			if($iv != null && trim($iv) != "" ){
				$QUOTATION_TEXT = array(
					"TEXT_ID"=>"ZQ01",
					"ITM_NUMBER"=>$vals,
					"LANGU"=>$lang,
					"TEXT_LINE"=>$iv
				);
				array_push($importTableTEXT, $QUOTATION_TEXT);
			}			
		}
		$s_text_split=str_split($s_text[$keys],132);
		foreach($s_text_split as $ik=>$iv)
		{
			if($iv != null && trim($iv) != "" ){
				$QUOTATION_TEXT = array(
					"TEXT_ID"=>"0001",
					"ITM_NUMBER"=>$vals,
					"LANGU"=>$lang,
					"TEXT_LINE"=>$iv
				);
				array_push($importTableTEXT, $QUOTATION_TEXT);
			}
		}		
		$j++;
		//$i++;
	}	

	$res = $fce->invoke(["SALESDOCUMENT"=>$i_vbeln,
						"QUOTATION_HEADER_IN"=>$ORDER_HEADER_IN,
						"QUOTATION_HEADER_INX"=>$ORDER_HEADER_INX,						
						"QUOTATION_ITEM_IN"=>$importTableITEMIN,
						"QUOTATION_ITEM_INX"=>$importTableITEMINX,
						"CONDITIONS_IN"=>$importTableCONDTITIONIN,
						"CONDITIONS_INX"=>$importTableCONDTITIONINX,
						"QUOTATION_TEXT"=>$importTableTEXT,						
						"SCHEDULE_LINESX"=>$importTableSCHEDULELINESX,
						"SCHEDULE_LINES"=>$importTableSCHEDULELINES,
						"LOGIC_SWITCH"=>$LOGIC_SWITCH],$options);

	$SalesOrder = $res['RETURN'];
	
	//print_r($SalesOrder);
	$mm = NULL;
	$type = "";
	foreach($SalesOrder as $msg)
	{
		$type = [];
		$type[] = $msg['TYPE'];
		$mm.= utf8_decode($msg['MESSAGE'])."<br>";
	}
	
	if(in_array("E", $type) || in_array("A", $type))
		$msgtype = "E";
	else
		$msgtype = "S";
	
	echo $mm."@".$msgtype;
	
	/*$bapicall = new CommitBapi();	
	$bapicall->bapiCommit('BAPI_TRANSACTION_COMMIT');
	$imp = new BapiImport();
	$imp->setImport("WAIT","");*/
?>