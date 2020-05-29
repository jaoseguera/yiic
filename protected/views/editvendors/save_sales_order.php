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
	$Price = $_REQUEST['Price'];
	$su          	= $_REQUEST['su'];
	//echo urldecode($_REQUEST['flag']);
	$flag=explode(',',urldecode($_REQUEST['flag']));
	if(trim($_REQUEST['flag_d'])!='')
	{
	$flag_d=explode(',',$_REQUEST['flag_d']);
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
	$importTableCONDTITIONIN = array();
	$importTableCONDTITIONINX = array();
	$importTablePARTNER = array();
	$importTablePARTNERCHANGES = array();
	$importTableSCHEDULELINES = array();
	$importTableSCHEDULELINESX = array();
	//............................................................
	
	
	$ORDER_HEADER_IN = array(		
		"SALES_ORG"=>$sales_org,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"DIVISION"=>$DIVISION,
		"REQ_DATE_H"=>$date,
		"PURCH_NO_C"=>$PURCH_NO_C
	);	
	$ORDER_HEADER_INX = array(
		"UPDATEFLAG"=>"U",
		"SALES_ORG"=>"X",
		"DISTR_CHAN"=>"X",
		"DIVISION"=>"X",
		"REQ_DATE_H"=>"X",
		"PURCH_NO_C"=>"X"
	);
	
	//...............................................................................

	$PARTNERS = array("PARTN_ROLE"=>"AG","PARTN_NUMB"=>$partn);
	array_push($importTablePARTNER, $PARTNERS);
	
	$ORDER_PARTNERS = array("DOCUMENT"=>$i_vbeln,"ITM_NUMBER"=>"000000","UPDATEFLAG"=>"U","PARTN_ROLE"=>"AG","P_NUMB_OLD"=>$partn_old,"P_NUMB_NEW"=>$partn);
	array_push($importTablePARTNERCHANGES, $ORDER_PARTNERS);
	
	$i=1;
	$j=0;
	//..................................................................................................................
	
	//.................................................................................................................
	//print_r($flag);
	foreach($item as $keys=>$vals)
	{
		$fg=explode('G1S',$flag[$j]);
		$ORDER_ITEMS_IN = array(
			"ITM_NUMBER"=>$vals,
			"MATERIAL"=>strtoupper($material[$keys]),
			"TARGET_QTY"=>$Order_quantity[$keys],
			"TARGET_QU"=>strtoupper($su[$keys]),
			"SHORT_TEXT"=>$description[$keys],
		);
		//print_r($ORDER_ITEMS_IN);
		array_push($importTableITEMIN,$ORDER_ITEMS_IN);
		//.................................................................................

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$vals,"UPDATEFLAG"=>$fg[1],"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X");
		array_pus($importTableITEMINX,$ORDER_ITEMS_INX);
		//.................................................................................
		
		$CONDITIONS_IN=array("ITM_NUMBER"=>$vals,"COND_TYPE"=>"PR00","COND_VALUE"=>$Price[$keys],"CURRENCY"=>"");
		array_push($importTableCONDTITIONIN, $CONDITIONS_IN);
		//.................................................................................
		
		$CONDITIONS_INX=array("ITM_NUMBER"=>$vals,"UPDATEFLAG"=>"U","COND_TYPE"=>"X","COND_VALUE"=>"X","CURRENCY"=>"X");
		array_push($importTableCONDTITIONINX, $CONDITIONS_INX);
		//.................................................................................
		
		$SCHEDULES_LINES=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>$i,"REQ_QTY"=>$Order_quantity[$keys]);
		array_push($importTableSCHEDULELINES,$SCHEDULES_LINES);
		//print_r($SCHEDULES_LINES);
		//.................................................................................

		$SCHEDULES_LINESX=array("ITM_NUMBER"=>$vals,"SCHED_LINE"=>$i,"UPDATEFLAG"=>$fg[1],"REQ_QTY"=>"X");
		array_push($importTableSCHEDULELINESX,$SCHEDULES_LINESX);
		//.................................................................................
		$i++;
		$j++;
	}

	$res = $fce->invoke(["SALESDOCUMENT"=>$i_vbeln,
						"QUOTATION_HEADER_IN"=>$ORDER_HEADER_IN,
						"QUOTATION_HEADER_INX"=>$ORDER_HEADER_INX,						
						"QUOTATION_ITEM_IN"=>$importTableITEMIN,
						"QUOTATION_ITEM_INX"=>$importTableITEMINX,
						"CONDITIONS_IN"=>$importTableCONDTITIONIN,
						"CONDITIONS_INX"=>$importTableCONDTITIONINX,
						"PARTNERS"=>$importTablePARTNER,
						"PARTNERCHANGES"=>$importTablePARTNERCHANGES,
						"SCHEDULES_LINES"=>$importTableSCHEDULELINES,
						"SCHEDULES_LINESX"=>$importTableSCHEDULELINESX],$options);

		
	$SalesOrder = $res['RETURN'];	
	//print_r($SalesOrder);
	$mm=NULL;
	foreach($SalesOrder as $msg)
	{
		
		$mm.= $msg['MESSAGE']."<br>";
			
		
	}
	echo $mm;
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
	$fce->invoke();
?>