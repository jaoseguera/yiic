<?php
class Zreports2Controller extends Controller
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
	public function actionTabledata() {
		 if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new Zreports2Form;
            $screen = CommonController::setScreen();

           
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }
	 }

    public function actionZreports2()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Zreports2Form;
            if(isset($_POST['key']))
            {
                global $rfc, $fce;
                $screen = CommonController::setScreen();
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                $bapiName=Controller::Bapiname($_REQUEST['key']);
                $bObj   = new Bapi();            
                $bObj->bapiCall($bapiName);                
                $model->_actionSubmit($doc, $screen, $fce);
            } else
			{
             Yii::app()->controller->renderPartial('index',array('model'=>$model));
			}
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	
	public function actionCustomforms()
	{
		if(Yii::app()->user->hasState("login"))
		{
			global $rfc, $fce;
			$screen = CommonController::setScreen();
			$userid = Yii::app()->user->getState('user_id');
			$client = Controller::userDbconnection();
			$doc    = $client->getDoc($userid);
			if(isset($_REQUEST['subkey']))
			{
				$jform=$_REQUEST['jform'];
				$bapiName=Controller::Bapiname($_REQUEST['subkey']);
				$bObj   = new Bapi();  
				$bObj->bapiCall($bapiName); 
				//GEZG 06/22/2018
                //Changing SAPRFC methods
                $options = ['rtrim'=>true];
                $importTableSelection = array();
                foreach($jform as $key=>$val)
                {
                    if(!empty($val))
                    {
                        $value=array('SELNAME'=>$key,'SIGN'=>'I','OPTION'=>'EQ','LOW'=>$val);
                        array_push($importTableSelection, $value);
                    }
                }
                $res = $fce->invoke(['I_XCODE'=> $_REQUEST['REPORT_NAME'],
                                    'IT_SELECTION_TABLE' => $importTableSelection],$options);							
				$rowsag = count($res["ET_REPORT_TEXT"]);
				$j=1;
				for ($i=0;$i<$rowsag;$i++)
				{
					$lines=NULL;
					$tbody=NULL;
					
					$lines  = $res["ET_REPORT_TEXT"][$i];
					$lines  = substr($lines['LINE'],0);
					if($i==1)
						$header = explode('|',$lines);
					else
					{
						$tables = explode('|',$lines);
						$tbody = array_combine($header,$tables);
						$SalesOrder[$j] = $tbody;
						$j++;
					}
				}
				$_SESSION['report_text'] = $SalesOrder;
				echo 'ZT$@$';
				Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('screen' => $screen ));
				//json_encode($SalesOrder);
			}
			else
			{
				$bapiName=Controller::Bapiname($_REQUEST['key']);
				$bObj   = new Bapi();  
				
				$bObj->bapiCall($bapiName); 
				//GEZG 06/22/2018
                //Changing SAPRFC methods
                $options = ['rtrim'=>true];
                $res = $fce->invoke(['I_XCODE'=>$_REQUEST['REPORT_NAME']],$options);
				
				$rowsag = count($res["ET_SELECTION_LIST"]);
				for ($i=0;$i<$rowsag;$i++)
					$SalesOrder[]= $res["ET_SELECTION_LIST"][$i];
				
				echo 'ZR$@$'.json_encode($SalesOrder);
				$et_msg = count($res["ET_MESSAGES"]);
				if($et_msg!=0)
				{
					$line_error=$res["ET_MESSAGES"][0];
					echo '$@$'.$line_error['MESSAGE'];
					//print_r($line_error);
				}
			}
		}
		else
		{
			$this->redirect(array('login/'));
		}
	}
	public function actionRelease_pro()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Zreports2Form;
            if(isset($_REQUEST['bapiName']))
            {
                global $rfc, $fce;
                $screen = CommonController::setScreen();
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::couchDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();            
                $bObj->bapiCall($_REQUEST['bapiName']);                
                $model->_actionSubmit($doc, $screen, $fce);
            }
            //$this->render('index',array('model'=>$model));
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