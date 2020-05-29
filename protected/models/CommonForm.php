<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class CommonForm extends CFormModel
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
    
    public function _actionSetdeliveryblock()
    {
        global $fce,$rfc;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $ref_doc=strtoupper($_REQUEST['REF_DOC']);
		$cusLenth       = count($ref_doc);
		if($cusLenth < 10) { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }
        $type = $_REQUEST['type'];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];                        
        if($type == 'set')
        {
            $ORDER_HEADER_IN = array('DLV_BLOCK'=>'01');
        }
        if($type == 'remove')
        {
            $ORDER_HEADER_IN = array('DLV_BLOCK'=>'');
        }        
        $ORDER_HEADER_INX = array('UPDATEFLAG'=>'U','DLV_BLOCK'=>'X');        

        $res = $fce->invoke(['SALESDOCUMENT'=> $ref_doc,
                            'ORDER_HEADER_IN'=>$ORDER_HEADER_IN,
                            'ORDER_HEADER_INX'=>$ORDER_HEADER_INX],$options);

        $SalesOrder=$res['RETURN'];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();

        $msg="";
		$restype = array();
		$msgtype = "S";
		
        foreach($SalesOrder as $keys)
        {
			$restype[] = $msg['TYPE'];
            $msg .=$keys['MESSAGE']."<br>";
        }
		
		if(in_array("E", $restype) || in_array("A", $restype))
			$msgtype = "E";
		
        return $msg."@".$msgtype;
    }
    
    public function _actionCreatedelivery()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $ref_doc=strtoupper($_REQUEST['REF_DOC']);
		$cusLenth       = count($ref_doc);
		if($cusLenth < 10) { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }
        
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $importTableOrderItems = array();
        $SALES_ORDER_ITEMS=array("REF_DOC"=>strtoupper($ref_doc));
        array_push($importTableOrderItems, $SALES_ORDER_ITEMS);
        $res = $fce->invoke(['SALES_ORDER_ITEMS'=>$importTableOrderItems],$options);
        
        $SalesOrder=$res['SALES_ORDER_ITEMS'];
        $SalesOrder1=$res['SERIAL_NUMBERS'];
        $SalesOrder2=$res['EXTENSION_IN'];
        $SalesOrder3=$res['DELIVERIES'];
        $SalesOrder4=$res['CREATED_ITEMS'];
        $SalesOrder5=$res['EXTENSION_OUT'];
        $SalesOrder6=$res['RETURN'];
        $deliv=$res['DELIVERY'];
        $msg="";
        $type=0;
		$restype = array();
		$msgtype = "S";
        if($deliv==NULL)
        {
            foreach($SalesOrder6 as $keys)
            {
				$restype[] = $keys['TYPE'];
                $msg.=$keys['MESSAGE']."<br>";
                if($keys['TYPE']!='S')
                {
                    $type=1;
                }
            }
			if(in_array("E", $restype) || in_array("A", $restype))
				$msgtype = "E";
        }
        else
        {
            $msg=$deliv." has been created";
        }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        return $msg."@".$msgtype;
    }
 public function _actionCreateorder()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $ref_doc=strtoupper($_REQUEST['REF_DOC']);
		$cusLenth       = count($ref_doc);
		if($cusLenth < 10) { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $importTableOrderItems = array();
        $SALES_ORDER_ITEMS=array("REF_DOC"=>strtoupper($ref_doc));
        array_push($importTableOrderItems, $SALES_ORDER_ITEMS);

        $res = $fce->invoke(['SALES_ORDER_ITEMS'=>$importTableOrderItems],$options);
       
        $SalesOrder=$res['SALES_ORDER_ITEMS'];
        $SalesOrder1=$res['SERIAL_NUMBERS'];
        $SalesOrder2=$res['EXTENSION_IN'];
        $SalesOrder3=$res['DELIVERIES'];
        $SalesOrder4=$res['CREATED_ITEMS'];
        $SalesOrder5=$res['EXTENSION_OUT'];
        $SalesOrder6=$res['RETURN'];
        $deliv=$res['DELIVERY'];
        $msg="";
        $type=0;
		$restype = array();
		$msgtype = "S";
        if($deliv==NULL)
        {
            foreach($SalesOrder6 as $keys)
            {
				$restype[] = $keys['TYPE'];
                $msg.=$keys['MESSAGE']."<br>";
                if($keys['TYPE']!='S')
                {
                    $type=1;
                }
            }
			if(in_array("E", $restype) || in_array("A", $restype))
				$msgtype = "E";
        }
        else
        {
            $msg=$deliv." has been created";
        }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        return $msg."@".$msgtype;
    }
public function _actionCreatebilling()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $ref_doc=strtoupper($_REQUEST['REF_DOC']);
		$cusLenth       = count($ref_doc);
		if($cusLenth < 10) { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $importTableOrderItems = array();
        $SALES_ORDER_ITEMS=array("VBELN"=>strtoupper($ref_doc));
        array_push($importTableOrderItems, $SALES_ORDER_ITEMS);

        $res = $fce->invoke(['T_RESULT_TABLE'=>$importTableOrderItems],$options);
       
        return $res['E_MESSAGES'];
    }	
    public function _actionSalesordercreditrelease()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);
        
        $I_VBELN=$_REQUEST['I_VBELN'];
		$VBLenth = count($I_VBELN);
		if($VBLenth < 10) { $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT); } else { $I_VBELN = substr($I_VBELN, -10); }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_VBELN"=>$I_VBELN],$options);
                
        return $res['E_MESSAGES'];
    }
	
	   public function _actionApprovesalesorder()
    {
        
        global $rfc,$fce;
        $I_VBELN=$_REQUEST['I_VBELN'];
		$VBLenth = count($I_VBELN);
		if($VBLenth < 10) { $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT); } else { $I_VBELN = substr($I_VBELN, -10); }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["VBELN"=>$I_VBELN],$options);

		$msg='';
            $SalesOrder=$res['T_MESSAGES'];
			foreach($SalesOrder as $key=>$val)
			{
					$msg=$msg.'<br/>'.$val['LOG_MESSAGE'];
        }
        return $msg;
    }
}