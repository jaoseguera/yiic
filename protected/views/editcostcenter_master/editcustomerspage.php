<?php // This is a Proof-of-Concept version that has not been reviewed. ?>
<script>

$(document).ready(function() {
    $('.ALL').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.chkSelect').each(function() { //loop through each checkbox
                this.checked = true; 
				var cls=this.value;
				$('.'+cls).attr("readonly", false);
				//select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.chkSelect').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1" 
				var cls=this.value;
			$('.'+cls).attr("readonly", true);				
            });        
        }
    });
	$('.chkSelect').change(function(){
	
	if(this.checked==true)
	{
	var cls=this.value;
	$('.'+cls).attr("readonly", false);
	}else
	{
	var cls=this.value;
	$('.'+cls).attr("readonly", true);
	
	}
	
	});
   
});
function changeedit()
{
$('#li_1').removeClass("active");
$('#li_2').addClass("active");
$('#tab41').css({display:'none'}); 
$('#tab42').css({display:'block'});	
$('#tab41').removeAttr("data-toggle","tab");
$('#validation1 input:text').val("");
$('#t41').html('Cost Center');
getBapitable("example40_today","BAPI0012_2","example40","L","show_menu@<?php echo 1032;?>","Editcostcenter_master","submit");
}
$(document).ready(function() {
    jQuery("#validation1").validationEngine();
    $(".read").attr('readonly','readonly');
	if($('#save_id').length<0)
	{
		$(".ALL").attr('readonly','readonly');
		$(".chkSelect").attr('readonly','readonly');
	}	
});
function cancels() { $('#calt').hide(); }
function edit_customer()
{
    $("#validation1").validationEngine();
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
var c_Area=$('#C_AREA').val();
    $.ajax({type:'POST',
            url: 'Editcostcenter_master/edit_costcenter', 
            data:$('#validation1').serialize()+'&C_AREA='+c_Area, 
            success: function(response) {
                    $('#loading').hide();
                    $("body").css("opacity","1");
					var spt=response.split("@");
					var msg=$.trim(spt[0]);
					if(msg=='S' || msg=='W')
					{
						jAlert('<b>SAP System Message:</b><br>'+spt[1], 'Message',function(){
						changeedit();
						});
					}else
						jAlert('<b>SAP System Message:</b><br>'+spt[1], 'Error');
				
			}
			
    });
}
function ss()
{
	$(".read").removeAttr('readonly');
	$('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">Save</button>');
	$('#can_id').show();
}

</script>
<style>.top { background-image: url("<?php echo Yii::app()->request->baseUrl; ?>/images/tab_head.png") !important; }
/*.head_icons { width: 951px !important;}*/</style>
<?php 
$items=$_SESSION['ITEM'];
$FD=$items['VALID_FROM'];
$year = substr($FD, 0, 4);
			$mm   = substr($FD, 4, 2);
			$dd   = substr($FD, 6, 2);
			$FD = $mm."/".$dd."/".$year;
			$TD=$items['VALID_TO'];
$year = substr($TD, 0, 4);
			$mm   = substr($TD, 4, 2);
			$dd   = substr($TD, 6, 2);
			$TD = $mm."/".$dd."/".$year;
