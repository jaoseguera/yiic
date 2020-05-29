<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'edit_company/editcompany', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Updated Successfully")
			{
				$("#Company").find("option:selected").text($("#I_NAME").val());
				$("#validation").find(".text-display").remove();
				$("#validation").find("input[type='text'], select, [type='submit']").hide();
				$("#validation").find("input[type='text']").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).val()+"</span>");
				});
				$("#validation").find("input[type='checkbox']").each(function(){
					if($(this).prop("checked"))
						$(this).hide();
					else
						$(this).closest("ul").hide();
				});
				$("#validation").find("select").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
				});
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
	$customize = $model;
	$client 	= Controller::companyDbconnection();
	$all_docs 	= $client->getAllDocs();
	$sd = json_encode($all_docs);
	$gs = json_decode($sd, true);
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="clear"></div>
					<div class="span5 utopia-form-freeSpace myspace">
						<div class="control-group">
                            <label class="control-label cutz" for="Company" alt="Company"><?php echo Controller::customize_label('Company');?><span> *</span>:</label>
                            <div class="controls">
								<select id="Company" data-placeholder="Select User"  class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="Company" style="height:30px;">
									<option value=""></option>
									<?php
										foreach($gs['rows'] as $key => $val)
										{
											$docs	= $client->getDoc($val['id']);
											// if($val['id'] != "emgadmin" && $val['id'] != "freetrial" && $docs->status != "inactive")
											if($val['id'] != "emgadmin" && $val['id'] != "freetrial")
												echo '<option value="'.$val['id'].'">'.$docs->name.'</option>';
										}
									?>
								</select>
                            </div>
                        </div>
					</div>
				</fieldset>
				<div class="span10" id="ctrl-btn">
					<div class="controls" style="text-align:center">
						<button class="btn bbt span2" type="button" id="subt-edit">Edit</button>
						<button class="btn btn-primary bbt span2" type="submit" id="subt">Submit</button>
						<button class="btn bbt span2" type="button" id="subt-cancel">Cancel</button>
					</div>
				</div>
				<div class="clear"></div>
				<div class="control-group" id="user_menus"></div>
				<div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn bbt span2" type="button" id="subt-edit">Edit</button>
                        <button class="btn btn-primary bbt span2" type="submit" id="subt">Submit</button>
                        <button class="btn bbt span2" type="button" id="subt-cancel">Cancel</button>
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
		
		if(sessionStorage.getItem('edit_company_id') != null)
		{
			$("#Company").val(sessionStorage.getItem('edit_company_id'));
			getcompanies($("#Company").val());
		}
		
		$("#Company").change(function() {
			if($(this).val() != "")
			{
				getcompanies($(this).val());
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
		});
		
		$("[type='button']").not("#subt-cancel").click(function() {
			$("#validation").find(".text-display").not("#span_Company, #span_I_COMPANY").remove();
			
			$("#validation").find("input[type='checkbox']").each(function(){
				if($(this).prop("checked"))
					$(this).show();
				else
					$(this).closest("ul").show();
			});
			$("#validation").find("input[type='text'], select, [type='submit']").not("#Company, #I_COMPANY").show();
			$("[type='button']").not("#subt-cancel").hide();
		});
	});
	
	function getcompanies(cmpid)
	{
		jQuery("#validation").validationEngine('validate');
		$('#loading').show();
		$("body").css("opacity","0.4");
		$("body").css("filter","alpha(opacity=40)");
		$.ajax({
			type: 'POST',
			url: 'edit_company/getcompanies',
			data: 'Company='+cmpid,
			success: function(response)
			{
				$('#loading').hide();
				$("body").css("opacity", "1");
				$("#user_menus").html(response);
				$("#user_menus").show();
				$("#ctrl-btn").show();
				
				sessionStorage.removeItem('edit_company_id');
				$("#validation").find("input[type='text'], select, [type='submit']").hide();
				$("#validation").find("input[type='text']").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).val()+"</span>");
				});
				$("#validation").find("input[type='checkbox']").each(function(){
					if($(this).prop("checked"))
						$(this).hide();
					else
						$(this).closest("ul").hide();
				});
				$("#validation").find("select").each(function(){
					$(this).closest("div").append("<span id='span_"+$(this).attr("id")+"' class='text-display span10'>"+$(this).find("option:selected").text()+"</span>");
				});
				$("[type='button']").show();
			}
		});
	}
</script>