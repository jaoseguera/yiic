<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_materialForm extends CFormModel
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
		$I_IDOCTP = "MATMAS05";
		$I_SEGNAM = "E1MARAM";
		$I_VALUE = "NIPRO002";

		$I_IDOCTP = strtoupper($I_IDOCTP);
		$I_SEGNAM = strtoupper($I_SEGNAM);
		$I_VALUE = strtoupper($_REQUEST['I_VALUE']);

		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["I_IDOCTP"=> strtoupper($I_IDOCTP),
							"I_SEGNAM"=> strtoupper($I_SEGNAM),
							"I_VALUE"=> strtoupper($_REQUEST['I_VALUE'])],$options);			
		$T_EDIDC3 = $res['T_EDIDC'];
		//print_r($T_EDIDC3);			
		$rowsag1 = count($T_EDIDC3);			
		//////////////////////////////////////////////////////////////////////////////////
	
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;
		$table_inf  = "DOCNUM,STATUS,MANDT,RCVPRN,RCVPRT";
		$labels_inf = "DOCNUM,STATUS,MANDT,RCVPRN,RCVPRT";
		$tableField1  = $_SESSION['device'].'_Search_material';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf=$doc->customize->$tableField1->Table_order;
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

		foreach ($T_EDIDC3 as $val_t => $retur) {
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$T_EDIDC[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		
		$_SESSION['table_today_search_material'] = $T_EDIDC;
		
		$rowsag1 = count($T_EDIDC);
		if ($rowsag1 <= 10) {
			$rows_sm = $rowsag1;
		} else {
			$rows_sm = 10;
		}
	}
}