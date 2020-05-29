<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Supply_listForm extends CFormModel
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
		$vender		= $_REQUEST['vendor'];
		$MATERIAL	= $_REQUEST['MATERIAL'];
		$PLANT		= $_REQUEST['PLANT'];
		$PURCH_ORG	= $_REQUEST['PURCH_ORG'];
		$cusLenth = strlen($vender);

		if($cusLenth != 0) {
			if($cusLenth < 10) { $vender = str_pad((int) $vender, 10, 0, STR_PAD_LEFT); } else { $vender = substr($vender,-10); }
		}
		/*echo "<script type='text/javascript'>alert('{$vender}' + ',' + '{$cusLenth}');</script>";*/
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["I_VENDOR_NUM"=> $vender,
							"I_MATERIAL_NUM"=> $MATERIAL,
							"I_PLANT"=> $PLANT,
							"I_PURCH_ORG"=> $PURCH_ORG],$options);		
		$SalesOrder3 = $res['ET_SUPPLY_LIST'];
			
		
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;			
		$table_inf  = "MATERIAL,UNRESTR_STOCK,BASE_UOM,PRICE,CURRENCY,";
		$labels_inf = "MATERIAL,UNRESTR_STOCK,BASE_UOM,PRICE,CURRENCY,";
		$tableField1 = $screen.'_Supply_list';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp   = explode(',',$labels_inf);
		if(count($exp>0))
		$_SESSION['table_today_supply_list_count']=count($exp)-1;
		else
		$_SESSION['table_today_supply_list_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}

		foreach($SalesOrder3 as $val_t => $retur)
		{
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}

		$_SESSION['table_today_supply_list'] = $SalesOrder;
		$rowsag1 = count($SalesOrder);
		$comp = 10;
		if ($rowsag1 < 10)
		{
			$comp = $rowsag1;
		} 
	}
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "MATERIAL,UNRESTR_STOCK,BASE_UOM,PRICE,CURRENCY,";
            $labels_inf        = "MATERIAL,UNRESTR_STOCK,BASE_UOM,PRICE,CURRENCY,";
		$tableField1  = $screen.'_Supply_list';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)>0)
			$c_c=count($exp)-1;
		else
			$c_c=10;
		$_SESSION['table_today_supply_list_count']=$c_c; 	
		return $c_c;	
	}
}