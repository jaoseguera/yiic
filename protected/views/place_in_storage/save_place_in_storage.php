<?php

    $doc_no = $_REQUEST['MATERIAL_DOC'];
    $doc_year = $_REQUEST['DOC_YEAR'];
    $MAT_DOC_DATE = $_REQUEST['MAT_DOC_DATE'];

	$item       	= $_REQUEST['MATDOC_ITM'];
	$MATERIAL   	= $_REQUEST['material'];
	$PLANT 	= $_REQUEST['plant'];
	$STGE_LOC = $_REQUEST['stge_loc'];
	$BATCH 			= $_REQUEST['batch'];
	$ENTRY_QNT		= $_REQUEST['entry_qnt'];
	$ENTRY_UOM          	= $_REQUEST['entry_uom'];


        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $importTableITEM = array();

        $GOODSMVT_HEADER=array("PSTNG_DATE"=>date("Ymd"),"DOC_DATE"=>date("Ymd"));    
        $GOODSMVT_CODE=array("GM_CODE"=>'04');        


        foreach($MATERIAL as $keys=>$vals)
        {
            $GOODSMVT_ITEM=array("MATERIAL"=>strtoupper($MATERIAL[$keys]),"PLANT"=>strtoupper($PLANT[$keys]),
                "STGE_LOC"=>strtoupper($STGE_LOC[$keys]),"BATCH"=>strtoupper($BATCH[$keys]),"MOVE_TYPE"=>'315',
                "ENTRY_QNT"=>floatval($ENTRY_QNT[$keys]),"ENTRY_UOM"=>strtoupper($ENTRY_UOM[$keys]),"MVT_IND"=>'');
            array_push($importTableITEM, $GOODSMVT_ITEM);
        }
        $res = $fce->invoke(['GOODSMVT_HEADER'=>$GOODSMVT_HEADER,
                        'GOODSMVT_CODE'=>$GOODSMVT_CODE,
                        'GOODSMVT_ITEM'=>$importTableITEM],$options);
        
        $en_expt=$res['MATERIALDOCUMENT'];
        $en_year=$res['MATDOCUMENTYEAR'];
        if($en_expt!=NULL)
        {
            echo "Material Document ".$en_expt." has been successfully posted ";
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();
            $type="S";
        }
        else
        {
            $res_table=new ResponseTable();
            $SalesOrder=$res['RETURN'];
            foreach($SalesOrder as $msg)
            {
                echo $msg['MESSAGE']."<br>";
                if($msg['TYPE']=='S')
                {
                    $type="S";
                }
                else
                {
                    $type=$msg['TYPE'];
                }
            }
        }
        echo "@".$type;
        $dt=0;
        $hs="";


?>