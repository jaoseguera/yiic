<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
    * Authenticates a user.
    * The example implementation makes sure if the username and password
    * are both 'demo'.
    * In practical applications, this should be changed to authenticate
    * against some persistent user identity storage (e.g. database).
    * @return boolean whether authentication succeeds.
    **/
    
    public function authenticate()
    {
        $email 		= $_POST['IndexForm']['username']; 
        $pswd  		= $_POST['IndexForm']['password'];
        $date_time 	= $_POST['IndexForm']['datetime'];
        
		$company = Controller::companyDbconnection();
        $client = Controller::userDbconnection();
        try{
            $doc = $client->getDoc($email);            
            if($doc)
            {
                $login 		= $doc->login_id;
                $status 	= $doc->status;
                $company_id = $doc->company_id;
                $role 		= $doc->profile->roles;
				$user_host	= isset($doc->host_id);
				$companydoc = $company->getDoc($company_id);
				// echo $companydoc->status."<br />";
				
				Yii::app()->user->setState("user_host", $user_host);
				
                if($login->password == md5($pswd) && ($status == 'active' || $status == 'initial') && $companydoc->status != 'inactive')
                {
				/*             
                    if(isset($doc->host_id))
                    {
                       
                        $host  = json_encode($doc->host_id);
                        $hosts = json_decode($host,true);
                        $host  = json_encode($doc->host_id);
                        $hosts = json_decode($host,true);
                        $demo  = 0;
                        foreach($hosts as $vau=>$jw)
                        {
                            $sy = explode("_",$vau);
                            $client_user=NULL;
                            if($vau!='none')
                            {
                                foreach($jw as $hs=>$he)
                                {
                                    if($hs=='Host'||$hs=='System_Number'||$hs=='System_ID')
                                    {
                                        $client_user.=$he.'/';
                                    }
                                }
                                if($client_user=='76.191.119.98/10/EC4/')
                                {
                                    $demo=1;
                                }
                            }
                        }
                        if($demo==0)
                        {
                            if(isset($sy[1]))
                            {
                                $ty=$sy[1];
                                $cd=$ty+1;
                            }
                            else
                            {
                                $cd=1;
                            }
                            $cd='host_'.$cd;
                            $doc->host_id->$cd=array('Description'=>'EC4','Host'=>'76.191.119.98','Router_String'=>'','Router_Port'=>'','System_Number'=>'10','System_ID'=>'EC4','Language'=>'EN','Extension'=>'on');
                            $doc->host_upload=array('76.191.119.98/10/EC4/'=>array('client'=>'210','user'=>'msreekanth'));
                        }
                    }
                    else
                    {
                        $doc->host_id=array('none'=>'none','host_1'=>array('Description'=>'EC4','Host'=>'76.191.119.98','Router_String'=>'','Router_Port'=>'','System_Number'=>'10','System_ID'=>'EC4','Language'=>'EN','Extension'=>'on'));
                        $doc->host_upload=array('76.191.119.98/10/EC4/'=>array('client'=>'210','user'=>'msreekanth'));
                    } 
                    /*---------------------------------------------------------*/
                    //$_SESSION['login']      = $email;
                    //$_SESSION['admin_user'] = $doc->profile->fname;
                    //$_SESSION['user_id']    = $email;
                    
                    /*---------------------------------------------------------*/
                    Yii::app()->user->setState("role", $role);
                    Yii::app()->user->setState("company_id", $company_id);
                    Yii::app()->user->setState("login", $email);
                    Yii::app()->user->setState("admin_user", $doc->profile->fname);
                    Yii::app()->user->setState("user_id", $email);
					Yii::app()->user->setState("company_id", $doc->company_id);
					
					if($status == 'initial')
						Yii::app()->user->setState("change_pwd", true);
					else
						Yii::app()->user->setState("change_pwd", false);
						
                    /*---------------------------------------------------------*/
                    $dates = explode("@",$date_time);
                    $times = explode(":",$dates[1]);

                    $hh=$times[0];
                    $mm=$times[1];
                    $ss=$times[2];

                    if(strlen(trim($times[0]))<2)
                    {
                        $hh="0".trim($times[0]);
                    }
                    if(strlen(trim($times[1]))<2)
                    {
                        $mm="0".trim($times[1]);
                    }
                    if(strlen(trim($times[2]))<2)
                    {
                        $ss="0".trim($times[2]);
                    }
                    $day=explode("/",$dates[0]);
                    $month=$day[0];
                    $date=$day[1];
                    if(strlen($day[0])<2)
                    {
                        $month="0".$day[0];
                    }
                    if(strlen($day[1])<2)
                    {
                        $date="0".$day[1];
                    }
                    $datest=$month."/".$date."/".$day[2];
                    $time_format=$hh.":".$mm.":".$ss;

                    if(!isset($doc->present_time))
                    {
                        $today=$time_format." on ".$datest;
                    }
                    else
                    {
                        $today=$doc->present_time;
                    }
                    if(isset($doc->profile->help_en))
                    {
                        $_SESSION['help_en']=$doc->profile->help_en;
                    }
                    else
                    {
                        $doc->profile->help_en="1";
                        $_SESSION['help_en']='1';
                    }
                    $_SESSION['t_date']=$datest;
                    $doc->past_time = $today;
                    $doc->present_time = $time_format." on ".$datest;
                    $client->storeDoc($doc);
                    /*---------------------------------------------------------*/
                    $users = array( $email=>$login->password );                   
                    if(!isset($users[$this->username]))
						$this->errorCode=self::ERROR_USERNAME_INVALID;
                    elseif($users[$this->username]!==$login->password)
						$this->errorCode=self::ERROR_PASSWORD_INVALID;
                    else
						$this->errorCode=self::ERROR_NONE;
                    return !$this->errorCode;
                    /*---------------------------------------------------------*/
                }
            }
        }
        catch (Exception $e) {
            return $this->errorCode;
        }
    }
}