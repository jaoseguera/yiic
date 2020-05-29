<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
if(isset($_REQUEST['NAME']))
{
    global $rfc,$fce;
    //GEZG 06/21/2018
    //Changing SAPRFC methods    
	$CUSTOMERNO = $_REQUEST['CUSTOMERNO'];
	$cusLenth = count($CUSTOMERNO);
	if($cusLenth < 10) { $CUSTOMERNO = str_pad((int) $CUSTOMERNO, 10, 0, STR_PAD_LEFT); } else { $CUSTOMERNO = substr($CUSTOMERNO, -10); }
	$I_CUSTOMER_CENTRAL = array("ADDR_NO"=>$CUSTOMERNO, "NAME"=>$_REQUEST['NAME'], "CITY"=>$_REQUEST['CITY'], "POSTL_COD1"=>$_REQUEST['POSTL_CODE'], "STREET"=>$_REQUEST['STREET'], "HOUSE_NO"=>$_REQUEST['HOUSENO'], "COUNTRY"=>$_REQUEST['COUNTRY'], "REGION"=>$_REQUEST['REGION']);
    $options = ['rtrim'=>true];
    $res = $fce->invoke(["I_CUSTOMER_CENTRAL"=>$I_CUSTOMER_CENTRAL],$options);    
    $SalesOrder = $res['ET_MESSAGES'];

    if($SalesOrder[0]['MESSAGE']==NULL)
    {
        echo "Customer change successfull";
	}
    else
    {
        echo $SalesOrder[0]['MESSAGE'];
    }
    try{
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
    }catch(SapException $ex){
        echo "Exception raised: ".$ex->getMessage();
        exit();
    }
    
    
}
?>