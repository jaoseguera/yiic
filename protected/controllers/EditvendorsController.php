<?php
class EditvendorsController extends Controller
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
    public function actionEditvendors()
    {
        if(Yii::app()->user->hasState("login"))
        {
            // print_r($_REQUEST); exit;
            $model = new EditvendorsForm;
            if(isset($_REQUEST['url']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
                
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $url = $_REQUEST['url'];
                $bObj   = new Bapi();
                $bObj->bapiCall(Controller::Bapiname($url));
            }
             Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
    }
     public function actionEdit_vendors() {
        global $fce;
        if (Yii::app()->user->hasState("login")) {
             $model = new EditvendorsForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $doc    = $client->getDoc($userid);
            $url = $_REQUEST['url'];
            $bObj = new Bapi();
            $bObj->bapiCall(Controller::Bapiname($url));
            $vendor_num  = strtoupper($_REQUEST['VENDOR']);
            $cusLenth = count($vendor_num);
            if($cusLenth < 10 && $vendor_num!='') { $vendor_num = str_pad((int) $vendor_num, 10, 0, STR_PAD_LEFT); } else { $vendor_num = substr($vendor_num, -10); }
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $res = $fce->invoke(["I_VENDOR_NUMBER"=>$vendor_num],$options);                    
            $vendors_read = $res['E_LFA1'];
            $vendors_email= $res['E_ADSMTP'];
            Yii::app()->controller->renderPartial('/editvendors/edit_vendors', array('model'=>$model,'vendors_read' => $vendors_read,'vendors_email'=>$vendors_email));
        } else {
            $this->redirect(array('login/'));
        }
    }
    
     public function actionChange_vendors() {
        global $rfc,$fce;
        if (Yii::app()->user->hasState("login")) {
            $model = new EditvendorsForm;
            $userid = Yii::app()->user->getState('user_id');
            $client = Controller::userDbconnection();
            $doc    = $client->getDoc($userid);
            $url = $_REQUEST['url'];
            $bObj = new Bapi();
            $bObj->bapiCall(Controller::Bapiname($url));
            $vendor_num  = strtoupper($_REQUEST['LIFNR']);
            $cusLenth = count($vendor_num);
            if($cusLenth < 10 && $vendor_num!='') { $vendor_num = str_pad((int) $vendor_num, 10, 0, STR_PAD_LEFT); } else { $vendor_num = substr($vendor_num, -10); }
            //echo $vendor_num;            
            $I_VENDOR_CENTRAL=array("ADDR_NO"=>$vendor_num,"NAME"=>$_REQUEST['NAME1'],"CITY"=>$_REQUEST['ORT01'],"POSTL_COD1"=>$_REQUEST['PSTLZ'],"STREET"=>$_REQUEST['STRAS'],"HOUSE_NO"=>$_REQUEST['HNO'],"COUNTRY"=>$_REQUEST['LAND1'],"REGION"=>$_REQUEST['REGIO'],"SORT1"=>$_REQUEST['SORTL'],"SORT2"=>$_REQUEST['SORTL'],"E_MAIL"=>$_REQUEST['E_MAIL'],"TEL1_NUMBR"=>$_REQUEST['TELF1']);
            //print_r($I_VENDOR_CENTRAL);
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $res = $fce->invoke(["I_VENDOR_CENTRAL"=>$I_VENDOR_CENTRAL],$options);           
            $SalesOrder=$res['ET_MESSAGES'];
            if(empty($SalesOrder))
            {
                echo 'Vendor '.$vendor_num.' is successfully changed';
            }
            else
            {
                foreach($SalesOrder as $keys=>$val)
                {
                    echo $val['MESSAGE'];
                }
            }
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();
           // Yii::app()->controller->renderPartial('/editvendors/edit_vendors', array('model'=>$model,'vendors_read' => $vendors_read));
        } else {
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