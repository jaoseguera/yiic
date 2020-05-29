<?php
class Picking_and_post_goodsController extends Controller
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
    public function actionPicking_and_post_goods()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Picking_and_post_goodsForm;
            global $rfc, $fce;
			if(isset($_REQUEST['key']))
            {
                            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['key']);
                $bObj->bapiCall($bapiName);
				//$model->_actionSubmit($doc, $screen, $fce);
				
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
	
	public function actionPicking()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Picking_and_post_goodsForm;
            if(isset($_REQUEST['key']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['key']);
                $bObj->bapiCall($bapiName);
				$model->_actionPostSubmit($doc, $screen, $fce);
				
            }
			
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
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