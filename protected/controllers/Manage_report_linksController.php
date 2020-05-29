<?php
class Manage_report_linksController extends Controller
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
	public function actionManage_report_links()
	{
		if(Yii::app()->user->hasState("login"))
        {
			Yii::app()->controller->renderPartial('index');
        }
        else{
            $this->redirect(array('login/'));
        }
	}
	
    public function actionCreatelinks()
    {
        if(Yii::app()->user->hasState("login"))
        {
			if(isset($_REQUEST))
			{
				$systemid	= $_REQUEST['systemid'];
				$clientid	= $_REQUEST['clientid'];
				$links		= $_REQUEST['links'];
				
				$companyid	= Yii::app()->user->getState("company_id");
				$user_host	= Yii::app()->user->getState("user_host");
				$user_id	= Yii::app()->user->getState("user_id");
				try {
					if($user_host)
					{
						$client 	= Controller::userDbconnection();
						$hostdoc 	= $client->getDoc($user_id);
					}
					else
					{
						$client		= Controller::companyDbconnection();
						$hostdoc	= $client->getDoc($companyid);
					}
					
					foreach($links as $key => $value)
					{
						unset($links[$key]);
						$links[$key."_reports"] = $value;
					}
					
					if(isset($hostdoc->reports->$systemid->$clientid))
						echo "Client Already Exists";
					else
					{
						$hostdoc->reports->$systemid->$clientid = $links;
						$result = $client->storeDoc($hostdoc);
						echo "Client Created Successfully";
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
	
    public function actionUpdatelinks()
    {
        if(Yii::app()->user->hasState("login"))
        {
			if(isset($_REQUEST))
			{
				$systemid	= $_REQUEST['systemid'];
				$clientid	= $_REQUEST['clientid'];
				$links		= $_REQUEST['links'];
				
				$companyid	= Yii::app()->user->getState("company_id");
				$user_host	= Yii::app()->user->getState("user_host");
				$user_id	= Yii::app()->user->getState("user_id");
				try {
					if($user_host)
					{
						$client 	= Controller::userDbconnection();
						$hostdoc 	= $client->getDoc($user_id);
					}
					else
					{
						$client		= Controller::companyDbconnection();
						$hostdoc	= $client->getDoc($companyid);
					}
					
					foreach($links[$systemid][$clientid] as $key => $value)
						foreach($value as $vkey => $vval)
							$hostdoc->reports->$systemid->$clientid->$key->$vkey = $vval;
						
					$result = $client->storeDoc($hostdoc);
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