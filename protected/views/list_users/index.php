<style>
.table th:nth-child(-n+4), .table td:nth-child(-n+4){

	display:table-cell;
	
	}
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$status_list = array("active" => "Active", "inactive" => "Inactive", "initial" => "Initial");
	$Company_ID	= Yii::app()->user->getState("company_id");
	$user	 	= Controller::userDbconnection();
	$all_docs 	= $user->getAllDocs();
	$sd = json_encode($all_docs);
	$gs = json_decode($sd, true);
	$cmp=Controller::companyDbconnection();
	$cmpdoc=$cmp->getDoc($Company_ID);
	$roles=array();
	foreach($cmpdoc->roles as $key=>$val)
	{
	array_push($roles,$key);
	}
	array_push($roles,'Admin');
	
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
										<th nowrap>Name</th>
										<th nowrap>Email</th>
										<th nowrap>Role</th>
										<th nowrap>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($gs['rows'] as $k => $v)
										{
											$usrdoc	= $user->getDoc($v['id']);
											if($usrdoc->company_id == $Company_ID && (in_array($usrdoc->profile->roles, $roles) ))
											{
												$sts = isset($usrdoc->status) ? $status_list[$usrdoc->status] : $status_list['active'];
												$usr_email = '<a onclick="edit_user(\''.$v['id'].'\')" style="cursor: pointer;">'.$v['id'].'</a>';
												echo '
													<tr>
														<td>'.$usrdoc->profile->fname.' '.$usrdoc->profile->lname.'</td>
														<td>'.$usr_email.'</td>
														<td>'.$usrdoc->profile->roles.'</td>
														<td>'.$sts.'</td>
													</tr>
												';
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
	function edit_user(cmp_id)
	{
		sessionStorage.setItem('edit_user_id', cmp_id);
		window.location.hash = 'edit_user';
		var page = window.location.hash;
		$(page).trigger('click');
	}
</script>