<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Create_purchase_orderForm extends CFormModel
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
        $COMP_CODE  = strtoupper(trim($_REQUEST['COMP_CODE']));
        $VENDOR     = strtoupper(trim($_REQUEST['VENDOR']));
        $PURCH_ORG  = strtoupper(trim($_REQUEST['PURCH_ORG']));
        $PUR_GROUP  = strtoupper(trim($_REQUEST['PUR_GROUP']));
        $OUR_REF    = strtoupper(trim($_REQUEST['OUR_REF']));
		
		$venLenth = count($VENDOR);
		if($venLenth < 10 && $VENDOR != "") { $VENDOR = str_pad((int) $VENDOR, 10, 0, STR_PAD_LEFT); } else { $VENDOR = substr($VENDOR, -10); }
        
        if(isset($_REQUEST['PURCH_REQ']))
			$PURCH_REQ    = $_REQUEST['PURCH_REQ'];
		else
			$PURCH_REQ	  = "";
        if(isset($_REQUEST['PURCH_REQ_ITEM']))
			$PURCH_REQ_ITEM    = $_REQUEST['PURCH_REQ_ITEM'];
		else
			$PURCH_REQ_ITEM	   = "";
        $PO_ITEM    = $_REQUEST['PO_ITEM'];
        $MATERIAL   = $_REQUEST['MATERIAL'];
        $PLANT      = $_REQUEST['PLANT'];
        $PO_UNIT    = $_REQUEST['PO_UNIT'];
        $QUANTITY   = $_REQUEST['QUANTITY'];
       

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];        
        $importTablePOITEM = array();
        $importTablePOITEMX = array();
        $POHEADER   = array("COMP_CODE"=>$COMP_CODE,"DOC_TYPE"=>"NB","VENDOR"=>$VENDOR,"PURCH_ORG"=>$PURCH_ORG,"PUR_GROUP"=>$PUR_GROUP,"OUR_REF"=>$OUR_REF);        
        $POHEADERX  = array("COMP_CODE"=>"X","DOC_TYPE"=>"X","VENDOR"=>"X","PURCH_ORG"=>"X","PUR_GROUP"=>"X","OUR_REF"=>"X");        
        
        //...................................................................................................................
        foreach($PO_ITEM as $keys=>$vals)
        {
            $POITEM     = array("PO_ITEM"=>(string)intval($vals),"MATERIAL"=>strtoupper(trim($MATERIAL[$keys])),"PLANT"=>strtoupper(trim($PLANT[$keys])),"QUANTITY"=>floatval($QUANTITY[0]),"PO_UNIT"=>strtoupper(trim($PO_UNIT[$keys])));
			if(isset($PURCH_REQ[$keys]) && isset($PURCH_REQ_ITEM[$keys]) && $PURCH_REQ[$keys] != "" && $PURCH_REQ_ITEM[$keys] != "")
			{
				$venLenth = count($PURCH_REQ[$keys]);
				if($venLenth < 10 && $PURCH_REQ[$keys] != "") { $PURCH_REQ[$keys] = str_pad((int) $PURCH_REQ[$keys], 10, 0, STR_PAD_LEFT); } else { $PURCH_REQ[$keys] = substr($PURCH_REQ[$keys], -10); }
				$POITEM['PREQ_NO'] = $PURCH_REQ[$keys];
				$POITEM['PREQ_ITEM'] = $PURCH_REQ_ITEM[$keys];
			}
            array_push($importTablePOITEM, $POITEM);            
            $POITEMX    = array("PO_ITEM"=>(string)intval($vals),"MATERIAL"=>"X","PLANT"=>"X","QUANTITY"=>"X","PO_UNIT"=>"X");
			if(isset($PURCH_REQ[$keys]) && isset($PURCH_REQ_ITEM[$keys]) && $PURCH_REQ[$keys] != "" && $PURCH_REQ_ITEM[$keys] != "")
			{
				$POITEMX['PREQ_NO'] = "X";
				$POITEMX['PREQ_ITEM'] = "X";
			}            
            array_push($importTablePOITEMX, $POITEMX);
        }
		$res = $fce->invoke(['POHEADER'=>$POHEADER,
                            'POHEADERX'=>$POHEADERX,
                            'POITEM'=>$importTablePOITEM,
                            'POITEMX' => $importTablePOITEMX
                            ],$options);
        
        $response = $res['EXPPURCHASEORDER'];
        if($response!=NULL)
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