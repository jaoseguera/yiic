<?php
class Customer_open_items_headController extends Controller
{
    /**
    * Declares class-based actions.
    */        
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
			$model = new Customer_open_item_headForm;
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
	 public function actionTabledataall() {
	     if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
			$model = new Customer_open_item_headForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname('customer_all_items');
                $bObj->bapiCall($bapiName);

                $model->_actionSubmitall($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
			
        } else {
            $this->redirect(array('login/'));
        }
    }
    public function actionCustomer_open_items_head()
    {
        if(Yii::app()->user->hasState("login"))
        {            
            $model = new CommonForm;
			$models = new Customer_open_item_headForm;
			$userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
			$doc = $client->getDoc($userid);
			$screen = CommonController::setScreen();
			$count=$models->_actionColumncount($doc, $screen);
			 Yii::app()->controller->renderPartial('index',array('model'=>$model,'count'=>$count));
           
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    public function actionHeader()
    {
		$model = new CommonForm;
		$models = new Customer_open_item_headForm;
		global $rfc, $fce;            
		$screen = CommonController::setScreen();            
		
		$userid = Yii::app()->user->getState('user_id');
		$client = Controller::userDbconnection();
		$doc    = $client->getDoc($userid);
		$bObj   = new Bapi();
		$bapiName=Controller::Bapiname($_REQUEST['key']);
		$bObj->bapiCall($bapiName);
		
		 Yii::app()->controller->renderPartial('head',array('model'=>$model,'count'=>$count,'fce'=>$fce));
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