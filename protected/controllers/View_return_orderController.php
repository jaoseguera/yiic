<?php
class View_return_orderController extends Controller
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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionView_return_order()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_userForm;
			Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    
	
	public function actionStringpdf()
    {
    	global $rfc,$fce;
		$order=$_REQUEST['order_num'];
		//$bapiName = '/EMG/SD_FORM_ORDER_CONFMN_GET';
		$bapiName = Controller::Bapiname('view_return_order');
		$b = new Bapi();
		$b->bapiCall($bapiName);
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["I_ORDER_NUM"=>$order],$options);
		
		$msg=$res['ET_MESSAGES'];		
		if($msg[0]['TYPE']=='E')
		{
			echo $msg[0]['MESSAGE'];
		}
		else
		{
		
		$SalesOrder=$res['ET_FORM_PDF'];
		
		 $str='';
            foreach($SalesOrder as $keys=>$value)
            {
				foreach($value as $innerkeys=>$innervalues)
				{
					$str.=$innervalues;
				}
			}
		}	
			$_SESSION['pdfname'] = 'Return_Order_'.ltrim($order, '0');
			$_SESSION['pdfstr']  = $str;
		
		
		//$_SESSION['pdfname'] = 'Return_order_'.ltrim($order, '0');
		//$_SESSION['pdfstr']  = $str;
	}
	/**
	 * This is the action to handle external exceptions.
	 */
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