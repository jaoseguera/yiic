<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/alerts.css" />
<?php $cs = Yii::app()->getClientScript(); $cs->registerCoreScript('jquery'); Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.feedBackBox.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine1.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js"></script>
<style>
    label span  { color:red; }
</style>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12" >
            <div class="header-top">
                <div class="header-wrapper">
                    <a href="<?php echo Yii::app()->createAbsoluteUrl("login/"); ?>" class="sapin-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-125x50.png"/></a>
                    <div class="user-panel header-divider body_con" style="border:none;width:59%"></div>
                    <div class="header-right">
                        <div class="header-divider">
                            <a href='<?php echo Yii::app()->createAbsoluteUrl("login/"); ?>' style='padding-right:30px;color:#fff;' class="re_login">Login</a>
                        </div>
                    </div><!-- End header right -->
                </div><!-- End header wrapper -->
            </div><!-- End header -->
        </div>
    </div>
    <section id='utopia-wizard-form' class="utopia-widget">
        <div class="utopia-widget-title">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/list.png" class="utopia-widget-icon">
            <span>Forgot your password</span>
        </div>
        <div class="row-fluid">
            <div class="utopia-widget-content">
                <div class="span12 utopia-form-freeSpace ">
                    <div class="sample-form">
                        <form id="validation"  class="form-horizontal forget" >
                            <div class="control-group" id="type_email" >
                                <label class="control-labels" for="inputError">Enter Your Email Address<span>*</span>:&nbsp;</label>
                                <div class="controls"  >
                                    <input id="email_id" class="input-fluid validate[required,custom[email]] span4" type="text" name='email_id' >
                                    <span id="email_check"></span>
                                    <br>
                                    <table class="bcl"><tr><td>  
                                        <button class="btn btn-primary span2" id="next" type="button"  onclick='question()' style="min-width:75px">Next</button></td><td>
                                        <button class="btn  span2" type="button"  onclick='cancel_pass()' style="min-width:75px">Cancel</button></td></tr></table>
                                </div>
                            </div>
                            <div id='select_confirm' style="display:none;">
                                <table><tr><td colspan='2'>
                                            <h3>Select one of the options below to reset your password:</h3>
                                            <br></td>
                                    </tr>
                                    <tr><td><input type='radio' name='confirm' id='confirms'></td><td>Send verification code to my email</td></tr>
                                    <tr><td colspan='2' style="padding:5px;">
                                            <div style='display:none;' id='mail_id'>
                                                <br>
                                                <div>Email Id:&nbsp;&nbsp;<span id='email_de' style="font-weight:bold;"></span></div>
                                                <div>
                                                    <br>
                                                    <button class="btn btn-primary span2" type="button"  onclick='emails("send")' style="min-width:66px" id='cnf_pass'>Send</button></div>
                                            </div>
                                        </td></tr>
                                    <tr><td colspan='2'>
                                            <div id='verifi_cod' style='display:none;padding:5px;'>
												<span class="alert-success" style='padding: 5px;'><strong>Please check your email for verification code.</strong></span><br /><br />
                                                <div >Enter your verification code:</div>
                                                <div><input type='text' name='verifi_code' id='vrfy'></div>
                                                <div><br>
                                                    <input type='button' value='Verify' onclick='emails("vrfy")'  class="btn btn-primary"></div>
                                            </div>
                                        </td></tr>
                                    <tr><td ><input type='radio' name='confirm' id='security_qus'></td>
                                        <td>Reset password by answering security questions</td></tr>
                                    <tr>
                                        <td colspan='2'>
                                            <div id="output" style="display:none;">
                                                <table>
                                                    <td><div id='q1'></div><td>
                                                    <tr>
                                                        <td>
                                                            <input id="a1" class="input-fluid validate[required]" type="text" name='a1'>
                                                            <input id="qa1"  type="hidden" >
                                                        </td>
                                                    </tr>
                                                    <tr><td><div id='q2'></div></td></tr>
                                                    <tr><td>
                                                            <input id="a2" class="input-fluid validate[required]" type="text" name='a2'>
                                                            <input id="qa2"  type="hidden" ></td></tr>
                                                    <tr><td>
                                                            <table class="bcl"><tr><td>
                                                                        <button class="btn btn-primary span2" type="button"  onclick='ans()' style="min-width:75px">Next</button></td></tr></table>
                                                        </td></tr></table> </td></tr></table>
                            </div>
                            <div id='newpass' style='display:none'>
                                <div class="control-group">
                                    <label class="control-label" for="password">Enter New Password<span> *</span>:</label>

                                    <div class="controls">
                                        <input id="password" class="input-fluid validate[required] span4" type="password" value="" name="pswd"><br>

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password">Retype password<span> *</span>:</label>

                                    <div class="controls">
                                        <input id="re-password" class="input-fluid validate[required,equals[password]] span4" type="password" value=""><br/>
                                    </div>
                                </div>
                                <div class="span2"></div>
                                <div>
                                    <table class="bcl"><tr><td>
                                    <button class="btn btn-primary span2" type="button"  onclick='newpass()' style="min-width:75px">Next</button></td><td>
                                    <button class="btn span2" type="button"  onclick='cancel_pass()' style="min-width:75px">Cancel</button></td></tr></table>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
