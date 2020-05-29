<style>
@media all and (max-width:750px)
{
.sapin-logo img{
width:100px;
height:35px;
}
}
</style>
<?php
/* @var $this DashBoardController */
/* @var $model DashBoardForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Dashboard';
if(Yii::app()->user->hasState("extended"))
{
    $extended = Yii::app()->user->getState('extended');
    // $rfc = Yii::app()->user->setState('rfc');
}
else { $extended = ""; }

$value  = "";

$userid     = Yii::app()->user->getState("user_id");
$companyid  = Yii::app()->user->getState("company_id");
//$user_host    = Yii::app()->user->getState("user_host");

$client  = Controller::userDbconnection();
$userdoc = $client->getDoc($userid);

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

// Include Jquery for this page
$cs = Yii::app()->clientScript;

$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page
?>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/colortip-1.0-jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.contextmenu.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/dashboard.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/FixedHeader.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.feedBackBox.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/table.dragtable.js"></script>


<div id="feedback"></div>
<input type="hidden" name="BaseURL" id="BaseURL" value="<?php echo Yii::app()->request->baseUrl; ?>" />
<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/close-help.png" class="help_close">
<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/help_thinui.png" class="help_thin">
<?php
if($extended!='on')
{
    ?>
    <script>
        $(document).ready(function () {
            $('.lite').hide();
            $('.lite_sales').attr("onclick","sap_form('coming_soon')");
        });
    </script>
<?php
}

$this->renderPartial('lookup');
?>
<div id="backgroundPopup"></div>

<div class="container-fluid">
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<div id='block-ui'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/block-ui.gif"></div>


<div class="row-fluid">
    <div class="span12" id='heder_position' >
        <div class="header-top">
            <div class="header-wrapper">
                <a href="dashboard" class="sapin-logo" align="center">
                <?php 
                $company=Controller::companyDbconnection();
                $compdetail=$company->getDoc($companyid); 
                $admincomp=$company->getDoc('emgadmin');
                $logo='';
                if(isset($compdetail->logo) && file_exists($compdetail->logo))
                {       
                    $logo=$compdetail->logo;
                    echo '<img src="'.Yii::app()->request->baseUrl."/upload/".basename($logo).'"/>';
                    echo '<h5 style="color:#fff;" align="center">Powered by Emergys thinui</h5>';
                }elseif($admincomp->logo && file_exists($admincomp->logo))
                {
                    $logo=$admincomp->logo;
                    echo '<img src="'.Yii::app()->request->baseUrl."/upload/".basename($logo).'"/>';
                    echo '<h5 style="color:#fff;" align="center">Powered by Emergys thinui</h5>';
                } else
                        echo '<img src="'.Yii::app()->request->baseUrl.'/images/thinui-logo-125x50.png"/>';
                                
                echo '</a>';
                ?>
                <!--<div class="user-panel header-divider body_con" style="border:none;width:59%"></div>-->
                <div class="header-right">
                    <div class="header-divider">
                        <div class="navbar sidebar-toggle">
                            <div class="container" style="margin-top:-10px;">
                                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="search-panel header-divider">
                        <div class="search-box">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/zoom.png" alt="Search">
                            <form action="" method="post">
                                <input type="text" name="search" placeholder="search"/>
                            </form>
                        </div>
                    </div>

                    <div class="header-divider mobile_lite hd" >
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/save-icone.png" onclick="save_customize()" class="save_customize body_con b_odd" title='<?=Controller::customize_label(_SAVECUSTOMIZE);?>' style="margin-left:5px;">
                        <div class="user_list" >
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/edit-icon.png" onclick="customize()" class="edit_customize  b_odd" title='<?=Controller::customize_label(_CUSTOMIZE);?>'>
                        </div>
                    </div>
                    <!-- hist---->
                    <div class="header-divider mobile_lite mobile_hid" >
                        <div class="user_list" id='his_u'>
                            <a href="#" tip='<?=Controller::customize_label(_HISTORY);?>' class='red b_od'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/history.png" alt=""></a>
                        </div>

                        <div class="user-dropbox body_con" id='d_his_u'>
                            <ul id="hist" style="margin:0px;"></ul>
                        </div>
                    </div>
                    <!---- fav
                    <div class="header-divider" id='header-divider'>---->
                    <div class="header-divider mobile_hid">
                        <div class="user_list" id='favt'>
                            <a href="#" tip='<?=Controller::customize_label(_FAVORITE);?>' class='red b_od'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/favt.png" alt=""></a>
                        </div>
                        <div class="user-dropbox body_con" id='d_favt'></div>
                    </div>
                    <!------------------host------------------------->
                    <div class="header-divider mobile_lite">
                        <div class="host_list" id='host_list'>
                            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/system.png" alt="" class='sys_ic'><div class="sys_len"><?php echo Yii::app()->user->getState("SYSID").'/'.Yii::app()->user->getState("CLIENT").' - '.Yii::app()->user->getState("userName"); ?></div></a>
                        </div>
                        <div class="d_host_list" id='d_host_list'>
                            <?php $this->renderPartial('system', array('doc'=>$doc)); ?>
                        </div>
                    </div>
                    <!------------------------------------------->
                    <div class="user-panel header-divider">
                        <div class="user-info" id='admin_u'>
                            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="" class='usr_ic'><div title="<?php echo Yii::app()->user->getState("admin_user"); ?>"><?php echo Yii::app()->user->getState("admin_user"); ?></div></a>
                        </div>

                        <div class="user-dropbox" id='d_admin_u'>
                            <ul>
                                <li class="mob_user_det body_con"><strong><a href="#" onclick="return false;" style="color: #025985;margin-left: 0px"><?php echo Yii::app()->user->getState("admin_user"); ?></a></strong></li>
                                <li class="theme-changer white-theme body_con"><a href="#" onClick='help_t()'><?=Controller::customize_label(_HELP);?></a></li>
                                <li class="user body_con" ><a href="#" id='profile' onClick="sap_form('profile')"><?=Controller::customize_label(_PROFILE);?></a></li>
                                <li class="license body_con"><a target="_blank" href="http://www.emergys.com/solutions/experience/thinui/ancillarysoftware-service/" ><?=Controller::customize_label(_LICENSEINFO);?></a></li>
                                <li class="settings body_con"><a href="host" onclick="call_systems()"><?=Controller::customize_label(_SYSTEMS);?></a></li>
                                <li class="logout"><a href="#" onClick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl("login/logout"); ?>'"><?=Controller::customize_label(_LOGOUT);?></a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- End header right -->
            </div><!-- End header wrapper -->
        </div><!-- End header -->
    </div>
</div>
<!-- Header ends -->
<div class="row-fluid">
    <!-- Sidebar start -->
    <div class="span2 sidebar-container fixed" id='nav_tab'>
        <?php $this->renderPartial('menu', array('extended'=>$extended)); ?>
    </div>
    <!-- Side Bar End -->

    <!-- Body Start -->
    <?php
    if(isset($doc->center_position))
    {
        $center_position=json_encode($doc->center_position);
        $center_positions=json_decode($center_position,true);
    }
    else
    {
        $center_positions=array('position_one'=>'position_1','position_two'=>'position_2','position_three'=>'position_3');
    }
    if(isset($doc->right_position))
    {
        $right_position=json_encode($doc->right_position);
        $right_positions=json_decode($right_position,true);
    }
    else
    {
        $right_positions=array('position_one'=>'position_1','position_two'=>'position_2','position_three'=>'position_3');
    }

    ?><div class="body-container body_con" id='body_position'>
        <div class="row-fluid">
            <!--Chart Icons -->
            <div class="span9" style="width:100%">
                <!--<div class="span12 widgg dis_wd" id='wigg_left'>
                    <div style='font-size:46px;font-weight:bold;'>+</div>
                    <div><h3 style='font-size:20px;font-weight:bold;'>Add Widget</h3></div>
                </div>-->
                <ul id="column1"><?php
                    foreach($center_positions as $pval => $divval)
                    {

                        if($divval == "position_3")
                        {
                            ?><li id="<?php echo $divval ?>" class="span12 mr_dr welcome_dr my_wel">
                            <div class="span12"  >
                                <div class="row-fluid">
                                    <div class="span12">
                                        <section class="utopia-widget main_div">
                                            <div class="utopia-widget-title">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
                                                <span id='edit_url' onClick="edit_url()"></span>
                                                <span><div id='head_tittle' class='cutz' alt='Welcome'><?php echo Controller::customize_label_welcome(_WELCOME);?></div></span>
                                                <div id="fav" title='<?=Controller::customize_label(_FAVORITELIST);?>' class="fav"></div>
                                                <span><div id="back_to" style="display:none;"></div></span>
                                                <div id="fav_list">
                                                    <table class='desx'><tr><td colspan='2' style="text-align:center;"><h3><?=Controller::customize_label(_ADDFAVORITELIST);?></h3></td></tr><tr>
                                                            <td style="font-size:11px;width:60px;">
                                                            <?=Controller::customize_label(_DESCRIPTION);?>:</td><td><input type='text' name='box' class="span11" id='fav_inp'/>
                                                            </td></tr>
                                                    </table>
                                                    <div style="float:right;width:150px;" id="uit">
                                                        <div id='removes' style="display:none">
                                                            <button class='btn span4' id='remove'><?=Controller::customize_label(_REMOVE);?></button><button class='btn span3 done' ><?=_EDIT?></button><button class='btn span3 fav_c' ><?=_CANCEL?></button></div>
                                                        <div id='dones' style="display:none"><button class='btn span5 done' ><?=Controller::customize_label(_DONE);?></button><button class='btn span5 fav_c' ><?=_CANCEL;?></button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="utopia-widget-content" ><?php
                                                $wel_url = "http://www.emergys.com";
                                                //$wel_url = "http://www.oncorpus.com";
                                                $companyid  = Yii::app()->user->getState("company_id");  
                                                $client     = Controller::companyDbconnection();
                                                $comp_doc   = $client->getDoc($companyid);
                                                if(isset($userdoc->welcome_urls->welcome_site))
                                                {
                                                    $wel_url = $userdoc->welcome_urls->welcome_site;
                                                }elseif(isset($comp_doc->welcome_urls) && $comp_doc->welcome_urls!='')
                                                {
                                                    $wel_url = $comp_doc->welcome_urls;
                                                }
                                                // $wel_url = Yii::app()->request->baseUrl."/images/thinui-logo-login.png";
                                                ?>
                                                <div id="out_put" style="display: none;">
                                                    <iframe src='<?php echo $wel_url;?>' style="width:100%;height:600px;visibility:visible;" frameborder='0' id='welcome_if'></iframe>
                                                </div>
                                                <input type="hidden" id="excelAjax" value="<?php echo Yii::app()->createAbsoluteUrl("common/excel"); ?>"/>
                                                <input type="hidden" id="csvAjax" value="<?php echo Yii::app()->createAbsoluteUrl("common/csv"); ?>"/>
                                                <input type="hidden" id="pdfAjax" value="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"/>
                                                <input type="hidden" id="excelexportAjax" value="<?php echo Yii::app()->createAbsoluteUrl("common/excelexport"); ?>"/>
                                                <div id="out_table" style='display:none;'></div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                            </li><?php
                        }
                    }
                    ?>
                </ul>
            </div>


            <!--Chart Icons End -->
        </div>
    </div>
    <!-- Body end -->
</div>


<!--------------------------------------------------------------------------------------------->
</div>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js" ></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.simpleWeather.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen.jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/header.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables1.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/smart_table-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.accordion.source.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tweetable.jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.timeago.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.core.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.widget.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.sortable.js"></script>


<script type="text/javascript" charset="utf-8">
if (typeof jQuery === "undefined") {
    alert('Jquery Not Included');
} else
{
    function randomBetween(min, max)
    {
        if (min < 0)
            return min + Math.random() * (Math.abs(min)+max);
        else
            return min + Math.random() * max;
    }
    function tab_ses_chk()
    {
        // console.log(sessionStorage.getItem('tab_sap_login'));
        if(sessionStorage.getItem('tab_sap_login') == null)
        {
            sessionStorage.setItem('tab_sap_login', localStorage.getItem('tab_sap_login'));
            sessionStorage.setItem('prev_seesid', localStorage.getItem('prev_seesid'));
            // console.log(localStorage.getItem('tab_sap_login'));
            // window.location.href = "host";
        }
        else
        {
            dataStrings = sessionStorage.getItem('tab_sap_login');
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/tabsystem"); ?>",
                data: dataStrings,
                success: function(datas)
                {
                    var html = datas.split("~");
                    $("#host_list .sys_len").html(html[1]);
                    $("#host_list .sys_len").attr("title", html[1]);
                    // $("#admin_u a").html(html[2]);
                   var sys = '<div class="sys_len sys_user_det" style="width:155px !important"><strong><a href="#" style="color: #025985;"><?php echo Yii::app()->user->getState("SYSID").'/'.Yii::app()->user->getState("CLIENT").' - '.Yii::app()->user->getState("userName"); ?></a></strong></div>';
                    $("#d_host_list").html(sys+html[3]);
                }
            });
        }
    }

    tab_ses_chk();
    var golb      = "";
    var page_url  = "welcome";
    var help_en   = "<?php echo $_SESSION['help_en']; ?>";
    var help_arry = $.cookie('help_en');

    if(help_arry == null)
    {
        $.cookie('help_en',help_en);
        help_arry = $.cookie('help_en');
    }

    function save_customize()
    {
        ////$('.widgg').addClass('dis_wd');
        ////$('.deld_wid').addClass('dis_wd');
        var datastr = '';
        var spl = 0;
        $('.customize_input').each(function(index, element) {
            var title = $(this).parent(this).attr('alt');
            datastr +=title +"="+ $(this).val()+",";
            var iChars = "!`@#$%^&*+=[]\\\';,{}|\":<>?~";
            var data=$(this).val();
            for (var i = 0; i < data.length; i++)
            {
                if (iChars.indexOf(data.charAt(i)) != -1)
                {
                    var specialCaracters =  '<?=Controller::customize_label(_SPECIALCARACTERS);?>';
                    var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                    jAlert(specialCaracters,message);
                    spl=1;
                }
            }
        });
        if(spl==1)
        {
            return false;
        }

        var dataString = "url="+page_url+"&lables="+datastr;

        $.ajax(
            {
                type: "POST",
                data:dataString,
                url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/savecustomize"); ?>",

                success: function(html) {
                    $('.customize_input').each(function(index, element)
                    {
                        var tag=$(this).attr('alt');
                        var sdt=$(this).val();
                        if(tag==1)
                        {
                            $(this).parent(this).html(sdt+"<span> * </span>:");
                        }
                        if(tag==2)
                        {
                            $(this).parent(this).html(sdt+":");
                        }
                        if(tag==0)
                        {
                            $(this).parent(this).html(sdt);
                        }
                    });
                    $('.edit_customize').show();
                    $('.save_customize').hide();
                }
            });
    }

    function  remove_class()
    {
        ////$('.widgg').addClass('dis_wd');
        ////$('.deld_wid').addClass('dis_wd');
        $('.customize_input').each(function(index, element) {
            $(this).remove();
        });
    }

    function resizeFrame(f)
    {
        var i = f.contentDocument.documentElement.scrollHeight;
        if(i<"600")
        {
            f.style.height = "600px";
        }
        else
        {
            f.style.height = (i+150)+"50px";
        }
    }

    function sap_app(url)
    {

        tab_ses_chk();
        // console.log(url);
        ////$('.widgg').remove();
        $('#welcome_if').hide();
        remove_class();

        $.cookie('sub_out','0');
        $('#back_to').hide();
        if($(document).width()<600) { $.cookie('table_cell','1,'); }

        if($(document).width()<1030&&$(document).width()>600) { $.cookie('table_cell','1,2,3,'); }
        if($(document).width()>1030) { $.cookie('table_cell','1,2,3,4,5,'); }
        $('.widget_hid').hide();
        $('.paypals').show();

        page_url = url;
        $('#column1').sortable({ cancel:".welcome_dr" });
        $('#edit_url').hide();
        $('.edit_customize').show();
        $('.save_customize').hide();

        $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });
        var help_fol = "";
        if(navigator.userAgent.match(/iPad/i))
            help_fol = "ipad/ipad_";
        else if(navigator.userAgent.match(/iPhone/i))
            help_fol = "iphone/iphone_";
        $('.help_thin').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+help_fol+url+'.jpg');
        $('#loading').show();

        // loading image
        $('#loading').css({position:'fixed'});
        $("body").css("opacity","0.4");
        $("body").css("filter","alpha(opacity=40)");

        if($(document).width()>450) {  $('#fav').show(); }

        var str = url;
        var srt = str.replace(/_/g," ");
        srt = srt.toLowerCase().replace(/\b[a-z]/g, function(letter) {  return letter.toUpperCase(); });
        $('#head_tittle').addClass('cutz').attr('alt',url);

        if(srt!='Coming Soon')
        {
            var datas="fav="+url+"&tit="+srt+"&type=bapi";

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/history"); ?>",
                data: datas,
                success: function(html) {
                    var histry=html.split("@");
                    $('#head_tittle').html(histry[0]);
                    $('#hist').html(histry[1]);
                }});
        }
        //..........................................................................
        $('#fav_inp').val(srt);
        var sdd = $('#fav_inp').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/favcheck"); ?>",
            data: datas,
            success: function(html)
            {
                $('#remove').attr('onclick','fav_r("'+url+'")');
                $('.done').attr("onclick","favt('"+sdd+"','"+url+"','bapi')");

                if(html=='Done')
                {
                    $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/favt.png) no-repeat'})
                    $('#uit').css({width:'230px'})
                    $('#removes').show();
                    $('#dones').hide();
                }
                else
                {
                    $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/fav.png) no-repeat'})
                    $('#removes').hide();
                    $('#dones').show();
                }
                $('.done').click(function()
                {
                    $('#fav_list').hide();
                    $('#uit').css({width:'230px'})
                    $('#removes').show();
                    $('#dones').hide();
                })
                $('#remove').click(function()
                {
                    $('#fav_list').hide();
                    $('#uit').css({width:'230px'})
                    $('#removes').hide();
                    $('#dones').show();
                })
                $('.fav_c').click(function(){ $('#fav_list').hide(); });
                $('#fav').click(function() { $('#fav_list').show(); });
            }
        });
        var widt = $(document).width();
        var beforeload = (new Date()).getTime();
        var datavals = 'url='+url+'&scr='+widt;

        $.ajax({
            type: "POST",
            url: url+'/'+url,
            data: datavals,
            success: function(html)
            {
                //alert(html);
                $(window).scrollTop(0);
                if(help_arry.search(url)<0)
                {
                    help_arry +=url+',';
                    $.cookie('help_en',help_arry);
                    help_t();
                }

                $('#out_table').hide();
                $('#out_put').html(html);


                //$('#loading').hide();
                //$("body").css("opacity","1");

                var afterload = (new Date()).getTime();
                seconds = (afterload-beforeload) / 1000;
                $("#load_time").text('Page load time ::  ' + seconds + ' sec(s).');
                color_tip();
            }
        });
        $('.sap_null').css({ display:'none' });
        $('.span9').css({ width:'100%' });
    }

    function sap_form(url)
    {

        tab_ses_chk();
        ////$('.widgg').remove();
        $('#welcome_if').hide();
        remove_class();

        $.cookie('sub_out','0');
        $('#back_to').hide();

        if($(document).width()<600) { $.cookie('table_cell','1,'); }
        if($(document).width()<1030&&$(document).width()>600) { $.cookie('table_cell','1,2,3,'); }
        if($(document).width()>1030) { $.cookie('table_cell','1,2,3,4,5,'); }

        page_url = url;
        $('.widget_hid').hide();
        $('.paypals').show();
        if(url=='subscription')
        {
            $('.paypals').hide();
        }
        $('#column1').sortable({ cancel:".welcome_dr" });
        $('#edit_url').hide();
        $('.edit_customize').show();
        $('.save_customize').hide();

        $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });

        var help_fol = "";
        if(navigator.userAgent.match(/iPad/i))
            help_fol = "ipad/ipad_";
        else if(navigator.userAgent.match(/iPhone/i))
            help_fol = "iphone/iphone_";
        $('.help_thin').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+help_fol+url+'.jpg');
        $('#loading').show();
        $('#loading').css({position:'fixed'});
        $("body").css("opacity","0.4");
        $("body").css("filter","alpha(opacity=40)");

        if($(document).width()>450) { $('#fav').show(); }

        var str = url;
        var srt = str.replace(/_/g," ");
        srt = srt.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        $('#head_tittle').addClass('cutz').attr('alt',url);
        if(srt=='Bi Reports')
        {
            srt='<?=_BIREPORTS?>';
        }
        if(srt=='Editsalesorder')
        {
            srt='<?=_DISPLAYSALESORDER?>';
        }
        if(srt=='Display List Approve')
        {
            srt='<?=_DISPLAYLISTAPPROVE?>';
        }
        if(srt!='Coming Soon')
        {
            var datas = "fav="+url+"&tit="+srt+"&type=forms&name=none";
            $.ajax(
                {
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/history"); ?>",
                    data: datas,
                    cache : false,
                    success: function(html)
                    {
                        var histry=html.split("@");
                        var srts=histry[0];
                        if(histry[0]=='Editsalesorder')
                        {
                            srts='<?=_DISPLAYSALESORDER?>';
                        }
                        if(histry[0]=='Editsalesquotation')
                        {
                            srts='<?=_DISPLAYSALESQUOTATION?>';
                        }
                        if(histry[0]=='Editcustomers')
                        {
                            srts='<?=_DISPLAYEDITCUSTOMER?>';
                        }
                        if(histry[0]=='Picking And Post Goods')
                        {
                            srts='<?=_PICKANDPOSTGOODS?>';
                        }
                        if(histry[0]=='Editvendors')
                        {
                            srts='<?=_DISPLAYANDEDITVENDOR?>';
                        }
                        if(histry[0]=='Edit Purchase Order')
                        {
                            srts='<?=_DISPLAYPURCHASEORDER?>';
                        }
                        if(histry[0]=='Post Good Receipt')
                        {
                            srts='<?=_POSTGOODSRECEIPT?>';
                        }
                        if(histry[0]=='Display List Approve')
                        {
                            srts='<?=_DISPLAYLISTAPPROVE?>';
                        }
                        if(histry[0]=='Quotation Document Flow')
                        {
                            srts='<?=_DOCUMENTFLOW?>';
                        }
                        if(histry[0]=='Editcustomers Master')
                        {
                            srts='<?=_EDITCUSTOMERMASTER?>';
                        }
                        if(histry[0]=='Editcostcenter Master')
                        {
                            srts='<?=_EDITCOSTCENTERMASTER?>';
                        }
                        if(histry[0]=='Create Costcenter Master')
                        {
                            srts='<?=_CREATECOSTCENTERMASTER?>';
                        }
                        if(histry[0]=='Review Status Customersmaster')
                        {
                            srts='<?=_REVIEWSTATUSCUSTOMERSMASTER?>';
                        }
                        if(url=='approve_purchase_requisition')
                            srts='<?=_APPROVECONVERTTOPO?>';

                        if(url=='display_billing_list')
                            srts='<?=_DISPLAYBILLINGDOCUMENT?>';

                        $('#head_tittle').html(srts);
                        $('#hist').html(histry[1]);
                    }
                });
        }
        //..........................................................
        $('#fav_inp').val(srt);
        var sdd=$('#fav_inp').val();
        $.ajax(
            {
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/favcheck"); ?>",
                data: datas,
                cache : false,
                success: function(html)
                {
                    $('.done').attr("onclick","favt('"+sdd+"','"+url+"','forms','none')");
                    $('#remove').attr('onclick','fav_r("'+url+'")');
                    if(html=='Done')
                    {
                        $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/favt.png) no-repeat'})
                        $('#uit').css({width:'230px'})
                        $('#removes').show();
                        $('#dones').hide();
                    }
                    else
                    {
                        $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/fav.png) no-repeat'});
                        $('#removes').hide();
                        $('#dones').show();
                    }
                    $('.done').click(function()
                    {
                        $('#fav_list').hide();
                        $('#uit').css({width:'230px'})
                        $('#removes').show();
                        $('#dones').hide();
                    })
                    $('#remove').click(function()
                    {
                        $('#fav_list').hide();
                        $('#uit').css({width:'230px'})
                        $('#removes').hide();
                        $('#dones').show();
                    })
                    $('.fav_c').click(function(){
                        $('#fav_list').hide();
                    })
                    $('#fav').click(function()
                    {
                        $('#fav_list').show();
                    });
                }
            });

        var widt = $(document).width();
        var beforeload = (new Date()).getTime();
        var form_values = 'url='+url+'&scr='+widt;

        if(url == 'profile'){
            var ContarollerAction = '<?php echo Yii::app()->createAbsoluteUrl("host/"); ?>/'+url;
        } else {
            var ContarollerAction = url+'/'+url;
        }
        // alert(ContarollerAction);
        if($.cookie('form_values')!=null&&$.cookie('form_values')!='')
        {
            form_values = $.cookie('form_values');
            submit_form('forms');
        }
        else
        {
            $('#out_table').html(' ');
            $.ajax({
                type: "POST",
                data:form_values,
                url: ContarollerAction,
                cache : false,
                success: function(html)
                {
                    // alert(html);
                    $(window).scrollTop(0);
                    if(help_arry.search(url)<0)
                    {
                        help_arry +=url+',';
                        $.cookie('help_en',help_arry);
                        help_t();
                    }
                    $('#out_put').show();
                    $('#out_table').hide();
                    $('#out_put').html(html);
                    $.cookie('form_values','');
                    $('#loading').hide();
                    $("body").css("opacity","1");
                    var afterload = (new Date()).getTime();
                    seconds = (afterload-beforeload) / 1000;
                    $("#load_time").text('Page load time ::  ' + seconds + ' sec(s).');

                    /*
                     $('form').find("input, select, textarea").blur(function () {
                     var ctrl_id = $(this).attr("id");
                     var ctrl_frm_id = $(this).closest("form").attr("id");
                     if($("."+ctrl_id+"formError").is(":visible"))
                     $("#"+ctrl_frm_id).validationEngine("validate");
                     });
                     */
                }
            });
        }
        $('.sap_null').css({ display:'none' });
        $('.span9').css({ width:'100%' });
        
    }

    function favt(title ,data, type)
    {
        var ds    = $('#fav_inp').val();
        var datas = "fav="+data+"&type="+type+"&tit="+ds;
        $.ajax({
            type: "POST",
            url: "common/tablestore",
            data: datas,
            success: function(html) {
                his_fav_list('d_favt');
                $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/favt.png) no-repeat'});
                $('#fav_list').hide();
            }
        });
    }

    function fav_r(data)
    {
        datas="rem="+data;
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/favcheck"); ?>",
            data: datas,
            success: function(html) {
                $('#fav').css({background:'url(<?php echo Yii::app()->request->baseUrl; ?>/images/fav.png) no-repeat'});
                his_fav_list('d_favt');
                $('#fav_list').hide();
                $('#removes').hide();
                $('#dones').show();
            }
        });
    }

    function titl(name){ $('#head_tittle').html(name); }

    function get_seesid()
    {
        // datas="sess="+sessionStorage.getItem('prev_seesid');
        $.cookie('prev_seesid', sessionStorage.getItem('SESSION'));
        return false;
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/seesid"); ?>",
            data: datas,
            success: function(html) {
                // alert(html);
            }
        });
    }

    function systems(values,id,host_ids)
    {
        var hst = values.split(',');
        jPrompt('', host_ids, hst[1]+'System details', function(r) {
            if( r )
            {
                $.cookie('host_ids',host_ids);
                var para=r.split(',');
                var host_val=values.split(',');
                var total_val=host_val[0]+","+host_val[1]+","+host_val[2]+","+host_val[3]+","+host_val[4]+","+host_val[5]+","+para[0]+","+para[1]+","+host_val[6]+","+host_val[7]+","+host_val[8]+","+para[13];
                $('#loading').show();
                $("body").css("opacity","0.4");
                $("body").css("filter","alpha(opacity=40)");
                var dataString =total_val+"&paz="+para[2];
                sessionStorage.setItem('tab_sap_login', dataString);
                localStorage.setItem('tab_sap_login', dataString);
                // $.cookie('prev_seesid',$.cookie('PHPSESSID'));

                $.ajax({
                    type: "POST",
                    url: "host/hostcheck",
                    data: dataString,
                    success: function(html) {
                        if(html=='dashboard')
                        {
                            tab_sesid = Math.floor(randomBetween(000000, 999999));
                            // console.log(tab_sesid);
                            sessionStorage.setItem('SESSION', tab_sesid);

                            // console.log($.cookie('PHPSESSID'));
                            sessionStorage.setItem('prev_seesid', $.cookie('PHPSESSID'));
                            $.cookie('prev_pass',r);
                            $.cookie('prev_host',hst[1]+'/'+hst[3]+'/'+hst[4]);
                            window.location.replace(html);
                        }
                        else
                        {
                            sessionStorage.removeItem("tab_sap_login");
                            $('#loading').hide();
                            $("body").css("opacity","1");

                            $('#'+id+'_del').css({
                                border:'1px solid red'
                            });
                            var errorConectionSAP =  '<?=Controller::customize_label(_ERRORCONECTIONSAP);?>';
                            var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                            jAlert(errorConectionSAP,message);
                            $('#'+id+'_inv').html("");
                            $('#'+id+'_inv').css({
                                color:'red',
                                'font-size':'12px',
                                'font-weight':'normal'
                            });
                        }
                    }
                });
            }
        });
    }

    function systems_bi(id,url,ids)
    {
        var vals=url.split(',');
        if($.cookie('prev_host')==vals[1]+','+vals[2]+','+vals[3]+','+vals[4])
        {
            $('#'+id+'_inv').html("<img src='../img/aj_load.gif'>");
            window.location.replace('dashboard.php');
        }
        else
        {
            if(vals[2]=='NON')
            {
                $('#'+id+'_inv').html("<img src='../img/aj_load.gif'>");
                $.ajax({
                    url: '../lib/controller.php?page=soap_check&name=non&pass=non&des='+vals[0]+'&url='+vals[1]+'&cms_name='+vals[2]+'&cms_port='+vals[3]+'&auth_type='+vals[4],
                    success: function(data) {
                        if(data=='done')
                        {
                            $.cookie('prev_host',vals[1]+','+vals[2]+','+vals[3]+','+vals[4]);
                            window.location.replace('dashboard.php');
                        }
                        else
                        {
                            var errorConectionSAP =  '<?=Controller::customize_label(_ERRORCONECTIONSAP);?>';
                            var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                            jAlert(errorConectionSAP,message);
                            $('#'+id+'_inv').html("");
                            $('#'+id+'_inv').css({
                                color:'red',
                                'font-size':'12px',
                                'font-weight':'normal'
                            });
                        }
                    }
                });
            }
            else
            {
                jPrompt_bi('', ids, 'BOBJ System details', function(r) {
                    if( r )
                    {
                        $('#'+id+'_inv').html("<img src='../img/aj_load.gif'>");
                        var values=r.split(',');
                        $.ajax({
                            url: '../lib/controller.php?page=soap_check&name='+values[0]+'&pass='+values[1]+'&des='+vals[0]+'&url='+vals[1]+'&cms_name='+vals[2]+'&cms_port='+vals[3]+'&auth_type='+vals[4],
                            success: function(data) {
                                if(data=='done')
                                {
                                    $.cookie('prev_host',vals[1]+','+vals[2]+','+vals[3]+','+vals[4]);
                                    window.location.replace('dashboard.php');
                                }
                                else
                                {
                                    var errorConectionSAP =  '<?=Controller::customize_label(_ERRORCONECTIONSAP);?>';
                                    var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                                    jAlert(errorConectionSAP,message);
                                    $('#'+id+'_inv').html("");
                                    $('#'+id+'_inv').css({
                                        color:'red',
                                        'font-size':'12px',
                                        'font-weight':'normal'
                                    });
                                }
                            }
                        });
                    }
                });
            }
        }
    }

    function his_fav_list(type)
    {
        var datas = "fav=none&tit=none&type="+type+"&name=none";

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("dashboard/history"); ?>',
            data: datas,
            success: function(html)
            {
                var histry = html.split("@");
                if(histry[1] == "")
                {
                    if(type == 'd_favt')
                    {
                        var favoritesNotFound = '<li><?=Controller::customize_label(_FAVORITESNOTFOUND);?></li>';
                        $('#'+type).html(favoritesNotFound);
                    }
                    else
                    {
                        var historyNotFound = '<li><?=Controller::customize_label(_HISTORYNOTFOUND);?></li>';
                        $('#'+type).html(historyNotFound);
                    }
                }
                else
                {
                    $('#'+type).html(histry[1]);
                }
            }
        });
    }

    function submit_ajaxform(id)
    {
        //alert(id);
        var url = $("#"+id+" input[name='url']").val();

        $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });

        var widt = $(document).width();
        $('#loading').show();
        $("body").css("opacity","0.4");
        $("body").css("filter","alpha(opacity=40)");

        // alert($.cookie('form_values'));
        var datastr=$('#'+id).serialize();

        //alert(datastr);
        var urls=url;

        if(url == 'picking_and_post_goods')
        {
            var urls='picking'
        }
        datastr = datastr+'&scr='+widt;
        //alert(urls);
        $.ajax(
            {
                type:'POST',
                data:datastr,
                url: url+'/'+urls,
                success: function(response)
                {
                    $.cookie('form_values','');
                    $('#loading').hide();
                    $("body").css("opacity","1");
                    if (response.indexOf("Error in rfc") >= 0)
                    {
                        jAlert(response, 'Error Message');
                    }
                    else
                    {
                        var sapSystemMessage =  '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
                        var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                        jAlert(sapSystemMessage+' '+response, message);
                        color_tip();
                    }
                }
            })
        $('#'+id+' input').each(function(index, element)
        {
            var names=$(this).attr('name');
            if($(this).attr('alt')=='MULTI')
            {
                names=$(this).attr('id');
            }
            var values=$(this).val();
            if(values!="")
            {
                var cook=$.cookie(names);
                var name_cook=values;
                if(cook!=null)
                {
                    name_cook=cook+','+values;
                }
                if($.cookie(names))
                {
                    var str=$.cookie(names);
                    var n=str.search(values);
                    if(n==-1)
                    {
                        $.cookie(names,name_cook);
                    }
                }
                else
                {
                    $.cookie(names,name_cook,{ expires: 365 });
                }
            }
        });
    }
    function submit_form(id)
    {
        var url = $("#"+id+" input[name='url']").val();
        $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });
        $('#out_table').html('');
        var widt = $(document).width();
        $('#loading').show();
        $("body").css("opacity","0.4");
        $("body").css("filter","alpha(opacity=40)");

        // alert($.cookie('form_values'));
        if(id=='forms')
        {
            var datastr=$.cookie('form_values');
        }
        else
        {
            var datastr=$('#'+id).serialize();
        }
        datastr = datastr+'&scr='+widt;
        // alert(datastr);
        $.ajax(
            {
                type:'POST',
                data:datastr,
                url: url+'/'+url,
                success: function(response)
                {

                    $.cookie('form_values','');
                    $('#loading').hide();
                    $("body").css("opacity","1");
                    if (response.indexOf("Error in rfc") >= 0)
                    {
                        var errorMessage =  '<?=Controller::customize_label(_ERRORMESSAGE);?>';
                        jAlert(response, errorMessage);
                    }
                    else
                    {
                        if($.cookie('sub_out')==1)
                        {
                            $('#out_put').hide();
                            $('#out_table').show();
                            $('#out_table').html(response);
                        }
                        else
                        {
                            $.cookie('validation_form',id);
                            $.cookie('form_values','');
                            $('#back_to').hide();
                            $('#out_put').show();
                            $('#out_table').hide();
                            $('#out_table').html('');
                            $('#out_put').html(response);
                        }
                        color_tip();
                    }
                }
            })
        $('#'+id+' input').each(function(index, element)
        {
            var names=$(this).attr('name');
            if($(this).attr('alt')=='MULTI')
            {
                names=$(this).attr('id');
            }
            var values=$(this).val();
            if(values!="")
            {
                var cook=$.cookie(names);
                var name_cook=values;
                if(cook!=null)
                {
                    name_cook=cook+','+values;
                }
                if($.cookie(names))
                {
                    var str=$.cookie(names);
                    var n=str.search(values);
                    if(n==-1)
                    {
                        $.cookie(names,name_cook);
                    }
                }
                else
                {
                    $.cookie(names,name_cook,{ expires: 365 });
                }
            }
        });
    }

    function str_pad(input, pad_length, pad_string, pad_type)
    {
        var half = '',
            pad_to_go;

        var str_pad_repeater = function (s, len) {
            var collect = '',i;

            while (collect.length < len) {
                collect += s;
            }
            collect = collect.substr(0, len);

            return collect;
        };

        input += '';
        pad_string = pad_string !== undefined ? pad_string : ' ';

        if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
            pad_type = 'STR_PAD_RIGHT';
        }
        if ((pad_to_go = pad_length - input.length) > 0) {
            if (pad_type === 'STR_PAD_LEFT') {
                input = str_pad_repeater(pad_string, pad_to_go) + input;
            } else if (pad_type === 'STR_PAD_RIGHT') {
                input = input + str_pad_repeater(pad_string, pad_to_go);
            } else if (pad_type === 'STR_PAD_BOTH') {
                half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                input = half + input + half;
                input = input.substr(0, pad_length);
            }
        }
        return input;
    }

    function getBapitable(table,tec_names,id,type,tool,table_name,from) // row, @third parameter
    {
        if($('#t_scrl').length>0 || from=='show_more')
                $('#t_scrl').remove();
        var widt = $(document).width();
        var row  = '';
        $(document).find('.head_fix').each(function() { $(this).remove(); });
        if(table_name=='Sales_orders')
        {
            if($('#CUSTOMER_ID').val()=="") { $("#validation").validationEngine(); return false; }
        }
        if(table_name=='Search_purchase_requisition')
        {
            // if($('#REL_CODE').val()=="") { $("#validation").validationEngine(); return false; }
        }
        if(table_name=='Supply_list')
        {
            if($('#PLANT').val()=="" || $('#PURCH_ORG').val()=="" )
            {
                $("#validation").validationEngine(); return false;
            }
        }
        if(table_name=='Search_sales_orders' || table_name=='Search_sales_quotation')
        {
            var fId = 'validation1';
            if( $('#SALES_ORGANIZATION').val()=="" || $('#BUSINESS_UNITS').val()=="" || (table_name=='Search_sales_orders' && $('#CUSTOMER_ID').val()=="" ))
            {
                $("#validation").validationEngine(); return false;
            }
        }
        if(table_name=='Document_flow')
        {
            if($('#DOCUMENT_NUMBER').val()=="")
            {
                $("#validation_new").validationEngine(); return false;
            }
        }

        if(table_name=='material_availability')
        {
            if($('#I_MATNR').val()=="")
            {
                $("#validation").validationEngine(); return false;
            }
        }
        var er='';
        if(table_name=='Approve_customers_master')
        {
        
        if($('#Users').val()=="" && $('#datepicker').val()=="" && $('#datepicker1').val()=="") 
        { 
            $('#loading').hide();
            $("body").css("opacity","1");
            var pleaseProvideUserID =  '<?=Controller::customize_label(_PLEASEPROVIDEUSERID);?>';
            var alert =  '<?=Controller::customize_label(_ALERT);?>';
            jAlert(pleaseProvideUserID,alert); 
            return false; 
        }
        }
        if(from == 'submit')
        {

            var fId = 'validation';
            if(table_name == 'Sales_orders'){ var fId = 'validation_editcustomers';}
            if(table_name == 'Search_customers'){ var fId = 'validation_cus';}
            if(table_name == 'Search_sales_quotation'){ var fId = 'validation_ser';}
            if(table_name == 'Document_flow'){ var fId = 'validation_new';}
            var datastr = $('#'+fId).serialize();
            if(table_name == 'Search_customers')
            {

                $('#scountry_list').val('');
                var cuid = $('#customer').val();
                var cusLenth = cuid.length;

                if(cusLenth < 10 && cuid != "")
                {
                    //cuid = str_pad(cuid, 10, 0, 'STR_PAD_LEFT');
                    //$('#customer').val(cuid);
                }
                /* else
                 {
                 alert(cuid);
                 cuid = cuid.substr( cuid, -10 );
                 alert(cuid);
                 }

                 var datastr = $('#'+fId).serialize();
                 */
                $('#tables').show();
                var datastr = datastr.replace('&url_nearby=search_customers_nearby',"");
                datastr = datastr.replace('&searched_type=near_map',"&searched_type=list");
                datastr = datastr.replace('&searched_type=near_map',"&searched_type=near_list");
                $('#maps').html('');
                $('#maps').hide();
                $('#maps').css({height:'0px'});
                $('#map_list').attr('class', 'btn spanbt back_b');
                $('#n_map_list').attr('class', 'btn spanbt back_b');
            }
            if(table_name == 'Todays_Orders' ) {

                var datastr = '&page=table_data';
            }
        }
        else
        {

        }

        var num = $('#'+id+'_num').html();
        $(".head_icons").hide();
        $(".testr").text('');

        if(type == 'S')
        {
            jh = Number(num)+10;
            $('#'+id+'_num').html(jh);
            $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
        }
        else
        {
            if(from == 'submit')
            {
                var row = '';
                $('#loading').show();
                $("body").css("opacity","0.4");
                $("body").css("filter","alpha(opacity=40)");
            }
            if(from == 'tab')
            {
                $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
                $('.testr').show();
            }
            jh = 10;
        }
        if(row!='')
        {
            if(row<=10) { jh=row; }
            if(jh>row)  {
                $('.'+table).hide();
                jh=row;
            }
            else { $('.'+table).show(); }
        }
        if(datastr == undefined)
            datastr = 'scr='+widt+'&kiu='+jh+'&table='+table+'&row='+row+'&tec='+tec_names+'&t_id='+id+'&tool='+tool+'&table_name='+table_name+'&from='+from;
        else
            datastr = datastr + '&scr='+widt+'&kiu='+jh+'&table='+table+'&row='+row+'&tec='+tec_names+'&t_id='+id+'&tool='+tool+'&table_name='+table_name+'&from='+from;


        var url_name=table_name;
        if(table_name=='approve_purchase_requisition')
            $('#table_convert_PO').html('');
        if(table_name == 'Document_flow')
        {
        if(table=='table_deliv1')
            $('#table_todays1').html('');
        else
            $('#table_deliv1').html('');
        }    
        if(table_name == 'Sales_order_dashboard')
        {
        $('#table_deliv').html('');
        }else if(table_name == 'Sales_order_dashboard_delivery')
        {
            $('#table_todays').html('');
        } 
        if(table_name == 'Todays_Orders'||table_name == 'Return_Orders'||table_name == 'Sales_Orders_Due_for_Delivery'||table_name == 'Delivery_Due_for_Billing')
        {
            url_name='sales_workbench'
            if(table=='table_today')
            {
            $('#backorders').html('');
            $('#table_delivery').html('');
            $('#table_billing').html('');
            $('#table_return').html('');
            }else if(table=='backorders')
            {
            $('#table_today').html('');
            $('#table_delivery').html('');
            $('#table_billing').html('');
            $('#table_return').html('');
            }else if(table=='table_return')
            {
            $('#backorders').html('');
            $('#table_delivery').html('');
            $('#table_billing').html('');
            $('#table_today').html('');
            }else if(table=='table_delivery')
            {
            $('#backorders').html('');
            $('#table_today').html('');
            $('#table_billing').html('');
            $('#table_return').html('');
            }else if(table=='table_billing')
            {
            $('#backorders').html('');
            $('#table_delivery').html('');
            $('#table_today').html('');
            $('#table_return').html('');
            }
        }
        if(table_name=='Sales_order_dashboard_delivery')
        {
            url_name='sales_order_dashboard'
            $('#table_today').html('');
            $('#t_scrl').remove();
        }
        if(table_name=='Search_purchase_requisition_Rel')
        {
            url_name='Search_purchase_requisition'
            url_action = 'tabledataRelease';
        }
        else if(table_name=='Search_purchase_requisition_PO')
        {
            url_name='Search_purchase_requisition'
            url_action = 'tabledataPO';
            $('#table_today1').html('');
            $('#t_scrl').remove();
        }else if(table_name=='Customer_all_items')
        {
        url_name='Customer_open_items'
            url_action = 'tabledataall';
        }else
            url_action = 'tabledata';
        // alert(datastr);
        //alert(url_name);
        $.ajax(
            {
                type:'POST',
                data:datastr,
                url: url_name+'/'+url_action,

                success: function(response)
                {

                    //alert(response);
                    // alert(datastr + ' - ' +response);
                    
                    $('#loading').hide();
                    $("body").css("opacity","1");
                    if(table_name == 'Todays_Orders' || table_name == 'prodcution_workbench') $('#out_put').show();
                    var resp = response.split('@');
            
                    $(document).find('.head_fix').each(function(index, element)
                    {
                        $(this).remove();
                    });
                    if($('#t_scrl').length>0)
                        $('#t_scrl').html('');
                    
                    if(resp[1] != 'E' && $('#t_scrl').length==0)
                        response='<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;" id="t_scrl"></div>'+response;
                    
                    
                    if(resp[1] == 'E'){
                        var sapSystemMessage =  '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
                        var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                        jAlert(sapSystemMessage+' '+ resp[0], message);
                        $(".head_icons span").addClass("table_top_hide");
                    }else if(table_name == 'Sales_orders' )
                    {
                        if(response.indexOf('id="editcustomers_page"') < 0)
                        {
                        
                            $('#edit_form').closest(".tabbable").find(".menu_tab").hide();
                            $('#calt').css('display','block');
                            $('#edit_form').html(response);
                        }
                        else
                        {
                            $('#edit_form').closest(".tabbable").find(".menu_tab").show();
                            $('#calt').css('display','block');
                            
                            $('#'+table).html(response);
                            $('#editcustomers_page').css('display','block');
                            $('#edit_form').html($('#editcustomers_page').html());
                            if(from != 'submit' || $('#li_2').hasClass('active')==true) $('.editcustomers_page').hide();
                        }
                    }
                    else if(table_name=='Approve_customers_master' || table_name=='Review_status_customersmaster' || table_name=='Editcostcenter_master')
                    {
                    $('#'+table).html(response);
                    $('#calt').css('display','block');
                    }
                    else
                    {
                       
                            $('#'+table).html(response);
                    }
                    
                    if(from == 'tab') { $('#'+id+'_num').text('10') }
                    if(table_name == 'Search_customer' || table_name == 'Search_vendors')
                    {
                        if($('#rowsagt').val() == 0) { $('#post,.table_head').hide(); $('#'+table).text('Match not Found'); } else { $('#post,.table_head').show(); }
                        if($("#scountry").val()!="") $("#scountry").val("");
                    }
                    if(table_name == 'Sales_order_dashboard')
                    {
                        $('#graph_Sales_order_dashboard').css('display','block');
                        $('#graph').html($('#graph_Sales_order_dashboard').html());
                        $('.container-fluid').css('display','block');
                        $('#graph_Sales_order_dashboard').css('display','none');
                    }
                    if(table_name == 'Search_purchase_requisition' || table_name == 'approve_purchase_requisition')
                    {
                        $('.container-fluid').css('display','block');
                        
                    }
                    if(table_name == 'Document_flow')
                    {

                        // alert($('#'+table).closest("#out_table").is(":visible"));
                        if($('#'+table).closest("#out_table").is(":visible"))
                        {
                            $('#out_table .container-fluid').css('display','block');
                            cur_tab_id = $('#out_table .container-fluid #menu_tab').find(".active").attr("id");
                            if(from == 'tab' && cur_tab_id == 'df_li_2')
                            {
                                $("#out_table #tab-content .tab-pane").hide();
                                $('#out_table .container-fluid #tab2').show();
                            }
                        }
                        else
                        {
                            $('.container-fluid').css('display','block');
                            cur_tab_id = $('.container-fluid #menu_tab').find(".active").attr("id");
                        }
                        if(from == 'submit' && cur_tab_id == 'df_li_2')
                            getBapitable("table_deliv1","DOCUMENT_FLOW_ALV_STRUC","example2","L",tool,table_name,'tab');
                    }
                    // var wids=$('.table').width();
                    // console.log(table+" "+$('#'+table).width());
                    //var wids = $('#'+table).width();
                    // $('.head_icons').attr('style','width: 990px');
                    //if(wids != 0)
                    //    $('.head_icons').attr('style','width: '+wids+'px');
                    //$('.head_icons').css({ width:wids+'px'});
                    row = $('#'+id+'_row').val();
                     if(row!=0)
                    {
                        data_table(id);
                        $('#'+id).each(function()
                        {
                            $(this).dragtable(
                                {
                                    placeholder: 'dragtable-col-placeholder test3',
                                    items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                                    appendTarget: $(this).parent(),
                                    tableId:id,
                                    tableSess:table,
                                    scroll: true
                                });
                            if($('#t_scrl').length==1)
                            {
                            $('#t_scrl').insertBefore($('.bottom'));
                            $('#t_scrl').append($('#'+id));
                            }
                        })
                    }

                    $('.head_icons').show();
                    $('.testr').html("");
                    if(parseInt(row) > parseInt(jh))
                    {
                        $('.testr').show();
                        var showMore =  '<?=Controller::customize_label(_SHOWMORE);?>';
                        $('.testr').html(showMore);
                    }

                    if(jh>row) { $('.'+table).hide(); }
                    //if(table_name == 'Delivery_list' && $('#'+id).text() == '') { $('#table_top').append('<span id="no_record">Match not Found</span>'); $('.head_icons').hide(); } else { $('#no_record').remove(); $('.head_icons').show();  }

                    var wids = $('#'+table).width();
                    // alert("  index  " +wids)
                    // $('.head_icons').attr('style','width: 990px');
                    if(wids != 0)
                        $('.head_icons').attr('style','width: '+wids+'px');
                }
            });
            
        return false;
    }

    function kop_test(table,tec_names,id,type,tool,table_name,from) // row, @third parameter
    {
        // alert(table_name);
        var fId = 'validation';
        if(table_name=='Sales_orders')
        {
            if($('#CUSTOMER_ID').val()=="") { $("#validation").validationEngine(); return false; }
        }
        if(table_name=='Search_sales_orders')
        {
            var fId = 'validation1';
            if($('#CUSTOMER_NUMBER').val()=="" || $('#SALES_ORGANIZATION').val()=="" || $('#BUSINESS_UNITS').val()=="" || $('#datepicker').val()=="" )
            {
                $("#validation").validationEngine(); return false;
            }
        }
        var widt = $(document).width();
        var row  = '';
        if($('#'+id+'_row').val()!='') row = $('#'+id+'_row').val();

        $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });

        if(from == 'submit')
        {
            var datastr = $('#'+fId).serialize();
            if(table_name == 'Search_customer')
            {
                $('#tables').show();
                var datastr = datastr.replace('&url_nearby=search_customers_nearby',"");
                datastr = datastr.replace('&searched_type=near_map',"&searched_type=list");
                datastr = datastr.replace('&searched_type=near_map',"&searched_type=near_list");
                $('#maps').hide();
                $('#maps').css({height:'0px'});
                $('#map_list').attr('class', 'btn spanbt back_b');
                $('#n_map_list').attr('class', 'btn spanbt back_b');
            }
            if(table_name == 'Todays_Orders' || table_name == 'Sales_order_credit_block') var datastr = '&page=table_data';
        }
        else
        {
            // var datastr = '&page=table_data';
        }

        var num = $('#'+id+'_num').html();
        $(".head_icons").hide();
        $(".testr").text('');

        if(type == 'S')
        {
            jh = Number(num)+10;
            $('#'+id+'_num').html(jh);
            $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
        }
        else
        {
            if(from == 'submit')
            {
                var row = '';
                $('#loading').show();
                $("body").css("opacity","0.4");
                $("body").css("filter","alpha(opacity=40)");
            }
            if(from == 'tab')
            {
                $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
            }
            jh = 10;
        }
        // alert(datastr);
        if(row!='')
        {
            if(row<=10)
            {
                jh=row
            }
            if(jh>row)
            {
                $('.'+table).hide();
                jh=row;
            }
            else
            {
                $('.'+table).show();
            }
        }
        //alert('../lib/controller.php?scr='+widt+'&kiu='+jh+'&table='+table+'&row='+row+'&tec='+tec_names+'&t_id='+id+'&tool='+tool+'&table_name='+table_name+'&from='+from);
        var datastr = 'scr='+widt+'&kiu='+jh+'&table='+table+'&row='+row+'&tec='+tec_names+'&t_id='+id+'&tool='+tool+'&table_name='+table_name+'&from='+from;

        $.ajax(
            {
                type:'POST',
                data:datastr,
                url: '<?php echo Yii::app()->createAbsoluteUrl("common/tabledata"); ?>',

                success: function(response)
                {
                    // alert(response);
                    $('#loading').hide();
                    $("body").css("opacity","1");
                    if(table_name == 'Todays_Orders' || table_name == 'prodcution_workbench') $('#out_put').show();
                    var resp = response.split('@');
                    $(document).find('.head_fix').each(function(index, element)
                    {
                        $(this).remove();
                    });
                    if(table_name == 'Sales_orders')
                    {
                        $('#calt').css('display','block');
                        $('#'+table).html(response);
                        $('#editcustomers_page').css('display','block');
                        $('#edit_form').html($('#editcustomers_page').html());
                        if(from != 'submit' || $('#li_2').hasClass('active')==true) $('.editcustomers_page').hide();
                    }
                    else
                    {
                        $('#'+table).html(response);
                    }

                    if(from == 'tab') { $('#'+id+'_num').text('10') }
                    if(table_name == 'Search_customer' || table_name == 'Search_vendors')
                    {
                        if($('#rowsagt').val() == 0) { $('#post,.table_head').hide(); $('#'+table).text('Match not Found'); } else { $('#post,.table_head').show(); }
                        if($("#scountry").val()!="") $("#scountry").val("");
                    }
                    if(table_name == 'Sales_order_dashboard')
                    {
                        $('#graph_Sales_order_dashboard').css('display','block');
                        $('#graph').html($('#graph_Sales_order_dashboard').html());
                        $('.container-fluid').css('display','block');
                        $('#graph_Sales_order_dashboard').css('display','none');
                    }

                    var wids = $('#'+table).width();
                    // $('.head_icons').attr('style','width: 990px');
                    $('.head_icons').attr('style','width: '+wids+'px');
                    row = $('#'+id+'_row').val();
                    if(row!=0)
                    {
                        data_table(id);
                        $('#'+id).each(function()
                        {
                            $(this).dragtable(
                                {
                                    placeholder: 'dragtable-col-placeholder test3',
                                    items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                                    appendTarget: $(this).parent(),
                                    tableId:id,
                                    tableSess:table,
                                    scroll: true
                                });
                        })
                    }
                    $('.head_icons').show();
                    $('.testr').html("");
                    if(parseInt(row) > parseInt(jh))
                    {
                        $('.testr').show();
                        $('.testr').html('Show more');
                    }
                    if(jh>row) { $('.'+table).hide(); }
                    if(table_name == 'Delivery_list' && $('#'+id).text() == '') { $('#table_top').append('<span id="no_record">Match not Found</span>'); $('.head_icons').hide(); } else { $('#no_record').remove(); $('.head_icons').show();  }
                }
            });
        return false;
    }

    function kop(table,tec_names,row,id,type,tool,table_name) // row, @third parameter
    {
        $('.head_icons').hide();
        $(document).find('.head_fix').each(function(index, element)
        {
            $(this).remove();
        });

        // $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
        var num = $('#'+id+'_num').html();
        if(type == 'S')
        {
            jh=Number(num)+10;
            $('#'+id+'_num').html(jh);
            $('.testr').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/fb_load.gif'>");
        }
        else
        {
            jh=10;
        }
        if(row<=10)
        {
            jh=row
        }
        if(jh>row)
        {
            $('.'+table).hide();
            jh=row;
        }
        else
        {
            $('.'+table).show();
        }

        $.ajax({
            type:'POST',
            url: 'sub_links/bapi_store.php?kiu='+jh+'&table='+table+'&tec='+tec_names+'&row='+row+'&t_id='+id+'&tool='+tool+'&table_name='+table_name,

            success: function(response)
            {
                var resp= response.split('@');
                $(document).find('.head_fix').each(function(index, element) {
                    $(this).remove();
                });
                $('#'+table).html(response);
                if(row!=0)
                {
                    data_table(id);
                    $('#'+id).each(function(){
                        $(this).dragtable({
                            placeholder: 'dragtable-col-placeholder test3',
                            items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                            appendTarget: $(this).parent(),
                            tableId:id,
                            tableSess:table,
                            scroll: true
                        });
                    })
                }
                $('.head_icons').show();

                //sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
                $('.testr').html('Show more');
                if(jh>row)
                {
                    $('.'+table).hide();
                }
            }
        })
    }

    function color_tip() { $('[tip]').colorTip({color:'red'}); }


    //function we_db(type,ids) { if(type=='Remove') { delete_weigt(ids); }else{ add_widget(ids); } }

    /*function add_widget(ids)
    {
        $('.'+ids).removeClass('none_wegid').show();
        $.ajax({
            type: "POST",
            data:"type=wegid&wegid_type="+ids+"&display=Remove",
            url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/welcomeurls"); ?>",
            success: function(html) {
                $('.'+ids+'_tr').hide();
                $('#'+ids+'_x').html(html);
                all_r();
            }
        })
    }
*/
    //commented by kavin
    /*function delete_weigt(ids)
    {
        $('.'+ids).hide();
        $.ajax({
            type: "POST",
            data:"type=wegid&wegid_type="+ids+"&display=Add",
            url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/welcomeurls"); ?>",
            success: function(html) {
                $('.'+ids+'_tr').removeClass('none_wegid');
                $('.'+ids+'_tr').show();
                $('#'+ids+'_x').html(html);
                all_r();
            }
        });
    }*/

    $(document).ready(function()
    {
        
        $('#out_put').bind("DOMSubtreeModified",function(){
            $(document).find('input:text').blur(function(){
                $(this).val($.trim($(this).val()));
            });
        });
        $('#out_put').show();
        //.........................................................................
        $('#childframe').css({ height:'990px' });
        //.........................................................................

        /*$.ajax({ type: "POST", data:"type=check_w", url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/welcomeurls"); ?>", success: function(html) { }  });*/
        //.........................................................................
        $('ul').accordion();
        //.........................................................................
        $('.level-3 li a').click(function(){ $.cookie('form_values',''); })
        $.cookie('form_values','');
        var page = window.location.hash;
        //var page_id = $('ul.accordion div').attr('id');
        if(page!='')
        {
            /////$('.level-1 li').first().removeClass('active');
            $(page+'_t').trigger('click');
        }else{
            var page_id = $('ul.accordion div').attr('id');
            //window.location.replace(window.location+$("div#"+page_id).prev().attr('href'))
            //subtu($("div#"+page_id).prev().attr('id'));
           //$('#'+page_id).trigger('click');

        }
        $(window).on('hashchange', function(){
            var page = window.location.hash;
            $(page!='')
            {
                var sdr=page.replace(/^#/, '');
                subtu(sdr);
                $(page+'_t').trigger('click');
            }
        });
        //.........................................................................
        $('#feedback').feedBackBox();
        color_tip();
        if(help_arry.search('dashbord_page')<0)
        {
            //alert("")
            help_arry +='dashbord_page,';
            $.cookie('help_en',help_arry);
            help_t();
        }
        his_fav_list('hist');
        his_fav_list('d_favt');
        $('#nav_tab').mousemove(function()
        {
            var heig=$('#nav_tab').height();
            if (heig >= 600) {
                $('#nav_tab').removeClass('fixed');
                $('#nav_tab').addClass('fixed1');
            } else {
                $('#nav_tab').removeClass('fixed1');
                $('#nav_tab').addClass('fixed');
            }
        })
        //.........................................................................
        $(window).resize(function() {
            // resizeFrame(document.getElementById('childframe'));
        });

        //.........................................................................
        /*
         $('#tweets').tweetable({
         username: '<?php echo $tiwt;?>',
     time: true,
     rotate: true,
     speed: 4000,
     limit: 5,
     replies: false,
     position: 'append',
     failed: "Sorry, twitter is currently unavailable for this user.",
     html5: true,
     onComplete:function($ul){
     $('time').timeago();
     }
     });
     */
        //.........................................................................

        /*$.simpleWeather({
            zipcode: '<?php echo $zip_weather;?>',
            unit: 'f',
            success: function(weather)
            {
                html  =  '<h3 class="widget_weth"><img src="<?php /*echo Yii::app()->request->baseUrl;*/ ?>/images/icons/paragraph_justify.png" class="p_ic"> <span class="deld_wid dis_wd" id="delet_weth" onclick="delete_weigt(\'delete_weather\')"></span><span class="cutz sub_titles" alt="Weather"><?php echo Controller::customize_label_welcome('Weather');?></span><span id="wiget_url" onClick="widget_url()"></span></h3>';
                html += '<h4 style="color:#000;margin-left:10px;">'+weather.city+', '+weather.region+'</h4>';
                html += '<img style="float:left" width="125px " src="'+weather.image+'">';
                html += '<p style="margin-top:0px;">'+weather.temp+'&deg; '+weather.units.temp+'<br /><span>'+weather.currently+'</span></p>';
                html += '<a href="'+weather.link+'" target="_blank">View Forecast &raquo;</a>';
                $("#utopia-dashboard-weather").css({ marginBottom:'20px'}).html(html);
            },
            error: function(error)
            {
                $("#utopia-dashboard-weather").html('<p>'+error+'</p>');
            }
        });*/
        //.........................................................................
        $( "#column1" ).sortable({ revert: true });
        ////$( "#column2" ).sortable({ revert: true });
        //.........................................................................
        $("#column1").sortable({ opacity: 0.6, cursor: 'move', update: function()
        {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
            $('#loading').show();
            $.post("<?php echo Yii::app()->createAbsoluteUrl("host/updatepanel"); ?>", order, function(theResponse){
                $('#loading').hide();
            });
        }});
        //.........................................................................

        /*$("#column2").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=update_right_RecordsListings';
            $('#loading').show();
            $.post("<?php echo Yii::app()->createAbsoluteUrl("host/updatepanel"); ?>", order, function(theResponse){
                $('#loading').hide();
            });
        }});*/
        //.........................................................................
        $( "#utopia-dashboard-datepicker" ).datepicker().css({ marginBottom:'20px' });


    });

}

