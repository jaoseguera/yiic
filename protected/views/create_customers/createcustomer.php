<?php
    //GEZG 06/20/2018 - Alias for SAPRFC library
    use SAPNWRFC\Connection as SapConnection;
    use SAPNWRFC\Exception as SapException;
    global $rfc,$fce;
    //GEZG 06/21/2018
    //Chainging SAPRFC methods
    
    $options = ['rtrim',true];
    $res = $fce->invoke(['I_SALES_ORG'=>strtoupper($_REQUEST['I_SALES_ORG']),
                        'I_DIST_CHAN'=>strtoupper($_REQUEST['I_DIST_CHAN']),
                        'I_DIVISION'=>strtoupper($_REQUEST['I_DIVISION']),
                        'I_NAME'=>strtoupper($_REQUEST['I_NAME']),
                        'I_HOUSE_NO'=>strtoupper($_REQUEST['I_HOUSE_NO']),
                        'I_STREET'=>strtoupper($_REQUEST['I_STREET']),
                        'I_CITY'=>strtoupper($_REQUEST['I_CITY']),
                        'I_STATE'=>strtoupper($_REQUEST['I_STATE']),
                        'I_ZIP'=>strtoupper($_REQUEST['I_ZIP']),
                        'I_COUNTRY'=>strtoupper($_REQUEST['I_COUNTRY']),
                        'I_SPRAS'=>strtoupper($_REQUEST['I_SPRAS'])],$options);

    $SalesOrder = $res['ET_MESSAGES'];
    echo $SalesOrder[0]['TYPE']."@".$SalesOrder[0]['MESSAGE']."  Sucessfully";

    try{
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
   }catch(SapException $ex){
        "Exception raised: ".$ex->getMessage();
   }

    
?>