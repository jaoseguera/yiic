<?php
	$customize = $model;
	$usr_role  = Yii::app()->user->getState("role");
	$sap_login = Yii::app()->user->getState('sap_login');
	$System_ID = $sap_login['SYSID'];
	$Client_ID = $sap_login['CLIENT'];
	$sales_reports = $doc->reports->$System_ID->$Client_ID->sales_reports;
	$all_reports = Controller::availableReports();
?>
<style>
.no_link
{
	color:#1499CB;
	cursor:pointer;
}
.report_link
{
	color:#1499CB;
	cursor:pointer;
}
.ullink li
{
	float: left;
    list-style-type: circle;
    margin-left: 8%;
    padding: 5px;
    width: 40.1709%;
}
</style>
<div>
    <div>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
			<div class="row-fluid">
				<div class="contt span12">
					<ul class="ullink">
						<?php
							foreach($all_reports['sales'] as $key => $val)
							{
								if(isset($sales_reports))
								{
									if(isset($sales_reports->$key) && !empty($sales_reports->$key))
										echo "<li><a href='".$sales_reports->$key."' target='_blank' class='report_link' id='".$key."' onmousedown='mosds(event,this)'>".$val."</a></li>";
									else
										echo "<li><span class='no_link' id='".$key."' onmousedown='mosd(event,this)'>".$val."</span></li>";
								}
								else
									echo "<li><span class='no_link' id='".$key."' onmousedown='mosd(event,this)'>".$val."</span></li>";
							}
						?>
					</ul>
				</div>
			</div>
        </section>
    </div><!-- Maincontent end -->
</div> <!-- end of container -->
<script>
$(document).ready(function(e) {
	$('.no_link').bind("contextmenu",function(e){ return false; });
	$('.report_link').bind("contextmenu",function(e){ return false; });
	$('.contt').bind("contextmenu",function(e){ return false; });
	$('.ccdiv').remove();
});
function mosd(event,thiss) {
	<?php if($usr_role != "Primary" && $usr_role != "Admin") { ?>
		return false;
	<?php } ?>
	var sd=$(thiss).attr('id');
	
	if(event.which==3||event.which==1)
	{
		//alert(event.pageY);
		$('.ccdiv').remove();
		var y=event.pageY;
		var x=event.pageX;
		$(thiss).after('<div style="border:1px solid #cecece;cursor:pointer;width:50px;padding:1px;background:#fff;position:absolute;top:'+y+'px;left: '+x+'px;" class="ccdiv" onClick="addurl(\''+sd+'\')">Add URL</div>');
	}
	else
	{
		//$('.ccdiv').remove();
	}
	return false;
}
function mosds(event,thiss) {
	<?php if($usr_role != "Primary" && $usr_role != "Admin") { ?>
		return false;
	<?php } ?>
	$('.ccdiv').remove();
	var sd=$(thiss).attr('id');
	if(event.which==3)
	{
		//alert(event.pageY);
		$('.ccdiv').remove();
		var y=event.pageY;
		var x=event.pageX;
		$(thiss).after('<div style="border:1px solid #cecece;cursor:pointer;width:50px;padding:1px;background:#fff;position:absolute;top:'+y+'px;left: '+x+'px;" class="ccdiv" onClick="addurl(\''+sd+'\')">Edit URL</div>');
	}
	else
	{
		//$('.ccdiv').remove();
	}
	return false;
}
function addurl(id) {
	$('.ccdiv').remove();
	var editval = $("#"+id).attr("href");
	jPrompturl('Please enter URL', editval,'Please enter URL',function(r){
		if(r)
		{
			//alert(encodeURIComponent(r));
			$.ajax({
				type:'POST',
				data:'url='+encodeURIComponent(r)+'&id='+id,
				url:'sales_reports/saveurl',
				success:function(data){
					//	alert(data);
					var val=$('#'+id).html();
					$('#'+id).parent('li').html("<a href='"+data+"' target='_blank' class='report_link' id='"+id+"' onmousedown='mosds(event,this)'>"+val+"</a>");
				}
			});
		}
	});
}
</script>