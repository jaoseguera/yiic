<?php
class Picking_and_post_esignController extends Controller
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
    public function actionPicking_and_post_esign()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Picking_and_post_goodsForm;
            global $rfc, $fce;
			if(isset($_REQUEST['key']))
            {
                            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['key']);
                $bObj->bapiCall($bapiName);
				//$model->_actionSubmit($doc, $screen, $fce);
				
            }
			
             Yii::app()->controller->renderPartial('index',array('model'=>$model,'fce'=>$fce));
		
        }
        else{
            $this->redirect(array('login/'));
        }
    }
    
    /**
    * This is the action to handle external exceptions.
    **/
	
	public function actionPicking()
    {
        if(Yii::app()->user->hasState("login"))
        {
            $model = new Picking_and_post_goodsForm;
            if(isset($_REQUEST['key']))
            {
                global $rfc, $fce;            
                $screen = CommonController::setScreen();            
            
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                $res=$this->Store();
				if($res)
				{
                $bObj   = new Bapi();
				$bapiName=Controller::Bapiname($_REQUEST['key']);
                $bObj->bapiCall($bapiName);
				$model->_actionPostSubmit($doc, $screen, $fce);
				}else
					echo 'Signature Not uploaded properly';
            }
			
        }
        else{
            $this->redirect(array('login/'));
        }
    }
	public function Store()
    {
       
		global $fce;
		$bObj   = new Bapi();
		$bapiName=Controller::Bapiname('image_upload');
		$bObj->bapiCall($bapiName);
		//$bObj->bapiCall('/EMG/AWS_UPLOAD_GRAPHICS');
		if(isset($_REQUEST['img']))
		{
		$path = getcwd().DS.'upload'.DS;
		$filename = $path.uniqid() . '.bmp';
		$imageInfo =$_REQUEST['img']; // Your method to get the data
		$image = fopen($imageInfo, 'r');
		file_put_contents($filename, $image);
		fclose($image);
		
		
		ini_set('memory_limit','128M');
		
		$contents = file_get_contents($filename);
		$chunks = str_split($contents,1022);
		$byteCount = strlen($contents);
		$name=$_REQUEST['I_VBELN'];
		$sourceFile = $filename;
		$info = getimagesize($sourceFile);
		list($width, $height, $type, $attr) = getimagesize($sourceFile);
		//echo $type."<br />";
		$filetype = image_type_to_extension($type, true);
		$filetype = strtoupper(substr($filetype, 1));
		//echo $filetype."<br />";
		
		///////////////////////////////////////////////////////////////////////////////////
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$importTableITFile = array();
		$options = ['rtrim'=>true];
		$res = $fce->invoke([],$options);	
		///////////////////////////////////////////////////////////////////////////////////		
		foreach($chunks as $key => $val)
		{
		
			//$IT_FILE_CONTENT = $chunks[$key];
			$IT_FILE_CONTENT = array('LINE' => $val);
			array_push($importTableITFile, $IT_FILE_CONTENT);						
			//.................................................................................
		}
		$res = $fce->invoke(["I_SAVE_AS_NAME"=> $name,
							"I_SAVE_AS_DESC"=> $name.'.bmp',
							"I_SAVE_AS_COLOR"=> "X",
							"I_FILE_BYTECOUNT"=> $byteCount,
							"I_FILE_FORMAT"=> 'BMP',
							"IT_FILE_CONTENT"=>$importTableITFile],$options);
		$BapiMessage = $res['ET_MESSAGES'];
		foreach($BapiMessage as $key => $value)
			{
				if(is_array($value))
				{
					if($value["TYPE"] == "S")
						$BapiStatus[] = true;
					else
						$BapiStatus[] = false;
				}
				else
				{
					if($key == "TYPE")
					{
						if($value == "S")
							$BapiStatus[] = true;
						else
							$BapiStatus[] = false;
					}
				}
				
			}
	unlink($filename);
	 if(count($BapiMessage) == 0)
			return true;
		else
			return false;
        }
		
      
    }

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