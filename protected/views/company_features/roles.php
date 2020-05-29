<style>
.disp-level-0 {
    margin: 0;
    text-indent: 10px;
	float: left;
	width: 45%;
}
.disp-level-0 > lh {
	font-size: 15px;
}
.disp-level-0 lh {
    line-height: 25px;
	font-weight: bold;
}
.disp-level-1 {
    text-indent: 50px;
}
.disp-level-1 > lh {
    color: #545454;
}
.disp-level-2 {
    text-indent: 90px;
}
.disp-level-0 input, .disp-level-1 input, .disp-level-2 input {
    margin-right: 10px;
	margin-top: -2px;
}
</style>
<?php
	$customize 	= $model;
	
	$Company_ID	= Yii::app()->user->getState("company_id");
	$client 	= Controller::companyDbconnection();
	if($Company_ID == "emgadmin")
		$doc		= $client->getDoc($_REQUEST['Company']);
	else
		$doc		= $client->getDoc($Company_ID);
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	if($Company_ID == "emgadmin")
		$roles = $gs['default_functions'];
	else
		$roles = $gs['selected_functions'];
	
	$all_menus = $gs['default_functions'];
	$client 	= Controller::couchDbconnection();
	$doc		= $client->getDoc('menus');
	$sd = json_encode($doc);
	$gs = json_decode($sd, true);
	unset($gs['_id']);
	unset($gs['_rev']);
	if($Company_ID == "emgadmin")
		$all_menus = $gs['dashboard'];
	$lvl0 = $lvl1 = $lvl2 = 0;
	
	foreach($all_menus as $key => $val)
	{
		if($Company_ID != "emgadmin")
			$val = $gs['dashboard'][$key];
		echo '<ul id="tree7" class="disp-level-0">';
		if(isset($val['href']))
		{
			if($val['title'] == "Welcome" && is_array($roles) && isset($roles[$val['title']]))
				$chk = "checked";
			else
				$chk = "";
			
			//echo '<lh><input '.$chk.' type="checkbox" name="level0[]" data-level="'.$lvl0.'" value="'.$lvl0.'~'.$key.'">'.$val['title'].'</lh>';
		}
		else
		{
			if(isset($roles[$key]))
				$chk = "checked";
			else
				$chk = "";
			
			echo '<lh><input '.$chk.' type="checkbox" name="level0[]" data-level="'.$lvl0.'" value="'.$lvl0.'~'.$key.'">'.$key.'</lh>';
			foreach($val as $key1 => $val1)
			{
				if(is_array($val1))
				{
					if(in_array($key1, $roles[$key]))
						$chk = "checked";
					else
						$chk = "";
					
					echo '<ul class="disp-level-1">';
					if(isset($val1['href']))
						echo '<lh><input '.$chk.' type="checkbox" name="level1[]" data-level="'.$lvl0.'_'.$lvl1.'" value="'.$lvl0.'~'.$lvl1.'~'.$key1.'">'.$val1['title'].'</lh>';
					else
					{
						echo '<lh><input '.$chk.' type="checkbox" name="level1[]" data-level="'.$lvl0.'_'.$lvl1.'" value="'.$lvl0.'~'.$lvl1.'~'.$key1.'">'.$key1.'</lh>';
						echo '<ul class="disp-level-2">';
						$lvl2 = 0;
						foreach($val1 as $key2 => $val2)
						{
							if(in_array($key2, $roles[$key][$key1]))
								$chk = "checked";
							else
								$chk = "";
							
							echo '<li><input '.$chk.' type="checkbox" name="level2[]" data-level="'.$lvl0.'_'.$lvl1.'" value="'.$lvl0.'~'.$lvl1.'~'.$lvl2.'~'.$key2.'">'.$val2['title'].'</li>';
							$lvl2++;
						}
						echo '</ul>';
					}
					echo '</ul>';
				}
				$lvl1++;
			}
		}
		echo '</ul>';
		$lvl0++;
	}
?>
<script type="text/javascript">
    $(document).ready(function() {
		$("[name='level0[]']").change(function() {
			var lvl0 = $(this).attr("data-level");
			var lvl0_chk = $(this).is(":checked");
			$("[name='level1[]']").each(function() {
				var lvl1_val = $(this).val();
				var lvl1_arr = lvl1_val.split("~");
				lvl1 = lvl1_arr[1];
				if(lvl0 == lvl1_arr[0])
				{
					if(lvl0_chk)
						$(this).prop('checked', true);
					else
						$(this).prop('checked', false);
				}
				
				var lvl1_chk = $(this).is(":checked");
				$("[name='level2[]']").each(function() {
					var lvl2_val = $(this).attr("data-level");
					var lvl2_arr = lvl2_val.split("_");
					var lvl2 = lvl2_arr[2];
					if(lvl0 == lvl2_arr[0] && lvl1 == lvl2_arr[1])
					{
						if(lvl1_chk)
							$(this).prop('checked', true);
						else
							$(this).prop('checked', false);
					}
				});
			});
		});
		$("[name='level1[]']").change(function() {
			var lvl1_val = $(this).attr("data-level");
			var lvl1_arr = lvl1_val.split("_");
			var lvl1 = lvl1_arr[1];
			var lvl0_chk = $(this).is(":checked");
			$("[name='level2[]']").each(function() {
				var lvl2_val = $(this).attr("data-level");
				var lvl2_arr = lvl2_val.split("_");
				var lvl2 = lvl2_arr[2];
				if(lvl1 == lvl2_arr[1])
					if(lvl0_chk)
						$(this).prop('checked', true);
					else
						$(this).prop('checked', false);
			});
		});
	});
</script>