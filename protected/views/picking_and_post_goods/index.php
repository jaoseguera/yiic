<style>
.table th:nth-child(-n+6), .table td:nth-child(-n+6){

	display:table-cell;
	
	}
</style>
<?php
global $rfc,$fce;
$i_vbeln  = "";
$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $i_vbeln="80000178";
    $cusLenth = count($i_vbeln);
    //if($cusLenth < 10 && $i_vbeln!='') { $i_vbeln = str_pad((int) $i_vbeln, 10, 0, STR_PAD_LEFT); } else { $i_vbeln = substr($i_vbeln, -10); }
}

if(isset($_REQUEST['values']))
{
    $VBE     = $_SESSION['VBE'];
    $json    = json_decode($_REQUEST['values'],true);
    $i_vbeln = $json['VBELN'];
    ?><script>
    $(document).ready(function() {
        $(".read").attr('readonly','readonly');
        $('.minw').hide();
        parent.titl('<?php echo $_REQUEST["titl"];?>');
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    });
    </script><?php
}

if(isset($_REQUEST['GET_D']))
{
//global $rfc, $fce; 
    $i_vbeln      = $_REQUEST['GET_D'];
    $i_vbelnLenth = count($i_vbeln);
    if($i_vbelnLenth < 10 && $i_vbeln!='') { $i_vbeln = str_pad((int) $i_vbeln, 10, 0, STR_PAD_LEFT); } else { $i_vbeln = substr($i_vbeln, -10); }

    $_REQUEST['values']  = $_REQUEST['GET_D'];
    //GEZG 06/22/2018
    //Changing SAPRFC methods
    $options = ['rtrim'=>true];
    $importTableVBELN = array();

    $IS_DLV_DATA_CONTROL = array("BYPASSING_BUFFER"=>"","HEAD_STATUS"=>"","HEAD_PARTNER"=>"","ITEM"=>"X","ITEM_STATUS"=>"","DOC_FLOW"=>"","FT_DATA"=>"","HU_DATA"=>"","SERNO"=>"");    
    

    $IT_VBELN = array("SIGN"=>"I","OPTION"=>"EQ","DELIV_NUMB_LOW"=>$i_vbeln);
    array_push($importTableVBELN, $IT_VBELN);    
    $res = $fce->invoke(['IS_DLV_DATA_CONTROL'=>$IS_DLV_DATA_CONTROL,
                        'IT_VBELN'=>$importTableVBELN],$options);
    

    $SalesOrder1 = $res['ET_DELIVERY_ITEM'];	
    foreach($SalesOrder1 as $values)
    {
        $VBE[$values['VBELN']][]=array('VBELN'=>$values['VBELN'],'POSNR'=>$values['POSNR'],'MATNR'=>$values['MATNR'],'LFIMG'=>$values['LFIMG'],'MEINS'=>$values['MEINS'],'WERKS'=>$values['WERKS']);
    }
    ?><script>$(document).ready(function() { $(".read").attr('readonly','readonly'); }); </script><?php
}
$this->renderPartial('smarttable');
$customize = $model;

