<?php
class Create_sales_quotationController extends Controller
{
    /**
    * Declares class-based actions.
    **/        
    public $screen;
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
    **/
    public function actionCreate_sales_quotation()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_sales_quotationForm;
            if(isset($_REQUEST['CUSTOMER']))
            {
                $customerNo = $_REQUEST['CUSTOMER'];
            }
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'customerNo'=>$customerNo));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    
    public function actionQuotation_sales()
    {
        if(Yii::app()->user->hasState("login"))
        {            
            global $rfc, $fce;
            $model = new Create_sales_quotationForm;
            if(isset($_REQUEST['scr'])) { $s_wid=$_REQUEST['scr']; }
            $bapiName = Controller::Bapiname($_REQUEST['url']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('quotation_sales',array('model'=>$model,'fce'=>$fce));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
	 public function actionQuotaitonemail()
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
		
                $client1        = Controller::companyDbconnection();
                $Company_ID     = Yii::app()->user->getState("company_id");
                $doc            = $client1->getDoc($Company_ID);              
                if(isset($doc->mailserver) && ($doc->mailserver->host!=''))
                {
                        $file=Yii::app()->params['salt'];
                        if(file_exists($file)  && is_readable($file))
                        {
                              $data = file_get_contents($file);
                              $arrdata = json_decode($data, true);
                              $salt=md5($arrdata['Title']);
                        }else
                        {
                              echo basename($file).'is not Available in Config folder.';
                              exit;
                        }
                        if(isset($doc->mailserver->smtpauth) && ($doc->mailserver->smtpauth=='true'))
                        {
                              $mail->SMTPAuth   = true;
                              $mail->SMTPSecure   = "tls";
                              $mail->Username   = Controller::decryptIt($doc->mailserver->username,$salt);
                              $mail->Password   = Controller::decryptIt($doc->mailserver->password,$salt);
                        }
                        $mail->Host       = Controller::decryptIt($doc->mailserver->host,$salt);
                        $mail->Port       = Controller::decryptIt($doc->mailserver->port,$salt);
                        $mail->From       = Controller::decryptIt($doc->mailserver->username,$salt);
                        $mail->FromName   = Controller::decryptIt($doc->mailserver->fromname,$salt);
                }
                else
                {
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
                        /* $mail->From       = 'thinui@emergys.com';
                        $mail->FromName   = 'thinui'; */
                        $mail->SetFrom($user_mail,$user_name);
                        $mail->AddReplyTo($user_mail,$user_name);
                }

		$mail->Subject    = "Sales Quotation Document from ThinUI";
		$filename ='';
		$file='';
		
		global $rfc, $fce;
		$order=$_REQUEST['q_no'];;
		//$bapiName=Controller::Bapiname($_REQUEST['bapi']);
		$bapiName = 'ZEMG_SD_FORM_QUOTATION_PDF';
		$b = new Bapi();
		$b->bapiCall($bapiName);
		//GEZG 06/21/2018
        //Changing SAPRFC functions
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_ORDER_NUM" => str_pad($order,10,'0',STR_PAD_LEFT)],$options);    
		$msg= $res["ET_MESSAGES"][0];
		
		
			if($msg['TYPE']=='E')
			{
			$mail->IsHTML(false);
			//$_REQUEST['name'];
			$mail->MsgHTML($_REQUEST['mailcontent'].' '.$msg['MESSAGE'] ); //Text Body
			}else
			{
		    $rowsag = count($res["ET_FORM_PDF"]);     
	        for ($i=0;$i<$rowsag;$i++)
			{
				$SalesOrder[]= $res["ET_FORM_PDF"][$i];
				//var_dump($SalesOrder);
			} 
	        $str='';
            foreach($SalesOrder as $keys=>$value)
            {
				foreach($value as $innerkeys=>$innervalues)
				{
					$str.=$innervalues;
				}
			}
			//echo $str;
			$filename = 'Sales_Quotation_Confirmation_'.ltrim($order, '0').'.pdf';
			//$file= $str;
			$_SESSION['pdfname']='Sales_Quotation_Confirmation_'.ltrim($order, '0');
			$_SESSION['pdfstr']=$str;
			$file=$str;
		
		//$model = new EditsalesorderForm;
		//$file=Yii::app()->controller->renderPartial('/common/stringpdf',array('model'=>$model));
        //$_SESSION['excel_table'] = $_REQUEST['table_data'];
        //$_SESSION['table_name'] = $_REQUEST['name'] . '_'.str_replace('/','-',$_SESSION['t_date']);
         //= trim($_SESSION['table_name'], " ").'.csv';
        //$file = $_SESSION['excel_table'];

        $mail->AddStringAttachment($file, $filename,'base64','application/pdf');
		$mail->IsHTML(false);
        //$_REQUEST['name'];
		$mail->MsgHTML('This Document is being emailed upon request by '.$user_name.' Please find the attachment of '); //Text Body
		}
        
		//$body = "HTML Body";
		$mail->WordWrap   = 50; // set word wrap
		//$mail->AddAddress($mail_to);
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
    /**
    * This is the action to handle external exceptions.
    **/
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                 Yii::app()->controller->renderPartial('error', $error);
        }
    }
                
}
