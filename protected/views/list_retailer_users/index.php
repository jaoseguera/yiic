<style>
.table th:nth-child(-n+6), .table td:nth-child(-n+6){

	display:table-cell;
	
	}
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$status_list = array("active" => "Active", "inactive" => "Inactive", "initial" => "Initial");
	$Company_ID	= Yii::app()->user->getState("company_id");
	$user	 	= Controller::userDbconnection();
	$comp	 	= Controller::companyDbconnection();
	$company=$comp->getDoc($Company_ID);
	$host_id=$company->host_id;
	$all_docs 	= $user->getAllDocs();
	$sd = json_encode($all_docs);
	$gs = json_decode($sd, true);
	$ur=array();
	$ur=explode('_',$_POST['url']);
	
	if($ur[1]=='retailer' && $ur[2]!='service')
		$rl='emg_retailer';
	elseif($ur[1]=='customer')
		$rl='emg_customer_service';
	elseif($ur[1]=='retailer' && $ur[2]=='service')
		$rl='emg_retailer_service';
	else	
		$rl='';
		
		
	/*$rl=explode('_',$_POST['url']);
	$rl=isset($rl[1])?$rl[1]:'';
	$rl=($rl=='retailer'?'emg_retailer':'emg_customer_service');
	*/
?>
<section id="formElement" class="utopia-form-box section" >
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">
				<fieldset>
					<div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th nowrap>Email</th>
										<th nowrap>First Name</th>
										<th nowrap>Last Name</th>
										<th nowrap>Company Name</th>
										<th nowrap>SoldTo ID</th>
										<th nowrap>System Name</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($gs['rows'] as $k => $v)
										{
											
											$usrdoc	= $user->getDoc($v['id']);
											if($usrdoc->company_id == $Company_ID && $usrdoc->profile->roles == "$rl")
											{
												$soldtoid=isset($usrdoc->soldtoid)?$usrdoc->soldtoid:'';
											        if (isset($usrdoc->system->host))
                                                                                                {
											                $hostname=$usrdoc->system->host;
											                $sts=isset($host_id->$hostname->Description)?$host_id->$hostname->Description:'';
                                                                                                }
											        else
                                                                                                        $sts='';
												$usr_email = '<a onclick="edit_retailer_users(\''.$v['id'].'\',\''.$rl.'\')" style="cursor: pointer;">'.$v['id'].'</a>';
												echo '
													<tr>
														<td>'.$usr_email.'</td>
														<td>'.$usrdoc->profile->fname.'</td>
														<td>'.$usrdoc->profile->lname.'</td>
														<td>'.$usrdoc->company_name.'</td>
														<td>'.$soldtoid.'</td>
														<td>'.$sts.'</td>
													</tr>
												';
											unset($usrdoc);
											}
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
    $(document).ready(function() { jQuery("#validation").validationEngine(); });
	function edit_retailer_users(cmp_id,role)
	{
		sessionStorage.setItem('edit_user_id', cmp_id);
		if(role=='emg_retailer')
			window.location.hash = 'edit_retailer_users';
		else if(role=='emg_retailer_service')
			window.location.hash = 'edit_retailer_service_users';
		else if(role=='emg_customer_service')
			window.location.hash = 'edit_customer_service_users';
		var page = window.location.hash;
		$(page).trigger('click');
	}
</script>
