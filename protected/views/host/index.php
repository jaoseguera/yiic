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
/* @var $this HostController */
/* @var $model HostForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Host';
$userid     = Yii::app()->user->getState("user_id");
$companyid  = Yii::app()->user->getState("company_id");
$user_host  = Yii::app()->user->getState("user_host");

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
// Get client script
$cs = Yii::app()->clientScript;

// Add CSS
// $cs->registerCSSFile('/css/file.css');
?>
<style>
    @media all  and (max-width: 1024px)
    {
        [class*="span"],
        .row-fluid [class*="span"]
        {
            display: block;
            float: none;
            width: auto;
            margin-left: 0;
        }
        #nav_tab
        {
            position:absolute;
        }
    }
    .exten_bobj
    {
        display:none;
    }
    .ui-state-highlight {
        color: #CECECE;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 4px 4px 4px 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
        margin-bottom: 20px;
        min-height: 20px;
        padding: 10px;
        opacity: 1;
    }
    .level-1 ul.active {
        display: block !important;
    }

</style>
<?php
/* @var $this DashBoardController */
/* @var $model DashBoardForm */
/* @var $form CActiveForm  */

////$this->pageTitle=Yii::app()->name . ' - Host';
if(Yii::app()->user->hasState("extended"))
{
    $extended = Yii::app()->user->getState('extended');
    // $rfc = Yii::app()->user->setState('rfc');
}
else { $extended = ""; }

$value  = "";

// Include Jquery for this page
////$cs = Yii::app()->clientScript;

$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page

?>

    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/colortip-1.0-jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.contextmenu.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/dashboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/FixedHeader.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/table.dragtable.js"></script>
    

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
////$this->renderPartial('lookup');
?>
<div id="backgroundPopup"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.feedBackBox.js"></script>
<script>
    if($.cookie("css")) {
        $('link[href*="../utopia-white.css"]').attr("href",$.cookie("css"));
        $('link[href*="../utopia-dark.css"]').attr("href",$.cookie("css"));
    }
    $(document).ready(function()
    {
 /*
         var width = $(window).width();
         $.ajax({
         url: '<?php echo Yii::app()->createAbsoluteUrl("host/"); ?>',
     type: 'post',
     data: { 'width' : width, 'recordSize' : 'true' },
     success: function() {}
     });
     */

        $(".theme-changer a").on('click', function() {
            $('link[href*="../utopia-white.css"]').attr("href",$(this).attr('rel'));
            $('link[href*="../utopia-dark.css"]').attr("href",$(this).attr('rel'));
            $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
            $('.user-info').removeClass('user-active');
            $('.user-dropbox').hide();
        });
    });
