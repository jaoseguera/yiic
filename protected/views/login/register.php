<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array( 'Register', );

$country_list = Controller::getCountryList();
$state_list	  = '';

?><script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>

<style> 
	.utopia-login { margin-left:auto; margin-right:auto; margin-top:10%; }
	label.error {  border: none !important; }
        .control-group { margin-bottom: 10px !important;}
        .main_div { min-height: 492px !important; }
	.chzn-select-deselect, .host_select
	{
		margin-left:0px !important;
	}
</style>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<div class="container-fluid">
<div class="row-fluid">
<div class="span12" >
<div class="header-top">
<div class="header-wrapper">
<a href="index" class="sapin-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/thinui-logo-125x50.png"  /></a>
<div class="user-panel header-divider body_con" style="border:none;"></div>
<div class="header-right">
<div class="header-divider">
<a href="index" style='padding-right:30px;color:#fff;' class="re_login">Login</a>
</div>
</div><!-- End header right -->
</div><!-- End header wrapper -->
</div><!-- End header -->
</div>
</div>
<section id='utopia-wizard-form' class="utopia-widget  section row-fluid main_div" >
<div class="utopia-widget-title" style="display:block;" id='r_title'>
<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
<span>Create an Account</span>
</div>

<div style="padding:15px;" >
<!------------------------------------------------------------------------------>
<div class="utopia-widget-content" id="registration_form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'register-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array( 'onsubmit'=>"return false;", 'class'=>"form-horizontal create_account", ),
)); ?>

<div class="span6 utopia-form-freeSpace myspace  ">
<div class="errorMessage" id="formResult"></div>
<div id="AjaxLoader" style="position: absolute; top: 350px; left: 600px;  display: none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></img></div>
<fieldset class="marg">
<div class="control-group">
<?php echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'firstname',array('class'=>'validate[required,custom[onlyLetterSp]] input-fluid span8', 'name'=>'fname', 'placeholder'=>'First Name','tabindex'=>'1','id'=>'input01')); ?>
    <span style="color:red;"><?php echo $form->error($model,'firstname'); ?></span></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
