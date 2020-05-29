<?php
class Edit_companyController extends Controller
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
	public function actionEdit_company()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_companyForm;
			Yii::app()->controller->renderPartial('index',array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionGetcompanies()
    {
		if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_companyForm;
			if(isset($_POST))
			{
				Yii::app()->controller->renderPartial('company', array('model' => $model, 'edit_company' => $_POST['Company']));
			}
        }
	}
	
    public function actionEditcompany()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_companyForm;
			
			if(isset($_POST))
			{
				$Company_ID = isset($_POST['I_COMPANY']) ? $_POST['I_COMPANY'] : "";
				$Name		= isset($_POST['I_NAME']) ? $_POST['I_NAME'] : "";
				$Houseno 	= isset($_POST['HOUSE_NO']) ? $_POST['HOUSE_NO'] : "";
				$Street 	= isset($_POST['STREET']) ? $_POST['STREET'] : "";
				$City	 	= isset($_POST['CITY']) ? $_POST['CITY'] : "";
				$State	 	= isset($_POST['STATE']) ? $_POST['STATE'] : "";
				$Country 	= isset($_POST['COUNTRY']) ? $_POST['COUNTRY'] : "";
				$Zip	 	= isset($_POST['ZIP_CODE']) ? $_POST['ZIP_CODE'] : "";
				$Status	 	= isset($_POST['STATUS']) ? $_POST['STATUS'] : "";
				
				$FName 		= isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : "";
				$LName 		= isset($_POST['LAST_NAME']) ? $_POST['LAST_NAME'] : "";
				$Role		= isset($_POST['ROLE']) ? $_POST['ROLE'] : "";
				$Email		= isset($_POST['EMAIL']) ? $_POST['EMAIL'] : "";
				
				$level0		= isset($_POST['level0']) ? $_POST['level0'] : "";
				$level1		= isset($_POST['level1']) ? $_POST['level1'] : "";
				$level2 	= isset($_POST['level2']) ? $_POST['level2'] : "";
				
				try {
					$doc_id 	= 'companies';
					$doc_id1 	= 'users';
					$Password	= md5('admin@2014');
					$flag 		= false;
					
					//GEZG 07/26/2018
					//Changing split to explode due that split is deprecated in PHP7
					$x = array();
					foreach($level0 as $key => $val)
					{
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
					
					foreach($x as $key => $val)
					{
						if(is_array($val))
						{
							unset($x[$key][0]);
						}
					}
					
					$client 	= Controller::companyDbconnection();
					$client1 	= Controller::userDbconnection();
					
					$doc	= $client->getDoc($Company_ID);
					$primary_user = $doc->primary_user;
					
					if($primary_user != $Email)
					{
						$all_docs 	= $client1->getAllDocs();
						foreach ($all_docs->rows as $row)
						{
							if($row->id == $Email)
							{
								if($row->company_id != $Company_ID)
								{
									echo "Primary Email address already exists in other company.";
									exit();
								}
								else
									$flag = true;
							}
						}
						
						$doc1 = $client1->getDoc($primary_user);
						$doc1->profile->roles = "Regular";
						$client1->storeDoc($doc1);
					}
					else
						$flag = true;
					
					if($flag)
						$doc1 = $client1->getDoc($Email);
					else
					{
						$doc1 = new stdClass();
						$doc1->_id = $Email;
					}
					
					$doc->name 				= $Name;
					$doc->houseno 			= $Houseno;
					$doc->street 			= $Street;
					$doc->country 			= $Country;
					$doc->state 			= $State;
					$doc->city	 			= $City;
					$doc->zip	 			= $Zip;
					$doc->status			= $Status;
					$doc->primary_user		= $Email;
					$doc->default_functions = $x;
					$doc->roles->Regular	= $x;
					$result = $client->storeDoc($doc);
					
					$doc1->profile->fname 		= $FName;
					$doc1->profile->lname 		= $LName;
					$doc1->profile->companyname	= $Name;
					$doc1->profile->roles 		= $Role;
					
					if($primary_user != $Email)
					{
						$pwdtxt		= Yii::app()->epassgen->generate(12, 2, 3, 2);
						$Password	= md5($pwdtxt);
						
						$doc1->login_id->email_id 	= $Email;
						$doc1->login_id->password 	= $Password;
						$doc1->company_id 			= $Company_ID;
						$doc1->status	 			= 'initial';
						
						$body  = '<h4>User Login Details</h4>
									<p> Username : '.$Email.'</p>
									<p> Password : '.$pwdtxt.'</p>';
						
						$mailstatus = Controller::sentMail($body, $Email);
						if($mailstatus)
						{
							$result1 = $client1->storeDoc($doc1);
							echo "Updated Successfully";
						}
						else
							echo $mailstatus;
					}
					else
					{
						$result1 = $client1->storeDoc($doc1);
						echo "Updated Successfully";
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