<ul id="column9">
	<?php
		$usr_role 	= Yii::app()->user->getState("role");
		$company_id	= Yii::app()->user->getState("company_id");
		
		foreach($center_positions as $pval => $divval)
		{
			$value = "";
			$bap='';
			try
			{
				$j = 0;
				$position = 1;
				// var_dump($hosts);
				foreach($hosts as $vau => $jw)
				{
					for($i = $count - 1; $i >= 0; $i--)
						$if[] = $i;
					
					$value = "";
					if($vau != 'none')
					{
						$client_user = NULL;
						// var_dump($jw);
						foreach($jw as $hs => $he)
						{
							if($hs == 'Host' || $hs == 'System_Number' || $hs == 'System_ID')
								$client_user.=$he . '/';
							
							if($hs != 'Password' && $hs!='Bapiversion')
								$value .= $he . ",";
							if($hs=='Bapiversion')
							{
							$bap=$he;
							}	
						}
						// echo $client_user;
						if(isset($doc->host_upload->$client_user))
						{
							$host_details 	= $doc->host_upload->$client_user;
							$h_client 		= $doc->host_upload->$client_user->client;
							$h_user 		= $doc->host_upload->$client_user->user;
							$h_login 		= $h_client . ',' . $h_user;
						}
						else
							$h_login = 'no_data';
						
						$bap=($bap==''?'v1':$bap);
						
						if($divval == $vau)
						{
							?>
							<li id='<?php echo $vau; ?>'>
								<div class="well" id='<?php echo $vau; ?>_del'>
									<?php
										if(($company_id != "freetrial" && ($usr_role == "Admin" || $usr_role == "Primary")) || ($company_id == "freetrial" && $client_user != '76.191.119.98/10/EC4/'))
										{
											?>
											<a class="close" onClick="delt('<?php echo $vau; ?>','<?php echo $if[$j]; ?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/trash_can.png" alt="Delete"></a>
											&nbsp;
											<a class="close" onClick="edit('<?php echo $vau; ?>','<?php echo $if[$j]; ?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/pencil.png" alt="Edit"></a>
											<?php
										}
										
										if($jw['System_type'] == 'BOBJ')
										{
											$sdd = 'no_data';
											if(isset($doc->bi_upload->$jw['System_URL']))
												$sdd = $doc->bi_upload->$jw['System_URL']->name;
											?>
                                            <strong onClick="systems_bi('<?php echo $vau; ?>','<?php echo $value; ?>','<?php echo $sdd; ?>')"><span class='Sys_typ'><?php echo $jw['System_type']; ?></strong>
											<strong onClick="systems_bi('<?php echo $vau; ?>','<?php echo $value; ?>','<?php echo $sdd; ?>')">
												<a href="#">
													<div class="sys_text"><?php echo $jw['Description']; ?></div><span id='<?php echo $vau; ?>_inv'></span>
												</a>
											</strong>
											<?php
										}
										else
										{
											?>
                                         <strong onClick="systems('bv=<?php echo $bap;?>&page=host&val=<?php echo $value; ?>','<?php echo $if[$j]; ?>','<?php echo $h_login; ?>')"><span class='Sys_typ'><?php echo $jw['System_type']; ?></span></strong>
										<strong  onClick="systems('bv=<?php echo $bap;?>&page=host&val=<?php echo $value; ?>','<?php echo $if[$j]; ?>','<?php echo $h_login; ?>')">
												<a href="#">
													<div class="sys_text"><?php echo $jw['Description']; ?></div><span id='<?php echo $if[$j]; ?>_inv'></span>
												</a>
											</strong>

											<?php
										}
									?>
								</div>
							</li>
							<?php
						}
						$j++;
						$position++;
					}
				}
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
	?>
</ul>