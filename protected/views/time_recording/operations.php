<?php
	$t_id = $_REQUEST['t_id'];
	$table_name = $_REQUEST['table_name'];
?>
<style>
	#table-table_todays input
	{
		float: left;
		margin: 0px;
	}
	#table-table_todays span label
	{
		float: left;
		margin-left: 5px;
	}
	#operations_table
	{
		overflow: auto;
		max-height: 440px;
	}
</style>
<div id="status_table">
	<h3>Operation Status Table</h3><br />
	<form id="operations_table_form" method="post" class="form-horizontal">
		<div id="operations_table">
			<table class="table table-striped table-bordered" id="table-<?php echo $t_id; ?>" alt="<?php echo $table_name; ?>">
				<thead>
					<tr>
						<th>Operation Number</th>
						<th>Operation Description</th>
						<th>Operation Status</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody id='<?php echo $t_id; ?>_tbody'>
					<?php
						foreach($Status as $skey => $sval)
						{
							if(!empty($sval)):
								$po_order = $sval['PROD'];
								$emp_id   = $sval['EMP'];
								
								unset($sval['PROD']);
								unset($sval['EMP']);
							endif;
							
							foreach($sval as $key => $val)
							{
								$oper_num = ltrim($val['OPERATION_NUMBER'], 0);
								$operations[$skey][$val['OPERATION_NUMBER']] = $oper_num." - ".$val['DESCRIPTION'];
								
								if($skey == "Stop")
									$dispkey = "Can be started";
								else
									$dispkey = $skey."ed";
								
								echo '
									<tr>
										<td>'.$oper_num.'</td>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								/*
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								echo '
									<tr>
										<td>'.CHtml::checkBox('operation_id', false, array('value' => $val['OPERATION_NUMBER'], 'style' => 'display: none;')).$oper_num.'</td>
										<td>'.$val['DESCRIPTION'].'</td>
										<td><input type="hidden" name="status" value="'.strtolower($skey).'">'.$dispkey.'</td>
										<td>'.ltrim($val['QUANTITY'], 0).'</td>
									</tr>
								';
								*/
							}
						}
					?>
				</tbody>
				<thead>
					<tr>
						<th><input type="text" value="" class="search_init" /></th>
						<th><input type="text" value="" class="search_init" /></th>
						<th><input type="text" value="" class="search_init" /></th>
						<th><input type="text" value="" class="search_init" /></th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="span4 utopia-form-freeSpace" style="margin-left: 0px;">
			<input type="button" name="start" id="start" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" style="min-width:90px;" value="Start" />
		</div>
		<div class="span4 utopia-form-freeSpace">
			<input type="button" name="stop" id="stop" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" style="min-width:90px;" value="Stop" />
		</div>
		<div class="span4 utopia-form-freeSpace">
			<input type="hidden" name='choice' id='choice' value="">
			<input type="hidden" name='po_order' value="<?php echo $po_order ?>">
			<input type="hidden" name='emp_id' value="<?php echo $emp_id ?>">
			<input type="hidden" name="url" value="time_recording_action"/>
			<label class="control-label cutz" style="margin-right: 5px; width: 45px; float: left;"><?php echo Controller::customize_label('Yield');?><span> *</span>:</label>
			<input type="type" id="yield" name="yield" value="" class="span6 validate[required]" style="float: left;" />
			<input type="button" name="complete" id="complete" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" style="min-width:90px; margin-left: 10px; float: left;" value="Complete" />
		</div>
	</form>
