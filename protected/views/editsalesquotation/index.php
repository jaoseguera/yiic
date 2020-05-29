
<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

	display:table-cell;
	
	}	
	
</style>
<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

$sales_org = "";
$sold_to = "";
$sel = "";
$distr_chan = "";
$doc_type = "";
$division = "";
$btn = "";
$count=5;
if (isset($_REQUEST['I_VBELN'])) {
   $customer = $_REQUEST['I_VBELN'];
   $cusLenth = count($customer);
   if($cusLenth < 10 && $customer != "") { $customer = str_pad($customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
   
   //GEZG 06/21/2018
   //Changing SAPRFC methods
   global $fce;
   $options = ["rtrim"=>true];
   $importTable = array();
   $SALES_DOCUMENTS = array("VBELN" => $customer);
   array_push($importTable,$SALES_DOCUMENTS);
   $I_BAPI_VIEW = array('HEADER' => 'X', 'ITEM' => 'X');
   try{
   $res = $fce->invoke(["I_BAPI_VIEW"=>$I_BAPI_VIEW,
                     "SALES_DOCUMENTS"=>$importTable],$options);   

   }catch(SapException $ex){
      echo $ex->getMessage();
      exit();
   }


   $ORDER_HEADERS_OUT = $res['ORDER_HEADERS_OUT'];
   $ORDER_ITEMS_OUT = $res['ORDER_ITEMS_OUT'];
   foreach ($ORDER_ITEMS_OUT as $keys) {
      $vas[] = array('ITM_NUMBER' => $keys['ITM_NUMBER'], 'MATERIAL' => $keys['MATERIAL'], 'SHORT_TEXT' => $keys['SHORT_TEXT'], 'REQ_QTY' => $keys['REQ_QTY'], 'NET_VALUE' => $keys['NET_VALUE'], 'NET_PRICE' => $keys['NET_PRICE'], 'SALES_UNIT' => $keys['SALES_UNIT'], 'TARGET_QU' => $keys['TARGET_QU'], 'DOC_NUMBER' => $keys['DOC_NUMBER'], 'MAT_ENTRD' => $keys['MAT_ENTRD'], 'PR_REF_MAT' => $keys['PR_REF_MAT'], 'BATCH' => $keys['BATCH'], 'MATL_GROUP' => $keys['MATL_GROUP'], 'SHORT_TEXT' => $keys['SHORT_TEXT'], 'ITEM_CATEG' => $keys['ITEM_CATEG'], 'ITEM_TYPE' => $keys['ITEM_TYPE'], 'REL_FOR_BI' => $keys['REL_FOR_BI'], 'HG_LV_ITEM' => $keys['HG_LV_ITEM'], 'PROD_HIER' => $keys['PROD_HIER'], 'OUT_AGR_TA' => $keys['OUT_AGR_TA'], 'TARGET_QTY' => $keys['TARGET_QTY'], 'T_UNIT_ISO' => $keys['T_UNIT_ISO'], 'PLANT' => $keys['PLANT'], 'TARG_QTY_N' => $keys['TARG_QTY_N'], 'BASE_UOM' => $keys['BASE_UOM'], 'SCALE_QUAN' => $keys['SCALE_QUAN'], 'ROUND_DLV' => $keys['ROUND_DLV'], 'ORDER_PROB' => $keys['ORDER_PROB'], 'CREAT_DATE' => $keys['CREAT_DATE'], 'CURRENCY' => $keys['CURRENCY']);
   }

   //var_dump($ORDER_ITEMS_OUT);
   if (isset($ORDER_HEADERS_OUT[0])) {
      $sales_org = $ORDER_HEADERS_OUT[0]['SALES_ORG'];
      $sold_to = ltrim($ORDER_HEADERS_OUT[0]['SOLD_TO'], "0");
      $sel = $ORDER_HEADERS_OUT[0]['REQ_DATE_H'];
      $distr_chan = $ORDER_HEADERS_OUT[0]['DISTR_CHAN'];
      $doc_type = $ORDER_HEADERS_OUT[0]['DOC_TYPE'];
      $division = $ORDER_HEADERS_OUT[0]['DIVISION'];
      $netvalue = $ORDER_HEADERS_OUT[0]['NET_VAL_HD'];
	  $df=$ORDER_HEADERS_OUT[0]['QT_VALID_F'];
	  $dt=$ORDER_HEADERS_OUT[0]['QT_VALID_T'];
		if($doc_type == 'TA')
			$doc_type = 'OR';

      $dd = substr($df, -2);
      $mm = substr($df, -4, 2);
      $year = substr($df, -8, 4);
      $date_from = $mm . "/" . $dd . "/" . $year;
	  
      $dd = substr($dt, -2);
      $mm = substr($dt, -4, 2);
      $year = substr($dt, -8, 4);
      $date_to = $mm . "/" . $dd . "/" . $year;
   }
   $btn = "btn-primary";
}

$I_VBELN = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if ($sysnr . '/' . $sysid . '/' . $clien == '10/EC4/210') {
   $I_VBELN_TXT = $I_VBELN = "10000351";
   $SalesLenth = count($I_VBELN);
   if ($SalesLenth < 10 && $I_VBELN != '') {
      $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT);
   } else {
      $I_VBELN = substr($I_VBELN, -10);
   }
}
if (isset($_REQUEST['I_VBELN'])) {
   $I_VBELN = $_REQUEST['I_VBELN'];
   $I_VBELN_TXT = $_REQUEST['I_VBELN'];
   $SalesLenth = count($I_VBELN);
   if ($SalesLenth < 10 && $I_VBELN != '') {
      $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT);
   } else {
      $I_VBELN = substr($I_VBELN, -10);
   }
}
$this->renderPartial('smarttable',array('count'=>$count));
$customize = $model;
?>
<style>
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.check { display:none !important; }

