<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class CommitBapi
{
    function bapiCommit($bapiName)
    {
        global $rfc,$fce;
        try{
        	$fce = $rfc->getFunction($bapiName);
        	if (!$fce) { echo "Discovering interface of function module failed"; exit; }
        	$rfc_rc = $fce->invoke();
        	exit();
        }catch(SapException $ex){
        	if (!$fce) { echo "Discovering interface of function module failed"; exit; }
        	echo "Exception raised: ".$ex->getMessage();
        	exit();
        }        
    }
}
?>