</div>
<script>
	var asInitVals = new Array();
	$(document).ready(function() {
		var oTable = $('#table-<?php echo $t_id; ?>').dataTable( {
			"bPaginate": false,
			"bInfo": false
		} );
		
		$("thead input").keyup( function () {
			oTable.fnFilter( this.value, $("thead input").index(this) );
		} );
		
		$("thead input").each( function (i) {
			asInitVals[i] = this.value;
		} );
		
		$("thead input").focus( function () {
			if ( this.className == "search_init" )
			{
				this.className = "";
				this.value = "";
			}
		} );
		
		$("thead input").blur( function (i) {
			if ( this.value == "" )
			{
				this.className = "search_init";
				this.value = asInitVals[$("thead input").index(this)];
			}
		} );
		$(".dataTables_filter").hide();
	} );
	
	$(document).ready(function() {
		jQuery("#operations_table_form").validationEngine();
		
		$("#status_table").find("[type=button]").attr("disabled", true);
		$("#status_table").find("[type=button]").removeClass("btn-primary");
		$("#yield").prop("disabled", true);
		
		jQuery("#action_table").validationEngine({
			'customFunctions': {
				'checkRow': function (field, rules, i, options){
					return checkrows(field, rules, i, options);
				}
			}
		});
		
		$("#status_table tbody").find("tr").click(function() {
			jQuery("#operations_table_form").validationEngine('hideAll');
			if($(this).find("[type=checkbox]").prop('checked'))
			{
				$("#status_table").find("[type=button]").attr("disabled", true);
				$("#status_table").find("[type=button]").removeClass("btn-primary");
				$("#yield").prop("disabled", true);
				
				$(this).find("[type=checkbox]").prop('checked', false);
				$(this).removeAttr('style');
			}
			else
			{
				$("#status_table tbody").find("tr").each(function() {
					$(this).find("[type=checkbox]").prop('checked', false);
					$(this).removeAttr('style');
				});
				
				opr_status = $(this).find("[type=hidden]").val();
				$("#status_table").find("[type=button]").each(function() {
					if(opr_status == "start")
					{
						/*
						if($(this).val() == "Start")
						{
							$(this).removeClass("btn-primary");
							$(this).prop("disabled", true);
							$("#yield").prop("disabled", true);
							$("#yield").val("");
						}
						else
						{
							$(this).addClass("btn-primary");
							$("#yield").prop("disabled", false);
							$(this).prop("disabled", false);
						}
						*/
						$(this).addClass("btn-primary");
						$("#yield").prop("disabled", false);
						$(this).prop("disabled", false);
					}
					else
					{
						if($(this).val() == "Start")
						{
							$(this).addClass("btn-primary");
							$("#yield").prop("disabled", false);
							$(this).prop("disabled", false);
						}
						else
						{
							$(this).removeClass("btn-primary");
							$("#yield").val("");
							$("#yield").prop("disabled", true);
							$(this).prop("disabled", true);
						}
					}
				});
				
				$(this).find("[type=checkbox]").prop('checked', true);
				$(this).css({ background:'#E1E3FE' });
			}
		});
	});
	
	$("#status_table").find("[type=button]").click(function() {
		$("#choice").val($(this).val());
		action_submit();
	});
	
	function action_submit()
	{
		// sts = jQuery("#action_table").validationEngine('validate');
		if($("#choice").val() == "Complete")
			sts = jQuery("#operations_table_form").validationEngine('validate');
		else
		{
			jQuery("#operations_table_form").validationEngine('hideAll');
			sts = true;
		}
		
		if(sts)
		{
			$('#loading').show();
			$('#loading').css({position:'fixed'});
			$("body").css("opacity","0.4"); 
			$("body").css("filter","alpha(opacity=40)");
			
			// dataStrings = $('#action_table').serialize();
			dataStrings = $('#operations_table_form [name!=status]').serialize();
			$.ajax({
				type: "POST",
				url: "<?php echo Yii::app()->createAbsoluteUrl("time_recording/timeaction"); ?>",
				data: dataStrings,
				success: function(response)
				{
					var spt = response.split("@");
					
					dataStrings = $('#validation').serialize();
					$.ajax({
						type: "POST",
						url: "<?php echo Yii::app()->createAbsoluteUrl("time_recording/tabledata"); ?>",
						data: dataStrings,
						success: function(data)
						{
							$('#loading').hide();
							$("body").css("opacity","1");
							$('#table_todays').html(data);
							jAlert('<b>SAP System Message: </b><br>'+ spt[0], 'Time Recording');
						}
					});
				}
			});
		}
		return false;
	}
	
	function checkrows(field, rules, i, options)
	{
		var ctrlval = field.val();
		var val = new Array();
		
		if(ctrlval == "" || ctrlval == null)
		{
			j = 0;
			field.closest('tr').find('input[type=text], input[type=radio], select').each( function(index){
				if($(this).attr('id') != "")
				{
					if($(this).val() == "" || $(this).val() == null || $(this).prop('readOnly') || !$(this).prop("checked"))
						val[j] = false;
					else
						val[j] = true;
					j++;
				}
			});
			
			if( jQuery.inArray( true, val ) >= 0)
			{
				rules.push('required');
				// return options.allrules.required.alertText;
			}
		}
	}
</script>