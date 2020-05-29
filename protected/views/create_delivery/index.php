<script>
function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
        document.getElementById('ref_doc').value=str;
    }
}
</script><?php

if(isset($_REQUEST['titl']))
{
    ?><script>
    $(document).ready(function()
    {
        parent.titl("<?php echo $_REQUEST['titl'];?>");
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    })
    </script><?php 
} 
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php
$ref_doc = "";
$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $ref_doc="10000352";
    $cusLenth = count($ref_doc);
    //if($cusLenth < 10 && $ref_doc!='') { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }
}
if(isset($_REQUEST['REF_DOC']))
{
$ref_doc=$_REQUEST['REF_DOC'];
}

$customize = $model;
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content inval">
            <form id="validation" action="javascript:submit_form('validation')" class="form-horizontal">
            <input type="hidden" name="page" value="bapi">
            <input type="hidden" name="url" value="create_delivery">
            <input type="hidden" name="key" value="create_delivery">
                <div class="span12 utopia-form-freeSpace">
                    <fieldset>
                        <div class="control-group span5" >
                        <label class="control-label cutz" alt="Sales Order Number" for="input01"><?php echo Controller::customize_label('Sales Order Number');?><span>*</span>:</label>
                            <div class="controls myspace1">
                                <input alt="Sales Order Number" type="text" class="input-fluid validate[required,custom[number]] " name='REF_DOC' id="REF_DOC" value="<?php echo $ref_doc;?>" onKeyUp="jspt('REF_DOC',this.value,event)" autocomplete="off" /><br/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="controls">
                                <button class="btn btn-primary spanbt span2 bbt" type="submit">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </div>                         
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    jQuery("#validation").validationEngine();
});
</script>