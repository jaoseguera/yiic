<?php
// This is a Proof-of-Concept version that has not been reviewed.
class Editcustomers_masterController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $screen;

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     * */
    public function actionEditcustomers_master() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;            
            Yii::app()->controller->renderPartial('index', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	
	 public function actionDisplaycustomer() {
        if (Yii::app()->user->hasState("login")) {
			global $rfc, $fce;
			$model = new Editcustomers_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST['CUSTOMER_ID'])) {
				
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);

                $model->_actionSubmit($doc, $screen, $fce);
				}
            $this->renderPartial('editcustomerspage', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	
	public function actionEdit_customers(){
	if (Yii::app()->user->hasState("login")) {
		
            global $rfc, $fce;
			$model = new Approve_customers_masterForm;
            $screen = CommonController::setScreen();

           if (isset($_REQUEST)) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname('edit_customer_master');
                $bObj->bapiCall($bapiName);
                //GEZG 06/22/2018
                //Changing SAPRFC methods
                $customer = $_REQUEST['CUST'];
                $cusLenth = count($customer);
                if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
                $login = Yii::app()->user->getState("user_id");

                $options = ['rtrim'=>true];
                $res = $fce->invoke(['I_KUNNR'=>$customer,
                                    'I_NAME'=>$_REQUEST['NAME_NEW'],
                                    'I_HOUSE_NO'=>$_REQUEST['HOUSE_NO_NEW'],
                                    'I_STREET'=>$_REQUEST['STREET_NEW'],
                                    'I_CITY'=>$_REQUEST['CITY_NEW'],
                                    'I_STATE'=>$_REQUEST['REGION_NEW'],
                                    'I_ZIP'=>$_REQUEST['POSTL_CODE_NEW'],
                                    'I_COUNTRY'=>$_REQUEST['COUNTRY_NEW'],              
                                    'I_THINUI_USER'=>$login,
                                    'I_OBJECTTYPE'=>'CUSTOMER'],$options);
								
				$SalesOrder = $res['ET_MESSAGES'];
				foreach($SalesOrder as $h=>$f)
				{
				$msg.=$f['MESSAGE'].'<br/>';
				}
				echo $SalesOrder[0]['TYPE'].'@'.$msg;
			} 
                       
           
        } else {
            $this->redirect(array('login/'));
        }
	
	
	}
    /**
     * This is the action to handle external exceptions.
    **/
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                Yii::app()->controller->renderPartial('error', $error);
        }
    }
}