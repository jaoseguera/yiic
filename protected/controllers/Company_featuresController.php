<?php
class Company_featuresController extends Controller
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
	public function actionCompany_features()
	{
		if(Yii::app()->user->hasState("login"))
        {
            $model = new Company_featuresForm;
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
			$model = new Company_featuresForm;
			if(isset($_POST))
			{
				Yii::app()->controller->renderPartial('roles', array('model'=>$model));
			}
        }
	}
	
    public function actionCreateroles()
    {
        if(Yii::app()->user->hasState("login"))
        {
			$model = new Company_featuresForm;
			if(isset($_POST))
			{
				$level0		= isset($_POST['level0']) ? $_POST['level0'] : "";
				$level1		= isset($_POST['level1']) ? $_POST['level1'] : "";
				$level2 	= isset($_POST['level2']) ? $_POST['level2'] : "";
				$Company_ID	= Yii::app()->user->getState("company_id");
				
				try {
					$client = Controller::companyDbconnection();
					if($Company_ID == "emgadmin")
						$docs	= $client->getDoc($_REQUEST['Company']);
					else
						$docs	= $client->getDoc($Company_ID);
					
					$x = array();
					foreach($level0 as $key => $val)
					{
						//GEZG 07/26/2018
						//Changing split to explode due that split function is deprecated in PHP7
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
					
					if($Company_ID == "emgadmin")
						$docs->default_functions = $x;
					else
					{
						$docs->selected_functions = $x;
						$docs->roles->Regular = $x;
					}
					$result = $client->storeDoc($docs);
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