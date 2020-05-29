<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'manage_report_links/createlinks', 
        data:$('#system_add').find("select, input").serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
            //GEZG 07/27/2018
            //Reloading page after saving
            location.reload();
        }
    });
	
    $('#system_add input').each(function(index, element) 
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
<style>
	.input-fluid {
		width: 100%;
		height: auto;
	}
	#table1 td {
		min-width: 175px;
	}
	#table1 td img {
		cursor: pointer;
	}
</style>
<?php
	$report_list = Controller::availableReports();
	$systems = Controller::availableSystems();
	$hosts = $systems['host'];
	//GEZG 07/27/2018
	//Parsing reports object to array, PHP7 cannot access to inner objects using a string variable
	$reports = (array)$systems['reports'];
	/*
	print_r($hosts);
	print_r($report_list);
	*/			
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
			<form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span12 utopia-form-freeSpace myspace">
						<div class="control-group" id="system_list">
							<table id="table1" class="controller">
								<?php
									$client_list = $report_list;
									foreach($hosts as $k => $v)
									{
										echo '<tr style="height: 35px;" data-level="1" id="level_1_'.$v['System_ID'].'"><td><h3>'.$v['Description'].'</h3></td><td><button class="btn" id="btn_'.$v['System_ID'].'" type="button" onclick="add_client(\''.$v['System_ID'].'\')" style="width: auto;">Add New Client</button></td></tr>';
										foreach($reports[$v['System_ID']] as $ck => $cv)
										{
											$ck = trim($ck);
											echo '<tr data-level="2" id="level_2_'.$v['System_ID'].$ck.'"><td><h3 style="margin-bottom: 10px;">Client : '.ucwords(strtolower($ck)).'</h3></td><td><button class="btn" id="btn_'.$v['System_ID'].'" type="button" onclick="clear_client(\''.$v['System_ID'].'_'.$ck.'\')" style="width: auto;">Clear all Links for Client '.ucwords(strtolower($ck)).'</button></td></tr>';
											echo '<tr style="height: 35px;" class="childless" data-level="3" id="level_3_'.$v['System_ID'].$ck.'"><td colspan="2"><strong>Report Group / Name</strong></td><td class="data"><strong>Report Link</strong></td><td class="data"><strong>Manage</strong></td></tr>';											
											foreach($report_list as $rk => $rv)
											{													
												$rk_rpt = $rk."_reports";
												foreach($rv as $rlk => $rlv)
													echo '<tr id="'.$v['System_ID'].'_'.$ck.'_'.$rlk.'" style="height: 35px;" class="childless '.$v['System_ID'].'_'.$ck.'" data-level="3" id="level_3_'.$v['System_ID'].$ck.'"><td colspan="2">'.ucwords(strtolower($rk))." / ".ucwords(strtolower($rlv)).'</td><td><span class="text" id="row_text_'.$v['System_ID'].'_'.$ck.'_'.$rlk.'">'.$cv->$rk_rpt->$rlk.' </span><span style="display: none;" id="row_input_'.$v['System_ID'].'_'.$ck.'_'.$rlk.'"><input type="hidden" name="systemid" value="'.$v['System_ID'].'" /><input type="hidden" name="clientid" value="'.$ck.'" /><input type="text" name="links['.$v['System_ID'].']['.$ck.']['.$rk_rpt.']['.$rlk.']" class="validate[, custom[url]]" value="'.$cv->$rk_rpt->$rlk.'" /></span></td><td><img title="Edit" onclick="return row_edit(\''.$v['System_ID'].'_'.$ck.'_'.$rlk.'\');" src="'.Yii::app()->request->baseUrl.'/images/icons/pen.png">&nbsp;&nbsp;&nbsp;&nbsp;<img title="Save" onclick="return row_save(\''.$v['System_ID'].'_'.$ck.'_'.$rlk.'\');" src="'.Yii::app()->request->baseUrl.'/images/icons/diskette.png">&nbsp;&nbsp;&nbsp;&nbsp;<img title="Cancel" onclick="return row_cancel(\''.$v['System_ID'].'_'.$ck.'_'.$rlk.'\');" src="'.Yii::app()->request->baseUrl.'/images/icons/cancel.png"></td></tr>';
											}
										}
									}
								?>
							</table>
						</div>
						<div class="control-group" id="system_add">
							<div><h3>Add Client</h3></div>
							<br />
							<div class="clear"></div>
							<table class="controller" style="width: 60%;">
								<tr style="height: 40px;">
									<td>Sytem ID</td>
									<td class="data">
										<select name="systemid" id="systemid" class="input-fluid validate[required]">
											<option value="">Select System</option>
											<?php
												foreach($hosts as $k => $v)
													echo '<option value="'.$v['System_ID'].'">'.$v['Description'].'</option>';
											?>
										</select>
									</td>
								</tr>
								<tr style="height: 40px;"><td>Client ID</td><td class="data"><input type="text" name="clientid" class="input-fluid validate[required, custom[integer]]"></td></tr>
								<tr style="height: 40px;"><td><strong>Report Group / Name</strong></td><td class="data"><strong>Report Link</strong></td></tr>
								<?php
									foreach($report_list as $rk => $rv)
									{
										foreach($rv as $rlk => $rlv)
											echo '<tr style="height: 40px;"><td>'.ucwords(strtolower($rk))." / ".ucwords(strtolower($rlv)).'</td><td class="data"><input type="text" name="links['.$rk.']['.$rlk.']" class="input-fluid validate[, custom[url]]"></td></tr>';
									}
								?>
							</table>
							<div class="span6">
								<br />
								<div class="controls" style="text-align:center">
									<button class="btn btn-primary bbt" type="submit" id="subt" style="width: auto;">Submit</button>
									&nbsp;&nbsp;&nbsp;
									<button class="btn btn-primary bbt" type="button" id="cancel" style="width: auto;">Cancel</button>
									<br><br><br><br>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/tabelizer/jquery.tabelizer.js'></script>
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/js/tabelizer/tabelizer.css' />
<script type="text/javascript">
    $(document).ready(function() {
		jQuery("#validation").validationEngine();
		$('#table1').tabelize({
			fullRowClickable : false,
			onAfterRowClick : function(evt){
				if (!$(evt.target).closest("tr").hasClass('contracted') && $(evt.target).closest("tr").hasClass('l1'))
					$(evt.target).closest("tr").find("button").show();
				else if ($(evt.target).closest("tr").hasClass('contracted') && $(evt.target).closest("tr").hasClass('l1'))
				{
					row_id = $(evt.target).closest("tr").attr("id");
					row_id = row_id.replace("level_1_", "btn_");
					$("#table1").find("button").each(function(){
						if($(this).attr("id") == row_id)
							$(this).hide();
					});
					// $(evt.target).closest("tr").find("button").hide();
				}
				if (!$(evt.target).closest("tr").hasClass('contracted') && $(evt.target).closest("tr").hasClass('l2'))
					$(evt.target).closest("tr").find("button").show();
				else if ($(evt.target).closest("tr").hasClass('contracted') && $(evt.target).closest("tr").hasClass('l2'))
					$(evt.target).closest("tr").find("button").hide();
			}
		});
		
		$("#table1").find(".tree-label").click(function(){
			$(this).prev().trigger('click');
		});
		
		$("#table1").find("button").hide();
		$("#system_add").hide();
		$("img[title='Save']").hide();
		$("img[title='Cancel']").hide();
		
		$("#cancel").click(function() {
			page = window.location.hash;
			if(page != '')
				$(page).trigger('click');
			return false;
			
			$("#system_list").show();
			$("#system_add").hide();
		});
	});
	
	function add_client(id)
	{
		$("#systemid").closest("tr").hide();
		$("#systemid").val(id);
		$("#system_list").hide();
		$("#system_add").show();
	}
	
	function row_edit(id)
	{
		$("#row_text_"+id).hide();
		$("#row_input_"+id).show();
		$("#"+id+" img[title='Save']").show();
		$("#"+id+" img[title='Cancel']").show();
	}
	
	function row_cancel(id)
	{
		$("#row_text_"+id).show();
		$("#row_input_"+id).hide();
		$("#"+id+" img[title='Save']").hide();
		$("#"+id+" img[title='Cancel']").hide();
	}
	
	function clear_client(id)
	{
		$("."+id).find(".text").html("");
		$("."+id).find("input[type=text]").val("");
		$('#loading').show();
		$("body").css("opacity","0.4"); 
		$("body").css("filter","alpha(opacity=40)"); 
		$.ajax({
			type: 'POST',
			url: 'manage_report_links/updatelinks', 
			data: $('.'+id).find('input').serialize(),
			success: function(response) 
			{
				$('#loading').hide();
				$("body").css("opacity", "1");
				if(response == "Updated Successfully")
					response = "Link Cleared Successfully";
				jAlert(response, 'Message');
			}
		});
	}
	
	function row_save(id)
	{
		sts = jQuery("#validation").validationEngine('validate');
		
		if(sts)
		{
			$('#loading').show();
			$("body").css("opacity","0.4"); 
			$("body").css("filter","alpha(opacity=40)"); 
			$.ajax({
				type: 'POST',
				url: 'manage_report_links/updatelinks', 
				data: $('#'+id).find('input').serialize(),
				success: function(response) 
				{
					$('#loading').hide();
					$("body").css("opacity", "1");
					jAlert(response, 'Message');
					$("#row_text_"+id).html($("#row_input_"+id).find("input:visible").val());
					row_cancel(id);
				}
			});
		}
	}
</script>