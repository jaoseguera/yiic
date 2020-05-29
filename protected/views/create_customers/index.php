<script>
function submitForm() 
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_customers/createcustomer', 
        data:$('#validation').serialize(), 
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
            var sapSystemMessage =  '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
            var message =  '<?=Controller::customize_label(_MESSAGE);?>';
            jAlert(sapSystemMessage+' '+spt[1], message);
            var msg=$.trim(spt[0])
            if(msg=='S')
            {
                $('#validation input:text').val("");
            }
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
                    <fieldset class="marg">
                        <div class="control-group">
                            <input type="hidden" name="url" value="create_customers"/>
                            <label class="control-label cutz in_custz" for="date" alt="Name" ><?=Controller::customize_label(_NAME);?><span> *</span>:</label>
                            <div class="controls">
                                <input   alt="Name" type="text" class="input-fluid  validate[required,custom[onlyLetterSp]]" name="I_NAME" tabindex="1" onKeyUp="jspt('I_NAME',this.value,event)" autocomplete="off" id="I_NAME">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="House No"><?=Controller::customize_label(_HOUSENO);?><span> &nbsp;</span>:</label>
                            <div class="controls">
                                <input alt="House No" type="text" class="input-fluid" style='height:18px;' name='I_HOUSE_NO' tabindex="2" onKeyUp="jspt('I_HOUSE_NO',this.value,event)" autocomplete="off" id="I_HOUSE_NO">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Street"><?=Controller::customize_label(_STREET);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Street" type="text" class="input-fluid validate[required]" style='height:18px;' name='I_STREET' tabindex="2" onKeyUp="jspt('I_STREET',this.value,event)" autocomplete="off" id="I_STREET">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="City"><?=Controller::customize_label(_CITY);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="City" type="text" class="input-fluid validate[required,custom[onlyLetterSp]] " name='I_CITY' tabindex="3" onKeyUp="jspt('I_CITY',this.value,event)" autocomplete="off" id="I_CITY">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="Zip"><?=Controller::customize_label(_POSTALCODE);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Zip" type="text" class="input-fluid validate[required]" name='I_ZIP' tabindex="4" onKeyUp="jspt('I_ZIP',this.value,event)" autocomplete="off" id="I_ZIP">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="input01" alt="State"><?=Controller::customize_label(_STATE);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="State" type="text" class="input-fluid validate[required,custom[onlyLetterSp]] " name='I_STATE' tabindex="5" onKeyUp="jspt('I_STATE',this.value,event)" autocomplete="off" id="I_STATE">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="span5 utopia-form-freeSpace myspace rid" >
                    <fieldset>
                        <div class="control-group" >
                            <label class="control-label cutz" for="select02" alt="Select Country"><?=Controller::customize_label(_COUNTRY);?><span> *</span>:</label>
                            <div class="controls sample-form-chosen">
                                <select id="select02" data-placeholder="Select your country"  class="select_box validate[required]" tabindex="6" name="I_COUNTRY" >
                                    <?=_COUNTRY_OPTS?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="select02" alt="Language"><?=Controller::customize_label(_LANGUAGE);?><span> *</span>:</label>
                            <div class="controls sample-form-chosen">
                                <select id="language" data-placeholder="Select your Language"  class="select_box validate[required]" tabindex="7" name="I_SPRAS" >
                                    <option value=""><?=Controller::customize_label(_SELECTLANGUAGE);?></option>
                                    <option value="EN" selected><?=Controller::customize_label(_ENGLISH);?></option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="input01" alt="Sales Organization"><?=Controller::customize_label(_SALESORGANIZATION);?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Sales Organization" type="text" class="input-fluid validate[required,custom[salesorder]] radius" name='I_SALES_ORG' id='I_SALES_ORG' tabindex="7" onKeyUp="jspt('I_SALES_ORG',this.value,event)" autocomplete="off">
                               <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','I_SALES_ORG','0')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('<?=Controller::customize_label(_SALESORGANIZATION);?>', 'I_SALES_ORG', 'sales_org')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="inputError" alt="Distribution Channel"><?=Controller::customize_label(_DISTRIBUTIONCHANNEL);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Distribution Channel" type="text" class="input-fluid validate[required,custom[dis]] radius" name='I_DIST_CHAN'  id='I_DIST_CHAN' tabindex="8" onKeyUp="jspt('I_DIST_CHAN',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','I_DIST_CHAN','1')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('<?=Controller::customize_label(_DISTRIBUTIONCHANNEL);?>', 'I_DIST_CHAN', 'dist_chan')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" for="date" alt="Division"><?=Controller::customize_label(_DIVISION);?><span> *</span>:</label>
                            <div class="controls">
                                <input  alt="Division" type="text" class="input-fluid validate[required,custom[divi]] radius"  name="I_DIVISION" id='I_DIVISION' tabindex="9" onKeyUp="jspt('I_DIVISION',this.value,event)" autocomplete="off">
                                <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','I_DIVISION','2')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('<?=Controller::customize_label(_DIVISION);?>', 'I_DIVISION', 'division')" >&nbsp;</span>
                                <br/>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="clear"></div>
                <div class="span3">
                    <div class="controls" style="text-align:center">
                        <button class="btn btn-primary bbt span" type="submit" id="subt" tabindex="10"><?=_SUBMIT?></button>
                        <br><br><br><br>
                    </div>
                </div>        
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
</script>