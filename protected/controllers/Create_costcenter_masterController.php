<?php
// This is a Proof-of-Concept version that has not been reviewed.
class Create_costcenter_masterController extends Controller
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
    public function actionCreate_costcenter_master()
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
    
    
    public function actionCreatecostcenter()
    {
        if(Yii::app()->user->hasState("login"))
        {
            global $rfc, $fce;
            $model = new CommonForm;
            if(isset($_REQUEST['scr'])) { $s_wid=$_REQUEST['scr']; }
            $bapiName = Controller::Bapiname($_REQUEST['url']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('createcostcenter',array('model'=>$model,'fce'=>$fce));
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