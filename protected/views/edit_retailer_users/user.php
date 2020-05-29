<head>

<style>
.input-fluid
{
width:90%;
float: left;
}
.row-fluid
[class*="span"]
{
margin-left:1.56%;
}
.spans
{
min-height:28px;
}
#sysdetails table td
{
 border: 1px solid #ddd;
 align:left;
 padding:3px;
}
</style>
</head>
<?php
	$client 	= Controller::companyDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$doc		= $client->getDoc($Company_ID);
	$sd 		= json_encode($doc);
	$gs 		= json_decode($sd, true);
	
	$user	 	= isset($edit_user) ? $edit_user : "";
	$client1 	= Controller::userDbconnection();
	$udocs	 	= $client1->getDoc($user);
	
	$role		= $udocs->profile->roles;
	$file=Yii::app()->params['salt'];
	if(file_exists($file)  && is_readable($file))
			{
			$data = file_get_contents($file);
			$arrdata = json_decode($data, true);
			$salt=md5($arrdata['Title']);
			}else
			{
				echo '<script type="text/javascript"> alert("'.basename($file).'is not Available in Config folder.");</script>';
				exit;
				}
	
	$status_list = array("active" => "Active", "inactive" => "Inactive", "initial" => "Initial");
	$udocs->status = isset($udocs->status) ? $udocs->status : "Inactive";
