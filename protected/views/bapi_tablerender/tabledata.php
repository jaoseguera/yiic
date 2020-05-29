
<?php
	$table = $_REQUEST['table'];        // div id - that table will append to
	$tec_name = $_REQUEST['tec'];       // table_names(header column names)
	$t_id = $_REQUEST['t_id'];          // table id ie. example, exampl1, example2...
	$SalesOrder = $_SESSION[$table];    // Bapi values (records)
	$row = count($SalesOrder);          // total number of rows(record count ie.200) 
	$t_h_c=$_SESSION[$table.'_count'];
	if(isset($_SESSION['tbl_count']) && $_SESSION['tbl_count']!=0)
	{
		$t_h_c=$_SESSION['tbl_count'];
		$_SESSION['tbl_count']=0;
	}	
	$_SESSION['t_rows']=$t_h_c;
	if($t_h_c>0)
	{
	echo '<style> .table th:nth-child(-n+'.$t_h_c.'), .table td:nth-child(-n+'.$t_h_c.'){
	display:table-cell;
	}</style>';
	}
	else
	{
	echo '<style> .table th:nth-child(-n+10), .table td:nth-child(-n+10){
	display:table-cell;
	}</style>';
	}
	/*echo '<style> .table th:nth-child(-n+150), .table td:nth-child(-n+150){
	display:table-cell;
	}</style>';*/
	if(isset($_SESSION['combine']))
		$combine = $_SESSION['combine'];
	$tool = $_REQUEST['tool'];           // screen width & funtion names ie. show_menu,show_dilv,..
	$tools = explode("@", $tool);
	$theaders  = Controller::technical_names($tec_name);
	//GEZG 06/20/2018 Adding extra param NULL. with PHP7 chrashes without it
	$t_headers = Controller::technicalNames($tec_name,null);
	
		if(count($theaders)>=5)	
			$rows = '1,2,3,4,5,';
		elseif(count($theaders)==4)
			$rows = '1,2,3,4,';
		elseif(count($theaders)==3)
			$rows = '1,2,3,';
		elseif(count($theaders)==2)
			$rows = '1,2,';
		else
			$rows=count($theaders);
	
	$split_rows = explode(",", $rows);
	
	for($i = 0; $i < count($split_rows) - 1; $i++) {
		$split_rows[$i] = $i + 1;
	}
	
	// var_dump($SalesOrder); exit;
	// $t_headers = $model->technical_names($tec_name);
	
	
	$customize = $model;
	if($_REQUEST['table_name'] == 'Sales_orders')
		$this->renderPartial('editcustomerspage', array('customize' => $customize));
	if($_REQUEST['table_name'] == 'Sales_order_dashboard')
		$this->renderPartial('sales_order_dashboard_graph', array('customize' => $customize));
	
	if($_REQUEST['key'] == 'search_vendors')
	{
		foreach($SalesOrder[1] as $k => $v)
		{
			$pos = strpos($theaders[$k], "-");
			if($pos !== false)
				$t[$k] = substr($theaders[$k], 0, $pos);
			else
				$t[$k] = $theaders[$k];
		}
		$theaders = array();
		$theaders = $t;
		
		// print_r($SalesOrder[1]);
		// echo "<br />";
		// print_r($theaders);
	}
	// print_r($SalesOrder[1]);
	
	if($SalesOrder != NULL)
	{
		if(isset($_REQUEST['kiu']))
		{
		
			$gf = $_REQUEST['kiu'];
			$dsd = 0;
		}
		else
		{
			
			$dsd = 0;
			$gf = $row;
		}
		if($gf >= $row)
		{
			
			$gf = $row;
			$dsd = 0;
		}
		
		?>
		<input type="hidden" id="tableordersaveUrl" value="<?php echo Yii::app()->createAbsoluteUrl("common/tableorder") ?>" />
		<input type="hidden" id="<?php echo $t_id . '_row'; ?>" value="<?php echo $row; ?>" />

	<table class="table table-striped table-bordered" id="<?php echo $t_id; ?>" alt="<?php echo $_REQUEST['table_name']; ?>">
		<?php
			$col = 0;
			
			for($i = 1; $i <= $gf; $i++)
			{
				$SalesOrders = $SalesOrder[$i];
				/*if(isset($SalesOrders['NET_VAL_HD']))
					unset($SalesOrders['NET_VAL_HD']);*/
				
				$cut = count($SalesOrders);
				if($i == 1)
				{
				?>
					<thead>
						<tr>
						<?php
							$th = 1;
							foreach($SalesOrders as $keys => $vales)
							{
								if($th<=$t_h_c)
									$style = "";
								else
									$style = "style='display:none;'";
								?>
									<th id="<?php echo $th; ?>" onclick="rowShort('<?php echo $keys; ?>',this,'<?php echo $tec_name; ?>','<?php echo $_REQUEST['table']; ?>')">
										<div class="<?php echo $t_id; ?>_<?php echo $keys; ?> cutz" alt='<?php echo "table" . $theaders[$keys]; ?>'><span class="ddrg dragtable-drag-handle">&nbsp;</span><span class="notdraggable truncated" alt="<?php echo "table" . $theaders[$keys]; ?>" title="<?php echo $theaders[$keys]; ?>"><?php echo Controller::customize_label("table" . $theaders[$keys], ''); ?></span></div>
										<div class="<?php echo $t_id; ?>_th <?php echo $t_id; ?>_<?php echo $keys; ?>_hid" style="display:none;" name="<?php echo $keys; ?>"><?php echo $theaders[$keys]; ?></div>
										<div class="<?php echo $t_id; ?>_tech" style="display:none;"><?php echo $keys . "@" . $theaders[$keys]; ?></div>
									</th>
								<?php
								$th++;
							}
							
							if($tec_name == "ZBAPI_SLS_LIST_ORDERS_OUT" || $tec_name == "/KYK/S_POWL_BILLDUE")
							{
								?><th style="display:none;">check</th><?php
							}
						?>
						</tr>
						<tr style="display:none;" class="<?php echo $t_id; ?>_filter">
						<?php
							$th = 1;
							foreach($SalesOrders as $keys => $vales)
							{
								if($th<=$t_h_c)
									$style = "";
								else
									$style = "style='display:none;'";
								?>
									<th><input type="text"  class="search_int" value="" alt='<?php echo $keys; ?>' name="<?php echo $table . '@' . $t_id; ?>"></th>
								<?php
								$th++;
							}
							
							if($tec_name == "ZBAPI_SLS_LIST_ORDERS_OUT" || $tec_name == "/KYK/S_POWL_BILLDUE")
							{
								?><th style="display:none;">check</th><?php
							}
						?>
						</tr>
					</thead>
					<tbody id='<?php echo $t_id; ?>_tbody'>
				<?php
				}
				
				if($tec_name == "ZBAPI_SLS_LIST_ORDERS_OUT" || $tec_name == "/KYK/S_POWL_BILLDUE")
				{
					foreach ($SalesOrder[$i] as $keys => $vales)
					{
						$art23[$i][] = '[' . $keys . ']' . $vales;
					}
					$array23[$i] = implode($art23[$i], " ");
				}
				
				$this->renderPartial('/bapi_tablerender/tablebody', array('SalesOrders' => $SalesOrders, 'split_rows' => $split_rows, 't_headers' => $t_headers, 't_id' => $t_id, 'tec_name' => $tec_name, 'table_name' => $_REQUEST['table_name'], 'array23' => $array23, 'i' => $i,'table_div'=>$_REQUEST['table'],'t_h_c'=>$t_h_c));
			}
			if($i == $gf)
				?></tbody><?php
		?>
		</table>
		<div id='<?php echo $t_id; ?>_table' style="display:none;">
		<?php
			$SalesOrder = Controller::dateValueFormat($t_headers, $SalesOrder);
			echo json_encode($SalesOrder);
		?>
		</div>
		
		<script>
			$(document).ready(function(e) 
			{
				$(".head_icons span").removeClass("table_top_hide");
			});
		</script>
		<?php
	}
	else
	{
		echo _NORECORDS;
		?>
		<script>
			$(document).ready(function(e) 
			{
				$(".head_icons span").addClass("table_top_hide");
			});
		</script>
		<?php
	}
