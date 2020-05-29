<?php
class Receive
{
    function getResult()
    {
        global $rfc,$fce;
        $rfc_rc = saprfc_call_and_receive ($fce);
		// var_dump($rfc_rc);
		if ($rfc_rc != SAPRFC_OK) { 
			if ($rfc == SAPRFC_EXCEPTION ) {
				echo ("Exception in RFC: ".saprfc_exception($fce));
				// exit;
			}
            else 
				echo ("Error in RFC: ".saprfc_error($fce));
			// exit;
		}
    }
}
?>