</style>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
   <div class="row-fluid">
      <div class="utopia-widget-content">
      
         <form id="validation3" action="javascript:submit_form('validation3')" class="form-horizontal">

            <div  class="form-horizontal">

               <div class="span5 utopia-form-freeSpace">

                  <fieldset>
                     <div class="control-group" >

                        <label class="control-label cutz" for="input01" style='min-width:170px;' alt='Sale Order Number' ><?php echo Controller::customize_label(_SALEQUOTATIONNUMBER); ?><span> *</span>:&nbsp;</label>
                        <input type="hidden" name='page' value="bapi">
                        <input type="hidden" name="url" value="editsalesquotation"/>
                        <input type="hidden" name="key" value="editsalesquotation"/>
                        <input type="hidden" name="jum" value="/KYK/SERPSLS_GENDOC_FLAGS_STS"/>
                        <input type="hidden" name="values" value="/KYK/SERPSLS_GENDOC_FLAGS_STS"/>

                        <div class="controls">
                           <input style='min-width:170px;' id='SALES_DOCUMENT' class="input-fluid validate[required] " type="text" name='I_VBELN' value="<?php echo $I_VBELN_TXT; ?>"/><span class='minw' onclick="lookup('Sales Document', 'SALES_DOCUMENT', 'sales_document')" >&nbsp;</span><!-- onChange="numdef(this.value,this.id)">-->
                        </div>

                     </div>
                  </fieldset></div>
               <?php
               if (!isset($_REQUEST['titl'])) {
                  ?>
                  <div>
                     <!--<input class="btn btn-primary back_b iphone_sales_disp <?php //echo $btn; ?>" name="btnsubmit" type="submit" value="<?php echo _SUBMIT ?>" style="margin-left:100px;margin-top:20px">-->
					 <button class="span2 btn btn-primary back_b iphone_sales_disp <?php echo $btn; ?>" type="submit" id='submit' style='margin-left:100px;margin-top:20px'><?=_SUBMIT?></button>
                  </div>
                  <?php
               }
               ?>
            </div>
         </form>
      </div>
   </div>
</section>

