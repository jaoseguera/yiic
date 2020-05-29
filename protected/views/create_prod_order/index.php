<?php
$customize = $model;
$MATERIAL="";
$PLANT="";
$ORDER_TYPE="";
$BASIC_START_DATE="";
$BASIC_END_DATE="";
$QUANTITY="";
$QUANTITY_UOM="";

$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
    $MATERIAL="FL00020";
    $PLANT="1100";
    $ORDER_TYPE="PP01";
    $QUANTITY="2";
    $QUANTITY_UOM="ST";
}
 
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section">
    <div class="row-fluid">
        <div class="utopia-widget-content myspace1">
       
		 <form id="validation" action="javascript:submit_form('validation')" class="form-horizontal">
               
        <div class="span5 utopia-form-freeSpace">
                
                      <fieldset>
                            <div class="control-group">
                             <input type="hidden" name='page' value="bapi">
                            <input type="hidden" name="url" value="create_prod_order"/>
                            <input type="hidden" name="key" value="create_prod_order"/>
                                <label class="control-label cutz" alt="Material" for="date"><?php echo Controller::customize_label('Material');?><span> *</span>:</label>


                                <div class="controls">
<input alt="Material" type="text" id='MATERIAL' name='MATERIAL' class="input-fluid validate[required] getval radiu" title="Material" value="<?php echo $MATERIAL;?>" tabindex="1" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off"/>
<!--<span  class='minw3'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
             
                                   
                                </div>
                            </div>

 
                                     <div class="control-group">
                                <label class="control-label cutz" alt="Plant" for="input01"><?php echo Controller::customize_label('Plant');?><span> *</span>:</label>

                                <div class="controls">
       
  <input alt="Plant" class="input-fluid validate[required,custom[pla]] radius getval" type="text" name='PLANT' value="<?php echo $PLANT;?>"  tabindex="2" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT">
                                    <span class='minw' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</span>
                                    <!--<span  class='minw3'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>  -->                                        </div>
                                </div>
                                
                                
                                  <div class="control-group">
                                <label class="control-label cutz" alt="Order type" for="input01"><?php echo Controller::customize_label('Order type');?><span> *</span>:</label>

                                <div class="controls">
 <input alt="Order type" type="text" class="input-fluid validate[required] " name='ORDER_TYPE' value="<?php echo $ORDER_TYPE;?>" tabindex="3" onKeyUp="jspt('ORDER_TYPE',this.value,event)" autocomplete="off" id="ORDER_TYPE">
                                    <!--<span  class='minw3'  onclick="tipup('BUS2005','CREATE1','ORDERDATA','ORDER_TYPE','Order type','ORDER_TYPE','0')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Order type','ORDER_TYPE','prod_order_type');" >&nbsp;</span>
                                </div>
                                </div>
                                
                                                     
                                <div class="control-group">
                                <label class="control-label cutz" alt="Basic start date" for="input01"><?php echo Controller::customize_label('Basic start date');?><span> *</span>:</label>

                                <div class="controls">
 <input alt="Basic start date" type="text" class="input-fluid validate[required,custom[date]]" name='BASIC_START_DATE' id='datepicker' value="<?php echo $BASIC_START_DATE;?>" tabindex="4">
                                </div>
                                </div>
                  
                        </fieldset>
                
            </div>
            <div class="span5 utopia-form-freeSpace rid">
               
                    <fieldset>
			          
                                
                                
                                    <div class="control-group">
                                <label class="control-label cutz" alt="Basic end date" for="input01"><?php echo Controller::customize_label('Basic end date');?><span> *</span>:</label>

                                <div class="controls">
<input alt="Basic end date" type="text" class="input-fluid validate[required,custom[date]]" name='BASIC_END_DATE' id='datepicker1' value="<?php echo $BASIC_END_DATE;?>" tabindex="5" >
                                </div>
                                </div>
                                
                                
                                    <div class="control-group">
                                <label class="control-label cutz" alt="Quantity" for="input01"><?php echo Controller::customize_label('Quantity');?><span> *</span>:</label>


                                <div class="controls">
 <input alt="Quantity" type="text" class="input-fluid validate[required,custom[number]] " name='QUANTITY' value="<?php echo $QUANTITY;?>" tabindex="6" onKeyUp="jspt('QUANTITY',this.value,event)" autocomplete="off" id="QUANTITY">
                                </div>
                                </div>
                                
                                
                                   <div class="control-group">
                                <label class="control-label cutz" alt="UOM" for="input01"><?php echo Controller::customize_label('UOM');?><span> *</span>:</label>

                                <div class="controls">
 <input  alt="UOM" type="text" class="input-fluid validate[required] " name='QUANTITY_UOM' value="<?php echo $QUANTITY_UOM;?>" tabindex="7" onKeyUp="jspt('QUANTITY_UOM',this.value,event)" autocomplete="off" id="QUANTITY_UOM">
  <!--<span  class='minw3'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','UOM','QUANTITY_UOM','0')" >&nbsp;</span>-->
  <span  class='minw' onclick="lookup('UOM', 'QUANTITY_UOM', 'uom')" >&nbsp;</span>

                                </div>
                                </div>
                                
                                
                           
                             
                                
                                
                                      
                                
                                       
                                
                                
                           </fieldset>
                            </div>
                            <div class="span4 utopia-form-freeSpace">
                <div class="controls">
     <table border="0" cellpadding="10"><tr>
<td>
                                <button class="btn btn-primary span bbt" type="submit" id="subt" tabindex="7">Submit</button></td><td>
                                </td></tr></table>
                               </div>
                           
            </div>

            
             
</form>
        </div>
    </div>
</section>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
		jQuery("#validation").validationEngine();
		
		$('#loading').hide();
		$("body").css("opacity","1");
       
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
       


        // basic
    
    });

  
</script>
</body>
</html>

