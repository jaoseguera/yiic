<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Customer_open_item_headForm extends CFormModel
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
		$sale = $_REQUEST['COMPANY_CODE'];
		$date = $_REQUEST['sales_order_date'];
		$dateto = $_REQUEST['sales_order_dateto'];
		
		list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $date)));		
		$date = $year.$month.$day;
		if($date == ""){$date = "00000000";}
		//$date = $month.$day.$year;
		
		list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $dateto)));		
		$dateto = $year.$month.$day;
		if($dateto == ""){$dateto = "00000000"; }
		//$dateto = $month.$day.$year;
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(['CUSTOMER'=> $cust_num,
							'COMPANYCODE'=> $sale,
							'KEYDATE'=> $date],$options);
		
		
            $SalesOrder=$res['LINE_ITEMS'];            
					
            $table_labels  = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
            $labels        = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
            $tableField1 = $screen.'_Customer_open_items';
            if(isset($doc->customize->$tableField1->Table_order))
            {			
				$labels=$doc->customize->$tableField1->Table_order;
            }			
            $exps1 = explode(',',$table_labels);
            $exp   = explode(',',$labels);                    
			
			if(count($exp)>0)
			$_SESSION['table_todays_count']=count($exp);
			else
			$_SESSION['table_todays_count']=11;
            if(count($exp)<11)
            {
				for($j=count($exp)-1;$j<count($exps1);$j++)
				{
					$exp[$j]=$exps1[$j];
				}
            }
			$sd=1;			
			foreach($SalesOrder as $val_t => $retur)
            {
                $order_t = array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]],$exp[5]=>$retur[$exp[5]],$exp[6]=>$retur[$exp[6]],$exp[7]=>$retur[$exp[7]],$exp[8]=>$retur[$exp[8]],$exp[9]=>$retur[$exp[9]]);
                unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]],$retur[$exp[5]],$retur[$exp[6]],$retur[$exp[7]],$retur[$exp[8]],$retur[$exp[9]]);
                $today=$retur;
                $SalesOrderr[$sd] = array_merge((array)$order_t, (array)$today);
                $sd++;
            }

            //................................................................................
           $_SESSION['table_todays'] = $SalesOrderr;
		
            $rowsag1 = count($SalesOrderr);
	}
      public function _actionSubmitall($doc, $screen, $fce)
    {
		$cust_num = $_REQUEST['CUSTOMER_NUMBER'];
		$cusLenth = count($cust_num);
		if($cusLenth < 10 && $cust_num!='') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
		$sale = $_REQUEST['COMPANY_CODE'];
		
		$date = $_REQUEST['sales_order_date'];
		$dateto = $_REQUEST['sales_order_dateto'];
		
		list($month, $day, $year) = split('[/.-]', $date);
		$date = $year.$month.$day;
		if($date == ""){$date = "00000000";}
		//$date = $month.$day.$year;
		
		list($month, $day, $year) = split('[/.-]', $dateto);
		$dateto = $year.$month.$day;
		if($dateto == ""){$dateto = "00000000";}

		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(['CUSTOMER'=> $cust_num,
					'COMPANYCODE'=> $sale,
					'DATE_FROM'=> $date,
					'DATE_TO'=> $dateto],$options);
		
		
            $SalesOrder=$res['LINEITEMS'];			
			$total=$res['TOTAL'];
            $ids=1;	
            $table_labels  = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
            $labels        = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
            $tableField1 = $screen.'_Customer_all_items';
            if(isset($doc->customize->$tableField1->Table_order))
            {			
				$labels=$doc->customize->$tableField1->Table_order;
            }			
            $exps1 = explode(',',$table_labels);
            $exp   = explode(',',$labels);
            
			if(count($exp>0))
			$_SESSION['table_todays_count']=count($exp);
			else
			$_SESSION['table_todays_count']=11;
            if(count($exp)<11)
            {
				for($j=count($exp);$j<count($exps1);$j++)
				{
					$exp[$j]=$exps1[$j];
				}
            }
			$sd=1;
			foreach($SalesOrder as $val_t => $retur)
            {
                $order_t = array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
                unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
                //$today=$retur;
                $SalesOrderr[$sd] = array_merge((array)$order_t, (array)$retur);
                $sd++;
            }
            //................................................................................
            $_SESSION['table_todays'] = $SalesOrderr;
			if(isset($_SESSION['ar_ag']))
				unset($_SESSION['ar_ag']);
				

			$rowsag1 = count($SalesOrderr);
	}
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
            $labels_inf = "DOC_DATE,REF_DOC_NO,FAEDT,LC_AMOUNT,ARREAR";
		$tableField1  = $screen.'_Customer_open_items';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)>0)
			$c_c=count($exp);
		else
			$c_c=10;
		$_SESSION['table_todays_count']=$c_c; 	
		return $c_c;	
	}	
}