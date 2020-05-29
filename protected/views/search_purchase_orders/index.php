<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

	display:table-cell;
	
	}	
	
</style>
<?php
$PURCHASE_ORDER = "";
$pur_grp = "";
$vender = "";
$MATERIAL = "";
$open_pur_ord = "";
?><script>
            if($.cookie("css")) {
                $('link[href*="utopia-white.css"]').attr("href",$.cookie("css"));
                $('link[href*="utopia-dark.css"]').attr("href",$.cookie("css"));
            }
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
        $this->renderPartial('smarttable',array('count'=>$count));
        $customize = $model;        
        ?>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
            <div class="row-fluid">
                <div class="utopia-widget-content wid_mess">
                    <h4 class="filter_note">Note : Use at least one filter for fast search results</h4>

                    <form id="validation" action="" class="form-horizontal" >
                        <fieldset class="span12" >
							<div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Purchase Order Number"><?php echo Controller::customize_label('Purchase Order Number'); ?>:</label>
                                    <input alt="Purchase Order Number" class="input-fluid" type="text" name='PURCHASE_ORDER'  value="<?php echo $PURCHASE_ORDER; ?>" onKeyUp="jspt('PURCHASE_ORDER',this.value,event)" autocomplete="off" id="PURCHASE_ORDER" ><span class='minw' onclick="lookup('Purchase Order Number', 'PURCHASE_ORDER', 'po_number')" >&nbsp;</span>
                                </fieldset></div>
								
                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Purchase Group"><?php echo Controller::customize_label('Purchase Group'); ?>:</label>
                                    <input alt="Purchase Group" class="input-fluid" type="text" name='pur_grp'  value="<?php echo $pur_grp; ?>" onKeyUp="jspt('Purchase Group',this.value,event)" autocomplete="off" id="Purchase_Group" ><span class='minw' onclick="lookup('Purchasing Group', 'Purchase_Group', 'purch_group')" >&nbsp;</span>
                                </fieldset></div>

                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Vendor Number"><?php echo Controller::customize_label('Vendor Number'); ?>:</label>

                                    <input type="hidden" name='page' value="bapi">
                                    <input type="hidden" name="url" value="search_purchase_orders"/>
                                    <input type="hidden" class="tbName_example" value="BAPIEKKOL"/> 

                                    <input type="hidden" name="serch" value="yes"/>                       

                                    <input alt="Vendor Number" class="input-fluid validate[required,custom[ven]]" type="text" name='vendor'  value="<?php echo $vender; ?>"  onKeyUp="jspt('VENDOR',this.value,event)" autocomplete="off" id="VENDOR">
                                    <!--<span  class='minw3'  onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>

                                </fieldset></div>

                            <div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label class="control-label1 cutz" for="input01" alt="Material"><?php echo Controller::customize_label('Material'); ?>:</label>

                                    <input alt="Material" class="input-fluid validate[required] radius getval" type="text" name='MATERIAL' value="<?php echo $MATERIAL; ?>" id="MATERIAL" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off">
                                    <!--<span  class='minw3'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                    <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>


                                </fieldset>
                            </div>
                        </fieldset>
                        <fieldset class="span12" style="padding:0px;margin:0px;">
							<div class="span3 utopia-form-freeSpace">
                                <fieldset>
                                    <label style="margin-top:25px;" class="control-label1" for="input01" ><span class="cutz" alt="Open Purchase Orders" style="color:#333;"><?php echo Controller::customize_label('Open Purchase Orders'); ?></span>: <input type="checkbox" name="open_pur_ord" value="X"/></label>
                                </fieldset> </div>
							<br>
                            <div class="utopia-form-freeSpace mfre" style="float:right;min-width:135px;">
                                <input type="hidden" name='searched' value='yes'>
                                <button class="btn btn-primary spanbt back_b" type="submit" onClick='return getBapitable("table_today","BAPIEKKOL","example","L","nones@<?php echo $s_wid; ?>","search_purchase_orders","submit")' style="max-width:90px;">Submit</button></td>
                            </div>

                        </fieldset>
                    </form>
                    <div style="padding-bottom:1px;">&nbsp;</div>
                </div>
            </div>
        </section>

		<div class="row-fluid">
			<?php
			// if (isset($_REQUEST['serch'])) {
			//  if ($rowsag1 > 1) {
			?>
			<!-- Body start -->
			<div >
				<div class="edge" style="overflow-y:hidden;margin-top:0px;">
					<?php $this->renderPartial('tabletop'); ?>
					<div id='table_today'>
					</div>
					<?php
					// if ($rowsag1 > 10) {
					?>
					<div class='testr table_today' onClick='getBapitable("table_today","BAPIEKKOL","example","S","nones@<?php echo $s_wid; ?>","search_purchase_orders","show_more")'>Show more</div>
					<div id='example_num' style="display:none;">10</div>
					<?php
					// }
					?>
				</div>
			</div>
			<div id='example_table' style="display:none">
				<?php
				$technical = $model;
				$t_headers = Controller::technical_names('BAPIEKKOL');
				foreach ($SalesOrder as $number_keys => $array_values) {
					foreach ($array_values as $header_values => $row_values) {
						$header_values1 = $t_headers[$header_values];
						unset($array_values[$header_values]);
						$array_values[$header_values1] = $row_values;
					}
					$SalesOrder[$number_keys] = $array_values;
				}
				echo json_encode($SalesOrder);
				// echo json_encode($SalesOrder);
				?>
			</div>
			<div id='export_table' style="display:none"></div>
			<div id='export_table_view_pdf' style="display:none"></div>
			<script>
				$(document).ready(function(e) {
					$(".head_icons").hide();
					$(".testr").text('');						
					$('.search_int').keyup(function () 
					{		
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
					$('.head_icons').css({ width:wids+'px'});
				});
			</script><!-- Body end -->
			<?php
			//} else {
			// echo "Match not Found";
			// }
			// }
			?>
		</div><!-- Maincontent end -->
