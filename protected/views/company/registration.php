<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>thinui (beta), by Emergys</title>
	<link  rel="SHORTCUT ICON" HREF="../img/thinui.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A complete admin panel theme">
    <meta name="author" content="theemio">

    <link href="../css/alerts.css" type="text/css" rel="stylesheet">
    <link href="../css/colorpicker.css" rel="stylesheet" type="text/css"/>
    <link href="../color/bundle.css" media="screen" rel="stylesheet" type="text/css"/>
    
    
    <link href="../css/datepicker.css" rel="stylesheet" type="text/css"/>
    <link href="../css/utopia-growl.css" rel="stylesheet" type="text/css"/>
    <link href="../css/page-scrller.css" rel="stylesheet" type="text/css"/>
    <!-- styles -->
    <link href="../css/utopia-white.css" rel="stylesheet">
    <link href="../css/utopia-responsive.css" rel="stylesheet">
    <link href="../css/ie.css" rel="stylesheet">
    <link href="../color/bundle.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/chosen.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../css/jquery.tagedit.css" rel="stylesheet" type="text/css">
    <link href="../css/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
	<link href="../css/jquery.feedBackBox.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.cookie.js"></script>
	<script src="../js/jquery.feedBackBox.js"></script>
    <script>
        if($.cookie("css")) {
            $('link[href*="../utopia-white.css"]').attr("href",$.cookie("css"));
            $('link[href*="../utopia-dark.css"]').attr("href",$.cookie("css"));
        }
        $(document).ready(function() {
            $(".theme-changer a").live('click', function() {
                $('link[href*="../utopia-white.css"]').attr("href",$(this).attr('rel'));
                $('link[href*="../utopia-dark.css"]').attr("href",$(this).attr('rel'));
                $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
                $('.user-info').removeClass('user-active');
                $('.user-dropbox').hide();
            });
        });
		function checkemail()
		{
		var val=$('#email_id').val();
		var dataString='page=dublicate&email='+val;
		$.ajax({
      type: "POST",
      url: "../lib/controller.php",
      data: dataString,
      success: function(html) {
		 		  if(html=='This Email Id All Ready Exists')
		  {
		 	$('#email_id').val("");
		  $('#email_id').css({
			  border:'1px solid red'
		  });
		  $('#email_check').html(html)
		  $('#email_check').css(
		  {color:'red'});
		  }
	  }
	  });
		}
		$(document).ready(function(e) {
          
				$("#email_id").focus(function () {
         $('#email_id').css({
			  border:''
		  });
		  $('#email_check').html('');
		 
    });
				$("#email_id_v").focus(function () {
         $('#email_id_v').css({
			  border:''
		  });
		  $('#email_check_v').html('');
		 
    });
			
				

$("#veri").focus(function () {
         $('#veri').css({
			  border:''
		  });
		  $('#veri_v').html('');
		 
    });
$("#email_bets").focus(function () {
         $('#email_bets').css({
			  border:''
		  });
		  $('#email_bets_v').html('');
		 
    });

    });
	function registration()
	{
		var currentdate = new Date(); 
		var datetime = (currentdate.getMonth()+1)+"/"+currentdate.getDate() + "/"+ currentdate.getFullYear() + " @ "+ currentdate.getHours() + ":"+ currentdate.getMinutes() + ":"+ currentdate.getSeconds();
		$('#loading').show();
		$("body").css("opacity","0.4");
		$("body").css("filter","alpha(opacity=40)");
		$.ajax(
		{
			type:'POST',
			url: '../lib/save_xml.php?date_time='+datetime,
			data:$('#validation1').serialize(), 
			success: function(response) 
			{
				// alert(response);
				$('#loading').hide();
				$("body").css("opacity","1");
				if(response == 'Message sent!') {
					jAlert('You have registered successfully, Please login to continue', 'Message',function(r)
					{
						if(r)
						{
							window.location.replace('../index.php');
						}			
					});
				}
				else
				{
					jAlert('Registration process not successful, Please try again..', 'Message',function(r)
					{
						
					});
				}
			}
		});
	}
    </script>
