<?php
class Search_purchase_requisitionController extends Controller
{
    /**
    * Declares class-based actions.
    **/        
    public $screen;
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array( 'class'=>'CCaptchaAction', 'backColor'=>0xFFFFFF, ),
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
	public function actionTabledata()
	{
		 if (Yii::app()->user->hasState("login"))
		 {
            global $rfc, $fce;
            $model = new Search_purchase_requisitionForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit')
			{
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$url = $_REQUEST['url'];

                $bObj = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        }
		else
		{
            $this->redirect(array('login/'));
        }
	 }
	public function actionTabledataRelease()
	{
		if (Yii::app()->user->hasState("login"))
		{
            global $rfc, $fce;
            $model = new Search_purchase_requisitionForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit')
			{
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$url = $_REQUEST['table_name'];
				
                $bObj = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));

                $model->_actionSubmitRel($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        }
		else
		{
            $this->redirect(array('login/'));
        }
	}
	public function actionTabledataPO()
	{
		if (Yii::app()->user->hasState("login"))
		{
            global $rfc, $fce;
            $model = new Search_purchase_requisitionForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit')
			{
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$url = $_REQUEST['table_name'];
				
                $bObj = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));

                $model->_actionSubmitPO($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        }
		else
		{
            $this->redirect(array('login/'));
        }
	}
    public function actionSearch_purchase_requisition()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Search_purchase_requisitionForm;
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
	public function actioncreatepo()
	{
		
		$data= $_REQUEST['po'];
		$exdata=explode('@',$data);
		$exdata=array_filter($exdata);
		 global $rfc, $fce;
		 $bObj = new Bapi();
          $bObj->bapiCall('BAPI_PO_CREATE1');
		  //GEZG 06/22/2018
        //Changing SAPRFC methods
        $importTablePOITEM = array();
        $importTablePOITEMX = array();
        $options = ['rtrim'=>true];

        $POHEADER=array('DOC_TYPE'=>'NB','OUR_REF'=>$_REQUEST['reff']);
        $POHEADERX=array('DOC_TYPE'=>'X','OUR_REF'=>'X');

        $item=0;
        foreach($exdata as $key=>$val){
            $item=$item+10;
            $vals=explode(',',$val);
            $POITEM=array('PO_ITEM'=>$item,'PREQ_NO'=>$vals[0],'PREQ_ITEM'=>$vals[1]);
            $POITEMX=array('PO_ITEM'=>$item,'PO_ITEMX'=>'X','PREQ_NO'=>'X','PREQ_ITEM'=>'X');
            array_push($importTablePOITEM, $POITEM);
            array_push($importTablePOITEMX, $POITEMX);            
        }

        $res = $fce->invoke(["POHEADER" => $POHEADER,
                            "POHEADERX" => $POHEADERX,
                            "POITEM" => $importTablePOITEM,
                            "POITEMX" => $importTablePOITEMX],$options);
		  
          		   
        $exp=$res['EXPPURCHASEORDER'];
		if($exp!=NULL)
		{
			echo $exp.'<br>';
		}
				
        $RETURN=$res['RETURN'];
		$msg='';
		foreach($RETURN as $rkey=>$rval)
		{
			$msg.=$rval['MESSAGE'].'<br>';
		}
		echo $msg;

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