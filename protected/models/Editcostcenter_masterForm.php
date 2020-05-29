<?php
// This is a Proof-of-Concept version that has not been reviewed.
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Editcostcenter_masterForm extends CFormModel
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
		$c_Area = isset($_REQUEST['C_AREA'])?$_REQUEST['C_AREA']:'';
		$c_Code=isset($_REQUEST['C_CODE'])?$_REQUEST['C_CODE']:'';
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["CONTROLLINGAREA"=>$c_Area,
							"COMPANYCODE"=>$c_Code],$options);
		
		$SalesOrders  = $res['COSTCENTER_LIST'];
		
		$table_inf  = "COSTCENTER,CO_AREA,COCNTR_TXT";
		$labels_inf = "COSTCENTER,CO_AREA,COCNTR_TXT";
		$tableField1  = $screen.'_Editcostcenter_master';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)<6)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		$sd=1;
		foreach ($SalesOrders as $val_t => $retur) {
			$order_t = array($exp[0] => trim($retur[$exp[0]]), $exp[1] => trim($retur[$exp[1]]), $exp[2] => trim($retur[$exp[2]]));
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]]);
			//$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $retur);
			
			$sd++;
			
		}
		
		$_SESSION['example40_today'] = $SalesOrder;
		$rowsag1  = count($SalesOrder);
		
	}
	public function _actionDetails($doc, $screen, $fce)
    {
		$c_Area = isset($_REQUEST['C_AREA'])?$_REQUEST['C_AREA']:'';
		$c_Code=isset($_REQUEST['cust'])?$_REQUEST['cust']:'';
		//$cusLenth = count($c_Code);
		//if($cusLenth < 10) { $c_Code = str_pad((int) $c_Code, 10, 0, STR_PAD_LEFT); } else { $c_Code = substr($c_Code, -10); }
		if(is_numeric($c_Code))
			$c_Code=str_pad($c_Code,10,'0',STR_PAD_LEFT);
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["CONTROLLINGAREA" => $c_Area,
							"COSTCENTER" => $c_Code],$options);
		
		$details = $res['COSTCENTERDETAIL'];
		$_SESSION['ITEM']=$details;
	}	
}