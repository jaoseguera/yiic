<?php
	$j = 0;
	$titles = array(
		'Description' => _DESCRIPTION,
		'Host' => _APPLICATIONSERVER,
		'Router_String' => _ROUTERIP.' / '._STREETADDRESS,
		'Router_Port' => _ROUTERPORT,
		'System_Number' => _INSTANCENUMBER,
		'System_ID' => _SYSTEMID,
		'Language' => _LANGUAGE,
		'Extension' => _EXTENDED,
		'System_URL' => _SYSTEMURL,
		'CMS_Name' => _CMSNAME,
		'CMS_Port' => _CMSPORT,
		'Auth_Type' => _AUTHTYPE,
		'Bapiversion'=>_BAPIVERSION,
		'Messageserver' => _MESAGGESERVER,
		'Group' => _GROUP
	);

	foreach($hosts as $vau => $jw)
	{
		for($i = $count - 1; $i >= 0; $i--)
			$if[] = $i;

		$value = "";
		if ($jw != 'none')
		{
			foreach($jw as $hs => $he)
				$value.=$he . ",";
			?>
			<section class="utopia-widget utopia-form-box section edit_sys" style="display:none;" id="<?php echo $vau; ?>_edit">
				<div class="utopia-widget-title">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
					<span>Edit <?php echo $jw['Description']; ?> <?=_DETAILS?></span>
				</div>
				<div class="utopia-widget-content" style="background:#fff;">
					<?php
						if($jw['System_type'] == 'ECC')
							$js_fun = "javascript:ajax_edit('".$vau."','".$if[$j]."')";
						else
							$js_fun = "javascript:ajax_edit_bi('".$vau."','".$if[$j]."')";
					?>
					<form id="form<?php echo $vau ?>" action="<?php echo $js_fun; ?>" class="validation form-horizontal create_account" style="margin-top:15px;">
						<?php
						foreach($jw as $hs => $he)
						{
							if($hs != 'System_type')
							{
								if($hs == 'Connection_type')
								{
									?>
									<input type="hidden" value="<?php echo $he; ?>" class="input-fluid validate[required] span3 <?php echo $hs; ?>" id="<?php echo $hs . $if[$j]; ?>">
									<?php
								}
								$title = $titles[$hs];
								if($hs != 'Connection_type' && $hs != 'Password' && $hs != 'Extension' && $hs != 'Language')
								{
									$mnd = '';
									$vld = ' ';
									if($hs == 'Description' || $hs == 'Host' || $hs == 'System_Number' || $hs == 'System_ID' || $hs=='Bapiversion')
									{
										$mnd = '<span> *</span>';
										$vld = ' validate[required] ';
									}
									?>
									<div class="control-group">
										<label class="control-label" for="input01"><?php echo $title. $mnd; ?>:</label>
										<div class="controls">
											<input type="text" value="<?php echo $he; ?>" class="input-fluid<?php echo $vld; ?>span3" id="<?php echo $hs . $if[$j]; ?>">
										</div>
									</div>
									<?php
								}
								elseif($hs == 'Language')
								{
									?>
									<div class="control-group">
										<label class="control-label" for="select02"><?=_LANGUAGE?><span> *</span>:</label>
										<div class="controls">
											<select id="<?php echo $hs . $if[$j]; ?>" data-placeholder="Select your Language" class="validate[required]">
												<option value=""><?=_SELECTLANGUAGE?></option>
												<option value="EN" selected><?=_ENGLISH?></option>
											</select>
										</div>
									</div>
									<?php
								}
								elseif($hs == 'Password')
								{
									?>
									<div class="control-group">
										<label class="control-label" for="input01"><?php echo $title; ?><span> *</span>:</label>
										<div class="controls">
											<input type="password" value="<?php echo str_rot13($he); ?>" class="input-fluid validate[required] span3" id="<?php echo $hs . $if[$j]; ?>">
										</div>
									</div>
									<?php
								}
								elseif($hs == 'CMS_Name' || $hs == 'CMS_Port' || $hs == 'Auth_Type')
								{
									$extended_bi = "";
									$wer = $he;
									if($he == 'NON')
									{
										$extended_bi = "hide_ex_bi";
										$wer = "";
									}
									?>
									<div class="control-group cms_names <?php echo $extended_bi; ?>">
										<label class="control-label" for="input01"><?php echo $title; ?><span> *</span>:</label>
										<div class="controls">
											<input type="text" value="<?php echo $wer; ?>" class="input-fluid validate[required] span3 <?php echo $hs; ?> emt_bobj" id="<?php echo $hs . $if[$j]; ?>">
										</div>
									</div>
									<?php
								}
								elseif($hs == 'Extension')
								{
									$type_sys = $jw['System_type'];
									?>
									<div class="control-group">
										<label class="control-label" for="input01"><?php echo $title; ?>:</label>
										<div class="controls">
											<?php
												if($he == 'on')
												{
													$chk_val = "on";
													$chk = 'checked="checked"';
												}
												else
												{
													$chk_val = "off";
													$chk = '';
												}
											?>
											<input type="checkbox" id="<?php echo $hs . $if[$j]; ?>" value="<?php echo $chk_val; ?>" onClick="bobj_extn(this,'<?php echo $type_sys; ?>')" <?php echo $chk; ?>>
										</div>
										<div id="error_msg<?php echo $if[$j]; ?>" style="margin-left:100px;"></div>
									</div>
									<?php
								}
							}
						}
						?>
						<div class="span1"></div>
						<button class="diab btn btn-primary" style="width:100px;" type="submit" id="ahide<?php echo $if[$j]; ?>" ><?=_SAVECHANGES?></button>
						<button class='diab btn '  style=" width:100px; display:none;" id="bhide<?php echo $if[$j]; ?>" ></button>
						&nbsp;&nbsp;<input class="btn" style="width:100px;" type="button" onClick="edit_cancel('<?php echo $vau ?>','<?php echo $if[$j]; ?>')" value='<?=CANCEL?>'>
					</form>
				<div style="margin-top:-10px" ><span style='color:red;'> *</span> <?=_REQUIREDFIELD?> </div>
				<!--<p style='color:red;'>Given password here will not be saved, it will be used only to validate the system.</p>-->
				</div>
			</section>
			<?php
			$j++;
		}
	}
?>