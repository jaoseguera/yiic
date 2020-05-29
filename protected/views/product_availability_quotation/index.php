<style>
.daw li { list-style:none; float:left; width:150px; padding:3px; text-align:right; }
</style><?php

$VENDOR   = "";
$MATERIAL = "";
$PLANT    = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $MATERIAL="N100015";
    $PLANT="1000";
}

if(isset($_REQUEST['values']))
{
    $MATERIAL=$_REQUEST['values'];
    $PLANT=$_REQUEST['pln'];
    ?><script>
    $(document).ready(function(e) {
    parent.titl('<?php echo $_REQUEST["titl"];?>');
    parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    $('#subt').trigger('click');
    });
    </script><?php
}
if(isset($_REQUEST['MATERIAL']))
{

    $MATERIAL = strtoupper($_REQUEST['MATERIAL']);
    $PLANT    = strtoupper($_REQUEST['PLANT']);
}
if(isset($_SESSION['product_aval_err']) && $_SESSION['product_aval_err']!="")
{
    //$ms_type = $em_ex[1];
    
        ?>
        <script>
            var msg = "<?php echo $_SESSION['product_aval_err']; ?>";
            jAlert('<b>SAP System Message: </b><br>'+ msg, 'Product Availability');
        </script>
        <?php

}

?>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;
?><section id="formElement" class="utopia-widget utopia-form-box section" style="padding-bottom:20px;">
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submit_form('validation')" class="form-horizontal" >
                <div class="span12 utopia-form-freeSpace">
                    <fieldset>
                        <div class="control-group span4">
                            <input type="hidden" name='page' value="bapi">
                            <input type="hidden" name="url" value="product_availability_quotation"/>
                            <input type="hidden" name="key" value="product_availability_quotation"/>
                            
                            <label class="control-label cutz" alt="Material" for="date"><?php echo Controller::customize_label(_MATERIAL);?><span> *</span>:&nbsp;</label>
                            <div class="controls" style="min-width:150px;">
                                <input alt="Material" type="text"  id='MATERIAL' name='MATERIAL' class="input-fluid validate[required] getval radiu" title="Material" value="<?php echo $MATERIAL;?>" tabindex="1" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off"/>
                              
                                <span class='minw' onclick="lookup('<?=_MATERIAL?>', 'MATERIAL', 'material')" >&nbsp;</span>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <label class="control-label cutz" alt="Plant" for="input01"><?php echo Controller::customize_label(_PLANT);?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Plant" class="input-fluid validate[required,custom[pla]]" type="text" name='PLANT'  value="<?php echo $PLANT?>" tabindex="2" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT" >
                                <span class='minw' onclick="lookup('<?__PLANT?>', 'PLANT', 'plant')" >&nbsp;</span>
                                
                            </div>
                        </div> 
                        <button class="btn btn-primary span1 bbt" type="submit" id="subt" style="min-width:80px"><?=_SUBMIT?></button>
                    </fieldset>
                </div>
            </form>
        </div><?php
        if(isset($_REQUEST['MATERIAL']) && (!isset($_SESSION['product_aval_err']) || $_SESSION['product_aval_err']==""))
        {
            $technical = $model;
            $t_headers = Controller::technical_names('BAPI_PROD_AVAIL');    
            foreach($SalesOrder as $prod=>$keys)
            { 
                    ?><div class="span5" style="padding:10px;">
                    <span class="span6" style="font-weight:bold;"><?php echo $t_headers[$prod];?>:</span>
                    <span class="span6" style="text-align:left;border:1px solid #cecece;border-radius:5px;margin-left:5px;"><span style="padding-left:3px;"><?php echo $keys;?></span></span>
                    </div><?php
              
            }
        }
        
    ?></div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() { 

jQuery("#validation").validationEngine();
 });
</script>