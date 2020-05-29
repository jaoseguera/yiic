<?php
class ResponseExport
{
    function export($fieldName)
    {
        global $rfc,$fce;
        $rowsag = saprfc_export($fce,$fieldName);
        return $rowsag;
    }
}
?>