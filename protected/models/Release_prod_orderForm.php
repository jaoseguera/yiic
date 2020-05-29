<?php
class Release_prod_orderForm extends CFormModel
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
    {
		if(isset($_REQUEST['ORDER_NUMBER']))
		{
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$imporTableOrders = array();						

			$ORDER_NUMBER=strtoupper($_REQUEST['ORDER_NUMBER']);
            $cusLenth = count($ORDER_NUMBER);
            if($cusLenth < 12) { $ORDER_NUMBER = str_pad((int) $ORDER_NUMBER, 12, 0, STR_PAD_LEFT); } else { $ORDER_NUMBER = substr($ORDER_NUMBER, -12); }
			$ORDERS=array("ORDER_NUMBER"=>$ORDER_NUMBER);
			array_push($imporTableOrders, $ORDERS);			
			
			$res = $fce->invoke(['RELEASE_CONTROL'=>'1',
								'WORK_PROCESS_GROUP'=>"COWORK_BAPI",
								'WORK_PROCESS_MAX'=>99,
								'ORDERS'=>$imporTableOrders],$options);
						
			$SalesOrder=$res['DETAIL_RETURN'];
			$dt=0;
			$hs="";
			
			foreach($SalesOrder as $keys)
			{
				$hs.=$keys['MESSAGE']."<br><br>";
				$ty=$keys['TYPE'];
				if($ty!='S')
					$dt=1;
			}
			
			echo $hs;
		}
		
		
    }
    

}