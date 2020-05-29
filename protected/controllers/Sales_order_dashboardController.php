<?php
class Sales_order_dashboardController extends Controller
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
            $model = new Sales_order_dashboardForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				
				$bapiName=Controller::Bapiname($_REQUEST['url']);
				
                $bObj->bapiCall($bapiName);

                $model->_actionSubmit($doc, $screen, $fce);
				}
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }
    }

    /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    **/
    public function actionSales_order_dashboard()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Sales_order_dashboardForm;                        
            Yii::app()->controller->renderPartial('index',array('model'=>$model));
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