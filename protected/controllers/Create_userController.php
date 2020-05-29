<?php
class Create_userController extends Controller
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
	public function actionCreate_user()
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
	
    public function actionCreateuser()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				$FName 		= isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : "";
				$LName 		= isset($_POST['LAST_NAME']) ? $_POST['LAST_NAME'] : "";
				$Role		= isset($_POST['ROLE']) ? $_POST['ROLE'] : "";
				$Email		= isset($_POST['EMAIL']) ? $_POST['EMAIL'] : "";
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
					
					if(!$flag)
					{
						$doc1->_id 					= $Email;
						$doc1->profile->fname 		= $FName;
						$doc1->profile->lname 		= $LName;
						$doc1->profile->roles 		= $Role;
						$doc1->profile->companyname	= $Name;
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
							echo "Created Successfully";
						}
						else
							echo $mailstatus;
					}
					else
						echo "Email Id Already Exists";
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