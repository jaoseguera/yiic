<?php
class Confirm_prod_orderForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    public function rules()
    {
        return array(
            //array('username','email'),
            // username and password are required
            //array('username, password', 'required'),
            // rememberMe needs to be a boolean
            //array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }
    
    public function _actionSubmit($doc, $screen, $fce)
    {	global $rfc;
		if(isset($_REQUEST['ORDER_NUMBER']))
		{
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$importTableATH = array();
			
			
			$ORDER_NUMBER=strtoupper($_REQUEST['ORDER_NUMBER']);
            $cusLenth = count($ORDER_NUMBER);
            if($cusLenth < 12) { $ORDER_NUMBER = str_pad((int) $ORDER_NUMBER, 12, 0, STR_PAD_LEFT); } else { $ORDER_NUMBER = substr($ORDER_NUMBER, -12); }
			if(isset($_REQUEST['final_conf']))
				$FIN_CONF=$_REQUEST['final_conf'];
			
			
			$YIELD=$_REQUEST['confirmed_qty'];
			$ATHDRLEVELS=array("ORDERID"=>$ORDER_NUMBER,'FIN_CONF'=>(string)$FIN_CONF,'YIELD'=>floatval($YIELD));
			array_push($importTableATH, $ATHDRLEVELS);
			$res = $fce->invoke(['ATHDRLEVELS'=>$importTableATH],$options);
		
			$SalesOrder=$res['DETAIL_RETURN'];
			
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
			$fce->invoke();

			$dt=0;
			$hs="";
			
			foreach($SalesOrder as $keys)
			{
				$hs.=$keys['MESSAGE']."<br>";
				//$ty=$keys['TYPE'];
				if($keys['TYPE']=='E' && $keys['ID'] == 'RU' && $keys['NUMBER']==510)
					$dt=1;
			}

            if($dt==1)
                $hs='This operation has activated a pre-defined trigger. <br> Please use SAP GUI to handle this trigger and perform the operation.';
		} 

		echo $hs;
    }
    
    
    
}