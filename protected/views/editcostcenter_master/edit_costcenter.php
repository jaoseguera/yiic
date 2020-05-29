<?php
	global $rfc,$fce;
// This is a Proof-of-Concept version that has not been reviewed.
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$importTableCOSTCENTER = array();	
    		
    $CC=$_REQUEST['CC_NEW'];
	if(is_numeric($CC))
		$CC=str_pad($CC,10,'0',STR_PAD_LEFT);
	$FD=explode('/',$_REQUEST['F_DATE_NEW']);
	$TD=explode('/',$_REQUEST['T_DATE_NEW']);
    
    $per_charge=$_REQUEST['PERSON_IN_NEW'];
    $CCC=$_REQUEST['CC_TYPE_NEW'];
    $c_Code=$_REQUEST['C_CODE_NEW'];
    $h_Area=$_REQUEST['HIER_NEW'];
	$i_Name=$_REQUEST['NAME_NEW'];
	$desc=$_REQUEST['DESCRIP_NEW'];
    $POITEM=array('COSTCENTER'=>$CC,'VALID_FROM'=>$FD[2].$FD[0].$FD[1],'VALID_TO'=>$TD[2].$TD[0].$TD[1],'PERSON_IN_CHARGE'=>$per_charge,'COSTCENTER_TYPE'=>$CCC,'COSTCTR_HIER_GRP'=>$h_Area,'COMP_CODE'=>$c_Code,'DESCRIPT'=>$desc,'NAME'=>$i_Name);
	
	
	array_push($importTableCOSTCENTER, $POITEM);

	$res = $fce->invoke(['CONTROLLINGAREA'=>$_REQUEST['C_AREA'],
						'COSTCENTERLIST'=>$importTableCOSTCENTER],$options);
	
    $SalesOrder = $res['RETURN'];
	
    if($SalesOrder[0]['TYPE']=='E')
		echo 'E@'.$SalesOrder[0]['MESSAGE'];
	else
		echo 'S@Costcenter ('.$CC.') has been Modified Successfully';

   	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
	$fce->invoke();

?>