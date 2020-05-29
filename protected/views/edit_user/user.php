<?php
	$client 	= Controller::companyDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$doc		= $client->getDoc($Company_ID);
	$sd 		= json_encode($doc);
	$gs 		= json_decode($sd, true);
	
	$user	 	= isset($edit_user) ? $edit_user : "";
	$client1 	= Controller::userDbconnection();
	$udocs	 	= $client1->getDoc($user);
	// $roles		= array('Admin', 'Regular');
	$roles		= array('Admin');
	$role		= $udocs->profile->roles;
	
	$status_list = array("active" => "Active", "inactive" => "Inactive", "initial" => "Initial");
	$udocs->status = isset($udocs->status) ? $udocs->status : "active";
?>
<fieldset>
	<div><h3>User Status Details</h3></div>
	<div class="span5 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz" for="STATUS" alt="Status"><?php echo Controller::customize_label('Status');?><span> *</span>:</label>
			<div class="controls">
				<?php echo CHtml::dropDownList('STATUS', '', $status_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select status', 'options' => array($udocs->status=>array('selected'=>true)))); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div><h3>User Details</h3></div>
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
				<select id="ROLE" data-placeholder="Select your role"  class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="ROLE" style="height:30px;">
					<option value=""></option>
					<?php
						foreach($roles as $key => $val)
						{
							if($val == $role)
								echo '<option selected value="'.$val.'">'.$val.'</option>';
							else
								echo '<option value="'.$val.'">'.$val.'</option>';
						}
						/*
						foreach($gs['roles'] as $key => $val)
						{
							if($key != "Regular")
							{
								if($key == $role)
									echo '<option selected value="'.$key.'">'.$key.'</option>';
								else
									echo '<option value="'.$key.'">'.$key.'</option>';
							}
						}
						*/
						foreach($gs['roles'] as $key => $val)
						{
							if($key == $role)
								echo '<option selected value="'.$key.'">'.$key.'</option>';
							else
								echo '<option value="'.$key.'">'.$key.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' readonly tabindex="9" autocomplete="off" value="<?php echo $udocs->login_id->email_id; ?>" id="EMAIL">
			</div>
		</div>
	</div>
</fieldset>