<?php
$PURCHASEORDER = "";
$release_code  = "";
$out_put       = 'out';

?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;

?><section id="formElement" class="utopia-widget utopia-form-box section">
<div class="row-fluid">
<div class="utopia-widget-content">
<form id="validation" action="javascript:submit_form('validation')" class="form-horizontal">
<div class="span4 utopia-form-freeSpace" style="min-width:420px;">
<fieldset>
<div class="control-group">
<input type="hidden" name='page' value="bapi">
<input type="hidden" name="url" value="approve_purchase_order"/>
<input type="hidden" name="key" value="approve_purchase_order"/>
<label class="control-labels cutz" alt="Purchase Order Number" style="width: 160px" for="date"><?php echo Controller::customize_label('Purchase Order Number');?><span> *</span>:&nbsp;</label>
<div class="controls ">
<input alt="1" class="input-fluid validate[required] radius" type="text" name='PURCHASEORDER' id="PURCHASEORDER" value="<?php echo $PURCHASEORDER;?>" onKeyUp="jspt('PURCHASEORDER',this.value,event)" autocomplete="off"><span  class='minw'  onclick="tipup('BUS2012','GETDETAIL1','POHEADER','PO_NUMBER','Purchase order number','PURCHASEORDER','4@MEKKM')" >&nbsp;</span>
</div>
</div>
</fieldset>
</div>
<div class="span4 utopia-form-freeSpace" >
<fieldset>
<div class="control-group">
<label class="control-label cutz" for="date" alt="Release code" style="white-space:nowrap;"><?php echo Controller::customize_label('Release code');?><span> *</span>:&nbsp; </label>
<div class="controls ">
<input alt="Release code" type="text" class="input-fluid  validate[required,custom[rel_code]]" id='PO_REL_CODE' name="PO_REL_CODE" value="<?php echo $release_code;?>"   onKeyUp="jspt('PO_REL_CODE',this.value,event)" autocomplete="off" onChange='number_es(this.value)'>
</div>
</div>
</fieldset>
</div>
<div class="controls">
<br>
<button class="btn btn-primary span1 bbt" type="submit" id="subt" style="min-width:80px;">Submit</button>
</div>
</form>
</div>
</div>
</section>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() { jQuery("#validation").validationEngine(); });

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
        document.getElementById('PURCHASEORDER').value=str;
    }
}
function number_es(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 2) {
        str = '0' + str;
        }
        document.getElementById('PO_REL_CODE').value=str;
    }
}
</script>