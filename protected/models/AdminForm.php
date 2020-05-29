<?php

/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class adminForm extends CFormModel
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
		global $rfc,$fce;
		$customer = $_REQUEST['CUSTOMER_ID'];
		$cusLenth = count($customer);
		if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
		// echo $customer; exit;
		$btn = $_REQUEST['btn'];
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$importTableIDRange = array();
		$IDRANGE   = array("OPTION"=>"EQ","LOW"=>$customer);
		array_push($importTableIDRange, $IDRANGE);
		$res = $fce->invoke(["MAXROWS"=>'0',
							"CPDONLY"=>'',
							'IDRANGE'=>$importTableIDRange],$options);


		$edit_cus  = $res['ADDRESSDATA'];
		$_SESSION['edit_cus']=$edit_cus;
		
		$fce = $rfc->getFunction('BAPI_SALESORDER_GETLIST');
		$res = $fce->invoke(['CUSTOMER_NUMBER'=>$customer,
							'SALES_ORGANIZATION'=>1000],$options);

	
		$SalesOrder = $res['SALES_ORDERS'];
		$sd=1;
		foreach($SalesOrder as $keys)
		{
			$result[$sd]=$keys;
			$sd++;	
		}
		$_SESSION['example40_today'] = $result;
		$rowsag1  = count($result);
		$cust_num = $edit_cus[0]['CUSTOMER'];            
	}
}