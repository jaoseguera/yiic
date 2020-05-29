<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Document_flowForm extends CFormModel
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
		if($_REQUEST['from'] == 'submit')
		{
			$doc_num = $_REQUEST['DOCUMENT_NUMBER'];
			$cusLenth = count($doc_num);
			if($cusLenth < 10 && $doc_num!='')
				$doc_num = str_pad((int) $doc_num, 10, 0, STR_PAD_LEFT);
			else
				$doc_num = substr($doc_num, -10);
			$item_num = $_REQUEST['ITEM_NUMBER'];
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			if($item_num == ""){$item_num = '000000'; }
			$res = $fce->invoke(['I_DOCNUM'=> $doc_num,
								'I_ITEMNUM'=>$item_num],$options);
		
			
			$SalesOrders = $res['ET_DOCFLOW_HEADER'];
			$Docflow_items = $res['ET_DOCFLOW_ITEM'];
			unset($Docflow_items[0]);
			$_SESSION['Docflow_items'] = $Docflow_items;
			$table_inf  = "DOCNUM,DOCTYPE,MATNR,RFMNG,STATUS,";
			$labels_inf ="DOCNUM,DOCTYPE,MATNR,RFMNG,STATUS,";
			$tableField1  = $screen.'_Document_flow_header';
		}
		else
		{
			$SalesOrders = $_SESSION['Docflow_items'];
			$table_inf  = "DOCNUM,DOCTYPE,MATNR,RFMNG,STATUS,";
			$labels_inf = "DOCNUM,DOCTYPE,MATNR,RFMNG,STATUS,";
			$tableField1  = $screen.'_Document_flow_items';
		}
		
		//////////////////////////////////////////////////////////////////////////////////
		$sd = 1;
		if(isset($doc->customize->$tableField1->Table_order))
		{
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp>0))
		$_SESSION[$_REQUEST['table'].'_count']=count($exp)-1;
		else
		$_SESSION[$_REQUEST['table'].'_count']=11;
		if(count($exp)<11)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		foreach ($SalesOrders as $val_t => $retur)
		{
			$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]],$exp[3] => $retur[$exp[3]], 
			$exp[4] => $retur[$exp[4]]);
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
			$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $today);
			$sd++;
		}
		//................................................................................
		$_SESSION[$_REQUEST['table']]=$SalesOrder;
		$rowsag1 = count($SalesOrder);
	}
	 public function _actionColumncount($doc, $screen)
    {
	     $table_inf  = "VBELN,KUNNR,AUDAT,NETWR,WAVWR,";
		$labels_inf = "VBELN,KUNNR,AUDAT,NETWR,WAVWR,";
		$tableField1  = $screen.'_Document_flow_items';
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