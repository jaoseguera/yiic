<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Display_list_approveForm extends CFormModel
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
		if($cusLenth < 10 && $cust_num!='') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
		$sale = $_REQUEST['SALES_ORGANIZATION'];
		$docu = $_REQUEST['DOCUMENT_NUMBER'];
		$docLength=count($docu);
		if($docLenth < 10 && $docu!='') { $docu = str_pad((int) $docu, 10, 0, STR_PAD_LEFT); } else { $docu = substr($docu, -10); }
		if($docu==0)
			$docu='';
		
		$date = $_REQUEST['sales_order_date'];
		$dateto = $_REQUEST['sales_order_dateto'];
		
		list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $date)));
		$date = $year.$month.$day;
		if($date == ""){$date = "00000000";}

		list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $dateto)));
		$dateto = $year.$month.$day;
		if($dateto == ""){$dateto = "00000000";}
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(['CUSTOMER'=> $cust_num,
							'VBELN'=> $docu,
							'VKORG'=> $sale,
							'DATE_FROM'=> $date,
							'DATE_TO'=> $dateto],$options);		
		$SalesOrders = $res['T_BLOCK_ORDER'];
		
		$sd = 1;
		//////////////////////////////////////////////////////////////////////////////////
		$table_inf  = "VBELN,KUNNR,AUDAT,NETWR,WAVWR";
		$labels_inf = "VBELN,KUNNR,AUDAT,NETWR,WAVWR";
		$tableField1  = $screen.'_Display_list_approve';
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
			
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]]);
			//$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $retur);
			$sd++;
		}
		//................................................................................
		$_SESSION['table_todays']=$SalesOrder;
		$rowsag1 = count($SalesOrder);
	}
    public function _actionColumncount($doc, $screen)
    {
	     $table_inf  = "VBELN,KUNNR,AUDAT,NETWR,WAVWR";
		$labels_inf = "VBELN,KUNNR,AUDAT,NETWR,WAVWR";
		$tableField1  = $screen.'_Display_list_approve';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
			$c_c=count($exp);
		else
			$c_c=10;
		return $c_c;	
	}
}