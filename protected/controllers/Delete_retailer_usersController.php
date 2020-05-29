<?php
class Delete_retailer_usersController extends Controller
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
	public function actionDelete_retailer_users()
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
	
    public function actionDeleteuser()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_userForm;
			if(isset($_POST))
			{
				$role		= isset($_POST['Users']) ? $_POST['Users'] : "";
				try {
					$client = Controller::userDbconnection();
					$docs	= $client->getDoc($role);
					$client->deleteDoc($docs);
					// $docs->status = 'inactive';
					// $client->storeDoc($docs);
					echo "User Deleted Successfully";
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