<?php if (isset($_REQUEST['I_VBELN']) && $ORDER_ITEMS_OUT != NULL) {
   ?>
   <form action="javascript:orders();" method="post" id='validation7' class="form-horizontal" enctype="multipart/form-data" autocomplete="on">
   <input type="hidden" name="bapiName" id="bapiName" value="BAPI_CUSTOMERQUOTATION_CHANGE"/>
   <input type="hidden" name="I_VBELN" id="I_VBELN" value="<?php echo $I_VBELN; ?>"/>
   
   <div id="form_edit_values" class="utopia-widget-content myspace inval35 spaceing row-fluid" style="margin-top:11px;">
         <div class="span5 utopia-form-freeSpace myspace" >
         <div style="position:absolute; float:right;right:50px;margin-top:-20px;"><a href="#" onclick="strpdf()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png"/>Sales Quotation </a></div>
            <fieldset>
            
            
               <div class="control-group">
                  <label class="control-label cutz in_custz" alt="Sales Organization" for="input01" id='SALES_ORG_s'><?php echo Controller::customize_label('Sales Organization'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Sales Organization" type="text" name='SALES_ORG' id='SALES_ORG' class="input-fluid validate[required,custom[salesorder]] getval radius" value='<?php echo $sales_org; ?>' onKeyUp="jspt('SALES_ORG',this.value,event)" autocomplete="off"/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('Sales Organization', 'SALES_ORG', 'sales_org')" >&nbsp;</span>
					 
                  </div>
               </div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01" id='PARTN_NUMB_s' alt="Customer Number"><?php echo Controller::customize_label('Customer Number'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input type="hidden" name="PARTN_NUMB_OLD" id="PARTN_NUMB_OLD" value="<?php echo $sold_to; ?>" />
					 <input alt="Customer Number" type="text" name='PARTN_NUMB' id='PARTN_NUMB' class="input-fluid validate[required,custom[customer]] getval radius" onchange="number(this.value)" value='<?php echo $sold_to; ?>' onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'PARTN_NUMB', 'sold_to_customer')" >&nbsp;</span>
                  </div></div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01" id='DISTR_CHAN_s' alt='Distribution. Channel'><?php echo Controller::customize_label('Distribution. Channel'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Distribution. Channel" type="text" name='DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required,custom[dis]] getval radius" value='<?php echo $distr_chan; ?>' onKeyUp="jspt('DISTR_CHAN',this.value,event)" autocomplete="off"/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('Distribution Channel', 'DISTR_CHAN', 'dist_chan')" >&nbsp;</span>
                  </div></div>
               <div class="control-group" id="NET_VAL_HD_hide">
                  <label class="control-label cutz" for="input01" id='NET_VAL_HD_s' alt='Net Value'><?php echo Controller::customize_label('Net Value'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Net Value" type="text" name='NET_VAL_HD' id='NET_VAL_HD' class="input-fluid validate[required,custom[dis]] getval radius" value='<?php echo number_format(trim($netvalue), 2) ?>' onKeyUp="jspt('NET_VAL_HD',this.value,event)" autocomplete="off"/></div></div>
            </fieldset>
         </div>
         <div class="span5 utopia-form-freeSpace">
            <fieldset>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"  style='width:150px;'  id="DOC_TYPE_s" alt='Sales Document Type'><?php echo Controller::customize_label('Sales Document Type'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Sales Document Type" type="text" name="DOC_TYPE" id='DOC_TYPE' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DOC_TYPE',this.value,event)" autocomplete="off" value='<?php echo $doc_type; ?>'/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DOC_TYPE','Sales Document Type','DOC_TYPE','0')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('Sales Document Type', 'DOC_TYPE', 'sales_order_types')" >&nbsp;</span>
                  </div></div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"  style='width:150px;'  id="DIVISION_s" alt='Division'><?php echo Controller::customize_label('Division'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Division" type="text" name='DIVISION' id='DIVISION' class="input-fluid validate[required,custom[divi]] getval radius" onKeyUp="jspt('DIVISION',this.value,event)" autocomplete="off" value='<?php echo $division; ?>'/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','DIVISION','2')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('Division', 'DIVISION', 'division')" >&nbsp;</span>
                  </div></div>
               <div class="control-group" >
                  <label class="control-label cutz" for="input01" style='width:150px;' alt='Quotation From Date'><?php echo Controller::customize_label('Quotation From Date'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Quotation From Date" type="text" id="datepicker" name='QFDate'  class="input-fluid getval radius" value="<?php echo $date_from; ?>"/>
                  </div></div>
				                 <div class="control-group" >
                  <label class="control-label cutz" for="input01" style='width:150px;' alt='Quotation To Date'><?php echo Controller::customize_label('Quotation To Date'); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Quotation To Date" type="text" id="datepicker1" name='QTDate'  class="input-fluid getval radius" value="<?php echo $date_to; ?>"/>
                  </div></div>
               <div class="control-group" >
                  <div class="controls">
                     <input type="button" name="copy_form_data" id="copy_form_data" value="Copy Sales Quotation" class="btn" />
                  </div></div>
            </fieldset>
         </div>
      
   </div>
	<span id="add_row_table" style="display:block;">
		<div class="row-fluid">
			<div class="span12" >
				<section class="utopia-widget spaceing max_width" style="margin-bottom:0px;">
					<div class="utopia-widget-title">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
						<span class='cutz sub_titles' alt='Items'><?php echo Controller::customize_label('Items');?></span>
					</div>
					<div class="utopia-widget-content items" >
						<div>
							<span class="btn" id="addRow" onclick="addRow('dataTable','A')" >Add item</span>
							<span class="btn"  id="deleteRow" onclick="deleteRow('dataTable')">
								<i class="icon-trash icon-white"></i>Delete item
							</span>
						</div>
						<br>
						<!--<table class="table  table-bordered iph" id="dataTable" >-->
						<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;overflow-y:scroll">
						<table class="table  table-bordered" id="dataTable" >
							<thead>
								<tr>
									<th class='cutz' alt='tableItems'><?php echo Controller::customize_label('tableItems');?></th>
									<th class='cutz' alt='Material'><?php echo Controller::customize_label('Material');?></th>
									<th class='cutz' alt='Description'><?php echo Controller::customize_label('Description');?></th>
									<th class='cutz' alt='Order Quantity'><?php echo Controller::customize_label('Order Quantity');?></th>
									<th class='cutz' alt='Price'><?php echo Controller::customize_label('Price');?></th>
									<th class='cutz' alt='SU'><?php echo Controller::customize_label('SU');?></th>
								</tr>
							</thead>
							<tbody>
								<tr onClick="select_row('ids_0')" class="ids_0 nudf" >
									<td><input class="chkbox check" type="checkbox" name="checkbox[]"
                                               title="che" id="chedk" value="U">
                                        <input  type="text" name='item[]' 
										<?php if(!isset($customerNo))
                                        { ?>value="10"<?php } else {?>value=""<?php }?>
                                                title="item" class='input-fluid validate[required,custom[number]] flgs' style="width:90%;" alt="Items" id="ITM_NUMBER" readonly="readonly"/></td>
									<td>
										<input type="text"  id='MATERIAL' name='material[]' class="input-fluid validate[required] getval radiu" title="MATERIAL" alt="MULTI" style="width:70%;" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" value='<?php echo $meterial;?>' onchange="jspt_new('MATERIAL',this.value,event)"/>
                                        <!--<span class='minw9' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                        <span class='minw' id="table_lookup" onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png" style="margin-left: 11px; cursor: pointer;" />
									</td>
									<td>
										<input type="text" id='SHORT_TEXT' style="width:90%;" class="input-fluid validate[required,custom[number]] getval" name='description[]' alt="SHORT_TEXT" onKeyUp="jspt('SHORT_TEXT',this.value,event)" autocomplete="off" value='<?php echo $order_q;?>'/>
									</td>
									<td>
										<input type="text" id='REQ_QTY' style="width:90%;" class="input-fluid validate[required] getval" name='Order_quantity[]' title="order_quantity" alt="REQ_QTY" onKeyUp="jspt('REQ_QTY',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/>
									</td>
									<td>
										<input type="text" id='NET_PRICE' style="width:90%;" class="input-fluid validate[required] getval" name='Price[]' title="descript" alt="PRICE" onKeyUp="jspt('PRICE',this.value,event)" autocomplete="off" value=''/>
										<input type="hidden" name="Currency[]" title="curr" id="CURRENCY"/>
									</td>
									<td>
										<input type="text" style="width:70%;" id='TARGET_QU' class="input-fluid validate[required] getval radiu" name='su[]' title="su" alt="MULTI" onKeyUp="jspt('TARGET_QU',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>
                                        <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','TARGET_QU','0')" >&nbsp;</span>-->
                                        <span  class='minw' id="table_lookup" onclick="lookup('SU', 'TARGET_QU', 'uom')" >&nbsp;</span>

                                    </td>
								</tr>
							</tbody>
						</table>
						</div>
						<input type="hidden" name="flag" id="flag"/>
						<input type="hidden" name="flag_d" id="flag_d"/>
						<table width="100%">
							<tr>
								<td>
									<span onclick="pre()" id="pre" class="btn" style="display:none">Previous</span>
									<span id="pre1" class="btn" style="display:none">Previous</span>
								</td>
								<td>
									<span onclick="nxt()" id="nxt" class="btn" style="float:right;display:none">Next</span>
									<span id="nxt1" class="btn" style="float:right;display:none">Next</span>
								</td>
							</tr>
						</table>
					</div>
                </section>
            </div>
        </div>
	</span>
	<div class="tab-content tab-con">
		<h3>Items</h3>
		<?php
		if ($ORDER_ITEMS_OUT != NULL)
		{
			?>
			<div class="labl pos_pop">
				<div class='pos_center'></div>
				<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
				<button class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
			</div>
			<div class="head_icons">
				<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example7')" ></span>
			</div>
			<?php
		}
		?>
		<div id='example7_today'>
		<?php
			if ($ORDER_ITEMS_OUT != NULL)
			{
				?>
				<div class="display_sales_header"></div>
				<input type="hidden" id="tableordersaveUrl" value="<?php echo Yii::app()->createAbsoluteUrl("common/tableorder") ?>" />
				<div style="border:1px solid #FAFAFA;overflow-y:scroll;overflow-x:scroll;">
				<table class="table table-striped table-bordered" id="example7" alt="editsalesorder">
				<?php
					$technical = $model;
					$tec_name = 'BAPISDIT';
					$t_headers = Controller::technical_names($tec_name);
					$r = "";
					//print_r($vas);
					for ($i = 0; $i < count($vas); $i++)
					{
						$SalesOrders = $vas[$i];
						if ($i == 0)
						{
							?>
							<thead>
								<tr>
								<?php
									foreach ($SalesOrders as $keys => $vales)
									{
										?>
										<th>
											<div class="truncated example7_<?php echo $keys; ?> cutz" title="<?php echo $t_headers[$keys]; ?>" alt='<?php echo $t_headers[$keys]; ?>'><?php echo Controller::customize_label($t_headers[$keys]); ?></div>
											<div class="example7_th example7_<?php echo $keys; ?>_hid" style="display:none;" name="<?php echo $keys; ?>"><?php echo $t_headers[$keys]; ?></div>
											<div class="example7_tech" style="display:none;"><?php echo $keys . "@" . $t_headers[$keys]; ?></div>
										</th>
										<?php
									}
								?>
								</tr>
								<tr style="display:none;" class="example7_filter">
								<?php
									$j = 1;
									foreach ($SalesOrders as $keys => $vales)
									{
										?>
										<th><input type="text"  class="search_int" value="" alt='<?php echo $j; ?>' name="table_today@example7"></th>
										<?php
										$j++;
									}
								?>
								</tr>
							</thead>
							<tbody id='example7_tbody'>
							<?php
						}
						?>
						<tr id="<?php echo $r; ?>">
						<?php
							$col = 0;
							foreach ($SalesOrders as $keys => $vales)
							{
								$jon = urlencode(json_encode($SalesOrders));
								
								$date = Controller::dateValue($t_headers, $keys, $vales);
								if($date != false)
									$vales = $date;
								else
								{
									$num = Controller::numberFormat($t_headers, $keys, $vales);
									if($num != false)
										$vales = $num;
								}
								$id = $vales;
								?>
								<td class="example7_cl<?php echo $col; ?>">
								<?php
									if($keys == "DOC_NUMBER")
									{
										?>
										<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
											<div onClick="show_menu('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','/KYK/SERPSLS_GENDOC_FLAGS_STS','sales_workbench')"><?php echo $vales; ?></div>
										</div>
										<?php
									}
									elseif($keys == 'MATERIAL')
									{
										$plant = $SalesOrders['PLANT'];
										$vals=preg_replace("/[^A-Za-z0-9]/", "", $vales);
										?>
										<div id="<?php echo $i.'_'.trim($vals); ?>" style="cursor:pointer;color:#00AFF0;">
											<div onClick="show_prod('<?php echo $i.'_'.$vals; ?>','<?php echo $plant; ?>','product_availability');" title=""><?php echo $vales; ?></div>
										</div>
										<?php
									}
									else
										echo $vales;
									
									if(is_numeric(trim($vales)) && $keys != 'MATERIAL')
									{
										echo '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys . '" name="' . $keys . '" value="' . round(trim($vales), 2) . '" alt="true">';
									}
									else
									{
										echo '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys . '" name="' . $keys . '" value="' . $vales . '" alt="true">';
									}
								?>
								</td>
								<?php
								$col++;
							}
						?>
						</tr>
						<?php
							//var_dump($SalesOrder);
							//  }
							if($r=="") { $r = 0; }
							$r = $r + 10;
					}
				?>
				</tbody>
				</table>
				</div>
				<?php
			}
			else
			{
				echo "No Items Found";
			}
		?>
		</div>
	</div>
   
   
   
   
   <br />
   <div class="controls" style="margin-left:0px;">
                     <input type="button" name="edit_salesorder" id="edit_salesorder" value="Edit" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="save_salesorder" id="save_salesorder" value="Save" onClick="save_quotation()" style="display:none;" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="cancel_salesorder" id="cancel_salesorder" value="Cancel" style="display:none;" class="btn iphone_sales_disp" />
                  </div>
				  </div>
				  </form>
               <?php
               if (isset($_REQUEST['I_VBELN'])) {
                  ?>
      <script>
         $(document).ready(function()
         {      	
            //data_table('example');  		
         })
      </script>
         <?php
         }
      }
      if (isset($_REQUEST['titl'])) {
         ?>
   <script>
      $(document).ready(function()
      {
         parent.titl('<?php echo $_REQUEST["titl"]; ?>');
         parent.subtu('<?php echo $_REQUEST["tabs"]; ?>');
      })
   </script>
<?php
	}
	elseif(isset($_REQUEST['I_VBELN']) && $ORDER_ITEMS_OUT == NULL)
	{
		?>
			<div class="tab-content tab-con">Sales quotation doesn't exist.</div>
		<?php
	}
	?>
<!-- javascript placed at the end of the document so the pages load faster -->
<div class="material_pop" ></div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
   $(document).ready(function() { 
   var flgs='';  
   $('.flgs').each(function(index, element) {
   flgs +=$(this).val()+'G1SU,';
});

	$('#flag').val(flgs);
      $('.getval').attr('readonly','readonly');	  
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();
      if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
      // $('#datepicker').val(today);
      $('#datepicker').datepicker({
         format: 'mm/dd/yyyy',
         weekStart: '0',
         autoclose:true
      }).on('changeDate', function()
      {
         $('.datepickerformError').hide();
      });
      jQuery("#validation3").validationEngine();
   });
   
   
	$(document).ready(function(e) 
	{
		$("#copy_form_data").click(function() 
		{
			var str = '';
			$("#form_edit_values").find(":input").each(function()
			{
				id = $(this).attr('id');					
				name = $(this).attr('name');
				val = $(this).attr('value');

				if(id != undefined && name != undefined && val != undefined && id != "bapiName" && id != "NET_VAL_HD" && id != "copy_form_data")
					str = str + name + '=' + val + '&';
			});
			$("#example7_today").find(":input").each(function()
			{
				id = $(this).attr('id');					
				name = $(this).attr('name');
				val = $(this).attr('value');

				if(id != undefined && name != undefined && val != undefined && id != "bapiName")
					str = str + name + '=' + val + '&';
			});
			$.cookie("formdata", str);
			window.location.href = '#create_sales_quotation';
		});
	});			
	
	
	
	
$(document).ready(function(e) 
{
    if($(document).width()<700)
    {
        $('#nxt1').css({color:'#cecece'});
        var gd=0;
        $('.iph').find('thead th').each(function(index, element) 
        {
            gd = gd+1;
            var text=$(this).text();
            $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
            //$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
        });
    }
    
    $("#dataTable").on('click', 'img', function() {
        var val   = $(this).closest("td").find("input").val();
        $sales_org = $("#SALES_ORG").val();
        if(val != "")
            show_prod_avail(val,$sales_org,'product_availability');
        else
            jAlert("You Have to Select Material First");
    })
});

var inc = 0;
var nut = 0;		
var delete_val='';
function addRow(tableID,t) 
{
    //inc=inc+1;
    if($(document).width()<100)
    {
        $('#pre').show();
        $('#nxt1').show();
        $('.sda').remove();
        $('.nudf').hide();
        $('#pre1').hide();
    }
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
	inc = (rowCount-1);
    if(t=='A')
	{
			var itm=table.rows[inc].cells[0].childNodes[2];
			in_vals=($('#'+itm.id).val()/10);
	}else
			in_vals=inc;
			
	nut=10*(in_vals)
	row.setAttribute('onclick', 'select_row("ids_'+in_vals+'")');
	row.setAttribute('class', 'ids_'+in_vals+' nudf');
    var colCount = table.rows[1].cells.length;


    for(var i=0; i<colCount; i++)
    {
        var newcell = row.insertCell(i);
        //newcell.childNodes[0].insertBefore('hello');
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        //alert(newcell.innerHTML);
        var ind=newcell.getElementsByTagName('input');
        //alert(ind[0].title);

		if(t != "U")
			ind[0].removeAttribute('readonly');
		
        if(ind[0].title=='che')
        {
          
        }
        //alert(newcell.childNodes[0].id);
        var ids=ind[0].id;
		//alert(ids);
        ind[0].id=ids+nut;

        ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");
		
        if(ind[0].title=='MATERIAL')
        {
	        ind[0].setAttribute("onchange","jspt_new('"+ids+nut+"',this.value,event)");
            var re=  newcell.getElementsByTagName('span');
            var met='MATERIAL'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
            //$(".minw").css("display","none");
            //$("#table_lookup").show();
            re[0].style.display=''
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");

        }

        if(ind[0].title=='su')
        {
            var re=  newcell.getElementsByTagName('span');
            var su='TARGET_QU'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+su+"','0');");*/
            //$(".minw").css("display","none");
            re[0].style.display=''
            re[0].setAttribute("onclick","lookup('SU', '"+su+"', 'uom');");
        }
        if(ind[(ind.length-1)].title=='item')
        {
            var numb=newcell.childNodes[0].value;
			var ids=ind[(ind.length-1)].id;
			ind[(ind.length-1)].id=ids+nut;
            ind[(ind.length-1)].value=(nut+10);
	        ind[(ind.length-1)].setAttribute("readonly", true);
			var vflag=document.getElementById('flag').value;
			document.getElementById('flag').value=vflag+(nut+10)+'G1S'+t+',';
        }
        else
        {
            ind[0].value = "";
        }
        if($(document).width()<100)
        {

            var test=$('.iph').find('thead th:nth-child('+(i+1)+')').text();
            $('#'+ids+nut).before('<label class="labls">'+test+'<span> *</span>:</label>');
            //$('#'+newcell.childNodes[0].id).after('<br><br>');
        }
    }
	$('.ids_'+inc+' .minw9').show();
}

