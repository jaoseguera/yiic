<script>
function resetform()
{
    document.getElementById("sname").value=null;
    document.getElementById("sstreet").value=null;
    document.getElementById("scity").value=null;
    document.getElementById("scountry").value=null;
    document.getElementById("sstate").value=null;
}
</script>
<?php
$customize = $model;
$this->renderPartial('smarttable',array('count'=>$count));
?>
<div>
    <div>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
            <div class="row-fluid">
                <div class="utopia-widget-content wid_mess">
                    <h4 class="filter_note" >Note : Use at least one filter for fast search results</h4>
                    <form id="validation" action="" class="form-horizontal" >
                        <fieldset class="span12">
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Vendor Number"><?php echo Controller::customize_label('Vendor Number'); ?>:</label>
                                    <input alt="Vendor Number" class="input-fluid validate[required,custom[ven]]" type="text" name='vendor' value="<?php echo $vender; ?>" onKeyUp="jspt('VENDOR',this.value,event)" autocomplete="off" id="VENDOR" onchange="number(this.value)">
                                    <!--<span class='minw3' onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="search_vendors"/>
                                    <input type="hidden" name="key" value="search_vendors"/>
                                    <input type="hidden" class="tbName_example" value="LFA1"/>
                                    <label class="control-label1 cutz" for="date" alt="Name"><?php echo Controller::customize_label('Name'); ?>:</label>
                                    <input alt="3" type="text" class="input-fluid validate[required]" id="sname" name="sname" value="<?php echo $sname ?>">
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="City"><?php echo Controller::customize_label('City'); ?>:</label>
                                    <input alt='6' class="input-fluid validate[required]" type="text" name='scity'  id="scity" value="<?php echo $scity ?>">
                                </fieldset>
                            </div>
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Postal Code"><?php echo Controller::customize_label('Postal Code'); ?>:</label>
                                    <input alt='7' class="input-fluid" type="text" name='postal_code' value="<?php echo $postal_code ?>" id="scountry">
                                </fieldset>
                            </div>
                        </fieldset>                
                        <fieldset class="span12" style="padding:0px;margin:0px;">
                            <div class="span3 utopia-form-freeSpace" >
                                <fieldset >
                                <label class="control-label1 cutz" for="input01" alt="Search Term"><?php echo Controller::customize_label('Search Term'); ?>:</label>
                                <input  alt="2" class="input-fluid validate[required] radius" type="text" name='search_term' id="search_term" value="<?php echo $search_term ?>">
                                </fieldset>
                            </div>
                            <br>
                            <div class="utopia-form-freeSpace mfre" style="float:right;min-width:135px;">
                                <input type="hidden" name='searched' value='yes'>
                                <button class="btn btn-primary spanbt back_b" type="submit" onClick='return getBapitable("table_today_search_vendors","LFA1","example","L","nones@<?php echo $s_wid; ?>","Search_vendors","submit")' style="max-width:90px;">Submit</button></td>
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
                ?><div id='table_today_search_vendors'></div>
                <div class='testr table_today_search_vendors' onClick='getBapitable("table_today_search_vendors","LFA1","example","S","nones@<?php echo $s_wid; ?>","Search_vendors","show_more")'>Show more</div>
                <div id='example_num' style="display:none;">10</div>
            </div>
        </div>
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