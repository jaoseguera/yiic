<?php
class Display_billing_listController extends Controller
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
    
    public function actionDisplay_billing_list()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Display_billing_listForm;   
            if(isset($_POST['jum']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_POST['key']);
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
		//$bapiName = '/EMG/SD_FORM_INVOICE_GET';
		$b = new Bapi();
		$b->bapiCall($bapiName);
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(["I_BILLING_DOC_NUM" => $order],$options);		
		$msg= $res["ET_MESSAGES"][0];
		if($msg['TYPE']=='E')
		{
			echo $msg['MESSAGE'];
		}
		else
		{
			$rowsag = count($res["ET_FORM_PDF"]);     
			for($i=0;$i<$rowsag;$i++)
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
			$_SESSION['pdfname']='Invoice_'.ltrim($order, '0');
			$_SESSION['pdfstr']=$str;
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