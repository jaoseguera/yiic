<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Post_good_receiptForm extends CFormModel
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
    
    public function _actionSubmit($fce)
    {
        global $rfc;
        $REF_DOC_NO=strtoupper($_REQUEST['REF_DOC_NO']);
        $MATERIAL=$_REQUEST['MATERIAL'];
        $PLANT=$_REQUEST['PLANT'];
        $STGE_LOC=$_REQUEST['STGE_LOC'];
        $ENTRY_QNT=$_REQUEST['ENTRY_QNT'];
        $ENTRY_UOM=$_REQUEST['ENTRY_UOM'];
        $PO_NUMBER=$_REQUEST['PO_NUMBER'];
        $PO_ITEM=$_REQUEST['PO_ITEM'];

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
                
        $GOODSMVT_HEADER=array("PSTNG_DATE"=>date("Ymd"),"DOC_DATE"=>date("Ymd"),"REF_DOC_NO"=>$REF_DOC_NO);        
        $GOODSMVT_CODE=array("GM_CODE"=>'01');        
        $imporTableITEM = array();

        //...................................................................................................................		
        foreach($PO_ITEM as $keys=>$vals)
        {
			if(strtoupper($ENTRY_UOM[$keys])=='CV')
			{
				$UOM='EA';
			}
			else
			{
                $UOM=strtoupper($ENTRY_UOM[$keys]);
			}
			$GOODSMVT_ITEM=array("MATERIAL"=>strtoupper($MATERIAL[$keys]),"PLANT"=>strtoupper($PLANT[$keys]),"STGE_LOC"=>strtoupper($STGE_LOC[$keys]),"MOVE_TYPE"=>'101',"ENTRY_QNT"=>floatval($ENTRY_QNT[0]),"ENTRY_UOM"=>strtoupper($UOM),"PO_NUMBER"=>strtoupper($PO_NUMBER[$keys]),"PO_ITEM"=>$vals,"MVT_IND"=>"B");
            array_push($imporTableITEM, $GOODSMVT_ITEM);			
        }
        $res = $fce->invoke(['GOODSMVT_HEADER'=>$GOODSMVT_HEADER,
                            'GOODSMVT_CODE'=> $GOODSMVT_CODE,
                            'GOODSMVT_ITEM'=>$imporTableITEM],$options);
        
        $en_expt=$res['MATERIALDOCUMENT'];
        //$en_expt=$expt->export('MATERIALDOCUMENT');
        if($en_expt!=NULL)
        {
			echo "Successfully  posted goods movement@S";
        }
        else
        {			
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
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        $dt=0;
        $hs="";
    }
}