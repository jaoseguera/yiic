<script>
function submitForm1(form) 
{
var vals=$('#UploadForm_file').val();

if(vals=='' || (vals.split('.')[1]!='xls' && vals.split('.')[1]!='xlsx'))
{
    jAlert('Please Select valid xls file for Upload Data.','Message');
	$('#UploadForm_file').val('');
	return false;
}else
{	

	$('#loading').show();
	$("body").css("opacity","0.4"); 
	dataform=new FormData(form);
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'submit_returns/Spreadsheet', 
        data:  new FormData(form),
		contentType: false,
		processData:false,
		cache: false,
        success: function(response) 
        {
            $('#loading').hide();
			$("body").css("opacity", "1"); 
			respons=response.split(':');
            if(respons[1]=='bad')
				jAlert(respons[0],'Message');
			else	
				//swal("Success!", respons[0], "success");
				alert(respons[0]);
			
			if(respons[2]=='ERROR' )
			{
				var urls = '<?php echo Yii::app()->createAbsoluteUrl("submit_returns/Errorexcel"); ?>?url='+respons[1];
				window.open(urls);

			}
			$('#UploadForm_file').val('');
			if(respons[2]== "SUCCESS")
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

}
</script>
<div id='loading' style="padding-top:50px;width:50%" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
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
            <!--<form id="validation" action="javascript:submitForm()" class="form-horizontal">-->
			<?php
				$form = $this->beginWidget(
				'CActiveForm',
					array(
					'id' => 'validation',
					'enableAjaxValidation' => true,
					'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=>"return false;",'class'=>'form-horizontal'),
					)    
				); 
			?>
				<fieldset>
				<?php if($doc->profile->roles=='emg_retailer_service') { ?>
				<div class="span4 utopia-form-freeSpace myspace">
					
					<div class="control-group">
					<label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('SoldToID');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid validate[required] " onblur="blurtext('customer');" name="SOLDTOID" tabindex="1" onKeyUp="jspt('SOLDTOID',this.value,event)" autocomplete="off" id="customer">
								<span class='minw' onclick="lookup('Customer Number', 'customer', 'sold_to_customer')" >&nbsp;</span>
                            </div>
					</div>
				</div>
				<div  class="span4 utopia-form-freeSpace myspace">
				<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Name');?>:</label>
							<div class="controls">
                                <input alt="Company Name" type="text" class="input-fluid validate[required]" name="COMPANY_NAME"  autocomplete="off" id="COMPANY_NAME"  disabled>
                            </div>
						</div>
				</div>
				<div  class="span4 utopia-form-freeSpace myspace">
				<div class="control-group">
                            <label class="control-label cutz" for="ROLE" alt="Role"><?php echo Controller::customize_label('Company Address');?>:</label>
							<div class="controls">
                                <textarea alt="Company Address" type="text" class="input-fluid validate[required]" name="COMPANY_ADDRESS"  autocomplete="off" id="COMPANY_ADDRESS"  disabled></textarea>
                            </div>
					</div>
				</div>
				
					
					<?php } ?>
				<?php /* if ($gs['profile']['roles']=='emg_customer_service') 
					{
					echo '<div></div><div class="span12 utopia-form-freeSpace myspace"> ';
					echo '<div class="control-group">';
							echo '<h3><label class="control-label cutz in_custz" for="input01" style="width:280px;float:left" alt="Street">Type of Return <span> *</span>:&nbsp;&nbsp;</label></h3>';
						echo '<div class="controls">';
							echo "<input type='radio' style='height:18px;' name='confirm' id='confirms'>Return for Refund  &nbsp;&nbsp;";
						
								echo "<input type='radio' style='height:18px;' name='confirm' id='confirms'>Return for Replacement"; 
						echo '</div>';
					echo '</div>';
					echo '</div>';
				
					}	*/
					?> 
						

				</fieldset>
				<div class="span8 utopia-form-freeSpace myspace"> 
						<div class="control-group">
                            
                            
							<label class="control-label cutz in_custz" for="FIRST_NAME" alt="First Name" style="width:280px;float:left" >Spreadsheet with Returns information<span> *</span>:&nbsp;&nbsp;&nbsp;</label> 
                      <div class="controls">
					  <?php echo $form->fileField($model, 'file',array('class'=>'btn-info','style'=>'overflow:hidden;height:120%')); ?>
					  </div>

</div>
</div>
<?php echo '<div align="center" class="control-group span8">';
					echo '<div class="div-submit-btn">';
					echo CHtml::submitButton('Submit',array('onkeypress'=>'return event.keyCode != 13;','onclick'=>'return submitForm1(this.form);','class'=>'span2 btn btn-primary ',) ) ;	
						echo '</div>';
						echo '</div>';
						echo '</div>';
				 $this->endWidget(); ?>
                     
            

    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine();  });

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