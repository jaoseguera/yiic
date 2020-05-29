<div class="row-fluid">
	<div class="span12" id='heder_position'>
		<div class="header-top">
			<div class="header-wrapper">
				<a href="dashboard" class="sapin-logo"><img src="../images/thinui-logo-125x50.png"/></a>
				<!--<div class="user-panel header-divider body_con" style="border:none;width:59%"></div>-->
				<div class="header-right">
					<div class="header-divider"> 
						<div class="navbar sidebar-toggle">
							<div class="container" style="margin-top:-10px;">
								<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</a>
							</div>
						</div>
					</div>
					<div class="search-panel header-divider">
						<div class="search-box">
							<img src="../images/icons/zoom.png" alt="Search">
							<form action="" method="post">
								<input type="text" name="search" placeholder="search"/>
							</form>
						</div>
					</div>

					<div class="header-divider mobile_lite" >
						<img src="../images/save-icone.png" onclick="save_customize()" class="save_customize body_con b_odd" title='Save Customize' style="margin-left:7px;">
						<div class="user_list" >
							<img src="../images/edit-icon.png" onclick="customize()" class="edit_customize  b_odd" title='Customize'>
						</div>
					</div>
					<!-- hist---->
					<div class="header-divider mobile_lite" >
						<div class="user_list" id='his_u'>
							<a href="#" tip='History' class='red b_od'><img src="../images/history.png" alt=""></a>
						</div>  

						<div class="user-dropbox body_con" id='d_his_u'>
							<ul id="hist" style="margin:0px;"></ul>
						</div>
					</div>
					<!---- fav
					<div class="header-divider" id='header-divider'>---->
					<div class="header-divider">
						<div class="user_list" id='favt'>
							<a href="#" tip='Favorite' class='red b_od'><img src="../images/favt.png" alt=""></a>
						</div>
						<div class="user-dropbox body_con" id='d_favt'></div>
					</div>
					<!------------------host------------------------->
					<div class="header-divider mobile_lite">
						<div class="host_list" id='host_list'>
							<a href="#"><div class="sys_len"><?php echo Yii::app()->user->getState("DEC");?></div></a>
						</div>
						<div class="d_host_list" id='d_host_list'><?php
						$host=json_encode($doc->host_id);
						$hosts=json_decode($host,true);
						$count=count($hosts);
						if($count==1)
						{ 
							?><script>
							$(document).ready(function()
							{
								// $('.host_list').css({'background-image':'none',width:'40px'});
								$('.host_list').css({'background-image':'none'});
								$('.d_host_list').remove();
								$('.host_list').attr('id','none');
								$('.host_list').click(function() {
									$(this).removeClass('user-active-host');
								});
							});
							</script><?php 
						}
						$j=0;
						foreach($hosts as $vau=>$jw)
						{
							for($i=$count-1;$i>=0;$i--)
							{
								$if[]=$i;
							}
							$value="";
							if($vau!='none')
							{
								$client_user=NULL;
								foreach($jw as $hs=>$he)
								{
									if($hs=='Host'||$hs=='System_Number'||$hs=='System_ID')
									{
										$client_user.=$he.'/';
									}
									if($hs!='Password')
									{
										$value.=$he.",";
									}
								}
								if(isset($doc->host_upload->$client_user))
								{
									$host_details = $doc->host_upload->$client_user;
									$h_client=$doc->host_upload->$client_user->client;
									$h_user= $doc->host_upload->$client_user->user;
									$h_login=$h_client.','.$h_user;
								}
								else
								{
									$h_login='no_data';
								}
								if($jw['Description'] != Yii::app()->user->getState("DEC"))
								{
									if($client_user=='76.191.119.98/10/EC4/')
									{ 
										?><div onClick="systems('page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')" class='sap_host'>
										<a href="#" ><table ><tr><td ><div class="sys_len">
										<?php echo $jw['Description'];?> </div></td><td><span id='<?php echo $if[$j];?>_inv'></span></td><td><span class='Sys_typs'>ECC</span></td></tr></table>
										</a></div><?php
									}
									else
									{ 
										if($jw['System_type']=='ECC')
										{
											?><div onClick="systems('page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')" class='sap_host'>
											<a href="#" ><table ><tr><td ><div class="sys_len">
											<?php echo $jw['Description'];?></div></td><td><span id='<?php echo $if[$j];?>_inv'></span></td><td><span class='Sys_typs'><?php echo $jw['System_type'];?></span></td></tr></table>
											</a></div><?php 
										}
										else 
										{ 
											$sdd='no_data';
											if(isset($doc->bi_upload->$jw['System_URL']))
											{
												$sdd=$doc->bi_upload->$jw['System_URL']->name;
											}
											?><div onClick="systems_bi('<?php echo $vau;?>','<?php echo $value;?>','<?php echo $sdd;?>')" class='sap_host'>
											<a href="#" ><table><tr><td><div class="sys_len">
											<?php echo $jw['Description'];?></div></td><td><span id='<?php echo $vau;?>_inv'></span></td><td><span class='Sys_typs'><?php echo $jw['System_type'];?></span></td></tr></table>
											</a></div><?php 
										}
									}
								}
								$j++;
							}
						}
						?></div>
					</div>
					<!------------------------------------------->
					<div class="user-panel header-divider">
						<div class="user-info" id='admin_u'>
							<img src="../images/icons/user.png" alt="" class='usr_ic'>
							<a href="#"><?php echo Yii::app()->user->getState("userName"); ?></a>
						</div>

						<div class="user-dropbox" id='d_admin_u'>
							<ul>
								<li class="theme-changer white-theme body_con"><a href="#" onClick='help_t()'>Help</a></li>
								<li class="user body_con" ><a href="#" id='profile' onClick="sap_form('profile')">Profile</a></li>
								<li class="settings body_con"><a href="host" >Systems</a></li>
								<li class="logout"><a href="#" onClick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl("login/logout"); ?>'">Logout</a></li>
							</ul>
						</div>
					</div>
				</div><!-- End header right -->
			</div><!-- End header wrapper -->
		</div><!-- End header -->
	</div>
</div>
<!-- Header ends -->