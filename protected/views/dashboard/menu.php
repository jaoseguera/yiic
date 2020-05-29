<?php
	if(Yii::app()->user->hasState("extended"))
		$extended = Yii::app()->user->getState('extended');
	else
		$extended = "";
	
	$role 		= Yii::app()->user->getState("role");
	$Company_ID	= Yii::app()->user->getState("company_id");
	$customize 	= $model;
	$client 	= Controller::couchDbconnection();
	$doc		= $client->getDoc('menus');
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);	
	if(isset($_SESSION["USER_LANG"])){		
		if(trim(strtoupper($_SESSION["USER_LANG"])) == "ES"){			
			$menu = $gs['dashboard_'.trim(strtolower($_SESSION["USER_LANG"]))];		
		}
		else{
			$menu = $gs['dashboard'];	
		}
	}else{
		$menu = $gs['dashboard'];	
	}
	
	
	$client 	= Controller::companyDbconnection();
	$doc		= $client->getDoc($Company_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	$all_mnu = $gs['selected_functions'];
	$roles = $gs['roles'][$role];
	$RMA='';
/*	$function=$doc->default_functions;
	isset($function->Returns_Portal)?$RMA=$function->Returns_Portal:$RMA */
	if($role=='emg_retailer')
	{
	$client 	= Controller::userDbconnection();
	$doc		= $client->getDoc(Yii::app()->user->getState("user_id"));
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	$roles = $gs['selected_functions'];
	}
	if(isset($all_mnu['Returns_Portal']))
	{
		unset($all_mnu['Returns_Portal']);
		$RMA='show';
	}
	if(isset($roles['Returns_Portal']))
	{
		unset($roles['Returns_Portal']);
		
	}	
	//unset($roles['Welcome']);
	//$roles		= ($role == 'Primary') ? $menu : $roles;
?>
<div class="sidebar">
	<div class="nav-collapse collapse">
		<ul class="accordion level-1" >
			<!--<li class="topli sales_dashbord active"><a href="dashboard">Welcome</a></li>--><?php
			if(!Yii::app()->user->getState("BI_REPORT"))
			{
				if($role != 'Primary' && $role != 'Admin' && $Company_ID != "freetrial")
				{
					$functions = $roles;
				}
				else
				{
					$functions = $all_mnu;
				}
                    $i=0;
					foreach($functions as $key => $val)
					{
                        if($i==0)
                            echo '<li  class="topli">';
                        else
                            echo '<li>';
                        //echo '<li>';
							echo '<a href="#">'.constant("_".str_replace(" ", "_", strtoupper($key))).'</a>';
							if(is_array($val))
							{
								echo '<ul class="level-2">';
								foreach($val as $key1 => $val1)
								{
									$title 		= $menu[$key][$val1]['title'];
									$href 		= $menu[$key][$val1]['href'];
									$click 		= $menu[$key][$val1]['click'];
									$sub_extend	= $menu[$key][$val1]['extended'];
									$li_id		= substr($href, 1);
									
									if(!is_array($val1))
									{
										if(!is_array($val[$val1]))
										{
											if($extended == 'off' && $sub_extend == 'on')
												$cls = " lite";
											else
												$cls = "";
											
											echo '
												<li class="sales_dashbord'.$cls.'">
													<a href="'.$href.'" id="'.$li_id.'">'.$title.'</a>
													<div id="'.$li_id.'_t" onClick="'.$click.'"></div>
												</li>';
										}
										else
										{
											echo '<li><a href="#">'.$menu[$key][$val1]['title'].'</a><ul class="level-3">';
											foreach($val[$val1] as $key2 => $val2)
											{
												$title 		= $menu[$key][$val1][$val2]['title'];
												$href 		= $menu[$key][$val1][$val2]['href'];
												$click 		= $menu[$key][$val1][$val2]['click'];
												$sub_extend	= $menu[$key][$val1][$val2]['extended'];
												$li_id		= substr($href, 1);
												
												if($extended == 'off' && $sub_extend == 'on')
													$cls = " class='lite'";
												else
													$cls = "";
												
												echo '
													<li'.$cls.'>
														<a href="'.$href.'" id="'.$li_id.'">'.$title.'</a>
														<div id="'.$li_id.'_t" onClick="'.$click.'"></div>
													</li>';
											}
											echo '</ul></li>';
										}
									}
								}
								echo '</ul>';
							}
						echo '</li>';
                        $i++;
					}
/*
				}
				else
				{
					//unset($menu['Welcome']);
                    $i=0;
					foreach($all_mnu as $key => $val)
					{
					
						if($i==0)
                            echo '<li  class="topli">';
                        else
                            echo '<li>';
							echo '<a href="#">'.$key.'</a>';
							if(is_array($val))
							{
								echo '<ul class="level-2">';
								foreach($val as $key1 => $val1)
								{
									$key1		= $val1;
									$val1		= $menu[$key][$val1];
									$title 		= $val1['title'];
									$href 		= $val1['href'];
									$click 		= $val1['click'];
									$sub_extend	= $val1['extended'];
									$li_id		= substr($href, 1);
									
									if(is_array($val1))
									{
										if(isset($val1['title']))
										{
											if($extended == 'off' && $sub_extend == 'on')
												$cls = " lite";
											else
												$cls = "";
											
											echo '
												<li class="sales_dashbord'.$cls.'">
													<a href="'.$href.'" id="'.$li_id.'">'.$title.'</a>
													<div id="'.$li_id.'_t" onClick="'.$click.'"></div>
												</li>';
										}
										else
										{
											echo '<li><a href="#">'.$key1.'</a><ul class="level-3">';
											foreach($val1 as $key2 => $val2)
											{
												$title 		= $val2['title'];
												$href 		= $val2['href'];
												$click 		= $val2['click'];
												$sub_extend	= $val2['extended'];
												$li_id		= substr($href, 1);
												
												if($extended == 'off' && $sub_extend == 'on')
													$cls = " class='lite'";
												else
													$cls = "";
												
												echo '
													<li'.$cls.'>
														<a href="'.$href.'" id="'.$li_id.'">'.$title.'</a>
														<div id="'.$li_id.'_t" onClick="'.$click.'"></div>
													</li>';
											}
											echo '</ul></li>';
										}
									}
								}
								echo '</ul>';
							}
						echo '</li>';
                        $i++;
						}
						
*/
				if($role == 'Primary' || $role == 'Admin')
				{					
					if($RMA=='show')
					{
					echo '<li class=" sales_dashbord">
								<a href="#Check_Returns_status_admin" id="company_features" onClick="sap_form(\'Check_returns_status_admin\')">'._CHECK_RETURN_STATUS.'</a>
							</li>';
					}
				}
				?>
				<!--
				<li>
					<a href="#">Sales</a>
					<ul class="level-2">	
						<li class="sales_dashbord lite">
							<a href="#sales_workbench" id='sales_workbench' >Sales Workbench</a>
							<div id='sales_workbench_t' onClick="sap_app('sales_workbench')"></div>
						</li>                                
						<li>
							<a href="#" >Customers</a>
							<ul class="level-3">
								<li>
									<a href="#search_customers" id='search_customers' >Search</a>
									<div id='search_customers_t' onClick="sap_form('search_customers')"></div>
								</li>
								<li class="lite">
									<a href="#create_customers" id='create_customers' >Create</a>
									<div id='create_customers_t' onClick="sap_form('create_customers')"></div>
								</li>
								<li>
									<a href="#editcustomers" id='editcustomers' >Display/Edit</a>
									<div id='editcustomers_t' onClick="sap_form('editcustomers')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">Orders</a>
							<ul class="level-3">	
								<li >
									<a href="#sales_order_dashboard" id='sales_order_dashboard'>Order Dashboard</a>
									<div id='sales_order_dashboard_t' onClick="sap_form('sales_order_dashboard')"></div>
								</li>
								<li >
									<a href="#search_sales_orders" id='search_sales_orders' >Search</a>
									<div id='search_sales_orders_t' onClick="sap_form('search_sales_orders')"></div>
								</li>
								<li>
									<a href="#create_sales_order" id='create_sales_order' >Create</a>
									<div id='create_sales_order_t' onClick="sap_form('create_sales_order')"></div>
								</li><?php
								if(Yii::app()->user->getState("HOST")=='199.204.218.222')
								{
									?><li>
										<a href="#create_2" id='create_2' >Create 2</a>
										<div id='create_2_t' onClick="sap_form('create_2')"></div>
									</li><?php
								}
								?><li>
									<a href="#editsalesorder" id='editsalesorder'>Display/Edit</a>
									<div id='editsalesorder_t' onClick="sap_form('editsalesorder')"></div>
								</li>
								<li>
									<a href="#sales_order_credit_block" id='sales_order_credit_block' >Credit Blocks / Release</a>
									<div id='sales_order_credit_block_t' onClick="sap_app('sales_order_credit_block')"></div>
								</li>                                    
								<li class="lite">
									<a href="#document_flow" id='document_flow' >Document Flow</a>
									<div id='document_flow_t' onClick="sap_form('document_flow')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" >Delivery</a>
							<ul class="level-3">
								<li >
									<a href="#delivery_list" id='delivery_list' >List</a>
									<div id='delivery_list_t' onClick="sap_form('delivery_list')"></div>
								</li>
								<li >
									<a href="#create_delivery" id='create_delivery'>Create</a>
									<div id='create_delivery_t' onClick="sap_form('create_delivery')"></div>
								</li>
								<li >
									<a href="#picking_and_post_goods" id='picking_and_post_goods' >Pick and Post</a>
									<div id='picking_and_post_goods_t' onClick="sap_form('picking_and_post_goods')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" >Product</a>
							<ul class="level-3">
							<li>
								<a href="#product_availability" id="product_availability" >Product Availability</a>
								<div id="product_availability_t" onClick="sap_form('product_availability')"></div>
							</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="colspes_show">
					<a href="#" id='fft' >Finance</a>
					<ul class="level-2">
						<li>
							<a href="#" >Sales</a>
							<ul class="level-3">
								<li class="lite">
									<a href="#salesorder_creditblock" id="salesorder_creditblock" >Credit Blocks / Release</a>
									<div id="salesorder_creditblock_t" onClick="sap_app('sales_order_credit_block')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" >Billing</a>
							<ul class="level-3">
								<li>
									<a href="#display_billing_list" id='display_billing_list' >Display</a>
									<div id='display_billing_list_t' onClick="sap_app('display_billing_list')"></div>
								</li>
								<li class="lite">
									<a href="#post_incoming_payment" id='post_incoming_payment' >Post Payment</a>
									<div id='post_incoming_payment_t' onClick="sap_form('post_incoming_payment')"></div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Procurement</a>
					<ul class="level-2" >
						<li>
							<a href="#">Vendors</a>
							<ul class="level-3">
								<li>
									<a href="#search_vendors" id='search_vendors'>Search</a>
									<div id='search_vendors_t' onClick="sap_form('search_vendors')"></div>
								</li>
								<li>
									<a href="#editvendors" id='editvendors'>Display/Edit</a>
									<div id='editvendors_t' onClick="sap_form('editvendors')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">Requisitions</a>
							<ul class='level-3'>	                                       
								<li>
									<a href="#search_purchase_requisition" id='search_purchase_requisition' >Search</a>
									<div id='search_purchase_requisition_t' onClick="sap_form('search_purchase_requisition')"></div>
								</li>
								<li>
								<a href="#create_purchase_requisition" id='create_purchase_requisition' >Create</a>
								<div id='create_purchase_requisition_t' onClick="sap_form('create_purchase_requisition')"></div>
								</li>
								<li>
								<a href="#approve_purchase_requisition" id='approve_purchase_requisition'>Approve</a>
								<div id='approve_purchase_requisition_t' onClick="sap_app('approve_purchase_requisition','BAPI_REQUISITION_GETITEMSREL')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">Purchase Orders</a>
							<ul class='level-3'>
								<li>
								<a href="#search_purchase_orders" id='search_purchase_orders' >Search</a>
								<div id='search_purchase_orders_t' onClick="sap_form('search_purchase_orders')"></div>
								</li>
								<li>
								<a href="#create_purchase_order" id='create_purchase_order' >Create</a>
								<div id='create_purchase_order_t' onClick="sap_form('create_purchase_order')"></div>
								</li>
								<li>
								<a href="#approve_purchase_order" id='approve_purchase_order' >Approve</a>
								<div  id='approve_purchase_order_t' onClick="sap_form('approve_purchase_order')"></div>
								</li>
								<li>
								<a href="#post_good_receipt" id='post_good_receipt' >Goods Receipt</a>
								<div id='post_good_receipt_t' onClick="sap_form('post_good_receipt')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" >Product</a>
							<ul class="level-3">
								<li>
									<a href="#productavailability" id="productavailability" >Product Availability</a>
									<div  id="productavailability_t" onClick="sap_form('product_availability')"></div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Production</a>
					<ul class='level-2' >
						<?php if($extended!='on') { ?>
						<li class="sales_dashbord">
							<a href="#prodcution_workbench" id='prodcution_workbench' >Production Workbench</a>
							<div id='prodcution_workbench_t' onClick="sap_app('production_workbench')"></div>
						</li>
						<?php } else
						{ ?>
						<li class="sales_dashbord">
							<a href="#production_workbench" id='production_workbench' >Production Workbench</a>
							<div id='production_workbench_t' onClick="sap_app('production_workbench')"></div>
						</li>
						<?php } ?>
						<li >
						<a href="#">Production Order</a>
							<ul class='level-3'>
								<li>
									<a href="#create_prod_order" id='create_prod_order' >Create Prod Order</a>
									<div id='create_prod_order_t' onClick="sap_form('create_prod_order')"></div>
								</li>
								<li>
									<a href="#release_prod_order" id='release_prod_order' >Release Prod Order</a>
									<div id='release_prod_order_t' onClick="sap_form('release_prod_order')"></div>
								</li>
								<li>
									<a href="#confirm_prod_order" id='confirm_prod_order' >Confirm Prod Order</a>
									<div id='confirm_prod_order_t' onClick="sap_form('confirm_prod_order')"></div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">Costing</a>
							<ul class='level-3'>
								<li>
									<a href="#production_order_costing" id='production_order_costing' >Production Order Costing</a>
									<div id='production_order_costing_t' onClick="sap_form('production_order_costing')"></div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Reports</a>
					<ul class='level-2' >
						<li class="sales_dashbord">
							<a href="#sales_reports" id='sales_reports' >Sales</a>
							<div id='sales_reports_t' onClick="sap_form('sales_reports')"></div>
						</li>
						<li class="sales_dashbord">
							<a href="#purchasing_reports" id='purchasing_reports' >Purchasing</a>
							<div id='purchasing_reports_t' onClick="sap_form('purchasing_reports')"></div>
						</li>
						<li class="sales_dashbord">
							<a href="#production_reports" id='production_reports' >Production</a>
							<div id='production_reports_t' onClick="sap_form('production_reports')"></div>
						</li>
						<li class="sales_dashbord">
							<a href="#finance_reports" id='finance_reports' >Finance</a>
							<div id='finance_reports_t' onClick="sap_form('finance_reports')"></div>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Analysis</a>
					<ul class='level-2' >
						<li class="sales_dashbord">
							<a href="#sales_analysis" id='sales_analysis' >Sales</a>
							<div id='sales_analysis_t' onClick="sap_form('sales_analysis')"></div>
						</li>
					 </ul>
				</li>
				-->
				<?php 
			}   
			else
			{
				?><li class="sales_dashbord">
					<a href='#bi_reports' id='bi_reports' ><?=_BIREPORTS?></a>
					<div id='bi_reports_t' onClick="sap_form('bi_reports')"></div>
				</li><?php 
			}
			if(Yii::app()->user->getState("HOST")=='76.191.119.98')
			{
				?> <!--<li>
					<a href="#">Support</a>
					<ul class='level-3'>											
						<li>
							<a href="#search_material" id='search_material' >Search Material</a>
							<div id='search_material_t' onClick="sap_form('search_material')"></div>
						</li>											
					</ul>
				</li> --><?php 
			}                    
			if(strpos(Yii::app()->user->getState("HOST"),'63.234.27.3')!=0) 
			{
				?><li class="sales_dashbord">                        
					<a href="#"><?=_REPORTS?></a>
					<ul class='level-3'>											
						<li class="sales_dashbord">
							<a href="#commission_report" id='commission_report'><?=_COMMISSIONREPORT?></a>
							<div id='commission_report_t' onClick="sap_form('commission_report')"></div>
						</li>
						<li class="sales_dashbord">
							<a href="#sales_order_report" id='sales_order_report'><?=_SALESORDERREPORT?></a>
							<div id='sales_order_report_t' onClick="sap_form('sales_order_report')"></div>
						</li>
						<li class="sales_dashbord">
							<a href="#custom_scheduling_report" id='custom_scheduling_report'><?=_CUSTOMSCCEHULINGREPORT?></a>
							<div id='custom_scheduling_report_t' onClick="sap_form('custom_scheduling_report')"></div>
						</li>											
					</ul>
				</li><?php 
			}
		
		?>
						
							</ul>

		<ul style="display:none;">
			<li>
				<a class="list" href="javascript:void(0)" ><span><?=_ORDERCASH?></span></a>
				<?php if($extended=='on'){?>
				<ul class="dropdown">
					<li><a class="tables" href="#" onClick="sap_form('search_customers')"><span><?=_SEARCHCUSTOMERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('create_customers')"><span><?=_CREATECUSTOMERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('editcustomers')"><span><?=_EDITCUSTOMERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('search_sales_orders')"><span><?=_SEARCHSALESORDERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('create_sales_order')"><span><?=_CREATESALESORDER?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('create_delivery')" ><span><?=_CREATEDELIVERY?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_app('delivery_list','BAPI_DELIVERY_GETLIST')"><span><?=_DELIVERYLIST?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_app('billing_list','BAPI_BILLINGDOC_GETLIST')"><span><?=_BILLINGLIST?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('sales_order_dashboard')"><span><?=_DASHBOARDSALES?></span></a></li>
					<li><a class="tables" href="#" ><span><?=_DASHBOARDINVOICED?></span></a></li>
					<li><a class="tables" href="#" id="sales_work_bench" onClick="sap_app('sales_workbench','ZBAPI_POWL_QUERY')"><span><?=_SALESWORKBENCH?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('picking_and_post_goods')"><span><?=_PICKINGPOST?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('post_incoming_payment')" ><span><?=_POSTINCOMINGPAYMENT?></span></a></li>
				</ul>
				<?php } else {?>
				<ul class="dropdown">
					<li><a class="tables" href="#" onClick="sap_form('search_customers')"><span><?=_SEARCHCUSTOMERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('editcustomers')"><span><?=_EDITCUSTOMERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('search_sales_orders')"><span><?=_SEARCHSALESORDERS?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('create_sales_order')"><span><?=_CREATESALESORDER?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('create_delivery')" ><span><?=_CREATEDELIVERY?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_app('delivery_list','BAPI_DELIVERY_GETLIST')"><span><?=_DELIVERYLIST?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_app('billing_list','BAPI_BILLINGDOC_GETLIST')"><span><span><?=_BILLINGLIST?></span></a></li>
					<li><a class="tables" href="#" onClick="sap_form('sales_order_dashboard')"><span><?=_DASHBOARDSALES?></span></a></li>
					<li><a class="tables" href="#" ><span><?=_DASHBOARDINVOICED?></span></a></li>
				</ul>
				<?php }?>
			</li>
			<li><a class="list" href="javascript:void(0)" ><span><?=_PORCUREPAY?></span></a></li>
			<li><a class="list" href="javascript:void(0)" ><span><?=_FINANCECONTROLLING?></span></a>
			<?php if($extended=='on'){?>
			<ul class="dropdown">
				<li><a class="tables" href="#" onClick="sap_form('list_of_sales_orders_with_credit')" ><span><?=_LISTSALES?></span></a></li>
				<li><a class="tables" href="#" onClick="sap_form('sales_order_credit_release')" ><span><?=_SALESORDERCREDIT?></span></a></li>
			</ul>
			<?php }else{

			}?>
			</li>
			<li><a class="list" href="javascript:void(0)" ><span><?=_FORECASTSTOCK?></span></a></li>
			<li><a class="list" href="javascript:void(0)" ><span><?=_PRODUCTION?></span></a></li>
			<li><a class="list" href="javascript:void(0)" ><span>HR</span></a></li>
			<li><a class="list" href="javascript:void(0)" ><span>CRM</span></a></li>
		</ul>
	</div>
</div>