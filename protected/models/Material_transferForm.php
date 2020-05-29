<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Material_transferForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     **/

    public function rules()
    {
        return array(
            // array('username','email'),
            // username and password are required
            // array('username, password', 'required'),
            // rememberMe needs to be a boolean
            // array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }

    public function _actionSubmit($doc, $screen, $fce)
    {
        global $rfc;
        $MATERIAL  = $_REQUEST['D_MATERIAL'];
        $PLANT_FROM  = $_REQUEST['D_PLANT_FROM'];
        $SLOC_FROM  = $_REQUEST['D_SLOC_FROM'];
        $PLANT_TO   = $_REQUEST['D_PLANT_TO'];
        $SLOC_TO      = $_REQUEST['D_SLOC_TO'];
        $QUANTITY     = $_REQUEST['D_QUANTITY'];
        $BATCH_FROM     = $_REQUEST['D_BATCH_FROM'];
        $BATCH_TO     = $_REQUEST['D_BATCH_TO'];
        $UOM     = $_REQUEST['D_UOM'];
		

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $GOODSMVT_HEADER=array("PSTNG_DATE"=>date("Ymd"),"DOC_DATE"=>date("Ymd"));    
        $GOODSMVT_CODE=array("GM_CODE"=>'04');        
        $importTableItems = array();

        foreach($MATERIAL as $keys=>$vals)
        {
		$fromLenth = count($BATCH_FROM[$keys]);
		if($fromLenth < 10 && $BATCH_FROM[$keys] != "") { $B_FROM = str_pad((int) $BATCH_FROM[$keys], 10, 0, STR_PAD_LEFT); } else { $B_FROM = substr($BATCH_FROM[$keys], -10); }
		
		$toLenth = count($BATCH_TO[$keys]);
		if($toLenth < 10 && $BATCH_TO[$keys] != "") { $B_TO = str_pad((int) $BATCH_TO[$keys], 10, 0, STR_PAD_LEFT); } else { $B_TO = substr($BATCH_TO[$keys], -10); }
         

            $GOODSMVT_ITEM=array("MATERIAL"=>strtoupper($MATERIAL[$keys]),"PLANT"=>strtoupper($PLANT_FROM[$keys]),
                "STGE_LOC"=>strtoupper($SLOC_FROM[$keys]),"BATCH"=>strtoupper($B_FROM),"MOVE_TYPE"=>'313',
                "ENTRY_QNT"=>floatval($QUANTITY[$keys]),"ENTRY_UOM"=>strtoupper($UOM[$keys]),"MVT_IND"=>'',"MOVE_PLANT"=>strtoupper($PLANT_TO[$keys]),
                "MOVE_STLOC"=>strtoupper($SLOC_TO[$keys]),"MOVE_BATCH"=>strtoupper($B_TO));
            array_push($importTableItems, $GOODSMVT_ITEM);            
        }
         $res = $fce->invoke(['GOODSMVT_HEADER'=>$GOODSMVT_HEADER,
                            'GOODSMVT_CODE'=>$GOODSMVT_CODE,
                            'GOODSMVT_ITEM'=>$importTableItems],$options);
        
        $en_expt=$res['MATERIALDOCUMENT'];
        //$en_expt=$expt->export('MATERIALDOCUMENT');
        if($en_expt!=NULL)
        {
            echo " Material document ".$en_expt." has been created successfully";
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();
            $type="S";
        }
        else
        {            
            $SalesOrder=$res['RETURN'];
            $s_msg = "";
            foreach($SalesOrder as $msg)            {

                if($msg['TYPE']=='S')
                {
                    $type="S";
                }
                else
                {
                    $type=$msg['TYPE'];
                    $s_msg .= $msg['MESSAGE']."<br>";
                }
            }
            echo $s_msg;
        }
        echo "@".$type."@";
        $dt=0;
        $hs="";
    }
}