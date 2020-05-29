<?php
// This is a Proof-of-Concept version that has not been reviewed.
class Review_status_customersmasterController extends Controller {

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
	 public function actionTabledata() {
	     if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
			$model = new Review_status_customersmasterForm;
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
    public function actionReview_status_customersmaster() {
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
			$model = new Review_status_customersmasterForm;
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
				$bapiName=Controller::Bapiname($_REQUEST['url']);
                $bObj->bapiCall($bapiName);
                //GEZG 06/22/2018
                //Changing SAPRFC methods
                $options = ['rtrim'=>true];
                $res = $fce->invoke([],$options);

                $login = Yii::app()->user->getState("user_id");								
				$customer=$_REQUEST['CHNGE_NO'];
				$cusLenth = count($customer);
				if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }

                $res = $fce->invoke(['I_FIELD'=>'CHANGE',
                                    'I_CHANGENR'=>$customer,
                                    'I_SALES_ORG'=>$_REQUEST['SALES_ORG_NEW'],
                                    'I_DIST_CHAN'=>$_REQUEST['DIST_CNL_NEW'],
                                    'I_DIVISION'=>$_REQUEST['DVSN_NEW'],
                                    'I_NAME'=>$_REQUEST['NAME_NEW'],
                                    'I_HOUSE_NO'=>$_REQUEST['HOUSE_NO_NEW'],
                                    'I_STREET'=>$_REQUEST['STREET_NEW'],
                                    'I_CITY'=>$_REQUEST['CITY_NEW'],
                                    'I_STATE'=>$_REQUEST['REGION_NEW'],
                                    'I_SPRAS'=>$_REQUEST['I_SPRAS_NEW'],
                                    'I_ZIP'=>$_REQUEST['POSTL_CODE_NEW'],
                                    'I_COUNTRY'=>$_REQUEST['COUNTRY_NEW'],              
                                    'I_THINUI_USER'=>$login,
                                    'I_OBJECTTYPE'=>'CUSTOMER',
                                    'I_COMMENT'=>$_REQUEST['COMMENT'],
                                    'I_KTOKD'=>'ZB01'],$options);				

				$SalesOrder = $res['ET_MESSAGES'];
				foreach($SalesOrder as $h=>$f)
				{
				$msg.=$f['MESSAGE'].'<br/>';
				}
				if ($SalesOrder[0]['TYPE']=='S')
					echo 'S@'.'Change Number '.$_REQUEST['CHNGE_NO'].' has been updated';
				else	
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