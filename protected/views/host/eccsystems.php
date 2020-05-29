<?php
if(isset($_POST))
{
    $userid = Yii::app()->user->getState("user_id");                
    $hst['Description']    = $_REQUEST['description'];
    $hst['Host']           = $_REQUEST['host'];
    $hst['routing_string'] = $_REQUEST['routing_string'];
    $hst['router_port']    = $_REQUEST['router_Port'];
    $hst['System_num']     = $_REQUEST['sys_num'];
    $hst['System_id']      = $_REQUEST['sys_id'];
    $hst['Lang']           = $_REQUEST['lang'];
    $hst['Extension']      = $_REQUEST['extension'];

    $client = new couchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['password']);
    $doc    = $client->getDoc($userid);
    $host   = json_encode($doc->host_id);
    $hosts  = json_decode($host,true);

    if(isset($doc->paypal)) { $host_count=1; } else { $host_count=1; }

    if($host_count>6) { echo 'paypal'; }
    else
    {
        $ho=$doc->host_id;                    
        $host=json_encode($doc->host_id);
        $hosts=json_decode($host,true);

        foreach($hosts as $sd=>$hd)
        {
            if(strtoupper($hd['Description'])==strtoupper($hst['Description'])) { echo "NOSYSTEM"; exit; }
            $sy = explode("_",$sd);
        }
        if(isset($sy[1])) { $ty=$sy[1];  $cd=$ty+1; } else {  $cd=1; }
        $num = $cd;
        $cd  = 'host_'.$cd;
        echo $dis = $cd."@";
        $ho->$cd  = array('Description'=>$hst['Description'],'Host'=>$hst['Host'],'Router_String'=>$hst['routing_string'],'Router_Port'=>$hst['router_port'],'System_Number'=>$hst['System_num'],'System_ID'=>$hst['System_id'],'Language'=>$hst['Lang'],'Extension'=>$_REQUEST['extension'],'System_type'=>'ECC');
        if(isset($doc->host_position)) { $doc->host_position->$cd=$cd; }
        $client->storeDoc($doc);

        if(isset($doc->host_position))
        {
            $center_position=json_encode($doc->host_position);
            $center_positions=json_decode($center_position,true); 
        }
        else
        {
            $host=json_encode($doc->host_id);
            $hosts=json_decode($host,true);
            $count=count($hosts);
            for($i=1;$i<=$count;$i++) { $center_positions[]='host_'.$i; }
        }
        ?><ul id="column9"><?php 
        foreach($center_positions as $pval=>$divval)
        {
            $value = "";
            $client = new couchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['password']);                        
            try 
            {
                $doc   = $client->getDoc($userid);
                $host  = json_encode($doc->host_id);
                $hosts = json_decode($host,true);
                $count = count($hosts);
                $j     = 0;

                foreach($hosts as $vau=>$jw)
                {
                    for($i=$count-1;$i>=0;$i--) { $if[]=$i; }
                    $value="";
                    if($vau!='none')
                    {
                        $client_user=NULL;
                        foreach($jw as $hs=>$he)
                        {
                            if($hs=='Host'||$hs=='System_Number'||$hs=='System_ID') { $client_user.=$he.'/'; }
                            if($hs!='Password') { $value.=$he.","; }        
                        }
                        if(isset($doc->host_upload->$client_user))
                        {
                            $host_details = $doc->host_upload->$client_user;
                            $h_client     = $doc->host_upload->$client_user->client;
                            $h_user       = $doc->host_upload->$client_user->user;
                            $h_login      = $h_client.','.$h_user;
                        }
                        else { $h_login='no_data'; }
                        if($client_user=='76.191.119.98/10/EC4/')
                        {
                            if($divval == $vau)
                            {
                                ?><li id='<?php echo $vau;?>'>
                                    <div class="well" id='<?php echo $vau;?>_del'>
                                        <!-- <a class="close" onClick="delt('<?php echo $vau;?>','<?php echo $if[$j];?>')"><img src="../img/icons/trash_can.png" alt="Delete"></a>&nbsp;
                                        <a class="close" onClick="edit('<?php echo $vau;?>','<?php echo $if[$j];?>')"><img src="../img/icons/pencil.png" alt="Edit"></a> ---> 

                                        <strong onClick="systems('page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')">
                                        <a href="#" ><?php echo $jw['Description'];?>: <?=_DEMOSYSTEM?>  &nbsp;&nbsp;&nbsp;<span class='Sys_typ' style='margin-right:55px;'>ECC</span><span id='<?php echo $if[$j];?>_inv'></span></a></strong>
                                    </div>
                                </li><?php
                            }
                        }
                        else
                        { 
                            if($divval == $vau)
                            {
                                ?><li id='<?php echo $vau;?>'>
                                    <div class="well" id='<?php echo $vau;?>_del'>
                                        <a class="close ip_cls" onClick="delt('<?php echo $vau;?>','<?php echo $if[$j];?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/trash_can.png" alt="Delete"></a>&nbsp;
                                        <a class="close ip_cls" onClick="edit('<?php echo $vau;?>','<?php echo $if[$j];?>')"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/pencil.png" alt="Edit"></a><?php
                                        if($jw['System_type']=='ECC') 
                                        {
                                            ?><strong onClick="systems('page=host&val=<?php echo $value;?>','<?php echo $if[$j];?>','<?php echo $h_login;?>')">
                                            <a href="#" ><?php echo $jw['Description'];?>&nbsp;&nbsp;&nbsp;<span class='Sys_typ'><?php echo $jw['System_type'];?></span><span id='<?php echo $if[$j];?>_inv'></span></a></strong><?php
                                        } 
                                        else 
                                        {
                                            $sdd='no_data';
                                            if(isset($doc->bi_upload->$jw['System_URL']))
                                            {
                                                    $sdd=$doc->bi_upload->$jw['System_URL']->name;
                                            }
                                            ?><strong onClick="systems_bi('<?php echo $vau;?>','<?php echo $value;?>','<?php echo $sdd;?>')">
                                            <a href="#" ><?php echo $jw['Description'];?>&nbsp;&nbsp;&nbsp;<span class='Sys_typ'><?php echo $jw['System_type'];?></span><span id='<?php echo $vau;?>_inv'></span></a></strong><?php
                                        } 
                                    ?></div>
                                </li><?php 
                            }
                        }
                        $j++;
                    }
                }
            }
            catch (Exception $e)  { echo $e->getMessage();  }
        }
        echo "@";
        $j=0;
        foreach($hosts as $vau=>$jw)
        {
            if($vau==$cd)
            {
                for($i=$count-1;$i>=0;$i--) {  $if[]=$i; }
                $value="";

                if($vau!='none')
                {
                    foreach($jw as $hs=>$he) {  $value.=$he.",";   }
                    ?><section class="utopia-widget utopia-form-box section edit_sys" style="display:none;" id="<?php echo $vau;?>_edit">
                    <div class="utopia-widget-title"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/window.png" class="utopia-widget-icon">
                        <span>Edit <?php echo $jw['Description'];?> Details</span>
                    </div>

                    <div class="utopia-widget-content" style="background:#fff;">
                        <form  id="form<?php echo $vau?>" action="javascript:ajax_edit('<?php echo $vau?>','<?php echo $if[$j];?>')" class="validation form-horizontal" ><?php 
                            foreach($jw as $hs=>$he)
                            { 
                                if($hs!='System_type')
                                {
                                    $titles=array('Description'=>'Description','Host'=>'Application Server','Router_String'=>'Router IP / Address','Router_Port'=>'Router Port','System_Number'=>'Instance Number','System_ID'=>'System ID','Language'=>'Language','Extension'=>'Extension','System_URL'=>'System URL','CMS_Name'=>'CMS Name','CMS_Port'=>'CMS Port','Auth_Type'=>'Auth Type');
                                    $title=$titles[$hs];
                                    if($hs!='Password' && $hs!='Extension' && $hs!='Routing_String')
                                    {
                                        ?><div class="control-group">
                                            <label class="control-label" for="input01"><?php echo $title;?><span> *</span>:</label>
                                            <div class="controls">
                                                <input type="text" value="<?php echo $he;?>" class="input-fluid validate[required] span3" id="<?php echo $hs.$if[$j];?>">
                                            </div>
                                        </div><?php 
                                    }
                                    if($hs=='Routing_String')
                                    { 
                                        ?><div class="control-group">
                                            <label class="control-label" for="input01"><?php echo $title;?>:</label>
                                            <div class="controls">
                                                <input type="text" value="<?php echo $he;?>" class="input-fluid  span3" id="<?php echo $hs.$if[$j];?>">
                                            </div>
                                        </div><?php 
                                    }
                                    if($hs=='Password')
                                    {
                                        ?><div class="control-group">
                                            <label class="control-label" for="input01"><?php echo $title;?><span> *</span>:</label>
                                            <div class="controls">
                                                    <input type="password" value="<?php echo str_rot13($he);?>" class="input-fluid validate[required] span3" id="<?php echo $hs.$if[$j];?>">
                                            </div>
                                        </div><?php 
                                    }
                                    if($hs=='Extension')
                                    {
                                        ?><div class="control-group">
                                            <label class="control-label" for="input01"><?php echo $title;?><span> *</span>:</label>
                                            <div class="controls"><?php 
                                            if($he=='on')
                                            { 
                                                ?><input type="checkbox"  id="<?php echo $hs.$if[$j];?>"  value="on"  checked="checked" ><?php 
                                            } 
                                            else
                                            {
                                                ?><input type="checkbox"  id="<?php echo $hs.$if[$j];?>" value="off"  ><?php 
                                            }
                                            ?></div>
                                            <div id="error_msg<?php echo $if[$j];?>" style="margin-left:100px;"></div>
                                        </div><?php 
                                    }
                                } 
                            }
                            ?><div class="span1"></div>  
                            <button class="diab btn btn-primary" style="width:100px;" type="submit" id="ahide<?php echo $if[$j];?>" >Save changes</button>
                            <button class='diab btn '  style=" width:100px; display:none;" id="bhide<?php echo $if[$j];?>" ></button>
                            &nbsp;&nbsp;<input class="btn" style="width:100px;" type="button" onClick="edit_cancel('<?php echo $vau?>','<?php echo $if[$j];?>')" value='Cancel'>
                        </form>

                        <div style="margin-top:-10px" ><span style='color:red;'> *</span> <?=_REQUIREDFIELD?> </div>
                        <p style='color:red;'><?=_GIVEPASSWORDHERE?></p>
                    </div>
                </section><?php
                $j++; 
                }
            }
        }
    }
}
?>
