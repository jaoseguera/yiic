<script>
function changesave()
{
	var save = '<?=Controller::customize_label(_SAVE);?>';
    $(".read").removeAttr('readonly');		
    $('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">'+save+'</button>');
    $('#can_id').show();
}
function changeedit()
{	
	var edit = '<?=Controller::customize_label(_EDIT);?>';
    $(".read").attr("readonly", true);
    $('#save_id').replaceWith('<button class="btn  spanbt span2 back_b" type="button" id="edit" Onclick="ss()" style="min-width:70px;">'+edit+'</button>');
    $('#can_id').hide();
}
$(document).ready(function() {
    jQuery("#validation1").validationEngine();
    $(".read").attr('readonly','readonly');
});

function cancels() { $('#calt').hide(); }
function edit_customer()
{
    $("#validation1").validationEngine();
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 

    $.ajax({type:'POST',
            url: 'common/edit_customers', 
            data:$('#validation1').serialize(), 
            success: function(response) {
                    $('#loading').hide();
                    $("body").css("opacity","1"); 
					var sapSystemMessage = '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
					var message = '<?=Controller::customize_label(_MESSAGE);?>';
                    jAlert(sapSystemMessage+' '+response, message);
            }
    });
}

function ss()
{	
	var save = '<?=Controller::customize_label(_SAVE);?>';
	$(".read").removeAttr('readonly');
	$('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">'Save'</button>');
	$('#can_id').show();
}
</script>
<style>.top { background-image: url("<?php echo Yii::app()->request->baseUrl; ?>/images/tab_head.png") !important; }
/*.head_icons { width: 951px !important;}*/</style>
<?php 
foreach($_SESSION['edit_cus'] as $hs=>$ej)
{
	?><div id="editcustomers_page" style="display:none"><section id='utopia-wizard-form' class="utopia-widget cancel editcustomers_page" style="border:none;">
		<div>
			<div class="utopia-widget-content">
				<form id="validation1" action="javascript:edit_customer()" class="form-horizontal editcus" >
					<input type="hidden" name="bapiName" value="BAPI_CUSTOMER_CHANGEFROMDATA"/>
					<input type="hidden" name="CUSTOMERNO" value="<?php echo $ej['CUSTOMER'];?>"/>
					<div class="span4 utopia-form-freeSpace myspace1" id="leftform">
					<fieldset class="marg"> 
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='Name'><?=Controller::customize_label('Name');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid validate[required,custom[onlyLetterSp]] minw1  read" type="text" name='NAME'  value="<?php echo $ej['NAME'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="inputError" alt='Street'><?=Controller::customize_label(_STREET);?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid validate[required] minw1 read" type="text" name='STREET' value="<?php echo $ej['STREET'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='Postal Code'><?=Controller::customize_label(_POSTALCODE);?><span>*</span>:</label>
						<div class="controls">
						<input class="input-fluid validate[required] minw1 read" type="text"  name="POSTL_CODE"  value="<?php echo $ej['POSTL_COD1'];?>"> <br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='City'><?=Controller::customize_label(_CITY);?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid  validate[required,custom[onlyLetterSp]] minw1 read" type="text" name="CITY" value="<?php echo $ej['CITY'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='State'><?=Controller::customize_label(_STATE);?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid validate[required,custom[onlyLetterSp]] minw1 read" type="text" name='REGION'value="<?php echo $ej['REGION'];?>"><br/>
						</div>
						</div>
					</fieldset></div>
					
					<div class="span4 utopia-form-freeSpace myspace1 rid1" id="rightform">
						<fieldset >  
							<div class="control-group ">
								<label class="control-label cutz" for="select02" alt='Country'><?=Controller::customize_label(_COUNTRY);?><span>*</span>:</label>
								<div class="controls sample-form-chosen" >
									<select id="select02" data-placeholder="<?=Controller::customize_label(_SELECTCOUNTRY);?>"  class="input-fluid validate[required]  minw1 read select_box1"  tabindex="7"  name="COUNTRY" style="height:30px;">
										<option value="<?php echo $ej['COUNTRY'];?>"><?php echo $ej['COUNTRY'];?></option>
										<?=_COUNTRY_OPTS?>
									</select><br/>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label cutz" for="input01" alt='Sales Organization'><?=Controller::customize_label(_SALESORGANIZATION);?><span>*</span>:</label>
								<div class="controls">
								<input type="text" name='PI_SALESORG' id='SALES_ORG' class="input-fluid validate[required,custom[number]] getval radius read"/>
                                    <!--<span class='minw' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Sales Organization', 'SALES_ORG', 'sales_org')" >&nbsp;</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label cutz" for="input01" alt='Distribution. Channel'><?=Controller::customize_label(_SALESORGANIZATION);?><span>*</span>:</label>
								<div class="controls">
								<input type="text" name='PI_DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required,custom[dis]] getval radius read"/>
                                    <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Distribution Channel', 'DISTR_CHAN', 'dist_chan')" >&nbsp;</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label cutz" for="input01" alt='Division'><?=Controller::customize_label(_DIVISION);?><span>*</span>:</label>
								<div class="controls">
								<input type="text" name='PI_DIVISION' id='DIVISION' class="input-fluid validate[required,custom[divi]] getval radius read"/>
                                    <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','DIVISION','2')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Division', 'DIVISION', 'division')" >&nbsp;</span>
								</div>
							</div>
					</fieldset></div>
					<div class="span6 utopia-form-freeSpace bbr" style="padding-bottom:10px;"id="bottomform">
						<div >
							<table><tr><td><button class="btn btn-primary spanbt span2 back_b" type="button" id='edit' style="min-width:70px;" onclick="return changesave()"><?=_EDIT?></button></td><td>&nbsp;</td><td>
							<button class="btn spanbt span2" type="button" id="can_id" style="min-width:60px;display:none;" onclick="return changeedit()"><?=_CANCEL?></button></td></tr>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section></div><?php  
} 
?>