<?php
// This is a Proof-of-Concept version that has not been reviewed.
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Editcustomers_masterForm extends CFormModel
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
		$customer = $_REQUEST['CUSTOMER_ID'];
		$cusLenth = count($customer);
		if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
		// echo $customer; exit;
		$btn = $_REQUEST['btn'];
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_CUSTOMER_NUM"=>$customer],$options);		
		$edit_cus  = $res['ET_BAPIAD1VL'];
		$_SESSION['edit_cus_mas']=$edit_cus;
		
		
	}
	
}