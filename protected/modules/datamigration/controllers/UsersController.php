<?php
class UsersController extends Controller
{
	
	public function actionIndex()
	{
		if(isset($_POST['company']))
		{
			$client  = Controller::userDbconnection();
			$users	 = Controller::mainuserDbconnection();
			$company = Controller::companyDbconnection();
			$user	 = $_POST['user'];
			$company = $_POST['company'];
			
			foreach($user as $key => $val)
			{
				try
				{
					$doc = $client->getDoc($val);
				}
				catch(Exception $e) 
				{
					if($e->getCode() == 404) 
					{
						$doc 	 = $users->getDoc($val);
						$compdoc = $company->getDoc($company);
						unset($doc->_rev);
						unset($doc->bi_id);
						unset($doc->bi_upload);
						unset($doc->paypal);
						$array	= json_decode(json_encode($doc), true);
						$arr	= array();
						
						foreach($array as $key1 => $val1)
							$arr[$key1] = $val1;
						$arr['company_id'] = $company;
						$arr['profile']['companyname'] = $compdoc->name;
						// $arr['change_pwd'] = false;
						if($company == 'freetrial')
							$arr['profile']['roles'] = "Admin";
						else
							$arr['profile']['roles'] = "Regular";
					
						$doc1 = new couchDocument($client);
						$doc1->set($arr);
					}
				}
			}
			$this->redirect(Yii::app()->createAbsoluteUrl("datamigration/users"));
		}
		else
			$this->render('user');
	}
}