<?php
class Create_sales_orderController extends Controller
{
    /**
    * Declares class-based actions.
    **/        
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
    public function actionCreate_sales_order()
    {
        
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_sales_orderForm;
			if(isset($_REQUEST['CUSTOMER']))
            {
                $customerNo = $_REQUEST['CUSTOMER'];
            }
			
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'customerNo'=>$customerNo));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    
    public function actionOrder_sales()
    {
        if(Yii::app()->user->hasState("login"))
        {            
            global $rfc, $fce;
            $model = new Create_sales_orderForm;
            if(isset($_REQUEST['scr'])) { $s_wid=$_REQUEST['scr']; }
            $bapiName = Controller::Bapiname($_REQUEST['url']);
            $b = new Bapi();
            $b->bapiCall($bapiName);
            Yii::app()->controller->renderPartial('order_sales',array('model'=>$model,'fce'=>$fce));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	public function actionSales_order_from_quotation()
	{
        global $rfc,$fce;
	$model = new Create_sales_orderForm;
			
            if(isset($_REQUEST['CUSTOMER']))
            {
                $customerNo = $_REQUEST['CUSTOMER'];
            }
			
            
	$b = new Bapi();
    $b->bapiCall($_REQUEST['bapiName']);
   $sales= $_REQUEST['I_VBELN'];
   
   $cusLenth1 = count($sales);
   if($cusLenth1 < 10 && $sales != "") { $sales = str_pad($sales, 10, 0, STR_PAD_LEFT); } else { $sales = substr($sales, -10); }
   
   
   
   //GEZG 06/21/2018
   //Changing SAPRFC methods
   $I_BAPI_VIEW = array('HEADER' => 'X', 'ITEM' => 'X');
   $importTableView = array();
   $SALES_DOCUMENTS = array("VBELN" => $sales);
   array_push($importTableView, $SALES_DOCUMENTS);
   $options = ['rtrim'=>true];
   $res = $fce->invoke(["I_BAPI_VIEW" => $I_BAPI_VIEW,
                        'SALES_DOCUMENTS' => $importTableView],$options);
   
   $ORDER_HEADERS_OUT = $res['ORDER_HEADERS_OUT'];
   $ORDER_ITEMS_OUT = $res['ORDER_ITEMS_OUT'];
	
	 Yii::app()->controller->renderPartial('index',array('model'=>$model,'customerNo'=>$customerNo,'ORDER_ITEMS_OUT'=>$ORDER_ITEMS_OUT,'ORDER_HEADERS_OUT'=>$ORDER_HEADERS_OUT,'I_VBELN'=>$sales));
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