function deleteRow(tableID) 
{
    if($(document).width()<100)
    {
        var num=0;
        $('.nudf').each(function(index, element) 
        {
            $(this).attr('id','ids_'+num);
            num++;
        });
        
        $('.nudf').each(function(index, element) {
            var lenft=$('.nudf').length;
            var nur=1;
            if($(this).css('display')=='table-row')
            {
                if(lenft==nur)
                {
                    $('#nxt').hide();
                    $('#nxt1').show();
                }
                var ids=$(this).attr('id');
                if(ids=='ids_0')
                {
                    jAlert('<b>At least one item is required.</b>', 'Message');
                    return false;
                }
                var sio=ids.split('_');
                $(this).remove();
                var cll=$('#ids_'+(sio[1]-1)).attr('class');

                if(cll=='ids_0 nudf')
                {
                    $('#pre').hide();
                    $('#pre1').show();
                    var gd=0;
                    $('.iph').find('thead th').each(function(index, element) 
                    {
                        gd=gd+1;
                        var text=$(this).text();
                        $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
                    });
                }
                $('#ids_'+(sio[1]-1)).show();
            }
            nur++;
        });
    }
    else
    {
        try {
            var cunt=0;
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
			var str='';
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
				
				//	var ind=nwcell.getElementsByTagName('input');
				
				//alert(nwcell);
                if(chkbox.id!='head')
                {
                    if(chkbox.checked)
                    {
						if(chkbox.title=='che')
						{
							var vflag=document.getElementById('flag').value;
							var str = vflag.split(',');
							//i-1 is added for table length count including header and vflag split for corresponding deleted row.
							var laststr=str[i-1];
							var sde=laststr.split('G1S');
							if(sde[1]=='U')
							{
								var lst=document.getElementById('flag_d').value;
								$(table.rows[i]).find(":input").each(function()
								{
									id = $(this).attr('id');
									val=$('#'+id).val();
									id_vals = id.match(/(\d+|[^\d]+)/g);
									name = $(this).attr('name');
									if(id != undefined && name != undefined && id != "bapiName")
									{
									if(delete_val=='')
										delete_val=id_vals[0] + '=' + val;
									else
										delete_val = delete_val + '&' + id_vals[0] + '=' + val;
									}
								});
							}
							if(strs=='')
								strs=vflag.replace(str[i-1]+',','');
							else
								strs=strs.replace(str[i-1]+',','');
						}
                        cunt=cunt+1;
                    }
                }
            }
            if(rowCount-1==cunt)
            {
                jAlert('<b>At least one item is required.</b>', 'Message');
            }
            else
            {
                for(var i=0; i<rowCount; i++) 
                {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
					//alert(row.cells[0].getElementsByTagName('input'));
                    if(chkbox.id!='head')
                    {
                        if(null != chkbox && true == chkbox.checked)
                        {
                            table.deleteRow(i);
                            rowCount--;
                            i--;
                        }
                    }
                }
            }
			if(delete_val!='')
			{
			$.cookie("deldata",delete_val);
			}
			if(strs!='')
				document.getElementById('flag').value=strs;
        }
        catch(e) {
        }
    }
	var num=0;
	
}


