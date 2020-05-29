<?php
$pur_grp=""; $meterial=""; $plant=""; $vendor="";
$qut=""; $unit=""; $preq="";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $pur_grp="100";
    $purch_org="1000";
    $meterial="H11";
    $plant="1000";
    $vendor="300001";
    $qut="2";
    $unit="ea";
    $preq="100";
}
?><style>
.table th, .table td { min-width:10px; }
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.table th, .table tbody td{  display:table-cell; }
.check  { display:none !important; }
.input-fluid {
    height: 18px;
    width: 60% !important;
}
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;
?><div style="font-size:14px; color:#900; margin:0px 0px 30px 60px;"></div>
<form id="validation" action="javascript:createPurchaseRequisition()" class="form-horizontal">
    <section id="formElement" class="utopia-widget utopia-form-box section max_width">
        <div class="row-fluid">
            <div class="utopia-widget-content">
                <h4 class="filter_note" >Note : All fields are mandatory except "Vendor"</h4>
                <input type="hidden" name='page' value="bapi">
                <input type="hidden" name="url" value="createpurreq"/>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="utopia-widget-content spaceing">
                            <div>
                                <a class="btn" href="#"  onclick="addRow('dataTable')">Add item</a>
                                <a class="btn" href="#" onclick="deleteRow('dataTable')"><i class="icon-trash icon-white"></i>Delete item</a>
                            </div>
                        <br>
						<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
                        <table class="table  table-bordered " id="dataTable">
                            <thead>
                                <tr>
                                    <th class="check"><input class="utopia-check-all" type="checkbox" id="head"></th>
                                    <th class="cutz" alt="Item Number"><?php echo Controller::customize_label('Item Number');?></th>
                                    <th class="cutz" alt="Purchasing Group"><?php echo Controller::customize_label('Purchasing Group');?></th>
                                    <th class="cutz" alt="Material"><?php echo Controller::customize_label('Material');?></th>
                                    <th class="cutz" alt="Plant"><?php echo Controller::customize_label('Plant');?></th>
                                    <th class="cutz" alt="Vendor"><?php echo Controller::customize_label('Vendor');?></th>
                                    <th class="cutz" alt="Purchase Org."><?php echo Controller::customize_label('Purchase Org.');?></th>
                                    <th class="cutz" alt="Quantity"><?php echo Controller::customize_label('Quantity');?></th>
                                    <th class="cutz" alt="UOM"><?php echo Controller::customize_label('UOM');?></th>
                                    <th class="cutz" alt="PREQ Price"><?php echo Controller::customize_label('PREQ Price');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr onClick="select_row('ids_0')" class="ids_0 nudf">
                                    <td class="check"><input class="chkbox" type="checkbox" name="checkbox[]" title="che" id="che" /></td>
                                    <td><input ype="text" name='PREQ_ITEM[]' value="10" style="width:90%;" title="item" id='itm' class='input-fluid validate[required,custom[number]]' readonly /></td>
                                    <td><input type="text" id='PUR_GROUP' class="input-fluid validate[required] getval radiu" name='PUR_GROUP[]' title="PUR_GROUP" onKeyUp="jspt('PUR_GROUP',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $pur_grp;?>"/>
                                        <div class='minws' onclick="lookup('Purchasing Group', 'PUR_GROUP', 'purch_group')" >&nbsp;</div>
                                   <!-- <span  class='minw9' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PUR_GROUP','Purchasing Group','PUR_GROUP','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" id='MATERIAL' name='MATERIAL[]' style="width:55%;" class="input-fluid validate[required] getval radiu" title="Material" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $meterial;?>"/>
                                    <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                        <div class='minws' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text" id='PLANT' class="input-fluid validate[required] getval" name='PLANT[]' title="PLANT" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $plant;?>"/>
                                        <div class='minws' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</div>
                                        <!--<span  class='minw9'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" id='VENDOR' class="input-fluid getval" name='VENDOR[]' title="VENDOR" onblur="mand_purch_org(this);" onKeyUp="jspt('VENDOR',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $vendor;?>"/>
                                    <!--<span  class='minw9' onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><div class='minws' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text" id='PURCH_ORG' class="input-fluid getval radiu" name='PURCH_ORG[]' title="PURCH_ORG" onKeyUp="jspt('PURCH_ORG',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $purch_org;?>"/>
                                        <div class='minws' onclick="lookup('Purchasing Organization', 'PURCH_ORG', 'purch_org')" >&nbsp;</div>
                                   <!-- <span class='minw9' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PURCH_ORG','Purchasing Organization','PURCH_ORG','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" style="width:90% !important;" class="input-fluid validate[required,custom[number]] getval" name='QUANTITY[]' id="QUANTITY" onKeyUp="jspt('QUANTITY',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $qut;?>"/></td>
                                    <td><input type="text" style="width:90% !important;" id='UNIT' class="input-fluid validate[required] getval radiu" name='UNIT[]' title="UNIT" onKeyUp="jspt('UNIT',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $unit;?>"/></td>
                                    <td><input type="text" style="width:90% !important;" id='PREQ_PRICE' class="input-fluid validate[required] getval radiu" name='PREQ_PRICE[]' title="PREQ_PRICE" onKeyUp="jspt('PREQ_PRICE',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $preq;?>"/></td>
                                </tr>
                            </tbody>
                        </table>
						</div>
                        <table width="100%"><tr><td>
                            <span onclick="pre()" id="pre" class="btn" style="display:none">Previous</span>
                            <span id="pre1" class="btn" style="display:none">Previous</span>
                            </td><td>
                            <span onclick="nxt()" id="nxt" class="btn" style="float:right;display:none">Next</span>
                            <span id="nxt1" class="btn" style="float:right;display:none">Next</span>
                            </td></tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </section>
    <div>
        <input type="submit" value="<?php echo _SUBMIT ?>" class='btn btn-primary bbt' />
    </div>
</form>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$('#VENDOR').focus();
	$('#VENDOR').blur();
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
});



function createPurchaseRequisition()
{
    $("input[name='PURCH_ORG[]']").each(function() {
        var val = $(this).val();
        if(val == "")
        {
            $(this).closest("td").find(".formError").each(function() {
                $(this).remove();
            });
        }
    });
    
    var de = 0;
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: 'create_purchase_requisition/create_purchase_requisition', 
        data:$('#validation').serialize(), 
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
            jAlert('<b>SAP System Message: </b><br>'+spt[0], 'Message');
            var msg=$.trim(spt[1])
            if(msg=='S')
            {
                $('.getval').val("");
            }
        }
    });
}

