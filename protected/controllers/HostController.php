<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class HostController extends Controller
{
    /**
    * Declares class-based  actions.
    */        
    public $screen;
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
    public function actionIndex()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;
            $rfc='';
            // collect user input data
            $userid     = Yii::app()->user->getState("user_id");
            $client  = Controller::userDbconnection();
            $userdoc = $client->getDoc($userid);
            $client1    = Controller::companyDbconnection();
            $Company_ID = Yii::app()->user->getState("company_id");
            $doc        = $client1->getDoc($Company_ID);
            
                $this->render('index',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionHostcount()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;

            $companyid = Yii::app()->user->getState("company_id");
            $client = Controller::companyDbconnection();
            $doc    = $client->getDoc($companyid);
            
            $host   = json_encode($doc->host_id);
            $hosts  = json_decode($host,true);
            if(isset($doc->paypal))
            {
                return "1";
            }
            else
            {
                return "1";
            }

            // display the login form
            $this->render('index',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionHostcheck()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;

            // collect user input data
            if(isset($_POST['page']))
            {   
                ini_set( "display_errors", 0);                    
                $vale     = $_REQUEST['val'];
                $password = $_REQUEST['paz'];                    
                $val_exp = explode(',',$vale);
                $user_lang = $val_exp[11];
                
                if($val_exp[9]=='Group')
                {
                
                $desc    = $val_exp[0];
                $messageserver    = $val_exp[2];
                $group    = $val_exp[3];
                $system_id  = $val_exp[1];
                $client_id  = $val_exp[6];
                $userid     = $val_exp[7];
                $language   = $val_exp[4];
                $extended   = $val_exp[5];
                
                $login = array (
                    "MSHOST"=>$messageserver,     // your host address here "76.191.119.98
                    "R3NAME"=>$system_id,
                    "GROUP"=>$group,
                    "CLIENT"=>$client_id,
                    "USER"=>$userid,     // your username here
                    "PASSWD"=>$password, // your logon password here
                    "LANG"=>$user_lang,
                );
                //print_r($login);
                }
                else
                {
                    $desc    = $val_exp[0];
                    $host    = $val_exp[1];
                    $rout    = $val_exp[2];
                    $rout_ip = $val_exp[3];
                    if($rout != NULL)
                    {
                        $host = '/H/'.$rout.'/S/'.$rout_ip.'/H/'.$host;
                    }
                    $system_num = $val_exp[4];
                    $system_id  = $val_exp[5];
                    $client_id  = $val_exp[6];
                    $userid     = $val_exp[7];
                    $language   = $val_exp[8];
                    $extended   = $val_exp[9];
                    $login = array (
                        "ASHOST"=>$host,     // your host address here "76.191.119.98
                        "SYSNR"=>$system_num,
                        "SYSID"=>$system_id,
                        "CLIENT"=>$client_id,
                        "USER"=>$userid,     // your username here
                        "PASSWD"=>$password, // your logon password here
                        "LANG"=>$user_lang,
                    );
                }
                
                // $_SESSION['sap_login'] = $login;
                Yii::app()->user->setState("bv", $_POST['bv']);
                Yii::app()->user->setState("sap_login", $login);
                /*GEZG 06/20/2018
                Changing SAPRFC connection method*/                              
                try{
                    $rfc = new SapConnection($login);
                    $companyid = Yii::app()->user->getState("company_id");
                    $user_host = Yii::app()->user->getState("user_host");                    
                    if($user_host)
                    {
                        $user_id    = Yii::app()->user->getState("user_id");
                        $client     = Controller::userDbconnection();
                        $doc        = $client->getDoc($user_id);
                    }
                    else
                    {
                        $client = Controller::companyDbconnection();
                        $doc    = $client->getDoc($companyid);
                    }                    
                    $system_ids = $val_exp[1].'/'.$system_num.'/'.$system_id.'/';
                    $doc->host_upload->$system_ids = array('client'=>$client_id, 'user'=>$userid);                                        
                    $client->storeDoc($doc);

                    $_SESSION['userName'] = $userid;
                    $_SESSION['DEC']      = $desc;
                    $_SESSION['HOST']     = $host;
                    $_SESSION['SYSNR']    = $system_num;
                    $_SESSION['SYSID']    = $system_id;
                    $_SESSION['CLIENT']   = $client_id;
                    $_SESSION['extended'] = $extended;
                    $_SESSION["USER_LANG"] = $user_lang;
                    Yii::app()->user->setState("rfc",$rfc);
                    Yii::app()->user->setState("userName",$userid);
                    Yii::app()->user->setState("DEC",$desc);
                    Yii::app()->user->setState("HOST",$host);
                    Yii::app()->user->setState("SYSNR",$system_num);
                    Yii::app()->user->setState("SYSID",$system_id);
                    Yii::app()->user->setState("CLIENT",$client_id);
                    Yii::app()->user->setState("extended",$extended);

                    // unset($_SESSION['BI_REPORT']);
                    Yii::app()->user->setState("BI_REPORT",'');
                    $page = "dashboard";
                }catch(SapException $ex){
                    $errormsg = $ex->getMessage();
                    $msg = explode(":",$errormsg);
                    $pos = strpos($errormsg, 'Message');
                    $msg = substr($errormsg,$pos);
                    echo str_replace('Internal','',$msg);
                    exit;
                }
                echo $page;
                return;
            }
            // display the login form
            $this->render('profile',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionProfile()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;

            // collect user input data
            if(isset($_POST['HostForm']))
            {
                $companyid = Yii::app()->user->getState("company_id");
                $client = Controller::companyDbconnection();
                $doc    = $client->getDoc($companyid);
                $host   = json_encode($doc->host_id);
                $hosts  = json_decode($host,true);
                if(isset($doc->paypal))
                {
                    echo "1";
                }
                else
                {
                    echo "1";
                }
            }
            // display the login form
            if($hosts)
                $this->renderPartial('profile',array('model'=>$model));
            else
                $this->renderPartial('profile_return_portal',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionChangepassword()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;

            // collect user input data
            if(isset($_POST['page']) && $_POST['page'] == 'newpassword')
            {
                $old_pass = $_REQUEST['old_pass'];
                $new_pass = $_REQUEST['new_pass'];

                $userid = Yii::app()->user->getState("user_id");
                $client = Controller::userDbconnection();
                $doc    = $client->getDoc($userid);
                
                // if($doc->login_id->password == md5($old_pass))
                if($doc->login_id->password == $old_pass)
                {
                    // $doc->login_id->password = md5($new_pass);
                    $doc->login_id->password = $new_pass;
                    
                    if($doc->status == 'initial')
                        $doc->status = 'active';
                    
                    $client->storeDoc($doc);
                    Yii::app()->user->setState("change_pwd", false);
                    echo _DONE;
                    return;
                }
                else
                {
                    echo _INVALIDOLDPASS;
                    return;
                }
            }
            // display the login form
            $this->render('profile',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionEditprofile()
    {
        if(Yii::app()->user->getState("user_id")):
            $model = new HostForm;

            $fname   = $_REQUEST['fname'];
            $lname   = $_REQUEST['lname'];
            $phone   = $_REQUEST['phone'];
            $company = $_REQUEST['company_name'];
            $street  = $_REQUEST['street'];
            $city    = $_REQUEST['city'];
            $state   = $_REQUEST['state'];
            $country = $_REQUEST['country'];

            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc    = $client->getDoc($userid);
            $host   = $doc->profile;

            $host->fname = $fname;
            $host->lname = $lname;
            $host->phone = $phone;
            $host->companyname   = $company;
            $host->streetaddress = $street;
            $host->city    = $city;
            $host->state   = $state;
            $host->country = $country;
            $client->storeDoc($doc);

            // display the login form
            $this->render('profile',array('model'=>$model));
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionExtension()
    {
        if(Yii::app()->user->getState("user_id"))
        {
            $model = new HostForm;
            global $rfc, $fce;
            $con_type=$_REQUEST['con_type'];
            if($con_type=='grp')
            {
                $Messageserver=$_REQUEST['messageserver'];
                $Group=$_REQUEST['group'];  
                $SystemId=$_REQUEST['sys_id'];
                $ClientId=$_REQUEST['client'];
                $UserId=$_REQUEST['user_name'];
                $Password=$_REQUEST['pswd'];
                $Language=$_REQUEST['lang'];
                $exten=$_REQUEST['extension'];
                $bap=$_REQUEST['bapiversion'];
            }
            else
            {
                $Host=$_REQUEST['host'];
                $routing_string=$_REQUEST['routing_string'];
                $router_Port=$_REQUEST['router_Port'];
                $SystemId=$_REQUEST['sys_id'];
                $SystemNum=$_REQUEST['sys_num'];
                $ClientId=$_REQUEST['client'];
                $UserId=$_REQUEST['user_name'];
                $Password=$_REQUEST['pswd'];
                $Language=$_REQUEST['lang'];
                $exten=$_REQUEST['extension'];
                $bap=$_REQUEST['bapiversion'];
                if($routing_string!=NULL)
                {
                    $Host='/H/'.$routing_string.'/S/'.$router_Port.'/H/'.$Host;
                }
            }
            
            if($con_type=='grp')
            {
                $login = array (
                    "MSHOST"=>$Messageserver,     // your host address here "76.191.119.98
                    "R3NAME"=>$SystemId,
                    "GROUP"=>$Group,
                    "CLIENT"=>$ClientId,
                    "USER"=>$UserId,     // your username here
                    "PASSWD"=>$Password, // your logon password here
                    "LANG"=>$Language,
                );
            }
            else
            {
                $login = array (
                    "ASHOST"=>$Host, // your host address here "76.191.119.98
                    "SYSNR"=>$SystemNum,
                    "SYSID"=>$SystemId,
                    "CLIENT"=>$ClientId,
                    "USER"=>$UserId, // your username here
                    "PASSWD"=>$Password, // your logon password here
                    "LANG"=>$Language,
                );
            }
            /*GEZG 06/20/2018
                Changing SAPRFC connection method*/
            //$rfc = saprfc_open($login);
            try{
                $rfc = new SapConnection($login);
                echo "done@";
            }catch(SapException $ex){
                $errormsg=$ex->getMessage();
                $msg=explode(":",$errormsg);
                $pos = strpos($errormsg, 'Message');
                $msg= substr($errormsg,$pos);
                echo str_replace('Internal','',$msg);
            }
            if($exten=='on')
            {
                //$bapiName="/EMG/ZBAPI_SAPIN_EXT_VER_CHECK";
                $bapiName="ZBAPI_SAPIN_EXTENDED_VER_CHECK";
                /*GEZG - 06/20/2018
                Chaning BAPI call method*/
                $fce = $rfc->getFunction($bapiName);
                if (! $fce )
                {
                    //echo "Discovering interface of function module failed"; 
                    exit;
                }
                try{
                    $rfc_rc = $fce->invoke();
                }catch(SapException $ex){
                    echo "Exception raised:".$ex->getMessage();
                    exit();
                }              
                //GEZG - Exporting BAPI response                
                //echo $rowsag = saprfc_export($fce,"E_MESSAGES");
                echo $rowsag =  $rfc_rc["E_MESSAGES"];
            }
        }
        else
            $this->redirect(array('login/'));
    }
    
    public function actionEccsystem()
    {
        if(Yii::app()->user->getState("user_id")):
            $userid     = Yii::app()->user->getState("user_id"); 
            $companyid  = Yii::app()->user->getState("company_id");                
            $con_type   = $_REQUEST['con_type'];
            if($con_type == 'cust')
            {
                $hst['Description']    = $_REQUEST['description'];
                $hst['Host']           = $_REQUEST['host'];
                $hst['routing_string'] = $_REQUEST['routing_string'];
                $hst['router_port']    = $_REQUEST['router_Port'];
                $hst['System_num']     = $_REQUEST['sys_num'];
                $hst['System_id']      = $_REQUEST['sys_id'];
                $hst['Lang']           = $_REQUEST['lang'];
                $hst['Extension']      = $_REQUEST['extension'];
                $hst['Bapiversion']    = $_REQUEST['bapiversion'];
            }
            else
            {
                $hst['Description']    = $_REQUEST['description'];
                $hst['Messageserver']  = $_REQUEST['messageserver'];
                $hst['Group']          = $_REQUEST['group'];
                $hst['System_id']      = $_REQUEST['sys_id'];
                $hst['Lang']           = $_REQUEST['lang'];
                $hst['Extension']      = $_REQUEST['extension'];
                $hst['Bapiversion']    = $_REQUEST['bapiversion'];
            }
            
            $user_host = Yii::app()->user->getState("user_host");
            if($user_host)
            {
                $client  = Controller::userDbconnection();
                $doc     = $client->getDoc($userid);
            }
            else
            {
                $client = Controller::companyDbconnection();
                $doc    = $client->getDoc($companyid);
            }
            $host   = json_encode($doc->host_id);
            $hosts  = json_decode($host,true);

            if(isset($doc->paypal))
                $host_count = 1;
            else
                $host_count = 1;
            
            if($host_count > 6)
            {
                echo 'paypal';
                exit;
            }
            else
            {
                $ho    = $doc->host_id;                    
                $host  = json_encode($doc->host_id);
                $hosts = json_decode($host,true);
                // print_r($hosts); return;
                foreach($hosts as $sd => $hd)
                {
                    if($sd != 'none')
                    {
                        if(strtoupper($hd['Description']) == strtoupper($hst['Description']))
                        {
                            echo _NOSYSTEM;
                            exit;
                        }
                        ///$sy = explode("_", $sd);
                    }
                }

                /*if(isset($sy[1]))
                {
                    $ty = $sy[1];
                    $cd = $ty+1;
                }
                else
                    $cd = 1;
                */
                $cd=uniqid();
                $num = $cd;
                $cd  = 'host_'.$cd;
                echo $dis = $cd."@";
                if($con_type == 'cust')
                {
                    $doc->host_id->$cd  = array(
                        'Description'       => $hst['Description'],
                        'Host'              => $hst['Host'],
                        'Router_String'     => $hst['routing_string'],
                        'Router_Port'       => $hst['router_port'],
                        'System_Number'     => $hst['System_num'],
                        'System_ID'         => $hst['System_id'],
                        'Language'          => $hst['Lang'],
                        'Extension'         => $_REQUEST['extension'],
                        'Bapiversion'       => $_REQUEST['bapiversion'],
                        'System_type'       => 'ECC',
                        'Connection_type'   => 'Single'
                    );
                }
                else
                {
                    $doc->host_id->$cd  = array(
                        'Description'       => $hst['Description'],
                        'System_ID'         => $hst['System_id'],
                        'Messageserver'     => $hst['Messageserver'],
                        'Group'             => $hst['Group'],
                        'Language'          => $hst['Lang'],
                        'Extension'         => $_REQUEST['extension'],
                        'Bapiversion'       => $_REQUEST['bapiversion'],
                        'System_type'       => 'ECC',
                        'Connection_type'   => 'Group'
                    );
                }
                if(isset($doc->host_position))
                    $doc->host_position->$num = $cd;
                
                $client->storeDoc($doc);
                
                if($user_host)
                    $hostdoc     = $client->getDoc($userid);
                else
                    $hostdoc    = $client->getDoc($companyid);
                
                if(isset($hostdoc->host_position))
                {
                    $center_position    = json_encode($hostdoc->host_position);
                    $center_positions   = json_decode($center_position, true);
                }
                else
                {
                    $host   = json_encode($hostdoc->host_id);
                    $hosts  = json_decode($host, true);
                    $bi_rep='';
                    foreach($hosts as $keys => $values)
                        $center_positions[] = $keys;
                    /*
                    $bi_resop   = explode("_", $bi_rep);
                    $cd         = $bi_resop[1];
                    
                    for($i = 1; $i <= $cd; $i++)
                        $center_positions[] = 'host_' . $i; */
                }
                
                $host   = json_encode($hostdoc->host_id);
                $hosts  = json_decode($host, true);
                $count  = count($hosts);
                
                $this->renderPartial('avilablesystems', array('doc'=>$hostdoc, 'companyid'=>$companyid, 'center_positions'=>$center_positions, 'hosts'=>$hosts, 'count'=>$count));
                echo "@";
                $this->renderPartial('editsystems', array('hosts'=>$hosts, 'count'=>$count));
            }
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionEdit()
    {
        if(Yii::app()->user->getState("user_id")):

            $companyid = Yii::app()->user->getState("company_id");
            $user_host = Yii::app()->user->getState("user_host");
            
            if($user_host)
            {
                $user_id = Yii::app()->user->getState("user_id");
                $client  = Controller::userDbconnection();
                $doc     = $client->getDoc($user_id);
            }
            else
            {
                $client = Controller::companyDbconnection();
                $doc    = $client->getDoc($companyid);
            }

            if(isset($_REQUEST['bi_rep']))
            {
                $ids       = $_REQUEST['bi_rep'];
                $idr       = $_REQUEST['id'];
                $dec       = $_REQUEST['description'];
                $sys_url   = $_REQUEST['system_url'];
                $cms_name  = $_REQUEST['cms_name'];
                $cms_port  = $_REQUEST['cms_port'];
                $auth_type = $_REQUEST['auth_type'];
                $ext_type  = $_REQUEST['bobj_extension'];
                $version=$_REQUEST['bapiversion'];

                if($cms_name==NULL&&$cms_port==NULL&&$auth_type==NULL)
                {
                    $cms_name  = 'NON';
                    $cms_port  = 'NON';
                    $auth_type = 'NON';
                }
                if ($this->is_valid_url($sys_url.'/BOBJSessionEMG/BOBJSessionWS?wsdl'))
                {
                    $doc->host_id->$ids->Description = $dec;
                    $doc->host_id->$ids->System_URL  = $sys_url;
                    $doc->host_id->$ids->CMS_Name    = $cms_name;
                    $doc->host_id->$ids->CMS_Port    = $cms_port;
                    $doc->host_id->$ids->Auth_Type   = $auth_type;
                    $doc->host_id->$ids->Extension   = $ext_type;
                    $doc->host_id->$ids->Bapiversion=$version;
                    $client->storeDoc($doc);

                    $df = $dec.','.$sys_url.','.$cms_name.','.$cms_port.','.$auth_type.',BOBJ,'.$ext_type;
                    ?><a class="close ip_cls" onClick="delt('<?php echo $ids;?>','<?php echo $idr;?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/trash_can.png" alt="Delete"></a>&nbsp;
                    <a class="close ip_cls" onClick="edit('<?php echo $ids;?>','<?php echo $idr;?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/pencil.png" alt="Edit"></a>
                    <strong onClick="systems_bi('<?php echo $ids;?>','<?php echo $df;?>','no_data')"><a href="#" >
                    <?php echo $dec;?>&nbsp;&nbsp;&nbsp;<span class='Sys_typ'>BOBJ</span><span id='<?php echo $ids;?>_inv'></span>
                    </a></strong><?php
                }
                else
                {
                    echo _URLNOTWORKING;
                    exit;
                }
            }
            else
            {
                $hst['Connection_type']= $_REQUEST['con_type'];
                
                if($hst['Connection_type']=='Single')
                {
                    $hst['Description']    = $_REQUEST['description'];
                    $hst['Host']           = $_REQUEST['host'];
                    $hst['routing_string'] = $_REQUEST['routing_string'];
                    $hst['router_Port']    = $_REQUEST['router_Port'];
                    $hst['System_num']     = $_REQUEST['sys_num'];
                    $hst['System_id']      = $_REQUEST['sys_id'];
                    $hst['Lang']           = $_REQUEST['lang'];
                    $hst['Extension']      = $_REQUEST['extension'];
                    $hst['Bapiversion']    = $_REQUEST['bapiversion'];
                }
                if($hst['Connection_type']=='undefined')
                {
                    $hst['Description']    = $_REQUEST['description'];
                    $hst['Host']           = $_REQUEST['host'];
                    $hst['routing_string'] = $_REQUEST['routing_string'];
                    $hst['router_Port']    = $_REQUEST['router_Port'];
                    $hst['System_num']     = $_REQUEST['sys_num'];
                    $hst['System_id']      = $_REQUEST['sys_id'];
                    $hst['Lang']           = $_REQUEST['lang'];
                    $hst['Extension']      = $_REQUEST['extension'];
                    $hst['Bapiversion']    = $_REQUEST['bapiversion'];
                }
                if($hst['Connection_type']=='Group')
                {
                    $hst['Description']    = $_REQUEST['description'];
                    $hst['Messageserver']  = $_REQUEST['messageserver'];
                    $hst['Group']          = $_REQUEST['group'];
                    $hst['System_id']      = $_REQUEST['sys_id'];
                    $hst['Lang']           = $_REQUEST['lang'];
                    $hst['Extension']      = $_REQUEST['extension'];
                    $hst['Bapiversion']    = $_REQUEST['bapiversion'];
                }

                $r     = $_REQUEST['id'];
                $rs    = $_REQUEST['ids'];
                $host  = $doc->host_id;
                $field = $host->$r;
                if($hst['Connection_type']=='Single')
                {
                    $field->Description   = $hst['Description'];
                    $field->Host          = $hst['Host'];
                    $field->Router_String = $hst['routing_string'];
                    $field->Router_Port   = $hst['router_Port'];
                    $field->System_Number = $hst['System_num'];
                    $field->System_ID     = $hst['System_id'];
                    $field->Language      = $hst['Lang'];
                    $field->Extension     = $hst['Extension'];
                    $field->Bapiversion   =$hst['Bapiversion'];
                }
                if($hst['Connection_type']=='Group')
                {
                    $field->Description   = $hst['Description'];
                    $field->Messageserver = $hst['Messageserver'];
                    $field->Group         = $hst['Group'];
                    $field->System_ID     = $hst['System_id'];
                    $field->Language      = $hst['Lang'];
                    $field->Extension     = $hst['Extension'];
                    $field->Bapiversion   =$hst['Bapiversion'];
                }
                if(trim($hst['Connection_type'])=='undefined')
                {
                    $field->Description   = $hst['Description'];
                    $field->Host          = $hst['Host'];
                    $field->Router_String = $hst['routing_string'];
                    $field->Router_Port   = $hst['router_Port'];
                    $field->System_Number = $hst['System_num'];
                    $field->System_ID     = $hst['System_id'];
                    $field->Language      = $hst['Lang'];
                    $field->Extension     = $hst['Extension'];
                    $field->Bapiversion   =$hst['Bapiversion'];
                }
                $client->storeDoc($doc);

                $host1  = $doc->host_id;
                $edit   = $host1->$r;
                $sg     = json_encode($edit);
                $jw     = json_decode($sg, true);
                $value  = "";

                foreach($jw as $hs=>$he)
                {
                    if($hs!='Password')
                    {
                        $value.=$he.",";
                    }
                }
                ?>
                <a class="close ip_cls" onClick="delt('<?php echo $r;?>','<?php echo $rs;?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/trash_can.png" alt="Delete"></a>&nbsp;
                <a class="close ip_cls" onClick="edit('<?php echo $r;?>','<?php echo $rs;?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/pencil.png" alt="Edit"></a> 
                <strong onClick="systems('page=host&val=<?php echo $value;?>','<?php echo $rs;?>','no_data')"><a href="#"  >
                <?php echo $jw['Description'];?>&nbsp;&nbsp;&nbsp;<span class='Sys_typ'>ECC</span><span id='<?php echo $rs;?>_inv'></span>
                </a></strong><?php
            }
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function is_valid_url($url)
    {
        if (!($url = @parse_url($url)))
        {
            return false;
        }
        $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
        $url['path'] = (!empty($url['path'])) ? $url['path'] : '/';
        $url['path'] .= (isset($url['query'])) ? "?$url[query]" : '';

        if (isset($url['host']) AND $url['host'] != @gethostbyname($url['host']))
        {
            if (PHP_VERSION >= 5)
            {
                $headers = @implode('', @get_headers("$url[scheme]://$url[host]:$url[port]$url[path]"));
            }
            else
            {
                if (!($fp = @fsockopen($url['host'], $url['port'], $errno, $errstr, 10)))
                {
                    return false;
                }
                fputs($fp, "HEAD $url[path] HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
                $headers = fread($fp, 4096);
                fclose($fp);
            }
            return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
        }
        return false;
    }

    public function actionUpdatepanel()
    {
        if(Yii::app()->user->getState("user_id"))
        {
            $user_host  = Yii::app()->user->getState("user_host");
            if($user_host)
            {
                $user_id = Yii::app()->user->getState("user_id");
                $client  = Controller::userDbconnection();
                $doc     = $client->getDoc($user_id);
            }
            else
            {
                $companyid  = Yii::app()->user->getState("company_id");
                $client     = Controller::companyDbconnection();
                $doc        = $client->getDoc($companyid);
            }
            
            $action = $_POST['action'];
            if(isset($_POST['host']))
            {
                $updateRecordsArray = $_POST['host'];
            }
            if(isset($_POST['position']))
            {
                $updateRecordsArray = $_POST['position'];
            }
            
            if ($action == "updateHostListings")
            {
                $host  = json_encode($doc->host_id);
                $hosts = json_decode($host,true);
                
                foreach($updateRecordsArray as $key => $value)
                    unset($doc->host_position->$value);
                
                foreach($updateRecordsArray as $key => $value)
                    $doc->host_position->$value = 'host_'.$value;
                
                $client->storeDoc($doc);                    
            }
            
            if ($action == "updateRecordsListings")
            {
                $doc->center_position->position_one="position_".$updateRecordsArray[0];
                $doc->center_position->position_two="position_".$updateRecordsArray[1];
                $doc->center_position->position_three="position_".$updateRecordsArray[2];        
                $client->storeDoc($doc);
                echo _REFRESHPAGE;
            }
            else if($action == "update_right_RecordsListings")
            {
                $doc->right_position->position_one="position_".$updateRecordsArray[0];
                $doc->right_position->position_two="position_".$updateRecordsArray[1];
                $doc->right_position->position_three="position_".$updateRecordsArray[2];        
                $client->storeDoc($doc);
                echo _REFRESHPAGE;
            }
        }
        else
        {
            $this->redirect(array('login/'));
        }
    }

    public function actionImporthost()
    {
        if(Yii::app()->user->getState("user_id"))
        {
            $companyid = Yii::app()->user->getState("company_id");
            $user_id = Yii::app()->user->getState("user_id");
            $user_host  = Yii::app()->user->getState("user_host");
            
            Yii::app()->user->setState('success',"404");
            Yii::app()->user->setState('all',"0");                
            $all='';


            if(isset($_FILES['file']))
            {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "Error: " . $_FILES["file"]["error"] . "<br>";
                    Yii::app()->user->setState('success',"0");
                    $this->redirect(array('host/'));
                    exit;
                }
                else
                {
                    define('BIRD', 'Dodo bird');
                    $filename = explode('.',$_FILES["file"]["name"]);
                    if($filename[1]!='ini')
                    {
                        Yii::app()->user->setState('success',"2");
                        $this->redirect(array('host/'));
                        exit;
                    }
                    $ini_array = parse_ini_file($_FILES["file"]["tmp_name"], true);
                    $description=$ini_array['Description'];

                    foreach($ini_array['Description'] as $keys=>$values)
                    {
                        if($user_host)
                        {
                            $client  = Controller::userDbconnection();
                            $doc     = $client->getDoc($user_id);
                        }
                        else
                        {
                            $client     = Controller::companyDbconnection();
                            $doc        = $client->getDoc($companyid);
                        }
                        $host   = json_encode($doc->host_id);

                        $hosts=json_decode($host,true);
                        if(isset($doc->paypal))
                        {
                            $host_count=1;
                        }
                        else
                        {
                            $host_count=count($hosts);
                        }
                        if(count($host_count)>6)
                        {
                            Yii::app()->user->setState('success',"9");
                            $this->redirect(array('host/'));
                        }
                        echo $host_details[]=$values.",".$ini_array['Server'][$keys].",".$ini_array['Database'][$keys].",".$ini_array['MSSysName'][$keys]."<br>";
                        $ho=$doc->host_id;
                        $host=json_encode($doc->host_id);

                        $hosts=json_decode($host,true);
                        $rols=$ini_array['Server'][$keys].",".$ini_array['Database'][$keys].",".$ini_array['MSSysName'][$keys];
                        $dub=0;

                        foreach($hosts as $sd => $hd)
                        {
                            if($hd !='none')
                            {
                                $sy = explode("_",$sd);

                                $comp = $hd['Host'].",".$hd['System_Number'].",".$hd['System_ID'];
                                if($rols==$comp)
                                {
                                    $dub=1;
                                    $all.= _SYSTEMWITH." ".$hd['Host']." and ".$hd['System_ID']." "._ALREADYEXIST."<br>";
                                    Yii::app()->user->setState('all',"5");
                                }
                            }
                        }
                        if($dub!=1)
                        {
                            if(isset($sy[1]))
                            {
                                $ty = $sy[1];
                                $cd = $ty+1;
                            }
                            else
                            {
                                $cd = 1;
                            }
                            $num = $cd;
                            $cd  = 'host_'.$cd;
                            $router_st='';
                            $router_port='';
                            if($ini_array['Router'][$keys]!=NULL)
                            {
                                $exp=explode('/S/',$ini_array['Router'][$keys]);
                                $exp_router=explode('/H/',$exp[0]);
                                $exp_port=explode('/H/',$exp[1]);
                                $router_st=$exp_router[1];
                                $router_port=$exp_port[0];
                            }
                            $doc->host_id->$cd = array('Description'=>$values,'Host'=>$ini_array['Server'][$keys],'Router_String'=>$router_st,'Router_Port'=>$router_port,'System_Number'=>$ini_array['Database'][$keys],'System_ID'=>$ini_array['MSSysName'][$keys],'Language'=>'EN','Extension'=>'off','System_type'=>'ECC');
                            if(isset($doc->host_position))
                            {
                                $doc->host_position->$num = $cd;
                            }
                            $client->storeDoc($doc);
                            Yii::app()->user->setState('success',"1");
                        }
                    }
                }
            }
            Yii::app()->user->setState('allre',$all);
            $this->redirect(array('host/'));
        }
        else
        {
            $this->redirect(array('login/'));
        }
    }

    public function actionRemove()
    {
        if(Yii::app()->user->getState("user_id"))
        {
            $r = $_REQUEST['id'];
            $companyid = Yii::app()->user->getState("company_id");
            $user_host = Yii::app()->user->getState("user_host");
            
            //GEZG 07/26/2018
            //Adding try/catch. If something goes wrong while deleting SAP system then send the error message
            try{
                if($user_host)
                {
                    $user_id = Yii::app()->user->getState("user_id");
                    $client  = Controller::userDbconnection();
                    $doc     = $client->getDoc($user_id);
                }
                else
                {
                    $client = Controller::companyDbconnection();
                    $doc    = $client->getDoc($companyid);
                }

                if(isset($_REQUEST['type']))
                {
                    $values = $doc->bi_id;
                    unset($values->$r);
                }
                else
                {
                    $values = $doc->host_id;
                    unset($values->$r);
                    $host   = json_encode($doc->host_position);
                    $hosts  = json_decode($host,true);
                    foreach($hosts as $key =>$gsd)
                    {
                        if($gsd==$r) { unset($doc->host_position->$key); }
                    }
                }
                $client->storeDoc($doc);                
            }catch(Exception $ex){
                echo $ex->getMessage();
            }
        }
        else
        {
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