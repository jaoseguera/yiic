<?php

class Forget_passwordController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $screen;

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
        $model = new Forget_passwordForm;
        // collect user input data        
        if (isset($_POST['email'])) {
            $ques = "";
            $ans = "";
            $email = $_POST['email'];
            $company = Controller::companyDbconnection();
            $client = Controller::userDbconnection();
            try {
                $doc = $client->getDoc($email);
                $companydoc = $company->getDoc($doc->company_id);
                if ($doc && $doc->status != "inactive" && $companydoc->status != "inactive") {
                    if (!isset($_REQUEST['questions'])) {
                        echo "This Email Id All Ready Exists";
                    }
                    if (isset($_REQUEST['questions'])) {
                        $q = $doc->login_id;
                        $ques.=$q->q1 . ",";
                        $ques.=$q->q2 . ",";
                        $ans.=$q->a1 . ",";
                        $ans.=$q->a2 . ",";
                        echo $ques;
                        echo $ans;
                    }
                } else {
                    if (isset($_REQUEST['questions'])) {
                        echo "Please contact your admin to change the password";
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            return;
        }
        // display the login form
        $this->render('index', array('model' => $model));
    }

    public function actionVerifi_password() {
        $model = new Forget_passwordForm;
        // collect user input data        
        if (isset($_REQUEST['user_id'])) {
            $userid=$_REQUEST['user_id'];
            $type=$_REQUEST['type'];
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);
            
            if ($type == 'send') {
                $ramdom = rand(999, 10000);
                $time = "";
                $doc->profile->verifi_pass = $ramdom;
                $doc->profile->verifi_time = $time;
                $client->storeDoc($doc);

                require_once( dirname(__FILE__) . "/../components/phpmailer/class.phpmailer.php");
                $mail = new PHPMailer();
                $body = "Your password verification code is :" . $ramdom;

                $address = "thinui@emergys.com";
                $user_name = 'Thinui Account Verification Code';
                $mail_to = $userid;
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

                $mail->Subject = "Forgot Password Verification Code - Thinui";
                $mail->MsgHTML($body);
                $mail->SetFrom($address, $user_name);
                $mail->AddReplyTo($address, $user_name);
                $mail->AddAddress($mail_to, $mail_to);

                if (!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message has been sent";
                }
            } else {
                $db_verifi = $doc->profile->verifi_pass;
                if (trim($_REQUEST['verify']) == trim($db_verifi)) {
                    echo "done";
                } else {
                    echo "cancel";
                }
            }
            return;
        }
        // display the login form
        $this->render('index', array('model' => $model));
    }

    public function actionNewpassword()
    {
        $email = $_REQUEST['email'];
        $client = Controller::userDbconnection();
        $doc = $client->getDoc($email);
		
		unset($doc->profile->verifi_pass);
		unset($doc->profile->verifi_time);
		
        $change = $doc->login_id;
        $change->password=md5($_REQUEST['pass']);
		
		if($doc->status == "initial")
			$doc->status = "active";
		
        $client->storeDoc($doc);
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

}