?>

	<div id="editcustomers_page" style=""><section id='utopia-wizard-form' class="utopia-widget cancel editcustomers_page" style="border:none;">
		<div>
			<div class="utopia-widget-content">
				<form id="validation1" action="javascript:edit_customer()" class="form-horizontal editcus" >
					<input type="hidden" name="url" value="change_costcenter"/>
					<input type="hidden" name="CUSTOMERNO" value="<?php echo $items['COSTCENTER'];?>"/>
					
					<div class="span12">
					
					<div class="span6 utopia-form-freeSpace myspace1" id="leftform">
					<fieldset> 
					
						<div class="control-group">
						
						<div class="controls">
						<label class="control-label cutz" for="input01" alt='Name'><h3>Existing Data</h3></label>
						<br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='Name'><?php echo Controller::customize_label('Name');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid minw1  read" type="text" name='NAME_OLD'  value="<?php echo $items['NAME'];?>">
						<br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="Houseno" alt='House No'><?php echo Controller::customize_label('Description');?>:</label>
						<div class="controls">
						<input class="input-fluid  minw1 read" type="text"  name="DESCRIP_OLD"  value="<?php echo $items['DESCRIPT'];?>"> <br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="inputError" alt='Street'><?php echo Controller::customize_label('Cost Center');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid minw1 read" type="text" name='CC_OLD' value="<?php echo ltrim($items['COSTCENTER'],"0");?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='Postal Code'><?php echo Controller::customize_label('Person Responsible');?><span>*</span>:</label>
						<div class="controls">
						<input class="input-fluid  minw1 read" type="text"  name="PERSON_IN_OLD"  value="<?php echo $items['PERSON_IN_CHARGE'];?>"> <br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="date" alt='City'><?php echo Controller::customize_label('Cost Center Category');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid  minw1 read" type="text" name="CC_TYPE_OLD" value="<?php echo $items['COSTCENTER_TYPE'];?>"><br/>
						</div>
						</div>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='State'><?php echo Controller::customize_label('Hierarchy Area');?><span>*</span>:</label>
						<div class="controls">
						<input  class="input-fluid  minw1 read" type="text" name='HIER_OLD'value="<?php echo $items['COSTCTR_HIER_GRP']; ?>"><br/>
						</div>
						</div>
						<div class="control-group ">
								<label class="control-label cutz" for="select02" alt='Country'><?php echo Controller::customize_label('Company Code');?><span>*</span>:</label>
								
								<div class="controls">
								<input type="text" name='C_CODE_OLD' id='C_CODE_OLD' readonly  class="input-fluid getval radius " value="<?php echo $items['COMP_CODE'];?>"/>
							
							</div>
						</div>
							
							<div class="control-group">
								<label class="control-label cutz" for="input01" alt='Sales Organization'><?php echo Controller::customize_label('From Date');?><span>*</span>:</label>
								<div class="controls">
								<input type="text" name='F_DATE_OLD' id='F_DATE_OLD' class="input-fluid getval radius read" value="<?php echo $FD;?>" />
                                    <!--<span class='minw' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
                                    
								</div>
							</div>
							<div class="control-group">
								<label class="control-label cutz" for="input01" alt='Distribution. Channel'><?php echo Controller::customize_label('To Date');?><span>*</span>:</label>
								<div class="controls">
								<input type="text" name='T_DATE_OLD' id='T_DATE_OLD' class="input-fluid getval radius read" value="<?php echo $TD;?>" >
                                    <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>-->
                                    
								</div>
							</div>
							
					</fieldset></div>
					
					<div class="span2 utopia-form-freeSpace myspace1" >
					<fieldset>
					<div class="control-group" style="margin-top:-10px;">
						<span style="margin-left:-20px;"><b>Select All</b></span> <br/> <input  type="checkbox" class="ALL"  value="ALL"  name='ALL' >
						</div>
					<div class="control-group" style="margin-top:30px">
						<input  type="checkbox"    name='chkSelect' class="chkSelect" value="NAME_NEW" >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input   type="checkbox" name='chkSelect' class="chkSelect" value="DESCRIP_NEW">
						</div>
					<div class="control-group" style="margin-top:30px">
						<!--<input    type="checkbox" class="chkSelect" value="CC_NEW" name='chkSelect' />-->
						<br/>
						</div>
					<div class="control-group" style="margin-top:20px">
						<input    type="checkbox" name='CHKPCODE' value="PERSON_IN_NEW" class="chkSelect"  >
					</div>
					<div class="control-group" style="margin-top:30px">
						<!--<input   class="chkSelect" type="checkbox" value="CC_TYPE_NEW" name='chkSelect' >-->
						<br/>
					</div>
					<div class="control-group" style="margin-top:20px">
						<input   class="chkSelect" type="checkbox" value="HIER_NEW" name='chkSelect' >
					</div>
					<div class="control-group" style="margin-top:20px">
						<!--<input  class="chkSelect" type=""  value="C_CODE_NEW" name='chkSelect' >-->
					<br/>
					</div>
					<div class="control-group" style="margin-top:30px">
					
						<input   class="chkSelect" type="checkbox" name='F_DATE_NEW' value="SALES_ORG" >
					</div>
					<div class="control-group" style="margin-top:30px">
						<input  class="chkSelect" type="checkbox" name='T_DATE_NEW' value="DIST_CNL">
					</div>
					
					
					</fieldset>
					</div>
					<div class="span4 utopia-form-freeSpace myspace1" style="margin-left:-40px;">
					
					<fieldset>
						<div class="control-group">
						<label class="control-label cutz" for="input01" alt='Name'><h3>Proposed Data</h3></label>
						<br/>
						
						</div>					
						
						<div class="control-group">
						
						<input  class="input-fluid minw1  NAME_NEW"  type="text" name='NAME_NEW' readonly value="<?php echo $items['NAME'];?>">
						
						
						</div>
						<div class="control-group">
						<input  class="input-fluid  minw1 DESCRIP_NEW" type="text" name='DESCRIP_NEW' placeholder="Old House No" readonly value="<?php echo $items['DESCRIPT'];?>">
						
						</div>
						<div class="control-group">
						<input  class="input-fluid  minw1 CC_NEW" type="text" name='CC_NEW'  readonly value="<?php echo ltrim($items['COSTCENTER'],"0");?>">
						
						</div>
						<div class="control-group">
						<input class="input-fluid minw1 PERSON_IN_NEW" type="text"  name="PERSON_IN_NEW"  readonly value="<?php echo $items['PERSON_IN_CHARGE'];?>"> 
						
						</div>
						<div class="control-group">
						<input  class="input-fluid  minw1 CC_TYPE_NEW" type="text"  readonly name="CC_TYPE_NEW" value="<?php echo $items['COSTCENTER_TYPE'];?>">
						
						</div>
						<div class="control-group">
						<input  class="input-fluid minw1 HIER_NEW" type="text" readonly  name='HIER_NEW' value="<?php echo $items['COSTCTR_HIER_GRP'];?>">
						
						</div>
						
							
							<div class="control-group">
								<input type="text" name='C_CODE_NEW' id='C_CODE_NEW' placeholder="" readonly class="C_CODE_NEW input-fluid getval radius " value="<?php echo $items['COMP_CODE'];?>" />
								 
							</div>
							
							<div class="control-group">
								<input type="text" name='F_DATE_NEW' id='F_DATE_NEW' placeholder="" readonly class="F_DATE_NEW input-fluid getval radius " value="<?php echo $FD;?>" />
								
							</div>
							<div class="control-group">
								<input type="text" name='T_DATE_NEW' id='T_DATE_NEW' placeholder="" readonly class="input-fluid T_DATE_NEW getval radius " value="<?php echo $TD;?>"/>
                            
							</div>
							
					</fieldset></div>
					</div>
					
					<div class="span12 utopia-form-freeSpace bbr" style="padding-bottom:10px;"id="bottomform">
						<div style="padding-left:20%">
							<table><tr><td>&nbsp;</td><td>
							<table><tr><td><button class="btn btn-primary spanbt span2" type="submit" id="save_id" style="min-width:70px">Submit</button></td><td>&nbsp;</td>
							
							<td><button class="btn spanbt span2" type="button" id="can_id" style="min-width:60px;" onclick="return changeedit()">Cancel</button></td></tr>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section></div><?php  
/* } */
?>
