<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

	display:table-cell;
	
	}	
	
</style><?php
$customize = $model;
$this->renderPartial('smarttable',array('count'=>$count));
?>
<div>
    <div>
        <section id="formElement" class="utopia-widget utopia-form-box section" style="padding-bottom:20px;">
            <div class="row-fluid">
                <div class="utopia-widget-content wid_mess">
                    <h4 class="filter_note" >Note : Use at least one filter for fast search results</h4>
                    <form id="validation" action="" onsubmit="javascript:return getBapitable('table_today_material_availability','/EMG/STRU_MB53_LINE','example','L','nones@<?php echo $s_wid; ?>','material_availability','submit')" class="form-horizontal" >
                        <fieldset class="span12">
                            <div class="span3 utopia-form-freeSpace">
                                <input type="hidden" name='page' value="bapi">
                                <input type="hidden" name="url" value="material_availability"/>
                                <input type="hidden" name="key" value="material_availability"/>
                                <input type="hidden" class="tbName_example" value="/EMG/MM_PLANT_STOCK_AVAIL"/>
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Material"><?php echo Controller::customize_label('Material'); ?><span> *</span>:</label>
                                    <input alt="Material" class="input-fluid validate[required] getval radiu" type="text" name='I_MATNR' value=""
                                           onKeyUp="jspt('I_MATNR',this.value,event)" autocomplete="off" id="I_MATNR">
                                    <span class='minw' onclick="lookup('Material', 'I_MATNR', 'material')" >&nbsp;</span>


                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Plant From"><?php echo Controller::customize_label('Plant From'); ?>:</label>
                                    <input alt="3" type="text" class="input-fluid validate[custom[pla]]" id="PLANT_FROM" name="PLANT_FROM" value="">
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Plant To"><?php echo Controller::customize_label('Plant To'); ?>:</label>
                                    <input alt='6' class="input-fluid validate[custom[pla]]" type="text" name='PLANT_TO'  id="PLANT_TO" value="">
                                </fieldset>
                            </div>

                        </fieldset>                
                        <fieldset class="span12" style="padding:0px;margin:0px;">
                            <br>
                            <div class="utopia-form-freeSpace mfre" style="float:right;min-width:135px;">
                                <input class="btn btn-primary back_b iphone_bill_list " onclick="" type="submit" name="submit" value="<?php echo _SUBMIT ?>">
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
                ?><div id='table_today_material_availability'></div>
                <div class='testr table_today_material_availability' onClick='getBapitable("table_today_material_availability","/EMG/STRU_MB53_LINE","example","S","nones@<?php echo $s_wid; ?>","material_availability","show_more")'>Show more</div>
                <div id='example_num' style="display:none;">10</div>
            </div>
        </div>
        <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>
        <div id='example_table' style="display:none"><?php 
        // echo json_encode($SalesOrder);
        $technical = $model;
        $t_headers = Controller::technical_names('/EMG/STRU_MB53_LINE');
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
        <script>
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

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery("#validation").validationEngine();
    });
</script>