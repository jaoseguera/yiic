<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class BapiCheck
{
    function bapiChecks($bapiName)
    {
        global $rfc,$fce;
        try{
            $fce = $rfc->getFunction($bapiName);
            if (! $fce ) { 
                //echo "Discovering interface of function module failed"; 
                exit;             
            }
            $rfc_rc = $fce->invoke();            
        }catch(SapException $ex){
            echo "Exception raised: ".$ex->getMessage();
        }        
    }
}
?>