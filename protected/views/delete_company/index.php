<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'delete_company/deletecompany', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Company Deleted Successfully")
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
</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$customize 	= $model;
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
											if($val['id'] != "emgadmin" && $val['id'] != "freetrial" && $docs->status != "inactive")
												echo '<option value="'.$val['id'].'">'.$docs->name.'</option>';
										}
									?>
								</select><br/>
                            </div>
                        </div>
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
	});
</script>