<?php
if(isset($_REQUEST['titl']))
{
    ?><script>
    $(document).ready(function()
    {
        parent.titl("<?php echo $_REQUEST['titl'];?>");
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    });
    </script><?php 
}
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php

$header_txt = "";
$comp_code  = "";
$ref_doc_no = "";
$gl_account = "";
$item_text  = "";
$amt_doccur = "";
$doc_date   = "";
$pstng_date = "";

if(isset($_REQUEST['CUSTOMER']))
    $customer=$_REQUEST['CUSTOMER'];
else
    $customer="";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210') 
{
    $header_txt = "jjj";
    $comp_code  = "1000";
    $ref_doc_no = "1";
    $gl_account = "113005";
}

$customize = $model;
?><section id="formElement" class="utopia-widget utopia-form-box section">
    <div class="row-fluid">
        <div class="utopia-widget-content myspace1" >
            <form id="post_inc_validation" action="javascript:submit_form('post_inc_validation')" class="form-horizontal">
                <div class="span5 utopia-form-freeSpace">            
                    <fieldset>
                        <div class="control-group">
                            <input type="hidden" name='page' value="bapi">
                            <input type="hidden" name="url" value="post_incoming_payment"/>
                            <input type="hidden" name="key" value="post_incoming_payment"/>
                            <label class="control-label cutz" alt="Header Text" for="date"><?php echo Controller::customize_label('Header Text');?>:</label>
                            <div class="controls">
                                <input alt="Header Text" class="input-fluid" type="text" name="HEADER_TXT" value="<?php echo $header_txt;?>" onKeyUp="jspt('HEADER_TXT',this.value,event)" autocomplete="off" id="HEADER_TXT">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Company Code" for="input01"><?php echo Controller::customize_label('Company Code');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Company Code" class="input-fluid validate[required] " type="text" name='COMP_CODE' value="<?php echo $comp_code;?>" onKeyUp="jspt('COMP_CODE',this.value,event)" autocomplete="off" id="COMP_CODE">
                                <!--<span  class='minw'  onclick="tipup('BUS0002','GETLIST','COMPANYCODELIST','COMP_CODE','Company Code','COMP_CODE','0')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Company Code', 'COMP_CODE', 'company_code')" >&nbsp;</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Document Date" for="input01"><?php echo Controller::customize_label('Document Date');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Document Date" class="input-fluid validate[required,custom[date]] " type="text" name='DOC_DATE' id='datepicker' value="<?php echo $doc_date;?>" >
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Posting Date" for="input01"><?php echo Controller::customize_label('Posting Date');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Posting Date" class="input-fluid validate[required,custom[date]] " type="text" name='PSTNG_DATE' id='datepicker1' value="<?php echo $pstng_date;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Reference" for="input01"><?php echo Controller::customize_label('Reference');?>:</label>
                            <div class="controls">
                                <input alt="Reference" class="input-fluid" type="text" name='REF_DOC_NO' value="<?php echo $ref_doc_no;?>" onKeyUp="jspt('REF_DOC_NO',this.value,event)" autocomplete="off" id="REF_DOC_NO">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="span5 utopia-form-freeSpace">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label cutz" alt="GL Account" for="date"><?php echo Controller::customize_label('GL Account');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="GL Account" class="input-fluid  validate[required] " type="text" name="GL_ACCOUNT" value="<?php echo $gl_account;?>" onKeyUp="jspt('GL_ACCOUNT',this.value,event)" autocomplete="off" id="GL_ACCOUNT"><span  class='minw'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMACCOUNTASSIGNM','G_L_ACCT','GL Account','GL_ACCOUNT','0@GL_ACCT_CA_NO')" >&nbsp;</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Item Text" for="input01"><?php echo Controller::customize_label('Item Text');?>:</label>
                            <div class="controls">
                                <input alt="Item Text" class="input-fluid" type="text" name='ITEM_TEXT' value="<?php echo $item_text;?>" onKeyUp="jspt('ITEM_TEXT',this.value,event)" autocomplete="off" id="ITEM_TEXT">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Customer Number" for="input01"><?php echo Controller::customize_label('Customer Number');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Customer Number" class="input-fluid validate[required,custom[customer]] radius" type="text" name='CUSTOMER'  id="CUSTOMER" value="<?php echo $customer;?>" onKeyUp="jspt('CUSTOMER',this.value,event)" autocomplete="off"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','CUSTOMER','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'CUSTOMER', 'sold_to_customer')" >&nbsp;</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label cutz" alt="Amount" for="input01"><?php echo Controller::customize_label('Amount');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Amount" class="input-fluid validate[required] " type="text" name='AMT_DOCCUR' value="<?php echo $amt_doccur;?>" onKeyUp="jspt('AMT_DOCCUR',this.value,event)" autocomplete="off" id="AMT_DOCCUR">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="span4 utopia-form-freeSpace">
                    <div class="controls">
                        <table border="0" cellpadding="10" style="margin-left:20px;">
                            <tr>
                                <td>
                                    <input class="btn btn-primary spanbt bbt" type="submit" name="submit" value="<?php echo _SUBMIT ?>"></td><td>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>

<script type="text/javascript">
$(document).ready(function () 
{
    var today = new Date();
    var dd    = today.getDate();
    var mm    = today.getMonth()+1; //January is 0!
    var yyyy  = today.getFullYear();
    
    if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
    $('#datepicker').val(today);
    $('#datepicker').datepicker({ format: 'mm/dd/yyyy', weekStart: '0', autoclose:true }).on('changeDate', function()
    {
        $('.datepicker1formError').hide();
    });
    $('#datepicker1').val(today);

    $('#datepicker1').datepicker({ format: 'mm/dd/yyyy', weekStart: '0', autoclose:true }).on('changeDate', function()
    {
        $('.datepicker1formError').hide();
    });
    jQuery("#post_inc_validation").validationEngine();
});
function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {  str = '0' + str; }
        document.getElementById('CUSTOMER').value=str;
    }
}
</script>