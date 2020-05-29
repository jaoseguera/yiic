<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'edit_user/edituser', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Updated Successfully")
			{
				$("#validation").find(".text-display").remove();
				$("#validation").find("input[type='text'], select, [type='submit']").hide();
				$("#validation").find("input[type='text']").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).val()+"</span>");
				});
				$("#validation").find("select").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
				});
				$("#subt-edit").show();
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
	$client 	= Controller::userDbconnection();
	$Company_ID	= Yii::app()->user->getState("company_id");
	$all_docs 	= $client->getAllDocs();
	$cmp=Controller::companyDbconnection();
	$cmpdoc=$cmp->getDoc($Company_ID);
	$roles=array();
	foreach($cmpdoc->roles as $key=>$val)
	{
	array_push($roles,$key);
	}
	array_push($roles,'Admin');
	$usr=Yii::app()->user->getState("user_id");
	
	foreach ($all_docs->rows as $key => $row)
	{
		$doc	= $client->getDoc($row->id);
		if($doc->company_id != $Company_ID || (!in_array($doc->profile->roles,$roles) ))
			unset($all_docs->rows[$key]);
	}
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="clear"></div>
					<div class="span5 utopia-form-freeSpace myspace">
						<div class="control-group">
                            <label class="control-label cutz" for="User" alt="User"><?php echo Controller::customize_label('Users');?><span> *</span>:</label>
                            <div class="controls">
								<select id="User" data-placeholder="Select User" class="input-fluid validate[required] minw1 read select_box1" tabindex="8" name="User" style="height:30px;">
									<option value=""></option>
									<?php
										foreach ($all_docs->rows as $row)
											echo '<option value="'.$row->id.'">'.$row->id.'</option>';
									?>
								</select>
                            </div>
                        </div>
					</div>
				</fieldset>
				<div class="control-group" id="user_menus"></div>
				<div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn bbt btn-primary span2 sub-btn" type="button" id="subt-edit">Edit</button>
                        <button class="btn btn-primary bbt span2 sub-btn" type="submit" id="subt" tabindex="11">Submit</button>
						<button class="btn btn-primary bbt span2 sub-btn" type="button" id="subt-cancel">Cancel</button>
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
		$("#subt-edit").hide();
        $(".sub-btn").hide();

		
		if(sessionStorage.getItem('edit_user_id') != null)
		{
			$("#User").val(sessionStorage.getItem('edit_user_id'));
			// sessionStorage.removeItem('edit_user_id');
			getusers($("#User").val());
		}
		
		$("#User").change(function() {
			if($(this).val() != "")
			{
				getusers($(this).val());
			}
			else
				$("#user_menus").html('');
		});
		
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
			$("#validation").find(".text-display").not("#span_User, #span_EMAIL").remove();
			
			$("#validation").find("input[type='text'], select, [type='submit']").not("#User, #EMAIL").show();
			$("#subt-edit").hide();

		});
	});
	
	function getusers(usrid)
	{
		$('#loading').show();
		$("body").css("opacity","0.4");
		$("body").css("filter","alpha(opacity=40)");
		$.ajax({
			type: 'POST',
			url: 'edit_user/getusers',
			data: 'User='+usrid,
			success: function(response)
			{
				$('#loading').hide();
				$("body").css("opacity", "1");
				$("#user_menus").html(response);
				$("#user_menus").show();
				
				sessionStorage.removeItem('edit_user_id');
				$("#validation").find("input[type='text'], select, [type='submit']").hide();
				$("#validation").find("input[type='text']").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).val()+"</span>");
				});
				$("#validation").find("select").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
				});
				$("#subt-edit").show();
                $("#subt-cancel").show();

			}
		});
	}
</script>