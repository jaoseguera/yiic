<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'edit_roles/createroles', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Updated Successfully")
			{
				$("#validation").find(".text-display").remove();
				$("#validation").find("input[type='checkbox']").each(function(){
					if($(this).prop("checked"))
						$(this).hide();
					else
						$(this).closest("ul").hide();
				});
				$("#validation").find("select").each(function(){
					$(this).hide();
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
				});
				$("[type='submit']").hide();
				$("[type='button']").show();
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

<style>
	.text-display {
		border: 1px solid #DDDDDD;
		border-radius: 3px;
		color: #555555;
		line-height: 28px;
		margin-left: 0 !important;
		text-indent: 5px;
		background-color: #EEEEEE;
		cursor: not-allowed;
	}
</style>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$customize 	= $model;
	$client 	= Controller::companyDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$doc		= $client->getDoc($Company_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
			<div id="error">
				<div class="flash-error">You must enable Functions before Display/Edit roles.</div>
				<div class="clear"></div>
			</div>
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
						<div class="control-group">
                            <label class="control-label cutz" for="ROLE_NAME" alt="Role Name"><?php echo Controller::customize_label('Roles');?><span> *</span>:</label>
                            <div class="controls">
								<select id="ROLE_NAME" data-placeholder="Select Role" class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="ROLE_NAME" style="height:30px;">
									<option value=""></option>
									<?php
										foreach($gs['roles'] as $key => $val)
											echo '<option value="'.$key.'">'.$key.'</option>';
									?>
								</select>
                            </div>
                        </div>
					</div>
				</fieldset>
				<!--<div class="span10" id="ctrl-btn">
					<div class="controls" style="text-align:center">
						<button class="btn bbt span2" type="button" id="subt-edit">Edit</button>
						<button class="btn btn-primary bbt span2" type="submit" id="subt">Submit</button>
						<button class="btn bbt span2" type="button" id="subt-cancel">Cancel</button>
					</div>
				</div>-->
				<div class="clear"></div>
				<div class="control-group" id="user_menus"></div>
				<div class="span10" id="default_ctrl">
                    <div class="controls" style="text-align:center">
                        <button class="btn bbt span2 sub-btn" type="button" id="subt-edit">Edit</button>
                        <button class="btn btn-primary bbt span2 sub-btn"  type="submit" id="subt">Submit</button>
						<button class="btn bbt span2 sub-btn" type="button"  id="subt-cancel">Cancel</button>
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
		$("[type='button']").not("#subt-cancel").hide();
		$("#ctrl-btn").hide();
		$("#error").hide();
        $(".sub-btn").hide();
		
		$("[type='button']").not("#subt-edit").click(function() {
			$("#validation").find(".text-display").remove();
			$("#validation").find("input[type='text'], select").val('');
			$("#validation").find("input[type='text'], select, [type='submit']").show();
			$("#user_menus").html('');
			$("[type='button']").not("#subt-cancel").hide();
            $("#ctrl-btn").hide();
            $(".sub-btn").hide();
		});
		
		$("[type='button']").not("#subt-cancel").click(function() {
			$("#validation").find("input[type='checkbox']").each(function(){
				if($(this).prop("checked"))
					$(this).show();
				else
					$(this).closest("ul").show();
			});
			$("[type='submit']").show();
			$("[type='button']").not("#subt-cancel").hide();
            $("#subt-edit").hide();

		});
		
		$("#ROLE_NAME").change(function() {
			if($(this).val() != "")
			{
				$('#loading').show();
				$("body").css("opacity","0.4");
				$("body").css("filter","alpha(opacity=40)");
				$.ajax({
					type: 'POST',
					url: 'edit_roles/getroles',
					data: 'role='+$(this).val(),
					success: function(response)
					{
						$('#loading').hide();
						$("body").css("opacity", "1");
						$("#user_menus").html(response);
						$("#user_menus").show();
						
						if($("#user_menus").find("ul").length == 0)
						{
							$("#user_menus").html($("#error").html());
							// $("#error").show();
							$("#default_ctrl").hide();
						}
						else
						{
							$("#default_ctrl").show();
							$("#ctrl-btn").show();
							
							$("#validation").find("input[type='checkbox']").each(function(){
								if($(this).prop("checked"))
									$(this).hide();
								else
									$(this).closest("ul").hide();
							});
							$("#validation").find("select").each(function(){
								$(this).hide();
								$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
							});
							$("[type='submit']").hide();
							$("[type='button']").show();
						}
					}
				});
			}
			else
				$("#user_menus").html('');
		});
	});
</script>