<?php
class Edit_retailer_usersController extends Controller
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
	public function actionEdit_retailer_users()
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
	
    public function actionGetusers()
    {
		if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				$user=$_POST['User'];
				$client 	= Controller::companyDbconnection();
				$Company_ID	= Yii::app()->user->getState("company_id");
				$doc		= $client->getDoc($Company_ID);
				$client1 	= Controller::userDbconnection();
				$udocs	 	= $client1->getDoc($user);
				foreach($doc->host_id as $key=>$val)
				{
					if($key==$udocs->system->host)
						$val_exp=$val;
				}
				
				if($val_exp->Connection_type=='Group')
				{
					
					$desc    = $val_exp->Description;
					$messageserver    = $val_exp->Host;
					$group    = $val_exp[3];
					$system_id  = $val_exp->System_ID;
					$language   = $val_exp->Language;
					$extended   = $val_exp->Extension;
					$login = array (
						"MSHOST"=>$messageserver,     // your host address here "76.191.119.98
						"R3NAME"=>$system_id,
						"GROUP"=>$group,
						"CLIENT"=>$client_id,
						"LANG"=>$language,
					);
					//print_r($login);
				}
				else
				{
					$desc    = $val_exp->Description;
					$host    = $val_exp->Host;
					$rout    = $val_exp->Router_Port;
					$rout_ip = $val_exp->Router_String;
					if($rout != NULL)
					{
						$host = '/H/'.$rout_ip.'/H/'.$host;
					}
					$system_num = $val_exp->System_Number;
					$system_id  = $val_exp->System_ID;
					$language   = $val_exp->Language;
					$extended   = $val_exp->Extension;
					$login = array (
						"ASHOST"=>$host,     // your host address here "76.191.119.98
						"SYSNR"=>$system_num,
						"SYSID"=>$system_id,
						"LANG"=>$language,
					);
				} 
			Yii::app()->user->setState("sap_login", $login);
			Yii::app()->controller->renderPartial('user', array('model' => $model, 'edit_user' => $user));
			}
        }else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionEdituser()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				
				$soldid=isset($_POST['SOLDTOID'])?$_POST['SOLDTOID']:'';
				$User 		= isset($_POST['User']) ? $_POST['User'] : "";
				$FName 		= isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : "";
				$LName 		= isset($_POST['LAST_NAME']) ? $_POST['LAST_NAME'] : "";
				//$Role		= isset($_POST['ROLE']) ? $_POST['ROLE'] : "";
				$Email		= isset($_POST['EMAIL']) ? $_POST['EMAIL'] : "";
				$CName=isset($_POST['cmp']) ? $_POST['cmp'] : "";
				$CAddress=isset($_POST['cmpad']) ? $_POST['cmpad'] : "";
				$Sys=isset($_POST['SAPSYSTEM']) ? $_POST['SAPSYSTEM'] : "";
				$status=isset($_POST['STATUS']) ? $_POST['STATUS']:"";
				$UN=isset($_POST['USER_NAME']) ? $_POST['USER_NAME'] : "";
				$PWD=isset($_POST['PASSWORD']) ? $_POST['PASSWORD'] : "";
				$Client_ID=isset($_POST['CLIENT_ID']) ? $_POST['CLIENT_ID'] : "";
				$level0		= isset($_POST['level0']) ? $_POST['level0'] : "";
				$level1		= isset($_POST['level1']) ? $_POST['level1'] : "";
				$level2 	= isset($_POST['level2']) ? $_POST['level2'] : "";
					$x = array();
					foreach($level0 as $key => $val)
					{
						//GEZG 08/13/2018
						//Chaning split to explode due that split is deprecated in PHP7
						$vals = explode("~", $val);
						$lvl0 = $vals[0];
						$lvl0_val = $vals[1];
						//$x[$lvl0_val] = true;
						foreach($level1 as $key1 => $val1)
						{
							$vals = explode("~", $val1);
							$lvl10 = $vals[0];
							$lvl11 = $vals[1];
							$lvl1_val = $vals[2];
							if($lvl0 == $lvl10)
							{
								$x[$lvl0_val][] = $lvl1_val;
								foreach($level2 as $key2 => $val2)
								{
									$vals = explode("~", $val2);
									$lvl20 = $vals[0];
									$lvl21 = $vals[1];
									$lvl22 = $vals[2];
									$lvl2_val = $vals[3];
									if($lvl11 == $lvl21)
									{
										$x[$lvl0_val][$lvl1_val][] = $lvl2_val;
									}
								}
							}
						}
					}
				$Company_ID	= Yii::app()->user->getState("company_id");
				
				try {
					$client 	= Controller::companyDbconnection();
					$cmpany_doc = $client->getDoc($Company_ID);
					$Name		= $cmpany_doc->name;
					
					$client1 	= Controller::userDbconnection();
					$doc1	 	= $client1->getDoc($User);
					$file=Yii::app()->params['salt'];
			if(file_exists($file)  || is_readable($file))
			{
			$data = file_get_contents($file);
			$arrdata = json_decode($data, true);
			$salt=md5($arrdata['Title']);
			}else
			{
				echo basename($file)." is not Available in Config folder.";
				exit;
				}
			
					if($UN!='')
					{
					$PWD=Controller::encryptIt($PWD,$salt);
					$UN=Controller::encryptIt($UN,$salt);
					}
						$doc1->profile->fname 			= $FName;
						$doc1->profile->lname 			= $LName;
						//$doc1->profile->roles 			= 'emg_retailer';
						$doc1->profile->companyname		= $Name;
						$doc1->login_id->email_id 		= $Email;
						
						$doc1->company_id 				= $Company_ID;
						$doc1->soldtoid      			=$soldid;
						$doc1->host_details='';
						$doc1->system->host		=$Sys;
						$doc1->system->username	=$UN;
						$doc1->system->password	=$PWD;
						$doc1->system->client_id=$Client_ID;
						$doc1->status	 				= $status;
						$doc1->company_name 			=$CName;
						$doc1->company_address			=explode(',',$CAddress);
						$doc1->selected_functions 		= $x;
					$result1 = $client1->storeDoc($doc1);
					echo "Updated Successfully";
				} catch (Exception $e) {
					if ($e->getCode() == 404) {
						echo "Specified Document does not exist!";
					}
					else
					{
						echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
					}
					exit(1);
				}
			}
        }
        else{
            $this->redirect(array('login/'));
        }
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