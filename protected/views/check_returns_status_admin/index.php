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
		if(fd > today || td > today)
		{
		alert('From and To Date should not be greater than Today');
		status=false;
		$('#loading').hide();
		$("body").css("opacity", "1"); 
		}else if(fd>td)
		{
		alert('Fromdate should not be greter than To Date');
		status=false;
		$('#loading').hide();
		$("body").css("opacity", "1"); 
		}
		if(status==true)
		{
		$('#loading').show();
		$("body").css("opacity","0.4"); 
		$("body").css("filter","alpha(opacity=40)"); 
		$.ajax({
			type:'POST', 
			url: 'check_returns_status_admin/Submitform', 
			data:$('#validation').serialize(), 
			success: function(response) 
			{
				$('#loading').hide();
				$("body").css("opacity", "1"); 
				var msg=response.split('!');
				alert(msg[0])
				if(msg[1]=='S')
				{
				var urls = '<?php echo Yii::app()->createAbsoluteUrl("check_returns_status_admin/excel"); ?>?url='+msg[2];
					window.open(urls);
				}	
			 }
		});
		

		}

}
</script>
<section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
				
					<div></div><div class="span12 utopia-form-freeSpace myspace">
                    <div class="control-group">
                            <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" >Type of Account<span> *</span>:</label>
                            <div class="controls " id="RT">
                              
                      <input type='radio' name='user' onclick="changeradio(this);" value="retailer" checked >Retailer Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type='radio' name='user' onclick="changeradio(this);" value="retailerservice" >Retailer Service Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='radio' name='user' value="customer" onclick="changeradio(this);">Customer Service Users
					  </div>
                      </div>
					</div>
					<div class="span12 utopia-form-freeSpace myspace csvc" >
                        <div class="control-group">
                        <label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" ><?php echo Controller::customize_label('Type of Return');?><span> *</span>:</label>
                        <div class="controls" >
                        <input type='radio' name='confirm' value='RP'>Return for Refund &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input type='radio' name='confirm' value='RF'>Return for Replacement &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type='radio' name='confirm' value='FD'>Field Destroy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <input type='radio' name='confirm' value='RR'>Replacement 
                        </div>
					</div>
					</div> 					
					
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
					<div class="span4 utopia-form-freeSpace myspace ">
					<div class="control-group">
					<label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('SoldToID');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" style="width:90%" type="text" class="input-fluid validate[required] " onblur="onblurtext('customer');" name="SOLDTOID" tabindex="3"  autocomplete="off" id="customer">
								<span class='minw' onclick="lookup('Customer Number', 'customer', 'sold_to_customer')" >&nbsp;</span>
                            </div>
					</div>
					</div>
					<div  class="span4 utopia-form-freeSpace myspace ">
					<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Name');?>:</label>
							<div class="controls">
                                <input alt="Company Name" type="text" style="width:100%" class="input-fluid validate[required]" name="COMPANY_NAME"  autocomplete="off" id="COMPANY_NAME"  disabled>
                            </div>
						</div>
					</div>
					<div  class="span3 utopia-form-freeSpace myspace ">
					<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Address');?>:</label>
							<div class="controls">
                                <textarea alt="Company Address" style="width:180%" type="text" class="input-fluid validate[required]" name="COMPANY_ADDRESS"  autocomplete="off" id="COMPANY_ADDRESS"  disabled></textarea>
                            </div>
					</div>
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					
						
						<div class="control-group csvc">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Model Number');?>:</label>
                            <div class="controls" style="margin-left:165px">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Model_number' tabindex="4" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
					
                            </div>
                        </div>
						
						<div class="control-group  rtlr">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Retailer Store');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid" style='height:18px;width:100%' name='Retailer_store' tabindex="4" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
					
                            </div>
                        </div>
					<div class="control-group  rtlr">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Model Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Model_number' tabindex="6" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>	
					
					</div>
					<div class="span4 utopia-form-freeSpace myspace">
					
						
						
						<div class="control-group csvc">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Serial Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Serial_number' tabindex="5" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						
						<div class="control-group rtlr ">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Invoice Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Invoice_number' tabindex="5" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						<div class="control-group rtlr ">
                             <label class="control-label cutz in_custz" for="input01" alt="Street"><?php echo Controller::customize_label('Serial Number');?>:</label>
                            <div class="controls">
                               <input alt="Street" type="text" class="input-fluid " style='height:18px;width:100%' name='Serial_number' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
                        </div>
						
					</div>
					
					<div class="span12 utopia-form-freeSpace myspace csvc">
					<div class="control-group">
                            <label class="control-label cutz in_custz" for="calender" alt=""><?php echo Controller::customize_label('Name');?>:</label>
							<!--<label class="control-label cutz in_custz" for="input01" alt="Street"><?php //echo Controller::customize_label('From');?></label>-->
                            <div class="controls span7">
                                First &nbsp;&nbsp;&nbsp;<input alt="Street" type="text" class="input-fluid " style='height:18px;width:20%' name='FIRST_NAME' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
								Last &nbsp;&nbsp; <input alt="Street" type="text" class="input-fluid " style='height:18px;width:20%' name='LAST_NAME' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" >
							</div>
							
                    </div>
					</div>
					<div class="controls span2" style="margin-left:30%">
                        <button class="btn btn-primary bbt span" position="absolute" align="middle" type="submit" id="subt" tabindex="11">Submit</button>
                        <br><br>
						</div>
				</fieldset>
                        
            </form>
        </div>
    </div>
</section>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
	$('.rtlr').show();
				$('.csvc').hide();
		var rtype='';		
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
	
	function onblurtext(id)
{

vals = $('#'+id).val();
if(vals!='')
{

ur=(rtype=='customer'?'Customer Service Users':rtype);
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

       function changeradio(name)
			{
			if(name.value=='customer')
			{
				$('input:text,textarea:text').val("");
				$('.csvc').show();
				$('.rtcv').hide();
				$('.rtlr').hide();
				
			}else if(name.value=='retailer')
			{
				$('input:text,textarea:text').val("");
				$('.rtlr').show();
				$('.csvc').hide();
				
			}else
			{
				$('.rtlr').show();
				$('.csvc').hide();
				$('input:text,textarea:text').val("");
			}
			$('input:text').val("");
			$('#COMPANY_ADDRESS').val("");
			$('#datepicker1').val(today);
			$('#datepicker').val(today);
			rtype=name.value;
			}
			
</script>