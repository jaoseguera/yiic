<!-- border:1px solid red; -->

	<div class="utopia-widget-content">
		<div class="row-fluid">
			<div class="utopia-widget-content">
				<div class="span8 utopia-form-freeSpace">
					<div class="sample-form form-horizontal">
						<div class="control-group" style="margin-left:7px;">
							<label class="control-label" for="input01" ><?=_SELECTSYSTEMTYPE?><span> *</span>:</label>
							<div class="controls sample-form-chosen">
								<select id='sys_types' onChange="select_system(this.value)">
									<option value=""><?=_SELECTSYSTEMTYPE?></option>
									<option value="ECC">ECC</option>
									<option value="BOBJ">BOBJ</option>
									<option value="CMS">CRM</option>
									<option value="RTD">GTS</option>
								</select>
							</div>
						</div>
						<!---------------------------------------------------------------------------------------------->
						<?php
							$form = $this->beginWidget('CActiveForm',
								array(
									'id' => 'ecc-form',
									'enableAjaxValidation' => false,
									'htmlOptions' => array('onsubmit' =>"return false;", 'class' => "form-horizontal span6 create_account ECC sys_t", 'style' => 'margin-top:5px;display:none;'),
								)
							);
						?>
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="select02"><?=_CONNECTIONTYPE?><span> *</span>:</label>
								<div class="controls sample-form-chosen">
									<select id="cont_type" data-placeholder="Select your Language" style="min-width:230px" class="validate[required] select_box" name="cont_type" onChange="cont_types(this.value)">
										<option value=" "><?=_SELECTCONNECTIONTYPE?></option>
										<option value="cust"><?=_CUSTOMPPLICATIONSERVER?></option>
										<option value="grp"><?=_GROUPSERVERSELECTION?></option>
									</select>
								</div>
							</div>
							<div class="control-group comm" style="display:none">
								<?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'description', array('class' => 'input-fluid validate[required] emt', 'name' => 'description', 'placeholder' => '',  'id' => 'description')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'description'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group cust" style="display:none">
								<?php echo $form->labelEx($model, 'applicationserver', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'applicationserver', array('class' => 'input-fluid validate[required] emt', 'name' => 'host', 'placeholder' => '',  'id' => 'host')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'applicationserver'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group cust" style="display:none">
								<?php echo $form->labelEx($model, 'routingstring', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'routingstring', array('class' => 'input-fluid  emt', 'name' => 'routing_string', 'placeholder' => '',  'id' => 'routing_string')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'routingstring'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group cust" style="display:none">
								<?php echo $form->labelEx($model, 'routerport', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'routerport', array('class' => 'input-fluid  emt', 'name' => 'router_port', 'placeholder' => '',  'id' => 'router_port')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'routerport'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group cust" style="display:none">
								<?php echo $form->labelEx($model, 'systemnum', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'systemnum', array('class' => 'input-fluid validate[required] emt', 'name' => 'system_num', 'placeholder' => '',  'id' => 'system_num')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'systemnum'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group comm" style="display:none">
								<?php echo $form->labelEx($model, 'systemid', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'systemid', array('class' => 'input-fluid validate[required] emt', 'name' => 'system_id', 'placeholder' => '',  'id' => 'system_id')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'systemid'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group cust" style="display:none">
								<?php echo $form->labelEx($model, 'bapiversion', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'bapiversion', array('class' => 'input-fluid validate[required] emt', 'name' => 'bapiversion', 'placeholder' => '',  'id' => 'bapiversion')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'bapiversion'); ?></span>
									</label>
								</div>
							</div>
							<!---------------------------------------------------------------------->
							<div class="control-group grp" style="display:none">
								<?php echo $form->labelEx($model, 'messageserver', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'messageserver', array('class' => 'input-fluid validate[required] emt', 'name' => 'messageserver', 'placeholder' => '',  'id' => 'messageserver')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'messageserver'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group grp" style="display:none">
								<?php echo $form->labelEx($model, 'group', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'group', array('class' => 'input-fluid validate[required] emt', 'name' => 'group', 'placeholder' => '',  'id' => 'group')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'group'); ?></span>
									</label>
								</div>
							</div>
							<div class="control-group grp" style="display:none">
								<?php echo $form->labelEx($model, 'bapiversion', array('class' => 'control-label')); ?>
								<div class="controls">
									<label>
										<?php echo $form->textField($model, 'bapiversion', array('class' => 'input-fluid validate[required] emt', 'name' => 'bapiversion', 'placeholder' => '',  'id' => 'bapiversion')); ?>
										<span style="color:red;"><?php echo $form->error($model, 'bapiversion'); ?></span>
									</label>
								</div>
							</div>
							<!------------------------------------------------>
							<div class="control-group comm" style="margin-top:-10px;display:none">
								<label class="control-label" for="select02">Language<span> *</span>:</label>
								<div class="controls sample-form-chosen">
									<select id="language" data-placeholder="Select your Language" style="min-width:230px" class="validate[required] select_box" name="lang" >
										<option value=""><?=_SELECTLANGUAGE?></option>
										<option value="EN" selected><?=_ENGLISH?></option>
									</select>
								</div>
							</div>
							<div class="control-group comm" style="display:none">
								<label class="control-label" for="select02"> <?=_EXTENDED?> :</label>
								<div class="controls">
									<input id="extension" value="off" type="checkbox" name="extension" >
								</div>
							</div>
							<div class='span3'></div>
							<div class="ipad_btn comm" style="display:none;">
								<table class="bbo">
									<tr>
										<td>
											<?php echo CHtml::submitButton(_SAVECHANGES, array('id' => 'ahide', 'class' => 'diab btn btn-primary', 'style' => 'width:120px;')); ?>
											<?php echo CHtml::Button(_SAVECHANGES, array('id' => 'bhide',  'class' => 'diab btn', 'style' => 'width:100px;display:none;')); ?>
										</td>
										<td>&nbsp;&nbsp;</td>
										<td>
											<?php echo CHtml::Button(_CANCEL, array('id' => 'bhide',  'class' => 'btn ', 'style' => 'width:100px;', 'onClick' => 'shows("avl_sys")')); ?>
										</td>
									</tr>
								</table>
							</div>
						</fieldset>
						<?php $this->endWidget(); ?>
						<!------------------------------------------------------------------------------------------------------------------->
						<form class="validation form-horizontal span6 create_account BOBJ sys_t" action="javascript:exten_bi()" style="margin-top:5px;display:none;">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="input01" ><?=_DESCRIPTION?><span> *</span>:</label>
									<div class="controls">
										<input id="bi_description" class="input-fluid validate[required] emt" type="text" name="description">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01" ><?=_BOBJSYSTEMURL?><span> *</span>:</label>
									<div class="controls">
										<input id="bi_system_url" class="input-fluid validate[required,custom[url]] emt" type="text" name="system_url">
									</div>
									<div  class="note_ip" id="note_bi"><?=_NOTEPLEASEURLFORMAT?> http://hostname:portnumber</div>
								</div>
								<div class="control-group exten_bobj">
									<label class="control-label" for="input01" ><?=_CMSNAME?><span> *</span>:</label>
									<div class="controls">
										<input id="cms_name" class="input-fluid validate[required] emt emt_bobj" type="text" name="cms_name">
									</div>
								</div>
								<div class="control-group exten_bobj">
									<label class="control-label" for="input01" ><?=_CMSPORT?><span> *</span>:</label>
									<div class="controls">
										<input id="cms_port" class="input-fluid validate[required]] emt emt_bobj" type="text" name="cms_port">
									</div>
								</div>
								<div class="control-group exten_bobj">
									<label class="control-label" for="input01" ><?=_AUTHTYPE?><span> *</span>:</label>
									<div class="controls sample-form-chosen">
										<select name="auth_type" id="auth_type" class="validate[required] emt_bobj">
											<option value="" ><?=_SELECTAUTHTYPE?></option>
											<option value="secEnterprise">secEnterprise</option>
											<option value="secLDAP">secLDAP</option>
											<option value="secWinAD">secWinAD</option>
											<option value="secSAPR3">secSAPR3</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01" ><?=_EXTENDED?>:</label>
									<div class="controls">
										<input id="extented_bobj" class="input-fluid  emt" type="checkbox" name="extented">
									</div>
								</div>
								<div style='color:red;' class="note_sso">
									<?=_NOTEIDCOMPLETED?>
								</div>
								<div class='span3'></div>
								<div class="ipad_btn">
									<table class="bbo">
										<tr>
											<td>
												<button class='diab btn btn-primary' style="width:120px;" type='submit'  id="ahide_bi"><?=_SAVECHANGES?></button>
												<button class='diab btn' type='button' style="width:100px;display:none;" id="bhide_bi" ><?=_EXTENDED?></button>
											</td>
											<td>&nbsp;&nbsp;</td>
											<td>
												<button class="btn " style="width:100px;" onClick="shows('avl_sys')" type='button'><?=_CANCEL?></button>
											</td>
										</tr>
									</table>
								</div>
							</fieldset>
						</form>
						<!-----------------------------------------------------------------CMS------------------------------------------>
						<form class="validation form-horizontal span6 create_account CMS sys_t" action="javascript:exten_bi1()" style="margin-top:10px;display:none;" >
							<fieldset >
							<?=_COMINGSOON?>
							</fieldset>
						</form>
						<!-----------------------------------------------------------------RGB------------------------------------------>
						<form class="validation form-horizontal span6 create_account RTD sys_t" action="javascript:exten_bi2()" style="margin-top:10px;display:none;" >
							<fieldset >
								<?=_COMINGSOON?>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div style="margin-top:-10px;float:left;margin-left:60px;" ><span style='color:red;'> *</span> <?=_REQUIREDFIELD?> </div><br>
		<!---<div style='color:red;'>Given password here will not be saved, it will be used only to validate the system.</div>-->
	</div>