<style>
.formError .formErrorContent
{
margin-left:-230px;
width: 120px !important;
}
.formErrorArrow
{
	margin-left:-120px !important;

}
@media all and (max-width: 1000px) {
	.registration_forms
	{
		width:auto !important;
	}
.registration_forms td
{
	display:block;
}
.registration_forms input
{
	width:200px !important;
}
}
.registration_forms tr td
{
	padding:10px !important;
}
</style>
    <!--[if IE 8]>
    <link href="../css/ie8.css" rel="stylesheet">
    <![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<div id='loading'><img src="../images/ajax-loader.gif"></div>
<div id="feedback"></div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12" >

            <div class="header-top">

                <div class="header-wrapper">

                    <a href="dashboard.php" class="sapin-logo"><img src="../img/thinui-logo-125x50.png"/></a>
<div class="user-panel header-divider body_con" style="border:none;width:59%"></div>
                    <div class="header-right">
 <div class="header-divider">
 
                            <a href="../index.php" style='padding-right:30px;color:#fff;' class="re_login">Login</a>
                      
						</div>
                    </div><!-- End header right -->

                </div><!-- End header wrapper -->

            </div><!-- End header -->

        </div>

    </div>
<section id='utopia-wizard-form' class="utopia-widget  section row-fluid main_div" >
<?php 
$noBeta = true;
?>
    <div class="utopia-widget-title" style="display:none;" id='r_title'>
        <img src="../img/icons/paragraph_justify.png" class="utopia-widget-icon">
        <span>Create an Account</span>
    </div>

    <div style="padding:15px;" >
	
	<?php
	if($noBeta == false)
	{
	if(isset($_SESSION['fb_beta']))
	{ 

$data=json_decode($_SESSION['fb_beta'],true);

$_SESSION['fb_code']=$_SESSION['fb_beta'];
       $s_type=$_SESSION['s_type']; 
	 
		   if($s_type=='facebook')
		{ ?>
		<div style="background-color:#3B5A9B;color:#fff;text-align:center;">
		<?php }
		else
		{ ?>
		<div style="background-color:#3C3B39;color:#fff;text-align:center;">
		<?php }
?>


<h3>Your email address successfully registered.<br>You will recieve thinui beta user code shortly after our review. It may take up to 24 hours.</h3>
</div>
  <div class="utopia-widget-content"  >
       <div class="control-group" >
	  
	   <br>
	   <table  align="center">
	
	             
                          <input id="email_bets" class="validate[required]" type="hidden" name='email_bets'  value='<?php echo $data['email'];?>'  >
						  <div id="email_bets_v"></div></td>
						 

	   <tr><td>
                                <label class="control-label" for="inputError">Already have beta code? Please enter here<span> *</span>:</label></td></tr>
<tr><td>
                            
                          <input id="veri" class="validate[required]" type="text" name='veri'  placeholder="Beta code"  >
						  <div id="veri_v"></div></td>
						  </tr>
		 <tr><td align='center'>  <button class="btn btn-primary  v_b" type="button"  onclick="verification_code('fb')"  style='width:80px;'>Verify</button></td>
                                </tr>
                                   </table>
                               
                            </div>
      </div>








	<?php }
	else
	{
	?>
	<!------------------------------------------------------------------------------>
	   <div class="span6" id="email_veri">
                    <section class="utopia-widget row-fluid" >
                        <div class="utopia-widget-title">
                            <img src="../img/icons/list.png" class="utopia-widget-icon iphone_reg">
                            <span style="font-size:16px;">Enter your email address to request a beta code</span>
                        </div>

                        <div class="utopia-widget-content">
     <div class='well' style='text-align:justify;'>ThinUI is in the initial beta launch.  During this time you must obtain a beta code in order to access ThinUI.  Beta codes will be issued as system capacity becomes available.</div>
       <div class="control-group" >
	   <table  align="center"   class="registration_forms" width='100%'>

<tr><td >
                                <label class="control-label" for="inputError">First Name:<span> *</span>:</label>
								 <input id="firstName_id_v" class="validate[required] span10" type="email" name='firstName_id_v'  placeholder="Enter First Name" >
						  <div id="firstName_check_v"></div>
								</td>
								<td> <label class="control-label" for="inputError">Last Name:<span> *</span>:</label>
								<input id="lastName_id_v" class="validate[required] span10" type="email" name='lastName_id_v'  placeholder="Enter Last Name" >
						  <div id="lastName_check_v"></div>
						  </td></tr>

	   <tr><td>  <label class="control-label" for="inputError">Company Name:<span> *</span>:</label>
								<input id="company_id_v" class="validate[required] span10" type="email" name='company_id_v'  placeholder="Enter Company Name" >
						  <div id="company_check_v"></div></td>
						  <td >
                                <label class="control-label" for="inputError">Email address:<span> *</span>:</label>
								<input id="email_id_v" class="validate[required,custom[email]] span10" type="email" name='email_id_v'  placeholder="Enter email address" >
						  <div id="email_check_v"></div>
								</td></tr>



				  
						  <tr><td align='center' colspan="2">  <button class="btn btn-primary e_b" type="button"  onclick="check_email()" style='width:80px;'>Submit</button></td>
                                </tr>
                                   </table>
                               
                            </div>
      </div>
	  </section>
	  </div>
	  	<!------------------------------------------------------------------------------>

 <div class="span6" id="verifi_code">
                    <section class="utopia-widget row-fluid" style="height:355px;">
                        <div class="utopia-widget-title">
                            <img src="../img/icons/list.png" class="utopia-widget-icon iphone_reg" >
                            <span style="font-size:16px;">Already have a beta code? Please enter it here to complete your user creation.</span>
                        </div>


  <div class="utopia-widget-content"  >
       <div class="control-group" >
	  
	   <br>
	   <br>
	   <table  align="center">
	  <tr>
	  <td colspan="2"> <label class="control-label" for="inputError">Email address<span> *</span>:</label>
	  </td></tr>
	  <tr><td colspan="2">
                            
                          <input id="email_bets" class="validate[required]" type="email" name='email_bets'  placeholder="Enter email address"  >
						  <div id="email_bets_v"></div></td>
						  </tr>

	   <tr><td>
                                <label class="control-label" for="inputError">Beta code<span> *</span>:</label></td></tr>
<tr><td>
                            
                          <input id="veri" class="validate[required]" type="text" name='veri'  placeholder="Beta code"  >
						  <div id="veri_v"></div></td>
						  </tr>
		 <tr><td align='center'>  <button class="btn btn-primary  v_b" type="button"  onclick="verification_code('thin')"  style='width:80px;'>Verify</button></td>
                                </tr>
                                   </table>
                               
                            </div>
      </div>
</section>
</div>
<?php
	}
								}
								?>


			<!------------------------------------------------------------------------------>

				
     <div class="utopia-widget-content" id="registration_form" <?php if($noBeta == false) { ?>style="display:none;" <?php } ?>>
<form id="validation1" action="javascript:registration()" class="form-horizontal create_account" style="margin:0px;padding:0px;">
<div class="span6 utopia-form-freeSpace myspace  ">
<fieldset class="marg">
<div class="control-group">
<label class="control-label" for="input01">First Name<span> *</span>:</label>

<div class="controls">
<input id="input01" class="input-fluid validate[required,custom[onlyLetterSp]] span8" type="text" name='fname' placeholder="First Name" tabindex="1">
</div>
</div>
<div class="control-group">
<label class="control-label" for="input01">Last Name<span> *</span>:</label>

<div class="controls">
<input id="input02" class="input-fluid validate[required,custom[onlyLetterSp]] span8" type="text" name='lname' placeholder="Last Name" tabindex="2">
</div>
</div>
<div class="control-group" >
<label class="control-label" for="inputError">Email Address<span> *</span>:</label>

<div class="controls" >
<input id="email_id" class="input-fluid validate[required,custom[email]] span8" type="text" name='email_id' onChange="checkemail()" placeholder="Email" tabindex="3"><span id="email_check"></span>

</div>
</div>
<div class="control-group">
<label class="control-label" for="password">Password<span> *</span>:</label>

<div class="controls">
<input id="password" class="input-fluid validate[required,custom[password]] span8" type="password" name="pswd" placeholder="Enter at least 6-8digits with alphanumeric." tabindex="4">

</div>
</div>
<div class="control-group">
<label class="control-label" for="password">Retype password<span> *</span>:</label>

<div class="controls">
<input id="re-password" class="input-fluid validate[required,equals[password]] span8" type="password" placeholder="*****" tabindex="5">
</div>
</div>
<div class="control-group">
<label class="control-label" for="select02">Secret Question 1<span> *</span>:</label>

<div class="controls sample-form-chosen">
<select id="select04" data-placeholder="Select your Question"  class="chzn-select-deselect span8 validate[required]" tabindex="6" name="q1">
<option value="">Select your Question</option>
<option value="What was the name of your primary school?">What was the name of your primary school?</option>
<option value="Which city were you born in?">Which city were you born in?</option>
<option value="What was your childhood nickname?">What was your childhood nickname? </option>
<option value="In what city did you meet your spouse/significant other?">In what city did you meet your spouse/significant other?</option>
<option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend? </option>
<option value="What street did you live on in third grade?">What street did you live on in third grade?</option>
<option value="What is your oldest siblings birthday month and year?">What is your oldest siblings birthday month and year?</option> 
<option value="What is the middle name of your oldest child?">What is the middle name of your oldest child?</option>
<option value="What is your oldest sibling's middle name?">What is your oldest sibling's middle name?</option>
<option value="What school did you attend for sixth grade?">What school did you attend for sixth grade?</option>
</select>
</div>
</div>
<div class="control-group">
<label class="control-label" for="input01">Your Answer<span> *</span>:</label>

<div class="controls">
<input id="input07" class="input-fluid validate[required] span8" type="password" name='a1' placeholder="Your Secret Answer" tabindex="7">
</div>
</div>

<div class="control-group">
<label class="control-label" for="select02">Secret Question 2<span> *</span>:</label>

<div class="controls sample-form-chosen">
<select id="select03" data-placeholder="Select your Question"  class="chzn-select-deselect span8 validate[required]" tabindex="8" name="q2">
<option value="">Select your Question</option>
<option value="What is the title of your favourite book?">What is the title of your favourite book?</option>
<option value="What was your favourite childhood game?">What was your favourite childhood game?</option>
<option value="What was the name of your elementary / primary school?">What was the name of your elementary / primary school?</option>
<option value="What is the name of the company of your first job?">What is the name of the company of your first job?</option>
<option value="What was your favorite place to visit as a child?">What was your favorite place to visit as a child?</option>
<option value="What is your spouse's mother's maiden name?">What is your spouse's mother's maiden name?</option>
<option value="What is the country of your ultimate dream vacation?">What is the country of your ultimate dream vacation?</option>
<option value="What is the name of your favorite childhood teacher?">What is the name of your favorite childhood teacher?</option>
<option value="What was your dream job as a child? ">What was your dream job as a child? </option>
<option value="What is the street number of the house you grew up in?">What is the street number of the house you grew up in?</option>
</select>
</div>
</div>

<div class="control-group">
<label class="control-label" for="input01">Your Answer<span> *</span>:</label>

<div class="controls">
<input id="input08" class="input-fluid validate[required] span8" type="password" name='a2' placeholder="Your Secret Answer" tabindex="9">
</div>
</div>
</fieldset></div>
<div class="span6 utopia-form-freeSpace ">
<fieldset>
<div class="control-group">
<label class="control-label" for="input01">Street Address<span> *</span>:</label>

<div class="controls">
<input id="input04" class="input-fluid validate[required] span8" type="text" name='street' placeholder="Street Address" tabindex="10">
</div>
</div>
<div class="control-group">
<label class="control-label" for="input01">City<span> *</span>:</label>

<div class="controls">
<input id="input05" class="input-fluid validate[required,custom[onlyLetterSp]] span8" type="text" name='city' placeholder="City" tabindex="11">
</div>
</div>

<div class="control-group">
<label class="control-label" for="input01">State<span> *</span>:</label>

<div class="controls">
<input id="input06" class="input-fluid validate[required,custom[onlyLetterSp]] span8" type="text" name='state' placeholder="State" tabindex="12">
</div>
</div>
<div class="control-group">
<label class="control-label" for="select02">Country<span> *</span>:</label>

<div class="controls sample-form-chosen">
<select id="select02" data-placeholder="Select your country"  class="chzn-select-deselect span8 validate[required]" tabindex="13" name="country" >
<option value="">Select your country</option>
<option value="AF">Afghanistan</option>
<option value="AX">Åland Islands</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia, Plurinational State of</option>
<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
<option value="BA">Bosnia and Herzegovina</option>
<option value="BW">Botswana</option>
<option value="BV">Bouvet Island</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo</option>
<option value="CD">Congo, the Democratic Republic of the</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Côte d'Ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CW">Curaçao</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GG">Guernsey</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-Bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard Island and McDonald Islands</option>
<option value="VA">Holy See (Vatican City State)</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="IR">Iran, Islamic Republic of</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IM">Isle of Man</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JE">Jersey</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KP">Korea, Democratic People's Republic of</option>
<option value="KR">Korea, Republic of</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao People's Democratic Republic</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macao</option>
<option value="MK">Macedonia, the former Yugoslav Republic of</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia, Federated States of</option>
<option value="MD">Moldova, Republic of</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="ME">Montenegro</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PS">Palestinian Territory, Occupied</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>
<option value="PH">Philippines</option>
<option value="PN">Pitcairn</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RE">Réunion</option>
<option value="RO">Romania</option>
<option value="RU">Russian Federation</option>
<option value="RW">Rwanda</option>
<option value="BL">Saint Barthélemy</option>
<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="MF">Saint Martin (French part)</option>
<option value="PM">Saint Pierre and Miquelon</option>
<option value="VC">Saint Vincent and the Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="RS">Serbia</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SX">Sint Maarten (Dutch part)</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">South Georgia and the South Sandwich Islands</option>
<option value="SS">South Sudan</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syrian Arab Republic</option>
<option value="TW">Taiwan, Province of China</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania, United Republic of</option>
<option value="TH">Thailand</option>
<option value="TL">Timor-Leste</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US" selected>United States</option>
<option value="UM">United States Minor Outlying Islands</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VE">Venezuela, Bolivarian Republic of</option>
<option value="VN">Viet Nam</option>
<option value="VG">Virgin Islands, British</option>
<option value="VI">Virgin Islands, U.S.</option>
<option value="WF">Wallis and Futuna</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
</select>
</div>
</div>


<div class="control-group">
<label class="control-label" for="date">Phone<span> *</span>:</label>


<div class="controls">
<input  class="input-fluid  validate[required, custom[phone]] span8" type="text" value="" name='phone' placeholder="Eg. 555-555-5555" tabindex="14">

</div>
</div>
<div class="control-group">
<label class="control-label" for="input01">Company Name<span> *</span>:</label>

<div class="controls">
<input id="input03" class="input-fluid validate[required,custom[onlyLetterSp]] span8" type="text" name='company_name' placeholder="Company Name" tabindex="15">
</div>
</div>





<div class="control-group">


<div class="controls create_account" id="agree">
<span><a href="#">Services agreement </a></span> | <span><a href="#">Privacy policy </a></span> | <span><a href='#'>Security policy</a></span>
<div class="checkboxExtra js-checkbox"  >I agree with the above terms and conditions</div>
<p style="color:red;">* Required Field<p>
</div>
</div>

<div class="span1" ></div> 
<div style="padding-bottom:10px;">
<table class="butt_bottom" ><tr><td >
<button class="btn spanbt btn-primary e_b" type="submit" tabindex="17">Submit</button></td>
<td ><button class="btn spanbt" type="button" onClick="window.location.href='../index.php'">Cancel</button></td>
</tr></table>
</div>
</fieldset>
</div>
</form>
</div>
           </div>
 
</section>
</div>
<script type="text/javascript" src="../js/utopia.js"></script>


<script type="text/javascript" src="../js/custom.js"></script>
<script type="text/javascript" src="../js/alerts.js"></script>

<script src="../js/utopia-ui.js"></script>
<script src="../js/ui/mouse.js"></script>
<script src="../js/ui/slider.js"></script>

<script src="../js/pagescroller.min.js" type="text/javascript"></script>

<script src="../js/jquery.validationEngine1.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/tags/utopia-tagedit.js"></script>
<script type="text/javascript" src="../js/utopia-ui.js"></script>
<script type="text/javascript" src="../js/tags/autoGrowInput.js"></script>
<script type="text/javascript" src="../js/utopia.js"></script>
<script type="text/javascript" src="../js/chosen.jquery.js"></script>
<script type="text/javascript" src="../js/jquery.cleditor.js"></script>
<script type="text/javascript" src="../js/formToWizard.js"></script>
<script src="../js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/maskedinput.js"></script>
<script src="../color/javascripts/SCF.ui.js" type="text/javascript"></script>
<script src="../color/javascripts/SCF.ui/checkbox.js" type="text/javascript"></script>
<script src="../color/javascripts/SCF.ui/commutator.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/header.js"></script>
<script type="text/javascript" src="../js/sidebar.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('#feedback').feedBackLog();
        $.cleditor.defaultOptions.width = '';
        $.cleditor.defaultOptions.height = '250';
        $("#input").cleditor();

        $("#date").mask("9999/99/99");
        $("#phone").mask("(999) 9999999999");

        $('#function-source input.tag').tagedit({
            autocompleteOptions: {
                source: function(request, response){
                    var data = [
                        { "id": "1", "label": "Hazel Grouse", "value": "Hazel Grouse" },
                        { "id": "2", "label": "Common Quail",	"value": "Common Quail" },
                        { "id": "3", "label": "Greylag Goose", "value": "Greylag Goose" },
                        { "id": "4", "label": "Merlin", "value": "Merlin" }
                    ];
                    return response($.ui.autocomplete.filter(data, request.term) );
                }
            }
        });
        $('input.show-tags').tagedit({
            autocompleteOptions: {
                source: function(request, response){
                    var data = [
                        { "id": "1", "label": "Hazel Grouse", "value": "Hazel Grouse" },
                        { "id": "2", "label": "Common Quail",	"value": "Common Quail" },
                        { "id": "3", "label": "Greylag Goose", "value": "Greylag Goose" },
                        { "id": "4", "label": "Merlin", "value": "Merlin" }
                    ];
                    return response($.ui.autocomplete.filter(data, request.term) );
                }
            }
        });

        $('input.show-tags2').tagedit({
            allowEdit: false,
            allowAdd: false,
            autocompleteOptions: {
                source: function(request, response){
                    var data = [
                        { "id": "1", "label": "Hazel Grouse", "value": "Hazel Grouse" },
                        { "id": "2", "label": "Common Quail",	"value": "Common Quail" },
                        { "id": "3", "label": "Greylag Goose", "value": "Greylag Goose" },
                        { "id": "4", "label": "Merlin", "value": "Merlin" }
                    ];
                    return response($.ui.autocomplete.filter(data, request.term) );

                }

            }
        });
		jQuery("#validation1").validationEngine();
        jQuery("#validation").validationEngine();
    });


   // $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
    $("#signUp").formToWizard();

	function check_email()
	{
		$('.e_b').html("<img src='../img/ajax-loader2.gif'>");
		var val=$('#email_id_v').val();
		var firstname=$('#firstName_id_v').val();
		var lastname=$('#lastName_id_v').val();
		var companyname=$('#company_id_v').val();
		 var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
   if(!emailReg.test(val)) {  
        $('#email_id_v').css({
			  border:'1px solid red'
		  });
		  $('#email_check_v').html("Please enter valid email address")
		  $('#email_check_v').css({color:'red'});
		$('.e_b').html('Submit');
		return false;
   }else if(firstname == ''){
    $('#firstName_id_v').css({
			  border:'1px solid red'
		  });
		$('#firstName_check_v').html("Please enter First Name")
		  $('#firstName_check_v').css({color:'red'});
		  $('.e_b').html('Submit');
		  return false;
	}else if(lastname == ''){
    $('#lastName_id_v').css({
			  border:'1px solid red'
		  });
		$('#lastName_check_v').html("Please enter Last Name")
		  $('#lastName_check_v').css({color:'red'});
		  $('.e_b').html('Submit');
		  return false;
	}else if(companyname == ''){
    $('#company_id_v').css({
			  border:'1px solid red'
		  });
		$('#company_check_v').html("Please enter Company Name")
		  $('#company_check_v').css({color:'red'});
		  $('.e_b').html('Submit');
		  return false;
	}    
		var dataString='page=dublicate&email='+val;
		$.ajax({
      type: "POST",
      url: "../lib/controller.php",
      data: dataString,
      success: function(html) {

		 		  if(html=='This Email Id All Ready Exists')
		  {
					  $('.e_b').html('Submit');
		 	$('#email_id_v').val("");
		  $('#email_id_v').css({
			  border:'1px solid red'
		  });
		  $('#email_check_v').html("User with this email address already exists")
		  $('#email_check_v').css(
		  {color:'red'});
		  }
		  else
		  {
               verification();
		  }
	  }
	  });
	}


	function verification()
	{
		
		var datastr=$('#email_id_v').val();
		var firstName=$('#firstName_id_v').val();
		var lastName=$('#lastName_id_v').val();
		var company=$('#company_id_v').val();

 var currentdate = new Date(); 
                var datetime =(currentdate.getMonth()+1)+"/"
	            +currentdate.getDate() + "/"
              + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();						
	var dataString="mail_to="+datastr+"&type=sub&firstName="+firstName+"&lastName="+lastName+"&company="+company+"&date_time="+datetime;
      $.ajax({
      type: "POST",
      url: "../lib/registration_email.php",
      data: dataString,
      success: function(html) {
//alert(html);
jAlert(html, 'Message');
$('.e_b').html("Submit");
	  }
	  });

	}



	function verification_code(type)
	{
		
		$('.v_b').html("<img src='../img/ajax-loader2.gif'>");
		var mail_too= $('#email_bets').val();
if(type!='fb')
		{
	
		 var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
   if(!emailReg.test(mail_too)) {  
        $('#email_bets').css({
			  border:'1px solid red'
		  });
		  $('#email_bets_v').html("Please enter valid email address")
		  $('#email_bets_v').css({color:'red'});
		$('.v_b').html('Verify');
		return false;
   }   


var dataString='page=dublicate&email='+mail_too;
		$.ajax({
      type: "POST",
      url: "../lib/controller.php",
      data: dataString,
      success: function(html) {

		 		  if(html=='This Email Id All Ready Exists')
		  {
					
				$('.v_b').html('Verify');
$('#veri').val("");
$('#email_bets').val("");
$('#email_bets').css({border:'1px solid red'});
		  $('#veri').css({
			  border:'1px solid red'
		  });
		  $('#veri_v').html("User with this email address already exists")
		  $('#veri_v').css(
		  {color:'red'});

		  }
		  else
		  {
			
//..................................................................................


var v_code=$('#veri').val();
	var dataString="verifi_code="+v_code+"&mail_to="+mail_too+"&type=verifi";
      $.ajax({
      type: "POST",
      url: "../lib/registration_email.php",
      data: dataString,
      success: function(html) {
		var para=html.split(',');				
if("done"==para[1])
		  {
	$('#email_veri').hide();
	$('#verifi_code').hide();
	$('#registration_form').show();
	$('#r_title').show();
	$('#email_id').val(mail_too).attr('readonly', 'readonly');
	$('#input01').val(para[2]).attr('readonly', 'readonly');
	$('#input02').val(para[3]).attr('readonly', 'readonly');
	
		  }
		  else
		  {
$('.v_b').html('Verify');
$('#veri').val("");
$('#email_bets').val("");
$('#email_bets').css({border:'1px solid red'});
		  $('#veri').css({
			  border:'1px solid red'
		  });
		  $('#veri_v').html(html)
		  $('#veri_v').css(
		  {color:'red'});
		  }
//$('#email_veri').hide();
//$('#verifi_code').show();
	  }
	  });


//...................................................

		  }
	  }
		});

	}
	else
		{
		
		var v_code=$('#veri').val();
		
		var mail_too= $('#email_bets').val();
		
	var dataString="verifi_code="+v_code+"&mail_to="+mail_too+"&type=verifi";
      $.ajax({
      type: "POST",
      url: "../lib/registration_email.php",
      data: dataString,
      success: function(html) {
		 var para=html.split(',');	
		  if(para[1]=="done")
		  {
			  window.location="../lib/facebook_login.php?fb_keys=enable";
		  }
		  else
		  {
			  $('.v_b').html('Verify');
$('#veri').val("");

		  $('#veri').css({
			  border:'1px solid red'
		  });
		  $('#veri_v').html(html)
		  $('#veri_v').css(
		  {color:'red'});
		  }

	  }
	  });
		}
}

</script>


</body>
</html>