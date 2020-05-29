<script>
$(document).ready(function() {
    $(".theme-changer a").on('click', function() {
        $('link[href*="utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
});
function resetform()
{
    document.getElementById("sname").value=null;
    document.getElementById("sstreet").value=null;
    document.getElementById("scity").value=null;
    document.getElementById("scountry").value=null;
    document.getElementById("sstate").value=null;
}
</script><?php
if (isset($_REQUEST['titl'])) 
{
    ?><script>
    $(document).ready(function()
    {
    parent.titl("<?php echo $_REQUEST['titl']; ?>");
    parent.subtu('<?php echo $_REQUEST["tabs"]; ?>');
    })
    </script><?php
} 
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php
$customize = $model;
$this->renderPartial('smarttable',array('count'=>$count));
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content wid_mess">
            <h4 class="filter_note" >Note : Use at least one filter for fast search results</h4>
            <form id="validation" action="" class="form-horizontal">
                <fieldset class="span12" >
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Customer Number"><?php echo Controller::customize_label('Customer Number'); ?>:</label>
                            <input alt="1" class="input-fluid radius" type="text" name='customer' id="customer" value="<?php echo $customer ?>" onKeyUp="jspt('customer',this.value,event)"><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','customer','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'customer', 'sold_to_customer')" >&nbsp;</span><input type="hidden" value="table" name="types" id="types"> 
                        </fieldset></div>
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <input type="hidden" name='page' value="bapi">
                            <input type="hidden" name="url" value="delivery_list"/>
                            <input type="hidden" name="key" value="delivery_list"/>
                            <input type="hidden" class="tbName_example" value="BAPIDLVHDR"/>

                            <label class="control-label1 cutz" for="date" alt="Material"><?php echo Controller::customize_label('Material'); ?>:</label>
                            <input type="text"  id='MATERIAL' name='material' class="input-fluid getval radiu" title="MATERIAL" alt="MULTI" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" value='<?php echo $material; ?>'/>
                            <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                            <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
                        </fieldset></div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Delivery Date"><?php echo Controller::customize_label('Delivery From Date'); ?>:</label>
                            <input alt="Requested Delivery Date" type="text" name='Delivery' id='datepicker' class="input-fluid getval radius" value="<?php echo $delivery; ?>"/>
                        </fieldset></div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Delivery To Date"><?php echo Controller::customize_label('Delivery To Date'); ?>:</label>
                            <input alt="Requested Delivery To Date" type="text" name='To_Delivery' id='datepicker1' class="input-fluid getval radius" value="<?php echo $to_delivery; ?>"/>
                        </fieldset></div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1" for="input01" ><span class="cutz" alt="Open Delivery" style="color:#333;"><?php echo Controller::customize_label('Open Delivery'); ?></span> : <input type="checkbox" name="status_goods" value="C" <?php echo $checked; ?>/></label>
                        </fieldset> </div>
                    <div class="span3 utopia-form-freeSpace" style="margin-bottom:10px;">
                        <button class="btn btn-primary span3 bbt back_b" onClick='return getBapitable("table_today","BAPIDLVHDR","example","L","show_dilv@<?php echo $s_wid; ?>","Delivery_list","submit")' type="submit" style="min-width:90px;">Submit</button>
                    </div>                   
                </fieldset>  
            </form> 
        </div>
    </div>
</section>
<?php// if (isset($_REQUEST['customer']) != "") { ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <!-- Body start -->
            <div>
                <div>
                    <div>
                        <div  style="overflow-y:hidden;padding-bottom:55px;" class="edge">
                            <div id="table_top"><?php
                        // if ($result != NULL) {
                                $this->renderPartial('tabletop');
                        // }
                            ?></div>
                            <div id='table_today'></div>
                            <?php //if ($rowsag1 > 10) { ?>
                            <div class='testr table_today' onClick='getBapitable("table_today","BAPIDLVHDR","example","S","show_dilv@<?php echo $s_wid; ?>","Delivery_list","show_more")'>Show more</div>
                            <div id='example_num' style="display:none;">10</div>                           
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div><!-- Body end -->
        </div><!-- Maincontent end -->
    </div> <!-- end of container -->
    <div id='export_table' style="display:none"></div>
    <div id='export_table_view_pdf' style="display:none"></div>
    <script>
    $(document).ready(function(e) {                   
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
        var wids=$('.table').width();
        $('.head_icons').css({
            width:wids+'px'
        });
    });
    </script>
<?php
//}
?>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".head_icons").hide();
    $(".testr").text('');
    var dd=0;
    $('.head_fix').css({display:'none'});
    $(document).scroll(function()
    {
        $('#examplefix').css({display:'block'});
    });

    $('#datepicker, #datepicker1').datepicker({
        format: 'mm/dd/yyyy',
        weekStart: '0',
        autoclose:true
    }).on('changeDate', function()
    {
        $('.datepickerformError').hide();
    });
});
</script>