?><script>
function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) { str = '0' + str; }
        document.getElementById('I_VBELN').value=str;
    }
}
</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content" style="margin-top:10px;"><?php
        if(!isset($_REQUEST['values'])&&!isset($_REQUEST['shows'])) 
        { 
		unset($_REQUEST['I_VBELN']);
            ?><form id="validation3" action="javascript:submit_form('validation3')" class="form-horizontal">
                <input type="hidden" name='page' value="bapi">
                <input type="hidden" name="url" value="picking_and_post_goods"/>
                <input type="hidden" name="key" value="picking_and_post_goods"/>

                <div class="span5 utopia-form-freeSpace">
                    <fieldset>
                        <div class="control-group ">
                            <label class="control-labels cutz" alt="Outbound Delivery Document" for="input01" style="width: auto;"><?php echo Controller::customize_label('Outbound Delivery Document');?><span>*</span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="controls myspace">
                                <input alt="Outbound Delivery Document" class="input-fluid validate[required,custom[number]]" type="text" name='GET_D' value="<?php echo $i_vbeln;?>" id='I_VBELN' onKeyUp="jspt('I_VBELN',this.value,event)" autocomplete="off">
                            </div>                            
                        </div>
                    </fieldset>
                </div>
                <br>
                <button class="btn btn-primary spanbt back_b iphone_pick_submit" type="submit" style="max-width:90px;">Submit</button>
            </form><?php 
        } 
        else 
        {
            if(isset($_REQUEST['shows']))
            {
                ?><form id="validation4" action="javascript:submit_form('validation4')" class="form-horizontal">
                    <input type="hidden" name='page' value="bapi">
                    <input type="hidden" name="url" value="picking_and_post_goods"/>
                     <input type="hidden" name="key" value="picking_and_post_goods"/>
                    <div class="span5 utopia-form-freeSpace" style="min-width:420px;">
                        <fieldset>
                            <div class="control-group ">
                                <label  class="control-labels cutz" alt="Outbound Delivery Document" for="input01"><?php echo Controller::customize_label('Outbound Delivery Document');?><span>*</span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <div class="controls myspace">
                                    <input alt="Outbound Delivery Document" class="input-fluid validate[required,custom[number]]" type="text" name='GET_D' value="<?php echo $i_vbeln;?>" id='I_VBELN' onKeyUp="jspt('I_VBELN',this.value,event)" autocomplete="off">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <br/>
                    <button class="btn btn-primary spanbt back_b iphone_pick_p_g iphone_pick_submit" type="submit" style="max-width:90px;">Get Items</button>
                </form><?php 
            }
            ?><form id="picking_validation" action="javascript:submit_ajaxform('picking_validation')" class="form-horizontal">
                <input type="hidden" name='page' value="bapi">
                <input type="hidden" name="url" value="picking_and_post_goods"/>
                <input type="hidden" name="key" value="picking"/>
                <input type="hidden" name="shows" value="shows"/><?php 
                $sds = ""; $mmr = ''; 
                if(isset($_REQUEST['shows']))  
                {
                    $sds = "style='display:none;'"; 
                    $mmr = "style='margin-top:-10px;'";
                }
                ?><div class="span11 utopia-form-freeSpace" >
                        <fieldset>
                            <div class="control-group ">
                        <label class="control-label cutz" alt="Outbound Delivery Document" style="width:auto" for="input01"><?php echo Controller::customize_label('Outbound Delivery Document');?><span>*</span>:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                         <div class="controls myspace">
						<input alt="Outbound Delivery Document" style="width:auto" class="input-fluid validate[required,custom[number]] read" type="text" name='I_VBELN' value="<?php echo ltrim($i_vbeln, "0"); ?>" id='I_VBELN' onKeyUp="jspt('I_VBELN',this.value,event)" autocomplete="off">
						</div>
						</div>
                    </fieldset></div>

                <br><br> <br><br>
                <div class="row-fluid" style="padding-left:3%">
                    <div class="span11" >
					<div style="border:1px solid #FAFAFA;overflow-y:scroll;overflow-x:scroll;">
                        <table class="table  table-bordered" id="dataTable" <?php echo $mmr;?>>
                            <thead>
                                <tr>
                                    <th style="display:none;"></th>
                                    <th class='cutz' alt='tableItems'><?php echo Controller::customize_label('tableItems');?></th>
                                    <th class='cutz' alt='Material'><?php echo Controller::customize_label('Material');?></th>
                                    <th class='cutz' alt='Description'><?php echo Controller::customize_label('Delivery qty');?></th>
                                </tr>
                            </thead>

                            <tbody><?php             
                            if(isset($_REQUEST['values'])||isset($_REQUEST['I_VBELN']))
                            {
                                $sd=0;
                                foreach($VBE[$i_vbeln] as $keys=>$values) 
                                {
                                    $met=$values['MATNR'];
                                    $plt=$values['WERKS'];
                                    ?><tr class="ids_<?php echo $sd;?> nudf" >
                                        <td class="check" style="display:none;"><input class="chkbox" type="checkbox" name="checkbox[]" title="che" id="chedk"></td>
                                        <td ><?php echo $values['POSNR'];?><input type="hidden" name='POSNR[]' value="<?php echo $values['POSNR'];?>" style="width:90%;" title="item" class='input-fluid validate[required,custom[number]] getval read' alt="Items" id="it"/></td>
                                        <td ><div onClick="show_prod('<?php echo $met;?>','<?php echo $plt;?>','picking_and_post_goods')" style="cursor:pointer;color:#39F;"><?php echo $values['MATNR'];?></div><input type="hidden"  id='MATERIAL' name='MATNR[]' class="input-fluid validate[required] getval radiu read" title="MATERIAL" alt="MULTI" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" value="<?php echo $values['MATNR'];?>"/>
                                        <input type="hidden" name='WERKS[]' value="<?php echo $plt;?>" />
                                        </td>
                                        <td><input type="text" id='DMATERIAL' style="width:90%;" class="input-fluid validate[required] getval" name='LFIMG[]' title="descript" alt="MULTI" onKeyUp="jspt('DMATERIAL',this.value,event)" autocomplete="off" value="<?php echo $values['LFIMG'];?>"/></td>
                                    </tr><?php 
                                    $sd++;                                     
                                }
								 unset($_REQUEST['values']);
							unset($_REQUEST['shows']);
                            }
                            ?></tbody>
                        </table>
						</div>
                        <table width="100%"><tr><td>
                            <span onclick="pre()" id="pre" class="btn" style="display:none">Previous</span>
                            <span id="pre1" class="btn" style="display:none">Previous</span>
                            </td><td>
                            <span onclick="nxt()" id="nxt" class="btn" style="float:right;display:none">Next</span>
                            <span id="nxt1" class="btn" style="float:right;display:none">Next</span>
                        </td></tr></table>
                    </div>
<div class="controls" style="margin-left:0px;float:right;width:180px;margin-bottom:1%">
					<button class="btn spanbt back_b iphone_pick_p_g iphone_pick_submit" type="button" id="cancel_btn" style="max-width:80px;">Cancel</button> <button class="btn btn-primary spanbt back_b iphone_pick_p_g iphone_pick_submit" type="submit" style="max-width:80px;">Submit</button>
                    </div>
                </div>
            </form><?php 
        } 
        ?></div>
    </div>