function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
      return str;
    }
}

function select_row(ids)
{
    if($('.'+ids).hasClass('bb'))
    {
        $('.'+ids).removeClass('bb');
        $('.'+ids).find('input:checkbox').prop('checked', false);
    }
    else
    {
        $('.'+ids).addClass('bb');
        $('.'+ids).find('input:checkbox').prop('checked', true);
    }
}

function pre()
{
    var lenft = $('.nudf').length;
    $('#nxt').css({color:'#000'});
    $('#nxt1').hide();
    $('#nxt').show();
    var num = 0;
    $('.nudf').each(function(index, element) {
        $(this).attr('id','ids_'+num);
        num++;
    });
	
    $('.nudf').each(function(index, element) {
        if($(this).css('display')=='table-row')
        {
            var ids=$(this).attr('id');
            var sio=ids.split('_');
            $(this).hide();
            $('#ids_'+(sio[1]-1)).show();
            if(sio[1]-1==0)
            {
                $('#pre1').css({color:'#cecece'});
                $('#pre1').show();
                $('#pre').hide();
                var gd=0;
                $('.iph').find('thead th').each(function(index, element) {
                    gd=gd+1;
                    var text=$(this).text();
                    $('.iph').find('tbody td:nth-child('+gd+')').children('input[type!="hidden"]').before('<label class="sda">'+text+'<span> *</span>:</label>');
                });
            }
            return false;
        }
    });
}

