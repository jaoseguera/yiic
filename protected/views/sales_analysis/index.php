<?php
$customize = $model;
if(isset($doc->sales_analysis))
{
	if(isset($doc->sales_analysis->link)){
	$link=$doc->sales_analysis->link;}
	else {
	$link=NULL; }
		
}
else
{
	$link=NULL;

}
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
	list-style-type:circle;
	padding:5px;
}
</style>
<div>
    <div>
        <section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
            <div class="row-fluid">
                <div class="utopia-widget-content contt">
                  <div class="span6">
                  <div class="span1"></div>
                  <div class="span11">
                  <ul class="ullink">
                  <?php if(trim($link)!=NULL) {?>
                  <li><a href='<?php echo $link;?>' target='_blank' class='report_link' id='link' onmousedown="mosds(event,this)">Link</a></li>
                  <?php } else {  ?>
                  <li><span class="no_link" id='link' onmousedown="mosd(event,this)">Link</span></li>
                  <?php } ?>
                  
                  
                  </ul>
                  </div>
                  </div>
                  <div class="span6">
                  <ul class="ullink">
                  
                
                  </ul>
                  </div>
               
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
	
}
function mosds(event,thiss) {
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
	
}
function addurl(id)
{
	$('.ccdiv').remove();
	jPrompturl('Please enter URL','','Please enter URL',function(r){
		if(r)
		{
			//alert(encodeURIComponent(r));
			$.ajax({
				type:'POST',
				data:'url='+encodeURIComponent(r)+'&id='+id,
				url:'sales_analysis/saveurl',
				success:function(data){
					//alert(data);
					var val=$('#'+id).html();
					$('#'+id).parent('li').html("<a href='"+data+"' target='_blank' class='report_link' id='customer_fact_sheet' onmousedown='mosds(event,this)'>"+val+"</a>");
				}
				});
		}
	});
}
</script>