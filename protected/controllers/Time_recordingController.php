<?php
class Time_recordingController extends Controller
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
    
	public function actionTabledata() {
	     if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
			$model = new Time_recordingForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);

                $Status = $model->_actionSubmit($doc, $screen, $fce);
				// print_r($Status);
				
				if(isset($Status['Start']))
					Yii::app()->controller->renderPartial('operations', array('model' => $model, 'screen' => $screen, 'Status' => $Status));
				else
					echo $Status;
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
			
        } else {
            $this->redirect(array('login/'));
        }
    }
	
    public function actionTime_recording()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new CommonForm;
            Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
    public function actionTimeaction()
    {
        if(Yii::app()->user->hasState("login"))
        {
			global $rfc, $fce;
			$model = new Time_recordingForm;
            $screen = CommonController::setScreen();
			
            if(isset($_POST))
			{
				$bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);
				
                $model->_actionOperation($doc, $screen, $fce);
			}
        }
        else{
            $this->redirect(array('login/'));
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
                $this->render('error', $error);
        }
    }
                
}