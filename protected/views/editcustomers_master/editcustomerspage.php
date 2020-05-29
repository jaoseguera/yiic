
<script>
// This is a Proof-of-Concept version that has not been reviewed.
$(document).ready(function() {
    $('.ALL').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.chkSelect').each(function() { //loop through each checkbox
                this.checked = true; 
				var cls=this.value;
				$('.'+cls).attr("readonly", false);
				//select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.chkSelect').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1" 
				var cls=this.value;
			$('.'+cls).attr("readonly", true);				
            });        
        }
    });
	$('.chkSelect').change(function(){
	
	if(this.checked==true)
	{
	var cls=this.value;
	$('.'+cls).attr("readonly", false);
	}else
	{
	var cls=this.value;
	$('.'+cls).attr("readonly", true);
	
	}
	
	});
   
});
function changeedit()
{
$('#li_1').removeClass("active");
$('#li_2').addClass("active");
$('#tab41').css({display:'none'}); 
$('#tab42').css({display:'block'});	
$('#tab41').removeAttr("data-toggle","tab");

}
$(document).ready(function() {
    jQuery("#validation1").validationEngine();
    $(".read").attr('readonly','readonly');
	if($('#save_id').length<0)
	{
		$(".ALL").attr('readonly','readonly');
		$(".chkSelect").attr('readonly','readonly');
	}	
});
function cancels() { $('#calt').hide(); }
function edit_customer()
{
    $("#validation1").validationEngine();
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	var cust=$('#CUSTOMER_ID').val();
    $.ajax({type:'POST',
            url: 'Editcustomers_master/edit_customers', 
            data:$('#validation1').serialize()+'&CUST='+cust, 
            success: function(response) {
                    $('#loading').hide();
                    $("body").css("opacity","1"); 
                   var spt=response.split("@");
					var msg=$.trim(spt[0]);
					if(msg=='S')
                    {
						jAlert(spt[1], 'Message',function(){
						$(".read").attr('readonly','readonly');
						changeedit();
						});
					}else
						jAlert(spt[1], 'Error');
			}
			
    });
}
function ss()
{
	$(".read").removeAttr('readonly');
	$('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">Save</button>');
	$('#can_id').show();
}
</script>
<style>.top { background-image: url("<?php echo Yii::app()->request->baseUrl; ?>/images/tab_head.png") !important; }
/*.head_icons { width: 951px !important;}*/</style>
<?php 
if(isset($_SESSION['edit_cus_mas'][0]['NAME']))
{
foreach($_SESSION['edit_cus_mas'] as $hs=>$ej)
{	?>

	<div id="editcustomers_page" style=""><section id='utopia-wizard-form' class="utopia-widget cancel editcustomers_page" style="border:none;">
			<div class="utopia-widget-content">
				<form id="validation1" action="javascript:edit_customer()" class="form-horizontal editcus" >
					<input type="hidden" name="bapiName" value="BAPI_CUSTOMER_CHANGEFROMDATA"/>
					<input type="hidden" name="CUSTOMERNO" value="<?php echo $ej['CUSTOMER'];?>"/>
					<div class="span6 utopia-form-freeSpace myspace1" id="leftform">
					<fieldset> 
					
						<div class="control-group">
						
						<div class="controls">
						<label class="control-label cutz" for="input01" alt='Name'><h3>Existing Data</h3></label>
						<br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='Name'><?php echo Controller::customize_label('Name');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid validate[required] minw1  read" type="text" name='NAME_OLD'  value='<?php echo $ej['NAME'];?>'>
						<br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="Houseno" alt='House No'><?php echo Controller::customize_label('House No');?>:</label>
						<div class="controls">
						<input class="input-fluid  minw1 read" type="text"  name="HOUSE_NO_OLD"  value="<?php echo $ej['HOUSE_NO'];?>"> <br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="inputError" alt='Street'><?php echo Controller::customize_label('Street');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid minw1 read" type="text" name='STREET_OLD' value="<?php echo $ej['STREET'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='Postal Code'><?php echo Controller::customize_label('Postal Code');?><span>*</span>:</label>
						<div class="controls">
						<input class="input-fluid minw1 read" type="text"  name="POSTL_CODE_OLD"  value="<?php echo $ej['POSTL_COD1'];?>"> <br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='City'><?php echo Controller::customize_label('City');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid minw1 read" type="text" name="CITY_OLD" value="<?php echo $ej['CITY'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='State'><?php echo Controller::customize_label('State');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid minw1 read" type="text" name='REGION_OLD'value="<?php echo $ej['REGION']; ?>"><br/>
						</div>
						</div>
						<div class="control-group ">
								<label class="control-label cutz" for="select02" alt='Country'><?php echo Controller::customize_label('Country');?><span>*</span>:</label>
								
								<div class="controls">
								<input type="text" name='COUNTRY_OLD' id='COUNTRY_OLD' readonly  class="input-fluid  getval radius " value="<?php echo $ej['COUNTRY'];?>"/>
							
							</div>
															</div>
							
						
							
					</fieldset></div>
					
					<div class="span2 utopia-form-freeSpace myspace1" >
					<fieldset>
					<div class="control-group" style="margin-top:-10px;">
						<span style="margin-left:-20px;"><b>Select All</b></span> <br/> <input  type="checkbox" class="ALL"  value="ALL"  name='ALL' >
						</div>
					<div class="control-group" style="margin-top:30px">
						<input  type="checkbox"    name='chkSelect' class="chkSelect" value="NAME" >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input   type="checkbox" name='chkSelect' class="chkSelect" value="HOUSE_NO">
						</div>
					<div class="control-group" style="margin-top:30px">
						<input    type="checkbox" class="chkSelect" value="STREET" name='chkSelect' />
						</div>
					<div class="control-group" style="margin-top:30px">
						<input    type="checkbox" name='CHKPCODE' value="POSTL_CODE" class="chkSelect"  >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input   class="chkSelect" type="checkbox" value="CITY" name='chkSelect' >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input   class="chkSelect" type="checkbox" value="REGION" name='chkSelect' >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input  class="chkSelect" type="checkbox"  value="COUNTRY" name='chkSelect' >
					</div>
					
					
					
					</fieldset>
					</div>
					<div class="span4 utopia-form-freeSpace myspace1" style="margin-left:-40px;">
					
					<fieldset>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='Name'><h3>Proposed Data</h3></label>
						<br/>
						
						</div>					
						
						<div class="control-group">
						
						<input  class="input-fluid minw1 validate[required] NAME" placeholder="New Name" type="text" name='NAME_NEW' readonly value='<?php echo $ej['NAME'];?>'>
						
						
						</div>
						<div class="control-group">
						<input  class="input-fluid minw1 HOUSE_NO" type="text" name='HOUSE_NO_NEW' placeholder="New House No" readonly value="<?php echo $ej['HOUSE_NO'];?>">
						
						</div>
						<div class="control-group">
						<input  class="input-fluid minw1 validate[required] STREET" type="text" name='STREET_NEW' placeholder="New Steet" readonly value="<?php echo $ej['STREET'];?>">
						
						</div>
						<div class="control-group">
						<input class="input-fluid minw1 validate[required] POSTL_CODE" type="text"  name="POSTL_CODE_NEW" placeholder="New PostalCode" readonly value="<?php echo $ej['POSTL_COD1'];?>"> 
						
						</div>
						<div class="control-group">
						<input  class="input-fluid validate[required]  minw1 CITY" type="text" placeholder="New City" readonly name="CITY_NEW" value="<?php echo $ej['CITY'];?>">
						
						</div>
						<div class="control-group">
						<input  class="input-fluid validate[required] minw1 REGION" type="text" readonly placeholder="New Region" name='REGION_NEW' value="<?php echo $ej['REGION'];?>">
						
						</div>
						<div class="control-group sample-form-chosen">
							<!--	<div class=" sample-form-chosen" >-->
									<select id="select02" data-placeholder="Select your country"  class="input-fluid validate[required] minw1 read select_box1 COUNTRY"  tabindex="7"  name="COUNTRY_NEW" style="height:30px;">
										<option value="<?php echo $ej['COUNTRY'];?>"><?php echo $ej['COUNTRY'];?></option>
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
										<option value="BL">Saint Barth?lemy</option>
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

							
					</fieldset></div>
					
					
					<div class="span12 utopia-form-freeSpace bbr" style="padding-bottom:10px;"id="bottomform">
						<div style="padding-left:20%">
							<table><tr><td>&nbsp;</td><td>
							<table><tr><td><button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">Submit</button></td><td>&nbsp;</td>
							<td><button class="btn spanbt span2" type="button" id="can_id" style="min-width:60px;" onclick="return changeedit()">Cancel</button></td></tr>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section></div><?php  
} 
}else
echo 'No Record Found.';
?>