function nxt()
{
    $('.sda').remove();
    var lenft = $('.nudf').length;
    $('#pre').css({color:'#000'});
    $('#pre').show();
    $('#pre1').hide();
    var num=0;
    $('.nudf').each(function(index, element) {
        $(this).attr('id','ids_'+num);
        num++;
    });
    $('.nudf').each(function(index, element) {
        if($(this).css('display')=='table-row')
        {
            var ids=$(this).attr('id');
            var sio=ids.split('_');
            $(this).hide();
            var inid=sio[1];
            inid++;

            $('#ids_'+(inid)).show();
            if(inid==lenft-1)
            {
                $('#nxt1').css({color:'#cecece'});
                $('#nxt').hide();
                $('#nxt1').show();
            }
            return false;
        }
    });
}
	
	function urldecode (str) {
		return decodeURIComponent((str + '').replace(/\+/g, '%20'));
	}

$(document).ready(function(e) {
	//$(".minw").css("display","none");
	$("#add_row_table").css("display","none");
	
	$("#edit_salesorder").click(function() {
        $('#head_tittle').html("Edit Sales Order");
		var tblexample7Len = $('#example7 >tbody >tr').length;
		var tbldataTableLen = $('#dataTable >tbody >tr').length;
		
		$("#edit_salesorder").hide();
		$("#save_salesorder").show();
		$("#cancel_salesorder").show();
		
		$("#copy_form_data").hide();
		$("#NET_VAL_HD_hide").hide();
		
		
		$("#add_row_table").css("display","block");
		$(".tab-con").css("display","none");
		
		$("#validation7 input[type=text]").each(function(){
			//$(this).attr("readonly", false);
			//$(".minw").css("display","inline");
		});
		//$('#MATERIAL').attr('readonly','readonly');
		//$('#REQ_QTY').attr('readonly',false);
		//$('#NET_PRICE').attr('readonly',false);
		if(tbldataTableLen < tblexample7Len){
			rowlen = tblexample7Len-tbldataTableLen;
			// for(l=0;l<tblexample7Len-1;l++)
			for(l=0;l<rowlen;l++)
			{
				addRow('dataTable','U');
			}
		}
		
		// $("#dataTable input[type=text]").each(function(){
		// console.log(tblexample7Len);
		$("#dataTable tbody tr").each(function(rind){
			// console.log(rind);
			if(rind < tblexample7Len)
			{
				$(this).find("input[type=text]").each(function(){
					//$(this).attr("readonly", false);
					if($(this).attr("id").indexOf("MATERIAL") >= 0 || $(this).attr("id").indexOf("TARGET_QU") >= 0)
						if($(this).is("[readonly]"));
							$(this).next().hide();
					if($(this).attr("id").indexOf("REQ_QTY") >= 0 || $(this).attr("id").indexOf("NET_PRICE") >= 0){
						$(this).attr("readonly", false);
                    }
				});
			}
			else
			{
				$(this).find("input[type=text]").each(function(tindex){
					if(tindex > 0)
						$(this).attr("readonly", false);
				});
			}
		});
		
		var str = '';
		// $("#example7_tbody input[type=hidden]").each(function(){
		$("#example7_tbody").find("input[type=hidden]").each(function(){
			id = $(this).attr('ids');					
			val = $(this).attr('value');

			if(id != undefined) 
				str = str + id + '=' + val + '&';
		});
		
		var values = str.split("&");
		$("#dataTable input[type=text], #CURRENCY").each(function()
		{
			var id = $(this).attr('id');					
			for(var j=0; j < values.length; j++)
			{
				var value = values[j].split("=");
				if(id == value[0])
				{
					$(this).val(value[1]);
				}
			}
		});
	});
	
	$("#cancel_salesorder").click(function() 
	{
        $('#head_tittle').html("Display Sales Order")
		$("#edit_salesorder").show();
		$("#save_salesorder").hide();
		$("#cancel_salesorder").hide();
		
		$("#copy_form_data").show();
		$("#NET_VAL_HD_hide").show();
		
		$("#add_row_table").css("display","none");
		$(".tab-con").css("display","block");
		
		$("#validation7 input[type=text]").each(function(){
			$(this).attr("readonly", true);
			//$(".minw").css("display","none");
		});
	});
});

