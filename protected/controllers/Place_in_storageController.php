<?php
class Place_in_storageController extends Controller
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
    public function actionPlace_in_storage()
    {
        if(Yii::app()->user->hasState("login"))
        {
            // print_r($_REQUEST); exit;
            $model = new Place_in_storageForm;
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
            }
            Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
    }





    public function actionSave_storage()
    {
        if(Yii::app()->user->hasState("login"))
        {
            global $rfc, $fce;
            $model = new Place_in_storageForm();
            if(isset($_REQUEST['scr'])) { $s_wid = $_REQUEST['scr']; }
            $bapiName = Controller::Bapiname($_REQUEST['bapiName']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('save_place_in_storage',array('model'=>$model,'fce'=>$fce));
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