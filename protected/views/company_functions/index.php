<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'company_features/createroles', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
        }
    });
}
</script>
<?php
	$customize = $model;
	$client 	= Controller::companyDbconnection();
	$all_docs 	= $client->getAllDocs();
	$sd = json_encode($all_docs);
	$gs = json_decode($sd, true);
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span12 utopia-form-freeSpace myspace">
						<div class="control-group span5">
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
						<br><br><br>
                        <div class="control-group" id="user_menus">
							<?php // $this->renderPartial("roles"); ?>
						</div>
					</div>
				</fieldset>
                <div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span3" type="submit" id="subt" tabindex="11">Submit</button>
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
		$("#Company").change(function() {
			if($(this).val() != "")
			{
				$('#loading').show();
				$("body").css("opacity","0.4");
				$("body").css("filter","alpha(opacity=40)");
				$.ajax({
					type: 'POST',
					url: 'company_features/getroles',
					data: 'Company='+$(this).val(),
					success: function(response)
					{
						$('#loading').hide();
						$("body").css("opacity", "1");
						$("#user_menus").html(response);
						$("#user_menus").show();
					}
				});
			}
			else
				$("#user_menus").html('');
		});
	});
</script>