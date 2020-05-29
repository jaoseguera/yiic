<?php
// This is a Proof-of-Concept version that has not been reviewed
class Approve_customers_masterController extends Controller {

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
 public function actionTabledata() {
	     if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
			$model = new Approve_customers_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
			
        } else {
            $this->redirect(array('login/'));
        }
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     * */
    public function actionApprove_customers_master() {
        if (Yii::app()->user->hasState("login")) {
            $model = new CommonForm;            
            Yii::app()->controller->renderPartial('index', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionCustomer_details() {
        if (Yii::app()->user->hasState("login")) {
		
         global $rfc, $fce;
			$model = new Approve_customers_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST['cust'])) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);

                $model->_actionDetails($doc, $screen, $fce);
            }            
            Yii::app()->controller->renderPartial('editcustomerspage', array('model' => $model));
        } else {
            $this->redirect(array('login/'));
        }
    }
	public function actionReject_customer(){
	if (Yii::app()->user->hasState("login")) {
		
         global $rfc, $fce;
			$model = new Approve_customers_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST['CHNGE_NO'])) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$customer=$_REQUEST['CHNGE_NO'];
				$cusLenth = count($customer);
				if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);
				//GEZG 06/21/2018
                //Changing SAPRFC methods
                $options = ['rtrim'=>true];
                $login = Yii::app()->user->getState("user_id");
                $res = $fce->invoke(["I_FIELD"=>'REJECTED',
                                    "I_CHANGENR"=>$customer,
                                    "I_COMMENT"=>$_REQUEST['COMMENT'],
                                    'I_THINUI_APPROVER'=>$login],$options);                
				echo "Change Number ".$_REQUEST['CHNGE_NO']." has been rejected";
                
            }            
           
        } else {
            $this->redirect(array('login/'));
        }
	
	
	}
	public function actionApprove_customer(){
	if (Yii::app()->user->hasState("login")) {
		
            global $rfc, $fce;
			$model = new Approve_customers_masterForm;
            $screen = CommonController::setScreen();

            if (isset($_REQUEST)) {
				$userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);
				$customer=$_REQUEST['CHNGE_NO'];
				$cusLenth = count($customer);
				if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
                $bObj = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);
                //GEZG 06/21/2018
                //Changing SAPRFC methods
                $login = Yii::app()->user->getState("user_id");
                $options = ['rtrim'=>true];
                $res = $fce->invoke(['I_FIELD'=>'APPROVED',
                            'I_CHANGENR'=>$customer,
                            'I_SALES_ORG'=>(string)$_REQUEST['SALES_ORG_NEW'],
                            'I_DIST_CHAN'=>(string)$_REQUEST['DIST_CNL_NEW'],
                            'I_DIVISION'=>(string)$_REQUEST['DVSN_NEW'],
                            'I_NAME'=>$_REQUEST['NAME_NEW'],
                            'I_HOUSE_NO'=>$_REQUEST['HOUSE_NO_NEW'],
                            'I_STREET'=>$_REQUEST['STREET_NEW'],
                            'I_CITY'=>$_REQUEST['CITY_NEW'],
                            'I_STATE'=>$_REQUEST['REGION_NEW'],
                            'I_ZIP'=>$_REQUEST['POSTL_CODE_NEW'],
                            'I_SPRAS'=>(string)$_REQUEST['I_SPRAS_NEW'],
                            'I_COUNTRY'=>$_REQUEST['COUNTRY_NEW'],
                            'I_THINUI_APPROVER'=>$login,
                            'I_COMMENT'=>$_REQUEST['COMMENT'],
                            'I_OBJECTTYPE'=>'CUSTOMER',
                            'I_KTOKD'=>'ZB01'],$options);				
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