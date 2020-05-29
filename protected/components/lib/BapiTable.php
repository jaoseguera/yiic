<?php
class BapiTable 
{
    function setTable($fieldName,$value)
    {	
        global $rfc,$fce;
        saprfc_table_init ($fce,$fieldName);
        saprfc_table_append ($fce,$fieldName, $value);
    }
}
?>