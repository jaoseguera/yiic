<?php
//GEZG - 06/19/2018
//Alias for new SAPRFC libraries
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class LoginController extends Controller {

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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (!Yii::app()->user->getState("user_id")):
            $model = new IndexForm;
            //require_once(Yii::app()->params['update']);
			
            if(isset($_REQUEST['em']) && isset($_REQUEST['acode']))
            {
                $userid = base64_decode($_REQUEST['em']);
                $acode  = base64_decode($_REQUEST['acode']);
                
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                // $doc1   = $client->getDoc("email_id_confirm");
				
                if($acode == $doc->activecode && $doc->status == 'inactive')
                {
					$doc->status  = 'active';
					/*
					$doc1->$userid->email  = 'sent';
					$doc1->$userid->status = 'active';
					*/
					
					$client->storeDoc($doc);
					//$client->storeDoc($doc1);
					Yii::app()->user->setFlash('success', 'Account Activated Successfully');
                }
				else
					Yii::app()->user->setFlash('error', 'Account Already Activated');
            }
            // collect user input data
            if (isset($_POST['IndexForm'])) {
                //  print_r($_POST); return;
                $model->attributes = $_POST['IndexForm'];
                // validate user input and redirect to the previous page if valid                                
                if ($model->validate() &&  ($_POST['err']=='' || $_POST['err'] == null)) {
					$model->login();
					$rfc='1';
					$userid		= Yii::app()->user->getState("user_id");
					try{
						$client	 = Controller::userDbconnection();
						$userdoc = $client->getDoc($userid);
						$client1 	= Controller::companyDbconnection();
						$Company_ID	= Yii::app()->user->getState("company_id");
						$doc		= $client1->getDoc($Company_ID);
					}catch(Exception $ex){
						echo "undone";exit();
					}
					
					if(isset($userdoc->system->host) && ($userdoc->system->host!=''))
					{
							//$salt=Yii::app()->params['salt'];
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
							$hostid=$userdoc->system->host;
							$val_exp=$doc->host_id->$hostid;
							if($val_exp->Connection_type=='Group')
							{
								$desc    = $val_exp->Description;
								$messageserver    = $val_exp->Host;
								$group    = $val_exp[3];
								$system_id  = $val_exp->System_ID;
								$language   = $val_exp->Language;
								$extended   = $val_exp->Extension;
								$uname      = Controller::decryptIt($userdoc->system->username,$salt);
								$pswd       = Controller::decryptIt($userdoc->system->password,$salt);
								$client     = $userdoc->system->client_id;
								$login = array (
									"MSHOST"=>$messageserver,     // your host address here "76.191.119.98
									"R3NAME"=>$system_id,
									"GROUP"=>$group,
									"USER"=>$uname,
									"PASSWD"=>$pswd,
									"CLIENT_ID"=>$client,
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
								$uname      = Controller::decryptIt($userdoc->system->username,$salt);
								$pswd       = Controller::decryptIt($userdoc->system->password,$salt);
					
								$client     = $userdoc->system->client_id;
								$login = array (
									"ASHOST"=>$host,     // your host address here "76.191.119.98
									"SYSNR"=>$system_num,
									"SYSID"=>$system_id,
									"USER"=>$uname,
									"PASSWD"=>$pswd,
									"CLIENT"=>$client,
									"LANG"=>$language,
								);
							}
							$bv=isset($val_exp->Bapiversion)?$val_exp->Bapiversion:'';
						
							Yii::app()->user->setState("bv", $bv);
							Yii::app()->user->setState("sap_login",$login);							
							try{
								$rfc = new SapConnection($login);
								echo "done"; return;
							}catch(SapException $ex){
								Yii::app()->user->logout();
								echo "There was an error connecting to the SAP system. \n Please contact your account administrator."; return;
							}
				}				
                }
                else
                {
                    echo 'undone'; return;
                }
            }

            $authentication = Yii::app()->getRequest()->getCookies()->itemAt('authentication');
            if (isset($authentication) && !empty($authentication))
                $model->attributes = unserialize($authentication);
          
            // display the login form
            
			$this->render('index', array('model' => $model));

        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        // $theTime = date("D M j G:i:s T Y");
        // $this->render('index', array('time'=>$theTime));
        else:
				$this->redirect(Yii::app()->user->returnUrl);
        endif;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * This is the default 'Register' action that is invoked
     * when an action is not explicitly requested by users.
     * */
    public function actionRegister() {
        $model = new RegisterForm;
        if (isset($_POST['RegisterForm'])) {
            $model->attributes = $_POST['RegisterForm'];
            if ($model->validate()) {
                $fname = $_REQUEST['fname'];
                $lname = $_REQUEST['lname'];
                $phone = $_REQUEST['phone'];
                $company = $_REQUEST['company'];
                $street = $_REQUEST['street'];
                $city = $_REQUEST['city'];
                $state = $_REQUEST['state'];
                $country = $_REQUEST['country'];
                $userid = $_REQUEST['email_id'];
                $email_id = $_REQUEST['email_id'];
                $pswd = md5($_REQUEST['pswd']);

                $q1 = $_REQUEST['q1'];
                $q2 = $_REQUEST['q2'];
                $a1 = $_REQUEST['a1'];
                $a2 = $_REQUEST['a2'];

                $date_time = isset($_REQUEST['date_time']) ? $_REQUEST['date_time'] : '';
                if ($date_time != '') {
                    $dates = explode("@", $date_time);
                    $times = explode(":", $dates[1]);

                    $hh = $times[0];
                    $mm = $times[1];
                    $ss = $times[2];

                    if (strlen(trim($times[0])) < 2) {
                        $hh = "0" . trim($times[0]);
                    }
                    if (strlen(trim($times[1])) < 2) {
                        $mm = "0" . trim($times[1]);
                    }
                    if (strlen(trim($times[2])) < 2) {
                        $ss = "0" . trim($times[2]);
                    }

                    $day = explode("/", $dates[0]);
                    $month = $day[0];
                    $date = $day[1];

                    if (strlen($day[0]) < 2) {
                        $month = "0" . $day[0];
                    }
                    if (strlen($day[1]) < 2) {
                        $date = "0" . $day[1];
                    }
                }
                $ramdam = rand(100000, 900000);
                $datest = $month . "/" . $date . "/" . $day[2];
                $time_format = $hh . ":" . $mm . ":" . $ss;
                $todayDate = $time_format . " on " . $datest;
				
				try {
					$client = Controller::userDbconnection();
					$docs	= $client->getDoc($userid);
					echo "Email Address Already Exists";
					exit;
				} catch (Exception $e) {
					if ($e->getCode() == 404) {
						$doc1 = new CouchDocument($client);
						
						/*
						$companycon = Controller::companyDbconnection();
						$compdoc = $companycon->getDoc("freetrial");
						$company = $compdoc->name;
						
						$client = Controller::userDbconnection();
						//$doc = $client->getDoc("email_id_confirm");
						$doc1 = new couchDocument($client);
						
						$doc->$userid = array(
							'firstName' => $fname,
							'lastName' => $lname,
							'company' => $company,
							'code' => $ramdam,
							'email' => 'pending',
							'createdDate' => $todayDate,
							'status' => 'deactive'
						);
						*/
						// $client->storeDoc($doc);
						
						$doc1->set(array(
							'_id' => $userid,
							'status' => 'inactive',
							'company_id' => 'freetrial',
							'activecode' => $ramdam,
							'login_id' => array(
								'email_id' => $userid,
								'password' => $pswd,
								'q1' => strtolower($q1),
								'q2' => strtolower($q2),
								'a1' => strtolower($a1),
								'a2' => strtolower($a2)
							),
							'host_id' => array(
								'host_1' => array('Description' => 'EC4',
									'Host' => '76.191.119.98',
									'Router_String' => '',
									'Router_Port' => '',
									'System_Number' => '10',
									'System_ID' => 'EC4',
									'Language' => 'EN',
									'Extension' => 'on',
									'System_type' => 'ECC')
							),
							'host_upload' => array('76.191.119.98/10/EC4/' => array('client' => '210', 'user' => 'msreekanth')),
							'profile' => array(
								'fname' => $fname,
								'lname' => $lname,
								'phone' => $phone,
								'roles' => "Admin",
								'companyname' => $company,
								'streetaddress' => $street,
								'city' => $city,
								'state' => $state,
								'country' => $country,
								'help_en' => 0
							)/*,
							'bi_id' => array(
								'bi_1' => array('Description' => 'BOBJ: Demo System',
									'System_URL' => 'http://services.cloud.skytap.com:27393',
									'CMS_Name' => 'emgbo1',
									'CMS_Port' => '6400',
									'Auth_Type' => 'secEnterprise')
							),
							'bi_upload' => array('http://services.cloud.skytap.com:27393' => array('name' => 'thinui'))*/
						));

						require_once( dirname(__FILE__) . "/../components/phpmailer/class.phpmailer.php");
						$mail = new PHPMailer();
						$body = '<h4>Your thinui account activation deatils <h4>
							<table cellpadding="5px"><tr><td> Name </td><td>:&nbsp;' . $fname . ' ' . $lname . '</td></tr>
							<tr><td>Company </td><td>:&nbsp;' . $company . '</td></tr>
							<tr><td> Email Id </td><td>:&nbsp;' . $email_id . '</td></tr>
							<tr><td> Click here to Activate your Account </td>
							<td>:&nbsp;<a style="cursor:pointer" href="http://' . $_SERVER['HTTP_HOST'] . Yii::app()->request->baseUrl . '/?acode=' . base64_encode($ramdam) . '&em=' . base64_encode($email_id) . '" target="_blank">Activate</a></td></tr>
							</table>
							<br><br>
							<img src="http://' . $_SERVER['HTTP_HOST'] . '/' . Yii::app()->request->baseUrl . '/images/thinui-logo-login.png" style="width:100px;"/><br> ' . $todayDate;

						$address = "thinui@emergys.com";
						$user_name = 'Thinui Account Activation';

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

						$mail->Subject = "Activation your Account - Thinui";
						$mail->MsgHTML($body);
						$mail->SetFrom($address, $user_name);
						$mail->AddReplyTo($address, $user_name);
						$mail->AddAddress($email_id, $user_name);

						if (!$mail->Send()) {
							echo "Mailer Error: " . $mail->ErrorInfo;
						} else {
							//$client->storeDoc($doc);
							echo "Message sent!";
						}
						return;
					}
					else
					{
						echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
					}
					exit(1);
				}
            }
        }
        $this->render('register', array('model' => $model));
    }

    public function actionHost() {
        $model = new HostForm;
        // collect user input data
        if (isset($_POST['HostForm'])) {
            
        }
        // display the login form
        $this->render('host', array('model' => $model));
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
	{
       /* $userid = Yii::app()->user->getState("user_id");
        $client = Controller::userDbconnection();
        $doc = $client->getDoc($userid);

        $helps = Yii::app()->request->cookies['help_en']->value;
        $doc->profile->help_en = $helps;
        $client->storeDoc($doc);
		*/
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}