var nut=0;
var inc=0;

function mand_purch_org(ctrl)
{
	var val = ctrl.value;
	ctrlid = ctrl.id;
	id = ctrlid.replace("VENDOR", "");
	PURCH_ORG = "PURCH_ORG"+id;
	
	if(val != "")
		$("#"+PURCH_ORG).addClass("validate[required]");
	else
	{
		$("#"+PURCH_ORG).removeClass("validate[required]");
		$("#"+PURCH_ORG).closest("td").find(".formError").each(function() {
			$(this).remove();
		});
	}
}

function addRow(tableID) 
{
    inc=inc+1;
    if($(document).width()<100)
    {
        $('#nxt1').show();
        $('#pre').show();
        $('.sda').remove();
        $('.nudf').hide();
        $('#pre1').hide();
    }
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
	inc = rowCount;
    var row = table.insertRow(rowCount);
    row.setAttribute('onclick', 'select_row("ids_'+inc+'")');
    row.setAttribute('class', 'ids_'+inc+' nudf');
    var colCount = table.rows[1].cells.length;
    nut=nut+10;
    for(var i=0; i<colCount; i++) {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        var ind=newcell.getElementsByTagName('input');
        if(ind[0].title=='che')
        {
            newcell.setAttribute('class', 'check');
        }
        var ids=ind[0].id;
        ind[0].id=ids+nut;
		if(ids != "che")
			ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");
		
        if(ind[0].title=='Material')
        {
            var re=  newcell.getElementsByTagName('div');
            var met='MATERIAL'+nut;
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
        }
        if(ind[0].title=='PUR_GROUP')
        {
            var re=  newcell.getElementsByTagName('div');
            var su='PUR_GROUP'+nut;
            re[0].setAttribute("onclick", "lookup('Purchasing Group', '"+su+"', 'purch_group')");

        }
        if(ind[0].title=='PURCH_ORG')
        {
            var re=  newcell.getElementsByTagName('div');
            var su='PURCH_ORG'+nut;
            re[0].setAttribute("onclick","lookup('Purchasing Organization', '"+su+"', 'purch_org')");
        }
        if(ind[0].title=='PLANT')
        {
            var re=  newcell.getElementsByTagName('div');
            var plant='PLANT'+nut;
            re[0].setAttribute("onclick","lookup('Plant', '"+plant+"', 'plant')");
        }
        if(ind[0].title=='VENDOR')
        {
            var re=  newcell.getElementsByTagName('div');
            var vendor='VENDOR'+nut;
            // re[0].setAttribute("onclick","tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','"+vendor+"','4@KREDA');");<span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
            re[0].setAttribute("onclick","lookup('Vendor Number', '"+vendor+"', 'vendor')");
        }
        if(ind[0].title=='item')
        {
            var numb=newcell.childNodes[0].value;
			ind[0].value=(eval(inc)*10);
        }
        else
        {
            ind[0].value = "";
        }
        if($(document).width()<100)
        {
            var test=$('.iph').find('thead th:nth-child('+(i+1)+')').text();
            $('#'+newcell.childNodes[0].id).before('<label class="labls">'+test+'<span> *</span>:</label>');
            //$('#'+newcell.childNodes[0].id).after('<br><br>');
        }
    }
}

