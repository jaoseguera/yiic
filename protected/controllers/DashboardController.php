<?php
class DashboardController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public $screen;
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (Yii::app()->user->hasState("login")):
            $model = new DashboardForm;

            // collect user input data
            if (isset($_POST['DashboardForm'])) {
                
            }
            // display the login form
            $this->render('index', array('model' => $model));
        else:
            $this->redirect(array('login/'));
        endif;
    }
    
    public function actionTabsystem()
    {
        echo "~";
        $vale       = $_REQUEST['val'];
        $password   = $_REQUEST['paz'];                    
        $val_exp    = explode(',', $vale);
        $userLanguage = $_SESSION["USER_LANG"];
        if($val_exp[9] == 'Group')
        {
            $desc           = $val_exp[0];
            $messageserver  = $val_exp[2];
            $group          = $val_exp[3];
            $system_id      = $val_exp[1];
            $client_id      = $val_exp[6];
            $userid         = $val_exp[7];
            $language       = $val_exp[4];
            $extended       = $val_exp[5];
            $login = array (
                "MSHOST"=>$messageserver,     // your host address here "76.191.119.98
                "R3NAME"=>$system_id,
                "GROUP"=>$group,
                "CLIENT"=>$client_id,
                "USER"=>$userid,     // your username here
                "PASSWD"=>$password, // your logon password here
                "LANG"=>$userLanguage,
            );
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
                "LANG"=>$userLanguage,
            );
        }
        
        Yii::app()->user->setState("sap_login", $login);
        $_SESSION['userName'] = $userid;
        $_SESSION['DEC']      = $desc;
        $_SESSION['HOST']     = $host;
        $_SESSION['SYSNR']    = $system_num;
        $_SESSION['SYSID']    = $system_id;
        $_SESSION['CLIENT']   = $client_id;
        $_SESSION['extended'] = $extended;
        
        Yii::app()->user->setState("userName", $userid);
        Yii::app()->user->setState("DEC", $desc);
        Yii::app()->user->setState("HOST", $host);
        Yii::app()->user->setState("SYSNR", $system_num);
        Yii::app()->user->setState("SYSID", $system_id);
        Yii::app()->user->setState("CLIENT", $client_id);
        Yii::app()->user->setState("extended", $extended);
        
        echo $system_id.'/'.$client_id." - ".$userid."~".$userid."~";
        
        $userid     = Yii::app()->user->getState("user_id");
        $companyid  = Yii::app()->user->getState("company_id");
        $user_host  = Yii::app()->user->getState("user_host");
        
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
        $this->renderPartial('system', array('doc'=>$doc));
    }

    public function actionTabledata()
    {
        if (Yii::app()->user->hasState("login")) {
            global $rfc, $fce;
            $model = new DashboardForm;
            $screen = CommonController::setScreen();

            if (isset($_POST) && $_POST['from'] == 'submit') {
                $userid = Yii::app()->user->getState('user_id');
                $client = Controller::userDbconnection();
                $doc = $client->getDoc($userid);

                $bObj = new Bapi();
                $bObj->bapiCall($_REQUEST['bapiName']);

                $model->_actionSubmit($doc, $screen, $fce);
            }
            Yii::app()->controller->renderPartial('/bapi_tablerender/tabledata', array('model' => $model, 'screen' => $screen));
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionSavecustomize()
    {
        if (Yii::app()->user->hasState("login")):
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);
            $lables = $_REQUEST['lables'];
            $url = $_REQUEST['url'];

            $each_lable = explode(",", $lables);
            foreach ($each_lable as $keys) {
                if ($keys != NULL) {
                    $key_lable = explode("=", $keys);
                    $ids = str_replace(' ', '_', $key_lable[0]);
                    $doc->customize->$url->$ids = array('lable' => $key_lable[1], 'title' => $key_lable[0]);
                }
            }
            $client->storeDoc($doc);
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionHistory()
    {
        if (Yii::app()->user->hasState("login")):
            if($_REQUEST['fav']=='production_workbench'){
                $extended = Yii::app()->user->getState('extended');
                $bapiName=Controller::Bapinamemulity($_REQUEST['fav'],$extended);
            }else{
                $bapiName = Controller::Bapiname($_REQUEST['fav']);
            }
            $data = $_REQUEST['tit'] . "@" . $_REQUEST['fav'] . "@" . $_REQUEST['type'] . "@" . $bapiName;
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);

            if (isset($doc->customize->$_REQUEST['fav'])) {
                $sd = json_encode($doc->customize->$_REQUEST['fav']);
                $gs = json_decode($sd, true);
                if (isset($gs[$_REQUEST['fav']]['lable'])) {
                    $constVar = constant("_".strtoupper(str_replace('/','',str_replace('_','',$gs[$_REQUEST['fav']]['lable']))));
                    if($constVar != NULL && $constVar != ""){
                        echo  $constVar."@";
                    }       
                    else{
                        echo ucwords(str_replace('_',' ',$gs[$_REQUEST['fav']]['lable']))."@";
                    }             
                } else {
                    $constVar = constant("_".strtoupper(str_replace('/','',(str_replace('_', '', $_REQUEST['fav'])))));
                    if($constVar != NULL && $constVar != ""){
                        echo  $constVar."@";
                    }       
                    else{
                        echo ucwords(str_replace('_', ' ', $_REQUEST['fav']))."@";
                    }                                  
                }
            } else {      
                $constVar = constant("_".strtoupper(str_replace('/','',(str_replace('_', '', $_REQUEST['fav'])))));
                if($constVar != NULL && $constVar != ""){
                    echo  $constVar."@";
                }       
                else{
                    echo ucwords(str_replace('_', ' ', $_REQUEST['fav']))."@";
                }  
            }

            if ($_REQUEST['type'] == 'd_favt') {
                if (isset($doc->favorites)) {
                    $fs = $doc->favorites;
                    $ds = json_encode($fs);
                    $jsd = json_decode($ds, true);

                    foreach ($jsd as $jy => $nsh) {
                        $rw = explode(',', $nsh);
                        if ($rw[1] == 'forms') {
                            ?><div class="fav_hist" id='le_<?php echo $jy; ?>' title="<?php echo $rw[0]; ?>"><a href="#<?php echo $jy; ?>" class='fav_tit'><?php echo $rw[0]; ?></a>
                                </div><div class='fav_delet' onclick="fav_r('<?php echo $jy; ?>')"></div><?php
                        }
                        if ($rw[1] == 'bapi') {
                            ?><div class="fav_hist" id='le_<?php echo $jy; ?>' title="<?php echo $rw[0]; ?>"><a href="#<?php echo $jy; ?>" class='fav_tit'><?php echo $rw[0]; ?></a>
                                </div><div class='fav_delet' onclick="fav_r('<?php echo $jy; ?>')"></div><?php
                        }
                    }
                }
            } else {
                if (Yii::app()->user->hasState("hist")) {
                    $hip = Yii::app()->user->getState("hist") . "," . $data;
                    Yii::app()->user->setState("hist", $hip);
                    $su = Yii::app()->user->getState("hist");
                    $ew = explode(",", $su);
                    $hd = array_unique($ew);

                    if (Yii::app()->user->hasState("ipad")) {
                        if (count($hd) > 3) {
                            unset($hd[0]);
                            $imps = implode(",", $hd);
                            Yii::app()->user->setState("hist", $imps);
                        }
                    } else {
                        if (count($hd) > 4) {
                            unset($hd[0]);
                            $imps = implode(",", $hd);
                            Yii::app()->user->setState("hist", $imps);
                        }
                    }
                    foreach ($hd as $df => $val) {
                        $huy = explode("@", $val);
                        if ($huy[2] == 'bapi') {
                            ?><div class="fav_hist" title="<?php echo $huy[0]; ?>"><a href="#<?php echo $huy[1]; ?>"><?php echo $huy[0]; ?></a></div><?php
                        }
                        if ($huy[2] == 'forms' && $huy[1] != 'profile') {
                            ?><div class="fav_hist" title="<?php echo $huy[0]; ?>"><a href="#<?php echo $huy[1]; ?>"><?php echo $huy[0]; ?></a></div><?php
                        }
                    }
                } else {
                    Yii::app()->user->setState("hist", $data);
                }
            }
        else:
            $this->redirect(array('login/'));
        endif;
    }

    public function actionWelcomeurls()
    {
        if (Yii::app()->user->hasState("login")) {
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);
            $type = $_REQUEST['type'];

            if ($type == 'feed') {
                $urls = $_REQUEST['url'];
                $feed_url = array($urls);
                $ucont = count($feed_url) - 1;
                for ($i = 0; $i <= $ucont; $i++) {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $urls);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

                    $xmlData = curl_exec($curl);
                    curl_close($curl);

                    $xml = simplexml_load_string($xmlData);
                    $count = 5;
                    $char = 0;
                    $loop = 0;
                    foreach ($xml->channel->item as $item) {
                        $loop = 1;
                        if ($char == 0) {
                            $newstring = $item->description;
                        } else {
                            $newstring = substr($item->description, 0, $char);
                        }
                        if ($count > 0) {
                            if ($item->title != "" && ($item->guid != "" || $item->link != "" )) {
                                if ($item->guid != "") {
                                    $link = $item->guid;
                                } else {
                                    $link = $item->link;
                                }
                            }
                            echo"<li><a href='" . $link . "' target='_blank'>{$item->title}</a></li>";
                        }
                        $count--;
                    }
                }
                if ($loop > 0) {
                    $doc->welcome_urls->news_feed = $urls;
                    $client->storeDoc($doc);
                }
            }
            if ($type == 'welcome') {
                $urls = $_REQUEST['url'];
                $array = get_headers($urls);
                $string = $array[0];
            if(strpos($string,"200"))
            {
                $doc->welcome_urls->welcome_site = $urls;
                $client->storeDoc($doc);
                
            }else
            {
            echo 'E';
            exit;
            }   
            
            }
            if ($type == 'zip_code') {
                $urls = $_REQUEST['url'];
                $doc->welcome_urls->zip_code = $urls;
                $client->storeDoc($doc);
            }
            if ($type == 'tiwt') {
                $urls = $_REQUEST['url'];
                $doc->welcome_urls->tiwt = $urls;
                $client->storeDoc($doc);
            }
            if ($type == 'wegid') {
                $wegid_type = $_REQUEST['wegid_type'];
                $display = $_REQUEST['display'];
                $doc->welcome_urls->$wegid_type = $display;
                $client->storeDoc($doc);
                ?><div class='btn_<?php echo $display; ?>' onClick="we_db('<?php echo $display; ?>','<?php echo $wegid_type; ?>')"><?php echo $display; ?></div><?php
            }
        } else {
            $this->redirect(array('login/'));
        }
    }

    public function actionFavcheck()
    {
        if (Yii::app()->user->hasState("login")):
            $userid = Yii::app()->user->getState("user_id");
            $client = Controller::userDbconnection();
            $doc = $client->getDoc($userid);
            if (isset($doc->favorites->$_REQUEST['fav'])) {
                echo _DONE;
            } else {
                echo _NONE;
            }
            if (isset($_REQUEST['rem'])):
                unset($doc->favorites->$_REQUEST['rem']);
                $client->storeDoc($doc);
            endif;
        else:
            $this->redirect(array('login/'));
        endif;
    }

    /**
     * This is the action to handle external exceptions.
     * */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}