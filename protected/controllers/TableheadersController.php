<?php
class TableheadersController extends Controller
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
    public function actionIndex()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new TableheadersForm;
			$model->bapiName = 'DDIF_FIELDINFO_GET';
			
			
			if(!Yii::app()->user->getState("sap_login"))
				Yii::app()->user->setFlash('error', 'Please Login into the SAP System');
            $this->render('index', array('model'=>$model));
        }
        else
		{
            $this->redirect(array('login/'));
        }
    }
    
    public function actionStore()
    {
        if(Yii::app()->user->hasState("login"))
        {
			if(isset($_POST['TableheadersForm']))
			{
				global $rfc, $fce;
				$model = new TableheadersForm;
                $formvars = $_POST['TableheadersForm'];
				$model->Create_tableheader($formvars, true);
            }
        }
        else
		{
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