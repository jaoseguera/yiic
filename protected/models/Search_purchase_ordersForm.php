<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_purchase_ordersForm extends CFormModel
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
		$PURCHASE_ORDER = "";
		$pur_grp  = "";
		$vender   = "";
		$MATERIAL = "";
		$open_pur_ord = "";
		$PURCHASE_ORDER = strtoupper($_REQUEST['PURCHASE_ORDER']);
		$pur_grp = strtoupper($_REQUEST['pur_grp']);
		$vender = strtoupper($_REQUEST['vendor']);
		$cusLenth = count($vender);
		if($cusLenth < 10 && $vender != "") { $vender = str_pad((int) $vender, 10, 0, STR_PAD_LEFT); } else { $vender = substr($vender, -10); }
		
		$MATERIAL = strtoupper($_REQUEST['MATERIAL']);
		$open_pur_ord = ($_REQUEST['open_pur_ord']!=null?$_REQUEST['open_pur_ord']:"");
		//GEZG 06/22/2018
		//Changing SAPRFC methods		
		$options = ['rtrim'=>true];
		$res = $fce->invoke(['PURCHASEORDER'=> $PURCHASE_ORDER,
							'DOC_TYPE'=> "NB",
							'DOC_DATE'=> '00000000',
							'PUR_GROUP'=> $pur_grp,
							'PURCH_ORG'=> '',
							'VENDOR'=> $vender,
							'SUPPL_PLANT'=> '',
							'MATERIAL'=> $MATERIAL,
							'MAT_GRP'=> '',
							'ITEM_CAT'=> '',
							'ACCTASSCAT'=> '',
							'PLANT'=> '',
							'TRACKINGNO'=> '',
							'SHORT_TEXT'=> '',
							'CREATED_BY'=> '',
							'PREQ_NAME'=> '',
							'WITH_PO_HEADERS'=> 'X',
							'DELETED_ITEMS'=> '',
							'ITEMS_OPEN_FOR_RECEIPT'=> $open_pur_ord],$options);
		
		$SalesOrder3 = $res['PO_HEADERS'];
		$SalesOrder1 = $res['PO_ITEMS'];
		$SalesOrder2 = $res['RETURN'];
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;			
		$table_inf  = "PO_NUMBER,CREATED_ON,CREATED_BY,VENDOR,PURCH_ORG,";
		$labels_inf = "PO_NUMBER,CREATED_ON,CREATED_BY,VENDOR,PURCH_ORG,";
		$tableField1 = $screen.'_search_purchase_orders';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp   = explode(',', $labels_inf);
		if(count($exp>0))
		$_SESSION['table_today_count']=count($exp)-1;
		else
		$_SESSION['table_today_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}

		foreach ($SalesOrder3 as $val_t => $retur)
		{
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}

		$_SESSION['table_today'] = $SalesOrder;
		$rowsag1 = count($SalesOrder);
		$comp = 10;
		if ($rowsag1 < 10)
		{
			$comp = $rowsag1;
		}
	}
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "PO_NUMBER,CREATED_ON,CREATED_BY,VENDOR,PURCH_ORG,";
            $labels_inf        = "PO_NUMBER,CREATED_ON,CREATED_BY,VENDOR,PURCH_ORG,";
		$tableField1  = $screen.'_search_purchase_orders';
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
		$_SESSION['table_today_count']=$c_c; 	
		return $c_c;	
	}
}