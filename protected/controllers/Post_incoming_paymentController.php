<?php
class Post_incoming_paymentController extends Controller
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

    /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    **/
    public function actionPost_incoming_payment()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Post_incoming_paymentForm;
            if(isset($_POST['key']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_POST['key']);
                $bObj->bapiCall($bapiName);
                $model->_actionSubmit($fce);
            }
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'fce'=>$fce));
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