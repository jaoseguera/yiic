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
if(isset($_SESSION['product_aval_err']))
{
    $em_ex = explode("@", $_SESSION['product_aval_err']);
    //$ms_type = $em_ex[1];
    if($em_ex[1]=="E"){
        ?>
        <script>
            var msg = "<?php echo $em_ex[0]; ?>";
            jAlert('<b>SAP System Message: </b><br>'+ msg, 'Product Availability');
        </script>
        <?php
    }    $_SESSION['product_aval_err'] = "";

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
                            <input type="hidden" name="url" value="product_availability"/>
                            <input type="hidden" name="key" value="product_availability"/>
                            
                            <label class="control-label cutz" alt="Material" for="date"><?php echo Controller::customize_label('Material');?><span> *</span>:&nbsp;</label>
                            <div class="controls" style="min-width:150px;">
                                <input alt="Material" type="text"  id='MATERIAL' name='MATERIAL' class="input-fluid validate[required] getval radiu" title="Material" value="<?php echo $MATERIAL;?>" tabindex="1" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off"/>
                                <!--<span  class='minw3'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
                            </div>
                        </div>
                        <div class="control-group span4">
                            <label class="control-label cutz" alt="Plant" for="input01"><?php echo Controller::customize_label('Plant');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Plant" class="input-fluid validate[required,custom[pla]]" type="text" name='PLANT'  value="<?php echo $PLANT?>" tabindex="2" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT" >
                                <span class='minw' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</span>
                                <!--<span  class='minw3'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
                            </div>
                        </div> 
                        <button class="btn btn-primary span1 bbt" type="submit" id="subt" style="min-width:80px">Submit</button>
                    </fieldset>
                </div>
            </form>
        </div><?php
        if($em_ex[1]=="S"){
        if(isset($_REQUEST['MATERIAL']))
        {
            $technical = $model;
            $t_headers = Controller::technical_names('BAPI_MRP_STOCK_DETAIL');	
            foreach($SalesOrder as $prod=>$keys)
            { 
                if($prod=='UNRESTRICTED_STCK' || $prod=='ORDERS' || $prod=='DELIVERY' || $prod=='PUR_ORDERS' || $prod=='QUOTATIONS') 
                {
                    ?><div class="span5" style="padding:10px;">
                    <span class="span6" style="font-weight:bold;"><?php echo $t_headers[$prod];?>:</span>
                    <span class="span6" style="text-align:left;border:1px solid #cecece;border-radius:5px;margin-left:5px;"><span style="padding-left:3px;"><?php echo $keys;?></span></span>
                    </div><?php
                }
            }
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