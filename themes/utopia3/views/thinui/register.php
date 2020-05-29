<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array( 'Register', );

?>

<style> 
	.utopia-login { margin-left:auto; margin-right:auto; margin-top:10%; }
	label.error {  border: none !important; } 
</style>

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
<form method="post" class="form-horizontal create_account" id="registerform">
<?php 
        $form=$this->beginWidget('CActiveForm', array( 'id'=>'register-form', 'enableClientValidation'=>true, 
            'clientOptions'=>array( 'validateOnSubmit'=>true, ),
));
?>
<div class="span6 utopia-form-freeSpace myspace  ">
<fieldset class="marg">
<div class="control-group">
<?php echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'firstname',array('class'=>'input-fluid span8', 'placeholder'=>'First Name','tabindex'=>'1','id'=>'input01')); ?>
    <?php echo $form->error($model,'firstname'); ?></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
<div class="controls">
<label><?php echo $form->textField($model,'lastname',array('class'=>'input-fluid span8', 'placeholder'=>'Last Name','tabindex'=>'1','id'=>'input01')); ?>
<?php echo $form->error($model,'lastname'); ?></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'email',array('class'=>'input-fluid span8', 'placeholder'=>'Email Address','tabindex'=>'2','id'=>'input02')); ?>
<?php echo $form->error($model,'email'); ?></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'password',array('class'=>'input-fluid span8', 'placeholder'=>'Password','tabindex'=>'3','id'=>'input03')); ?>
<?php echo $form->error($model,'password'); ?></label>
</div>
</div>
<div class="control-group">
<?php echo $form->labelEx($model,'repassword',array('class'=>'control-label')); ?>
<div class="controls">
    <label><?php echo $form->textField($model,'repassword',array('class'=>'input-fluid span8', 'placeholder'=>'Password','tabindex'=>'4','id'=>'input03')); ?>
<?php echo $form->error($model,'repassword'); ?></label>
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
<?php $this->endWidget(); ?>

</div>
</section>
</div>






























