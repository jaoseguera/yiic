
<?php
	$table = $_REQUEST['table'];        // div id - that table will append to
	$tec_name = $_REQUEST['tec'];       // table_names(header column names)
	$t_id = $_REQUEST['t_id'];          // table id ie. example, exampl1, example2...
	$SalesOrder = $_SESSION[$table]; 
	   // Bapi values (records)
//	$row = count($SalesOrder);          // total number of rows(record count ie.200)
$this->renderPartial('tabletop'); 
	?>
    
                   <!--  <div style="height:35px; border:1px solid #cecece; border-top-left-radius:5px;border-top-right-radius:5px;">&nbsp;</div>  --> 
                        
	<table  class="table table-striped table-bordered" id="example">
    <thead>
    <tr>
    <?php
	foreach($SalesOrder[0] as $keys=>$val)
	{ ?>
		<th><div class="example_th"><?php echo $val;?></div></th>
	<?php }
	?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($SalesOrder as $kk=>$vv)
	{ 
	if($kk!=0)
	{
	?>
     <tr>
    <?php
	foreach($vv as $keys=>$val)
	{ ?>
		<td><?php echo $val;?></td>
	<?php }
	?>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
    <script>
		$(document).ready(function(e) 
	{
		var $disptablerow = $("#<?php echo $t_id; ?> tbody tr");
		var wids=$('.table').width()-20;
		if(wids<180)
		{
			wids=$('#out_put').width()-100;
		}
		$('.head_icons').css({ width:wids+'px' });
		var widss=$('#example40').width()-20;
		if(widss<180)
		{
			widss=$('#out_put').width()-100;
		}
		$('.example40').css({ 'width':widss+'px', 'z-index':'8000' });
		$('.search_int').keyup(function () 
		{
			sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
		});
	});
	</script>