?>
<script>
	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g,"");
	}
	
	String.prototype.ltrim = function() {
		return this.replace(/^\s+/,"");
	}
	
	String.prototype.rtrim = function() {
		return this.replace(/\s+$/,"");
	}
	
	$(document).ready(function(e) 
	{
		var $disptablerow = $("#<?php echo $t_id; ?> tbody tr");
		var wids=$('.table').width();
		if(wids<180)
		{
			wids=$('#out_put').width()-100;
		}

		$('.head_icons').css({ width:wids+'px'});
		var widss=$('#example40').width()-20;
		if(widss<180)
		{
			widss=$('#out_put').width()-100;
		}
		$('.example40').css({ 'width':widss+'px'});
		$('.search_int').keyup(function () 
		{
			sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
		});
	});
	
	function rowShort(Column,thiss,tech,table)
	{
		$('#srch_show_more').remove();
		var smid=$(thiss).attr('id');
		var tableid=$(thiss).parent('tr').parent('thead').parent('table').attr('id');
		
		//GEZG 07/12/2018
		//Fixing autosum problem
		//$('#'+tableid).parent('div').parent('div').parent('div').find('.head_icons').find('#sumr').attr("onclick","ssum('"+Column+"','"+tableid+"','"+smid+"')");
		$('#'+tableid).parents(".edge").find('.head_icons').find('#sumr').attr("onclick","ssum('"+Column+"','"+tableid+"','"+smid+"')");

		
		if(thiss=='L')
		{
			var sor='no-sort';
			var table_id = Column;
		}
		else
		{
			var sor=$(thiss).attr('class');
			var table_id=$(thiss).closest('table').attr('id');
			if(sor=='sorting')
			{
				$('#'+table_id+' thead tr:first-child th').removeClass('sorting_asc').removeClass('sorting_desc').addClass('sorting');
				$(thiss).removeClass('sorting').addClass('sorting_desc');
				var sor=$(thiss).attr('class');
			}
			if(sor=='sorting_desc')
			{
				$(thiss).removeClass('sorting_desc').addClass('sorting_asc');
				var sor=$(thiss).attr('class');
			}
			else
			{
				$(thiss).removeClass('sorting_asc').addClass('sorting_desc');
				var sor=$(thiss).attr('class');
			}
		}
		
		var t_rows = $('#'+table_id+'_num').html();
		var datas  = "column="+Column+"&sor="+sor+"&tech="+tech+"&table="+table+"&table_id="+table_id+"&t_rows="+t_rows;
		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->createAbsoluteUrl("common/tablesort"); ?>",
			data: datas,
			success: function(html)
			{
				$('#'+table_id+'_tbody').html(html);
				set_Columns(table_id);
					
			}
		});
	}
			
