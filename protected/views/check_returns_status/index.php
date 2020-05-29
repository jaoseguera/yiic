<script>
function submitForm() 
{
		var status=true;
		var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
		var fd=$('#datepicker').val();
		var td=$('#datepicker1').val();
		if($('#RT').length>0 )
		{
		if($("#RT input[type='radio']:checked").val()==undefined)
		{
		alert('Please Select Valid Return Type');
		$('#loading').hide();
		$("body").css("opacity", "1"); 
		status=false;
		}
		}
	
		if(status==true)
		{
		$('#loading').show();
		$("body").css("opacity","0.4"); 
		$("body").css("filter","alpha(opacity=40)"); 
		$.ajax({
			type:'POST', 
			url: 'check_returns_status/Submitform', 
			data:$('#validation').serialize(), 
			success: function(response) 
			{
				$('#loading').hide();
				$("body").css("opacity", "1"); 
				var msg=response.split('!');
				alert(msg[0])
				if(msg[1]=='S')
				{
				var urls = '<?php echo Yii::app()->createAbsoluteUrl("check_returns_status/excel"); ?>?url='+msg[2];
					window.open(urls);
				}	
			 }
		});
		

		}
}
</script>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
$this->renderPartial('lookup');
	$customize 	= $model;
	$client 	= Controller::userDbconnection();
	$user_ID	= Yii::app()->user->getState("user_id");
	$doc		= $client->getDoc($user_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	
?>
<section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" onkeypress="return event.keyCode != 13;" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
				
				<?php if ($gs['profile']['roles']=='emg_customer_service') 
					{ ?>
					<div></div>
					<div class="span12 utopia-form-freeSpace myspace" >
                        <div class="control-group">
                        <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('Type of Return');?><span> *</span>:</label>
                        <div class="controls" id="RT">
                        <input type='radio' name='confirm' value='RF' checked ><span style="align:middle">Return for Refund &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					    <input type='radio' name='confirm' value='RP'>Return for Replacement &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input type='radio' name='confirm' value='FD' align="middle">Field Destroy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input type='radio' name='confirm' value='RR' align="middle">Replacement 
                        </div>
					</div>
					</div>
					
		<?php } else echo '<div></div><div></div>'; ?>
					<?php if($gs['profile']['roles']=='emg_retailer_service') { ?>
				<div class="span4 utopia-form-freeSpace myspace">
					
					<div class="control-group">
					<label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('SoldToID');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" style="width:90%" type="text" class="input-fluid validate[required] " onblur="blurtext('customer');" name="SOLDTOID" tabindex="3" onKeyUp="jspt('SOLDTOID',this.value,event)" autocomplete="off" id="customer">
								<span class='minw' onclick="lookup('Customer Number', 'customer', 'sold_to_customer')" >&nbsp;</span>
                            </div>
					</div>
				</div>
				<div  class="span4 utopia-form-freeSpace myspace">
				<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Name');?>:</label>
							<div class="controls">
                                <input alt="Company Name" type="text" style="width:100%" class="input-fluid validate[required]" name="COMPANY_NAME"  autocomplete="off" id="COMPANY_NAME"  disabled>
                            </div>
						</div>
				</div>
				<div  class="span3 utopia-form-freeSpace myspace">
				<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Address');?>:</label>
							<div class="controls">
                                <textarea alt="Company Address" style="width:180%" type="text" class="input-fluid validate[required]" name="COMPANY_ADDRESS"  autocomplete="off" id="COMPANY_ADDRESS"  disabled></textarea>
                            </div>
					</div>
				</div>
				
					
					<?php } ?>
					<div class="span12 utopia-form-freeSpace myspace">
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="calender" alt=""><?php echo Controller::customize_label('Calender Period');?><span> *</span>:</label>
							<!--<label class="control-label cutz in_custz" for="input01" alt="Street"><?php //echo Controller::customize_label('From');?></label>-->
                            <div class="controls span7">
                               From &nbsp;&nbsp;<input alt="Street" type="text" class="input-fluid validate[required] " style='height:18px;width:20%' name='FROM_DATE' tabindex="1" onKeyUp="jspt('FROM_DATE',this.value,event)" autocomplete="off" id="datepicker">
								&nbsp; To &nbsp;&nbsp;<input alt="Street" type="text" class="input-fluid validate[required] " style='height:18px;width:20%' name='TO_DATE' tabindex="2" onKeyUp="jspt('TO_DATE',this.value,event)" autocomplete="off" id="datepicker1">
							</div>
					</div>
					</div>
					
					<div class="span4 utopia-form-freeSpace myspace">
					
						<?php if ($gs['profile']['roles']=='emg_customer_service') 
					{ ?>
						<div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Model Number');?>:</label>
                            <div class="controls" style="margin-left:165px">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Model_number' tabindex="4" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
					
                            </div>
                        </div>
						
					<?php } else {?>
					
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Retailer Store');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid" style='height:18px;width:100%' name='Retailer_store' tabindex="4" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
					
                            </div>
                        </div>
					<div class="control-group">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Model Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Model_number' tabindex="6" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>	
					<?php } ?>
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					
						
						<?php if ($gs['profile']['roles']=='emg_customer_service') 
					{ ?>
						<div class="control-group">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Serial Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Serial_number' tabindex="5" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						<?php } else { ?>
						<div class="control-group">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Invoice Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Invoice_number' tabindex="5" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						<div class="control-group">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Serial Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Serial_number' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						<?php } ?>
					</div>
					<?php if ($gs['profile']['roles']=='emg_customer_service') 
					{ ?>
					<div class="span12 utopia-form-freeSpace myspace">
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="calender" alt=""><?php echo Controller::customize_label('Name');?>:</label>
							<!--<label class="control-label cutz in_custz" for="input01" alt="Street"><?php //echo Controller::customize_label('From');?></label>-->
                            <div class="controls span7">
                                First &nbsp;&nbsp;&nbsp;<input alt="Street" type="text" class="input-fluid " style='height:18px;width:20%' name='FIRST_NAME' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
								Last &nbsp;&nbsp; <input alt="Street" type="text" class="input-fluid " style='height:18px;width:20%' name='LAST_NAME' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
							
                    </div>
					</div>
					<?php } ?>
					<div class="controls span2" style="margin-left:30%">
                        <button class="btn btn-primary bbt span" position="absolute" align="middle" type="submit" id="subt" tabindex="11">Submit</button>
                        <br><br>
						</div>
                    					
				</fieldset>
                       
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
	
	 var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
        $('#datepicker').val(today);

        $('#datepicker').datepicker({
            format: 'mm/dd/yyyy',
            weekStart: '0',
			autoclose:true
        }).on('changeDate', function()
	{
		$('.datepickerformError').hide();
	});
		
		 $('#datepicker1').val(today);

        $('#datepicker1').datepicker({
            format: 'mm/dd/yyyy',
            weekStart: '0',
			autoclose:true
        }).on('changeDate', function()
	{
		$('.datepicker1formError').hide();
	});
    function blurtext(id)
{

vals = $('#'+id).val();
if(vals!='')
{

$('#loading').show();
$("body").css("opacity","0.4"); 
datastr='cno='+vals+'&ur=Retailer Service Users';
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
					$('#'+id).val('');
					$('#COMPANY_NAME').val('');
					$('#COMPANY_ADDRESS').val('');
					$('#'+id).focus();
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
