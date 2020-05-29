<?php
class Delete_rolesController extends Controller
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
	public function actionDelete_roles()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Create_rolesForm;
			Yii::app()->controller->renderPartial('index', array('model'=>$model));
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionGetroles()
    {
		if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_rolesForm;
			if(isset($_POST))
			{
				Yii::app()->controller->renderPartial('roles', array('model'=>$model));
			}
        }
	}
	
    public function actiondeleteroles()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Create_rolesForm;
			if(isset($_POST))
			{
				$role		= isset($_POST['Users']) ? $_POST['Users'] : "";
				$Company_ID	= Yii::app()->user->getState("company_id");
				
				try {
					$client = Controller::companyDbconnection();
					$docs	= $client->getDoc($Company_ID);
					
					if(isset($docs->roles->$role))
					{
						$roles 	= $docs->roles;
						$sd 	= json_encode($roles);
						$gs 	= json_decode($sd, true);
						unset($gs[$role]);
						$docs->roles = $gs;
						$result = $client->storeDoc($docs);
						echo "Role Deleted Successfully";
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