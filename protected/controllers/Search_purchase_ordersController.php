<?php
class Search_purchase_ordersController extends Controller
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
	
	public function actionTabledata() {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new Search_purchase_ordersForm;
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
	 public function actionStrgpdf()
    {
		
		
		 global $rfc, $fce;
		$order=$_REQUEST['VAL'];
		// $bapiName = '/EMG/MM_FORM_PURCH_ORDER_GET';
			$bapiName=Controller::Bapiname('purchase_order_doc');
		  $b = new Bapi();
            $b->bapiCall($bapiName);
			//GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $res = $fce->invoke(["I_PURCHASING_DOC_NUM"=>$order],$options);						
			$msg= $res["ET_MESSAGES"][0];
    if($msg['TYPE']=='E')
	{
		echo $msg['MESSAGE'];
	}
	else
	{
		    $rowsag = count($res["ET_FORM_PDF"]);     
	        for ($i=0;$i<$rowsag;$i++){
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
			$_SESSION['pdfname']='Purchase_Order_'.ltrim($order, '0');
			$_SESSION['pdfstr']=$str;
	}
	
	}
    public function actionSearch_purchase_orders()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Search_purchase_ordersForm;
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
                 Yii::app()->controller->renderPartial('error', $error);
        }
    }                
}