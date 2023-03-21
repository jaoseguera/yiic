<?php
global $rfc;
$doc_r=strtoupper($_REQUEST["DOC_TYPE"]);
if(strtoupper($_REQUEST["DOC_TYPE"])=='OR')
{
	$doc_r='TA';
}
	$sales_org      = strtoupper($_REQUEST['SALES_ORG']);
	$partn          = strtoupper($_REQUEST['PARTN_NUMB']);
	$partn1          = strtoupper($_REQUEST['PARTN_NUMB1']);
	$partn2          = strtoupper($_REQUEST['PARTN_NUMB2']);
    $headCurrency    = strtoupper($_REQUEST['HEAD_CURRENCY']);
    $cusLenth       = count($partn);
	$cusLenth1       = count($partn1);	
	$cusLenth2       = count($partn2);
	$DISTR_CHAN     = strtoupper($_REQUEST['DISTR_CHAN']);
    $DOC_TYPE       = $doc_r;
	$percentageDiscount = trim($_REQUEST['PERCENTAGE_DISCOUNT']);
	$amountDiscount = trim($_REQUEST['AMOUNT_DISCOUNT']);
	//$DIVISION       = strtoupper($_REQUEST['DIVISION']);
	$QTDate       = explode('/',$_REQUEST['ValidtoDate']);
	$QFDate	= explode('/',$_REQUEST['ValidfromDate']);
	$QTDate=$QTDate[2].$QTDate[0].$QTDate[1];
	$QFDate=$QFDate[2].$QFDate[0].$QFDate[1];
	$item       	= $_REQUEST['item'];
	$material   	= $_REQUEST['material'];
	$description 	= $_REQUEST['description'];
	$Order_quantity = $_REQUEST['Order_quantity'];
	$su          	= $_REQUEST['su'];
    $COND_UNIT   = $_REQUEST['COND_UNIT'];
	$s_price  		= $_REQUEST['Net_Price'];
	$per_unit		= $_REQUEST['Per_Unit'];
    $currency       = $_REQUEST['Currency'];
    $plant       	= $_REQUEST['Plant'];
	$date_one    	= explode('/',$Delivery);
	$date        	= $date_one[2].$date_one[0].$date_one[1];
    if($date == ""){
		$date = "00000000";
	}
    $pmntterms    	=$_REQUEST['PMNTTERMS'];
    $PURCH_NO_C    	=$_REQUEST['PURCH_NO_C'];
	$h_text    		=$_REQUEST['HEADER_TEXT'];
	$i_text    		=$_REQUEST['ITEM_TEXT'];


	//GEZG 09/12/2018
	//Adding sales text field
	$s_text 		=$_REQUEST['SALES_TEXT'];
	//Adding free charge flag
	$free_charge 	=$_REQUEST['FREE_CHARGE']; 
	//Adding is component flag
	$is_component 	= $_REQUEST['IS_COMPONENT']; 
	$item_categ 	= $_REQUEST['ITEM_CATEG']; 
	$high_level_item = $_REQUEST['HIGH_LEVEL_ITEM']; 


	$lang           =$_REQUEST['LANGUAGE'];
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }
	if($cusLenth1 < 10) { $partn1 = str_pad((int) $partn1, 10, 0, STR_PAD_LEFT); } else { $partn1 = substr($partn1, -10); }
	if($cusLenth2 < 10) { $partn2 = str_pad((int) $partn2, 10, 0, STR_PAD_LEFT); } else { $partn2 = substr($partn2, -10); }
	//................................................................................
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];	
	$importTableITEMSIN = array();
	$importTableITEMSINX = array();
	$imporTablePARTNERS = array();
	$importTableTEXT = array();	
	$importTableSCHEDULESIN = array();
	$importTableSCHEDULESINX = array();
	$importTableCONDITIONSIN = array();
	$importTableCONDITIONSINX = array();

	$QUOTATION_HEADER_IN = array(
		"DOC_TYPE"=>$DOC_TYPE,
		"SALES_ORG"=>$sales_org,
        "PURCH_NO_C"=>$PURCH_NO_C,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"REQ_DATE_H"=>$date,
		"QT_VALID_F"=>$QFDate,
		"QT_VALID_T"=>$QTDate,
        "PMNTTRMS"=>$pmntterms,
        "PO_METHOD"=>"THUI",
        "CURRENCY"=>$headCurrency
	);
	
	//............................................................
	
	$QUOTATION_HEADER_INX = array(
		"DOC_TYPE"=>"X",
		"SALES_ORG"=>"X",
        "PURCH_NO_C"=>"X",
		"DISTR_CHAN"=>"X",
		"REQ_DATE_H"=>"X",
		"QT_VALID_F"=>"X",
		"QT_VALID_T"=>"X",
        "PMNTTRMS"=>"X",
        "PO_METHOD"=>"X",
        "CURRENCY"=>"X"
	);
	
	$LOGIC_SWITCH=array("ATP_WRKMOD"=>"X","SCHEDULING"=>"X","NOSTRUCTURE"=>"X","COND_HANDL"=>"X","ADDR_CHECK"=>"X");	
	//...............................................................................
	
	
	$QUOTATION_PARTNERS = array("PARTN_ROLE"=>"AG","PARTN_NUMB"=>$partn);	
	$QUOTATION_PARTNERS1 = array("PARTN_ROLE"=>"WE","PARTN_NUMB"=>$partn1);	
	$QUOTATION_PARTNERS2 = array("PARTN_ROLE"=>"ZS","PARTN_NUMB"=>$partn2);

	array_push($imporTablePARTNERS,$QUOTATION_PARTNERS);
	array_push($imporTablePARTNERS,$QUOTATION_PARTNERS1);
	array_push($imporTablePARTNERS,$QUOTATION_PARTNERS2);
	
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
		
	foreach($item as $keys=>$vals)
	{
		if(is_numeric($material[$keys]))
		{
			$materialLenth  = count($material[$keys]);
			if($materialLenth < 18) { $material[$keys] = str_pad($material[$keys], 18, 0, STR_PAD_LEFT); } else { $material[$keys] = substr($material[$keys], -18); }
		}
		
		$QUOTATION_ITEMS_IN = array(
			"ITM_NUMBER"=>$vals,
			"MATERIAL"=>strtoupper($material[$keys]),
			"TARGET_QTY"=>floatval($Order_quantity[$keys]),
            "TARGET_QU"=>strtoupper($su[$keys]),
            "SALES_UNIT"=>strtoupper($su[$keys]),
            "SHORT_TEXT"=>$description[$keys],
            "PLANT"=>$plant[$keys]
		);
		//GEZG 09/14/2018
		//IF free charge flag is on, set ITEM CATEG to AGNN
		if($item_categ[$keys] != ""){
			if($free_charge[$keys] == "1"){
				$QUOTATION_ITEMS_IN["ITEM_CATEG"] = "AGNN";
			}
			else{
				$QUOTATION_ITEMS_IN["ITEM_CATEG"] = $item_categ[$keys];	
				if($high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0){				
					$QUOTATION_ITEMS_IN["HG_LV_ITEM"] = $high_level_item[$keys];
				}				
			}		
		}else if($item_categ[$keys] == "" && $high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0 ){
			$QUOTATION_ITEMS_IN["ITEM_CATEG"] = "ZTAE";
		}	
		array_push($importTableITEMSIN,$QUOTATION_ITEMS_IN);
		//.................................................................................		

		if($is_component[$keys] != "1"){
			$QUOTATION_CONDITIONS_IN = array(
				"ITM_NUMBER"=>$vals,			
				"COND_COUNT"=>"00",
				"COND_TYPE" => "PR00",
				"COND_VALUE"=>floatval($s_price[$keys]),
				"COND_P_UNT"=>floatval($per_unit[$keys]),
				//"COND_UNIT"=>strtoupper($su[$keys]),
                "COND_UNIT"=>strtoupper($COND_UNIT[$keys]),
				"CURRENCY"=>$currency[$keys]
			);
			//$QUOTATION_CONDITIONS_IN["COND_TYPE"] = "PR00";
			array_push($importTableCONDITIONSIN,$QUOTATION_CONDITIONS_IN);
		}
		
		if($percentageDiscount != ""){
			$QUOTATION_CONDITIONS_IN = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZRA0",
				"COND_VALUE"=>floatval($percentageDiscount)			
            );	
            array_push($importTableCONDITIONSIN,$QUOTATION_CONDITIONS_IN);			
		}

		if($amountDiscount != ""){
			$QUOTATION_CONDITIONS_IN = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZHB2",
				"COND_VALUE"=>floatval($amountDiscount)			
            );	
            array_push($importTableCONDITIONSIN,$QUOTATION_CONDITIONS_IN);			
		}
		
        //.................................................................................
		
		$QUOTATION_ITEMS_INX=array("ITM_NUMBER"=>$vals,"MATERIAL"=>"X","TARGET_QTY"=>"X","PO_ITM_NO"=>"X","TARGET_QU"=>"X","SALES_UNIT"=>"X","SHORT_TEXT"=>"X","PLANT"=>"X");
		//GEZG 09/14/2018
		//IF free charge flag is on, activate ITEM CATEG FLAG
		if($free_charge[$keys] == "1" || $item_categ[$keys] != ""){
			$QUOTATION_ITEMS_INX["ITEM_CATEG"]="X";
			if($high_level_item[$keys] != "" && (int)$high_level_item[$keys] != 0){				
				$QUOTATION_ITEMS_INX["HG_LV_ITEM"] = "X";
			}
		}
		array_push($importTableITEMSINX,$QUOTATION_ITEMS_INX);
		//.................................................................................

		$QUOTATION_SCHEDULES_IN=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>floatval($Order_quantity[$keys]));
		array_push($importTableSCHEDULESIN,$QUOTATION_SCHEDULES_IN);
		//.................................................................................

		$QUOTATION_SCHEDULES_INX=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>"X");
		array_push($importTableSCHEDULESINX, $QUOTATION_SCHEDULES_INX);
		//.................................................................................	
				
		if($is_component[$keys] != "1"){
			$QUOTATION_CONDITIONS_INX = array(
				"ITM_NUMBER"=>$vals,				
				"COND_COUNT"=>"00",
				"COND_TYPE" => "PR00",
				"COND_VALUE"=>"X",
				"COND_P_UNT"=>"X",				
                "COND_UNIT"=>"X",
				"CURRENCY"=>"X"
			);
		
			//$QUOTATION_CONDITIONS_INX["COND_TYPE"] = "PR00";
			array_push($importTableCONDITIONSINX,$QUOTATION_CONDITIONS_INX);		
		}
        
        if($percentageDiscount != ""){
			$CONDITIONS_INX = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZRA0",
				"COND_VALUE"=>"X"		
			);
			array_push($importTableCONDITIONSINX,$CONDITIONS_INX);		
		}
		
		if($amountDiscount != ""){
			$CONDITIONS_INX = array(
				"ITM_NUMBER"=>"000000",
				"COND_TYPE"=>"ZHB2",
				"COND_VALUE"=>"X"		
			);
			array_push($importTableCONDITIONSINX,$CONDITIONS_INX);		
		}
		
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

	//GEZG 09/12/2018
	//Pushing sales text into import table
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
	


	}

	$res = $fce->invoke(["QUOTATION_HEADER_IN"=>$QUOTATION_HEADER_IN,
						"QUOTATION_HEADER_INX"=>$QUOTATION_HEADER_INX,
						"LOGIC_SWITCH"=>$LOGIC_SWITCH,
						"QUOTATION_PARTNERS"=>$imporTablePARTNERS,
						"QUOTATION_TEXT"=>$importTableTEXT,
						"QUOTATION_ITEMS_IN"=>$importTableITEMSIN,
						"QUOTATION_ITEMS_INX"=>$importTableITEMSINX,
						"QUOTATION_SCHEDULES_IN"=>$importTableSCHEDULESIN,
						"QUOTATION_SCHEDULES_INX"=>$importTableSCHEDULESINX,
						"QUOTATION_CONDITIONS_IN"=>$importTableCONDITIONSIN,
						"QUOTATION_CONDITIONS_INX"=>$importTableCONDITIONSINX],$options);
	$response= $res['SALESDOCUMENT'];
	// var_dump($response);
	if($response!=NULL)
	{
		echo $response." "._CREATEDSUCCESS;
		$res_table=new ResponseTable();
		$SalesOrder=$res_table-> getTable('RETURN');
		// var_dump($SalesOrder);
		foreach($SalesOrder as $msg)
		{
			
			if($msg['TYPE']=='W')
			{
				echo str_replace(_SALESDOCNOTCOMPLETE,_PLEASEEDITSALESQUOTATION,$msg['MESSAGE'])."<br>";
			}
			
		}
		echo "@S";
		
		
		
	}
	else
	{
		$SalesOrder=$res['RETURN'];
		// var_dump($SalesOrder);
		foreach($SalesOrder as $msg)
		{
			echo str_replace(_SALESDOCNOTCOMPLETE,_PLEASEEDITSALESQUOTATION,$msg['MESSAGE'])."<br>";
			
			if($msg['TYPE']=='S')
			{
				$type = "S";
			}
			else
			{
				$type = $msg['TYPE'];
			}
		}
		echo "@".$type;
	}
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
	$fce->invoke();
?>