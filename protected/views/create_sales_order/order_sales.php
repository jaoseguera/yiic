<?php
global $rfc,$fce;
$doc_r=strtoupper($_REQUEST["DOC_TYPE"]);
if(strtoupper($_REQUEST["DOC_TYPE"])=='OR')
{
	$doc_r='TA';
}
	$sales_org      = strtoupper($_REQUEST['SALES_ORG']);
	$partn          = strtoupper($_REQUEST['PARTN_NUMB']);
	$cusLenth       = count($partn);	
	$DISTR_CHAN     = strtoupper($_REQUEST['DISTR_CHAN']);
	$DOC_TYPE       = $doc_r;
	$DIVISION       = strtoupper($_REQUEST['DIVISION']);
	$Delivery       = strtoupper($_REQUEST['Delivery']);
	$PURCH_NO_C 	= strtoupper($_REQUEST['PURCH_NO_C']);
	$item       	= $_REQUEST['item'];
	$material   	= $_REQUEST['material'];
	$description 	= $_REQUEST['description'];
	$Order_quantity = $_REQUEST['Order_quantity'];
	$su          	= $_REQUEST['su'];
	$date_one    	= explode('/',$Delivery);
	$date        	= $date_one[2].$date_one[0].$date_one[1];
	
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }
	//................................................................................
	
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];	
	$importTableITEMSIN = array();
	$importTableITEMSINX = array();
	$importTableORDERPARTNERS = array();
	$importTableSCHEDULESIN = array();
	$importTableSCHEDULESINX = array();


	$ORDER_HEADER_IN = array(
		"DOC_TYPE"=>$DOC_TYPE,
		"SALES_ORG"=>$sales_org,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"DIVISION"=>$DIVISION,
		"REQ_DATE_H"=>$date,
		"PURCH_NO_C"=>$PURCH_NO_C
	);
		

	//............................................................
	
	$ORDER_HEADER_INX = array(
		"DOC_TYPE"=>"X",
		"SALES_ORG"=>"X",
		"DISTR_CHAN"=>"X",
		"DIVISION"=>"X",
		"REQ_DATE_H"=>"X",
		"PURCH_NO_C"=>"X"
	);

	//...............................................................................
	
	$ORDER_PARTNERS = array("PARTN_ROLE"=>"AG","PARTN_NUMB"=>$partn);
	array_push($importTableORDERPARTNERS, $ORDER_PARTNERS);

	foreach($item as $keys=>$vals)
	{
		if(is_numeric($material[$keys]))
		{
			$materialLenth  = count($material[$keys]);
			if($materialLenth < 18) { $material[$keys] = str_pad($material[$keys], 18, 0, STR_PAD_LEFT); } else { $material[$keys] = substr($material[$keys], -18); }
		}
		
		$ORDER_ITEMS_IN = array(
			"ITM_NUMBER"=>$vals,
			"MATERIAL"=>strtoupper($material[$keys]),
			"TARGET_QTY"=>floatval($Order_quantity[$keys]),
			"TARGET_QU"=>strtoupper($su[$keys]),
			"SHORT_TEXT"=>$description[$keys],
		);
		array_push($importTableITEMSIN, $ORDER_ITEMS_IN);		
		//.................................................................................

		$ORDER_ITEMS_INX=array("ITM_NUMBER"=>$vals,"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X","SHORT_TEXT"=>"X");
		array_push($importTableITEMSINX,$ORDER_ITEMS_INX);
		//.................................................................................

		$ORDER_SCHEDULES_IN=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>floatval($Order_quantity[$keys]));
		array_push($importTableSCHEDULESIN,$ORDER_SCHEDULES_IN);
		//.................................................................................

		$ORDER_SCHEDULES_INX=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>"X");
		array_push($importTableSCHEDULESINX, $ORDER_SCHEDULES_INX);
		//.................................................................................
	}	
	$res = $fce->invoke(["ORDER_HEADER_IN"=>$ORDER_HEADER_IN,
						"ORDER_HEADER_INX"=>$ORDER_HEADER_INX,
						"ORDER_ITEMS_IN"=>$importTableITEMSIN,
						"ORDER_ITEMS_INX"=>$importTableITEMSINX,
						"ORDER_SCHEDULES_IN"=>$importTableSCHEDULESIN,
						"ORDER_SCHEDULES_INX"=>$importTableSCHEDULESINX,
						"ORDER_PARTNERS"=>$importTableORDERPARTNERS],$options);
	$response= $res['SALESDOCUMENT'];
	// var_dump($response);
	if($response!=NULL)
	{
		echo $response." Created Successfully<br>";		
		$SalesOrder=$res['RETURN'];
		// var_dump($SalesOrder);
		foreach($SalesOrder as $msg)
		{
			
			if($msg['TYPE']=='W')
			{
				echo str_replace("The sales document is not yet complete: Edit data","Please Edit the sales order in SAP GUI and complete the incompletions.",$msg['MESSAGE'])."<br>";
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
			
			echo str_replace("The sales document is not yet complete: Edit data","Please Edit the sales order in SAP GUI and complete the incompletions.",$msg['MESSAGE'])."<br>";
			
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