<?php
class Create_retailer_usersController extends Controller
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
	public function actionCreate_retailer_users()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_userForm;
			Yii::app()->controller->renderPartial('index',array('model'=>$model,'service'=>$_REQUEST['typ']));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionCreateuser()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
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
				$soldid=isset($_POST['SOLDTOID'])?$_POST['SOLDTOID']:'';
				$FName 		= isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : "";
				$LName 		= isset($_POST['LAST_NAME']) ? $_POST['LAST_NAME'] : "";
				$Role		= isset($_POST['ur']) ? $_POST['ur'] : "";
				$status=isset($_POST['status'])?'active':'inactive';
				if($Role=='Create Retailer Users')
					$Role='emg_retailer';
				elseif($Role=='Create Customer Service Users')
					$Role='emg_customer_service';
				else
					$Role='emg_retailer_service';
					
				$Email		= isset($_POST['EMAIL']) ? $_POST['EMAIL'] : "";
				$CName=isset($_POST['cmp']) ? $_POST['cmp'] : "";
				$CAddress=isset($_POST['cmpad']) ? $_POST['cmpad'] : "";
				$Sys=isset($_POST['SAPSYSTEM']) ? $_POST['SAPSYSTEM'] : "";
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
						$x[$lvl0_val][] = true;
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
					$doc_id1 	= 'users';
					$pwdtxt		= Yii::app()->epassgen->generate(12, 2, 3, 2);
					$Password	= md5($pwdtxt);
					$flag 		= false;
					
					$client 	= Controller::companyDbconnection();
					$cmpany_doc = $client->getDoc($Company_ID);
					$Name		= $cmpany_doc->name;
					
					$client1 	= Controller::userDbconnection();
					$all_docs 	= $client1->getAllDocs();
					// echo "Database got ".$all_docs->total_rows." documents.<BR>\n";
					foreach ($all_docs->rows as $row)
					{
						if($row->id == $Email)
							$flag = true;
					}
					if($UN!='')
					{
					$PWD=Controller::encryptIt($PWD,$salt);
					$UN=Controller::encryptIt($UN,$salt);
					}
					if(!$flag)
					{
						$doc1->_id 					 = $Email;
						$doc1->profile->fname 		 = $FName;
						$doc1->profile->lname 		 = $LName;
						$doc1->profile->roles 		 = $Role;
						$doc1->profile->companyname	 = $Name;
						$doc1->login_id->email_id 	 = $Email;
						$doc1->login_id->password 	 = $Password;
						$doc1->company_id 			 = $Company_ID;
						$doc1->soldtoid		     	 =$soldid;
						$doc1->system->host				 =$Sys;
						$doc1->system->username	=$UN;
						$doc1->system->password	=$PWD;
						$doc1->system->client_id=$Client_ID;
						$doc1->status	 			 = 'initial';
						$doc1->company_name 		 =$CName;
						$doc1->company_address		 =explode(',',$CAddress);
						$doc1->selected_functions    = $x;
					
						$body  = '<h4>User Login Details</h4>
									<p> Username : '.$Email.'</p>
									<p> Password : '.$pwdtxt.'</p>';
						
						$mailstatus = Controller::sentMail($body, $Email);
						if($mailstatus)
						{
							$result1 = $client1->storeDoc($doc1);
							echo "Created Successfully";
						}
						else
							echo $mailstatus;
					}
					else
						echo "Email Id Already Exists";
						
					foreach($x as $key => $val)
					{
						if(is_array($val))
						{
							unset($x[$key][0]);
						}
					}	
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
