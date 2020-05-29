<?php
class Edit_purchase_orderController extends Controller
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
    public function actionEdit_purchase_order()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new EditsalesorderForm;
            if(isset($_REQUEST['key']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
                
                $userid 	= Yii::app()->user->getState('user_id');
                $client 	= Controller::userDbconnection();
                $doc    	= $client->getDoc($userid);
                $bObj   	= new Bapi();
				$bapiName 	= Controller::Bapiname($_REQUEST['key']);
                $bObj->bapiCall($bapiName);
            }
			Yii::app()->controller->renderPartial('index', array('model'=>$model));
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
                 Yii::app()->controller->renderPartial('error', $error);
        }
    }
                
}