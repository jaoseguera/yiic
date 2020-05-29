<?php
    global $rfc,$fce;
// This is a Proof-of-Concept version that has not been reviewed.
    //GEZG 06/22/2018
    //Changing SAPRFC methods
    $options = ['rtrim'=>true];
    $login = Yii::app()->user->getState("user_id");
    $res = $fce->invoke(['I_SALES_ORG'=>$_REQUEST['I_SALES_ORG'],
                        'I_DIST_CHAN'=>$_REQUEST['I_DIST_CHAN'],
                        'I_DIVISION'=>$_REQUEST['I_DIVISION'],
                        'I_NAME'=>$_REQUEST['I_NAME'],
                        'I_HOUSE_NO'=>$_REQUEST['I_HOUSE_NO'],
                        'I_STREET'=>$_REQUEST['I_STREET'],
                        'I_CITY'=>$_REQUEST['I_CITY'],
                        'I_STATE'=>$_REQUEST['I_STATE'],
                        'I_ZIP'=>$_REQUEST['I_ZIP'],
                        'I_COUNTRY'=>$_REQUEST['I_COUNTRY'],
                        'I_SPRAS'=>$_REQUEST['I_SPRAS'],    
                        'I_THINUI_USER'=>$login,
                        'I_OBJECTTYPE'=>'CUSTOMER',
                        'I_KTOKD'=>'ZB01'],$options);
   
    
    $SalesOrder = $res['ET_MESSAGES'];
    foreach($SalesOrder as $h=>$f)
	{
	$msg.=$f['MESSAGE'].'<br/>';
	}
	echo $SalesOrder[0]['TYPE'].'@'.$msg;
?>