<div class="controls">
<label><?php echo $form->textField($model,'lastname',array('class'=>'validate[required,custom[onlyLetterSp]] input-fluid span8', 'name'=>'lname', 'placeholder'=>'Last Name','tabindex'=>'2','id'=>'input02')); ?>
<span style="color:red;"><?php echo $form->error($model,'lastname'); ?></span></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'email',array('class'=>'validate[required,custom[email]] input-fluid span8', 'name'=>'email_id', 'placeholder'=>'Email Address','tabindex'=>'3','id'=>'input03')); ?>
<span style="color:red;"><?php echo $form->error($model,'email'); ?></span></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
<div class="controls">
<label><?php echo $form->passwordField($model,'password',array('class'=>'validate[required,custom[password]] input-fluid span8', 'name'=>'pswd', 'placeholder'=>'Enter at least 6-8digits with alphanumeric.','tabindex'=>'4','id'=>'input04')); ?>
<span style="color:red;"><?php echo $form->error($model,'password'); ?></span></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'repassword',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->passwordField($model,'repassword',array('class'=>'validate[required,equals[input04]] input-fluid span8', 'placeholder'=>'*****','tabindex'=>'5','id'=>'input05')); ?>
<span style="color:red;"><?php echo $form->error($model,'repassword'); ?></span></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'secques1',array('class'=>'control-label')); ?>
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
<?php echo $form->labelEx($model,'secans1',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->passwordField($model,'secans1',array('class'=>'validate[required] input-fluid span8', 'name'=>'a1', 'placeholder'=>'Secret Answer','tabindex'=>'7','id'=>'input07')); ?>
<span style="color:red;"><?php echo $form->error($model,'secans1'); ?></span></label>
</div>
</div>

<div class="control-group">
<?php echo $form->labelEx($model,'secques2',array('class'=>'control-label')); ?>
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
<?php echo $form->labelEx($model,'secans2',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->passwordField($model,'secans2',array('class'=>'validate[required] input-fluid span8', 'name'=>'a2', 'placeholder'=>'Secret Answer','tabindex'=>'9','id'=>'input09')); ?>
<span style="color:red;"><?php echo $form->error($model,'secans2'); ?></span></label>
</div>
</div>
</fieldset></div>
<div class="span6 utopia-form-freeSpace ">
<fieldset class="marg">
<div class="control-group">
<?php echo $form->labelEx($model,'country',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->dropDownList($model, 'country', $country_list, array('class'=>'validate[required] chzn-select-deselect span8', 'name'=>'country', 'onchange' => 'return getstate(this.value)', 'tabindex' => 10, 'prompt' => 'Please select country')); ?>
<span style="color:red;"><?php echo $form->error($model, 'country'); ?></span></label>
</div>
</div>

<div class="control-group">
<?php echo $form->labelEx($model,'state',array('class'=>'control-label')); ?>
<div class="controls">
    <label>
		<div id="state_option"><?php echo $form->dropDownList($model, 'state', $state_list, array('class'=>'validate[required] chzn-select-deselect span8', 'name'=>'state_list', 'tabindex' => 11, 'prompt' => 'Please select state','id'=>'input12')); ?></div>
		<div id="state_text"><?php echo $form->textField($model, 'state',array('class'=>'validate[required] input-fluid span8', 'name'=>'state', 'placeholder'=>'State', 'tabindex' => 12)); ?></div>
<span style="color:red;"><?php echo $form->error($model,'state'); ?></span></label>
</div>
</div>

<div class="control-group">
<?php echo $form->labelEx($model,'city',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'city',array('class'=>'validate[required,custom[onlyLetterSp]] input-fluid span8', 'name'=>'city', 'placeholder'=>'City','tabindex'=>'13','id'=>'input11')); ?>
<span style="color:red;"><?php echo $form->error($model,'city'); ?></span></label>
</div>
</div>

<div class="control-group">
<?php echo $form->labelEx($model,'street',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'street',array('class'=>'validate[required] input-fluid span8', 'name'=>'street', 'placeholder'=>'Street','tabindex'=>'14','id'=>'input10')); ?>
<span style="color:red;"><?php echo $form->error($model,'street'); ?></span></label>
</div>
</div>

<!--   
<div class="control-group">
<label class="control-label" for="select02">Country<span> *</span>:</label>

<div class="controls sample-form-chosen">
<select id="select02" data-placeholder="Select your country"  class="chzn-select-deselect span8 validate[required]" tabindex="13" name="country" >
<option value="">Select your country</option>
<option value="AF">Afghanistan</option>
<option value="AX">Aland Islands</option>
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
-->

<div class="control-group">
<?php echo $form->labelEx($model,'phone',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'phone',array('class'=>'validate[required, custom[phone]] input-fluid span8', 'name'=>'phone', 'placeholder'=>'Eg. 555-555-5555','tabindex'=>'15','id'=>'input14')); ?>
<span style="color:red;"><?php echo $form->error($model,'phone'); ?></span></label>
</div>
</div>
<div class="control-group">
	<?php echo $form->labelEx($model,'company',array('class'=>'control-label')); ?>
	<div class="controls">
		<label><?php echo $form->textField($model,'company',array('class'=>'validate[required,custom[onlyLetterSp]] input-fluid span8', 'name'=>'company', 'placeholder'=>'Company Name','tabindex'=>'16','id'=>'input15')); ?>
		<span style="color:red;"><?php echo $form->error($model,'company'); ?></span></label>
	</div>
</div>
<div class="control-group">
	<div class="controls create_account">
		<span><a href="#">Services agreement </a></span> | <span><a href="#">Privacy policy </a></span> | <span><a href='#'>Security policy</a></span>
		<div class="js-checkbox">
			<input class="validate[required] checkbox" type="checkbox" id="agree" name="agree" style="margin: 0px;" />
			<span>I agree with the above terms and conditions</span>
		</div>
		<p style="color:red;">* Required Field<p>
	</div>
</div>

<div class="span1" ></div> 
<div style="padding-bottom:10px;">
<table class="butt_bottom" ><tr><td >
<?php echo CHtml::submitButton('Submit',array('id'=>'mybtnSubmit','tabindex'=>'17','class'=>'btn spanbt btn-primary e_b',)); ?></td>
<td ><button class="btn spanbt" type="button" onClick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl("login/index"); ?>'">Cancel</button></td>
</tr></table>
</div>
</fieldset>
</div>
<input type="hidden" name="date_time" id="date_time" value="" />
<script>
var currentdate = new Date(); 
var datetime = (currentdate.getMonth()+1)+"/"+currentdate.getDate() + "/"+ currentdate.getFullYear() + " @ "+ currentdate.getHours() + ":"+ currentdate.getMinutes() + ":"+ currentdate.getSeconds();    
document.getElementById('date_time').value = datetime;
</script>
<?php $this->endWidget(); ?>
</div>
</section>
</div>

<?php $cs = Yii::app()->getClientScript(); $cs->registerCoreScript('jquery'); Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine1.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.alerts.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ui.draggable.js" type="text/javascript"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.alerts.css" type="text/css" rel="stylesheet" />
<script>    
if (typeof jQuery === "undefined") {    
     alert('Jquery Not Included');
} else {
	function getstate(ctry)
	{
		if(ctry != "")
		{
			$('#loading').show();
			$("body").css("opacity","0.4");
			$("body").css("filter","alpha(opacity=40)");
			
			$.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->createAbsoluteUrl("countrystate/statelist"); ?>',
				data: "ctry="+ctry,
				success:function(data){
					// console.log(data);
					data1 = $.parseJSON(data);
					// console.log(data1);
					if(data != "null")
					{
						$("#state_option").show();
						$("#state_text").hide();
						$("#state_text input").attr("name", "state_list");
						$("#state_option select").attr("name", "state");
						$("#state_option select").find('option:gt(0)').remove();
						$.each(data1, function (i,v)
						{
							$("#state_option select").append('<option value="'+v.code+'">'+v.title+'</option>');
						});
						// $("#state_option select").append('<option value="NONE">None of the above</option>');
						
						$("#state_option").find("option").on('click', function(){
							enb_text($(this).val());
						});
					}
					else
					{
						$("#state_option").hide();
						$("#state_text").show();
						$("#state_text input").attr("name", "state");
						$("#state_option select").attr("name", "state_list");
					}
					
					$('#loading').hide();
					$("body").css("opacity","1");
				}                        
			});
		}
		else
		{
			$('#loading').show();
			$("body").css("opacity","0.4");
			$("body").css("filter","alpha(opacity=40)");
			
			$("#state_option").show();
			$("#state_text").hide();
			$("#state_text input").attr("name", "state_list");
			$("#state_option select").attr("name", "state");
			$("#state_option select").find('option:gt(0)').remove();
			
			$('#loading').hide();
			$("body").css("opacity","1");
		}
	}
	
	function enb_text(val)
	{
		if(val == "NONE")
		{
			$("#state_text").show();
			$("#state_text input:first").focus();
			$("#state_text input").attr("name", "state");
			$("#state_option select").attr("name", "state_list");
		}
		else
		{
			$("#state_option").show();
			$("#state_text").hide();
			$("#state_text input").attr("name", "state_list");
			$("#state_option select").attr("name", "state");
		}
	}
	
    $(document).ready(function(){
		$("#state_text").hide();
		$("#state_text input").attr("name", "state_list");
		$("#state_option select").attr("name", "state");
		
		$("#state_option").find("option").on('click', function(){
			enb_text($(this).val());
		});
		
        $("#register-form").validationEngine('attach', {
            onValidationComplete: function(form, status)
            {
                if(status)
                {
                    $('#loading').show();
                    $("body").css("opacity","0.4");
                    $("body").css("filter","alpha(opacity=40)");
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createAbsoluteUrl("login/register"); ?>',
                        data: form.serialize(),
                        success:function(data){
							$('#loading').hide();
							$("body").css("opacity","1");
                            if(data == 'Message sent!')
                            {
                                jAlert('You have registered successfully, Please check your email to activate your account', 'Message',function(r)
                                {
                                    if(r)
                                    {
                                        window.location.replace('<?php echo Yii::app()->createAbsoluteUrl("login/index"); ?>');
                                    }			
                                });
                            }
                            else
                            {
                                // jAlert('Registration process not successful, Please try again..', 'Message',function(r)
                                jAlert(data, 'Message',function(r)
                                {
                                    
                                });
                            }
                        }                        
                    });
                }
            }  
        });
    });
}
</script>