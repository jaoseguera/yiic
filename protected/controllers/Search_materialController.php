<?php
class Search_materialController extends Controller
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
            $model = new Search_materialForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
                $bObj->bapiCall($_REQUEST['bapiName']);

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }
	 
	 }
    public function actionSearch_material()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Search_materialForm;
            
            if(isset($_POST['bapiName']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
                $bObj->bapiCall($_POST['bapiName']);
                $model->_actionSubmit($fce);
            }            
            Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    
	 public function actionidocnumber()
    {
		if(isset($_REQUEST['I_DOCNUM']))
{
    $I_DOCNUM='0000000000'.trim($_REQUEST['I_DOCNUM']);
} 
global $rfc, $fce;  
$bObj   = new Bapi();
$bObj->bapiCall($_REQUEST['bapiName']);

//GEZG 06/22/2018
//Changing SAPRFC methods
$options = ['rtrim'=>true];
$res = $fce->invoke(["I_DOCNUM"=>$I_DOCNUM],$options);

$T_MESSAGE3=$res['T_MESSAGE'];
//var_dump($I_DOCNUM);
foreach($T_MESSAGE3 as $keys=>$value)
{
	foreach($value as $innerkeys=>$innervalues)
	{
		if(($innerkeys =='DESCRP') || ($innerkeys =='STAT_TXT')){
			echo '<br>'.$innervalues;
		}
	}
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