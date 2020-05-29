<?php
class Product_availabilityController extends Controller
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
    public function actionProduct_availability()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Product_availabilityForm;
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
                $SalesOrder = $model->_actionSubmit($fce);
            }
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'SalesOrder'=>$SalesOrder));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    
	public function actionProduct_avl()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Product_availabilityForm;
            if(isset($_REQUEST['bapiName']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
                $bObj->bapiCall($_REQUEST['bapiName']);
                $SalesOrder = $model->_actionSubmit1($fce);
            }
            Yii::app()->controller->renderPartial('/common/product_avl',array('model'=>$model,'SalesOrder'=>$SalesOrder,'MATERIAL'=>$MATERIAL));
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