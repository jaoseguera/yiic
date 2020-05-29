<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Create_purchase_requisitionForm extends CFormModel
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
        $PREQ_ITEM  = $_REQUEST['PREQ_ITEM'];
        $PUR_GROUP  = $_REQUEST['PUR_GROUP'];
        $PURCH_ORG  = $_REQUEST['PURCH_ORG'];
        $MATERIAL   = $_REQUEST['MATERIAL'];
        $PLANT      = $_REQUEST['PLANT'];
        $VENDOR     = $_REQUEST['VENDOR'];
        $QUANTITY   = $_REQUEST['QUANTITY'];
        $UNIT       = $_REQUEST['UNIT'];
        $PREQ_PRICE = $_REQUEST['PREQ_PRICE'];
        
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];            
        $PRHEADER = array("PR_TYPE"=>"NB", "ITEM_INTVL"=>"00010");            
        $PRHEADERX=array("PR_TYPE"=>"X", "ITEM_INTVL"=>"X");                
        $importTablePRITEM = array();
        $importTablePRITEMX = array();
        
        
        foreach($PREQ_ITEM as $keys=>$vals)
        {
			$venLenth = count($VENDOR[$keys]);
			if($venLenth < 10 && $VENDOR[$keys] != "") { $VENDOR[$keys] = str_pad((int) $VENDOR[$keys], 10, 0, STR_PAD_LEFT); } else { $VENDOR[$keys] = substr($VENDOR[$keys], -10); }
            $PRITEM  = array("PREQ_ITEM"=>$vals, "PUR_GROUP"=>strtoupper($PUR_GROUP[$keys]), "MATERIAL"=>strtoupper($MATERIAL[$keys]), "PLANT"=>strtoupper($PLANT[$keys]), "QUANTITY"=>floatval($QUANTITY[$keys]), "UNIT"=>strtoupper($UNIT[$keys]), "PREQ_PRICE"=>floatval($PREQ_PRICE[$keys]), "FIXED_VEND"=>strtoupper($VENDOR[$keys]), "PURCH_ORG"=>strtoupper($PURCH_ORG[$keys]));
            array_push($importTablePRITEM, $PRITEM);            
            $PRITEMX = array("PREQ_ITEM"=>$vals, "PUR_GROUP"=>"X", "MATERIAL"=>"X", "PLANT"=>"X", "QUANTITY"=>"X", "UNIT"=>"X", "PREQ_PRICE"=>"X", "FIXED_VEND"=>"X", "PURCH_ORG"=>"X");
            $ORDER_ITEMS_INX=array("ITM_NUMBER"=>$vals, "MATERIAL"=>"X", "TARGET_QTY"=>"X", "TARGET_QU"=>"X");            
            array_push($importTablePRITEMX, $PRITEMX);
        }
        $res = $fce->invoke(['PRHEADER'=>$PRHEADER,
                            'PRHEADERX'=>$PRHEADERX,
                            'PRITEM'=>$importTablePRITEM,
                            'PRITEMX'=>$importTablePRITEMX],$options);          
        
        $response= $res['NUMBER'];
        if($response!='#       1')
        {
            echo $response." Created Successfully";
            echo "@S";
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
            echo "@".$type;
        }

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        $dt=0;
        $hs="";
    }
}