<?php
class Edit_userController extends Controller
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
	public function actionEdit_user()
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
				Yii::app()->controller->renderPartial('user', array('model' => $model, 'edit_user' => $_POST['User']));
			}
        }
	}
	
    public function actionEdituser()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				$User 		= isset($_POST['User']) ? $_POST['User'] : "";
				$FName 		= isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : "";
				$LName 		= isset($_POST['LAST_NAME']) ? $_POST['LAST_NAME'] : "";
				$Role		= isset($_POST['ROLE']) ? $_POST['ROLE'] : "";
				$Email		= isset($_POST['EMAIL']) ? $_POST['EMAIL'] : "";
				$Status	 	= isset($_POST['STATUS']) ? $_POST['STATUS'] : "";
				$Company_ID	= Yii::app()->user->getState("company_id");
				
				try {
					$client 	= Controller::companyDbconnection();
					$cmpany_doc = $client->getDoc($Company_ID);
					$Name		= $cmpany_doc->name;
					
					$client1 	= Controller::userDbconnection();
					$docs	 	= $client1->getDoc($User);
					
					$docs->profile->fname 		= $FName;
					$docs->profile->lname 		= $LName;
					$docs->profile->companyname	= $Name;
					$docs->profile->roles 		= $Role;
					$docs->login_id->email_id 	= $Email;
					$docs->status				= $Status;
					$docs->company_id 			= $Company_ID;
					$result1 = $client1->storeDoc($docs);
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