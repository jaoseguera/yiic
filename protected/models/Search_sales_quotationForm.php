<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_sales_quotationForm extends CFormModel
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
		$cust_num = $_REQUEST['CUSTOMER_NUMBER'];
		$cusLenth = count($cust_num);
		if($cust_num!='')
		{
			if($cusLenth < 10 && $cust_num!='') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
		}
		$sale = $_REQUEST['SALES_ORGANIZATION'];
		$busi = $_REQUEST['BUSINESS_UNITS'];
		$date = $_REQUEST['sales_order_date'];
		$dateto = $_REQUEST['sales_order_dateto'];
		$quoteNumber = $_REQUEST['SALES_DOCUMENT'];
		
		if(trim($quoteNumber) != ""){
			while (strlen($quoteNumber) < 10) {
				$quoteNumber = "0".$quoteNumber;
			}
		}

		if($date != null && $date != ""){
			list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $date)));
			$date = $year.$month.$day;
		}else{
			$date="00000000";
		}
		if($dateto != null && $dateto != ""){
			list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $dateto)));		
			$dateto = $year.$month.$day;	
		}else{
			$dateto = "00000000";
		}

		//GEZG 06/21/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];		
		$res = $fce->invoke([
				'CUSTOMER_NUMBER'=>$cust_num,
				'SALES_ORGANIZATION'=>$sale,
				'DOCUMENT_DATE'=>$date,
				'DOCUMENT_DATE_TO'=>$dateto,
				'SD_DOC'=>$quoteNumber
			],$options);		
		$SalesOrders = $res['SALES_ORDERS'];
		
		$sd = 1;
		//////////////////////////////////////////////////////////////////////////////////
		$table_inf  = "SD_DOC,ITM_NUMBER,MATERIAL,SHORT_TEXT,DOC_TYPE,";
		$labels_inf = "SD_DOC,ITM_NUMBER,MATERIAL,SHORT_TEXT,DOC_TYPE,";
		$tableField1  = $screen.'_Search_sales_quotation';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
		$_SESSION['table_todays_count']=count($exp)-1;
		else
		$_SESSION['table_todays_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach ($SalesOrders as $val_t => $retur) {
			if($retur['DOC_TYPE'] == 'TA')
				$retur['DOC_TYPE'] = 'OR';
			if(isset($retur['NET_VAL_HD']))
				unset($retur['NET_VAL_HD']);
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]],$exp[3] => $retur[$exp[3]], 
			$exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		//................................................................................
		$_SESSION['table_todays']=$SalesOrder;
		$rowsag1 = count($SalesOrder);
	}
	public function _actionColumncount($doc, $screen)
    {
	     $table_inf  = "SD_DOC,ITM_NUMBER,MATERIAL,SHORT_TEXT,DOC_TYPE,";
		$labels_inf = "SD_DOC,ITM_NUMBER,MATERIAL,SHORT_TEXT,DOC_TYPE,";
		$tableField1  = $screen.'_Search_sales_quotation';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
			$c_c=count($exp)-1;
		else
			$c_c=10;
		return $c_c;	
	}
    
}