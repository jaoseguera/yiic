<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class Bapi
{
    function bapiCall($bapiName)
    {
        global $rfc,$fce;
        $test='hello';
        $login = Yii::app()->user->getState("sap_login");
        //GEZG 06/20/2018
        //Changing BAPI discovery method and open connection method
        try{
            $rfc = new SapConnection($login);
            $fce = $rfc->getFunction($bapiName);
            if(!$fce){
                echo "Discovering interface of function module failed"; 
                exit; 
            }
        }catch(SapException $ex){
            echo "Discovering interface of function module failed"; 
            exit; 
        }       
    }
}
?>