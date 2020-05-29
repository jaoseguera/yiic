<?php
// This is a Proof-of-Concept version that has not been reviewed.
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Review_status_customersmasterForm extends CFormModel
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
		$userId = isset($_REQUEST['Users'])?$_REQUEST['Users']:'';
		$objectType='CUSTOMER';
		$status=isset($_REQUEST['Status'])?$_REQUEST['Status']:'';
		$fDate=$_REQUEST['F_DATE'];
		$tDate=$_REQUEST['T_DATE'];
		$FD=explode('/',$fDate);
		$TD=explode('/',$tDate);
		$FD = $FD[2].$FD[0].$FD[1];
		$TD = $TD[2].$TD[0].$TD[1];
		if($FD == ""){$FD = "00000000";}			
		if($TD == ""){$TD = "00000000";}			
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$importTableUDATE = array();

		if($FD != '00000000')
		{			
			$RANGE  = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$FD,"HIGH"=>$TD);
			//$RANGE  = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$fDate,"HIGH"=>$tDate);
			array_push($importTableUDATE, $RANGE);			
		}
		$res = $fce->invoke(["I_THINUI_USER"=> $userId,
							"I_OBJECTTYPE"=>$objectType,
							"I_STATUS"=>$status,
							"ET_UDATE"=>$importTableUDATE],$options);

		$SalesOrders  = $res['ET_CREATE'];				

		$table_inf  = "CHANGENR,OBJECTID,TRANSACTIONTYPE,THINUI_USER,UDATE,THINUI_APPROVER,STATUS";
		$labels_inf = "CHANGENR,OBJECTID,TRANSACTIONTYPE,THINUI_USER,UDATE,THINUI_APPROVER,STATUS";
		$tableField1  = $screen.'_Approve_customers_master';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)<8)
		{
			for($j=count($exp)-1;$j<count($exps1);$j++)
			{
				$exp[$j]=$exps1[$j];
			}
		}
		$sd=1;
		foreach ($SalesOrders as $val_t => $retur) {
			$order_t = array($exp[0] => trim($retur[$exp[0]]), $exp[1] => trim($retur[$exp[1]]), $exp[2] => trim($retur[$exp[2]]),$exp[3] => trim($retur[$exp[3]]),$exp[4] => trim($retur[$exp[4]]),$exp[5] => trim($retur[$exp[5]]),$exp[6] => trim($retur[$exp[6]]));
			unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]],$retur[$exp[5]],$retur[$exp[6]]);
			//$today = $retur;
			$SalesOrder[$sd] = array_merge((array) $order_t, (array) $retur);
			
			$sd++;
			
		}
		
		$_SESSION['example40_today'] = $SalesOrder;
		$rowsag1  = count($SalesOrder);
		
	}
	public function _actionDetails($doc, $screen, $fce)
    {
		$userId = isset($_REQUEST['Users'])?$_REQUEST['Users']:'';
		$fDate=$_REQUEST['F_DATE'];
		$tDate=$_REQUEST['T_DATE'];
		$FD=explode('/',$fDate);
		$TD=explode('/',$tDate);
		$FD = $FD[2].$FD[0].$FD[1];
		$TD = $TD[2].$TD[0].$TD[1];
		if($FD == ""){$FD = "00000000";}
		if($TD == ""){$TD = "00000000";}
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$importTableUDATE = array();
				
		$RANGE  = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$FD,"HIGH"=>$TD);
		array_push($importTableUDATE, $RANGE);
		$customer=$_REQUEST['cust'];
			$cusLenth = count($customer);
		if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }				
		$res = $fce->invoke(["I_THINUI_USER"=>$userId,
							'ET_UDATE'=>$importTableUDATE,
							"I_CHANGENR"=>$customer
							],$options);
		
		$hdr = $res['ET_CREATE'];
		$item=$res['ET_CHANGE'];
		//$items[]=array();
		foreach($item as $h=>$d)
		{
		$items[$d['FNAME']]=array('NEW'=>$d['VALUE_NEW'],'OLD'=>$d['VALUE_OLD']);
		}
		$_SESSION['HDR']=$hdr;
		$_SESSION['ITEM']=$items;
	}	
}