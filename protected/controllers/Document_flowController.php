<?php
class Document_flowController extends Controller
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
			$model = new Document_flowForm;
            $screen = CommonController::setScreen();

            /*if (isset($_POST) && $_POST['from'] == 'submit') {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc = $client->getDoc($userid);
				
                $bObj = new Bapi();
                $bObj->bapiCall($_REQUEST['bapiName']);

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));*/
			
			if(isset($_POST))
			{
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				
				if ($_POST['from'] == 'submit')
				{
					$bObj = new Bapi();
					$bapiName=Controller::Bapiname($_REQUEST['url']);
					$bObj->bapiCall($bapiName);
				}
				$model->_actionSubmit($doc, $screen, $fce);
			}
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
			
        } else {
            $this->redirect(array('login/'));
        }
    }
    public function actionDocument_flow()
    {
        if(Yii::app()->user->hasState("login"))
        {            
            $model = new CommonForm;
			$models = new Document_flowForm;
			$userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
			$doc = $client->getDoc($userid);
			$screen = CommonController::setScreen();
			$count=$models->_actionColumncount($doc, $screen);
            Yii::app()->controller->renderPartial('index',array('model'=>$model,'count'=>$count));
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