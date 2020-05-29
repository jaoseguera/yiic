<?php
class InforecordsController extends Controller
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
    public function actionInforecords()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new InforecordsForm;
            if(isset($_POST['bapiName']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
                $bObj->bapiCall($_POST['bapiName']);
                $model->_actionSubmit($fce);
            }
            $this->render('index',array('model'=>$model,'fce'=>$fce));
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