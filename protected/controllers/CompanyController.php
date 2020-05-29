<?php
class CompanyController extends Controller
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
	public function actionIndex()
	{
		global $rfc,$fce;
		$model = new CompanyForm;		
		if(isset($_POST['CompanyForm']))
		{
			$bapiName = $_POST['bapiName'];
			$b = new Bapi();
			$b->bapiCall($bapiName);
			
			$CompanyForm = $_POST['CompanyForm'];
			$compy_legalname	= strtoupper($CompanyForm['compy_legalname']);
			$compy_street		= strtoupper($CompanyForm['compy_street']);
			$compy_houseno		= strtoupper($CompanyForm['compy_houseno']);
			$compy_city			= strtoupper($CompanyForm['compy_city']);
			$compy_state		= strtoupper($CompanyForm["compy_state"]);
			$compy_telephone	= strtoupper($CompanyForm['compy_telephone']);
			$compy_postalcode	= strtoupper($CompanyForm['compy_postalcode']);
			$compy_fax			= strtoupper($CompanyForm['compy_fax']);
			$compy_timezone		= strtoupper($CompanyForm['compy_timezone']);
			$compy_tinno		= strtoupper($CompanyForm['compy_tinno']);
			
			$plant_legalname	= strtoupper($CompanyForm['plant_legalname']);
			$plant_street		= strtoupper($CompanyForm['plant_street']);
			$plant_houseno		= strtoupper($CompanyForm['plant_houseno']);
			$plant_city			= strtoupper($CompanyForm['plant_city']);
			$plant_state		= strtoupper($CompanyForm["plant_state"]);
			$plant_telephone	= strtoupper($CompanyForm['plant_telephone']);
			$plant_postalcode	= strtoupper($CompanyForm['plant_postalcode']);
			$plant_fax			= strtoupper($CompanyForm['plant_fax']);
			$plant_timezone		= strtoupper($CompanyForm['plant_timezone']);
			$plant_tinno		= strtoupper($CompanyForm['plant_tinno']);
			
			$sales_legalname	= strtoupper($CompanyForm['sales_legalname']);
			$sales_street		= strtoupper($CompanyForm['sales_street']);
			$sales_houseno		= strtoupper($CompanyForm['sales_houseno']);
			$sales_city			= strtoupper($CompanyForm['sales_city']);
			$sales_state		= strtoupper($CompanyForm["sales_state"]);
			$sales_telephone	= strtoupper($CompanyForm['sales_telephone']);
			$sales_postalcode	= strtoupper($CompanyForm['sales_postalcode']);
			$sales_fax			= strtoupper($CompanyForm['sales_fax']);
			$sales_timezone		= strtoupper($CompanyForm['sales_timezone']);
			$sales_tinno		= strtoupper($CompanyForm['sales_tinno']);
			
			$purch_legalname	= strtoupper($CompanyForm['purch_legalname']);
			$purch_street		= strtoupper($CompanyForm['purch_street']);
			$purch_houseno		= strtoupper($CompanyForm['purch_houseno']);
			$purch_city			= strtoupper($CompanyForm['purch_city']);
			$purch_state		= strtoupper($CompanyForm["purch_state"]);
			$purch_telephone	= strtoupper($CompanyForm['purch_telephone']);
			$purch_postalcode	= strtoupper($CompanyForm['purch_postalcode']);
			$purch_fax			= strtoupper($CompanyForm['purch_fax']);
			$purch_timezone		= strtoupper($CompanyForm['purch_timezone']);
			$purch_tinno		= strtoupper($CompanyForm['purch_tinno']);
			
			$I_COMPCODE_DATA = array(
					"NAME"=>$compy_legalname,
					"STREET_LNG"=>$compy_street,
					"HOUSE_NO"=>$compy_houseno,
					"CITY"=>$compy_city,
					"REGION"=>$compy_state,
					"TEL1_NUMBR"=>$compy_telephone,
					"POSTL_COD1"=>$compy_postalcode,
					"FAX_NUMBER"=>$compy_fax,
					"TIME_ZONE"=>$compy_timezone,
					"TAXJURCODE"=>$compy_tinno
			);
			
			$I_PLANT_DATA = array(
					"NAME"=>$plant_legalname,
					"STREET_LNG"=>$plant_street,
					"HOUSE_NO"=>$plant_houseno,
					"CITY"=>$plant_city,
					"REGION"=>$plant_state,
					"TEL1_NUMBR"=>$plant_telephone,
					"POSTL_COD1"=>$plant_postalcode,
					"FAX_NUMBER"=>$plant_fax,
					"TIME_ZONE"=>$plant_timezone,
					"TAXJURCODE"=>$plant_tinno
			);
			
			$I_SALESORG_DATA = array(
					"NAME"=>$sales_legalname,
					"STREET_LNG"=>$sales_street,
					"HOUSE_NO"=>$sales_houseno,
					"CITY"=>$sales_city,
					"REGION"=>$sales_state,
					"TEL1_NUMBR"=>$sales_telephone,
					"POSTL_COD1"=>$sales_postalcode,
					"FAX_NUMBER"=>$sales_fax,
					"TIME_ZONE"=>$sales_timezone,
					"TAXJURCODE"=>$sales_tinno
			);
			
			$I_PURCHORG_DATA = array(
					"NAME"=>$purch_legalname,
					"STREET_LNG"=>$purch_street,
					"HOUSE_NO"=>$purch_houseno,
					"CITY"=>$purch_city,
					"REGION"=>$purch_state,
					"TEL1_NUMBR"=>$purch_telephone,
					"POSTL_COD1"=>$purch_postalcode,
					"FAX_NUMBER"=>$purch_fax,
					"TIME_ZONE"=>$purch_timezone,
					"TAXJURCODE"=>$purch_tinno
			);
			//GEZG 06/21/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$res = $fce->invoke(["I_COMPANY_CODE" => 123,
								"I_COMPCODE_DATA" => $I_COMPCODE_DATA,
								"I_PLANT_NUMBER" => 456,
								"I_PLANT_DATA" =>  $I_PLANT_DATA,
								"I_SALES_ORG" => 789,
								"I_SALESORG_DATA" => $I_SALESORG_DATA,
								"I_PURCHASE_ORG" => 012,
								"I_PURCHORG_DATA" => $I_PURCHORG_DATA],$options);			
						
			$res_table = new ResponseTable();
			$SalesOrder = $res['ET_MESSAGES'];
			// echo $SalesOrder[0]['TYPE']."@".$SalesOrder[0]['MESSAGE']."  Sucessfully";
			var_dump($SalesOrder);
			$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
			$fce->invoke();						
			exit;
		}
		$this->render('index', array('model'=>$model));
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

	/**
	 * This is the default 'Register' action that is invoked
	 * when an action is not explicitly requested by users.
	**/
	public function actionRegister()
	{
		$model = new RegisterForm;
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes = $_POST['RegisterForm'];                
			if($model->validate())
			{
				$fname    = $_REQUEST['fname'];
				$lname    = $_REQUEST['lname'];
				$phone    = $_REQUEST['phone'];
				$company  = $_REQUEST['company'];
				$street   = $_REQUEST['street'];
				$city     = $_REQUEST['city'];
				$state    = $_REQUEST['state'];
				$country  = $_REQUEST['country'];
				$userid   = $_REQUEST['email_id'];
				$email_id = $_REQUEST['email_id'];
				$pswd     = md5($_REQUEST['pswd']);
				
				$q1 = $_REQUEST['q1'];
				$q2 = $_REQUEST['q2'];
				$a1 = $_REQUEST['a1'];
				$a2 = $_REQUEST['a2'];

				$date_time   = isset($_REQUEST['date_time']) ? $_REQUEST['date_time'] : '';
				if($date_time != '')
				{
					$dates = explode("@",$date_time);
					$times = explode(":",$dates[1]);

					$hh = $times[0];
					$mm = $times[1];
					$ss = $times[2];

					if(strlen(trim($times[0]))<2)
					{
						$hh="0".trim($times[0]);
					}
					if(strlen(trim($times[1]))<2)
					{
						$mm="0".trim($times[1]);
					}
					if(strlen(trim($times[2]))<2)
					{
						$ss="0".trim($times[2]);
					}

					$day   = explode("/",$dates[0]);
					$month = $day[0];
					$date  = $day[1];

					if(strlen($day[0])<2)
					{
						$month="0".$day[0];
					}
					if(strlen($day[1])<2)
					{
						$date="0".$day[1];
					}
				}
				$ramdam      = rand(100000, 900000);
				$datest      = $month."/".$date."/".$day[2];
				$time_format = $hh.":".$mm.":".$ss;
				$todayDate   = $time_format." on ".$datest;
				
				$client = Controller::couchDbconnection();
				$doc    = $client->getDoc("email_id_confirm");
				$doc1   = new couchDocument($client);
				
				$doc->$userid = array(
					'firstName'=>$fname,
					'lastName'=>$lname,
					'company'=>$company,
					'code'=>$ramdam,
					'email'=>'pending',
					'createdDate'=>$todayDate,
					'status'=>'deactive'
				);
				// $client->storeDoc($doc);

				$doc1->set(array(
					'_id'=>$userid,
					'status' => 'deactive',
					'login_id'=>array(
							'email_id'=>$userid,
							'password'=>$pswd,
							'q1'=>strtolower($q1),
							'q2'=>strtolower($q2),
							'a1'=>strtolower($a1),
							'a2'=>strtolower($a2)
					),
					'host_id'=>array(
							'none'=>'none',
							'host_1'=>array('Description'=>'EC4',
									'Host'=>'76.191.119.98',
									'Router_String'=>'',
									'Router_Port'=>'',
									'System_Number'=>'10',
									'System_ID'=>'EC4',
									'Language'=>'EN',
									'Extension'=>'on')
					),
					'host_upload'=>array('76.191.119.98/10/EC4/'=>array('client'=>'210', 'user'=>'msreekanth')),
					'profile'=>array(
							'fname'=>$fname,
							'lname'=>$lname,
							'phone'=>$phone,
							'companyname'=>$company,
							'streetaddress'=>$street,
							'city'=>$city,
							'state'=>$state,
							'country'=>$country,
							'help_en'=>0
					),
					'bi_id'=>array(
							'bi_1'=>array('Description'=>'BOBJ: Demo System',
							'System_URL'=>'http://services.cloud.skytap.com:27393',
							'CMS_Name'=>'emgbo1',
							'CMS_Port'=>'6400',
							'Auth_Type'=>'secEnterprise')
					),
					'bi_upload'=>array('http://services.cloud.skytap.com:27393'=>array('name'=>'thinui'))
				));

				require_once( dirname(__FILE__) . "/../components/phpmailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$body = '<h4>Your thinui account activation deatils <h4>
				<table cellpadding="5px"><tr><td> Name </td><td>:&nbsp;'.$fname.' '.$lname.'</td></tr>
				<tr><td>Company </td><td>:&nbsp;'.$company.'</td></tr>
				<tr><td> Email Id </td><td>:&nbsp;'.$email_id.'</td></tr>
				<tr><td> Click here to Activate your Account </td>
				<td>:&nbsp;<a style="cursor:pointer" href="http://' . $_SERVER['HTTP_HOST'] . '/'.basename(dirname(dirname(__FILE__))).'/html/useractivation.php?acode='.$ramdam.'&email_id='.$email_id.'" target="_blank">Activate</a></td></tr>
				</table>
				<br><br>
				<img src="'.Yii::app()->request->baseUrl.'/images/thinui-logo-login.png" style="width:100px;"/><br> '.$todayDate;

				$address = "thinui@emergys.com";
				$user_name = 'Thinui Account Activation';
				$mail->IsSMTP();
				
				if(Controller::checkHost())
				{
					$mail->Host       = Yii::app()->params['smtpconfig']['mailhost'];
				}
				else
				{
					$mail->SMTPDebug  = 1;
					$mail->SMTPAuth   = true;
					$mail->SMTPSecure = Yii::app()->params['smtpconfig']['securetype'];
					$mail->Host       = Yii::app()->params['smtpconfig']['host'];
					$mail->Port       = Yii::app()->params['smtpconfig']['port'];
					$mail->Username   = Yii::app()->params['smtpconfig']['username'];
					$mail->Password   = Yii::app()->params['smtpconfig']['password'];
				}

				$mail->Subject    = "Activation your Account - Thinui";
				$mail->MsgHTML($body);
				$mail->SetFrom($address, $user_name);
				$mail->AddReplyTo($address, $user_name);
				$mail->AddAddress($email_id, $user_name);

				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;                       
				} else {
					$client->storeDoc($doc);
					echo "Message sent!";
					
				}
				return;
			}
		}
		$this->render('register', array('model'=>$model));
	}
	
        
        public function actionHost()
	{
            $model = new HostForm;
            // collect user input data
            if(isset($_POST['HostForm']))
            {
                
            }
            // display the login form
            $this->render('host',array('model'=>$model));		
	}
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes = $_POST['ContactForm'];
			if($model->validate())
			{
				$name    = '=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject = '=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers = "From: $name <{$model->email}>\r\n".
						"Reply-To: {$model->email}\r\n".
						"MIME-Version: 1.0\r\n".
						"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact', array('model'=>$model));
	}
}