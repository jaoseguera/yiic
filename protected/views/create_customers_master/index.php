<?php // This is a Proof-of-Concept version that has not been reviewed. ?>
<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_customers_master/createcustomer', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
            
            var msg=$.trim(spt[0])
            if(msg=='S')
            {
				jAlert(spt[1], 'Message');
                $('#validation input:text').val("");
            }else
				jAlert(spt[1],'Message');
        }
    });

    $('#validation input').each(function(index, element) 
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
</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php
$customize = $model;
?><section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal" >
                <div class="span5 utopia-form-freeSpace myspace" >
                    <fieldset class="marg">
                        <div class="control-group">
                            <input type="hidden" name="url" value="create_customers_master"/>
                            <label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid  validate[required,custom[onlyLetterSp]]" name="I_NAME" tabindex="1" onKeyUp="jspt('I_NAME',this.value,event)" autocomplete="off" id="I_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="House No"><?php echo Controller::customize_label('House No');?><span> &nbsp;</span>:</label>
                            <div class="controls">
                                <input alt="House No" type="text" class="input-fluid" style='height:18px;' name='I_HOUSE_NO' tabindex="2" onKeyUp="jspt('I_HOUSE_NO',this.value,event)" autocomplete="off" id="I_HOUSE_NO">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Street');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Street" type="text" class="input-fluid validate[required]" style='height:18px;' name='I_STREET' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" id="I_STREET">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="City"><?php echo Controller::customize_label('City');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="City" type="text" class="input-fluid validate[required,custom[onlyLetterSp]] " name='I_CITY' tabindex="3" onKeyUp="jspt('I_CITY',this.value,event)" autocomplete="off" id="I_CITY">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Zip"><?php echo Controller::customize_label('Postal Code');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Zip" type="text" class="input-fluid validate[required]" name='I_ZIP' tabindex="4" onKeyUp="jspt('I_ZIP',this.value,event)" autocomplete="off" id="I_ZIP">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="State"><?php echo Controller::customize_label('State');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="State" type="text" class="input-fluid validate[required,custom[onlyLetterSp]] " name='I_STATE' tabindex="5" onKeyUp="jspt('I_STATE',this.value,event)" autocomplete="off" id="I_STATE">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="span5 utopia-form-freeSpace myspace rid" >
                    <fieldset>
                        <div class="control-group" >
                            <label class="control-label cutz" for="select02" alt="Select Country"><?php echo Controller::customize_label('Country');?><span> *</span>:</label>
                            <div class="controls sample-form-chosen">
                                <select id="select02" data-placeholder="Select your country"  class="select_box validate[required]" tabindex="6" name="I_COUNTRY" >
                                    <option value="">Select Your Country</option>
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
                                    <option value="CI">Cote d'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curacao</option>
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
                                    <option value="RE">Reunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barth�lemy</option>
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
                                    <option value="US" selected >United States</option>
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
                            <label class="control-label cutz" for="select02" alt="Language"><?php echo Controller::customize_label('Language');?><span> *</span>:</label>
                            <div class="controls sample-form-chosen">
                                <select id="language" data-placeholder="Select your Language"  class="select_box validate[required]" tabindex="7" name="I_SPRAS" >
                                    <option value="">Select Your Language</option>
                                    <option value="EN" selected>English</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="input01" alt="Sales Organization"><?php echo Controller::customize_label('Sales Organization');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Sales Organization" type="text" class="input-fluid validate[required,custom[salesorder]] radius" name='I_SALES_ORG' id='I_SALES_ORG' tabindex="7" onKeyUp="jspt('I_SALES_ORG',this.value,event)" autocomplete="off">
                               <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','I_SALES_ORG','0')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Sales Organization', 'I_SALES_ORG', 'sales_org')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="inputError" alt="Distribution Channel"><?php echo Controller::customize_label('Distribution Channel');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Distribution Channel" type="text" class="input-fluid validate[required,custom[dis]] radius" name='I_DIST_CHAN'  id='I_DIST_CHAN' tabindex="8" onKeyUp="jspt('I_DIST_CHAN',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','I_DIST_CHAN','1')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Distribution Channel', 'I_DIST_CHAN', 'dist_chan')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="date" alt="Division"><?php echo Controller::customize_label('Division');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Division" type="text" class="input-fluid validate[required,custom[divi]] radius"  name="I_DIVISION" id='I_DIVISION' tabindex="9" onKeyUp="jspt('I_DIVISION',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','I_DIVISION','2')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Division', 'I_DIVISION', 'division')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                    </fieldset>
                </div>
				<div class="clear"></div>
                <div class="span3">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span" type="submit" id="subt" tabindex="10">Submit</button>
                        <br><br><br><br>
                    </div>
                </div>        
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
</script>