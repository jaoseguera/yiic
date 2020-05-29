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
if ($_SESSION['SYSNR'] . '/' . $_SESSION['SYSID'] . '/' . $_SESSION['CLIENT'] == '10/EC4/210') {
    $I_IDOCTP = "MATMAS05";
    $I_SEGNAM = "E1MARAM";
    $I_VALUE = "NIPRO002";
}
$customize = $model;
$this->renderPartial('smarttable');
?>
<div>
    <div>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
            <div class="row-fluid">
                <div class="utopia-widget-content wid_mess">
                    
                    <form id="validation" action="" class="form-horizontal" >
                               
                                 <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="search_material"/>
                                    <input type="hidden" name="bapiName" value="/EMG/READ_IDOC_VALUE"/>
                                    <input type="hidden" class="tbName_example" value="EDIDC"/>
                                    
                                    <div class="utopia-form-freeSpace">


                            <div class="control-group span4" >
                                <label class="control-label cutz" alt="Material" for="input01"><?php echo Controller::customize_label('Material'); ?><span> *</span>:</label>
                                <div class="controls" style='min-width:150px;'>
                                    <input alt="Material" class="input-fluid validate[required]" type="text" name='I_VALUE' value="<?php echo $I_VALUE; ?>" maxlength='10' onKeyUp="jspt('I_VALUE',this.value,event)" autocomplete="off" id="I_VALUE"> 
                                </div>
                            </div>			
                            <div>                           	  
                   <button class="btn btn-primary span1 bbt back_b" onClick='return getBapitable("table_today_search_material","EDIDC","example","L","nones@<?php echo $s_wid; ?>","Search_material","submit")' type="submit" id='submit'  style='min-width:80px;'>Submit</button>
                            </div>
                        </div>
                                    
                                    
                                    
                             
                       
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
                ?><div id='table_today_search_material'></div>
                <div class='testr table_today_search_material' onClick='getBapitable("table_today_search_material","EDIDC","example","S","nones@<?php echo $s_wid; ?>","Search_material","show_more")'>Show more</div>
                <div id='example_num' style="display:none;">10</div>
            </div>
        </div>
        <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>
        <div id='example_table' style="display:none"><?php 
        // echo json_encode($SalesOrder);
        $technical = $model;
        $t_headers = Controller::technical_names('EDIDC');
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
		function submitForm1_click(ids) 
            {	
              
                $('#loading').show();
                $("body").css("opacity","0.4"); 
                $("body").css("filter","alpha(opacity=40)");
			
                $.ajax({
                    type:'POST', 
                    url: 'search_material/idocnumber?bapiName=/EMG/IDOC_REPROCESS&I_DOCNUM='+ids, 
                    success: function(response) 
                    {
                        $('#loading').hide();
                        $("body").css("opacity","1"); 
                        jAlert('<b>SAP System Message:</b>'+response, 'Resend', function(r)
                        {
                            if(r)
                            {
							
                            }
                        });
                    }
                });
                return false;
            }
        </script>
        <?php
        /* } else {
        echo "NO DATA FOUND";
        } */
        //}
        ?>
    </div><!-- Maincontent end -->
</div> <!-- end of container -->