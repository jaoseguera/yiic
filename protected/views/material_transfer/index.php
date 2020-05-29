<?php
$meterial=""; $plant_from=""; $plant_to="";
$Sloc_from=""; $Sloc_to=""; $qut=""; $batch_from="";$uom="";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $meterial="N100003";
    $plant_from="1000";
    $plant_to="1000";
    $Sloc_from="1040";
    $Sloc_to="1060";
    $qut="5";
    $batch_from="110";
    $uom="EA";

}
?><style>
.table th, .table td { min-width:1px; }
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.table th, .table tbody td{  display:table-cell; }
.check  { display:none !important; }
.input-fluid {
    height: 18px;
    width: 60%;
}

</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;
?><div style="font-size:14px; color:#900; margin:0px 0px 30px 60px;"></div>
<form id="validation" action="javascript:submit_material()" class="form-horizontal">
    <section id="formElement" class="utopia-widget utopia-form-box section max_width">
        <div class="row-fluid">
            <div class="utopia-widget-content">
                <h4 class="filter_note" >Note : All fields are mandatory except "Batch From & Batch To"</h4>
                <input type="hidden" name='page' value="bapi">
                <input type="hidden" name="url" value="material_transfer"/>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="utopia-widget-content spaceing">
                            <div>
                                <a class="btn" href="#" onclick="addRow('dataTable')">Add item</a>
                                <a class="btn" href="#" onclick="deleteRow('dataTable')"><i class="icon-trash icon-white"></i>Delete item</a>
                            </div>
                        <br>
						<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
                        <table class="table  table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="check"><input class="utopia-check-all" type="checkbox" id="head"></th>
                                    <!--<th class="cutz" alt="Item Number"><?php /*echo Controller::customize_label('Item Number');*/?></th>-->
                                    <th class="cutz" alt="Material"><?php echo Controller::customize_label('Material');?></th>
                                    <th class="cutz" alt="Plant From"><?php echo Controller::customize_label('Plant From');?></th>
                                    <th class="cutz" alt="Storage Location From"><?php echo Controller::customize_label('Storage Location From');?></th>
                                    <th class="cutz" alt="Plant To"><?php echo Controller::customize_label('Plant To');?></th>
                                    <th class="cutz" alt="Storage Location To"><?php echo Controller::customize_label('Storage Location To');?></th>
                                    <th class="cutz" alt="Batch From"><?php echo Controller::customize_label('Batch From');?></th>
                                    <th class="cutz" alt="Batch To"><?php echo Controller::customize_label('Batch To');?></th>
                                    <th class="cutz" alt="Quantity"><?php echo Controller::customize_label('Quantity');?></th>
                                    <th class="cutz" alt="UOM"><?php echo Controller::customize_label('UOM');?></th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr onClick="select_row('ids_0')" class="ids_0 nudf">
                                    <td class="check"><input class="chkbox" type="checkbox" name="checkbox[]" title="che" id="che" /></td>
                                    <!--<td><input ype="text" name='PREQ_ITEM[]' value="10" style="width:90%;" title="item" id='itm' class='input-fluid validate[required,custom[number]]' readonly /></td>-->
                                    <td><input type="text" id='MATERIAL' class="input-fluid validate[required] getval radiu" name='D_MATERIAL[]' title="MATERIAL" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $meterial;?>"/>
                                        <div class='minws' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</div>
                                   <!-- <span  class='minw9' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PUR_GROUP','Purchasing Group','PUR_GROUP','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" id='PLANT_FROM' name='D_PLANT_FROM[]' class="input-fluid validate[required] getval radiu" title="Plant From" onKeyUp="jspt('PLANT_FROM',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $plant_from;?>"/>
                                    <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                        <div class='minws' onclick="lookup('Plant', 'PLANT_FROM', 'plant')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text" id='SLOC_FROM' class="input-fluid validate[required] getval" name='D_SLOC_FROM[]' title="Sloc From" onKeyUp="jspt('SLOC_FROM',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $Sloc_from;?>"/>
                                        <!--PLANT_FROM and WERKS these two fields are used to fill the plant No in lookup control-->
                                        <div class='minws' onclick="lookup('Storage Location', 'SLOC_FROM', 'storgae_loc','PLANT_FROM','WERKS');" >&nbsp;</div>
                                        <!--<span  class='minw9'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" id='PLANT_TO' class="input-fluid validate[required] getval" name='D_PLANT_TO[]' title="Plant To" onKeyUp="jspt('PLANT_TO',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $plant_to;?>"/>
                                    <!--<span  class='minw9' onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>-->
                                        <div class='minws' onclick="lookup('Plant', 'PLANT_TO', 'plant')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text" id='SLOC_TO' class="input-fluid validate[required] getval radiu" name='D_SLOC_TO[]' title="SLOC_TO" onKeyUp="jspt('SLOC_TO',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $Sloc_to;?>"/>
                                        <div class='minws' onclick="lookup('Storage Location', 'SLOC_TO', 'storgae_loc','PLANT_TO','WERKS')" >&nbsp;</div>
                                   <!-- <span class='minw9' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PURCH_ORG','Purchasing Organization','PURCH_ORG','0')" >&nbsp;</span>-->
                                    </td>
                                    <td><input type="text" class="input-fluid getval" name='D_BATCH_FROM[]' title="Batch From" id="BATCH_FROM" onKeyUp="jspt('BATCH_FROM',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $batch_from;?>"/>
                                        <div class='minws' onclick="lookup('Batch', 'BATCH_FROM', 'batch')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text"  class="input-fluid getval" name='D_BATCH_TO[]' title="Batch To" id="BATCH_TO" onKeyUp="jspt('BATCH_TO',this.value,event)" autocomplete="off" alt="MULTI" value=""/>
                                        <div class='minws' onclick="lookup('Batch', 'BATCH_TO', 'batch')" >&nbsp;</div>
                                    </td>
                                    <td><input type="text" style="width:90%;" class="input-fluid validate[required] getval" name='D_QUANTITY[]' id="QUANTITY" onKeyUp="jspt('QUANTITY',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $qut;?>"/>
                                    </td>
                                    <td><input type="text" id='UOM' class="input-fluid validate[required] getval radiu" name='D_UOM[]' title="UOM" onKeyUp="jspt('UOM',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $uom;?>"/>
                                        <div class='minws' onclick="lookup('UOM', 'UOM', 'uom')">&nbsp;</div>
                                    </td>
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
function setPlant(el,id){
        alert($('#'+id).val());
    $("input[name='WERKS']").val($('#'+id).val());


}
$(document).ready(function() {
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

var nut=0;
var inc=0;



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
		
        if(ind[0].title=='MATERIAL')
        {
            //ind[0].setAttribute("onchange","batch_validation('"+ids+nut+"',this.value,event,'MATERIAL')");
            var re=  newcell.getElementsByTagName('div');
            var met='MATERIAL'+nut;
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
        }
        if(ind[0].title=='Plant From')
        {
            //ind[0].setAttribute("onchange","batch_validation('"+ids+nut+"',this.value,event,'FROM')");
            var re=  newcell.getElementsByTagName('div');
            var su='PLANT_FROM'+nut;
            re[0].setAttribute("onclick", "lookup('Plant', '"+su+"', 'plant')");

        }
        if(ind[0].title=='Sloc From')
        {
            var re=  newcell.getElementsByTagName('div');
            var su='SLOC_FROM'+nut;
            var pl='PLANT_FROM'+nut;
            re[0].setAttribute("onclick","lookup('Storage Location', '"+su+"', 'storgae_loc','"+pl+"','WERKS')");

        }
        if(ind[0].title=='Plant To')
        {
            //ind[0].setAttribute("onchange","batch_validation('"+ids+nut+"',this.value,event,'TO')");
            var re=  newcell.getElementsByTagName('div');
            var plant='PLANT_TO'+nut;
            re[0].setAttribute("onclick","lookup('Plant', '"+plant+"', 'plant')");
        }
        if(ind[0].title=='SLOC_TO')
        {
            var re=  newcell.getElementsByTagName('div');
            var vendor='SLOC_TO'+nut;
            var pl='PLANT_TO'+nut;
            re[0].setAttribute("onclick","lookup('Storage Location', '"+vendor+"', 'storgae_loc','"+pl+"','WERKS')");
        }
        if(ind[0].title=='UOM')
        {
            var re=  newcell.getElementsByTagName('div');
            var uom='UOM'+nut;
            re[0].setAttribute("onclick","lookup('UOM', '"+uom+"', 'uom')");
        }
        if(ind[0].title=='Batch From')
        {
            //ind[0].setAttribute("onchange","batch_validation('"+ids+nut+"',this.value,event,'FROM')");
            var re=  newcell.getElementsByTagName('div');
            var batch_from='BATCH_FROM'+nut;
            re[0].setAttribute("onclick","lookup('Batch', '"+batch_from+"', 'batch')");
        }
        if(ind[0].title=='Batch To')
        {
            //ind[0].setAttribute("onchange","batch_validation('"+ids+nut+"',this.value,event,'TO')");
            var re=  newcell.getElementsByTagName('div');
            var batch_to='BATCH_TO'+nut;
            re[0].setAttribute("onclick","lookup('Batch', '"+batch_to+"', 'batch')");
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
			
			var id = $(this).attr("id");
            //var newid = id.replace(/\d+$/, num);
			if(index == 0)
				var newid = id.replace(/\d+$/, "");
			else
				var newid = id.replace(/\d+$/, num);
			$(this).attr('id', newid);
			if(inpindex > 1)
				$(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");

            /*if(inpindex == 1)
                $(this).attr("onchange","batch_validation('"+newid+"',this.value,event,'MATERIAL')");
            if(inpindex == 2 || inpindex == 6)
                $(this).attr("onchange","batch_validation('"+newid+"',this.value,event,'FROM')");
            if(inpindex == 4 || inpindex == 7)
                $(this).attr("onchange","batch_validation('"+newid+"',this.value,event,'TO')");*/
            $(this).closest("td").find(".formError").each(function() {
                $(this).remove();
            });
		});
		
		$(this).find('span').each(function(spanindex, spanelement)
		{
			var num = (10 * index);
			var id = $(this).prev().attr("id");
			if(index == 0)
				var newid = id.replace(/\d+$/, "");
			else
				var newid = id.replace(/\d+$/, num);
			var pf = "PLANT_FROM"+num;
            var pt = "PLANT_TO"+num;
			if(spanindex == 0)
                $(this).attr("onclick", "lookup('Material', '"+newid+"', 'material');");
			if(spanindex == 1)
                $(this).attr("onclick", "lookup('Plant', '"+newid+"', 'plant');");
			if(spanindex == 2)
				$(this).attr("onclick", "lookup('Storage Location', '"+newid+"', 'storgae_loc','"+pf+"','WERKS')");
			if(spanindex == 3)
                $(this).attr("onclick", "lookup('Plant', '"+newid+"', 'plant');");
            if(spanindex == 4)
				$(this).attr("onclick","lookup('Storage Location', '"+newid+"', 'storgae_loc','"+pt+"','WERKS')");
            if(spanindex == 5)
                $(this).attr("onclick","lookup('Batch', '"+newid+"', 'batch')");
            if(spanindex == 6)
                $(this).attr("onclick","lookup('Batch', '"+newid+"', 'batch')");
            if(spanindex == 8)
                $(this).attr("onclick","lookup('UOM', '"+newid+"', 'uom')");
        });
		num++;

	});
    //$('.formError').hide();
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
function submit_material()
{
	$("input[name='PLANT_FROM[]']").each(function() {
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
        url: 'material_transfer/material_transfer',
        data:$('#validation').serialize(), 
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
            var msg=spt[1];
            jAlert('<b>SAP System Message: </b><br>'+spt[0], 'Message');
            if(msg=='S')
            {
                $('.getval').val("");
            }
        }
    });

}


/*function batch_validation(ids,myKey,e,type)
{

    var v_batch = "";
    var v_material = "";
    var v_plant = "";
    if(type=="FROM"){
        v_batch = "BATCH_FROM";
        v_material = "MATERIAL";
        v_plant = "PLANT_FROM";
    }else{
        v_batch = "BATCH_TO";
        v_material = "MATERIAL";
        v_plant = "PLANT_TO";
    }

    var id_append = ids.replace(/[^0-9\.]/g, '');
    var batch = $("#"+v_batch+id_append).val();
    var material = $("#"+v_material+id_append).val();
    var plant = $("#"+v_plant+id_append).val();
    var val    = new Array('',material,plant);
    if(material!="" && plant!=""){
        $('#loading').show();
        $("body").css("opacity","0.4");
        $.ajax({
            type: "POST",
            url: "material_transfer/batch_validation",
            data: "val="+val+"&batch="+batch,
            success: function(html)
            {
                //alert(html);
                $('#loading').hide();
                $("body").css("opacity","1");
                if(html=='nobatch')
                {
                    $("#"+v_batch+id_append).val('');
                    $("#"+v_batch+id_append).attr('readonly', true);
                    $("#"+v_batch+id_append).next("span").css("display", "none");
                    jAlert('<b>SAP System Message: </b><br> '+material+' Material does not have a batch details.' , 'Remove From Storage');
                }
                else
                {
                    //$("#"+v_batch+id_append).val('');
                    $("#"+v_batch+id_append).attr('readonly', false);
                    $("#"+v_batch+id_append).next("span").css("display", "");
                }
                if(type=="MATERIAL")
                    batch_validation(ids,myKey,e,"FROM");
            }
        });
    }

}*/

</script>