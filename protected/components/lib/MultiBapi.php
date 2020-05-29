<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class MultiBapi
{
    function multiBapiCall($bapiName)
    {
        global $rfc,$fce;
        try{
        	$fce = $rfc->getFunction($bapiName);	
        	if (!$fce) { echo "Discovering interface of function module failed"; exit; }
        }catch(SapException $ex){
        	echo "Discovering interface of function module failed"; exit; 
        }               
    }
}
?>