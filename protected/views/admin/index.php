<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">

    <title>thinui (beta), by Emergys</title>
<link  rel="SHORTCUT ICON" HREF="../img/thin-ui.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=0">

    <meta name="description" content="A complete admin panel theme">

    <meta name="author" content="theemio">




</head>


<body>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page 
?><script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<script type="text/javascript">

			$(document).ready(function() {
			
       // focus on the first text input field in the first field on the page
        $("input[type='email']:first", document.forms[0]).focus();
			
    });
        </script>
<?php
$email="";
$pswd="";
$checked="";
if(isset($_COOKIE['EmailId'])&&isset($_COOKIE['Pswd'])&&isset($_COOKIE['Check']))
{
	 $email=$_COOKIE['EmailId'];
	 $pswd=$_COOKIE['Pswd'];
	 $checked=$_COOKIE['Check'];
}
if(isset($_REQUEST['ps']))
{?>
	<script>
	$(document).ready(function(e) {
        jAlert('Your Password has successfully Changed, Please login to continue', 'Success message');
    });
	</script>
<?php }

if(isset($_REQUEST['succ']))
{?>
	<script>
	$(document).ready(function(e) {
         jAlert('You have registered successfully, Please login to continue', 'Success message');
    });
	</script>
<?php }

   ?>
<style>
.ipad
{
	margin-left:35%;
	margin-top:-5%;
	
}
@media all and (max-width: 450px){
   .ipad
{
	margin-left:0px;
	
}
.zocial
	{
   max-width: 70px;
	
	white-space: nowrap;
	}
}
@media all
and (max-width : 980px) and (min-width : 470px)
{
   .ipad
{
	margin-left:25%;
	
}
}
</style>
<div class="container-fluid">



    <div class="row-fluid">



        <div class="span12">



            <div class="row-fluid">



              


                <div class="ipad" >

                    <div class="utopia-login">
						<!-- <a href="index.php" class="sapin-logo" style="width:100%;margin-left:30%;"><img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-login.png"/></a>
						<h1><a href="#" class="sapin-logo"><img src="img/sapin-logo.png" alt="Utopia"></a></h1>-->
                       <div class='thinui-login'><a class="sapin-logo" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-125x50.png"  /></a></div>
					   <div id='error'>&nbsp;</div>
                        <form method="post" class="utopia" id="logform" action="javascript:logincheck()">
						
                           <label id='email_s'>User name<span> *</span>:</label>

<input alt="Email address" type="text"  id='email' class="span12 utopia-fluid-input validate[required]" name="email" value="<?php echo $email;?>"  autocomplete="off">

                            <label>Password<span> *</span>:</label>
 <input alt="Password" type="password" id='pswd' class="span12 utopia-fluid-input validate[required]"  name="pswd" value="<?php echo $pswd;?>">


<table border="0" width="100%"><tr>
<td><button type="submit" class="btn span4" id="btnLogin" style="min-width:80px">Login</button></td>

</tr>
<tr>
<td style="display:none;"><input type="checkbox" name='remember' id='remember' <?php echo $checked;?> > Remember me!</td></tr>
</table>
                          

                        </form>

                    </div>

                </div>



            </div>



        </div>

    </div>

</div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine1.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script>
jQuery(document).ready(function() {
	
 $('#logform').validationEngine();
   });
function logincheck()
{
	
var email=document.getElementById('email').value;
var pswd=document.getElementById('pswd').value;
var rem=document.getElementById('remember').checked;
if(email==''||pswd=='')
	  {
	 $('#error').html('Email Address and Password are required');
			  $('#error').css({
				 'padding-left':'70px',
					  'color':'#e00909'
			  });
				   $('#email').css({
				  border:'1px solid #e00909'});
				  $('#pswd').css({
				  border:'1px solid #e00909'});
				  return false;
	  }
		
	  $('#btnLogin').html("<img src='images/aj_load.gif'>");

			
			var dataString = "page=admin&email="+email+"&pswd="+pswd;
//	alert (dataString);return false;
		$.ajax({
      type: "POST",
      url: "admin/logincheck",
      data: dataString,
		  cache:false,
      success: function(html) {
		
		   if(rem) {
		  $.cookie("EmailId", email);
$.cookie("Pswd", pswd);
$.cookie("Check", "CHECKED");
		  }
		  else
		  {
			   $.cookie("EmailId", "");
$.cookie("Pswd", "");
		  }
	if(html=='done')
		  {
			   window.location.replace('admin/betarequest');
		  }
		  else
		  {
		  $('#btnLogin').html("Login");
		  $('#error').html('Invalid User Name Or Password');
			  $('#error').css({
				 'padding-left':'70px',
					  'color':'#e00909'
			  });
				   $('#email').css({
				  border:'1px solid #e00909'});
				  $('#pswd').css({
				  border:'1px solid #e00909'});
		  }
	  
	  }
        });
		
     
}
</script>
</body>
</html>

