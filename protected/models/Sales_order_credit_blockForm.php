<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Sales_order_credit_blockForm extends CFormModel
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
    public function _actionSubmit($doc,$screen,$fce)
    {
        
     
			$i_vbeln        = strtoupper($_REQUEST['I_VBELN']);	
			$sales_org      = strtoupper($_REQUEST['SALES_ORGANIZATION']);	
			$partn          = strtoupper($_REQUEST['CUSTOMER_NUMBER']);
			if($i_vbeln>0)
			{
	$docLenth=count($i_vbeln);		
	if($docLenth < 10) { $i_vbeln = str_pad((int) $i_vbeln, 10, 0, STR_PAD_LEFT); } else { $i_vbeln = substr($partn, -10); }	
	}
	if($partn>0)
	{
	$cusLenth=count($partn);		
	if($cusLenth < 10) { $partn = str_pad((int) $partn, 10, 0, STR_PAD_LEFT); } else { $partn = substr($partn, -10); }	
	}
	//GEZG 06/22/2018
    //Changing SAPRFC methods
    $options = ['rtrim'=>true];
    $res = $fce->invoke(["VBELN"=>$i_vbeln,
                        "KKBER"=>$sales_org,
                        "KNKLI"=>$partn],$options);
	
             
		
            
            $SalesOrder=$res['T_CREDBLOCKDOC'];

            $ids=1;	
            $table_labels = "VBELN,ERDAT,CTLPC,AMTBL,CMWAE";
            $labels       = "VBELN,ERDAT,CTLPC,AMTBL,CMWAE";
            $tableField1 = $screen.'_Sales_order_credit_block';
            if(isset($doc->customize->$tableField1->Table_order))
            {			
				$labels=$doc->customize->$tableField1->Table_order;
            }			
            $exps1 = explode(',',$table_labels);
            $exp   = explode(',',$labels);
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
			$sd=1;
			foreach($SalesOrder as $val_t => $retur)
            {
                $order_t = array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>number_format($retur[$exp[2]],2),$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]],$exp[5]=>$retur[$exp[5]],$exp[6]=>$retur[$exp[6]],$exp[7]=>$retur[$exp[7]],$exp[8]=>$retur[$exp[8]],$exp[9]=>$retur[$exp[9]]);
                unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]],$retur[$exp[5]],$retur[$exp[6]],$retur[$exp[7]],$retur[$exp[8]],$retur[$exp[9]]);
                $today=$retur;
                $SalesOrderr[$sd] = array_merge((array)$order_t, (array)$today);
                $sd++;
            }
            //................................................................................
            $_SESSION['table_todays'] = $SalesOrderr;
            $rowsag1 = count($SalesOrderr);
        
    }
	public function _actionColumncount($doc, $screen)
    {
	    $table_inf  = "VBELN,ERDAT,CTLPC,AMTBL,CMWAE";
		$labels_inf = "VBELN,ERDAT,CTLPC,AMTBL,CMWAE";
		$tableField1  = $screen.'_Sales_order_credit_block';
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