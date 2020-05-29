<?php
class Material_availabilityController extends Controller
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
            $model = new Material_availabilityForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
                $url = $_REQUEST['url'];
                $bObj = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }

    }
    public function actionMaterial_availability()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Material_availabilityForm;

            if(isset($_POST['key']))
            {
                global $rfc, $fce;
                $screen = CommonController::setScreen();

                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);

                $url = $_REQUEST['url'];
                $bObj   = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));
                $model->_actionSubmit($doc,$screen,$fce);
            }
			$userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
			$doc = $client->getDoc($userid);
			$screen = CommonController::setScreen();
			$count=$model->_actionColumncount($doc, $screen);
            Yii::app()->controller->renderPartial('index',array('model'=>$model,'count'=>$count));
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