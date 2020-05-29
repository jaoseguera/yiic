<?php
class Check_returns_status_adminController extends Controller
{
	/**
	* Declares class-based actions.
	*/        
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionCheck_returns_status_admin()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_userForm;
			Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
  public function actionSubmitform()
	{
			global $rfc,$fce;
			$userid		= Yii::app()->user->getState("user_id");
			$client	 = Controller::userDbconnection();
			$userdoc = $client->getDoc($userid);
		
	        if($_REQUEST['user']=='retailer')
				$CTYPE='RTLR';
			elseif($_REQUEST['user']=='retailerservice')	
				$CTYPE='RSVC';
			else	
				$CTYPE='CSVC';
			$CUSTID=isset($userdoc->soldtoid)?($userdoc->soldtoid):$_POST['SOLDTOID'];
			$IF_DT=isset($_REQUEST['FROM_DATE'])?$_REQUEST['FROM_DATE']:'';
			$IT_DT=isset($_REQUEST['TO_DATE'])?$_REQUEST['TO_DATE']:'';
			$IRTR_ST=isset($_REQUEST['Retailer_store'])?$_REQUEST['Retailer_store']:'';
			$IML_NO=isset($_REQUEST['Model_number'])?$_REQUEST['Model_number']:'';
			$INV_NO=isset($_REQUEST['Invoice_number'])?$_REQUEST['Invoice_number']:'';
			$ISL_NO=isset($_REQUEST['Serial_number'])?$_REQUEST['Serial_number']:'';
			$IFT_NM=isset($_REQUEST['FIRST_NAME'])?$_REQUEST['FIRST_NAME']:'';
			$ILT_NM=isset($_REQUEST['LAST_NAME'])?$_REQUEST['LAST_NAME']:'';
			$I_RET=isset($_REQUEST['confirm'])?($_REQUEST['confirm']=='RF'?'Refund':($_REQUEST['confirm']=='RP'?'Return for Replacement':($_REQUEST['confirm']=='RR'?'Replacement':'Field Destroy'))):'';
			$b = new Bapi();
			//$b->bapiCall('ZEMG_RETURNS_OUTPUT');
			$bapiName = Controller::Bapiname('check_return_status');
			$b->bapiCall($bapiName);	
			$FD=explode('/',$IF_DT);
			$TD=explode('/',$IT_DT);

			//GEZG 06/21/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$importTableDate = array();
			$RANGE  = array("SIGN"=>"I","OPTION"=>"BT","LOW"=>$FD[2].$FD[0].$FD[1],"HIGH"=>$TD[2].$TD[0].$TD[1]);
			array_push($importTableDate, $RANGE);
			$res=$fce->invoke(["I_KUNNR" => str_pad($CUSTID, 10, '0', STR_PAD_LEFT),
								"I_CUSTTYPE" => $CTYPE,
								"I_INVOICE_NO" => $INV_NO,
								"I_MODEL_NO" => $IML_NO,
								"I_SERIAL_NO" => $ISL_NO,
								"I_RETAILER_STORE" => $IRTR_ST,
								"I_RETURN"=> $I_RET,
								"I_FIRST_NAME"=> $IFT_NM,
								"I_LAST_NAME" => $ILT_NM,
								'I_DATE' => $importTableDate],$options);

						
			if($CTYPE=='CSVC')
				$result=$res['T_RETURNS_CSVC'];
			elseif($CTYPE=='RTLR')
				$result=$res['T_RETURNS_RTLR'];
			else
				$result=$res['T_RETURNS_RSVC'];
				
			$date=date("mdYHis");
			$objPHPExcel = new PHPExcel();
			$styleThickBrownBorderOutline = array('font'=> array('bold'	=> true));
			$color1= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF00')));
			$color2= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D6D6C2')));
			$color3= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00BFFF')));
			$Sheet = new PHPExcel_Worksheet($objPHPExcel);
			$hds=array();
			$objPHPExcel->addSheet($Sheet);
			$objPHPExcel->removeSheetByIndex(0);
			$objPHPExcel->setActiveSheetIndex(0);
			$strdoc= Controller::couchDbconnection();
			$doc= $strdoc->getDoc("table_headers");
			if(isset($result[0]))
			{
			foreach($result[0] as $key=>$val)
			{
			array_push($hds,$doc->ZSTR_RETURNS->$key);
			}
			}
			if(isset($result[0]))
			{
				$Sheet->fromArray($result, null, 'A2');
				$Sheet->fromArray($hds, null, 'A1');
				$i=count($hds);
				$c3= PHPExcel_Cell::stringFromColumnIndex($i-1);
				$Sheet->getStyle('A1:'.$c3.'1')->applyFromArray($color3);
				for($col = 0; $col <$i; $col++) 
				{
					$cols=PHPExcel_Cell::stringFromColumnIndex($col);
					$objPHPExcel->getActiveSheet()->getColumnDimension($cols)->setAutoSize(true);
				} 
				
				$file = Yii::app()->basePath.DS.'upload'.DS.'Output-'.$CUSTID.'-'.$date.'.xlsx';
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($file);
				echo count($result).' Records found.!S!'.basename($file);
			}else
			{
			echo "No Record Found.!F";
			}
	}
    public function actionExcel()
	{
		$file=Yii::app()->basePath.DS.'upload'.DS.$_REQUEST['url'];
		$filecontent = file_get_contents($file);
		$s=$_REQUEST['url'];
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$s);
		header('Cache-Control: max-age=0');
		echo $filecontent;
		//unlink($file);
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
