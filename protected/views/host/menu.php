<style>
.spans
{
width:16%; !important
}
</style>
<?php
	$usr_role 	= Yii::app()->user->getState("role");
	$company_id	= Yii::app()->user->getState("company_id");
	              
						$client 	= Controller::companyDbconnection();
						$doc    	= $client->getDoc($company_id);
						$RMA='';
						if($usr_role!='emg_retailer' && $usr_role!='emg_customer_service' && $usr_role!='emg_retailer_service')
						{
							$function=$doc->default_functions;
							isset($function->Returns_Portal)?$RMA=$function->Returns_Portal:$RMA='';
						}
						
?>

	<div class="sidebar spans">
		<div class="nav-collapse collapse" id="nav_tab" >
			<ul class="accordion level-1" >
			<li class="topli sales_dashbord active"><a href="host">Welcome</a></li>
				<?php
					if($company_id == "emgadmin")
					{
						if($usr_role == "Admin" || $usr_role == "Primary")
						{
							?>
							
							<li id="mnu_company" class="topli"><a href="#"><span>Company</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#list_company" id='list_company' onClick="sap_common_form('list_company')">List Company</a>
									</li>
									<li class="sales_dashbord">
										<a href="#create_company" id='create_company' onClick="sap_common_form('create_company')">Create Company</a>
									</li>
									<!--<li class="sales_dashbord">
										<a href="#delete_company" id='delete_company' onClick="sap_common_form('delete_company')">Delete Company</a>
									</li>-->
									<li class="sales_dashbord">
										<a href="#edit_company" id='edit_company' onClick="sap_common_form('edit_company')">Display / Edit Company</a>
									</li>
									<li class="sales_dashbord">
										<a href="#upload_logo" id='upload_logo' onClick="sap_common_form('upload_logo')">Upload Logo</a>
									</li>
								</ul>
							</li>
							<?php
						}
						?>
						<!--
						<li class="topli sales_dashbord">
							<a href="#quota" id='quota' onClick="sap_common_form('quota')">Quota</a>
						</li>
						<li class="topli sales_dashbord"><a href="#"><span>Usage Reports</span></a></li>
						-->
						<li class="topli sales_dashbord"><a href="#"><span>Audit Trails</span></a></li>
						<?php
						if($usr_role == "Admin" || $usr_role == "Primary")
						{
							?>
							<li >
								<a href="#"><span>Users</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_user" id='create_user' onClick="sap_common_form('create_user')">Create User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_user" id='delete_user' onClick="sap_common_form('delete_user')">Delete User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_user" id='edit_user' onClick="sap_common_form('edit_user')">Display / Edit User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#list_users" id='list_users' onClick="sap_common_form('list_users')">List Users</a>
									</li>
								</ul>
							</li>
							<?php
						}
					}
					elseif($company_id == "freetrial")
					{
						?>
						<li id = "sap_systems"><a href="#" id='sap_dit'><span>SAP Systems</span></a>
							<ul class="level-2">
								<li class="sales_dashbord" style="border-top-width:0px;">
									<a href="#" id='avl_sys_nav' onClick="shows('avl_sys')"><span>Available SAP Systems</span></a>
								</li>
								<li class="sales_dashbord">
									<a href="#" id='add_sys_nav' onClick="shows('add_sys')"><span>Add New SAP Systems</span></a>
								</li>
							</ul>
						</li>
						<?php
					}
					else
					{
						if(($usr_role == "Admin" || $usr_role == "Primary")  && $usr_role!='emg_retailer' && $usr_role!='emg_customer_service' && $usr_role!='emg_retailer_service' )
						{
							?>
							
							<li id = "sap_systems"><a href="#" id='sap_dit'><span>SAP Systems</span></a>
								<ul class="level-2">
									<li class="sales_dashbord" style="border-top-width:0px;">
										<a href="#" id='avl_sys_nav' onClick="shows('avl_sys')"><span>Available SAP Systems</span></a>
									</li>
									<li class="sales_dashbord">
										<a href="#" id='add_sys_nav' onClick="shows('add_sys')"><span>Add New SAP Systems</span></a>
									</li>
									<li class="sales_dashbord">
										<a href="#manage_report_links" id='manage_report_links' onClick="sap_common_form('manage_report_links')">Manage Report Links</a>
									</li>
								</ul>
							</li>
							<li class=" sales_dashbord">
								<a href="#company_features" id='company_features' onClick="sap_common_form('company_features')">Functions</a>
							</li>
							<li >
								<a href="#"><span>Roles</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_roles" id='create_roles' onClick="sap_common_form('create_roles')">Create Role</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_roles" id='delete_roles' onClick="sap_common_form('delete_roles')">Delete Role</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_roles" id='edit_roles' onClick="sap_common_form('edit_roles')">Display / Edit Role</a>
									</li>
								</ul>
							</li>
							<li >
								<a href="#"><span>Users</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_user" id='create_user' onClick="sap_common_form('create_user')">Create User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_user" id='delete_user' onClick="sap_common_form('delete_user')">Delete User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_user" id='edit_user' onClick="sap_common_form('edit_user')">Display / Edit User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#list_users" id='list_users' onClick="sap_common_form('list_users')">List Users</a>
									</li>
								</ul>
							</li>
							<?php 
							if($RMA<>'')
							{ ?>
								<li >
								<a href="#"><span class="user">Retailer Users</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_retailer_users" id='create_retailer_users' onClick="sap_common_form('create_retailer_users')">Create User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_retailer_users" id='delete_retailer_users' onClick="sap_common_form('delete_retailer_users')">Delete User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_retailer_users" id='edit_retailer_users' onClick="sap_common_form('edit_retailer_users')">Display / Edit User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#list_retailer_users" id='list_retailer_users' onClick="sap_common_form('list_retailer_users')">List Users</a>
									</li>
								</ul>
							</li>
							<li >
								<a href="#"><span class="user">Retailer Service Users</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_retailer_service_users" id='create_retailer_service_users' onClick="sap_common_form('create_retailer_service_users')">Create User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_retailer_service_users" id='delete_retailer_service_users' onClick="sap_common_form('delete_retailer_service_users')">Delete User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_retailer_service_users" id='edit_retailer_service_users' onClick="sap_common_form('edit_retailer_service_users')">Display / Edit User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#list_retailer_service_users" id='list_retailer_service_users' onClick="sap_common_form('list_retailer_service_users')">List Users</a>
									</li>
								</ul>
							</li>
							<li >
								<a href="#"><span class="user">Customer Service Users</span></a>
								<ul class="level-2">
									<li class="sales_dashbord">
										<a href="#create_customer_service_users" id='create_customer_service_users' onClick="sap_common_form('create_customer_service_users')">Create User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#delete_customer_service_users" id='delete_customer_service_users' onClick="sap_common_form('delete_customer_service_users')">Delete User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#edit_customer_service_users" id='edit_customer_service_users' onClick="sap_common_form('edit_customer_service_users')">Display / Edit User</a>
									</li>
									<li class="sales_dashbord">
										<a href="#list_customer_service_users" id='list_customer_service_users' onClick="sap_common_form('list_customer_service_users')">List Users</a>
									</li>
								</ul>
							</li>
							
							
							<?php }?>
							<li class="sales_dashbord">
										<a href="#upload_logo" id='upload_logo' onClick="sap_common_form('upload_logo')">Upload Logo</a>
									</li>
							<?php
						}
						elseif($usr_role=='emg_retailer' || $usr_role=='emg_customer_service' || $usr_role=='emg_retailer_service')
						{
							$role 		= Yii::app()->user->getState("role");
							$Company_ID	= Yii::app()->user->getState("company_id");
							$customize 	= $model;
							$client 	= Controller::couchDbconnection();
							$doc		= $client->getDoc('menus');
							$sd = json_encode($doc);
							$gs = json_decode($sd, true);
							$menu = $gs['dashboard'];
							
							$client 	= Controller::companyDbconnection();
							$doc		= $client->getDoc($Company_ID);
							$sd = json_encode($doc);
							$gs = json_decode($sd, true);
							$all_mnu = $gs['selected_functions'];
							
							$client 	= Controller::userDbconnection();
							$doc		= $client->getDoc(Yii::app()->user->getState("user_id"));
							$sd = json_encode($doc);
							$gs = json_decode($sd, true);
							$roles = $gs['selected_functions'];
							
							
							$i=0;
							foreach($roles as $key => $val)
							{
							if(isset($all_mnu[$key]))
							{
							if($i==0)
									echo '<li  class="topli">';
								else
									echo '<li>';
									//echo '<li>';
								echo '<a href="#">'.str_replace("_"," ",$key).'</a>';
								if(is_array($val))
								{
									echo '<ul class="level-2">';
									foreach($val as $key1 => $val1)
									{
									if($val1!='true')
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
												echo '<li><a href="#">'.$val1.'</a><ul class="level-3">';
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
									}
									echo '</ul>';
								}
								echo '</li>';
								$i++;
							
							}
							}
						}else
						{
							?>
							<li id = "sap_systems"><a href="#" id='sap_dit'><span>SAP Systems</span></a>
								<ul class="level-2">
									<li class="sales_dashbord" style="border-top-width:0px;">
										<a href="#" id='avl_sys_nav' onClick="shows('avl_sys')"><span>Available SAP Systems</span></a>
									</li>
								</ul>
							</li>
							<?php
						}
					}
				?>
			</ul>
		</div>
	</div>
