<?php
class Approve_purchase_requisitionController extends Controller
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
    public function actionTabledata()
	{
		if (Yii::app()->user->hasState("login"))
		{
            global $rfc, $fce;
            $model = new Approve_purchase_requisitionForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit')
			{
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$url = $_REQUEST['table_name'];
				
                $bObj = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));
                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
		} else {
            $this->redirect(array('login/'));
        }
	}
	
	public function actionApprove_request()
	{
		global $rfc, $fce; 
		$bObj   = new Bapi();
		$bObj->bapiCall($_REQUEST['bapiName']);
		
		$NUMBER=$_REQUEST['NUMBER'];
		$NUMBERLenth = count($NUMBER);
		if($NUMBERLenth < 10 && $NUMBER!='') { $NUMBER = str_pad((int) $NUMBER, 10, 0, STR_PAD_LEFT); } else { $NUMBER = substr($NUMBER, -10); }
		$release_code=$_REQUEST['PO_REL_CODE'];
		//GEZG 06/21/2018
		//Changing SAPRFC methods
		$options=['rtrim'=>true];
		$res = $fce->invoke(['NUMBER'=>$NUMBER,
							'REL_CODE'=>$release_code,
							'NO_COMMIT_WORK'=>""],$options);
	
		$export_msg=$res['REL_INDICATOR_NEW'];
		$dt=0;
		$hs="";
		if($export_msg!=NULL)
		{
			$hs="Purchase requisition ".$NUMBER." is successfully released";
		}
		else
		{			
			$SalesOrder=$res['RETURN'];
			$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
			$fce->invoke();			
			
			foreach($SalesOrder as $keys)
			{
				$hs.=$keys['MESSAGE']."<br>";
				$ty=$keys['TYPE'];
				if($ty!='S')
				{
					$dt=1;
				}
			}
		}
		echo $hs;	
	}
	
    public function actionApprove_purchase_requisition()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Approve_purchase_requisitionForm;
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