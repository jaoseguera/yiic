<?php
class Submit_returnsController extends Controller
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
	public function actionSubmit_returns()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new UploadForm;
			Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionGetusers()
    {
		if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				Yii::app()->controller->renderPartial('user', array('model' => $model, 'edit_user' => $_POST['User']));
			}
        }
	}
	
    public function actionSpreadsheet()
    {
		global $rfc,$fce;
        if(Yii::app()->user->hasState("login"))
        {
		date_default_timezone_set("America/Los_Angeles");
		$userid		= Yii::app()->user->getState("user_id");
		$client	 = Controller::userDbconnection();
		$userdoc = $client->getDoc($userid);
		$fn='';
		$date=date("mdYHis");
		$strdoc= Controller::couchDbconnection();
		$doc= $strdoc->getDoc("table_headers");
		$fieldInfo=array();
		$model = new UploadForm;
		if(isset($_POST))
		{
			
			$Version=isset($doc->ZSTR_RETURNS->VERSION)?$doc->ZSTR_RETURNS->VERSION:'';
			$CUSTID=isset($userdoc->soldtoid)?(($userdoc->soldtoid=='')?$_POST['SOLDTOID']:$userdoc->soldtoid):'';
			if($userdoc->profile->roles=='emg_retailer')
				$CTYPE='RTLR';
			elseif($userdoc->profile->roles=='emg_retailer_service')	
				$CTYPE='RSVC';
			else	
				$CTYPE='CSVC';
				
			$b = new Bapi();
			//$b->bapiCall('ZEMG_RETURNS_INPUT');
			$bapiName = Controller::Bapiname('submit_returns');
			$b->bapiCall($bapiName);
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$res = $fce->invoke(["I_VERSION"=>$Version,
								"I_KUNNR"=>str_pad($CUSTID,10,'0',STR_PAD_LEFT),
								"I_CUSTTYPE"=>$CTYPE,
								"I_THINUIID"=>$userid],$options);
			$msg=$res['E_BAPI_RETURNS'];
			if($msg['MESSAGE']!='Enter the data in mandatory fields')
			{
			//if(isset($msg['MESSAGE_V1']) && ($msg['MESSAGE_V1']!='')) 
			if($msg['MESSAGE_V1']!='')
			{
				$Version=$msg['MESSAGE_V1'];
				$fieldInfo=$this->techDescription($Version);
				$doc->ZSTR_RETURNS=$fieldInfo;
				$strdoc->storeDoc($doc);
			}else
			{
				echo $msg['MESSAGE'];
				exit;
			}
			} 
			
			$uploadFile = CUploadedFile::getInstance($model, 'file');
			$fileName = "{$uploadFile}";
			$model->file = $fileName;
			$path=Yii::app()->basePath.DS;
			$fpath='upload'.DS.$fileName;
			$uploadFile->saveAs($path.$fpath);
			include_once ($path.'extensions'.DS.'excel'.DS.'PHPExcel'.DS.'IOFactory.php');
$files=$path.$fpath;
			
try {
    $inputFileType = PHPExcel_IOFactory::identify($files);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($files);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($files, PATHINFO_BASENAME) 
    . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

$hrow='';
			
			if($highestRow==0 && $highestColumn==0)
			{
			echo "Please select valid .xls or .xlsx file for Upload Data.:bad";
			unlink($path.$fpath);
			exit;			
			}
			$arrays=array();
			foreach($doc->ZSTR_RETURNS as $k=>$v)
			{
			$arrays[]=$v;
			}
			$arrays=array_map('strtolower', $arrays);
			for ($row = 1; $row <= $highestRow; $row++) {
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
										NULL, TRUE, FALSE);
			$hvals=$rowData[0][0];							
			//foreach($rowData[0] as $k=>$v)
				//echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />";
		if(in_array(strtolower($hvals),$arrays))
			{
				$hrow=$row;
				$row=$highestRow+1;
			}
			}
			if ($hrow=='')
			{
				echo "This file does not have valid column headers, Please upload file with proper column headers.:bad";
				unlink($files);
				exit;
			}else			
				$x=$hrow;
			
			$tr='';
			$header=array();
			$h_values=array();
			$excelData=array();
			$tec_value=array();
			$tec_values=array();
			$tec_name=array();
			$yv='';
			
for ($row = $x; $row <= $highestRow; $row++) {
$values=array();
$tech_values=array();
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
    NULL, TRUE, FALSE);
    foreach($rowData[0] as $k=>$v)
	{
	
						if($row==$hrow)
					{
						if(in_array(strtolower($v),$arrays))
							array_push($header,strtolower($v));
						else
						{
							echo "This file does not have valid column headers, Please upload file with proper column headers.:bad";
							unlink($files);
							exit;
						}		
					}else
						array_push($values,$v);
					//unset($cell);
					
					}
					if($row>$hrow)
					{
						$tec_value=array_combine($header,$values);
						array_push($h_values,$tec_value);
					}
					
				}
				
				
				unlink($files);
		if(count($h_values)==0)
		{
			echo "File has no data.:bad";
			exit;
		}		
		//unlink($path.$fpath);
		$b = new Bapi();
		//$b->bapiCall('ZEMG_RETURNS_INPUT');
		$bapiName = Controller::Bapiname('submit_returns');
			$b->bapiCall($bapiName);
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$importTableReturnsInput = array();
		$options = ['rtrim'=>true];

		$co=count((array)$h_values);
		for($i=0;$i<$co;$i++){
			foreach($doc->ZSTR_RETURNS as $tec=>$des){
				if($tec!='VERSION'){
					$tec_values[$tec]=isset($h_values[$i][strtolower($des)])?strval($h_values[$i][strtolower($des)]):'';					
					//GEZG 08/13/2018
					//Parsing data types to match BAPI's structure
					$tec_values["ZQUANTITY"] = floatval($tec_values["ZQUANTITY"]); 
					$tec_values["ZAMOUNT"] = floatval($tec_values["ZAMOUNT"]); 
					$tec_values["ZIP"] = (string)$tec_values["ZIP"];
					$tec_values["ZPURCHASE_PRICE"] = (string)$tec_values["ZPURCHASE_PRICE"];
					$tec_values["ZPHONE1"] = (string)$tec_values["ZPHONE1"]; 
				}
				$status=true;				
			}			
			array_push($importTableReturnsInput, $tec_values);
		}		
			
		$msg='';
		if($status==true)
			{
			$res = $fce->invoke(["I_VERSION"=>$Version,
									"I_KUNNR"=>str_pad($CUSTID,10,'0',STR_PAD_LEFT),
									"I_CUSTTYPE"=>$CTYPE,
									"I_THINUIID"=>$userid,
									"T_RETURNS_INPUT"=>$importTableReturnsInput],$options);			
			$msg = $res['E_BAPI_RETURNS'];			
			if($CTYPE=='CSVC')
				$errors=$res['T_RETURNS_CSVC'];
			elseif($CTYPE=='RTLR')
				$errors=$res['T_RETURNS_RTLR'];
			else
				$errors=$res['T_RETURNS_RSVC'];
				
   				$file=$this->Errortable($doc->ZSTR_RETURNS,$msg['TYPE'],$errors,$fileName,$CUSTID);
				echo $msg['MESSAGE'].':'.$file.':ERROR';
			
			
			}
		
		
		
	}else
		{
		echo 'This file does not have valid column headers, Please upload file with proper column headers.:SUCCESS';
		exit;
		}
	}else{
            echo 'Your Session has been expired, Please login again and Try.:SUCCESS';
        }
    }
	
	public function actionSysdetail()
	{
	$client 	= Controller::companyDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$doc		= $client->getDoc($Company_ID);
	$str='<table>';
		
	foreach($val=$doc->host_id->$_REQUEST['id'] as $key=>$val)
	{
		if($key<>'')
			$str=$str.'<tr><td>'.$key.' : </td><td>'.$val.'</td></tr>';
	}
	$str=$str.'</table>';
	echo $str;
	}
	public function techDescription($version)
	{
			global $fce;
			$b = new Bapi();
			$b->bapiCall('DDIF_FIELDINFO_GET');
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$res = $fce->invoke(["TABNAME"=> 'ZSTR_RETURNS',
								"FIELDNAME"=> "",
								"LANGU"=> "EN",
								"LFIELDNAME"=> "",
								"ALL_TYPES"=> "",
								"GROUP_NAMES"=> "",
								"UCLEN"=> "00"],$options);
						
			$result = $res['DFIES_TAB'];
			$disp = "";
			$keys = array();
			$vals=array();
			$len=array();
			$values=array();
			array_push($keys,'VERSION');
			array_push($vals,$version);
			$fieldInfo=array();
			foreach($result as $key=>$val)
			{
			array_push($keys,$val['FIELDNAME']);
			//$values['desc']=$val['FIELDTEXT'];
			//$values['len']=$val['LENG'];
			array_push($vals,$val['FIELDTEXT']);
			
			}
		$fieldInfo=array_combine($keys,$vals);
		return $fieldInfo;
	}
	public function actionErrorexcel()
	{
		$file=Yii::app()->basePath.DS.'upload'.DS.$_REQUEST['url'];
		$s=basename($file);
		//$file=Yii::app()->basePath.'\upload\error.xlsx';
		$filecontent = file_get_contents($file);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$s.'"');
		header('Cache-Control: max-age=0');
		echo $filecontent;
		unlink($file);
	
	
	}
	public function Errortable($Desc,$type,$errors,$fna,$CUSTID)
	{
		date_default_timezone_set("America/Los_Angeles");
		$objPHPExcel = new PHPExcel();
		$styleThickBrownBorderOutline = array('font'=> array('bold'	=> true));
		$color1= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFFF00')));
		$color2= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D6D6C2')));
		$color3= array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00BFFF')));
		$Sheet = new PHPExcel_Worksheet($objPHPExcel);
		$objPHPExcel->addSheet($Sheet);
		$header=array();
		//array_push($head,'SAP Status');
		foreach($Desc as $tec=>$des)
		{
		if($tec!='VERSION')
			array_push($header,$des);
		}
		$count=count((array)$errors);
		//$Sheet->fromArray($head, null, 'A2');
		$objPHPExcel->removeSheetByIndex(0);
		$objPHPExcel->setActiveSheetIndex(0);
		$columnLetter = PHPExcel_Cell::stringFromColumnIndex($count-1); 
		for($col = 'A'; $col !==$columnLetter; $col++) 
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
		}
		
		
		$column=0;
		$row=2;
		$er='';
		if(count((array)$errors>1))
		{
		foreach($errors as $key=>$val)
		{
		$column=0;
		foreach($val as $key1=>$val1)
		{
		//if($key1=='ZSTATUS_SAP_TEXT' && $val1!='')
			//$er=$er.','.$val1;
				$hv=$Desc->$key1;
				//$val1=($val1=='00000000'?'':$val1);
				$Sheet->setCellValueExplicitByColumnAndRow($column, $row,$val1,PHPExcel_Cell_DataType::TYPE_STRING);
				$Sheet->setCellValueByColumnAndRow($column,1,$hv);
				$Sheet->getStyleByColumnAndRow($column, 1)->applyFromArray($styleThickBrownBorderOutline);
				$column=$column+1;
			
		}
		$row=$row+1;
		}
		}else
		{
		foreach($errors as $key=>$val)
		{
			$hv=$Desc->$key;
				$Sheet->setCellValueExplicitByColumnAndRow($column, $row,$val1,PHPExcel_Cell_DataType::TYPE_STRING);
				$Sheet->setCellValueByColumnAndRow($column,1,$hv);
				$Sheet->getStyleByColumnAndRow($column, 1)->applyFromArray($styleThickBrownBorderOutline);
				$column=$column+1;
			
		}
		}
		//$Sheet->fromArray($errors, null, 'A2');
		$c3= PHPExcel_Cell::stringFromColumnIndex($column-1);
		$Sheet->getStyle('A1:'.$c3.'1')->applyFromArray($color3);
		for($col = 1; $col <$column; $col++) 
		{
			$cols=PHPExcel_Cell::stringFromColumnIndex($col);
			$objPHPExcel->getActiveSheet()->getColumnDimension($cols)->setAutoSize(true);
		} 
		$date=date("mdYHis");
		$fna=explode('.',$fna);
		$fpath=Yii::app()->basePath.DS.'upload'.DS.$fna[0];
		if($type=='S')
			$file = $fpath.'-Out-'.$CUSTID.'-'.$date.'.xlsx';
		else
			$file = $fpath.'-Err-'.$CUSTID.'-'.$date.'.xlsx';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($file);
		return basename($file);
	}
	public function excelLetter($num)
	{
		return PHPExcel_Cell::stringFromColumnIndex($num);
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