$(document).ready(function() { jQuery("#validation").validationEngine(); });
$(document).ready(function() {		
    if($.cookie("css")) {
        $('link[href*="../utopia-white.css"]').attr("href",$.cookie("css"));
        $('link[href*="../utopia-dark.css"]').attr("href",$.cookie("css"));
    }		
    $('#next').click(function(){ $(this).submit(); $("body").css("opacity","1"); });		

    $(".theme-changer a").on('click', function() {
        $('link[href*="../utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="../utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
});
function question()
{
    var val=$('#email_id').val();
    if(val==""||val==" ")
    {	
        return false;
    }
    var dataString='email='+val+'&questions=on';
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createAbsoluteUrl("forget_password/index"); ?>",
        data: dataString,
        success: function(html) {
            if((html.indexOf('Object Not Found - missing') > -1) || (html.indexOf('Please contact your admin to change the password') > -1))
            {
                $('#email_id').val("");
                $('#email_id').css({ border:'1px solid red' });
                $('#email_check').html("Please contact your admin to change the password")
                $('#email_check').css({color:'red'});
            }
            else
            {
                $('#type_email').hide();
                $('#select_confirm').show();
                $('#security_qus').click(function(){
                    $('#mail_id').hide();
                    $('#output').show();
                    $('#verifi_cod').hide();
                });
                $('#confirms').click(function()
                {
                    $('#cnf_pass').html("Send");
                    $('#email_de').html($('#email_id').val());
                    $('#mail_id').show();
                    $('#output').hide();
                });
                var se=html;
                var sde=se.split(',');
                $('#q1').html(sde[0]+"<span style='color:red;'> *</span>:&nbsp;&nbsp;&nbsp;");
                $('#q2').html(sde[1]+"<span style='color:red;'> *</span>:&nbsp;&nbsp;&nbsp;");
                $('#qa1').val(sde[2]);
                $('#qa2').val(sde[3]);
            }
        }
    });
}


function ans()
{

    var a1=$('#a1').val().toLowerCase();
    var a2=$('#a2').val().toLowerCase();
    var qa1=$('#qa1').val();
    var qa2=$('#qa2').val();

    if(a1==qa1&&a2==qa2)
    {
        if(a1=""||a1==" ")
        {
            return false;
        }
        if(a2=""||a2==" ")
        {
            return false;
        }
        $('#select_confirm').hide();
        $('#output').hide();
        $('#newpass').show();
    }
    else
    {
        $('#a1').val('');
        $('#a2').val('');
        $('#a2').css({
            border:'1px solid red'})
        $('#a1').css({
            border:'1px solid red'})
        jAlert('Incorrect Answers', 'Message');
    }
}

function newpass()
{
    var val=$('#email_id').val();
    var pass=$('#password').val();
    var re_p=$('#re-password').val();
    if(pass!=re_p)
    {
        $('#password').css({ border:'1px solid red' });
        $('#re-password').css({ border:'1px solid red' });
        return false;
    }
    if(pass==""||re_p=="")
    {
        $('#password').css({ border:'1px solid red' });
        $('#re-password').css({ border:'1px solid red' });
        return false;
    }

    var dataString='email='+val+'&pass='+pass;
    
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createAbsoluteUrl("forget_password/newpassword"); ?>",
        data: dataString,
        success: function(html) {
            jAlert('Your Password has successfully Changed, Please login to continue', 'Success message',function(r){
                if(r)
                {
                    window.location.replace('<?php echo Yii::app()->createAbsoluteUrl("login/"); ?>');
                }
            });
        }
    });
}

function cancel_pass()
{
    window.location.replace('<?php echo Yii::app()->createAbsoluteUrl("login/"); ?>');
}

function emails(type)
{
    $('#cnf_pass').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader2.gif'>");
    var verify = '';
    if(type=='vrfy')
    {
        verify = $('#vrfy').val();
    }
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createAbsoluteUrl("forget_password/verifi_password"); ?>",
        data: "type="+type+"&user_id="+$('#email_id').val()+'&verify='+verify,
        success: function(html) {
            $('#verifi_cod').show();
            $('#mail_id').hide();
            if(html=='done')
            {
                $('#select_confirm').hide();
                $('#newpass').show();
            }
			else if(html == 'cancel')
			{
				jAlert('Invalid verification code, Please try again..', 'Message', function(r){
					$('#vrfy').focus();
				});
			}
        }
    });
}
</script>