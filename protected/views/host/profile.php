<script>
$(document).ready(function() {
	<?php
	if(Yii::app()->user->getState("change_pwd"))
	{
		?>
		$('#profile-form').hide();
        $('#changepass-form').show();
		<?php
	}
	?>
    $('.change_pass span').click(function()
    {
        $('#profile-form').hide();
        $('#changepass-form').show();
    })

    $('.span4').attr('readonly', 'readonly');
    $('#edit').click(function()
    {
        $(".span4").removeAttr('readonly');
		$('#input04').attr('readonly', 'readonly');
		$('#role').attr('readonly', 'readonly');
        $("#edit").hide();
        $("#submit").show();
        $("#sub_cancel").show();
    });
	
    $('#sub_cancel').click(function()
    {
        $('.span4').attr('readonly', 'readonly');
        $("#edit").show();
        $("#submit").hide();
        $("#sub_cancel").hide();
    });

    $(".theme-changer a").on('click', function() {
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
        $('#email_id').css({ border:''});
        $('#email_check').html('');
    });
});

$(document).ready(function(){            
    $("#profile-form").validationEngine('attach', {
        onValidationComplete: function(form, status)
        {
            if(status)
            {
                $.ajax({type:'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("host/editprofile"); ?>', 
                    data:form.serialize(), 
                    success: function(response) {
                        jAlert('You have updated successfully', 'Success message',function(r){
                        if(r)
                        {
                            location.reload();
                        } });
                    }
                });
            }
        }
    });
 });

function change_pass()
{
    var val=$('#old_pass').val();
    var pass=$('#new_pass').val();
    var re_p=$('#confirm_pass').val();
    
    if(pass!=re_p)
    {
        $('#new_pass').css({ border:'1px solid red' });        
        $('#confirm_pass').css({border:'1px solid red'}).val('').focus(function(){
            $(this).css({border:'1px solid #cccccc'});
            $('#new_pass').css({border:'1px solid #cccccc'});
            $('#conf_er').hide();
        });
        $('#conf_er').html('Password not match').css({color:'red'});
        return false;
    }
    var dataString='page=newpassword&old_pass='+$.md5(val)+'&new_pass='+$.md5(pass);
    
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createAbsoluteUrl("host/changepassword"); ?>",
        data: dataString,
        success: function(html) {
			 $('#loading').hide(); 
             $("body").css("opacity","1"); 
            if(html=='done')
            {
                jAlert('Your Password has successfully Changed', 'Success message',function(r){
					if(r)
					{
						url_frm = $("#url_frm").val();
						$('#old_pass').val('');
						$('#new_pass').val('');
						$('#confirm_pass').val('');
						
						if(url_frm == "host")
						{
							window.location.href = 'host';
							// $('#profile-form').show();
							// $('#changepass-form').hide();
						}
						else
						{
							$('#profile-form').show();
							$('#changepass-form').hide();
							// $('#prof').hide();
							// $("#mybtnCancel, #nav_tab, #avl_sys, #profile").show();
						}
					}
				});
            }
            else
            {
                $('#old_pass').val('').css({border:'1px solid red'}).focus(function(e) {
					$(this).css({border:'1px solid #CCCCCC'});
					$('#error_pass').hide();
                });
				$('#error_pass').show();
                $('#error_pass').html(html).css({color:'red'});
            }
        }
    });
}
</script>
<?php
    $userid = Yii::app()->user->getState("user_id");
	$client = Controller::userDbconnection();
    $doc    = $client->getDoc($userid);
    $user   = $doc->profile;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.md5.js"></script>
<script type="text/javascript">
$(document).ready(function() {      
    jQuery("#profile-form").validationEngine();
    jQuery("#changepass-form").validationEngine();
});

// $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
function cancel_pass()
{
    $('#profile-form').show();
    $('#changepass-form').hide();
}

$(document).ready(function(e) {
    $("select option").filter(function() {
        return $(this).val() == '<?php echo $user->country; ?>'; 
    }).attr('selected', true);
});
</script>

