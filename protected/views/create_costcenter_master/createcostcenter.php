<?php
    global $rfc,$fce;
// This is a Proof-of-Concept version that has not been reviewed.
    //GEZG 06/22/2018
    //Changing SAPRFC methods
    $options = ['rtrim'=>true];
    $importTableCostCenter = array();

	
    $CC=$_REQUEST['CC'];
	$FD=explode('/',$_REQUEST['F_DATE']);
	$TD=explode('/',$_REQUEST['T_DATE']);
    
    $per_charge=$_REQUEST['PER_RES'];
    $CCC=$_REQUEST['CCC'];
    $c_Code=$_REQUEST['CMP_CODE'];
    $h_Area=$_REQUEST['HI_AREA'];
	$i_Name=$_REQUEST['I_NAME'];
	$desc=$_REQUEST['DESCRIPT'];
    $POITEM=array('COSTCENTER'=>$CC,'VALID_FROM'=>$FD[2].$FD[0].$FD[1],'VALID_TO'=>$TD[2].$TD[0].$TD[1],'PERSON_IN_CHARGE'=>$per_charge,'COSTCENTER_TYPE'=>$CCC,'COSTCTR_HIER_GRP'=>$h_Area,'COMP_CODE'=>$c_Code,'DESCRIPT'=>$desc,'NAME'=>$i_Name);
	array_push($importTableCostCenter, $POITEM);    
	
    $res = $fce->invoke(['CONTROLLINGAREA'=>$_REQUEST['C_AREA'],
                        'COSTCENTERLIST'=>$importTableCostCenter
                    ],$options);   

   
    $SalesOrder = $res['RETURN'];
    if($SalesOrder[0]['TYPE']=='E')
		echo 'E@'.$SalesOrder[0]['MESSAGE'];
	else
		echo 'S@Costcenter ('.$CC.') has been created Successfully';
	//echo 'S@'.$SalesOrder[0]['MESSAGE'];
	//GEZG 06/22/2018
    //Changing SAPRFC methods
    $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
    $fce->invoke();
?>