</section>
<div class="material_pop iphone_pick_post" ></div>

<script type="text/javascript">
$(document).ready(function() 
{
    $('.minw').hide();
    if($(document).width()<100)
    {
        $('#nxt1').css({color:'#cecece'});
        var gd=0;
        $('.iph').find('thead th').each(function(index, element) {
            gd=gd+1;
            var text=$(this).text();
            $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
            //$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
        });
    }
    jQuery("#validation3").validationEngine();
});
$("#cancel_btn").click(function() 
{
location.reload();
});
function pre()
{
    var lenft=$('.nudf').length;
    $('#nxt').css({color:'#000'});
    $('#nxt1').hide();
    $('#nxt').show();
    var num=0;
    $('.nudf').each(function(index, element) {
        // alert($(this).css('display'));
        $(this).attr('id','ids_'+num);
        num++;
    });
    $('.nudf').each(function(index, element) {
        // alert($(this).css('display'));
        if($(this).css('display')=='table-row')
        {
            var ids=$(this).attr('id');
            var sio=ids.split('_');
            $(this).hide();
            $('#ids_'+(sio[1]-1)).show();
            if(sio[1]-1==0)
            {
                $('#pre1').css({color:'#cecece'});
                $('#pre1').show();
                $('#pre').hide();
                var gd=0;
                $('.iph').find('thead th').each(function(index, element) {
                    gd=gd+1;
                    var text=$(this).text();
                    $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
                });
            }
            return false;
        }
    });
}

function nxt()
{
    $('.sda').remove();
    var lenft=$('.nudf').length;
    $('#pre').css({color:'#000'});
    $('#pre').show();
    $('#pre1').hide();
    var num=0;
    $('.nudf').each(function(index, element) {
        // alert($(this).css('display'));
        $(this).attr('id','ids_'+num);
        num++;
    });
    $('.nudf').each(function(index, element) {
    if($(this).css('display')=='table-row')
    {
        var ids=$(this).attr('id');
        var sio=ids.split('_');
        $(this).hide();
        var inid=sio[1];
        inid++;
        $('#ids_'+(inid)).show();
        if(inid==lenft-1)
        {
            $('#nxt1').css({color:'#cecece'});
            $('#nxt').hide();
            $('#nxt1').show();
        }
        return false;
    }
    });
}		
</script>