<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">                    
                    
                     <?php $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'profile-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array( 'class'=>"form-horizontal" ),
                        )); ?>
                    <fieldset style="margin-left: 30px;">

                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'firstname',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'fname', 'placeholder'=>'','tabindex'=>'1','id'=>'input01','value'=>"$user->fname")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'firstname'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'lastname',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'lname', 'placeholder'=>'','tabindex'=>'2','id'=>'input02','value'=>"$user->lname")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'lastname'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'phoneno',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'phoneno',array('class'=>'input-fluid  validate[required, custom[phone]] span4', 'name'=>'phone', 'placeholder'=>'','tabindex'=>'3','id'=>'input03','value'=>"$user->phone")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'phoneno'); ?></span></label>
                            </div>
                        </div>
						
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'companyname',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'companyname',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'company_name', 'placeholder'=>'','tabindex'=>'4','id'=>'input04','value'=>"$user->companyname")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'companyname'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'role',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'role',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'role', 'placeholder'=>'', 'id'=>'role', 'value'=>"$user->roles")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'role'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'streetaddress',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'streetaddress',array('class'=>'input-fluid validate[required] span4', 'name'=>'street', 'placeholder'=>'','tabindex'=>'5','id'=>'input05','value'=>"$user->streetaddress")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'streetaddress'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'city',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'city',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'city', 'placeholder'=>'','tabindex'=>'6','id'=>'input06','value'=>"$user->city")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'city'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'state',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'state',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'state', 'placeholder'=>'','tabindex'=>'7','id'=>'input07','value'=>"$user->state")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'state'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="select02">Country<span> *</span>:</label>
                            <div class="controls sample-form-chosen">
                            <select id="select02" data-placeholder="Select your country" class="chzn-select-deselect span4 validate[required]" tabindex="11" name="country">
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
                            <option value="US">United States</option>
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
                            </select><br/>
                            </div>
                        </div>
                        
                        <div class="span2" ></div>  
                        <p class="change_pass labels_t"><span>Change Password</span></p>
                        <div class="span2" ></div>  

                        <p style="color:red;" class="labels_t" >* Required Field</p>
                        <div class="span2" ></div>  
                        
                        <?php echo CHtml::Button('Edit',array('id'=>'edit','tabindex'=>'9','class'=>'btn btn-primary span2','onclick'=>'','style'=>'width:100px;margin-left:50px;')); ?>
                        <?php echo CHtml::submitButton('Submit',array('id'=>'submit','tabindex'=>'10','class'=>'btn btn-primary span2','style'=>'width:100px;display:none;float:left;')); ?>
                        <?php echo CHtml::Button('Cancel', array('id'=>'sub_cancel','tabindex'=>'10','class'=>'btn span2','style'=>'width:100px;display:none;margin-left:50px;float:left;')); ?>
                    </fieldset>
                     <?php $this->endWidget(); ?>
                    
                     <?php $form1 = $this->beginWidget('CActiveForm', array(
                        'id'=>'changepass-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array( 'onsubmit'=>"return false;", 'class'=>"form-horizontal", 'style'=>"display:none;"),
                        )); ?>
                     <fieldset style="margin-left: 30px;">
					  <input type="hidden" name="url_frm" id="url_frm" value="host" />
                        <div class="flash-error span6" id="error_pass" style="display: none;"></div>
						<div class="clear"></div>
                    <div class="control-group">
                                <?php echo $form1->labelEx($model,'oldpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'oldpass',array('class'=>'input-fluid validate[required,custom[password]] span3', 'name'=>'old_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'old_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'oldpass'); ?></span></label>
                                </div>
                            </div>
                         <div class="control-group">
                                <?php echo $form1->labelEx($model,'newpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'newpass',array('class'=>'input-fluid validate[required,custom[password]] span3', 'name'=>'new_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'new_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'newpass'); ?></span></label>
                                </div>
                            </div>
                     <div class="control-group">
                                <?php echo $form1->labelEx($model,'confirmpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'confirmpass',array('class'=>'input-fluid validate[required] span3', 'name'=>'confirm_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'confirm_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'confirmpass'); ?></span></label>
                                </div>
                            </div>
                            
                            <div class="span2">&nbsp </div>  
                              <p style="color:red;" class="labels_t">* Required Field<p>
				<div class="span1">&nbsp </div>  
                             <div class='ch_btn'>
                                 <?php echo CHtml::submitButton('Submit',array('id'=>'mybtnSubmit','tabindex'=>'17','class'=>'btn btn-primary','onclick'=>'return change_pass();','style'=>'width:100px;')); ?>
                                 <?php echo CHtml::Button('Cancel',array('id'=>'mybtnCancel','tabindex'=>'17','class'=>'btn','onclick'=>'cancel_pass();','style'=>'width:100px;')); ?>                               
                               </div>
                                </fieldset>
                        <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</section>