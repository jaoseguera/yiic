<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_company/createcompany', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Created Successfully")
			{
				$('#validation input:text, #validation input:password, #validation select').val("");
				$('#ROLE').val("Primary");
			}
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
	$state_list = Controller::getStateList();
	$country_list = Controller::getCountryList();
	$cmp_id = Controller::generateRandomString();
	
	/*$client = Controller::couchDbconnection();
	$doc	= $client->getDoc('menus');
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	unset($gs['_id']);
	unset($gs['_rev']);
	//print_r($gs['dashboard']);

	$mnu = array();
	$l0 = $l1 = $l2 = 0;

	foreach($gs['dashboard'] as $key => $val)
	{
		if(!isset($val['href']))
		{
			$l1 = 1;
			foreach($val as $key1 => $val1)
			{
				$lvl2[$key][$l1] = $key1;
				if(is_array($val1))
				{
					if(!isset($val1['href']))
					{
						$l2 = 0;
						foreach($val1 as $key2 => $val2)
						{
							$lvl2[$key][$key1][$l2] = $key2;
							$l2++;
						}
					}
				}
				$l1++;
			}
		}
		$l0++;
	}
	echo "<pre>";
	print_r($lvl2);
	echo "</pre>";
	
	$Company_ID	= Yii::app()->user->getState("company_id");
	$client1 = Controller::companyDbconnection();
	$docs	 = $client1->getDoc($Company_ID);
	$docs->role->Regular 	= $lvl2;
	//$result = $client1->storeDoc($docs);*/
?><section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div><h3>Company Details</h3></div>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="I_COMPANY" alt="Company ID" ><?php echo Controller::customize_label('Company ID');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Company ID" type="text" class="input-fluid validate[required]" name="I_COMPANY" tabindex="1" onKeyUp="jspt('I_COMPANY',this.value,event)" autocomplete="off" id="I_COMPANY" value="<?php echo $cmp_id; ?>" readonly>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="I_NAME" alt="Name" ><?php echo Controller::customize_label('Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Name" type="text" class="input-fluid validate[required]" name="I_NAME" tabindex="2" onKeyUp="jspt('I_NAME',this.value,event)" autocomplete="off" id="I_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="HOUSE_NO" alt="House No" ><?php echo Controller::customize_label('Address Line 1');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="House No" type="text" class="input-fluid validate[required]" name="HOUSE_NO" tabindex="2" onKeyUp="jspt('HOUSE_NO',this.value,event)" autocomplete="off" id="HOUSE_NO">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="STREET" alt="Street" ><?php echo Controller::customize_label('Address Line 2');?>:</label>
                            <div class="controls">
                                <input alt="Street" type="text" class="input-fluid" name="STREET" tabindex="2" onKeyUp="jspt('STREET',this.value,event)" autocomplete="off" id="STREET">
                            </div>
                        </div>
					</div>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz" for="COUNTRY" alt="Country"><?php echo Controller::customize_label('Country');?><span> *</span>:</label>
                            <div class="controls">
								<?php echo CHtml::dropDownList('COUNTRY', '', $country_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select country')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="STATE" alt="State"><?php echo Controller::customize_label('State');?><span> *</span>:</label>
                            <div class="controls">
								<?php echo CHtml::dropDownList('STATE', '', $state_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select state')); ?>
                                <!--<input alt="State" type="text" class="input-fluid validate[required]" style='height:18px;' name='STATE' tabindex="3" onKeyUp="jspt('STATE',this.value,event)" autocomplete="off" id="STATE">-->
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="CITY" alt="City"><?php echo Controller::customize_label('City');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="City" type="text" class="input-fluid validate[required]" style='height:18px;' name='CITY' tabindex="3" onKeyUp="jspt('CITY',this.value,event)" autocomplete="off" id="CITY">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="ZIP_CODE" alt="Zip Code"><?php echo Controller::customize_label('Zip Code');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Zip Code" type="text" class="input-fluid validate[required]" style='height:18px;' name='ZIP_CODE' tabindex="3" onKeyUp="jspt('ZIP_CODE',this.value,event)" autocomplete="off" id="ZIP_CODE">
                            </div>
                        </div>
					</div>
				</fieldset>
				<div class="clear"></div>
				<fieldset>
					<div><h3>Primary Admin User</h3></div>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('First Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="First Name" type="text" class="input-fluid validate[required]" name="FIRST_NAME" tabindex="5" autocomplete="off" id="FIRST_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Last Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Last Name" type="text" class="input-fluid validate[required]" name="LAST_NAME" tabindex="6" autocomplete="off" id="LAST_NAME">
                            </div>
                        </div>
                        <!--<div class="control-group">
                            <label class="control-label cutz in_custz" for="GENDER" alt="Gender" ><?php //echo Controller::customize_label('Gender');?><span> *</span>:</label>
                            <div class="controls">
								<select id="GENDER" data-placeholder="Select your gender"  class="input-fluid validate[required] minw1 read select_box1"  tabindex="7" name="GENDER" style="height:30px;">
									<option value=""></option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select><br/>
                            </div>
                        </div>-->
					</div>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Role');?><span> *</span>:</label>
                            <div class="controls">
								<select id="ROLE" data-placeholder="Select your role"  class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="ROLE" style="height:30px;">
									<option value="Primary">Primary</option>
								</select><br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' tabindex="9" autocomplete="off" id="EMAIL">
                            </div>
                        </div>
                        <!--<div class="control-group">
                            <label class="control-label cutz" for="PASSWORD" alt="Password"><?php //echo Controller::customize_label('Password');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Password" type="password" class="input-fluid validate[required]" style='height:18px;' name='PASSWORD' tabindex="10" autocomplete="off" id="PASSWORD">
                            </div>
                        </div>-->
					</div>
				</fieldset>
				<fieldset>
					<div><h3>Company Features</h3></div>
					<div class="span12 utopia-form-freeSpace myspace">
                        <div class="control-group" id="user_menus">
							<?php $this->renderPartial("roles"); ?>
						</div>
					</div>
				</fieldset>
				<div class="clear"></div>
                <div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span3" type="submit" id="subt" tabindex="11">Submit</button>
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