function deleteRow(tableID) 
{
    if($(document).width()<100)
    {
        var num=0;
        $('.nudf').each(function(index, element) {
            // alert($(this).css('display'));
            $(this).attr('id','ids_'+num);
            num++;
        });
        $('.nudf').each(function(index, element) {
            // alert($(this).css('display'));
            var lenft=$('.nudf').length;
            var nur=1;
            if($(this).css('display')=='table-row')
            {
                if(lenft==nur)
                {
                    $('#nxt').hide();
                    $('#nxt1').show();
                }
                var ids=$(this).attr('id');
                if(ids=='ids_0')
                {
                    jAlert('<b>At least one item is required.</b>', 'Message');
                    return false;
                }
                var sio=ids.split('_');
                $(this).remove();
                var cll=$('#ids_'+(sio[1]-1)).attr('class');
                if(cll=='ids_0 nudf')
                {
                    $('#pre').hide();
                    $('#pre1').show();
                    var gd=0;
                    $('.iph').find('thead th').each(function(index, element) {
                        gd=gd+1;
                        var text=$(this).text();
                        $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
                    })
                }
                $('#ids_'+(sio[1]-1)).show();
            }
            nur++;
        });
    }
    else
    {
        try {
            var cunt=0;
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(chkbox.id!='head')
                {
                    if(chkbox.checked)
                    {
                        cunt=cunt+1;
                    }
                }
            }
            if(rowCount-1==cunt)
            {
                jAlert('<b>At least one item is required.</b>', 'Message');
            }
            else
            {
                for(var i=0; i<rowCount; i++) {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    if(chkbox.id!='head')
                    {
                        if(null != chkbox && true == chkbox.checked)
                        {   
                            table.deleteRow(i); 
                            rowCount--; 
                            i--;
                        }
                    }
                }
            }
        }
        catch(e) {}
    }
	
	var num=0;
	$('#'+tableID+" tbody tr").each(function(index, element) 
	{
		$(this).attr('class','ids_'+num);
		$(this).attr('onclick', 'select_row("ids_'+num+'")');
		var tds = $(this).find('td');
		
		$(this).find('input').each(function(inpindex, inpelement)
		{
			var num = (10 * index);
			if(inpindex == 0)
				$(this).attr('checked', false);
			if(inpindex == 1)
			{
				if(index == 0)
					$(this).val(10);
				else
					$(this).val((num+10));
			}
			
			var id = $(this).attr("id");
			if(index == 0)
				var newid = id.replace(/\d+$/, "");
			else
				var newid = id.replace(/\d+$/, num);
			$(this).attr('id', newid);
			if(inpindex > 1)
				$(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");
			if(inpindex == 2)
				$(this).attr("onchange","jspt_new('"+newid+"',this.value,event)");
		});
		
		$(this).find('span').each(function(spanindex, spanelement)
		{
			var num = (10 * index);
			var id = $(this).prev().attr("id");
			if(index == 0)
				var newid = id.replace(/\d+$/, "");
			else
				var newid = id.replace(/\d+$/, num);
			
			if(spanindex == 0)
				$(this).attr("onclick","lookup('Purchasing Group', '"+newid+"', 'purch_group')");
			if(spanindex == 1)
                $(this).attr("onclick", "lookup('Material', '"+newid+"', 'material');");
				/*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+newid+"','3@MAT1L');");*/
			if(spanindex == 2)
				$(this).attr("onclick", "lookup('Plant', '"+newid+"', 'plant')");
			if(spanindex == 3)
				$(this).attr("onclick","lookup('Vendor Number', '"+newid+"', 'vendor');");
                   if(spanindex == 4)
				$(this).attr("onclick","lookup('Purchasing Organization', '"+newid+"', 'purch_org')");
                   		});
		num++;
	});
}

function select_row(ids)
{
    if($('.'+ids).hasClass('bb'))
    {
        $('.'+ids).removeClass('bb');
        $('.'+ids).find('input:checkbox').prop('checked', false);
    }
    else
    {
        $('.'+ids).addClass('bb');
        $('.'+ids).find('input:checkbox').prop('checked', true);
    }
}


function pre()
{
    var lenft = $('.nudf').length;
    $('#nxt').css({color:'#000'});
    $('#nxt1').hide();
    $('#nxt').show();
    var num=0;
    $('.nudf').each(function(index, element) 
    {
        // alert($(this).css('display'));
        $(this).attr('id','ids_'+num);
        num++;
    });
    $('.nudf').each(function(index, element) 
    {    
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
                $('.iph').find('thead th').each(function(index, element) 
                {                
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

$(document).ready(function() { jQuery("#validation").validationEngine(); });      
</script>