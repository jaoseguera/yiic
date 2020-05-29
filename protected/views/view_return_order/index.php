<script>
function submitForm()
{
	$('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
		type:'POST',
		data:'order_num='+number($('#I_VBELN').val()),
		url:'view_return_order/stringpdf',
		success:function(data){
		//	alert(data);
		$('#loading').hide();
            $("body").css("opacity","1");
			if($.trim(data)!='')
			{
				jAlert(data,'Message');
			}
			else
			{
				var tab=window.open('common/Pdfurl');
				tab.focus();
			}
		}
	});	
}
function submitForm1() 
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
function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
      return str;
    }
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
            <form id="validation" onkeypress="return event.keyCode != 13;" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Zip"><?php echo Controller::customize_label('Return Order Number');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Zip" type="text" class="input-fluid validate[required]" name='I_ZIP' tabindex="4" onKeyUp="jspt('I_ZIP',this.value,event)" autocomplete="off" id="I_VBELN">
                            </div>
                        </div>
					</div>
				</fieldset>
                <div class="span10">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span2" type="submit" id="subt" tabindex="11">Submit</button>
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