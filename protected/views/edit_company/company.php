<?php
	$state_list = Controller::getStateList();
	$country_list = Controller::getCountryList();
	$Company 	= isset($edit_company) ? $edit_company : "";
	$client  	= Controller::companyDbconnection();
	$docs	 	= $client->getDoc($Company);
	$user		= $docs->primary_user;
	$client1 	= Controller::userDbconnection();
	$udocs	 	= $client1->getDoc($user);
	$status_list = array("active" => "Active", "inactive" => "Inactive");
	$docs->status = isset($docs->status) ? $docs->status : "active";
?>
<fieldset>
	<div><h3>Company Status Details</h3></div>
	<div class="span5 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz" for="STATUS" alt="Status"><?php echo Controller::customize_label('Status');?><span> *</span>:</label>
			<div class="controls">
				<?php echo CHtml::dropDownList('STATUS', '', $status_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select status', 'options' => array($docs->status=>array('selected'=>true)))); ?>
			</div>
		</div>
	</div>
</fieldset>
<div class="clear"></div>
<fieldset>
	<div><h3>Company Details</h3></div>
	<div class="span5 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz in_custz" for="I_COMPANY" alt="Company ID" ><?php echo Controller::customize_label('Company ID');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Company ID" type="text" class="input-fluid validate[required]" name="I_COMPANY" tabindex="1" onKeyUp="jspt('I_COMPANY',this.value,event)" autocomplete="off" value="<?php echo $Company; ?>" readonly id="I_COMPANY">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz in_custz" for="I_NAME" alt="Name" ><?php echo Controller::customize_label('Name');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Name" type="text" class="input-fluid validate[required]" name="I_NAME" tabindex="2" onKeyUp="jspt('I_NAME',this.value,event)" autocomplete="off" value="<?php echo $docs->name; ?>" id="I_NAME">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz in_custz" for="HOUSE_NO" alt="House No" ><?php echo Controller::customize_label('Address Line 1');?><span> *</span>:</label>
			<div class="controls">
				<input alt="House No" type="text" class="input-fluid validate[required]" name="HOUSE_NO" tabindex="2" onKeyUp="jspt('HOUSE_NO',this.value,event)" autocomplete="off" id="HOUSE_NO" value="<?php echo $docs->houseno; ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz in_custz" for="STREET" alt="Street" ><?php echo Controller::customize_label('Address Line 2');?>:</label>
			<div class="controls">
				<input alt="Street" type="text" class="input-fluid" name="STREET" tabindex="2" onKeyUp="jspt('STREET',this.value,event)" autocomplete="off" id="STREET" value="<?php echo $docs->street; ?>">
			</div>
		</div>
	</div>
	<div class="span5 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz" for="COUNTRY" alt="Country"><?php echo Controller::customize_label('Country');?><span> *</span>:</label>
			<div class="controls">
				<?php echo CHtml::dropDownList('COUNTRY', '', $country_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select country', 'options' => array($docs->country=>array('selected'=>true)))); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz" for="STATE" alt="State"><?php echo Controller::customize_label('State');?><span> *</span>:</label>
			<div class="controls">
				<?php echo CHtml::dropDownList('STATE', '', $state_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select state', 'options' => array($docs->state=>array('selected'=>true)))); ?>
				<!--<input alt="State" type="text" class="input-fluid validate[required]" style='height:18px;' name='STATE' tabindex="3" onKeyUp="jspt('STATE',this.value,event)" autocomplete="off" id="STATE">-->
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz" for="CITY" alt="City"><?php echo Controller::customize_label('City');?><span> *</span>:</label>
			<div class="controls">
				<input alt="City" type="text" class="input-fluid validate[required]" style='height:18px;' name='CITY' tabindex="3" onKeyUp="jspt('CITY',this.value,event)" autocomplete="off" value="<?php echo $docs->city; ?>" id="CITY">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz" for="ZIP_CODE" alt="Zip Code"><?php echo Controller::customize_label('Zip Code');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Zip Code" type="text" class="input-fluid validate[required]" style='height:18px;' name='ZIP_CODE' tabindex="3" onKeyUp="jspt('ZIP_CODE',this.value,event)" autocomplete="off" value="<?php echo $docs->zip; ?>" id="ZIP_CODE">
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
				<input alt="First Name" type="text" class="input-fluid validate[required]" name="FIRST_NAME" tabindex="5" autocomplete="off" value="<?php echo $udocs->profile->fname; ?>" id="FIRST_NAME">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Last Name');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Last Name" type="text" class="input-fluid validate[required]" name="LAST_NAME" tabindex="6" autocomplete="off" value="<?php echo $udocs->profile->lname; ?>" id="LAST_NAME">
			</div>
		</div>
	</div>
	<div class="span5 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Role');?><span> *</span>:</label>
			<div class="controls">
				<select id="ROLE" data-placeholder="Select your role" class="input-fluid validate[required] minw1 read select_box1" tabindex="8" name="ROLE" style="height:30px;">
					<option value="Primary">Primary</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' tabindex="9" autocomplete="off" value="<?php echo $udocs->login_id->email_id; ?>" id="EMAIL">
			</div>
		</div>
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