<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
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
	$QTDate       = explode('/',$_REQUEST['ValidtoDate']);
	$QFDate	= explode('/',$_REQUEST['ValidfromDate']);
	$QTDate=$QTDate[2].$QTDate[0].$QTDate[1];
	$QFDate=$QFDate[2].$QFDate[0].$QFDate[1];
	$item       	= $_REQUEST['item'];
	$material   	= $_REQUEST['material'];
	$description 	= $_REQUEST['description'];
	$Order_quantity = $_REQUEST['Order_quantity'];
	$su          	= $_REQUEST['su'];
	$date_one    	= explode('/',$Delivery);
	$date        	= $date_one[2].$date_one[0].$date_one[1];
	if($date == ""){$date="00000000";}
	
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }
	//................................................................................
	
	$QUOTATION_HEADER_IN = array(
		"DOC_TYPE"=>$DOC_TYPE,
		"SALES_ORG"=>$sales_org,
		"DISTR_CHAN"=>$DISTR_CHAN,
		"DIVISION"=>$DIVISION,
		"REQ_DATE_H"=>$date,
		"QT_VALID_F"=>$QFDate,
		"QT_VALID_T"=>$QTDate	
	);
	
	//............................................................
	
	$QUOTATION_HEADER_INX = array(
		"DOC_TYPE"=>"X",
		"SALES_ORG"=>"X",
		"DISTR_CHAN"=>"X",
		"DIVISION"=>"X",
		"REQ_DATE_H"=>"X",
		"QT_VALID_F"=>"X",
		"QT_VALID_T"=>"X"
	);	
	//...............................................................................

	//Import tables
	$importTableQuotationItemsIN = array();
	$importTableQuotationItemsINX = array();
	$importTableQuotationPartners = array();
	$importTableQuotationSchIN = array();
	$importTableQuotationSchINX = array();	
	
	$QUOTATION_PARTNERS = array("PARTN_ROLE"=>"AG","PARTN_NUMB"=>$partn);
	array_push($importTableQuotationPartners, $QUOTATION_PARTNERS);
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
			"SHORT_TEXT"=>$description[$keys],
		);	
		array_push($importTableQuotationItemsIN,$QUOTATION_ITEMS_IN);
		//.................................................................................

		$QUOTATION_ITEMS_INX=array("ITM_NUMBER"=>$vals,"MATERIAL"=>"X","TARGET_QTY"=>"X","TARGET_QU"=>"X","SHORT_TEXT"=>"X");
		array_push($importTableQuotationItemsINX, $QUOTATION_ITEMS_INX);
		//.................................................................................

	$QUOTATION_SCHEDULES_IN=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>floatval($Order_quantity[$keys]));
		array_push($importTableQuotationSchIN, $QUOTATION_SCHEDULES_IN);
		//.................................................................................

		$QUOTATION_SCHEDULES_INX=array("ITM_NUMBER"=>$vals,"REQ_QTY"=>"X");
		array_push($importTableQuotationSchINX, $QUOTATION_SCHEDULES_INX);
		//................................................................................. 
	}		
	$options = ['rtrim'=>true];
	try{
	$res = $fce->invoke(["QUOTATION_HEADER_IN"=>$QUOTATION_HEADER_IN,
						"QUOTATION_HEADER_INX"=>$QUOTATION_HEADER_INX,
						"QUOTATION_ITEMS_IN"=>$importTableQuotationItemsIN,
						"QUOTATION_ITEMS_INX"=>$importTableQuotationItemsINX,
						"QUOTATION_PARTNERS"=>$importTableQuotationPartners,
						"QUOTATION_SCHEDULES_IN"=>$importTableQuotationSchIN,
						"QUOTATION_SCHEDULES_INX"=>$importTableQuotationSchINX],$options);
	}catch(SapException $ex){
		echo $ex->getMessage();
		exit();
	}

	// $response = new ResponseExport;
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
				echo str_replace("The sales document is not yet complete: Edit data","Please Edit the sales quotation in SAP GUI and complete the incompletions.",$msg['MESSAGE'])."<br>";
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
			
			echo str_replace("The sales document is not yet complete: Edit data","Please Edit the sales quotation in SAP GUI and complete the incompletions.",$msg['MESSAGE'])."<br>";
			
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
	try{
		$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
		$fce->invoke();
	}catch(SapException $ex){
		echo "Exception raised: ".$ex->getMessage();
	}
?>