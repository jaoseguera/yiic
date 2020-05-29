<?php
class Production_workbenchController extends Controller
{
    /**
    * Declares class-based actions.
    */        
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

 public function actionTabledata() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new Production_workbenchForm;
            $screen = CommonController::setScreen();

          
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }
    }

    /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    **/
    public function actionProduction_workbench()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Production_workbenchForm;
            $screen = CommonController::setScreen();
            
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
			
			
            $doc    = $client->getDoc($userid);
            ///////////////////////////////////////////////////////            
            $url = $_REQUEST['url'];
            if(isset($_REQUEST['scr']))
            {
                $s_wid = $_REQUEST['scr'];
            }
            
            global $rfc, $fce;
			$extended = Yii::app()->user->getState('extended');
			
            $bapiName=Controller::Bapinamemulity($_REQUEST['url'],$extended);
		  
            $b = new Bapi();            
            $b->bapiCall($bapiName);
            
            Yii::app()->user->setState("p_url", $url);            
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'doc'=>$doc,'fce'=>$fce,'screen'=>$screen));
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
                 Yii::app()->controller->renderPartial('error', $error);
        }
    }
                
}