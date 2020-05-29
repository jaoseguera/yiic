<?php
	$host  = json_encode($doc->host_id);
	$hosts = json_decode($host,true);
	$count = count($hosts);
	if($count==1)
	{ 
		?>
		<script>
		$(document).ready(function()
		{
			// $('.host_list').css({'background-image':'none',width:'40px'});
			/*$('.host_list').css({'background-image':'none'});
			$('.d_host_list').remove();
			$('.host_list').attr('id','none');
			$('.host_list').click(function() {
				$(this).removeClass('user-active-host');
			});*/
		});
		</script>
		<?php
	}
	$j=0;
	foreach($hosts as $vau=>$jw)
	{
		for($i=$count-1;$i>=0;$i--)
		{
			$if[]=$i;
		}
		$value="";
		$bap='';
		if($vau!='none')
		{
			$client_user=NULL;
			foreach($jw as $hs=>$he)
			{
				if($hs=='Host'||$hs=='System_Number'||$hs=='System_ID')
				{
					$client_user.=$he.'/';
				}
				if($hs!='Password' && $hs!='Bapiversion')
				{
					$value.=$he.",";
				}
				if($hs=='Bapiversion')
				{
				$bap=$he;
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
			//if($jw['Description'] != Yii::app()->user->getState("DEC"))
			//{
			$bap=($bap==''?'v1':$bap);
			
				if($client_user=='76.191.119.98/10/EC4/')
				{ 
					?><div onClick="systems('bv=<?php echo $bap;?>&page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')" class='sap_host'>
					<a href="#" ><table ><tr><td ><div class="sys_len">
					<?php echo $jw['Description'];?> </div></td><td><span id='<?php echo $if[$j];?>_inv'></span></td><td><span class='Sys_typs'>ECC</span></td></tr></table>
					</a></div><?php
				}
				else
				{
					if($jw['System_type']=='ECC')
					{
						?><div onClick="systems('bv=<?php echo $bap;?>&page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')" class='sap_host'>
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
		//}
	}
?>