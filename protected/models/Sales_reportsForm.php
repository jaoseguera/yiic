<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Sales_reportsForm extends CFormModel
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
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $type = $_REQUEST['type'];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        
        $imp->setImport('SALESDOCUMENT',$_REQUEST['REF_DOC']);
        if($type == 'set')
        {
            $ORDER_HEADER_IN = array('DLV_BLOCK'=>'01');
        }
        if($type == 'remove')
        {
            $ORDER_HEADER_IN = array('DLV_BLOCK'=>'');
        }        
        $ORDER_HEADER_INX = array('UPDATEFLAG'=>'U','DLV_BLOCK'=>'X');        
        $res = $fce->invoke(['ORDER_HEADER_IN'=>$ORDER_HEADER_IN,
                            'ORDER_HEADER_INX'=>$ORDER_HEADER_INX],$options);
        
        $SalesOrder = $res["RETURN"];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        $msg="";
        foreach($SalesOrder as $keys)
        {
            $msg .=$keys['MESSAGE']."<br>";
        }
        return $msg;
    }
    
    public function _actionCreatedelivery()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);

        $ref_doc=strtoupper($_REQUEST['REF_DOC']);
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $importTableItems = array();        
        $SALES_ORDER_ITEMS=array("REF_DOC"=>strtoupper($_REQUEST['REF_DOC']));
        array_push($importTableItems, $SALES_ORDER_ITEMS);
        $res = $fce->invoke(['SALES_ORDER_ITEMS'=>$importTableItems],$options);
        
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
        if($deliv==NULL)
        {
            foreach($SalesOrder6 as $keys)
            {
                $msg.=$keys['MESSAGE']."<br>";
                if($keys['TYPE']!='S')
                {
                    $type=1;
                }
            }
        }
        else
        {
            $msg=$deliv." has been created";
        }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
        $fce->invoke();
        return $msg;
    }

    public function _actionSalesordercreditrelease()
    {
        global $rfc,$fce;
        $bapiName = $_REQUEST['bapiName'];
        $b = new Bapi();
        $b->bapiCall($bapiName);
        
        $I_VBELN=$_REQUEST['I_VBELN'];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_VBELN"=>$I_VBELN],$options);            
        return $res['E_MESSAGES'];
    }
}