function displaytrimzero($disptablerow)
{
    var disptablerowlen = $disptablerow.length;
    $disptablerow.find("td").each(function(){
        tdhtml = $(this).html();
        tdtxt = $(this).text().trim();
        newtdtxt = tdtxt.replace(/^0+/,"");
        tdtxt = "/\\"+tdtxt+"\\b/";
        tdhtml = tdhtml.replace(tdtxt, newtdtxt);

        divlen = $(this).find("div").length;
        if(divlen == 0)
            $(this).text(newtdtxt);
        else
            $(this).find("div:last").html(newtdtxt);
    });
}


function call_systems(){
    $.cookie("show_systems_dashboard", "show_systems_dashboard");
}
$('#out_put').click(function(){

if($('.sidebar-toggle').hasClass('user-active-bars'))
        {
            $('.sidebar-toggle').removeClass('user-active-bars');
            $('#nav_tab').hide();
        }
});
function htop(num)
{
count=parseInt($('#noh').html());

if (num=='1' && count!=1)
    $('#noh').html(count-1);
else if (num=='2' && count!=10)
    $('#noh').html(count+1);
else
        var noHeaderNot =  '<?=Controller::customize_label(_NOHEADERNOT);?>';
        var message =  '<?=Controller::customize_label(_MESSAGE);?>';
        jAlert(noHeaderNot, message);
}
</script>