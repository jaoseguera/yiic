<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Product_availability_quotationForm extends CFormModel
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
        $MATERIAL = strtoupper($_REQUEST['MATERIAL']);
        $cusLenth = count($MATERIAL);
        if($cusLenth < 18 && $MATERIAL != "" && is_numeric($MATERIAL)) {
            $MATERIAL = str_pad($MATERIAL, 18, 0, STR_PAD_LEFT);
        }
        $PLANT    = strtoupper($_REQUEST['PLANT']);
        //GEZG 06/21/2018
        //Changing SAPRFC methods
        $options=['rtrim'=>true];
        $res = $fce->invoke(['I_MATNR'=>$MATERIAL,
                            'I_WERKS'=>$PLANT],$options);
        
        $SalesOrder['U_QUANTITY'] = round($res['U_QUANTITY'],0);
        $SalesOrder['O_QUANTITY'] = round($res['O_QUANTITY'],2);
        $SalesOrder['Q_QUANTITY']  = round($res['Q_QUANTITY'],0);
        $SalesOrder['D_QUANTITY'] = round($res['D_QUANTITY'],1);
        $SalesOrder['PUR_ORDERS'] = round($res['PUR_ORDERS'],0);
        $SalesOrder['T_QUANTITY'] = $res['U_QUANTITY']-($res['O_QUANTITY']+$res['D_QUANTITY']);
        $_SESSION['product_aval_err']=$res['E_MESSAGE'];
        /*
        $s_msg = "";
        if($SalesOrder2 !=NULL) {
            $type=$SalesOrder2['TYPE'];
            $s_msg = $SalesOrder2['MESSAGE']."<br>";
            $_SESSION['product_aval_err'] = $s_msg."@".$type;
        }
        $res_table   = new ResponseTable();*/
        return $SalesOrder;
    }
    
    public function _actionSubmit1($fce)
    {
        $MATERIAL = strtoupper($_REQUEST['values']);
        $PLANT    = strtoupper($_REQUEST['pln']);
         //GEZG 06/21/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(['MATERIAL'=> $MATERIAL,
                            'PLANT'=> $PLANT],$options);        
        
        $SalesOrder  = $res['MRP_STOCK_DETAIL'];
        $SalesOrder2 = $res['RETURN'];
        return $SalesOrder;
    }
    
   
}