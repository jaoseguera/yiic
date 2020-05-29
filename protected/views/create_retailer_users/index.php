<head>
<link href="css/jquery.tagedit.css" rel="stylesheet" type="text/css">
<style>
.input-fluid
{
width:90%;
float: left;
}
.spans
{
min-height:28px;
}
#sysdetails table td
{
 border: 1px solid #ddd;
 align:center;
 padding:3px;
}
</style>
</head>
<script>

function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	var ur=$('#head_tittle').html();
	var cmp=$('#COMPANY_NAME').val();
	var cmpad=$('#COMPANY_ADDRESS').val();
	
    $.ajax({
        type:'POST', 
        url: 'create_retailer_users/createuser', 
        data:$('#validation').serialize()+'&ur='+ur+'&cmp='+cmp+'&cmpad='+cmpad, 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity", "1"); 
            jAlert(response, 'Message');
			
			if(response == "Created Successfully")
				$('#validation input:text, #validation input:password, #validation select,#sysdetails').val("");
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
$this->renderPartial('lookup');
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
				<div class="span4 utopia-form-freeSpace myspace">
					<div class="control-group">
						<label class="control-label cutz in_custz" for="ROLE" alt="Role"><?php echo Controller::customize_label('SAP System');?><span> *</span>:</label>
                            <div class="controls">
								<select id="SAP_SYSTEM" onchange="changethis(this)" data-placeholder="Select SAP Syatem"  class="spans input-fluid validate[required] "  tabindex="5" name="SAPSYSTEM" >
									<option value="Select Sap System">Select SAP System</option>
									
									<!--<option value="Regular">Regular</option>-->
									<?php
									if(isset($doc->host_id))
									{
										foreach($doc->host_id as $key => $val)
										{
											// if($key != "Regular")
											echo '<option value="'.$key.'">'.$val->Description.'</option>';
										}
									}	
									?>
								</select>
                            </div>

					</div>
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="ROLE" alt="Role"><?php echo Controller::customize_label('SAP User ID');?><span> *</span>:</label>
							<div class="controls">
                                <input alt="Company Name" type="text" class="input-fluid validate[required]" onblur="addlogin(this.id);" name="USER_NAME" tabindex="7" autocomplete="off" id="USER_NAME">
                            </div>
						</div>
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="CLIENTID" alt="Client ID"><?php echo Controller::customize_label('SAP Client ID');?><span> *</span>:</label>
							<div class="controls">
                                <input alt="Client ID" type="text" class="input-fluid validate[required]" onblur="addlogin(this.id);" name="CLIENT_ID" tabindex="6" autocomplete="off" id="CLIENT_ID">
                            </div>
						</div>
						<div class="control-group">
					<label class="control-label cutz in_custz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('SAP Password');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="First Name" type="password" class="input-fluid validate[required]" onblur="addlogin(this.id);" name="PASSWORD" tabindex="8" autocomplete="off" id="PASSWORD">
                            </div>
					</div>
					</div>
					<div  class="span10"  id="sysdetails" style="margin-left:6%;padding:3%">
					</div><br/>
				</fieldset>
				<fieldset>	
					<div class="span4 utopia-form-freeSpace myspace">
					<?php if($service!='service') { ?>
					<div class="control-group">
					<label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('SoldToID');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid validate[required] " onblur="blurtext('customer');" name="SOLDTOID" tabindex="1" onKeyUp="jspt('SOLDTOID',this.value,event)" autocomplete="off" id="customer">
								<span class='minw' onclick="lookup('Customer Number', 'customer', 'sold_to_customer')" >&nbsp;</span>
                            </div>
					</div>
					<?php } ?>
					<div class="control-group">
                            <label class="control-label cutz" for="EMAIL" alt="Email"><?php echo Controller::customize_label('Email');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Email" type="text" class="input-fluid validate[required,custom[email]]" style='height:18px;' name='EMAIL' tabindex="2" autocomplete="off" id="EMAIL">
                            </div>
					</div>
					
										
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
						<?php if($service!='service') { ?>
						<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Name');?>:</label>
							<div class="controls">
                                <input alt="Company Name" type="text" class="input-fluid validate[required]" name="COMPANY_NAME"  autocomplete="off" id="COMPANY_NAME"  disabled>
                            </div>
						</div>
						<?php } ?>
					    <div class="control-group">
                            <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('First Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="First Name" type="text" class="input-fluid validate[required]" name="FIRST_NAME" tabindex="3" autocomplete="off" id="FIRST_NAME">
                            </div>
                        </div>
	
						
						
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					<?php if($service!='service') { ?>
					<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Address');?>:</label>
							<div class="controls">
                                <textarea alt="Company Address" type="text" class="input-fluid validate[required]" name="COMPANY_ADDRESS"  autocomplete="off" id="COMPANY_ADDRESS"  disabled></textarea>
                            </div>
					</div>
					<?php } ?>
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Last Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Last Name" type="text" class="input-fluid validate[required]" name="LAST_NAME" tabindex="4" autocomplete="off" id="LAST_NAME">
                            </div>
					</div>
					
					</div>
					<!--<div class="span10 utopia-form-freeSpace myspace" style="padding-right:50%">					
						 //$this->renderPartial("roles"); 					
                    </div><br/><br/> -->
					<?php if($service=='service') { ?>
					<div class="span4 utopia-form-freeSpace myspace">
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="LAST_NAME" alt="Last Name" ><?php echo Controller::customize_label('Status');?>:</label>
                            <div class="controls" style="padding-top:5px">
                                <input  type="checkbox"  name="status" value="status" tabindex="4" autocomplete="off" id="status">
                            </div>
					</div>
					</div>
					<?php } ?>
				</fieldset>
				<fieldset style="padding-left:4.5%">
				<div><h3>User Features</h3></div>
					<div class="span12 utopia-form-freeSpace myspace">
                        <div class="control-group" style="padding-left:8%" id="user_menus">
							<?php $this->renderPartial("roles"); ?>
						</div>
					</div>
				</fieldset>
                <div class="span10">
                    <div class="controls" style="text-align:right" >
					<br/>
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
<script type="text/javascript" src="js/tags/utopia-tagedit.js"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });

function changethis(ids)
{
$('#CLIENT_ID').val('');
$('#PASSWORD').val('');
$('#USER_NAME').val('');
$.ajax({
        type:'POST', 
        url: 'common/sysdetail', 
		data:'id='+ids.value,
		success: function(response) 
        {
		$('#sysdetails').html(response);
		}
		
});
}
function addlogin(ids)
{
var uname=$('#USER_NAME').val()
var pswd=$('#PASSWORD').val()
var client=$('#CLIENT_ID').val()
$.ajax({
        type:'POST', 
        url: 'common/addlogin', 
		data:'uname='+uname+'&pswd='+pswd+'&client='+client,
		success: function(response) 
        {
		
		}
		
});
}
function blurtext(id)
{

vals = $('#'+id).val();
if(vals!='')
{
var ur=$('#nav_tab').find('.active .user');
ur=ur.html();
$('#loading').show();
$("body").css("opacity","0.4"); 
datastr='cno='+vals+'&ur='+ur;
		$.ajax(
			{
			type:'POST',
			url: 'common/companydetails',
			data: datastr,
			success: function(data) 
				{
					var json;
					try {
					  data1 = $.parseJSON(data);
					} catch (exception) {
					  //It's advisable to always catch an exception since eval() is a javascript executor...
					  json = 'no';
					}
				
				
				if(json == 'no')
				{
					jAlert(data, 'Message');
					$('#COMPANY_NAME').val('');
					$('#COMPANY_ADDRESS').val('');
					$('#'+id).focus();
					$('#'+id).val('');
				}else
				{
					data1 = $.parseJSON(data);
					$('#COMPANY_NAME').val(data1.NAME);
					$('#COMPANY_ADDRESS').val(data1.CITY+','+data1.COUNTRY+','+data1.POSTL_CODE);
				}
				
			$('#loading').hide();
			$("body").css("opacity","1"); 
				}
			});

}
}

</script>
