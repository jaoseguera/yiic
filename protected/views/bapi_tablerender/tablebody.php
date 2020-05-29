<?php
	$bb = array(
		'Sales_order_credit_block' => 'sales_order_credit_block',
		'Sales_order_dashboard' => 'sales_order_dashboard',
		'Todays_Orders' => 'sales_workbench',
		'Sales_workbench' => 'sales_workbench',
		'sales_workbench' => 'sales_workbench',
		'Sales_Orders_Due_for_Delivery' => 'sales_workbench',
		'Return_Orders' => 'sales_workbench',
		'Delivery_Due_for_Billing' => 'sales_workbench',
		'Search_customers' => 'search_customers',
		'search_customers' => 'search_customers',
		'Search_sales_orders' => 'search_sales_orders',
		'Delivery_list' => 'delivery_list',
		'production_workbench' => 'production_workbench',
		'prodcution_workbench' => 'prodcution_workbench',
		'Inforecords' => 'inforecords',
		'Sales_order_dashboard_delivery' => 'Sales_order_dashboard',
		'Search_customer' => 'Search_customer',
		'Inforecord_Purchase_Org' => 'Inforecord_Purchase_Org',
		'Sales_orders' => 'editcustomers',
		'Search_purchase_requisition' => 'search_purchase_requisition',
		'search_purchase_orders' => 'search_purchase_orders',
		'Search_ZCOMS' => 'Search_ZCOMS',
		'Search_ZVA05' => 'Search_ZVA05',
		'Search_ZCOOIS' => 'Search_ZCOOIS',
		'Back_Orders' => 'Back_Orders',
		'Search_vendors'=>'search_vendors',
		'Search_sales_quotation'=>'search_sales_quotation',
		'Workflow_inbox'=>'workflow_inbox'
	);
	$back_to = $bb[$table_name];
	?>
