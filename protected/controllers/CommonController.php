<?php 
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class CommonController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    
    public function actionSetdeliveryblock()
    {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);            
            echo $model->_actionSetdeliveryblock();
        } else {
            $this->redirect(array('login/'));
        }
    }
	
    public function actionTablemail()
	{
		$userid = Yii::app()->user->getState("user_id");
		$user_name=Yii::app()->user->getState("admin_user");
		$user_mail=$_SESSION['login'];
		$user_name=$_SESSION['userName'];
		$_REQUEST['table_data'];
		$mail_to=$_REQUEST['mail_to'];
		// example on using PHPMailer with GMAIL
		$mail_to=explode(",",$mail_to);
		
		require_once( dirname(__FILE__) . "/../components/phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		
		if(Controller::checkHost())
		{
			$mail->Host       = Yii::app()->params['smtpconfig']['mailhost'];
		}
		else
		{
			$mail->SMTPDebug = 1;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = Yii::app()->params['smtpconfig']['securetype'];
			$mail->Host       = Yii::app()->params['smtpconfig']['host'];
			$mail->Port       = Yii::app()->params['smtpconfig']['port'];
			$mail->Username   = Yii::app()->params['smtpconfig']['username'];
			$mail->Password   = Yii::app()->params['smtpconfig']['password'];
		}
		
		$mail->From       = 'thinui@emergys.com';
		$mail->FromName   = 'thinui';
		$mail->Subject    = str_replace('_',' ',$_REQUEST['name'])." Document from ThinUI";
        $_SESSION['excel_table'] = $_REQUEST['table_data'];
        $_SESSION['table_name'] = $_REQUEST['name'] . '_'.str_replace('/','-',$_SESSION['t_date']);
        //$filename = trim($_SESSION['table_name'], " ").'.csv';
        //$file = $_SESSION['excel_table'];
		
		$dataRows = Controller::getdata($_REQUEST['table_data']);
        $objPHPExcel = new PHPExcel();
        $Sheet = $objPHPExcel->setActiveSheetIndex(0);

        foreach($dataRows as $key => $rows)
        {
            $row = $key + 1;
            foreach($rows as $cols => $colVal)
            {
                $Sheet->setCellValueByColumnAndRow($cols, $row, $colVal);
            }
        }
	
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
		for($col = 'A'; $col !=='AZ'; $col++) 
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}    
		$filename = $_SESSION['table_name'];
		$file = Yii::app()->params['logoPath'].$_SESSION['table_name'].'.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($file);
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
		
		
		
        $mail->AddAttachment($file,$filename.'.xlsx');

        $mail->IsHTML(false);
        //$_REQUEST['name'];
		$mail->MsgHTML('This Document is being emailed upon request by '.$user_name.' Please find the attachment of '.str_replace("_", " ", $_REQUEST['name']).'.'); //Text Body
		//$body = "HTML Body";
		$mail->WordWrap   = 50; // set word wrap
		$mail->SetFrom($user_mail,$user_name);
		$mail->AddReplyTo($user_mail,$user_name);
		//unlink($file);
		foreach($mail_to as $keys)
		{
			$mail->AddAddress($keys,$keys);
		}
		if(!$mail->Send())
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
			echo "Message has been sent";
		}
		
	}
    
	public function actionCreatedelivery()
    {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
            
            echo $model->_actionCreatedelivery();
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionCreatebilling()
    {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
            
            echo $model->_actionCreatebilling();
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionCreateorder()
    {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
            
            echo $model->_actionCreateorder();
        } else {
            $this->redirect(array('login/'));
        }
    }
    public function actionFeedback()
	{
		$name     = $_REQUEST['name'];
		$feedback = $_REQUEST['feedback'];
		
		if(isset($_REQUEST['login']))
		{
			$userid=$_REQUEST['email'];
			$tele=$_REQUEST['tele'];
			$feedback=$name." (".$tele.")<br>".$_REQUEST['feedback'];
			$select_type="Feedback";
			$user_name=$name;
		}
		else
		{
			$userid = Yii::app()->user->getState("user_id");
			$select_type=$_REQUEST['select_type'];
			$user_name=Yii::app()->user->getState("admin_user");
		}			
		$client = Controller::userDbconnection();
        $doc = $client->getDoc("feedbacks");
		
		$num=0;
		$numt=0;
		if($select_type=='Feedback')
		{
			$mail_to='feedback@thinui.com';
			if(isset($doc->$userid->feedback))
			{
				$feeds=$doc->$userid->feedback;	
				foreach($feeds as $keys=>$val)
				{
					$feed_key=$keys;
				}
				$feed_value=explode("_",$feed_key);
				$num=$feed_value[1]+1;
			}
			$feedback_keys="feedback_".$num;
			$docUser1= $client->getDoc($userid);
			if(isset($docUser1->profile->phone))
			{
				$tele=$docUser1->profile->phone;
			}
			$today = date("Y-m-d H:i:s"); 
			// $user=$doc->$userid->feedback->$feedback_keys=$feedback;
			$user=$doc->$userid->feedback->$feedback_keys=array('Name'=>$user_name,'EmailId'=>$userid,'Telephone'=>$tele,'FeedBack'=>$feedback,'createdDate'=>$today);
			$client->storeDoc($doc);
		}
		else if($select_type=='Help')
		{
			$mail_to='help@thinui.com';
			if(isset($doc->$userid->help))
			{
				$feeds=$doc->$userid->help;
				foreach($feeds as $keys=>$val)
				{
					$feed_key=$keys;
				}
				$feed_value=explode("_",$feed_key);
				$numt=$feed_value[1]+1;
			}
			$docUser= $client->getDoc($userid);
			if(isset($docUser->profile->phone))
			{
				$tele=$docUser->profile->phone;
			}
			$feedback_keys="help_".$numt;
			$today = date("Y-m-d H:i:s"); 
			$user=$doc->$userid->help->$feedback_keys=array('Name'=>$user_name,'EmailId'=>$userid,'Telephone'=>$tele,'HelpContent'=>$feedback,'createdDate'=>$today,'status'=>'pending');
			// $user=$doc->$userid->help->$feedback_keys=$feedback;
			$client->storeDoc($doc);
		}
		else 
		{
			$mail_to='feedback@thinui.com';
			$user_name=$_REQUEST['name'];	
			$userid=$_REQUEST['email'];
			$tele=$_REQUEST['tele'];
			$feedback=$_REQUEST['feedback'];	
			
			if(isset($doc->$userid->feedback))
			{
				$feeds=$doc->$userid->feedback;
				foreach($feeds as $keys=>$val)
				{
					$feed_key=$keys;
				}
				$feed_value=explode("_",$feed_key);
				$num=$feed_value[1]+1;
			} 				
			$feedback_keys="feedback_".$num;
			$today = date("Y-m-d H:i:s"); 
			$user=$doc->$userid->feedback->$feedback_keys=array('Name'=>$user_name,'EmailId'=>$userid,'Telephone'=>$tele,'FeedBack'=>$feedback,'createdDate'=>$today);
			$client->storeDoc($doc);
		}

		require_once( dirname(__FILE__) . "/../components/phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
		$mail->IsSMTP();
		
		if(Controller::checkHost())
		{
			$mail->Host       = Yii::app()->params['smtpconfig']['mailhost'];
		}
		else
		{
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = Yii::app()->params['smtpconfig']['securetype'];
			$mail->Host       = Yii::app()->params['smtpconfig']['host'];
			$mail->Port       = Yii::app()->params['smtpconfig']['port'];
			$mail->Username   = Yii::app()->params['smtpconfig']['username'];
			$mail->Password   = Yii::app()->params['smtpconfig']['password'];
		}
		
		$mail->SetFrom    = $userid;
		$mail->FromName   = $user_name;
		$mail->Subject    = $name;
		$body = $feedback;
		$mail->MsgHTML($body);
		$mail->WordWrap   = 50; // set word wrap
		$mail->AddReplyTo($userid,$user_name);
		$mail->AddAddress($mail_to,$mail_to);
		$mail->IsHTML(true); // send as HTML
		$mail->SMTPDebug = 1;

		if(!$mail->Send()) 
		{
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			echo "Message has been sent";
		}
	}
    public function actionSalesordercreditrelease()
    {
        if (Yii::app()->user->hasState("login")) {
            
			$model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
            
            echo $model->_actionSalesordercreditrelease();
        } else {
            $this->redirect(array('login/'));
        }
    }
	 public function actionApprovesalesorder()
    {
        if (Yii::app()->user->hasState("login")) {
            global $fce,$rfc;
			$model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
				$bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['bapiName']);
                $bObj->bapiCall($bapiName);
            echo $model->_actionApprovesalesorder();
        } else {
            $this->redirect(array('login/'));
        }
    }
    public function actionPdfurl()
    {
		   $model = new EditsalesorderForm;
		Yii::app()->controller->renderPartial('/common/stringpdf',array('model'=>$model));
	}
    public function actionSystemMSG() {
        $login = Yii::app()->user->getState('sap_login');

        /*
            GEZG 06/20/2018
            Chaing SAPRFC functions
        */
        try{
            $options = ["rtrim"=>true];
            $rfc = new SapConnection($login);
            $fce = $rfc->getFunction('SO_USER_READ_API1');
            if (!$fce) {
                echo "Discovering interface of function module failed";
                exit;
            }
            $value = array('USERID' => '', 'SAPNAME' => strtoupper(Yii::app()->user->getState('userName')), 'OFFICENAME' => '', 'FULLNAME' => '', 'DELETED' => '');
            $rfc_rc = $fce->invoke(["USER"=>$value],$options);
            $rowsag = $rfc_rc->USER_DATA;
            unset($fce);
            $fce = $rfc->getFunction('SO_FOLDER_READ_API1');
            if (!$fce) {
                echo "Discovering interface of function module failed";
                exit;
            }
            $rfc_rc = $fce->invoke(['FOLDER_ID'=>$rowsag['INBOXFOL']],$options);
            $rowsag = $rfc_rc->FOLDER_DATA;
             if ($rowsag['OBJ_DESCR'] == '#')
                echo 0;
            else
                echo $rowsag['OBJ_DESCR'];
        }catch(SapException $ex){
            if (!$fce) {
                echo "Discovering interface of function module failed";
                exit;
            }
            echo ("Exception raised KK: " .$ex->getMessage());
            exit();
        }            
    }

    public function actionGeolocation() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            Yii::app()->controller->renderPartial('geolocation', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionLookuptype() {
        if (Yii::app()->user->hasState("login")) {
            $type	= $_REQUEST['type'];
            $client = Controller::couchDbconnection();
			if(!Yii::app()->user->getState("bv"))
				$lv='';
			else	
			{
				$lv=Yii::app()->user->getState("bv");
				$lv=($lv!='v1'?'-'.$lv:'');
			}
            $doc    = $client->getDoc("lookuptype".$lv);
			echo json_encode($doc->$type);
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionLookup() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;

            $bapiName = Controller::Bapiname($_REQUEST['key']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('lookup', array('model' => $model, 'fce' => $fce));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actiongetAccountGroup(){        
        global $rfc,$fce;
        $bObj   = new Bapi();       
        $bObj->bapiCall('ZEMG_ACCOUNT_GRP_DISPLAY ');             
        $salesOrg = strtoupper($_REQUEST['salesOrg']);   
        $options = ['rtrim'=>true];
        $res = $fce->invoke(['SALES_ORGN'=>$salesOrg],$options); 
        $accountGroup = $res['ACCOUNT_GRP'];
        echo $accountGroup;
    }

	public function actionLookup_order() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;

            $bapiName = Controller::Bapiname($_REQUEST['key']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('lookup_order', array('model' => $model, 'fce' => $fce));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionMaterial_doc_lookup() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;

            $bapiName = Controller::Bapiname($_REQUEST['key']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('material_doc_lookup', array('model' => $model, 'fce' => $fce));
        } else {
            $this->redirect(array('login/'));
        }
    }
    public function actionMaterial_doc_help() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;

            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);

            $bapiName = Controller::Bapiname($_REQUEST['key']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('material_doc_help', array('model' => $model, 'docs' => $docs, 'client' => $client, 'fce' => $fce));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionHelp() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;

            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);

			if($_REQUEST['type']=="ship_to_customer"){
                $bapiName = Controller::Bapiname($_REQUEST['type']);
                $b = new Bapi();
                $b->bapiCall($bapiName);
                Yii::app()->controller->renderPartial('help_shipto', array('model' => $model, 'docs' => $docs, 'client' => $client, 'fce' => $fce));
			} else if ($_REQUEST['key']=="search_sales_person") {
                $bapiName = Controller::Bapiname($_REQUEST['key']);
                $b = new Bapi();
                $b->bapiCall($bapiName);
                Yii::app()->controller->renderPartial('help_salesperson', array('model' => $model, 'docs' => $docs, 'client' => $client, 'fce' => $fce));
            } else {
                $bapiName = Controller::Bapiname($_REQUEST['key']);
                $b = new Bapi();
                $b->bapiCall($bapiName);
                Yii::app()->controller->renderPartial('help', array('model' => $model, 'docs' => $docs, 'client' => $client, 'fce' => $fce));
			}
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionPlantMaterialCheck(){
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);
            $bapiName = "ZMAT_CHECK_PLANT";
            $b = new Bapi();
            $b->bapiCall($bapiName);
            $options = ['rtrim'=>true];
            $material = $_REQUEST["material"];
            $plant = $_REQUEST["plant"];
            $res = $fce->invoke(['LV_MATNR'=>$material, 'LV_WERKS'=>$plant],$options);
            $response = $res["RETURN"][0];
            echo '{"message":"'.$response["MESSAGE"].'"}';            
        } else{
            $this->redirect(array('login/'));   
        }
    }
           

     public function actionHelpPlant() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new CommonForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);            
            $bapiName = "ZPLANT_LOOKUP";
            $b = new Bapi();
            $b->bapiCall($bapiName);             
            Yii::app()->controller->renderPartial('helpPlant', array('model' => $model, 'docs' => $docs, 'client' => $client, 'fce' => $fce));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionHelpload() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;

            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $docs = $client->getDoc($userid);

            if($_REQUEST['type']=="Material Document"){
                Yii::app()->controller->renderPartial('mat_doc_helpload', array('model' => $model, 'docs' => $docs));
            }else{
                Yii::app()->controller->renderPartial('helpload', array('model' => $model, 'docs' => $docs));
            }


        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionSmarttable() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            Yii::app()->controller->renderPartial('smarttable', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionSearchtable() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            Yii::app()->controller->renderPartial('searchtable', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionEdit_customers() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;

            $bObj = new Bapi();
			$bapiName=Controller::Bapiname($_REQUEST['key']);
            $bObj->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('/editcustomers/edit_customers', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionTablesort() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            // $this->render('tablesort',array('model'=>$model));
            Yii::app()->controller->renderPartial('tablesort', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionTablestore() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);
            Yii::app()->controller->renderPartial('tablestore', array('model' => $model, 'doc' => $doc, 'client' => $client));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionTableorder() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;

            $screen = CommonController::setScreen();
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);

            $lables = $_REQUEST['lables'];
            $url = $_REQUEST['url'];
            $sess = $_REQUEST['sess'];
            $table = $_SESSION[$sess];
			
            $exp = explode(',', $lables);
			$_SESSION['tbl_count']=count($exp)-1;
			$_SESSION['t_count']=count($exp);
			$ids = 1;
			if ($url == 'Document_flow' && $sess == "example2_wrapper")
				$url .= '_header';
			elseif ($url == 'Document_flow' && $sess == "example1_wrapper")
				$url .= '_items';

            foreach ($table as $keys => $value) {
                if ($url == 'search_customers') {
                    $sdq[$ids] = array($exp[0] => $value[$exp[0]], $exp[1] => $value[$exp[1]], $exp[2] => $value[$exp[2]], $exp[3] => $value[$exp[3]], $exp[4] => $value[$exp[4]]);
                } else {
                    $order_t = array($exp[0] => $value[$exp[0]], $exp[1] => $value[$exp[1]], $exp[2] => $value[$exp[2]], $exp[3] => $value[$exp[3]], $exp[4] => $value[$exp[4]],$exp[5] => $value[$exp[5]], $exp[6] => $value[$exp[6]], $exp[7] => $value[$exp[7]], $exp[8] => $value[$exp[8]], $exp[9] => $value[$exp[9]]);
                    unset($value[$exp[0]], $value[$exp[1]], $value[$exp[2]], $value[$exp[3]], $value[$exp[4]],$value[$exp[5]], $value[$exp[6]], $value[$exp[7]], $value[$exp[8]], $value[$exp[9]]);
					$today = $value;
                    $sdq[$ids] = array_merge((array) $order_t, (array) $today);
                }
                $ids++;
            }
            $_SESSION[$sess] = $sdq;
            $urlName = $screen . '_' . $url;
            $doc->customize->$urlName->Table_order = $lables;
            $client->storeDoc($doc);
            exit;
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionExcel() {
        $_SESSION['excel_table'] = $_REQUEST['table_data'];
        
        if($_REQUEST['full_table'] != '')
            $_SESSION['col_count'] = $this->count_table_columns($_REQUEST['full_table']);
        else
            $_SESSION['col_count'] = $this->count_table_columns($_REQUEST['table_data']);

		if($_REQUEST['table_data_pdf']!='')
            $_SESSION['excel_table_pdf_view'] = $_REQUEST['table_data_pdf'];

        $_SESSION['table_name'] = $_REQUEST['name'] . '_' . $_SESSION['t_date'];
    }

    public function actionCsv() {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $_SESSION['table_name'] . '.csv"');

        $csv = $_SESSION['excel_table'];
        $csv = utf8_decode($csv);
        echo $csv;
    }

    public function actionPdf() {
        $content = $_SESSION['excel_table'];
        $content = utf8_decode($content);
		$table_name = substr($_SESSION['table_name'], 0, -1);
        
        define('FPDF_FONTPATH', 'font/');
        $colcount = $_SESSION['col_count'];

        $error_many_columns = _ERROR_MANY_COLUMNS;

        if($colcount > 13)
		{
			echo $error_many_columns;
			exit;
		}
		else
			$p = new PDFTable();
		
		/*
		if($colcount > 14)
			$p = new PDFTable('P', 'mm', 'a3');
		else
			$p = new PDFTable();
		*/
		
        // I set margins out of class
        $p->AddFont('vni_times');
        $p->AddFont('vni_times', 'B');
        $p->AddFont('vni_times', 'I');
        $p->AddFont('vni_times', 'BI');

        // $p->SetMargins(1, 1, 1);
        $p->AddPage('L');
        $p->defaultFontFamily = 'Arial';
        $p->defaultFontStyle = '';
		if($colcount > 14)
			$p->defaultFontSize = '6';
		else
			$p->defaultFontSize = '10';

        $p->SetFont($p->defaultFontFamily, $p->defaultFontStyle, $p->defaultFontSize);

        $p->htmltable($content);
        $p->output($table_name . '.pdf', 'D');
    }

    public function actionPdfview() {
        $content = $_SESSION['excel_table_pdf_view'];
        $content = utf8_decode($content);

        $table_name = substr($_SESSION['table_name'], 0, -1);
        define('FPDF_FONTPATH', 'font/');
        $p = new PDFTable();
        // I set margins out of class
        $p->AddFont('vni_times');
        $p->AddFont('vni_times', 'B');
        $p->AddFont('vni_times', 'I');
        $p->AddFont('vni_times', 'BI');
        
        $p->AddPage('P');
        $p->defaultFontFamily = 'Arial';
        $p->defaultFontStyle = '';
        $p->defaultFontSize = '10';

        $p->SetFont($p->defaultFontFamily, $p->defaultFontStyle, $p->defaultFontSize);

        $p->htmltable($content);
        $p->output($table_name . '.pdf', 'D');
    }
	
	public function count_table_columns($html)
	{
		$html = strtolower($html);
        //$rows = split('<tr>', $html);
        $rows = [];
        $rows = explode('<tr>', $html);
		foreach($rows as $row) {
			if(substr_count($row, '<td>') != 0)
				return substr_count($row, '<td>')."<br />";
			// if(!trim($row)) { continue; }
			// return substr_count($row, '<td>');
		}
	}
    public function actionsoldtoname()
    {
        global $fce;
        $bObj   = new Bapi();       
        $bapiName=Controller::Bapiname('ship_to_customer');
        $bObj->bapiCall($bapiName);         
        $sold = strtoupper($_REQUEST['val']);
        $lang = "E";
        if(isset($_SESSION["USER_LANG"])){
            $lang = strtoupper($_SESSION["USER_LANG"])=="ES"?"S":$lang;
        }

        $soldLenth  = count($sold);
            if($soldLenth < 10) { $sold = str_pad($sold, 10, 0, STR_PAD_LEFT); } else { $sold = substr($sold, -10); }
        //GEZG 06/21/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(['KUNNR'=>$sold,
                                'LANGUAGE'=> $lang],$options);        
        $SOLD_DET=$res['ITEMTAB'];
        foreach($SOLD_DET as $key=>$val)
        {
        if($sold==$val['KUNNR'])
        {
            $name=$val['NAME1'];
            $sorg=$val['VKORG'];
            $dch=$val['VTWEG'];
            $lang=$val['SPRAS'];
            $paymentTerm = $val['ZTERM'];
            $paymentTermDesc = $val['TEXT1'];
            echo 'S@'.$sorg.'@'.$dch.'@'.$name.'@'.$lang.'@'.$paymentTerm.'@'.$paymentTermDesc;
            exit;   
        }   
        }
        if(!isset($name))
        {
            echo 'E@This is not Valid Sold to Party.';
        }           
    }

    public function actionmaterialbom(){
        global $rfc,$fce;
        $bObj   = new Bapi();               
        //$bObj->bapiCall('SD_ORDER_CREATE'); 
        $bObj->bapiCall('ZEMG_MATERIAL_PRICE');         

        $material = strtoupper($_REQUEST['val']);   
        $sorg = strtoupper($_REQUEST['sorg']);
        $dchnl = strtoupper($_REQUEST['dcnl']);
        $sold=strtoupper($_REQUEST['part']);
        $ship=strtoupper($_REQUEST['part1']);
        $doc=strtoupper($_REQUEST['doc']);        
        $qty = intval($_REQUEST['qty']);

        if(is_numeric($material))
        {
            $materialLenth  = count($material);
            if($materialLenth < 18) { $material = str_pad($material, 18, 0, STR_PAD_LEFT); } else { $material = substr($material, -18); }
        }     
        
        $soldLenth  = count($sold);
        if($soldLenth < 10) { $sold = str_pad($sold, 10, 0, STR_PAD_LEFT); } else { $sold = substr($sold, -10); }
        $shipLenth  = count($ship);
        if($shipLenth < 10) { $ship = str_pad($ship, 10, 0, STR_PAD_LEFT); } else { $ship = substr($ship, -10); }  

        $options = ['rtrim'=>true];
        $res = $fce->invoke(['MATERIAL'=>$material,
                             'SORG'=> $sorg,
                             'DCHNL'=>$dchnl,
                             'SOLDTOPARTY'=>$sold,
                             'SHIPTOPARTY'=>$ship,
                             'DOCTYPE'=>$doc,
                             'ORDER_QTY'=>$qty
                            ],$options); 
        
        $matDesc = $res['E_MAKTX'];
        $SU     = $res['E_MEINS'];  
        $mCur    = $res['E_WAERS']; 
        
        $MATERIALPRICE=$res['T_KONP'];
        $mPrice=$MATERIALPRICE[0]['KBETR'];
        $mPer=$MATERIALPRICE[0]['KPEIN'];                
        $UOM = $MATERIALPRICE[0]['KMEIN']; 

        if(is_array($MATERIALPRICE) && !empty($MATERIALPRICE))
            $mCur=$MATERIALPRICE[0]['KONWA'];
            
         
        $components = $res['T_STPO'];
        $sComponents = "";
        if($matDesc!='')
        {

            $response =  '{
                    "isSuccess":true,
                    "data":{
                        "matDesc":"'.addcslashes($matDesc,"\"\\").'",
                        "uom":"'.$UOM.'",   
                        "su":"'.$SU.'",                 
                        "matPrice":"'.$mPrice.'",
                        "matPer":"'.$mPer.'",
                        "matCur":"'.$mCur.'",
                        "matPlant":""';                        
            if(count($components) > 0){
               $response .= ',"components":[';
               foreach ($components as $c => $component) {              
                    $sComponents .= '{           
                        "matNumber":"'.addcslashes($component["COMPONENT"],"\"\\").'",             
                        "matDesc":"'.$component["ITEM_TEXT1"].'",
                        "su":"'.$component["COMP_UNIT"].'",
                        "uom":"'.$component["COMP_UNIT"].'",                        
                        "matPrice":"0",
                        "matPer":"0",
                        "matCur":"'.$mCur.'",
                        "matPlant":"",
                        "matQty":"'.trim($component["COMP_QTY"]).'"
                    },';                
                }            
                $sComponents = substr($sComponents,0,strlen($sComponents)-1);
                $response .= $sComponents.']';
            }

            $response .= '}}';

            echo $response;
        }
        else
        {
            echo '{"isSuccess":false,"message":"Material Not Available."}';
        }
    
    }

    public function actionmaterialdes()
    {
        global $rfc,$fce;
        if($_REQUEST['part1']=='')
        {
        $bObj   = new Bapi();            
        $bObj->bapiCall('BAPI_MATERIAL_GET_ALL'); 
        $imp   = new BapiImport();
        $material = strtoupper($_REQUEST['val']);
        
        if(is_numeric($material))
        {
            $materialLenth  = count($material);
            if($materialLenth < 18) { $material = str_pad($material, 18, 0, STR_PAD_LEFT); } else { $material = substr($material, -18); }
        }
        
        //GEZG 06/21/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res=$fce->invoke(['MATERIAL'=>$material],$options);    

        $ClientData = $res['CLIENTDATA'];
        $UOM = $ClientData['BASE_UOM'];           
        $MATERIALDESCRIPTION=$res['MATERIALDESCRIPTION'];
        $met=$MATERIALDESCRIPTION[0]['MATL_DESC'];
        $return=$res['RETURN'];
        $msg='';
        foreach($return as $msg)
        {
            $msg.=$msg['MESSAGE'].'<br>';
        }
        if($met!='')
        {
            echo 'S@'.$met.'@'.$UOM;
        }
        else
        {
            echo 'E@'.$msg;
        }
        }else
        {
        $bObj   = new Bapi();       
        $bapiName=Controller::Bapiname('material_price');
        $bObj->bapiCall($bapiName);         
        //GEZG 06/21/2018
        //Changing SAPRFC methods        
        $material = strtoupper($_REQUEST['val']);
        $sorg = strtoupper($_REQUEST['sorg']);
        $dchnl = strtoupper($_REQUEST['dcnl']);
        $sold=strtoupper($_REQUEST['part']);
        $ship=strtoupper($_REQUEST['part1']);
        $doc=strtoupper($_REQUEST['doc']);
        if(is_numeric($material))
        {
            $materialLenth  = count($material);
            if($materialLenth < 18) { $material = str_pad($material, 18, 0, STR_PAD_LEFT); } else { $material = substr($material, -18); }
        }
            $customerLenth  = count($customer);
            if($customerLenth < 10) { $customer = str_pad($customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
            $soldLenth  = count($sold);
            if($soldLenth < 10) { $sold = str_pad($sold, 10, 0, STR_PAD_LEFT); } else { $sold = substr($sold, -10); }
            $shipLenth  = count($ship);
            if($shipLenth < 10) { $ship = str_pad($ship, 10, 0, STR_PAD_LEFT); } else { $ship = substr($ship, -10); }
        $options = ['rtrim'=>true];
        $res=$fce->invoke(['MATERIAL' => $material,
                            'SORG' => $sorg,
                            'DCHNL' => $dchnl,
                            'SOLDTOPARTY' => $sold,
                            'SHIPTOPARTY'=>  $ship,
                            'DOCTYPE'=> $doc],$options);    
        
        $met = $res['E_MAKTX'];
        $UOM = $res['E_MEINS'];

        $MATERIALPRICE=$res['T_KONP'];
        $mPrice=$MATERIALPRICE[0]['KBETR'];
        $mPer=$MATERIALPRICE[0]['KPEIN'];
        $mCur=$MATERIALPRICE[0]['KONWA'];
        if($mCur=='')
            $mCur=$res['E_WAERS'];
        
        if($met!='')
        {
            echo 'S@'.$met.'@'.$UOM.'@'.$mPrice.'@'.$mPer.'@'.$mCur;
        }
        else
        {
            echo 'E@Material Not Available.';
        }
        }
    }
    public function actionExcelexport() {
        $dataRows = Controller::getdata($_SESSION['excel_table']);
        $objPHPExcel = new PHPExcel();
        $Sheet = $objPHPExcel->setActiveSheetIndex(0);

        foreach($dataRows as $key => $rows)
        {
            $row = $key + 1;
            foreach($rows as $cols => $colVal)
            {
                $colVal = utf8_decode($colVal);
                $Sheet->setCellValueByColumnAndRow($cols, $row, $colVal);
            }
        }
	
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
		for($col = 'A'; $col !=='AZ'; $col++) 
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}    
		$filename = $_SESSION['table_name'].'.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
    }

    public static function setScreen() {
        $scrnWidth = $_COOKIE['screenwidth'];
        if ($scrnWidth >= 1024)
            return 'desktop';
        else if ($scrnWidth <= 700)
            return 'phone';
        else if ($scrnWidth <= 1024)
            return 'tablet';
    }
    public function actionCompanydetails()
    {
            global $rfc,$fce;
            $bapiName='BAPI_CUSTOMER_GETDETAIL2';
            $b = new Bapi();
            $b->bapiCall($bapiName);            
            $cno=str_pad($_REQUEST['cno'], 10, '0', STR_PAD_LEFT);
            $options = ['rtrim'=>true];
            $res = $fce->invoke(["CUSTOMERNO" => $cno],$options);
            
            $resul=$res['CUSTOMERADDRESS'];
            
            $accdetail=$res['CUSTOMERGENERALDETAIL'];
            $file=Yii::app()->params['accountgroup'];
            if(!is_file($file) xor !is_readable($file))
                trigger_error("File Not readable");     
            $data = file_get_contents($file);
            $arrdata = json_decode($data, true);
            $Role       = isset($_POST['ur']) ? $_POST['ur'] : "";
                $Role=($Role=='Customer Service Users'?'emg_customer_service':'emg_retailer');
            $ACCN = ($Role=='emg_retailer'?$arrdata['Account_Group_Code']['Retailer']:$arrdata['Account_Group_Code']['Customer']);
            
            if($resul['CUSTOMER']=='')
                echo 'This SoldtoID is Not Available in SAP System.';
            elseif($ACCN!=$accdetail['ACCNT_GRP'])
                echo 'This SoldtoID Mismatch with Account Group Code.'; 
            else
                echo json_encode($resul);
            
    }
	Public function actionAddlogin()
	{
	if(isset($_REQUEST))
	{
	$login=Yii::app()->user->getState("sap_login");
	
		$login["CLIENT"]=$_REQUEST['client'];
		$login["USER"]=$_REQUEST['uname'];
		$login["PASSWD"]=$_REQUEST['pswd'];
	
	Yii::app()->user->setState("sap_login", $login);
	}
	
	}
    public function actionSysdetail()
    {
    $client    = Controller::companyDbconnection();
    $Company_ID = Yii::app()->user->getState("company_id");
    $doc        = $client->getDoc($Company_ID);
    $str='<table >';
    $th='<tr style="font-weight: bold">';
    $tb='<tr>';     
    //GEZG 08/13/2018
    //PArsing object to array for maaking it accessible using a string index
    $hostIDs = (array)$doc->host_id;
    foreach($val=$hostIDs[$_REQUEST['id']] as $key=>$val)
    {
        if($key<>'')
        {
            $th=$th.'<td>'.$key.'</td>';
            $tb=$tb.'<td>'.$val.'</td>';
        }   //$str=$str.'<tr><td>'.$key.' : </td><td>'.$val.'</td></tr>';
    }
    $th=$th.'</tr>';
    $tb=$tb.'</tr>';
    $str=$str.$th.$tb.'</table>';
    $val_exp=$hostIDs[$_REQUEST['id']];
    
            if($val_exp->Connection_type=='Group')
            {
                
                $desc    = $val_exp->Description;
                $messageserver    = $val_exp->Host;
                $group    = $val_exp[3];
                $system_id  = $val_exp->System_ID;
                $language   = $val_exp->Language;
                $extended   = $val_exp->Extension;
                $login = array (
                    "MSHOST"=>$messageserver,     // your host address here "76.191.119.98
                    "R3NAME"=>$system_id,
                    "GROUP"=>$group,
                    "CLIENT"=>$client_id,
                    "LANG"=>$language,
                );
                //print_r($login);
            }
            else
            {
                $desc    = $val_exp->Description;
                $host    = $val_exp->Host;
                $rout    = $val_exp->Router_Port;
                $rout_ip = $val_exp->Router_String;
                if($rout != NULL)
                {
                    $host = '/H/'.$rout_ip.'/H/'.$host;
                }
                $system_num = $val_exp->System_Number;
                $system_id  = $val_exp->System_ID;
                $language   = $val_exp->Language;
                $extended   = $val_exp->Extension;
                $login = array (
                    "ASHOST"=>$host,     // your host address here "76.191.119.98
                    "SYSNR"=>$system_num,
                    "SYSID"=>$system_id,
                    "LANG"=>$language,
                );
            }
            Yii::app()->user->setState("sap_login", $login);    
    echo $str;
    }

    /**
     * This is the action to handle external exceptions.
     * */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
	

    public function actionGetPaymentTermDesc(){
        global $fce,$rfc;
        $bObj   = new Bapi();                       
        $bObj->bapiCall('BAPI_HELPVALUES_GET');         
        
        $paymentTerm = strtoupper($_REQUEST['paymentTerm']);          
        $EXPLICIT_SHLP = array("SHLPNAME" => "ZPAYTERMS", "SHLPTYPE" => "SH", "TITLE" => "", "REPTEXT" => "");
                
        $SELECTION_FOR_HELPVALUES = array("SELECT_FLD" => "ZTERM", "SIGN" => "I", "OPTION" => "CP", "LOW" => $paymentTerm , "HIGH" => "");
        $selectionForHelpValuesImportTable = array();
        array_push($selectionForHelpValuesImportTable, $SELECTION_FOR_HELPVALUES);               
        $options = ['rtrim'=>true];
        $res = $fce->invoke(['OBJTYPE'=>"ZPAY_TERM",
                            'METHOD'=>"ZPAYTERMS",
                            'PARAMETER'=>"ZTERM",
                            'FIELD'=>"ZTERM",
                            "EXPLICIT_SHLP"=>$EXPLICIT_SHLP,
                            'MAX_OF_ROWS'=>0,
                            "SELECTION_FOR_HELPVALUES"=>$selectionForHelpValuesImportTable],$options);      

        $helpValuesCount = count($res["HELPVALUES"]);
        if($helpValuesCount != 1){
            $response = '{
                "success":false,
                "message":"Invalid payment term"
            }';
        }else{  
            $helpValues = $res["HELPVALUES"][0];
            $response = '{
                            "success":true,
                            "value":"'.$helpValues["HELPVALUES"].'"
                        }';            
        }
        echo $response;       
    
    }

}