?>

	<div><h3>User Status Details</h3></div>
	<div class="span4 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz" for="STATUS" alt="Status"><?php echo Controller::customize_label('Status');?><span> *</span>:</label>
			<div class="controls">
				<?php echo CHtml::dropDownList('STATUS', '', $status_list, array('class'=>'validate[required] input-fluid', 'style' => 'height: 30px', 'tabindex' => 3, 'prompt' => 'Please select status', 'options' => array($udocs->status=>array('selected'=>true)))); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div><h3>User Details</h3></div>
	<fieldset>
	<div class="span4 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz in_custz" for="ROLE" alt="Role"><?php echo Controller::customize_label('SAP System');?><span> *</span>:</label>
				<div class="controls">
					<select id="SAP_SYSTEM" onchange="changethis(this)" data-placeholder="Select SAP Syatem"  class="spans input-fluid validate[required] "  tabindex="8" name="SAPSYSTEM" >
					<option value="Select Sap System">Select SAP System</option>
									<?php
									if(isset($doc->host_id))
									{
										foreach($doc->host_id as $key => $val)
										{
											$sel='';
											if(isset($udocs->system->host) && $udocs->system->host==$key)
											{
											$sel='selected="selected"';
											$vals=$val;
											}
											echo '<option value="'.$key.'" '.$sel.'>'.$val->Description.'</option>';
										}
									}	
									?>
					</select>
				</div>
		</div>
		<div class="control-group">
				<label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('SAP User ID');?><span> *</span>:</label>
				<div class="controls">
					<input alt="Company Name" type="text" class="input-fluid validate[required]" name="USER_NAME" onblur="addlogin(this.id);" tabindex="5" autocomplete="off" id="USER_NAME" value="<?php echo Controller::decryptIt($udocs->system->username,$salt); ?>">
				</div>
		</div> 
	</div>	
	<div class="span4 utopia-form-freeSpace myspace">
		<div class="control-group">
			<label class="control-label cutz in_custz" for="CLIENT_ID" alt="Client ID" ><?php echo Controller::customize_label('SAP Client ID');?><span> *</span>:</label>
			<div class="controls">
				<input alt="Client ID" type="text" class="input-fluid validate[required]" name="CLIENT_ID" tabindex="5" autocomplete="off" onblur="addlogin(this.id);" id="CLIENT_ID" value="<?php echo $udocs->system->client_id; ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('Password');?><span> *</span>:</label>
			<div class="controls">
				<input alt="First Name" type="password" class="input-fluid validate[required]" name="PASSWORD" tabindex="5" autocomplete="off" onblur="addlogin(this.id);" id="PASSWORD" value="<?php  echo Controller::decryptIt($udocs->system->password,$salt); ?>">
			</div>
		</div>
	</div>	
	<div  class="span10"  id="sysdetails" style="margin-left:6%;padding:3%">
							<?php if($vals!='')
									{
									$str='<table >';
									$th='<tr style="font-weight: bold">';
									$tb='<tr>';	
									
									foreach($vals as $key=>$val)
									{
										$th=$th.'<td>'.$key.'</td>';
										$tb=$tb.'<td>'.$val.'</td>';
									}	
									$th=$th.'</tr>';
									$tb=$tb.'</tr>';
									$str=$str.$th.$tb.'</table>';
									echo $str;
									}
							?>
					</div>
	</fieldset>
	<fieldset>
	<div class="span4 utopia-form-freeSpace myspace">
	<?php if($role!='emg_retailer_service') { ?>
					<div class="control-group">
					<label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('SoldToID');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid validate[required] " onblur="blurtext('customer');" name="SOLDTOID" tabindex="1" onKeyUp="jspt('SOLDTOID',this.value,event)" autocomplete="off" id="customer" value="<?php echo isset($udocs->soldtoid)?$udocs->soldtoid:''; ?>" disabled>
								<span class='minw'  >&nbsp;</span>
                            </div>
					</div>
					<?php } ?>
					<div class="control-group">
                            <label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' tabindex="9" autocomplete="off" id="EMAIL" value="<?php echo $udocs->login_id->email_id; ?>">
                            </div>
					</div>
					                      
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					<?php if($role!='emg_retailer_service') { ?>
						<div class="control-group">
                            <label class="control-label cutz" for="COMPANY_NAME" alt="Company Name"><?php echo Controller::customize_label('Company Name');?>:</label>
							<div class="controls">
                                <textarea alt="Company Name" type="text" class="input-fluid validate[required]" name="COMPANY_NAME" tabindex="5" autocomplete="off" id="COMPANY_NAME" value="<?php echo $udocs->company_name; ?>"  disabled><?php echo $udocs->company_name; ?></textarea>
                            </div>
						</div>
						<?php } ?>
					    <div class="control-group">
                            <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('First Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="First Name" type="text" class="input-fluid validate[required]" name="FIRST_NAME" tabindex="5" autocomplete="off" id="FIRST_NAME" value="<?php echo $udocs->profile->fname; ?>">
                            </div>
                        </div>
					</div>
						
						
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					<?php if($role!='emg_retailer_service') { ?>
					<div class="control-group">
                            <label class="control-label cutz" for="COMPANY_ADDRESS" alt="Company Address"><?php echo Controller::customize_label('Company Address');?><span> *</span>:</label>
							<div class="controls">
                                <textarea alt="Company Name" type="text" class="input-fluid validate[required]" name="COMPANY_ADDRESS" tabindex="5" autocomplete="off" id="COMPANY_ADDRESS" value="<?php $address=isset($udocs->company_address)?implode(',',$udocs->company_address):""; echo $address; ?>"  disabled><?php echo $address; ?></textarea>
                            </div>
					</div>
					<?php } ?>
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Last Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Last Name" type="text" class="input-fluid validate[required]" name="LAST_NAME" tabindex="6" autocomplete="off" id="LAST_NAME" value="<?php echo $udocs->profile->lname; ?>">
                            </div>
					</div>
					</div>
					
					<!--<div class="span10 utopia-form-freeSpace myspace" style="padding-left:10%">					
						//$this->renderPartial("roles",array('udocs'=>$udocs)); 					
                    </div><br/><br/>-->
					
			</fieldset>
			<fieldset style="padding-left:4.5%">
				<div><h3>User Features:</h3></div>
					<div class="span12 utopia-form-freeSpace myspace">
                        <div class="control-group" style="padding-left:11%" id="user_menus">
							<?php $this->renderPartial("roles",array('udocs'=>$udocs)) ?>
						</div>
					</div>
				</fieldset>