function change_disp_mode()
{
	$("#dataTable tbody tr").each(function(rindex) {
		newrow = false;
		$(this).find("[title='MATERIAL']").each(function() {
			ctrl_attr = $(this).attr("readonly");
			if(ctrl_attr == undefined)
				newrow = true;
		});
		if(newrow)
		{
			rowval = $(this).find("[type='text'],[type='hidden']").serialize();
			rowval = rowval.replace(/%5B%5D/gi, "");
			var values = rowval.split("&");
			row_id = eval($("#example7 tbody tr:last").attr("id"))+(10*(rindex+1));
			row_id = (10*rindex);
			$("#example7 tbody tr:first").clone().find("td").each(function(index) {
				$(this).find("input").attr({
					'ids': function(_, ids) { return ids + row_id }
				});
				if(index == 0)
				{
					tdhtml = $(this).html();
					$(this).html(tdhtml.replace(/10/gi, (row_id+10)));
				}
				else
				{
					tdtext = $(this).text().trim();
					tdhtml = $(this).html().trim();
					var re = new RegExp(tdtext, 'gi');
					
					inpctrl = $(this).find("input");
					if(values[index] != undefined)
					{
						var value = values[index].split("=");
						if(value[0] == "Currency")
						{
							var value = values[(index-1)].split("=");
							$(this).html(tdhtml.replace(re, urldecode(value[1])));
							tdtext = inpctrl.val().trim();
							tdhtml = $(this).html().trim();
							var re = new RegExp(tdtext, 'gi');
							$(this).html(tdhtml.replace(re, urldecode(value[1])));
						}
						else if(value[0] == "Price")
						{
							var qty = values[(index-1)].split("=");
							x = (urldecode(value[1])*qty[1]);
							rate = x.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
							$(this).html(tdhtml.replace(re, rate));
						}
						else if(value[0] == "su")
						{
							$(this).html(tdhtml.replace(re, value[1]));
							tdtext = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").text().trim();
							tdhtml = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html().trim();
							var re = new RegExp(tdtext, 'gi');
							$(this).closest("tr").find("[name='TARGET_QU']").closest("td").html(tdhtml.replace(re, value[1]));
						}
						else
							$(this).html(tdhtml.replace(re, value[1]));
					}
				}
			}).end().appendTo("#example7");
			$("#example7 tbody tr:last").attr("id", row_id);
		}
		else
		{
			rowval = $(this).find("[type='text'],[type='hidden']").serialize();
			rowval = rowval.replace(/%5B%5D/gi, "");
			var values = rowval.split("&");
			if(rindex == 0)
				row_id = 10;
			else
				row_id = (10*rindex);
			// console.log(row_id);
			// console.log($("#example7 tbody tr:nth-child("+(rindex+1)+")").find("td:first").text().trim());
			// return;
			$("#example7 tbody tr:nth-child("+(rindex+1)+")").find("td").each(function(index) {
				if(index == 0)
				{
					// tdhtml = $(this).html();
					// $(this).html(tdhtml.replace(/10/gi, (row_id+10)));
				}
				else
				{
					tdtext = $(this).text().trim();
					tdhtml = $(this).html().trim();
					var re = new RegExp(tdtext, 'gi');
					
					inpctrl = $(this).find("input");
					if(values[index] != undefined)
					{
						var value = values[index].split("=");
						if(value[0] == "Currency")
						{
							var value = values[(index-1)].split("=");
							$(this).html(tdhtml.replace(re, urldecode(value[1])));
							tdtext = inpctrl.val().trim();
							tdhtml = $(this).html().trim();
							var re = new RegExp(tdtext, 'gi');
							$(this).html(tdhtml.replace(re, urldecode(value[1])));
						}
						else if(value[0] == "Price")
						{
							var qty = values[(index-1)].split("=");
							x = (urldecode(value[1])*qty[1]);
							rate = x.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
							$(this).html(tdhtml.replace(re, rate));
						}
						else if(value[0] == "su")
						{
							$(this).html(tdhtml.replace(re, value[1]));
							tdtext = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").text().trim();
							tdhtml = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html().trim();
							var re = new RegExp(tdtext, 'gi');
							$(this).closest("tr").find("[name='TARGET_QU']").closest("td").html(tdhtml.replace(re, value[1]));
						}
						else
							$(this).html(tdhtml.replace(re, value[1]));
					}
				}
			});
		}
	});
}
function save_quotation()
{
	 //alert('hi');
	// console.log($('#validation7').serialize());
	// change_disp_mode();
	// return false;
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	// alert($('#validation7').serialize());
    $.ajax({
        type: 'POST', 
        data: $('#validation7').serialize(), 
        url: 'editsalesquotation/save_sales_quotation',			
        success: function(response) 
        {
			// alert(response);
			$('#loading').hide();
            $("body").css("opacity","1");			
            var spt = response.split("@");
			
			var n = spt[0].indexOf("System error");
			var type = spt[1];
			// alert(n);
			// if(n < 0)
			if(type != "E")
			{
				jConfirm('<b>SAP System Message: </b><br>'+ spt[0], 'Sales Quotation Change', function(r) {
					if(r)
					{
						$('#loading').show();
						$("body").css("opacity","0.4");
						$("body").css("filter","alpha(opacity=40)");
						$.ajax({
							type:'POST',
							data:$('#validation7').serialize(),
							url: 'editsalesquotation/commit',
							success: function(response)
							{
								change_disp_mode();
								if($.cookie("deldata"))
								{
									$.cookie("deldata", null);
								}
								$('#loading').hide();
								$("body").css("opacity","1");
								$("#cancel_salesorder").trigger("click");
								jAlert('<b>SAP System Message: </b><br> Changed Successfully', 'Sales Quotaion Change');
							}
						});
					}
				});
				$("#popup_ok").val('Click to Confirm');
			}
			else
				jAlert('<b>SAP System Message: </b><br>'+ spt[0], 'Sales Quotation Change');
        }
    });
}

function orders()
{
}

function strpdf()
{
	$('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
		type:'POST',
		data:'order_num='+number($('#I_VBELN').val())+'&bapi=editsalesquotation_doc',
		url:'editsalesquotation/stringpdf',
		success:function(data){
		//	alert(data);
		$('#loading').hide();
            $("body").css("opacity","1");
			if($.trim(data)!='')
			{
				jAlert(data,'Message');
			}
			else
			{
				var tab=window.open('common/Pdfurl');
				tab.focus();
			}
		}
	});	
}
</script>