function set_Columns(table)
{
    $('#block-ui').hide();
    var back_to_visible = $("#back_to").is(':visible');
	if(back_to_visible)
		sort_main_div = "#out_table";
	else
		sort_main_div = "#out_put";
	
	hleng=$('#noh').html();
  
			
     if($('body').width()>100)
    { 
        				
        var inr = 0;
        var head_pos = '';
        			
        $(sort_main_div).find('.cells1').each(function() 
        {				
			if(inr==0)
			{
			$(sort_main_div).find('#'+table+' th, #'+table+' tbody td').css({
            display:'none'
			});
			}
            inr=inr+1;
            if($(this).hasClass('table_sel1'))
            {
                var sde=$(this).attr('id').split('_');
              
                    if(inr >=hleng+1){}else{
                        $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                            display:'table-cell',
                            width:'20%'
                        });	
                    }					
                //}
                head_pos +=inr+',';
            }
        });
    }
	}
</script>
<?php
if($gf >= $row)
		{ ?>
			
			<script>
		$(document).ready(function(e) 
		{
			
			$('.testr').hide();		
		});
		</script>
		<?php }
		else
		{ ?>
			<script>
		$(document).ready(function(e) 
		{
			
			$('.testr').show();		
		});
		</script>
		<?php }
		?>