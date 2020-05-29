<?php
$VENDOR = "";
$MATERIAL = "";
$PLANT = "";
$PUR_ORG = "";

$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
	$VENDOR = "300000";
    $MATERIAL = "N100003";
    $PLANT = "1000";
    $PUR_ORG = "1000";
}
$customize = $model;
$this->renderPartial('smarttable',array('count'=>$count));
?>
<style>
	.form-horizontal .control-label{ min-width: 140px !important; width: auto; }
</style>
<div>
    <div>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
            <div class="row-fluid">
                <div class="utopia-widget-content wid_mess">
					<form id="validation" action="javascript: check_val();" method="post" class="form-horizontal" >
                        <fieldset class="span12">
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Vendor Number"><?php echo Controller::customize_label('Vendor Number'); ?>:</label>
                                    <input alt="Vendor Number" class="input-fluid" type="text" name='vendor'  value="<?php echo $VENDOR; ?>" onKeyUp="jspt('VENDOR',this.value,event)" autocomplete="off" id="VENDOR">
                                    <!--<span class='minw3' onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="supply_list"/>
                                    <input type="hidden" name="key" value="supply_list"/>
                                    <input type="hidden" class="tbName_example" value="LFA1"/>
                                    <label style="text-align: left;" class="control-label1 cutz" alt="Material" for="inputError"><?php echo Controller::customize_label('Material');?>:</label>
									<input alt="Material" class="input-fluid radius getval" type="text" name='MATERIAL' value="<?php echo $MATERIAL; ?>" id="MATERIAL" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off">
                                    <!--<span  class='minw3' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label style="text-align: left;" class="control-label1 cutz" alt="Plant" for="inputError"><?php echo Controller::customize_label('Plant');?> <span>*</span>:</label>
									<input alt="Plant" class="input-fluid validate[required] radius" type="text" name='PLANT' value="<?php echo $PLANT; ?>" maxlength='4' onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT">
                                    <!--<span class='minw3' onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</span>
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label style="text-align: left;" class="control-label1 cutz" alt="PURCH_ORG" for="inputError"><?php echo Controller::customize_label('Purchasing Organization');?> <span>*</span>:</label>
									<input type="text" id='PURCH_ORG' class="input-fluid validate[required] getval radiu" name='PURCH_ORG' title="PURCH_ORG" onKeyUp="jspt('PURCH_ORG',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $PUR_ORG;?>"/>
                                    <span class='minw' onclick="lookup('Purchasing Organization', 'PURCH_ORG', 'purch_org')" >&nbsp;</span>
                                    <!--<span class='minw9' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PURCH_ORG','Purchasing Organization','PURCH_ORG','0')" >&nbsp;</span>-->
                                </fieldset>
                            </div>
                        </fieldset>                
                        <fieldset class="span12" style="padding:0px;margin:0px;">
                            <div class="utopia-form-freeSpace mfre" style="float:right;min-width:135px;">
								<button class="btn btn-primary span1 bbt back_b" type="submit" id='submit' style='min-width:80px;'>Submit</button>
                            </div>
                        </fieldset>
                    </form>
                <div style="padding-bottom:1px;">&nbsp;</div>
                </div>
            </div>
        </section>
        <!-- Body start -->
        <?php
        // if ($searched != "") {
        // if ($rowsag1 != 0) {
        ?>
        <div>
            <div class="utopia-widget-content edge" style="overflow-y:hidden;margin-top:30px;"><?php
                $this->renderPartial('tabletop');
                ?><div id='table_today_supply_list'></div>
                <div class='testr table_today_supply_list' onClick='getBapitable("table_today_supply_list","/EMG/STRU_VENDOR_SUPPLY","example","S","nones@<?php echo $s_wid; ?>","Supply_list","show_more")'>Show more</div>
                <div id='example_num' style="display:none;">10</div>
            </div>
        </div>
        <div class='material_pop' style="display:none"></div>
        <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>
        <div id='example_table' style="display:none"><?php 
        // echo json_encode($SalesOrder);
        $technical = $model;
        $t_headers = Controller::technical_names('LFA1');
        foreach ($SalesOrder as $number_keys => $array_values) {
                foreach ($array_values as $header_values => $row_values) {
                        $header_values1 = $t_headers[$header_values];
                        unset($array_values[$header_values]);
                        $array_values[$header_values1] = $row_values;
                }
                $SalesOrder[$number_keys] = $array_values;
        }
        echo json_encode($SalesOrder);
        ?></div>
		
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>

        <script>
	$(document).ready(function() { jQuery("#validation").validationEngine(); });
	function check_val()
	{
		jQuery("#validation").validationEngine();
		getBapitable("table_today_supply_list","/EMG/STRU_VENDOR_SUPPLY","example","L","nones@<?php echo $s_wid; ?>","Supply_list","submit");
	}
        $(document).ready(function() 
        {
            $(".head_icons").hide();
            $(".testr").text('');
            $('.search_int').keyup(function () {
                sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
            })
            data_table('example');
            $('#example').each(function(){
                $(this).dragtable({
                    placeholder: 'dragtable-col-placeholder test3',
                    items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                    appendTarget: $(this).parent(),
                    tableId: 'example',
                    tableSess: 'table_today',
                    scroll: true
                });
            })
            var wids = $('.table').width();
            $('.head_icons').css({ width:wids+'px'});
        });
        </script>
        <?php
        /* } else {
        echo "NO DATA FOUND";
        } */
        //}
        ?>
    </div><!-- Maincontent end -->
</div> <!-- end of container -->