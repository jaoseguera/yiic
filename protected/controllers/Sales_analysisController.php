<?php
class Sales_analysisController extends Controller
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
    public function actionSales_analysis()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Sales_reportsForm;
			 $screen = CommonController::setScreen(); 
			 $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc    = $client->getDoc($userid);
           
              
            
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'doc'=>$doc));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
       public function actionSaveurl()
    {
		$url=urldecode($_REQUEST['url']);
		$id=$_REQUEST['id'];
		 $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc    = $client->getDoc($userid);
				$doc->sales_analysis->$id=$url;
				$result = $client->storeDoc($doc);
				echo $url;
				
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