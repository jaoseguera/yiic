<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_roles/createroles', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Created Successfully")
			{
				$('#validation input:text').val("");
				$('#validation input:checkbox').removeAttr("checked");
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

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
			<div id="error">
				<div class="flash-error">You must enable Functions before Creating roles.</div>
				<div class="clear"></div>
			</div>
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="ROLE_NAME" alt="Role Name" ><?php echo Controller::customize_label('Role');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Role Name" type="text" class="input-fluid validate[required,notequals[emg],notequals[regular],notequals[admin],notequals[primary]]" name="ROLE_NAME" autocomplete="off" id="ROLE_NAME">
								<input alt="Role Name" type="hidden" value='emg' name="Emg" autocomplete="off" id="emg">
								<input alt="Role Name" type="hidden" value='Primary' name="Primary" autocomplete="off" id="primary">
								<input alt="Role Name" type="hidden" value='Regular' name="Regular" autocomplete="off" id="regular">
								<input alt="Role Name" type="hidden" value='Admin' name="admin" autocomplete="off" id="admin">
                            </div>
                        </div>
					</div>
					<div class="span12 control-group" id="user_menus">
						<?php $this->renderPartial("roles"); ?>
					</div>
				</fieldset>
                <div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span3" type="submit" id="subt">Submit</button>
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
		
		if($("#user_menus").find("ul").length == 0)
			$("#validation").hide();
		else
			$("#error").hide();
		
		$("[name='level0[]']").change(function() {
			var lvl0 = $(this).attr("data-level");
			var lvl0_chk = $(this).is(":checked");
			$("[name='level1[]']").each(function() {
				var lvl1_val = $(this).val();
				var lvl1_arr = lvl1_val.split("~");
				lvl1 = lvl1_arr[1];
				if(lvl0 == lvl1_arr[0])
				{
					if(lvl0_chk)
						$(this).prop('checked', true);
					else
						$(this).prop('checked', false);
				}
				
				var lvl1_chk = $(this).is(":checked");
				$("[name='level2[]']").each(function() {
					var lvl2_val = $(this).attr("data-level");
					var lvl2_arr = lvl2_val.split("_");
					var lvl2 = lvl2_arr[2];
					if(lvl0 == lvl2_arr[0] && lvl1 == lvl2_arr[1])
					{
						if(lvl1_chk)
							$(this).prop('checked', true);
						else
							$(this).prop('checked', false);
					}
				});
			});
		});
		$("[name='level1[]']").change(function() {
			var lvl1_val = $(this).attr("data-level");
			var lvl1_arr = lvl1_val.split("_");
			var lvl1 = lvl1_arr[1];
			var lvl0_chk = $(this).is(":checked");
			$("[name='level2[]']").each(function() {
				var lvl2_val = $(this).attr("data-level");
				var lvl2_arr = lvl2_val.split("_");
				var lvl2 = lvl2_arr[2];
				if(lvl1 == lvl2_arr[1])
					if(lvl0_chk)
						$(this).prop('checked', true);
					else
						$(this).prop('checked', false);
			});
		});
	});
</script>