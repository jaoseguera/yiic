<!--
	GEZG 07/26/2018
	Adding same style as list users view for displaying table correctly
-->
<style>
.table th:nth-child(-n+4), .table td:nth-child(-n+4){

	display:table-cell;
	
	}
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php
	$status_list = array("active" => "Active", "inactive" => "Inactive");
	$client 	= Controller::companyDbconnection();
	$all_docs 	= $client->getAllDocs();
	$sd = json_encode($all_docs);
	$gs = json_decode($sd, true);
?>

<section id="formElement" class="utopia-form-box section" >    
    <div class="row-fluid" >
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submitForm()" class="form-horizontal">				
				<fieldset>
					<div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<table class="table table-bordered iph" >
								<thead>
									<tr>
										<th nowrap>Company Id</th>
										<th nowrap>Company Name</th>
										<th nowrap>Primary Adimn</th>
										<th nowrap>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($gs['rows'] as $k => $v)
										{
											if($v['id'] != "emgadmin" && $v['id'] != "freetrial")
											{
												$cmpdoc	= $client->getDoc($v['id']);
												$sts = isset($cmpdoc->status) ? $status_list[$cmpdoc->status] : $status_list['active'];
												echo '
													<tr>
														<td><a onclick="edit_company(\''.$v['id'].'\')" style="cursor: pointer;">'.$v['id'].'</a></td>
														<td>'.$cmpdoc->name.'</td>
														<td>'.$cmpdoc->primary_user.'</td>
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
	function edit_company(cmp_id)
	{
		sessionStorage.setItem('edit_company_id', cmp_id);
		window.location.hash = 'edit_company';
		var page = window.location.hash;
		$(page).trigger('click');
	}
</script>