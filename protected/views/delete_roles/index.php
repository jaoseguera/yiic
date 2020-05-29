<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$customize 	= $model;
	$users		= Controller::userDbconnection();
	$client 	= Controller::companyDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	
	$docs		= $users->getallDocs();
	foreach($docs->rows as $key => $val)
	{
		$doc = $users->getDoc($val->id);
		if($doc->company_id == $Company_ID && $doc->profile->roles != "Regular" && $doc->profile->roles != "Primary")
			$arr[] = $doc->profile->roles;
	}
	
	$doc		= $client->getDoc($Company_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" class="form-horizontal" method="post">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz" for="Users" alt="Users"><?php echo Controller::customize_label('Roles');?><span> *</span>:</label>
                            <div class="controls">
								<select id="Users" data-placeholder="Select User" class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="Users" style="height:30px;">
									<option value=""></option>
									<?php
										foreach($gs['roles'] as $key => $val)
										{
											if($key != "Regular")
											{
												if(in_array($key, $arr))
													echo '<option value="'.$key.'" exist_cust= "1">'.$key.'</option>';
												else
													echo '<option value="'.$key.'">'.$key.'</option>';
											}
										}
									?>
								</select><br/>
                            </div>
                        </div>
                        <div class="control-group" id="user_menus"></div>
					</div>
				</fieldset>
                <div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span3" onclick="return submitForm();" type="button" id="subt">Submit</button>
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
    $(document).ready(function() {
		jQuery("#validation").validationEngine();
	});
	
	function submitForm()
	{
		sts = jQuery("#validation").validationEngine('validate');
		if(sts)
		{
			jConfirm('<b>Do you really want to delete this role? </b>', 'Delete User', function(r) {
				if(r)
					Formsubmit();
				else
					return false;
			});
		}
	}
	
	function Formsubmit() 
	{
		var exist_cust = $("#Users option:selected").attr("exist_cust");
		
		if(exist_cust == 1)
		{
			alert("This role is already assigned to User. Please update the role for that User.");
			return false;
		}
		else
		{
			$('#loading').show();
			$("body").css("opacity","0.4"); 
			$("body").css("filter","alpha(opacity=40)"); 
			$.ajax({
				type:'POST', 
				url: 'delete_roles/deleteroles', 
				data:$('#validation').serialize(), 
				success: function(response) 
				{
					$('#loading').hide();
					$("body").css("opacity", "1"); 
					jAlert(response, 'Message');
					
					if(response == "Role Deleted Successfully")
					{
						$('#validation select option:selected').remove();
						$('#validation select').val("");
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
		return false;
	}
</script>