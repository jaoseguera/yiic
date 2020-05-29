<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class ResponseTable 
{
    function getTable($fieldName)
    {
        global $rfc,$fce,$res;
        $SalesOrder="";
        $rowsag = count($res[$fieldName]);
        for ($i=0;$i<$rowsag;$i++){
            $SalesOrder[]= $res[$fieldName][$i];
            //var_dump($SalesOrder);
        } 
        return $SalesOrder;
    }
}
?>