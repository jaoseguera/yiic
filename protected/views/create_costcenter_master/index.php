<?php // This is a Proof-of-Concept version that has not been reviewed. ?>
<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_costcenter_master/createcostcenter', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
            
            var msg=$.trim(spt[0])
            if(msg=='S')
            {
				jAlert(spt[1], 'Message');
                $('#validation input:text').val("");
            }else
				jAlert(spt[1], 'Message');
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

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php
$customize = $model;
?><section id="formElement" class="utopia-widget utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal" >
			
                <div class="span5 utopia-form-freeSpace myspace" >
                    <fieldset class="">
                        <div class="control-group">
                            <input type="hidden" name="url" value="create_costcenter"/>
                            <label class="control-label cutz in_custz" for="date" alt="Name" ><?php echo Controller::customize_label('Name');?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid  validate[required]" name="I_NAME" tabindex="1" onKeyUp="jspt('I_NAME',this.value,event)" autocomplete="off" id="I_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="House No"><?php echo Controller::customize_label('Cost Center');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="House No" type="text" class="input-fluid validate[required]" style='height:18px;' name='CC' tabindex="2" onKeyUp="jspt('CC',this.value,event)" autocomplete="off" id="CC">
                            </div>
                        </div>
						<div class="control-group">
                            <label class="control-label cutz" for="input01" alt="Sales Organization"><?php echo Controller::customize_label('Controlling Area');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Sales Organization" type="text" class="input-fluid validate[required] radius" name='C_AREA' id='C_AREA' tabindex="7" onKeyUp="jspt('C_AREA',this.value,event)" autocomplete="off">
                               <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','I_SALES_ORG','0')" >&nbsp;</span>
                                <span class='minw' onclick="lookup('Sales Organization', 'I_SALES_ORG', 'sales_org')" >&nbsp;</span>-->
                                <br/>
                            </div>
                        </div>
						<div class="control-group">
                            <label class="control-label cutz" for="date" alt="Division"><?php echo Controller::customize_label('Cost Center Category');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Division" type="text" class="input-fluid validate[required] radius"  name="CCC" id='CCC' tabindex="9" onKeyUp="jspt('CCC',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','I_DIVISION','2')" >&nbsp;</span>
                                <span class='minw' onclick="lookup('Division', 'I_DIVISION', 'division')" >&nbsp;</span>-->
                                <br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="City"><?php echo Controller::customize_label('Valid From');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="City" type="text" class="input-fluid validate[required] " name='F_DATE' tabindex="3" onKeyUp="jspt('F_DATE',this.value,event)" autocomplete="off" id="datepicker">
                            </div>
                        </div>
						 
                    </fieldset>
                </div>
                <div class="span5 utopia-form-freeSpace myspace rid" >
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label cutz" for="input01" alt="Sales Organization"><?php echo Controller::customize_label('Description');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Sales Organization" type="text" class="input-fluid radius" name='DESCRIPT' id='DESCRIPT' tabindex="7" onKeyUp="jspt('DESCRIPT',this.value,event)" autocomplete="off">
                               <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','I_SALES_ORG','0')" >&nbsp;</span>
                                <span class='minw' onclick="lookup('Sales Organization', 'I_SALES_ORG', 'sales_org')" >&nbsp;</span>-->
                                <br/>
                            </div>
                        </div>
												
                        <div class="control-group">
                            <label class="control-label cutz" for="input01" alt="Sales Organization"><?php echo Controller::customize_label('Company Code');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Sales Organization" type="text" class="input-fluid validate[required] radius" name='CMP_CODE' id='CMP_CODE' tabindex="7" onKeyUp="jspt('CMP_CODE',this.value,event)" autocomplete="off">
                               <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','I_SALES_ORG','0')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Company Code', 'COMP_CODE', 'company_code')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                        
						<div class="control-group">
                            <label class="control-label cutz" for="date" alt="Division"><?php echo Controller::customize_label('Hierarchy area');?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Division" type="text" class="input-fluid validate[required] radius"  name="HI_AREA" id='HI_AREA' tabindex="9" onKeyUp="jspt('HI_AREA',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','I_DIVISION','2')" >&nbsp;</span>
                                <span class='minw' onclick="lookup('Division', 'I_DIVISION', 'division')" >&nbsp;</span>-->
                                <br/>
                            </div>
                        </div>
						<div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Zip"><?php echo Controller::customize_label('Person Responsible');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Zip" type="text" class="input-fluid validate[required]" name='PER_RES' tabindex="4" onKeyUp="jspt('PER_RES',this.value,event)" autocomplete="off" id="PER_RES">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="inputError" alt="Distribution Channel"><?php echo Controller::customize_label('Valid To');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Distribution Channel" type="text" class="input-fluid validate[required] radius" name='T_DATE'  id='datepicker1' tabindex="8" onKeyUp="jspt('T_DATE',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','I_DIST_CHAN','1')" >&nbsp;</span>
                                <span class='minw' onclick="lookup('Distribution Channel', 'I_DIST_CHAN', 'dist_chan')" >&nbsp;</span>-->
                                <br/>
                            </div>
                        </div>
						
                    </fieldset>
                </div>
				<div class="clear"></div>
                <div class="span3">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span" type="submit" id="subt" tabindex="10">Submit</button>
                        <br><br><br><br>
                    </div>
                </div>        
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
$('#datepicker, #datepicker1').datepicker({
format: 'mm/dd/yyyy',
weekStart: '0',
        autoclose:true
}).on('changeDate', function()
{
$('.datepickerformError').hide();
});


	jQuery("#validation").validationEngine(); });
</script>