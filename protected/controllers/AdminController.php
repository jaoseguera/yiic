<?php
class adminController extends Controller
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
	 public function actionIndex() {
       
              
           
            $this->render('index');
       
    }
	public function actionLoginCheck()
    {
		 $client = Controller::couchDbconnection();
               
                $doc = $client->getDoc("admin_id");
				$email=$doc->login_id->email_id;
				$pass=$doc->login_id->password;
				if($email==$_REQUEST['email']&&$pass==$_REQUEST['pswd'])
				{
					Yii::app()->session['admin_user']=$email;
					echo 'done';
				}
				else
				{
					echo 'Invalid Username Or Password';
				}
	
	}
	public function actionBetaRequest()
    {
		 if (Yii::app()->session["admin_user"]):
		$client = Controller::couchDbconnection();
       $doc = $client->getDoc("email_id_confirm");
	 $betajson=json_encode($doc);
		 $this->render('betarequest',array('betajson'=>$betajson));
		 else:
            $this->redirect('../admin');
        endif;
        
    }
    public function actionFeedback()
    {
		if (Yii::app()->session["admin_user"]):
      $client = Controller::couchDbconnection();
       $doc = $client->getDoc("feedbacks");
	 $feedbackjson=json_encode($doc);
		 $this->render('feedback',array('feedbackjson'=>$feedbackjson));
		 else:
            $this->redirect('../admin');
        endif;
        
    }
    public function actionHelp()
    {
		if (Yii::app()->session["admin_user"]):
        $client = Controller::couchDbconnection();
       $doc = $client->getDoc("feedbacks");
	 $helpjson=json_encode($doc);
		 $this->render('help',array('helpjson'=>$helpjson));
		 else:
            $this->redirect('../admin');
        endif;
    }
    public function actionstatusactive()
	{
		$ids=$_POST['ids'];
		$client = Controller::couchDbconnection();
       $doc = $client->getDoc("email_id_confirm");
	   $doc->$ids->status='active';
	    $client->storeDoc($doc);
	}
	 public function actionhelpactive()
	{
		$ids=$_POST['ids'];
		$ida=explode(',',$ids);
		$client = Controller::couchDbconnection();
       $doc = $client->getDoc("feedbacks");
	  $doc->$ida[1]->help->$ida[0]->status='sent';
	    $client->storeDoc($doc);
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
                $this->render('error', $error);
        }
    }
                
}