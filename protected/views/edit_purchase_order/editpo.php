<?php
	global $rfc,$fce;
	$PURCHASE_ORDER  = strtoupper($_REQUEST['PURCHASE_ORDER']);
	
	//GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$res = $fce->invoke(['PURCHASEORDER'=> $PURCHASE_ORDER,
						'ACCOUNT_ASSIGNMENT'=> 'X',
						'ITEM_TEXT'=> 'X',
						'HEADER_TEXT'=> 'X',
						'DELIVERY_ADDRESS'=> 'X',
						'VERSION'=> 'X',
						'SERVICES'=> 'X',
						'SERIALNUMBERS'=> 'X',
						'INVOICEPLAN'=> 'X'],$options);
	
	$POHEADER	= $res['POHEADER'];
	
	$comp_code 	= $POHEADER['COMP_CODE'];
    $vendor		= ltrim($POHEADER['VENDOR'], "0");
    $purch_org	= $POHEADER['PURCH_ORG'];
    $pur_group	= $POHEADER['PUR_GROUP'];
	$ref 		= $POHEADER['OUR_REF'];
		
	$SalesOrders= $res['POITEM'];
	
	//var_dump($POHEADER);
	//var_dump($POITEM);
		
	$sd = 0;
	//////////////////////////////////////////////////////////////////////////////////
	$table_inf  = "PO_ITEM,MATERIAL,SHORT_TEXT,PLANT,STGE_LOC,";
	$labels_inf = "PO_ITEM,MATERIAL,SHORT_TEXT,PLANT,STGE_LOC,";
	$exps1 = explode(',',$table_inf);
	$exp = explode(',', $labels_inf);
	if(count($exp>0))
	$count=count($exp)-1;
	else
	$count=11;
	if(count($exp)<11)
	{
		for($j=count($exp)-1;$j<count($exps1);$j++)
		{
			$exp[$j]=$exps1[$j];
		}
	}
	foreach ($SalesOrders as $val_t => $retur) {
		$order_t = array($exp[0] => $retur[$exp[0]], $exp[1] => $retur[$exp[1]], $exp[2] => $retur[$exp[2]],$exp[3] => $retur[$exp[3]], 
		$exp[4] => $retur[$exp[4]]);
		unset($retur[$exp[0]], $retur[$exp[1]], $retur[$exp[2]], $retur[$exp[3]], $retur[$exp[4]]);
		$today = $retur;
		$SalesOrder[$sd] = array_merge((array) $order_t, (array) $today);
		$sd++;
	}
	//................................................................................
	$POITEM = $SalesOrder;
	$this->renderPartial('smarttable',array('count'=>$count));
?>
<style>
.table th:nth-child(-n+<?php echo $count;?>), .table td:nth-child(-n+<?php echo $count;?>){

	display:table-cell;
	
	}
</style>
<section id="formElement" class=" utopia-form-box section">
    <div style="float:right;"><a style="cursor: pointer;" onclick="pdfstrgpur(<?php echo $PURCHASE_ORDER; ?>)"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png"/>Purchase Order Confirmation</a></div>
    <div class="clear"></div>
	<div class="row-fluid">
		<div class="utopia-widget-content">
            <form id="validation_pur" action="" class="form-horizontal" >
			<div class="span5 utopia-form-freeSpace myspace">
				<fieldset>
					<div class="control-group">
						<label class="control-label cutz in_custz" style="width: 155px" for="date" alt="Company Code"><?php echo Controller::customize_label('Company Code'); ?>:&nbsp;&nbsp;</label>
						<div class="controls">
							<input alt="Company Code" type="text" class="input-fluid  getval" name="COMP_CODE" tabindex="1" readonly value="<?php echo $comp_code; ?>" autocomplete="off" id="COMP_CODE">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label  cutz in_custz" style="width: 155px" for="input01" alt='Vendor Number'><?php echo Controller::customize_label('Vendor Number'); ?>:&nbsp;&nbsp;</label>
						<div class="controls">
							<input  alt="Vendor Number" type="text" class="input-fluid  getval" name='VENDOR' tabindex="2" readonly value="<?php echo $vendor; ?>" autocomplete="off" id="VENDOR" >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label  cutz in_custz" style="width: 155px" for="input01" alt='Purchasing Organization'><?php echo Controller::customize_label('Purchasing Organization'); ?>:&nbsp;&nbsp;</label>
						<div class="controls">
							<input alt="Purchasing Organization" type="text" class="input-fluid  getval" name='PURCH_ORG' tabindex="3" readonly value="<?php echo $purch_org; ?>" autocomplete="off" id="PURCH_ORG" >
						</div>
					</div>
				</fieldset>
			</div>
			<div class="span5 utopia-form-freeSpace myspace rid">
				<fieldset>
					<div class="control-group">
						<label class="control-label  cutz" for="input01" alt='Purchasing Group'> <?php echo Controller::customize_label('Purchasing Group'); ?>:&nbsp;&nbsp;</label>
						<div class="controls">
							<input alt="Purchasing Group" type="text" class="input-fluid  getval" name='PUR_GROUP' tabindex="4" readonly value="<?php echo $pur_group; ?>" autocomplete="off" id="PUR_GROUP1" >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label  cutz " for="input01" alt='Reference'><?php echo Controller::customize_label('Reference'); ?>:&nbsp;&nbsp;</label>
						<div class="controls">
							<input alt="Reference" type="text" class="input-fluid  getval" name='OUR_REF' tabindex="5" readonly value="<?php echo $ref; ?>" autocomplete="off" id="OUR_REF">
						</div>
					</div>
				</fieldset>
			</div>
        </form>
			<div class="row-fluid">
				<div class="span12">
					<div class="tab-content tab-con">
						<h3>Items</h3>
						<?php
							if($POITEM != NULL)
							{
								?>
								<div class="labl pos_pop">
									<div class='pos_center'></div>
									<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
									<button  class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
								</div>
								<div class="head_icons">
									<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example7')" ></span>
								</div>
								<?php
							}
						?>
						<div id='example7_today'>
							<?php
								if($POITEM != NULL)
								{
									?>
										<div class="display_sales_header"></div>
										<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
										<table class="table table-bordered" id="example7">
										<?php
											$t_headers = Controller::technical_names('BAPIMEPOITEM');
											$r = "";
											for($i = 0; $i < count($POITEM); $i++)
											{
												$SalesOrders = $POITEM[$i];
												if ($i == 0)
												{
													?>
													<thead>
														<tr>
															<?php
																foreach($SalesOrders as $keys => $vales)
																{
																	echo "";
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
																foreach($SalesOrders as $keys => $vales)
																{
																	?>
																	<th><input type="text" class="search_int" value="" alt='<?php echo $j; ?>' name="table_today@example"></th>
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
														foreach($SalesOrders as $keys => $vales)
														{
															?>
															<td class="example7_cl<?php echo $col; ?>"><?php echo $vales; ?></td>
															<?php
															$col++;
														}
													?>
												</tr>
												<?php
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
				</div>
			</div>
		</div>
	</div>
</section>