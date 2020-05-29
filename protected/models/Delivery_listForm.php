<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Delivery_listForm extends CFormModel
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
	 
			
			$customer = NULL;
			$material = NULL;
			$delivery = NULL;
			$to_delivery = NULL;
			$status   = NULL;
			$checked  = NULL;	
			
			$customer = strtoupper($_REQUEST['customer']);
			$cusLenth = count($customer);
			if ($cusLenth < 10 && $customer != '') {
				$customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT);
			} else {
				$customer = substr($customer, -10);
			}
			$material = strtoupper($_REQUEST['material']);
			$delivery = strtoupper($_REQUEST['Delivery']);
			$to_delivery = strtoupper($_REQUEST['To_Delivery']);

			$date = "";
			if (isset($_REQUEST['status_goods'])) {
				$status = $_REQUEST['status_goods'];
				$checked = "CHECKED";
			}
			//GEZG 06/21/2018
			//Changing SAPRFC methods
			$IS_DLV_DATA_CONTROL = array("BYPASSING_BUFFER" => "", "HEAD_STATUS" => "", "HEAD_PARTNER" => "", "ITEM" => "X", "ITEM_STATUS" => "", "DOC_FLOW" => "", "FT_DATA" => "", "HU_DATA" => "", "SERNO" => "");
			$importTableMaterial = array();
			if ($material != NULL) {
				$IT_MATNR = array("SIGN" => "I", "OPTION" => "EQ", "MATERIAL_LOW" => $material);
				array_push($importTableMaterial, $IT_MATNR);
			}		
			$importTableCustomer = array();	
			if ($customer != NULL) {
				$IT_KUNN2 = array("SIGN" => "I", "OPTION" => "EQ", "CUSTOMER_LOW" => $customer);
				array_push($importTableCustomer, $IT_KUNN2);
			}
			$importTableDelivery = array();
			if ($delivery != NULL || $to_delivery != NULL) {
				$date = "";
				$to_date = "";
				$date_one = explode('/', $delivery);
				$date = $date_one[2] . $date_one[0] . $date_one[1];
				$date_two = explode('/', $to_delivery);
				$to_date = $date_two[2] . $date_two[0] . $date_two[1];
				
				if($date != "" && $to_date == "")
					$IT_LFDAT = array("SIGN" => "I", "OPTION" => "EQ", "DELIV_DATE_LOW" => $date);
				else
					$IT_LFDAT = array("SIGN" => "I", "OPTION" => "BT", "DELIV_DATE_LOW" => $date, "DELIV_DATE_HIGH" => $to_date);
				array_push($$importTableDelivery, $IT_LFDAT);
			}
			$importTableStatus = array();
			if ($status != NULL) {
				$IT_WBSTK = array("SIGN" => "I", "OPTION" => "NE", "OVERALL_STATUS_GOODS_MOVEM_LOW" => $status);
				array_push($importTableStatus, $IT_WBSTK);
			}
			$options = ['rtrim'=>true];
			$res = $fce->invoke(['IS_DLV_DATA_CONTROL'=>$IS_DLV_DATA_CONTROL,
						'IT_MATNR'=>$importTableMaterial,
						'IT_KUNN2'=>$importTableCustomer,
						'IT_LFDAT'=>$importTableDelivery,
						'IT_WBSTK'=>$importTableStatus],$options);			
			$SalesOrder = $res['ET_DELIVERY_HEADER'];
			$SalesOrder1 = $res['ET_DELIVERY_ITEM'];	
			
			//print_r($SalesOrder);
			//print_r($SalesOrder1);	
			//////////////////////////////////////////////////////////////////////////////////
			//$doc = $client->getDoc($userid);
			//////////////////////////////////////////////////////////////////////////////////	
			$ds = 1;
			$ss = 1;			
			$table_deliv  = "VBELN,ERDAT,WADAT,KUNNR,KUNAG,";
			$labels_deliv = "VBELN,ERDAT,WADAT,KUNNR,KUNAG,";
			$tableField1  = $screen.'_Delivery_list';
			if(isset($doc->customize->$tableField1->Table_order))
			{			
				$labels_deliv=$doc->customize->$tableField1->Table_order;
			}			
			
			$exps1 = explode(',',$table_deliv);
			$exp = explode(',', $labels_deliv);
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
			
			foreach ($SalesOrder as $val => $bill) {
				$order_b = array($exp[0] => $bill[$exp[0]], $exp[1] => $bill[$exp[1]], $exp[2] => $bill[$exp[2]], $exp[3] => $bill[$exp[3]], $exp[4] => $bill[$exp[4]]);
				unset($bill[$exp[0]], $bill[$exp[1]], $bill[$exp[2]], $bill[$exp[3]], $bill[$exp[4]]);
				$billing = $bill;
				$result[$ss] = array_merge((array) $order_b, (array) $billing);
				$ss++;
			}
			foreach ($SalesOrder1 as $values) {

				$as = array('VBELN' => $values['VBELN'], 'POSNR' => $values['POSNR'], 'MATNR' => $values['MATNR'], 'LFIMG' => $values['LFIMG'], 'MEINS' => $values['MEINS']);
				$un[$values['VBELN']][] = array('VBELN' => $values['VBELN'], 'POSNR' => $values['POSNR'], 'MATNR' => $values['MATNR'], 'LFIMG' => $values['LFIMG'], 'MEINS' => $values['MEINS'], 'WERKS' => $values['WERKS']);
			}
			//echo 'jshds';
			$_SESSION['VBE'] = $un;			
			$_SESSION['table_today'] = $result;
			//print_r($result);
			$rowsag1 = count($result);
			
			if ($rowsag1 >= 10) {
				$row = 10;
			} else {
				$row = $rowsag1;
			}
		
	}
    public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "VBELN,ERDAT,WADAT,KUNNR,KUNAG,";
            $labels_inf = "VBELN,ERDAT,WADAT,KUNNR,KUNAG,";
		$tableField1  = $screen.'_Delivery_list';
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