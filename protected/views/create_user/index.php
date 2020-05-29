<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_user/createuser', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Created Successfully")
				$('#validation input:text, #validation input:password, #validation select').val("");
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
	$Company_ID	= Yii::app()->user->getState("company_id");
	$doc		= $client->getDoc($Company_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('First Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="First Name" type="text" class="input-fluid validate[required]" name="FIRST_NAME" tabindex="5" autocomplete="off" id="FIRST_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Last Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Last Name" type="text" class="input-fluid validate[required]" name="LAST_NAME" tabindex="6" autocomplete="off" id="LAST_NAME">
                            </div>
                        </div>
					</div>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Role');?><span> *</span>:</label>
                            <div class="controls">
								<select id="ROLE" data-placeholder="Select your role"  class="input-fluid validate[required] minw1 read select_box1"  tabindex="8" name="ROLE" style="height:30px;">
									<option value=""></option>
									<option value="Admin">Admin</option>
									<!--<option value="Regular">Regular</option>-->
									<?php
										foreach($gs['roles'] as $key => $val)
										{
											// if($key != "Regular")
											echo '<option value="'.$key.'">'.$key.'</option>';
										}
									?>
								</select><br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' tabindex="9" autocomplete="off" id="EMAIL">
                            </div>
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
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
</script>