<tr Onclick="thisrow(this,'<?php echo $i; ?>',event)">
<?php
	$col = 0;
	$td = 1;
	$scrn='';
	foreach($SalesOrders as $keys => $vales)
	{
		$jon = urlencode(json_encode($SalesOrders));
		if($td<=$t_h_c)
			$style = "";
		else
			$style = "style='display:none;'";
		
		$date = Controller::dateValue($t_headers, $keys, $vales);
		if($date != false)
		{
			$vales = $date;
			$id = $vales;
		}
		else
		{
			$num = Controller::numberFormat($t_headers, $keys, $vales);
			
			if($num != false)
			{
				//GEZG 10/28/2019
				//Removing leading minus sign for displaying numbers in tables
				if(strpos(strval($num),"-") !== false  && strpos(strval($num),"-") === 0){
					$num = substr(strval($num),1);
				}
				$vl=explode('.',$num);
				if(isset($vl[1]))
				{
					$vales='<div align="right">'.$num.'</div>';
					$id = $num;
				}else
				{
					$vales = $num;
					$id = $vales;
				}
			}else
				$id = $vales;
		}

		$vales=($vales=='00/00/0000'?'':$vales);
		if($vales=='0.00')
			$vales='<div align="right">'.$vales.'</div>';
			
		?>
		<td class="<?php echo $t_id; ?>_cl<?php echo $col; ?>">
			<?php
				if(($keys == "KUNNR" && $tec_name != 'BAPIDLVHDR') || $keys == "CUSTOMER")
				{
					?>
					<div id='<?php echo $id . '_' . $col . '_' . $i; ?>' style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_cus('<?php echo $id . '_' . $col . '_' . $i; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif($keys == "VBELN" && $tec_name == 'BAPIDLVHDR')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_dilv('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','<?php echo $tec_name; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')" title="Pick and post goods"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif(($keys == "VBELN" || $keys == "SD_DOC") && $tec_name != 'DOCUMENT_FLOW_ALV_STRUC')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col . '_' . $i); ?>" style="cursor:pointer;color:#00AFF0;">
					<?php if($back_to=='search_sales_quotation')
				{ ?>
				<div id='display1' name='<?php echo $back_to; ?>' onclick='side_links(this,"<?php echo $table_div; ?>")' alt='Editsalesquotation_sold/Editsalesquotation_sold/?key=ZBAPISDORDER_GETDETAILEDLIST&I_VBELN=<?php echo $vales; ?>&titl=Display Sales Quotation&tabs=editsalesquotation&key=editsalesquotation'><?php echo $vales; ?></div>
				<?php } else { ?> 
						<div onClick="show_menu('<?php echo trim($id . '_' . $col . '_' . $i); ?>','<?php echo $jon; ?>','<?php echo $tec_name; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')"><?php echo $vales; ?></div>
				<?php } ?>	</div>
					<?php
				}
				elseif($keys == "DOCNUM" && $tec_name == 'DOCUMENT_FLOW_ALV_STRUC')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col . '_' . $i); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_menu('<?php echo trim($id . '_' . $col . '_' . $i); ?>','<?php echo $jon; ?>','<?php echo $tec_name; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif($keys == 'MATERIAL')
				{
					$plant = $SalesOrders['PLANT'];
					if(empty($plant))
						$plant = $_REQUEST['PLANT'];
					if($tec_name != 'BAPIEINA')
						$div_ids = preg_replace("/[^A-Za-z0-9]/", "", $vales);
					else
						$div_ids = $vales;
					?>
					<div id="<?php echo $i.'_'.trim($div_ids); ?>" style="cursor:pointer;color:#00AFF0;">
						<?php
							if($tec_name != 'BAPIEINA')
							{
								?>
								<div onClick="show_prod('<?php echo $i.'_'.$div_ids; ?>','<?php echo $plant; ?>','product_availability','<?php echo $table_div; ?>');" title=""><?php echo $vales; ?></div>
								<?php
							}
							else
							{
								?>
								<div onClick="show_info_rec('<?php echo $vales; ?>','<?php echo $jon; ?>','inforecords'),'<?php echo $table_div; ?>'" title=""><?php echo $vales; ?></div>
								<?php
							}
						?>
					</div>
					<?php
				}
				elseif($keys == 'LIFNR' || $keys == 'VENDOR')
				{
					?>
					<div id='<?php echo $id . '_' . $col . '_' . $i; ?>' style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_vendor_menu('<?php echo $id . '_' . $col . '_' . $i; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				/*
				elseif($keys == 'DOC_NUMBER' && $table_name == "editsalesorder")
				{
					?>
					<!--
					<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_menu('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','/KYK/SERPSLS_GENDOC_FLAGS_STS','sales_workbench')"><?php echo $vales . '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys . '" name="' . $keys . '[]" value="' . $vales . '" alt="true">'; ?></div>
					</div>
					-->
					<?php
				}
				*/
				elseif($keys == 'PREQ_NO' && $table_name != "Search_purchase_requisition" && $table_name != "table_today" && $table_name != "table_convert_PO" && $table_name != "Search_purchase_requisition_PO")
				{
					?>
					<div id='<?php echo trim($id . '_' . $col); ?>' style="cursor:pointer;color:#00AFF0;" class="poc" alt="<?php echo $vales.','.$SalesOrders['PREQ_ITEM']; ?>">
						<div onClick="approve_r('<?php echo trim($id . '_' . $col); ?>','<?php echo $vales; ?>','<?php echo $table_div; ?>')"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif($keys == 'PREQ_NO' && $table_name == "Search_purchase_requisition_PO")
				{
					?>
					<div id='<?php echo trim($id . '_' . $col); ?>' class="poc" alt="<?php echo $vales.','.$SalesOrders['PREQ_ITEM'].','.$SalesOrders['PURCH_ORG'].','.$SalesOrders['PUR_GROUP'].','.$SalesOrders['MATERIAL'].','.$SalesOrders['PLANT'].','.$SalesOrders['UNIT'].','.$SalesOrders['QUANTITY'].','.$SalesOrders['FIXED_VEND']; ?>"><?php echo $vales; ?></div>
					<?php
				}
				elseif($keys == 'PO_NUMBER')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_purch('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','<?php echo $tec_name; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')" ><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif ($keys == 'BILLINGDOC')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_doc('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','<?php echo $tec_name; ?>','<?php echo $back_to; ?>','<?php echo $table_div; ?>')" title="Display"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif ($keys == 'ORDER_NUMBER')
				{
					?>
					<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="show_rels('<?php echo trim($id . '_' . $col); ?>','<?php echo $vales; ?>','BAPI_ORDER_HEADER1','<?php echo $back_to; ?>','<?php echo $table_div; ?>')" title="Release Production order"><?php echo $vales; ?></div>
					</div>
					<?php
				}
				elseif ($keys=='CHANGENR' || $keys=='COSTCENTER' )
				{
				?>
				<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
						<div onClick="change('<?php echo $vales; ?>','<?php echo $SalesOrders['STATUS']; ?>')" title="Change Number"><?php echo $vales; ?></div>
					</div>
				<?php 
				}
				elseif ($keys=='WI_TEXT')
				{
				?>
				<div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
				<div id='execute<?php echo $i; ?>' name='<?php echo $back_to; ?>' onclick='execute("execute<?php echo $i; ?>","<?php echo $table_div; ?>")' alt='workflow_inbox/customer_details/?c_no=<?php echo $SalesOrders['WI_ID']?>&c_id=<?php echo $vales; ?>&titl=Approve Customer Master&tabs=approvecustomermaster&key=editsalesquotation'><?php echo $vales; ?></div>
				</div>
				<?php 
				}
				elseif($keys=='AUART' && $vales=='TA')
					echo 'OR';
				elseif($keys=='DOC_TYPE' && $vales=='AG')	
					echo 'QT';
				else
					echo $vales;
					
			?>
		</td>
		<?php
		$col++;
		$td++;
	}
	if($tec_name == "ZBAPI_SLS_LIST_ORDERS_OUT" || $tec_name == "/KYK/S_POWL_BILLDUE")
	{
		?>
		<td style="display:none;"><input type='checkbox' value="<?php echo $array23[$i]; ?>" name='deli[]' class='deli_<?php echo $i; ?>'></td>
		<?php
	}
?>
</tr>