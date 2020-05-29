<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_purchase_requisitionForm extends CFormModel
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
		$PUR_GROUP = "";
		$MATERIAL = "";
		$PLANT = "";
		$PUR_GROUP = strtoupper($_REQUEST['PUR_GROUP']);
		$MATERIAL = strtoupper($_REQUEST['MATERIAL']);
		$PLANT = strtoupper($_REQUEST['PLANT']);
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		// ASSIGNED_ITEMS = 'X', CLOSED_ITEMS = 'X', DELETED_ITEMS = 'X', PARTICALLY_ORDERED_ITEMS = 'X', OPEN_ITEMS = 'X'		
		$res = $fce->invoke(["PUR_GROUP"=> $PUR_GROUP,
							"MATERIAL"=> $MATERIAL,
							"PLANT"=> $PLANT,
							"ASSIGNED_ITEMS"=> 'X',
							"CLOSED_ITEMS"=> 'X',
							"DELETED_ITEMS"=> 'X',
							"PARTIALLY_ORDERED_ITEMS"=> "X",
							"OPEN_ITEMS"=> "X"],$options);
		
				
		$REQUISITION_ITEMS3 = $res['REQUISITION_ITEMS'];
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;			
		$table_inf  = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$labels_inf = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$tableField1 = $screen.'_Search_purchase_requisition';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
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

		foreach ($REQUISITION_ITEMS3 as $val_t => $retur)
		{
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$REQUISITION_ITEMS[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		$_SESSION['table_today'] = $REQUISITION_ITEMS;
		$rowsag1 = count($REQUISITION_ITEMS);
		if ($rowsag1 <= 10)
			$rows_l = $rowsag1 - 1;
		else
			$rows_l = 10;
	}
	
	public function _actionSubmitRel($doc, $screen, $fce)
    {		
		
		$REQ_NUMBER	= "";
		$PUR_GROUP 	= "";
		$MATERIAL 	= "";
		$PLANT 		= "";
		$REL_GROUP 	= "";
		$REL_CODE	= "";
		
		$REQ_NUMBER	= strtoupper($_REQUEST['REQ_NUMBER']);
		$PUR_GROUP 	= strtoupper($_REQUEST['PUR_GROUP']);
		$MATERIAL 	= strtoupper($_REQUEST['MATERIAL']);
		$PLANT 		= strtoupper($_REQUEST['PLANT']);
		$REL_GROUP 	= strtoupper($_REQUEST['REL_GROUP']);
		$REL_CODE 	= strtoupper($_REQUEST['REL_CODE']);
		
		$codeLenth = count($REQ_NUMBER);
		if($codeLenth < 10 && $REQ_NUMBER != "") { $REQ_NUMBER = str_pad((int) $REQ_NUMBER, 10, 0, STR_PAD_LEFT); } else { $REQ_NUMBER = substr($REQ_NUMBER, -10); }
		
		$codeLenth = count($REL_CODE);
		if($codeLenth < 2 && $REL_CODE != "") { $REL_CODE = str_pad((int) $REL_CODE, 2, 0, STR_PAD_LEFT); } else { $REL_CODE = substr($REL_CODE, -2); }
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["I_PREQ_NUM"=> $REQ_NUMBER,
							"I_PUR_GROUP"=> $PUR_GROUP,
							"I_MATERIAL"=> $MATERIAL,
							"I_PLANT"=> $PLANT,
							"I_REL_GROUP"=> $REL_GROUP,
							"I_REL_CODE"=> $REL_CODE,
							"I_ITEMS_FOR_RELEASE"=> "X"],$options);
			
		$REQUISITION_ITEMS3 = $res['ET_PR_ITEMS'];
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;			
		$table_inf  = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$labels_inf = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$tableField1 = $screen.'_Search_purchase_requisition_Rel';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
		$_SESSION['table_deliv_PO_count']=count($exp)-1;
		else
		$_SESSION['table_deliv_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}

		foreach ($REQUISITION_ITEMS3 as $val_t => $retur) {
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$REQUISITION_ITEMS[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		$_SESSION['table_deliv'] = $REQUISITION_ITEMS;
		$rowsag1 = count($REQUISITION_ITEMS);
		if ($rowsag1 <= 10) {
			$rows_l = $rowsag1 - 1;
		} else {
			$rows_l = 10;
		}
	}
	
	public function _actionSubmitPO($doc, $screen, $fce)
    {
		
		$PUR_GROUP 	= "";
		$MATERIAL 	= "";
		$PLANT 		= "";
		
		$PUR_GROUP 	= strtoupper($_REQUEST['PUR_GROUP']);
		$MATERIAL 	= strtoupper($_REQUEST['MATERIAL']);
		$PLANT 		= strtoupper($_REQUEST['PLANT']);
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["I_PUR_GROUP"=> $PUR_GROUP,
							"I_MATERIAL"=> $MATERIAL,
							"I_PLANT"=> $PLANT],$options);
				
		$REQUISITION_ITEMS3 = $res['ET_PR_ITEMS'];
		//////////////////////////////////////////////////////////////////////////////////	
		$sd = 1;			
		$table_inf  = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$labels_inf = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$tableField1 = $screen.'_Search_purchase_requisition_PO';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf=$doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
		$_SESSION['table_convert_PO_count']=count($exp)-1;
		else
		$_SESSION['table_convert_PO_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}

		foreach ($REQUISITION_ITEMS3 as $val_t => $retur) {
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]], $exp[3] => $retur[$exp[3]], $exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$REQUISITION_ITEMS[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		$_SESSION['table_convert_PO'] = $REQUISITION_ITEMS;
		$rowsag1 = count($REQUISITION_ITEMS);
		if ($rowsag1 <= 10) {
			$rows_l = $rowsag1 - 1;
		} else {
			$rows_l = 10;
		}
	}
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
            $labels_inf        = "PREQ_NO,PREQ_ITEM,DOC_TYPE,PUR_GROUP,CREATED_BY,";
		$tableField1  = $screen.'_Search_purchase_requisition';
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