</script><?php
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'success') {
        ?><script>
            $(document).ready(function()
            {
                $('#subscrib').trigger('click');
                jAlert('<b style="color:green;">Your Payment is Successfully done. Thank you</b>', 'Message');
            });
        </script><?php
    } else {
        ?><script>
            $(document).ready(function() {
                jAlert('<b style="color:red;">Your Payment has been Canceled.</b>', 'Message');
            });
        </script><?php
    }
}
if (Yii::app()->user->getState("success")) {
    if (Yii::app()->user->getState("success") == 1) {
        ?><script>
            $(document).ready(function() {
                jAlert('<b style="color:green;">New SAP Systems are Added</b>', 'Message');
            });
        </script><?php
    }
    if (Yii::app()->user->getState("success") == 2) {
        ?><script>
            $(document).ready(function()
            {
                jAlert('<b style="color:red;">Invalid file format</b>', 'Message');
            });
        </script><?php
    }
    if (Yii::app()->user->getState("success") == 9) {
        ?><script>
            $(document).ready(function()
            {
                $('.paypal').show();
                $("#backgroundPopup").css("opacity", "0.7");
                $("#backgroundPopup").fadeIn(0001);
            })
        </script><?php
    }
    if (Yii::app()->user->getState("success") == 404) {
        ?><script>
            $(document).ready(function()
            {
                jAlert('<b style="color:red;">Invalid file or exception occurred. Please contact helpdesk</b>', 'Message');
            })
        </script><?php
    }
    if (Yii::app()->user->getState("all") == 5) {
        ?><script>
            $(document).ready(function() {
                jAlert('<b style="color:red;"><?php echo Yii::app()->user->getState("allre"); ?>', 'Message');
            });
        </script><?php
    }
    Yii::app()->user->setState("success", "0");
    Yii::app()->user->setState("all", "0");
}
//if(!isset($_SESSION['rfc']))
if (!Yii::app()->user->hasState("rfc")) {
    ?><script>
        $(document).ready(function() {
            $.cookie('prev_host','');
        });
    </script><?php
}
?>
    <script>
    $(document).ready(function() {
        if($.cookie("show_systems_dashboard")=='show_systems_dashboard'){
            shows('avl_sys');
        }
        $.cookie("show_systems_dashboard", "");
     });
    //................................................................................................................
    function shows(type,call_from)
    {

        $("#company").hide();
        if(type=='add_sys')
        {
            //$('#sys_types option[value=""]').attr('selected', 'selected');
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("host/hostcount"); ?>",
                success: function(datas) {
                    if(datas>6)
                    {
                        $('.paypal').show();
                        $("#backgroundPopup").css("opacity", "0.7");
                        $("#backgroundPopup").fadeIn(0001);
                        return false;
                    }
                    else
                    {

                        var help_fol = "";
                        if(navigator.userAgent.match(/iPad/i))
                            help_fol = "ipad/ipad_";
                        else if(navigator.userAgent.match(/iPhone/i))
                            help_fol = "iphone/iphone_";



                        $('.help_thin').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+help_fol+'host.jpg');
                        //$('#'+type+'_nav').css({ color:'#0088CC' });
                        //$('#add_sys_nav').css({ color:'#000' });
                        $('#sys_types option[value=""]').prop('selected', true);
                        $('.sys_t').hide();
                        $('#add_sys').show();
                        $('#avl_sys').hide();
                        $('#sap_sys').hide();
                        $('#prof').hide();
                        $('.edit_sys').hide();
                        $('#welcome_wiget').hide();
                        $('.sap_null').css({ display:'none' })


                    }
                }
            });
        }

        if(type=='avl_sys')
        {

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("host/hostcount"); ?>",
                success: function(datas) {
                    if(datas>6)
                    {
                        $('#sub_files').attr('alt',6);
                    }
                    else
                    {
                        $('#sub_files').attr('alt',0);
                    }


                    var help_fol = "";
                    if(navigator.userAgent.match(/iPad/i))
                        help_fol = "ipad/ipad_";
                    else if(navigator.userAgent.match(/iPhone/i))
                        help_fol = "iphone/iphone_";

                    //$('.help_thin').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+help_fol+'host.jpg');
                    //$('#'+type+'_nav').css({ color:'#0088CC' });
                    //$('#add_sys_nav').css({ color:'#000' });

                    if(!$('#sap_systems').closest("li").hasClass('active')){
                           $('#sap_dit').trigger('click');
                    }

                    if(!$('#'+type+'_nav').closest("li").hasClass('active')){
                        $('#'+type+'_nav').closest("li").addClass('active');
                    }
                    $('#add_sys_nav').closest("li").removeClass('active');
                    $('#avl_sys').show();
                    $('#add_sys').hide();
                    $('#prof').hide();
                    $('.edit_sys').hide();
                    $('#welcome_wiget').hide();
                    $('.sap_null').css({ display:'none' })
                }
            });

        }
        
        return false;
        
        
    }
    //................................................................................................................

    //................................................................................................................
    function delt(id,ids)
    {
        var can="";
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            done(id,ids,r)
            return false;
        });
    }
    //................................................................................................................
    function delt_bi(id)
    {
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            done_bi(id,r)
            return false;
        });
    }
    //................................................................................................................
    function done(id,ids,r)
    {
        if(r)
        {
            var stringval = 'id='+id;
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("host/remove"); ?>',
                data: stringval,
                success: function(html) {
                    //GEZG 07/26/2018
                    //Showing message to inform if either SAP system was deleted or not
                    if(response.trim() == ""){
                        var systemDescription = $('#'+id).find(".sys_text").html();
                        $('#'+id).hide('slow');
                        $('#'+id+'_del').hide('slow');
                        $('#'+id).remove();
                        $('#'+id+'_del').remove();    
                        jAlert("System "+systemDescription+" deleted successfully");
                    }else{
                        jAlert(response);
                    }

                }
            });
        }
    }
    //................................................................................................................
    function done_bi(id,r)
    {
        if(r)
        {
            var strval = 'type=bi_id&id='+id;
            $.ajax({
                type:'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("host/remove"); ?>',
                data:strval,
                success: function(html) {
                    $('#'+id+'_del').hide('slow');
                }
            });
        }
    }
    //................................................................................................................
    function edit(id,ids)
    {
        $('#avl_sys').hide();
        $('#sap_sys').show();
        $('#prof').hide();
        $('#'+id+'_edit').show();
    }
    //................................................................................................................
    function edit_bi(id)
    {
        $('#avl_sys').hide();
        $('#bi_avl').hide();
        $('#bi_sys').show();
        $('#prof').hide();
        $('#'+id+'_edit_bi').show();
    }
    //................................................................................................................
    function edit_cancel(id,ids)
    {
        $('#avl_sys').show();
        $('#'+id+'_edit').hide();
    }
    //................................................................................................................
    function edit_cancel_bi(id)
    {
        $('#li_bi_avl').trigger('click');
        // $('#'+id+'_edit_bi').hide();
    }
    //................................................................................................................
    function ajax_edit(id,ids)
    {
        var routing_string=$('#Router_String'+ids).val();
        var con_type=$('#Connection_type'+ids).val();
        if(routing_string!="")
        {
            /*var leng=routing_string.length;
             var s = routing_string.charAt(routing_string.length-leng);
             var n = routing_string.charAt(routing_string.length-1);
             if(s!='/'&&n!='/')
             {
             $('#Router_String'+ids).css({border:'1px solid red'});
             jAlert('<p style="color:red;">Invalid SAProuter String</p>', 'Message');
             return false;
             }
             */
        }
        //console.log($('#Extension'+ids).is(':checked'));
        if(!$('#Extension'+ids).is(':checked'))
        {

            var description=$('#Description'+ids).val();
            var host=$('#Host'+ids).val();
            var routing_string=$('#Router_String'+ids).val();
            var router_Port=$('#Router_Port'+ids).val();
            var sys_num=$('#System_Number'+ids).val();
            var sys_id=$('#System_ID'+ids).val();
            var messageserver=$('#Messageserver'+ids).val();
            var group=$('#Group'+ids).val();
            var lang=$('#Language'+ids).val();
            var extension=$('#Extension'+ids).val();
            var bapiversion     =$('#Bapiversion'+ids).val();

            var extension='off';

            if(con_type=='Group')
            {
                var strval = 'description='+description+'&sys_id='+sys_id+'&messageserver='+messageserver+'&group='+group+'&lang='+lang+'&extension='+ extension+'&id='+id+'&ids='+ids+'&con_type='+con_type+'&bapiversion='+bapiversion;
            }
            else
            {
                var strval = 'description='+description+'&host='+host+'&routing_string='+routing_string+'&router_Port='+router_Port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&lang='+lang+'&extension='+ extension+'&id='+id+'&ids='+ids+'&con_type='+con_type+'&bapiversion='+bapiversion;
            }
            $.ajax({
                type:'POST',
                url: '<?php echo Yii::app()->createAbsoluteUrl("host/edit"); ?>',
                data:strval,
                success: function(vals) {

                    $('#'+id+'_edit').hide();
                    $('#avl_sys').show();
                    $('#'+id+'_del').html(vals);
                    $('#'+id+'_del').addClass("suss").delay(1500).queue(function(next){
                        $(this).removeClass("suss");
                        next();
                    });
                }
            });
        }
        else
        {
            jPrompt('', '', 'SAP Login Details', function(r)
            {
                if( r )
                {
                    var para = r.split(',');
                    $('#ahide'+ids).html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader2.gif'>");
                    var description=$('#Description'+ids).val();
                    var host=$('#Host'+ids).val();
                    var routing_string=$('#Router_String'+ids).val();
                    var router_Port=$('#Router_Port'+ids).val();
                    var sys_num=$('#System_Number'+ids).val();
                    var sys_id=$('#System_ID'+ids).val();
                    var messageserver=$('#Messageserver'+ids).val();
                    var group=$('#Group'+ids).val();
                    var client=para[0];
                    var user_name=para[1];
                    var pswd=para[2];
                    var lang=$('#Language'+ids).val();
                    var extension=$('#Extension'+ids).val();
                    var bapiversion=$('#Bapiversion'+ids).val();
//alert($('#Extension'+ids).is(':checked'));
                    if($('#Extension'+ids).is(':checked'))
                    {
                        var extension='on';
                    }
                    else
                    {
                        var extension='off';
                    }
                    //  alert(extension);
                    //..............................................................

                    //........................................................
                    if(con_type=='Group')
                    {
                        var dataString='messageserver='+messageserver+'&group='+group+'&sys_id='+sys_id+'&client='+client+'&user_name='+user_name+'&pswd='+pswd+'&lang='+lang+'&extension='+extension+'&con_type=grp&bapiversion='+bapiversion;
                    }
                    else
                    {
                        var dataString='host='+host+'&routing_string='+routing_string+'&router_Port='+router_Port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&client='+client+'&user_name='+user_name+'&pswd='+pswd+'&lang='+lang+'&extension='+extension+'&con_type=cust&bapiversion='+bapiversion;
                    }
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Yii::app()->createAbsoluteUrl("host/extension"); ?>",
                        data: dataString,
                        success: function(data) {
                            $('#ahide'+ids).html("Save Change");
                            var str=data.split("@");

                            if(str[1]=='SAPin Extended Version Validation Successful')
                            {
                                document.getElementById('Extension'+ids).checked = 'checked';
                                var extension = document.getElementById('Extension'+ids).value = 'on';
                                var exten = '';
                            }
                            else
                            {
                                document.getElementById('Extension'+ids).checked='';
                                document.getElementById('Extension'+ids).value='off';
                                var exten='Extended features are not available in this system';
                                $('#Extension'+ids).val('off');
                                jAlert('<p style="color:red;">Extended features are not available in this system</p>', 'Message');
                            }
                            if(str[0]=='done')
                            {
                                if(con_type=='Group')
                                {
                                    var strval = 'description='+description+'&messageserver='+messageserver+'&group='+group+'&sys_id='+sys_id+'&lang='+lang+'&extension='+ extension+'&id='+id+'&ids='+ids+'&con_type=Group&bapiversion='+bapiversion;
                                }
                                else
                                {
                                    var strval = 'description='+description+'&host='+host+'&routing_string='+routing_string+'&router_Port='+router_Port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&lang='+lang+'&extension='+ extension+'&id='+id+'&ids='+ids+'&con_type=Single&bapiversion='+bapiversion;
                                }
                                
                                $.ajax({
                                    type:'POST',
                                    url: '<?php echo Yii::app()->createAbsoluteUrl("host/edit"); ?>',
                                    data:strval,
                                    success: function(vals) {
                                        $('#'+id+'_edit').hide();
                                        $('#avl_sys').show();
                                        $('#'+id+'_del').html(vals);
                                        $('#'+id+'_del').addClass("suss").delay(1500).queue(function(next){
                                            $(this).removeClass("suss");
                                            next();
                                        });
                                    }
                                });
                            }
                            else
                            {
                                jAlert('<p style="color:red;">'+str[0]+"</p>", 'Message');
                            }
                            $('#ahide').show();
                            $('#bhide').hide();

                        }

                    });
                }
            });
        }
    }

    //................................................................................................................
    function randomBetween(min, max)
    {
        if (min < 0)
            return min + Math.random() * (Math.abs(min)+max);
        else
            return min + Math.random() * max;
    }
    //................................................................................................................
    function systems(values,id,host_ids)
    {
        var hst=values.split(',');
        if($.cookie('prev_host')==hst[1]+'/'+hst[3]+'/'+hst[4])
        {
            $('#'+id+'_inv').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
            var para=$.cookie('prev_pass').split(',');
            var host_val=values.split(',');
            var total_val=host_val[0]+","+host_val[1]+","+host_val[2]+","+host_val[3]+","+host_val[4]+","+host_val[5]+","+para[0]+","+para[1]+","+host_val[6]+","+host_val[7]+","+host_val[8];
            var dataStrings =total_val+"&paz="+para[2];
            sessionStorage.setItem('tab_sap_login', dataStrings);
            localStorage.setItem('tab_sap_login', dataStrings);

            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createAbsoluteUrl("host/hostcheck"); ?>",
                data: dataStrings,
                success: function(datas) {
                    if(datas=='dashboard')
                    {
                        sessionStorage.setItem('prev_seesid', $.cookie('PHPSESSID'));
                        localStorage.setItem('prev_seesid', $.cookie('PHPSESSID'));
                        window.location.replace(datas);
                    }
                    else
                    {
                        sessionStorage.removeItem("tab_sap_login");
                        localStorage.removeItem("tab_sap_login");
                        $('#'+id+'_del').css({ border:'1px solid red' });
                        $('#'+id+'_inv').html(datas);
                        $('#'+id+'_inv').css({ color:'red', 'font-size':'10px'});
                    }
                }
            })
            return false;
        }

        jPrompt('', host_ids, ' SAP System details', function(r) {
            if( r )
            {
                $.cookie('host_ids',host_ids)
                var para=r.split(',');
                var host_val=values.split(',');
                var total_val=host_val[0]+","+host_val[1]+","+host_val[2]+","+host_val[3]+","+host_val[4]+","+host_val[5]+","+para[0]+","+para[1]+","+host_val[6]+","+host_val[7]+","+host_val[8];
                $('#'+id+'_inv').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                var dataString =total_val+"&paz="+para[2];
                sessionStorage.setItem('tab_sap_login', dataString);
                localStorage.setItem('tab_sap_login', dataString);

                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createAbsoluteUrl("host/hostcheck"); ?>",
                    data: dataString,
                    success: function(html) {
                        if(html=='dashboard')
                        {
                            tab_sesid = Math.floor(randomBetween(000000, 999999));
                            // console.log(tab_sesid);
                            sessionStorage.setItem('SESSION', tab_sesid);

                            sessionStorage.setItem('prev_seesid', $.cookie('PHPSESSID'));
                            localStorage.setItem('prev_seesid', $.cookie('PHPSESSID'));
                            $.cookie('prev_pass',r);
                            $.cookie('prev_host',hst[1]+'/'+hst[3]+'/'+hst[4]);
                            window.location.replace("<?php echo Yii::app()->createAbsoluteUrl("dashboard/"); ?>");

                        }
                        else
                        {
                            sessionStorage.removeItem("tab_sap_login");
                            localStorage.removeItem("tab_sap_login");
                            $('#'+id+'_del').css({ border:'1px solid red' });
                            $('#'+id+'_inv').html('There was an error connecting to your SAP System. Please check your Systems Settings, Client, Username and Password or contact us.');
                            $('#'+id+'_inv').css({ color:'red', 'font-size':'12px','font-weight':'normal'});
                        }
                    }
                })
            }
        });

        var popupHeight = $("#popup_container").height();
        var viewportHeight = $(window).height();
        var popupTop = (viewportHeight-popupHeight)/2;
        $("#popup_container").css({top: popupTop});
        //alert(popupTop+" "+popupHeight+" "+viewportHeight);
    }
    //................................................................................................................
    function sap_count()
    {
        var alts=$('#sub_files').attr('alt');
        if(alts==6)
        {
            $('.paypal').show();
            $("#backgroundPopup").css("opacity", "0.7");
            $("#backgroundPopup").fadeIn(0001);
            return false;
        }
        else
        {
            return true;
        }
    }
    //................................................................................................................
    function exten_bi()
    {
        var des=$('#bi_description').val();
        var system_url=$('#bi_system_url').val();
        var cms_name=$('#cms_name').val();
        var cms_port=$('#cms_port').val();
        var auth_type=$('#auth_type').val();
        if($('#extented_bobj').is(':checked'))
        {
            jPrompt_bi('', '', 'BOBJ System details', function(r) {
                if( r )
                {
                    $('#ahide_bi').hide();
                    $('#bhide_bi').show();
                    $('#bhide_bi').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                    $('#bhide_bi').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                    var values=r.split(',');
                    var datas=datastring='../lib/controller.php?page=soap_check&name='+values[0]+'&pass='+values[1]+'&des='+des+'&url='+system_url+'&cms_name='+cms_name+'&cms_port='+cms_port+'&auth_type='+auth_type;
                    $.ajax({
                        url: datas,
                        success: function(data)
                        {
                            if(data=='done')
                            {
                                var datastring='../lib/bi_xml.php?description='+des+'&system_url='+system_url+'&cms_name='+cms_name+'&cms_port='+cms_port+'&auth_type='+auth_type+'&bobj_extension=on';
                                $.ajax({
                                    url: datastring,
                                    success: function(data) {
                                        $('#ahide_bi').show();
                                        $('#bhide_bi').hide();
                                        $('#ahide_bi').html("Save changes");

                                        if(data=='NOSYSTEM')
                                        {
                                            jAlert('<b style="color:red;">This system is already exist</b>', 'Message');
                                            return false
                                        }
                                        if(data=='URL_NOT_WORKING')
                                        {
                                            jAlert('<b style="color:red;">Invalid URL.</b>', 'Message');
                                            return false
                                        }
                                        var sy=data.split('@');
                                        $('#sap_sys').html(sy[1]);
                                        $('#getthis').html(sy[0]);
                                        $('.emt').val('');
                                        $('#avl_sys_nav').trigger('click');
                                    }
                                });
                            }
                            else
                            {
                                $('#ahide_bi').show();
                                $('#bhide_bi').hide();
                                $('#ahide_bi').html("Save changes");
                                jAlert('<b style="color:red;">SSO setup not completed please contact help desk.</b>', 'Message');
                                return false
                            }
                        }
                    });
                } });
        }
        else
        {
            $('#ahide_bi').hide();
            $('#bhide_bi').show();
            $('#bhide_bi').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
            var datastring='../lib/bi_xml.php?description='+des+'&system_url='+system_url+'&bobj_extension=off';

            $.ajax({
                url: datastring,
                success: function(data) {
                    $('#ahide_bi').show();
                    $('#bhide_bi').hide();
                    $('#ahide_bi').html("Save changes");

                    if(data=='NOSYSTEM')
                    {
                        jAlert('<b style="color:red;">This system is already exist</b>', 'Message');
                        return false
                    }
                    if(data=='URL_NOT_WORKING')
                    {
                        jAlert('<b style="color:red;">Invalid URL.</b>', 'Message');
                        return false
                    }
                    var sy=data.split('@');
                    $('#sap_sys').html(sy[1]);
                    $('#getthis').html(sy[0]);
                    $('.emt').val('');
                    $('#avl_sys_nav').trigger('click');
                }
            });
        }
    }
    //................................................................................................................
    function ajax_edit_bi(ids,id)
    {
        $('#ahide'+id).hide();
        $('#bhide'+id).show();
        $('#bhide'+id).html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
        $('#bhide'+id).html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
        var des=$('#Description'+id).val();
        var system_url=$('#System_URL'+id).val();
        if($('#Extension'+id).is(':checked'))
        {
            var cms_name=$('#CMS_Name'+id).val();
            var cms_port=$('#CMS_Port'+id).val();
            var auth_type=$('#Auth_Type'+id).val();
            var status='on';
        }
        else
        {
            var cms_name="";
            var cms_port="";
            var auth_type="";
            var status='off';
        }

        if($('#Extension'+id).is(':checked'))
        {
            jPrompt_bi('', '', 'BOBJ System details', function(r) {
                if( r )
                {
                    $('#ahide'+id).hide();
                    $('#bhide'+id).show();
                    $('#bhide'+id).html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                    $('#bhide'+id).html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                    var values=r.split(',');
                    var datas=datastring='../lib/controller.php?page=soap_check&name='+values[0]+'&pass='+values[1]+'&des='+des+'&url='+system_url+'&cms_name='+cms_name+'&cms_port='+cms_port+'&auth_type='+auth_type;

                    $.ajax({
                        url: datas,
                        success: function(data) {

                            if(data=='done')
                            {
                                $.ajax({
                                    url: '../lib/edit.php?bi_rep='+ids+'&description='+des+'&system_url='+system_url+'&cms_name='+cms_name+'&cms_port='+cms_port+'&auth_type='+auth_type+'&id='+id+'&bobj_extension='+status,
                                    success: function(data) {
                                        $('#ahide'+id).show();
                                        $('#bhide'+id).hide();
                                        $('#ahide'+id).html("Save changes");
                                        if(data=='URL_NOT_WORKING')
                                        {
                                            jAlert('<b style="color:red;">Invalid URL.</b>', 'Message');
                                        }
                                        else
                                        {
                                            $('#'+ids+'_edit').hide();
                                            $('#avl_sys').show();
                                            $('#'+ids+'_del').html(data);
                                            $('#'+ids+'_del').addClass("suss").delay(1500).queue(function(next){
                                                $(this).removeClass("suss");
                                                next();
                                            });
                                        }
                                    }
                                });
                            }
                            else
                            {
                                $('#ahide'+id).show();
                                $('#bhide'+id).hide();
                                $('#ahide'+id).html("Save changes");
                                jAlert('<b style="color:red;">SSO setup not completed please contact help desk.</b>', 'Message');
                                return false
                            }
                        } });
                } });
        }
        else
        {
            $.ajax({
                url: '../lib/edit.php?bi_rep='+ids+'&description='+des+'&system_url='+system_url+'&cms_name='+cms_name+'&cms_port='+cms_port+'&auth_type='+auth_type+'&id='+id+'&bobj_extension='+status,
                success: function(data) {
                    $('#ahide'+id).show();
                    $('#bhide'+id).hide();
                    $('#ahide'+id).html("Save changes");
                    if(data=='URL_NOT_WORKING')
                    {
                        jAlert('<b style="color:red;">Invalid URL.</b>', 'Message');
                    }
                    else
                    {
                        $('#'+ids+'_edit').hide();
                        $('#avl_sys').show();
                        $('#'+ids+'_del').html(data);
                        $('#'+ids+'_del').addClass("suss").delay(1500).queue(function(next){
                            $(this).removeClass("suss");
                            next();
                        });
                    }
                }
            });
        }
    }
    //................................................................................................................
    function systems_bi(id,url,ids)
    {
        var vals=url.split(',');
        if($.cookie('prev_host')==vals[1]+','+vals[2]+','+vals[3]+','+vals[4])
        {
            $('#'+id+'_inv').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
            window.location.replace('dashboard.php');
        }
        else
        {
            if(vals[6]=='off')
            {
                $('#'+id+'_inv').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
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
                            $('#'+id+'_inv').css({color:'red','font-size':'12px','font-weight':'normal'}).html("There was an error connecting to your SAP System. Please check your Systems Settings, Client, Username and Password or contact us.");
                        }
                    }
                });
            }
            else
            {
                jPrompt_bi('', ids, 'BOBJ System details', function(r) {
                    if( r )
                    {
                        $('#'+id+'_inv').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
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
                                    $('#'+id+'_inv').css({color:'red','font-size':'12px','font-weight':'normal'}).html("There was an error connecting to your SAP System. Please check your Systems Settings, Client, Username and Password or contact us.");
                                }
                            }
                        });
                    } });
            }
        }
    }
    //................................................................................................................
    function can_bi()
    {
        $('#li_bi_avl').trigger('click');
    }
    //................................................................................................................
    </script>
    <!--<div id="backgroundPopup"></div>-->
    <div id="feedback"></div>
    <input type="hidden" name="BaseURL" id="BaseURL" value="<?php echo Yii::app()->request->baseUrl; ?>" />
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/close-help.png" class="help_close">
   <!-- <img src="php echo Yii::app()->request->baseUrl/images/help/host.jpg" class="help_thin">-->
    <div class="container-fluid">
    <div id="test"></div>
    <!-- Header starts -->
    <div class="row-fluid">
        <div class="span12" id='heder_position'>
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
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/save-icone.png" onclick="save_customize()" class="save_customize body_con b_odd" title='Save Customize' style="margin-left:1px;">
                            <div class="user_list" >
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/edit-icon.png" onclick="customize()" class="edit_customize  b_odd" title='Customize'>
                            </div>
                        </div>
                        <!-- hist---->
                        <div class="header-divider mobile_lite" style="display: none;">
                            <div class="user_list" id='his_u'>
                                <a href="#" tip='History' class='red b_od'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/history.png" alt=""></a>
                            </div>

                            <div class="user-dropbox body_con" id='d_his_u'>
                                <ul id="hist" style="margin:0px;"></ul>
                            </div>
                        </div>
                        <!---- fav
                        <div class="header-divider" id='header-divider'>---->
                        <div class="header-divider" style="display: none;">
                            <div class="user_list" id='favt'>
                                <a href="#" tip='Favorite' class='red b_od'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/favt.png" alt=""></a>
                            </div>
                            <div class="user-dropbox body_con" id='d_favt'></div>
                        </div>
                        <!------------------host------------------------->
                        <?php if($userdoc->profile->roles!='emg_retailer' && $userdoc->profile->roles!='emg_customer_service' && $userdoc->profile->roles!='emg_retailer_service')
                                {
                                ?>
                        <div class="header-divider mobile_lite">
                                
                                <div class="host_list" id='host_list'>
                                <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/system.png" alt="" class='sys_ic'><div class="sys_len">Available Systems</div></a>
                            </div>
                            <div class="d_host_list" id='d_host_list'>
                                <?php   $this->renderPartial('system', array('doc'=>$doc));
                                ?> </div> 
                        </div>    
                        <?php } ?>
                        <!------------------------------------------->
                        <div class="user-panel header-divider">
                            <div class="user-info" id='admin_u'>
                                <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/user.png" alt="" class='usr_ic'><div title="<?php echo Yii::app()->user->getState("admin_user"); ?>"><?php echo Yii::app()->user->getState("admin_user"); ?></div></a>
                            </div>

                            <div class="user-dropbox" id='d_admin_u'>
                                <ul>
                                    <li class="mob_user_det body_con"><strong><a href="#" onclick="return false;" style="color: #025985;margin-left: 0px"><?php echo Yii::app()->user->getState("admin_user"); ?></a></strong></li>
                                    <li class="theme-changer white-theme body_con"><a href="#" onClick='help_t()'>Help</a></li>
                                    <li class="user body_con" ><a href="#" id='profile' onClick="sap_form('profile')">Profile</a></li>
                                    <li class="license body_con"><a target="_blank" href="http://www.emergys.com/solutions/experience/thinui/ancillarysoftware-service/" >License Info</a></li>
                                    <?php if($userdoc->profile->roles!='emg_retailer' && $userdoc->profile->roles!='emg_customer_service' && $userdoc->profile->roles!='emg_retailer_service') { ?>
                                    <li class="settings body_con"><a href="#" id="avilable_systems" onClick="shows('avl_sys')">Systems</a></li>
                                    
                                    <?php } ?>
                                    <li class="logout"><a href="#" onClick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl("login/logout"); ?>'">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- End header right -->
                </div><!-- End header wrapper -->
            </div><!-- End header -->
        </div>
    </div>
    <!-- Header end -->
    <div class="row-fluid" >
    <!-- Sidebar statr -->
    <div class="span2 sidebar-container fixed" id='nav_tab'>
        <?php $this->renderPartial("menu"); ?>
    </div>


    <!-- Sidebar end -->
    <!-- Body Start -->
    <?php
    /* if($user_host)
    { 
    $RMA='';
    }else
    {
    if(isset($userdoc->default_functions) && $userdoc->profile->roles!='emg_retailer' && $userdoc->profile->roles!='emg_customer_service')
        isset($userdoc->default_functions->Returns_Portal)?$RMA=$userdoc->default_functions->Returns_Portal:$RMA='';
    else
        $RMA='';
    } */                        
                            
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
    $display_w    = "Remove";
    $display_d    = "Remove";
    $display_f    = "Remove";
    $display_m    = "Remove";
    $display_t    = "Remove";
    $display_w_db = "Remove";
    $display_d_db = "Remove";
    $display_f_db = "Remove";
    $display_m_db = "Remove";
    $display_t_db = "Remove";
    $opps_w       = 'none_wegid';
    $opps_d       = 'none_wegid';
    $opps_f       = 'none_wegid';
    $opps_m       = 'none_wegid';
    $opps_t       = 'none_wegid';


    if(isset($userdoc->welcome_urls->delete_weather))
    {
        $display_w_db=$userdoc->welcome_urls->delete_weather;
        if($display_w_db=='Add')
        {
            $display_w='none_wegid';
            $opps_w="";
        }
    }
    if(isset($userdoc->welcome_urls->delete_date))
    {
        $display_d_db=$userdoc->welcome_urls->delete_date;
        if($display_d_db=='Add')
        {
            $display_d='none_wegid';
            $opps_d="";
        }
    }
    if(isset($userdoc->welcome_urls->delete_feed))
    {
        $display_f_db=$userdoc->welcome_urls->delete_feed;
        if($display_f_db=='Add')
        {
            $display_f='none_wegid';
            $opps_f="";
        }
    }
    if(isset($userdoc->welcome_urls->delete_twit))
    {
        $display_t_db=$userdoc->welcome_urls->delete_twit;
        if($display_t_db=='Add')
        {
            $display_t='none_wegid';
            $opps_t="";
        }
    }
    if(isset($userdoc->welcome_urls->delete_msg))
    {
        $display_m_db=$userdoc->welcome_urls->delete_msg;
        if($display_m_db=='Add')
        {
            $display_m='none_wegid';
            $opps_m="";
        }
    }
    ?>


    <div class="body-container body_con" id='body_position'>
    <div class="span12" style="display:none;margin:0px;" id="company">
        <section class="utopia-widget" style="margin:0px;">
            <div class="utopia-widget-title">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
                <span><div id='head_tittle' class='cutz' alt='Welcome'></div></span>
            </div>
            <div class="utopia-widget-content" id='out_put_form'></div>
        </section>
    </div>
    <div class="span12" style="display:none;margin:0px;" id="prof" >
        <section class="utopia-widget" style="margin:0px;">
            <div class="utopia-widget-title">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
                <span id='title_host'>Profile</span>
            </div>
            <div class="utopia-widget-content" id='out_put_prof'></div>
        </section>
    </div>


    <?php
    if($user_host)
    {
        $user_id    = Yii::app()->user->getState("user_id");
        $user       = Controller::userDbconnection();
        $hostdoc    = $user->getDoc($user_id);
    }
    else
        $hostdoc = $doc;

    if(isset($hostdoc->host_position))
    {
        $center_position_host   = json_encode($hostdoc->host_position);
        $center_position_hosts  = json_decode($center_position_host, true);
    }
    else
    {
        $host   = json_encode($hostdoc->host_id);
        $hosts  = json_decode($host, true);

        foreach($hosts as $keys => $values)
            $center_position_hosts[] = $keys;

    }

    $host   = json_encode($hostdoc->host_id);
    $hosts  = json_decode($host, true);
    $count  = count($hosts);
    ?>

    <div class="span12" id="avl_sys" style="margin:0px;display:none;">
        <section class="utopia-widget" style="min-height:480px;">
            <div class="utopia-widget-title">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
                <span>Available SAP Systems</span>
            </div>
            <div class="utopia-widget-content">
                <div class="row-fluid">
                    <div class="span5">
                        <section>
                            <div class="utopia-widget-content">
                                <div id='getthis'>
                                    <?php
                                    // $this->renderPartial('avilablesystems', array('doc'=>$hostdoc, 'companyid'=>$companyid, 'center_positions'=>$center_positions, 'hosts'=>$hosts, 'count'=>$count));
                                    $this->renderPartial('avilablesystems', array('doc'=>$hostdoc, 'companyid'=>$companyid, 'center_positions'=>$center_position_hosts, 'hosts'=>$hosts, 'count'=>$count));
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <!-------------------------------------------------------edit systems------------------------------------------------->
    <div class="span12" style="margin:0px;display:none;" id='sap_sys'>
        <?php $this->renderPartial('editsystems', array('model'=>$model, 'hosts'=>$hosts, 'count'=>$count)); ?>
    </div>
    <!-------------------------------------------------------add new systems---------------------------------------------->
    <div class="span12" style="display:none; margin:0px;" id="add_sys">
        <section class="utopia-widget" style="margin:0px;">
            <div class="utopia-widget-title">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
                <span>Add New SAP System</span>
            </div>

            <div class="utopia-widget-content">
                <div class="row-fluid">
                    <div class="span6">
                        <section>
                            <div class="utopia-widget-content">
                                <div id='getthis'>
                                    <?php

                                    $this->renderPartial('addsystems', array('model'=>$model));
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class='span6' id="import_syatems">
                        <div name="helloword_hulk_options"></div>
                        <h3 style="border-bottom:1px solid #cecece;">Import Your SAP Systems</h3>
                        <div class="utopia-widget-content" style="float:right;padding:3px;">
                            <form action="<?php echo Yii::app()->createAbsoluteUrl("host/importhost"); ?>" method="post" enctype="multipart/form-data" id='sap_host' onsubmit="return sap_count()">
                                <table border='0'>
                                    <tr>
                                        <td><input type="file" name="file" id='files' class="validate[required]"/></td>
                                        <td><input type="submit" value="<?php echo _SUBMIT ?>" class='btn' id='sub_files'/></td>
                                    </tr>
                                </table>
                            </form>
                            <div class='well'>
                                <p style='text-align:justify;'>You may import your existing saplogon.ini file to expedite your account setup.  This can only be completed through the desktop interface.  After you click choose file, browse to your saplogin.ini file and click Submit to complete the import process.  Please note if you are using the free version of ThinUI we will only import your first five systems.</p>
                                <p style='text-align:justify;'>For reference, the saplogon.ini file is typically located in one of the following directories but can vary by your version of Windows and your Corporate IT strategy.  If you are having problems locating your saplogon.ini file please contact your IT support center.</p>
                                <p>
                                    Windows XP or earlier: c:\windows</br>
                                    Windows Vista: C:\Users\username\AppData\Local\VirtualStore\Program Files\SAP\FrontEnd\SAPgui</br>
                                    Windows 7/8: C:\Users\username\AppData\Roaming\SAP\Common
                                </p>
                                <p style='color:red;'>* Please replace "username" with your Windows username.</p>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </section>
    </div>
    <div class="row-fluid">
    <!--Chart Icons -->
    <div class="span9" id="welcome_wiget" >
        <div class="span12 widgg dis_wd" id='wigg_left'>
            <div style='font-size:46px;font-weight:bold;'>+</div>
            <div><h3 style='font-size:20px;font-weight:bold;'>Add Widget</h3></div>
        </div>
        <ul id="column1"><?php
            foreach($center_positions as $pval => $divval)
            {
//Item removed on 25092015 
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
                                        <span><div id='head_tittle' class='cutz' alt='Welcome'><?=Controller::customize_label_welcome('Welcome');?></div></span>
                                        <div id="fav" title='Favorite list' class="fav"></div>
                                        <span><div id="back_to" style="display:none;"></div></span>
                                        <div id="fav_list">
                                            <table class='desx'><tr><td colspan='2' style="text-align:center;"><h3>Add to Favorite list</h3></td></tr><tr>
                                                    <td style="font-size:11px;width:60px;">
                                                        Description :</td><td><input type='text' name='box' class="span11" id='fav_inp'/>
                                                    </td></tr>
                                            </table>
                                            <div style="float:right;width:150px;" id="uit">
                                                <div id='removes' style="display:none">
                                                    <button class='btn span4' id='remove'>Remove</button><button class='btn span3 done' >Edit</button><button class='btn span3 fav_c' >Cancel</button></div>
                                                <div id='dones' style="display:none"><button class='btn span5 done' >Done</button><button class='btn span5 fav_c' >Cancel</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="utopia-widget-content"><?php
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
                                        <div id="out_put">
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

    <div class="span3 sap_null my_wid">
        <div class="row-fluid">
            <div class="span12 widgg dis_wd" id='wigg_right'>
                <div style='font-size:46px;font-weight:bold;'>+</div>
                <div ><h3 style='font-size:20px;font-weight:bold;'>Add Widget</h3></div>
            </div>
            <ul id="column2"><?php
                foreach($right_positions as $p_val=>$div_right_val)
                {
                    if($div_right_val == "position_1")
                    {
                        ?><li class="span12 delete_weather <?php echo $display_w;?>" id="<?php echo $div_right_val ?>">
                            <div class="span12" id='delete_weather' alt='Add Weather Widget'>
                                <div class="none_wegid cls_we" onClick="delete_weigt('delete_weather')"></div>
                                <div id="utopia-dashboard-weather" >

                                </div>
                            </div>
                        </li><?php
                    }
                    if($div_right_val == "position_2")
                    {
                        ?><li class="span12 delete_date <?php echo $display_d;?>" id="<?php echo $div_right_val ?>">
                        <div class="span12" id="delete_date" alt='Add Calender Widget'>
                            <div class="none_wegid cls_ca" onClick="delete_weigt('delete_date')"></div>
                            <div class="calen_widget">
                                <h3 class='sap_msg'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="p_ic">
                                    <span class="deld_wid dis_wd" id='delet_date' onClick="delete_weigt('delete_date')"></span>
                                    <span class='cutz sub_titles' alt='Calendar'><?php echo Controller::customize_label_welcome('Calendar');?></span></h3>
                                <div id="utopia-dashboard-datepicker"></div>
                            </div>
                        </div>
                        </li><?php
                    }
                    if($div_right_val == "position_3")
                    {
                        ?><li class="span12 delete_feed <?php echo $display_f;?>" id="<?php echo $div_right_val ?>">
                        <div class="span12" id="delete_feed" style="margin:0px;" alt='Add News Feeds Widget'>
                            <div class="none_wegid cls_fe" onClick="delete_weigt('delete_feed')"></div>
                            <div class="utopia-chart-legend1">
                                <div class="news" >
                                    <h3><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="p_ic">
                                        <span class="deld_wid dis_wd" id='delet_feed' onClick="delete_weigt('delete_feed')"></span>
                                        <span class='cutz sub_titles' alt='News Feed'><?php echo Controller::customize_label_welcome('News Feed');?></span> <span id="feed_url" onClick="feed_url()" ></span></h3>
                                    <ul style="margin-left:25px;" class="circle"><?php
                                        $feed_url="http://feeds.reuters.com/reuters/INworldNews";
                                        if(isset($userdoc->welcome_urls->news_feed))
                                        {
                                            $feed_url=$userdoc->welcome_urls->news_feed;
                                        }
                                        $feed_url = array($feed_url);
                                        $ucont    = count($feed_url)-1;
                                        for($i=0;$i<=$ucont;$i++)
                                        {
                                            $curl = curl_init();
                                            curl_setopt($curl, CURLOPT_URL,"$feed_url[$i]");
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);

                                            $xmlData = curl_exec($curl);

                                            curl_close($curl);

                                            $xml = simplexml_load_string($xmlData);

                                            $count = 5;

                                            $char = 0;

                                            foreach ($xml->channel->item as $item)
                                            {
                                                if($char == 0)
                                                {
                                                    $newstring = $item->description;
                                                }
                                                else
                                                {
                                                    $newstring = substr($item->description, 0, $char);
                                                }
                                                if($count > 0)
                                                {
                                                    if($item->title!="" && ($item->guid!="" || $item->link!="" ))
                                                    {
                                                        if($item->guid!="")
                                                        {
                                                            $link=$item->guid;
                                                        }
                                                        else
                                                        {
                                                            $link=$item->link;
                                                        }
                                                    }
                                                    echo"<li><a href='".$link."' target='_blank'>{$item->title}</a></li>";
                                                }
                                                $count--;
                                            }
                                        }
                                        ?></ul>
                                </div>
                            </div>
                        </div>
                        </li><?php
                    }
                }
                $zip_weather = '10001';
                if(isset($userdoc->welcome_urls->zip_code))
                {
                    $zip_weather = $userdoc->welcome_urls->zip_code;
                }

                $tiwt = 'SAP';
                if(isset($userdoc->welcome_urls->tiwt))
                {
                    $tiwt=$userdoc->welcome_urls->tiwt;
                }
                ?>
            </ul>
        </div>


    </div>
    <!--Chart Icons End -->
    </div>
    </div>


    <!-- Body end -->

    </div>
    <!-- Item removed on 25092015 -->
    <!--------------------------------------------------------------------------------------------->
    <div class="widget_dis widget_right">
        <div class='cls_wid'></div>
        <h3>Widget Settings</h3>
        <div style='display:none' id='w_ri'>All available widgets are added already.</div>
        <table>
            <tr class="<?php echo $opps_w;?> delete_weather_tr"><td><h4>Weather</h4></td>
                <td id="delete_weather_x" >
                    <div class="btn_<?php echo $display_w_db;?>" onClick="we_db('<?php echo $display_w_db;?>','delete_weather')"><?php echo $display_w_db;?></div>
                </td>
            </tr>
            <tr class="<?php echo $opps_d;?> delete_date_tr"><td><h4>Calendar</h4></td>
                <td id="delete_date_x">
                    <div class="btn_<?php echo $display_d_db;?>" onClick="we_db('<?php echo $display_d_db;?>','delete_date')"><?php echo $display_d_db;?></div>
                </td></tr>
            <tr class="<?php echo $opps_f;?> delete_feed_tr"><td><h4>News Feed</h4></td>
                <td id="delete_feed_x">
                    <div class="btn_<?php echo $display_f_db;?>" onClick="we_db('<?php echo $display_f_db;?>','delete_feed')"><?php echo $display_f_db;?></div>
                </td></tr>
        </table>
    </div>
    <!--------------------------------------------------------------------------------------------->
    </div>
    

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.simpleWeather.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.validationEngine1.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="<?php /*echo Yii::app()->request->baseUrl; */?>/js/jquery.validationEngine.js"></script>-->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
    <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia-ui.js"></script>-->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tags/autoGrowInput.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/formToWizard.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/header.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables1.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/smart_table-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.accordion.source.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tweetable.jquery.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.timeago.js"></script>-->
    <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.draggable.js"></script>-->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.mouse.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.sortable.js"></script>
    <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>-->

    <script type="text/javascript">

    if (typeof jQuery === "undefined")
    {
        alert('Jquery Not Included');
    }
    else
    {
        //..............................................................................................................
        $(document).ready(function() {
            var loops = 0;
            $("#ecc-form").validationEngine('attach',{
                onValidationComplete: function(form, status)
                {
                    if(loops < 1)
                    {
                        if(status)
                        {
                            var routing_string = $('#routing_string').val();
                            if(routing_string!="")
                            {
                                /*
                                 var leng=routing_string.length;
                                 var s = routing_string.charAt(routing_string.length-leng);
                                 var n = routing_string.charAt(routing_string.length-1);
                                 if(s!='/'&&n!='/')
                                 {
                                 $('#routing_string').css({border:'1px solid red'});
                                 jAlert('<p style="color:red;">Invalid SAProuter String</p>', 'Message');
                                 return false;
                                 }
                                 */
                            }
                            var con_type        = $('#cont_type').val();
                            if(!$('#extension').is(':checked'))
                            {
                                var description     = $('#description').val();
                                var host            = $('#host').val();
                                var routing_string  = $('#routing_string').val();
                                var router_port     = $('#router_port').val();
                                var sys_num         = $('#system_num').val();
                                var messageserver   = $('#messageserver').val();
                                var group           = $('#group').val();
                                var sys_id          = $('#system_id').val();
                                var client          = $('#client').val();
                                var user_name       = $('#user_name').val();
                                var pswd            = $('#password').val();
                                var lang            = $('#language').val();
                                var bapiversion     = $('#bapiversion').val();
                                var extension       = "off";
                                if(con_type=='cust')
                                {
                                    var dataString = 'description='+description+'&host='+host+'&routing_string='+routing_string+'&router_Port='+router_port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&lang='+lang+'&extension='+extension+'&con_type=cust&bapiversion='+bapiversion;
                                }
                                else
                                {
                                    var dataString = 'description='+description+'&messageserver='+messageserver+'&group='+group+'&sys_id='+sys_id+'&lang='+lang+'&extension='+extension+'&con_type=grp&bapiversion='+bapiversion;
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo Yii::app()->createAbsoluteUrl("host/eccsystem"); ?>',
                                    data: dataString,
                                    success: function(val) {
                                        //alert(val); return false;
                                        if(val=='paypal')
                                        {
                                            $('.paypal').show();
                                            $("#backgroundPopup").css("opacity", "0.7");
                                            $("#backgroundPopup").fadeIn(0001);
                                            return false;
                                        }
                                        if(val=='NOSYSTEM')
                                        {
                                            jAlert('<b style="color:red;">This system is already exist</b>', 'Message');
                                            return false
                                        }
                                        jAlert('<b style="color:green;">New SAP System is Added</b><br>', 'Message',function(r){
                                            if(r)
                                            {
                                                $('.emt').val('');
                                                $('.display').toggle();
                                                var sy=val.split('@');
                                                $('#sap_sys').html(sy[2]);
                                                $('#getthis').html(sy[1]);
                                                $('#add_sys').hide();
                                                $('#avl_sys').show();
                                                $('#'+sy[0]+'_del').addClass("suss").delay(1500).queue(function(next){
                                                    $(this).removeClass("suss");
                                                    next();
                                                });
                                                // location.reload();
                                            }
                                        });
                                    }
                                });
                            }
                            else
                            {
                                jPrompt('', 'no_data', 'SAP System details', function(r) {
                                    if( r )
                                    {
                                        var para=r.split(',');
                                        $('#bhide').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/aj_load.gif'>");
                                        //document.getElementById('error_msg').innerHTML="";
                                        var de=0;
                                        if(de!=1)
                                        {
                                            $('#add_fsys input').each(function(index, element) {
                                                var names=$(this).attr('name');
                                                var values=$(this).val();

                                                // alert(idss);
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
                                                        $.cookie(names,name_cook, { expires: 365 });
                                                    }
                                                }
                                                //alert($.cookie(names));
                                            });

                                            if(document.getElementById('extension').value=='off')
                                            {
                                                $('#ahide').hide();
                                                $('#bhide').show();
                                                var con_type = $('#cont_type').val();
                                                var description=$('#description').val();
                                                var host=$('#host').val();
                                                var routing_string=$('#routing_string').val();
                                                var router_port=$('#router_port').val();
                                                var sys_num=$('#system_num').val();
                                                var messageserver=$('#messageserver').val();
                                                var group=$('#group').val();
                                                var sys_id=$('#system_id').val();
                                                var client=$('#client').val();
                                                var user_name=$('#user_name').val();
                                                var pswd=$('#password').val();
                                                var lang=$('#language').val();
                                                var bapiversion=$('#Bapiversion').val();
                                                //
                                                if($('#extension').is(':checked'))
                                                {
                                                    var extension='on';
                                                }
                                                else
                                                {
                                                    var extension='off';
                                                }
                                                if(con_type=='grp')
                                                {
                                                    var dataString='messageserver='+messageserver+'&group='+group+'&sys_id='+sys_id+'&client='+para[0]+'&user_name='+para[1]+'&pswd='+para[2]+'&lang='+lang+'&extension='+extension+'&con_type='+con_type;

                                                }
                                                else
                                                {
                                                    var dataString='host='+host+'&routing_string='+routing_string+'&router_Port='+router_port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&client='+para[0]+'&user_name='+para[1]+'&pswd='+para[2]+'&lang='+lang+'&extension='+extension+'&con_type='+con_type;
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo Yii::app()->createAbsoluteUrl("host/extension"); ?>",
                                                    data: dataString,
                                                    success: function(data) {
                                                        // alert(data);
                                                        var str=data.split("@");
                                                        if(str[1]=='SAPin Extended Version Validation Successful')
                                                        {
                                                            document.getElementById('extension').checked='checked';
                                                            var extension=document.getElementById('extension').value='on';
                                                            var exten='';
                                                        }
                                                        else
                                                        {
                                                            document.getElementById('extension').checked='';
                                                            document.getElementById('extension').value='off';
                                                            var exten='Extended features are not available in this system';
                                                            var extension=$('#extension').val('off');
                                                        }
                                                        if(str[0]=='done')
                                                        {
                                                            if(con_type=='grp')
                                                            {
                                                                var dataString1 = 'description='+description+'&messageserver='+messageserver+'&group='+group+'&sys_id='+sys_id+'&client='+para[0]+'&user_name='+para[1]+'&pswd='+para[2]+'&lang='+lang+'&extension='+extension+'&con_type='+con_type+'&bapiversion='+bapiversion;
                                                            }
                                                            else
                                                            {
                                                                var dataString1 = 'description='+description+'&host='+host+'&routing_string='+routing_string+'&router_Port='+router_port+'&sys_num='+sys_num+'&sys_id='+sys_id+'&client='+para[0]+'&user_name='+para[1]+'&pswd='+para[2]+'&lang='+lang+'&extension='+extension+'&con_type='+con_type+'&bapiversion='+bapiversion;
                                                            }

                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo Yii::app()->createAbsoluteUrl("host/eccsystem"); ?>",
                                                                data: dataString1,
                                                                success: function(data) {
                                                                    if(data=='paypal')
                                                                    {
                                                                        $('.paypal').show();
                                                                        $("#backgroundPopup").css("opacity", "0.7");
                                                                        $("#backgroundPopup").fadeIn(0001);
                                                                        return false;
                                                                    }
                                                                    if(data=='NOSYSTEM')
                                                                    {
                                                                        jAlert('<b style="color:red;">This system is already exist as demo system</b>', 'Message');
                                                                        return false;
                                                                    }
                                                                    jAlert('<b style="color:green;">New SAP System is Added</b><br>'+exten, 'Message',function(r){
                                                                        if(r)
                                                                        {
                                                                            $('.emt').val('');
                                                                            document.getElementById('extension').value='off';
                                                                            document.getElementById('extension').checked='';
                                                                            $('.display').toggle();
                                                                            var sy=data.split('@');
                                                                            $('#sap_sys').html(sy[2]);
                                                                            $('#getthis').html(sy[1]);
                                                                            $('#add_sys').hide();
                                                                            $('#avl_sys').show();
                                                                            $('#'+sy[0]+'_del').addClass("suss").delay(1500).queue(function(next){
                                                                                $(this).removeClass("suss");
                                                                                next();
                                                                            });
                                                                            // location.reload();
                                                                        } });
                                                                }
                                                            });
                                                        }
                                                        else
                                                        {
                                                            jAlert('<p style="color:red;">'+str[0]+"</p>", 'Message');
                                                        }
                                                        $('#ahide').show();
                                                        $('#bhide').hide();
                                                    }
                                                });
                                            }
                                            else
                                            {
                                                document.getElementById('extension').value='off';
                                                document.getElementById('extension').checked='';
                                            }
                                        }
                                    }
                                });
                            }
                        }
                        loops = 0;
                    }
                } });
                
                
                    $(document).ready(function() { jQuery("#validation").validationEngine(); });
    
     var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
        $('#datepicker').val(today);

        $('#datepicker').datepicker({
            format: 'mm/dd/yyyy',
            weekStart: '0',
            autoclose:true
        }).on('changeDate', function()
    {
        $('.datepickerformError').hide();
    });
        
         $('#datepicker1').val(today);

        $('#datepicker1').datepicker({
            format: 'mm/dd/yyyy',
            weekStart: '0',
            autoclose:true
        }).on('changeDate', function()
    {
        $('.datepicker1formError').hide();
    });
       
        });

        function bobj_extn(id,type)
        {
            if(type=='BOBJ')
            {
                if($(id).is(':checked'))
                {
                    $('.cms_names').removeClass('hide_ex_bi');
                }
                else
                {
                    $('.cms_names').addClass('hide_ex_bi');
                }
            }
        }
        var help_en="<?php echo $_SESSION['help_en']; ?>";

        if($.cookie('help_en')==null)
        {
            $.cookie('help_en',help_en);
        }
        help_arry=$.cookie('help_en');
        $(document).ready(function(){
            $('#host').focus(function() {
                $('#note_ip').show();
            });
            $('#host').focusout(function() {
                $('#note_ip').hide();
            });
            $('#bi_system_url').focus(function() {
                $('#note_bi').show();
            });
            $('#bi_system_url').focusout(function() {
                $('#note_bi').hide();
            });
            $("#backgroundPopup").click(function() {
                $('.paypal').hide();
                $("#backgroundPopup").fadeOut("normal");
            });
            $('#pal_cls').click(function() {
                $('.paypal').hide();
                $("#backgroundPopup").fadeOut("normal");
            });
            $('#feedback').feedBackBox();
            if(help_arry.search("<?php echo Yii::app()->user->getState("user_id"); ?>")<0)
            {
                if(help_en.search("<?php echo Yii::app()->user->getState("user_id"); ?>")<0)
                {
                    help_arry='';
                    help_arry +="<?php echo Yii::app()->user->getState("user_id"); ?>,";
                    help_arry +='host_page,';
                    $.cookie('help_en',help_arry);
                    help_t();
                }
                else
                {
                    $.cookie('help_en',help_en);
                }
            }
            jQuery(".validation").validationEngine();
            jQuery("#sap_host").validationEngine();
            // sap_host
        });

        function sap_form_return_portal(url) {
            $('#company').hide();
            $('#avl_sys').hide();
            $('#add_sys').hide();
            url_frm = "";
            
            // page_url = url;
            var srt = url.replace(/_/g," ");
            srt = srt.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            $('#title_host').text(srt);

            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("host/profile"); ?>',
                cache : false,
                success: function(html) {
                    $('#welcome_wiget').hide();
                    $('.sap_null').css({ display:'none' })
                    $('#sap_sys').hide();
                    $('#avl_sys').hide();
                    $('#bi_add').hide();
                    $('#bi_avl').hide();
                    $('#prof').show();

                    if(help_arry.search(url)<0) {
                        help_arry +=url+',';
                        $.cookie('help_en',help_arry);
                        help_t();
                    }
                    $('#out_put_prof').html(html);

                    if(url_frm == "profile_initial")
                    {
                        $("#url_frm").val("host");
                        $('.change_pass').trigger("click");
                        $("#mybtnCancel, #nav_tab, #profile").hide();
                    }
                    else if(url_frm == "profile")
                    {
                        $("#url_frm").val(url_frm);
                        $('.change_pass').trigger("click");
                        // $("#mybtnCancel, #nav_tab, #profile").hide();
                    }
                    $('#loading').hide();
                    $("body").css("opacity","1");
                }
            });
            $('.sap_null').css({ display:'none' })
            $('.span9').css({ width:'100%' })
        
        }
        
        function sap_form(url) {
            $('#company').hide();
            $('#avl_sys').hide();
            $('#add_sys').hide();
            url_frm = "";
            if(url=='subscription')
                $('.paypals').hide();
            else if(url == 'profile_initial')
            {
                url_frm = url;
                url = "profile";
            }
            else if(url == 'profile')
            {
                url_frm = url;
                url = "profile";
            }
            else
            {
            
            }
             // page_url = url;
            var srt = url.replace(/_/g," ");
            srt = srt.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            $('#title_host').text(srt);
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("host/profile"); ?>',
                cache : false,
                success: function(html) {
                    $('#welcome_wiget').hide();
                    $('.sap_null').css({ display:'none' })
                    $('#sap_sys').hide();
                    $('#avl_sys').hide();
                    $('#bi_add').hide();
                    $('#bi_avl').hide();
                    $('#prof').show();

                    if(help_arry.search(url)<0) {
                        help_arry +=url+',';
                        $.cookie('help_en',help_arry);
                        help_t();
                    }
                    $('#out_put_prof').html(html);

                    if(url_frm == "profile_initial")
                    {
                        $("#url_frm").val("host");
                        $('.change_pass').trigger("click");
                        $("#mybtnCancel, #nav_tab, #profile").hide();
                    }
                    else if(url_frm == "profile")
                    {
                        $("#url_frm").val(url_frm);
                        $('.change_pass').trigger("click");
                        // $("#mybtnCancel, #nav_tab, #profile").hide();
                    }
                    $('#loading').hide();
                    $("body").css("opacity","1");
                }
            });
        
           
            $('.sap_null').css({ display:'none' })
            $('.span9').css({ width:'100%' })
        
        }

        function remove_class()
        {
            $('.widgg').addClass('dis_wd');
            $('.deld_wid').addClass('dis_wd');
            $('.customize_input').each(function(index, element) {
                $(this).remove();
            });
        }


        function sap_common_form(url)
        {
            $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });

            //$('.help_thin').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+url+'.jpg');
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
                srt='BI Reports';
            }
            if(srt=='Editsalesorder')
            {
                srt='Display Sales Order';
            }
            //console.log(srt);
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
                        if(html!='')
                        {
                            var histry=html.split("@");
                            var srts=histry[0];
                            if(histry[0]=='Editsalesorder')
                            {
                                srts='Display Sales Order';
                            }
                            if(histry[0]=='Editcustomers')
                            {
                                srts='Display and Edit Customer';
                            }
                            if(histry[0]=='Picking And Post Goods')
                            {
                                srts='Pick And Post Goods';
                            }
                            if(histry[0]=='Editvendors')
                            {
                                srts='Display and Edit Vendor';
                            }
                            if(histry[0]=='Create Roles')
                            {
                                srts='Create Role';
                            }
                            if(histry[0]=='Delete Roles')
                            {
                                srts='Delete Role';
                            }
                            if(histry[0]=='Edit Roles')
                            {
                                srts='Display / Edit Role';
                            }
                            if(histry[0]=='Edit User')
                            {
                                srts='Display / Edit User';
                            }
                            if(histry[0]=='Edit Company')
                            {
                                srts='Display / Edit Company';
                            }
                            $('#head_tittle').html(srts);
                            $('#hist').html(histry[1]);
                        }else
                            $('#head_tittle').html(url);    
                        }
                    });
            }
            var typ="normal";
            var widt = $(document).width();
            var beforeload = (new Date()).getTime();
            var form_values = 'url='+url+'&scr='+widt;
            if(url=='create_customer_service_users')
            {
                url='create_retailer_users';
                typ="customer";
            }else if(url=='edit_customer_service_users')
            {
                url='edit_retailer_users';
                typ="customer";
            }else if(url=='delete_customer_service_users')
            {
                url='delete_retailer_users';
                typ="customer";
            }else if(url=='list_customer_service_users')
            {
                url='list_retailer_users';
                typ="customer";
            }else if(url=='create_retailer_service_users')
            {           
                url='create_retailer_users';
                typ="service";
            }else if(url=='edit_retailer_service_users')
            {
                url='edit_retailer_users';
                typ="service";
            }else if(url=='delete_retailer_service_users')
            {
                url='delete_retailer_users';
                typ="service";
            }else if(url=='list_retailer_service_users')
            {
                url='list_retailer_users';
                typ="service";
            }else
                url=url;
            
            if(url == 'profile'){
                var ContarollerAction = '<?php echo Yii::app()->createAbsoluteUrl("host/"); ?>/'+url;
            } else {
                var ContarollerAction = url+'/'+url+'?typ='+typ;
            }

            if($.cookie('form_values')!=null&&$.cookie('form_values')!='')
            {
                form_values = $.cookie('form_values');
                submit_form('forms');
            }
            else
            {
                $('#prof').hide();
                $('#avl_sys').hide();
                $('#sap_sys').hide();
                $('#add_sys').hide();
                $('#my_wid').hide();
                $('#welcome_wiget').hide();
                $('#company').show();


                $.ajax({
                    type: "POST",
                    data:form_values,
                    url: ContarollerAction,
                    cache : false,
                    success: function(html)
                    {
                        //alert(html);
                        $(window).scrollTop(0);
                        $('#out_put_form').show();
                        $('#out_put_form').html(html);
                        $('#loading').hide();
                        $("body").css("opacity","1");
                    }
                });
            }
            $('.sap_null').css({ display:'none' });
            $('.span9').css({ width:'100%' });
            
        }

        $(document).ready(function () {
            $('#extented_bobj').click(function() {
                if ($(this).is(':checked')) {
                    $('.exten_bobj').show();
                }
                else
                {
                    $('.exten_bobj').hide();
                }
            })
            $('ul').accordion();
            //$('#sap_dit').trigger('click');
        });
        var old_sys = "";

        function select_system(value)
        {
            if(value != "")
            {
                old_sys = value;
                var help_fol = "";
                if(navigator.userAgent.match(/iPad/i))
                    help_fol = "ipad/ipad_";
                else if(navigator.userAgent.match(/iPhone/i))
                    help_fol = "iphone/iphone_";
                $('.help_thin').attr('src','<?php echo Yii::app()->request->baseUrl; ?>/images/help/'+help_fol+'host_'+value+'.jpg');
                $('.sys_t').hide();
                $('.'+value).show();
            }
            else
                $('.'+old_sys).hide();
        }
        function cont_types(value)
        {
            $('.comm').show();
            if(value=='grp')
            {
                $('.grp').show();
                $('.cust').hide();
            }
            if(value=='cust')
            {
                $('.grp').hide();
                $('.cust').show();
            }

            if($.trim(value)=='')
            {
                $('.grp').hide();
                $('.cust').hide();
                $('.comm').hide();
            }

        }

        $(function() {
            $( "#column9" ).sortable({ placeholder: "ui-state-highlight" });
        });

        $(function() {
            $("#column9").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable("serialize") + '&action=updateHostListings';
                // alert(order);
                $('#loading').show();
                $.post("<?php echo Yii::app()->createAbsoluteUrl("host/updatepanel"); ?>", order, function(theResponse){
                    //alert(theResponse);
                    //$('body').html(theResponse);
                    $('#loading').hide();
                    //alert(theResponse);
                });
            }
            });
        });
    }
    </script>



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

        }

        tab_ses_chk();
        var golb      = "";
        var page_url  = "welcome";
        /*var help_en   = "<?php echo $_SESSION['help_en']; ?>";
        var help_arry = $.cookie('help_en');

        if(help_arry == null)
        {
            $.cookie('help_en',help_en);
            help_arry = $.cookie('help_en');
        }*/

        function save_customize()
        {
            $('.widgg').addClass('dis_wd');
            $('.deld_wid').addClass('dis_wd');
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

                        jAlert("Your string has special characters. \nThese are not allowed.","Message");
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
                    var total_val=host_val[0]+","+host_val[1]+","+host_val[2]+","+host_val[3]+","+host_val[4]+","+host_val[5]+","+para[0]+","+para[1]+","+host_val[6]+","+host_val[7]+","+host_val[8]+","+para[3];
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
                                jAlert("There was an error connecting to your SAP System.<br> Please check your Systems Settings, Client, Username and Password or contact us.","Meassage");
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
                                jAlert("There was an error connecting to your SAP System.<br> Please check your Systems Settings, Client, Username and Password or contact us.","Meassage");
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
                                        jAlert("There was an error connecting to your SAP System.<br> Please check your Systems Settings, Client, Username and Password or contact us.","Meassage");
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


        function submit_ajaxform(id)
        {

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
                            jAlert("<b>SAP System Message: </b><br>"+response, 'Message');
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
                            jAlert(response, 'Error Message');
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


        function color_tip() { $('[tip]').colorTip({color:'red'}); }

        function we_db(type,ids) { if(type=='Remove') { delete_weigt(ids); }else{ add_widget(ids); } }

        function add_widget(ids)
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

        function delete_weigt(ids)
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
        }

        $(document).ready(function()
        {
            $('#out_put').bind("DOMSubtreeModified",function(){
                $(document).find('input:text').blur(function(){
                    $(this).val($.trim($(this).val()));
                });
            });
            //.........................................................................
            $('#childframe').css({ height:'990px' });
            //.........................................................................
            $.ajax({ type: "POST", data:"type=check_w", url: "<?php echo Yii::app()->createAbsoluteUrl("dashboard/welcomeurls"); ?>", success: function(html) { }  });
            //..........................................           ...............................
            //$('ul').accordion();
            //.........................................................................
            $('.level-3 li a').click(function(){ $.cookie('form_values',''); })
            $.cookie('form_values','');
            var page = window.location.hash;
            $(page!='')
            {
                $('.level-1 li').first().removeClass('active');
                $(page+'_t').trigger('click');
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
            ////$('#feedback').feedBackBox();
            color_tip();
            /*if(help_arry.search('dashbord_page')<0)
            {
                help_arry +='dashbord_page,';
                $.cookie('help_en',help_arry);
                help_t();
            }*/
            ////his_fav_list('hist');
            ////his_fav_list('d_favt');
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
            $.simpleWeather({
                zipcode: '<?php echo $zip_weather;?>',
                unit: 'f',
                success: function(weather)
                {
                    html  =  '<h3 class="widget_weth"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="p_ic"> <span class="deld_wid dis_wd" id="delet_weth" onclick="delete_weigt(\'delete_weather\')"></span><span class="cutz sub_titles" alt="Weather"><?php echo Controller::customize_label_welcome('Weather');?></span><span id="wiget_url" onClick="widget_url()"></span></h3>';
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
            });
            //.........................................................................
            $( "#column1" ).sortable({ revert: true });
            $( "#column2" ).sortable({ revert: true });
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
            $("#column2").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable("serialize") + '&action=update_right_RecordsListings';
                $('#loading').show();
                $.post("<?php echo Yii::app()->createAbsoluteUrl("host/updatepanel"); ?>", order, function(theResponse){
                    $('#loading').hide();
                });
            }});
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
$('#out_put').click(function(){
if($('.sidebar-toggle').hasClass('user-active-bars'))
            {
                $('.sidebar-toggle').removeClass('user-active-bars');
                $('#nav_tab').hide();
            }
});

    </script>

<?php
$usr_role   = Yii::app()->user->getState("role");
////$user_id    = Yii::app()->user->getState("user_id");
////$company_id = Yii::app()->user->getState("company_id");



if(Yii::app()->user->getState("change_pwd"))
{
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            sap_form('profile_initial');
            $(".level-1 .topli").removeClass("active");
            $(".level-1").find(".level-2").hide();
            $(".level-1 .topli:first").addClass("active");
            $(".level-1 #mnu_company").find(".level-2").show();
            $(".level-2 .topli:first").addClass("active");
        });
    </script>
<?php
}
else
{
    if($companyid == "emgadmin")
    {
        if($usr_role == "Admin" || $usr_role == "Primary")
        {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#avilable_systems').hide();
                    $('#host_list').hide();

                    var page = window.location.hash;
                    if(page != '')
                    {
                        $(page).trigger('click');
                        $(".level-1 "+page).closest(".topli").addClass("active");
                    }
                    else
                    {
                        // sap_common_form('create_company');
                        //sap_common_form('list_company');
                        // window.location.hash = "list_company";
                        // var page = window.location.hash;
                        // $(page).trigger('click');
                        /*$(".level-1 .topli").removeClass("active");
                        $(".level-1").find(".level-2").hide();
                        $(".level-1 .topli:first").addClass("active");
                        $(".level-1 #mnu_company").find(".level-2").show();
                        $(".level-2 .topli:first").addClass("active");*/
                        $(".level-1 .topli").removeClass("active");
                        $(".level-1 .topli:first").addClass("active");
                    }
                });
            </script>
        <?php
        }
        else
        {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#avilable_systems').hide();
                    sap_common_form('quota');
                    $(".level-1 .topli").removeClass("active");
                    $(".level-1 .topli:first").addClass("active");
                });
            </script>
        <?php
        }
    }
    elseif($companyid == "freetrial")
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                /*
                 $(".level-1 .topli").removeClass("active");
                 $(".level-1 .topli:first").addClass("active");
                 $(".level-2 .topli:first").addClass("active");
                 */
                var page = window.location.hash;
                if(page != '')
                {
                    $(page).trigger('click');
                    $(".level-1 "+page).closest(".topli").addClass("active");
                }
            });
        </script>
    <?php
    }
    else
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                <?php if($usr_role == "Admin" || $usr_role == "Primary") { ?>
                $('#import_syatems').show();
                <?php }else{ ?>
                $('#import_syatems').hide();
                <?php } ?>
                $(".level-1 .topli").removeClass("active");
                $(".level-1 .topli:first").addClass("active");
                //$(".level-2 .topli:first").addClass("active");

                var page = window.location.hash;
                if(page != '')
                {
                    $(page).trigger('click');
                    $(".level-1 .topli").removeClass("active");
                    $(".level-1").find(".level-2").hide();
                    $(".level-1 "+page).closest(".topli").addClass("active");
                    $(".level-1 "+page).closest(".topli").find("ul").addClass("active");
                    $(".level-1 "+page).closest("li").addClass("active");
                    // alert($(".level-1 "+page).closest(".topli").find(".level-2").html());
                    // $(".level-1 "+page).closest(".topli").find(".active").show();
                }
            });
            
        </script>
    <?php
    }
}
?>

