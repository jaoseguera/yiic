<?php
class EditsalesquotationController extends Controller
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
    public function actionEditsalesquotation()
    {
        if(Yii::app()->user->hasState("login"))
        {
            // print_r($_REQUEST); exit;
            $model = new EditsalesorderForm;
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
    
	public function actionStringpdf()
    {
		global $rfc, $fce;
		$order=$_REQUEST['order_num'];
		$bapiName=Controller::Bapiname($_REQUEST['bapi']);
		//$bapiName = '/EMG/SD_FORM_ORDER_CONFMN_GET';
		$b = new Bapi();
		$b->bapiCall($bapiName);
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_ORDER_NUM"=>$order],$options);		
		$msg= $res["ET_MESSAGES"][1];
		if($msg['TYPE']=='E')
		{
			echo $msg['MESSAGE'];
		}
		else
		{
		    $rowsag = count($res["ET_FORM_PDF"]);     
	        for ($i=0;$i<$rowsag;$i++)
			{
				$SalesOrder[]= $res["ET_FORM_PDF"][$i];
				//var_dump($SalesOrder);
			} 
	        $str='';
            foreach($SalesOrder as $keys=>$value)
            {
				foreach($value as $innerkeys=>$innervalues)
				{
					$str.=$innervalues;
				}
			}
			//echo $str;
			$_SESSION['pdfname'] = 'Sales_Quotation_Confirmation_'.ltrim($order, '0');
			$_SESSION['pdfstr']  = $str;
		}
	}
	
	public function actionPdfurl()
    {
		   $model = new EditsalesorderForm;
		Yii::app()->controller->renderPartial('/common/stringpdf',array('model'=>$model));
	}
	
	public function actionSave_sales_quotation()
    {
        if(Yii::app()->user->hasState("login"))
        {            
            global $rfc, $fce;
            $model = new EditsalesorderForm;
            if(isset($_REQUEST['scr'])) { $s_wid = $_REQUEST['scr']; }
            $bapiName = $_REQUEST['bapiName'];
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('save_sales_quotation',array('model'=>$model,'fce'=>$fce));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
	public function actionCommit()
    {
        if(Yii::app()->user->hasState("login"))
        {            
			global $rfc, $fce;
            $model = new EditsalesorderForm;
            if(isset($_REQUEST['scr'])) { $s_wid = $_REQUEST['scr']; }
            $bapiName = $_REQUEST['bapiName'];
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('save_sales_quotation',array('model'=>$model,'fce'=>$fce));
            //GEZG 06/22/2018
            //Changing SAPRFC methods
			$fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();            
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