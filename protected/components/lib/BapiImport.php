<?php
class BapiImport 
{
    function setImport($fieldName,$value,$importTable)
    {
        global $importTable;
        array_push($importTable, array($fieldName=>$value));        
    }
}
?>