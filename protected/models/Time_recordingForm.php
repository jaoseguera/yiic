<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Time_recordingForm extends CFormModel
{
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
		$po_order = $_REQUEST['Production_Order'];
		$poLenth = count($po_order);
		if($poLenth < 12 && $po_order!='') { $po_order = str_pad((int) $po_order, 12, 0, STR_PAD_LEFT); } else { $po_order = substr($po_order, -12); }
		$emp_id   = $_REQUEST['Employee_ID'];
		$empLenth = count($emp_id);
		if($empLenth < 8 && $emp_id!='') { $emp_id = str_pad((int) $emp_id, 8, 0, STR_PAD_LEFT); } else { $emp_id = substr($emp_id, -8); }
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(['I_PROD_ORDER_NUM'=> $po_order,
							'I_EMPLOYEE_ID'=> $emp_id],$options);		
		
		$Started		= $res['ET_OPERATIONS_STARTED'];
		$Canbestarted	= $res['ET_OPERATIONS_CANBESTARTED'];
		$Completed		= $res['ET_OPERATIONS_COMPLETED'];
		$Message		= $res['ET_MESSAGES'];
		
		if($Message[0]['TYPE']=='E')
			return $Message[0]['MESSAGE'];
		
		// print_r($Message);
		// $po_order = ltrim($po_order, 0);
		// $emp_id   = ltrim($emp_id, 0);
		
		// $status['Messages'] 		= $Message;
		$status['Start'] 			= $Started;
		if(!empty($Started)):
			$status['Start']['PROD'] 	= $po_order;
			$status['Start']['EMP'] 	= $emp_id;
		endif;
		
		$status['Stop'] 			= $Canbestarted;
		if(!empty($Canbestarted)):
			$status['Stop']['PROD'] 	= $po_order;
			$status['Stop']['EMP'] 		= $emp_id;
		endif;
		
		/*
		if(!empty($Completed)):
			$status['Complete'] 		= $Completed;
			$status['Complete']['PROD'] = $po_order;
			$status['Complete']['EMP'] 	= $emp_id;
		endif;
		*/
		
		if(empty($status['Start']) && empty($status['Stop']))
			$status = "No Operations are available for this PO Number.";
		else
		{
			foreach($status as $key => $val)
			{
				if(is_array($val))
				{
					foreach($val as $key1 => $val1)
					{
						if(strpos($val1['OPR_CNTRL_KEY'], 'PM') !== false || strpos($val1['OPR_CNTRL_KEY'], 'QM') !== false)
							unset($status[$key][$key1]);
					}
				}
			}
		}
		// $_SESSION['table_todays'] = $SalesOrders;
		return $status;
	}
	
	public function _actionOperation($doc, $screen, $fce)
    {
		$po_order = $_REQUEST['po_order'];
		$poLenth = count($po_order);
		if($poLenth < 12 && $po_order!='') { $po_order = str_pad((int) $po_order, 12, 0, STR_PAD_LEFT); } else { $po_order = substr($po_order, -12); }
		$emp_id   = $_REQUEST['emp_id'];
		$empLenth = count($emp_id);
		if($empLenth < 8 && $emp_id!='') { $emp_id = str_pad((int) $emp_id, 8, 0, STR_PAD_LEFT); } else { $emp_id = substr($emp_id, -8); }
		
		$choice		= $_REQUEST['choice'];
		/*
		$start		= $_REQUEST['operations_start'];
		$stop		= $_REQUEST['operations_stop'];
		$complete	= $_REQUEST['operations_complete'];
		*/
		$start		= $_REQUEST['operation_id'];
		$stop		= $_REQUEST['operation_id'];
		$complete	= $_REQUEST['operation_id'];
		$quantity	= $_REQUEST['yield'];
		
		if(!empty($start) && $choice == "Start")
		{
			$oper_num = $start;
			$action	  = "S";
		}
		elseif(!empty($stop) && $choice == "Stop")
		{
			$oper_num = $stop;
			$action	  = "P";
		}
		elseif(!empty($complete) && $choice == "Complete")
		{
			$oper_num = $complete;
			$action	  = "C";
		}
		$oper_numLenth = count($oper_num);
		if($oper_numLenth < 4 && $oper_num!='') { $oper_num = str_pad((int) $oper_num, 4, 0, STR_PAD_LEFT); } else { $oper_num = substr($oper_num, -4); }
		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		
		if($action == "C"){
			$params = ['I_PROD_ORDER_NUM'=> $po_order,
					'I_OPERATION_NUM'=> $oper_num,
					'I_EMPLOYEE_ID'=> $emp_id,
					'I_ACTION'=> $action, 
					'I_QUANTITY'=>$quantity];		
		}
		else{
			$params = ['I_PROD_ORDER_NUM'=> $po_order,
					'I_OPERATION_NUM'=> $oper_num,
					'I_EMPLOYEE_ID'=> $emp_id,
					'I_ACTION'=> $action];	
		}
		$options = ['rtrim'=>true];
		$res = $fce->invoke($params,$options);			
		
		$SalesOrder = $res['ET_MESSAGES'];	
		//print_r($SalesOrder);
		$mm=NULL;
		foreach($SalesOrder as $msg)
		{
			$mm.= $msg['MESSAGE']."<br>";
		}
		echo $mm;
	}
    
}