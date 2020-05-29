<?php
class Create_deliveryController extends Controller
{
    /**
    * Declares class-based actions.
    **/        
    public $screen;
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array( 'class'=>'CCaptchaAction', 'backColor'=>0xFFFFFF, ),
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
    public function actionCreate_delivery()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_deliveryForm;            
            if(isset($_POST['key']))
            {
                global $rfc, $fce;
                if(isset($_REQUEST['scr'])) { $s_wid=$_REQUEST['scr']; }
                $bapiName = Controller::Bapiname($_REQUEST['key']);
                $b = new Bapi();
                $b->bapiCall($bapiName);
                $model->_actionSubmit($fce);                
            }
			Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
	
    public function actionCommit()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_deliveryForm;            
            if(isset($_POST['key']))
            {
                global $rfc, $fce;
                if(isset($_REQUEST['scr'])) { $s_wid=$_REQUEST['scr']; }
                $bapiName = Controller::Bapiname($_REQUEST['key']);
                $b = new Bapi();
                $b->bapiCall($bapiName);
                $model->_actionCommit($fce);                
            }
			// Yii::app()->controller->renderPartial('index',array('model'=>$model));
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