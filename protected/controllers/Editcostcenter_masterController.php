<?php
// This is a Proof-of-Concept version that has not been reviewed.
class Editcostcenter_masterController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $screen;

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
	public function actionTabledata() {
	     if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
			$model = new Editcostcenter_masterForm;
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
     * */
    public function actionEditcostcenter_master() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;            
            Yii::app()->controller->renderPartial('index', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionCostcenter_details() {
        if (Yii::app()->user->hasState("login")) {
		
         global $rfc, $fce;
			$model = new Editcostcenter_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST['cust'])) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname('display_costcenter');
                $bObj->bapiCall($bapiName);

                $model->_actionDetails($doc, $screen, $fce);
            }            
            Yii::app()->controller->renderPartial('editcustomerspage', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionEdit_costcenter(){
		if (Yii::app()->user->hasState("login")) {
		
            global $rfc, $fce;
			$model = new Editcostcenter_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST)) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);
				
            Yii::app()->controller->renderPartial('edit_costcenter',array('model'=>$model,'fce'=>$fce));
			}
		}
	}
	/**
     * This is the action to handle external exceptions.
    **/
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                Yii::app()->controller->renderPartial('error', $error);
        }
    }
}