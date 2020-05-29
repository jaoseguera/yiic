<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

	display:table-cell;
	
	}	
	
</style>
<script>
    $(document).ready(function(e)
	{
        if($(document).width()<100)
        {
            $('#nxt1').css({color:'#cecece'});
            var gd=0;
            <?php if(!isset($_REQUEST['po']))
            { ?>
            $('.iph').find('thead th').each(function(index, element) {
                gd=gd+1;
                var text=$(this).text();
                $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
                //$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
            });
            <?php }else{ ?>
                $('.iph').find('thead th').each(function(index, element) {
                    gd=gd+1;
                    var text=$(this).text();
                   $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="labls">'+text+'<span> *</span>:</label>');
                    //$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
                });

                $('.iph').find('tbody tr:first').each(function(index, element) {
                    $(this).find('.labls').remove();
                });
            <?php } ?>
        }
    });
	
    var inc=0;
    var nut=0;
    function addRow(tableID)
	{
        //inc=inc+1;
        if($(document).width()<100)
        {
            $('#pre').show();
            $('#nxt1').show();
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
		var tabindex = table.rows[1].cells[(colCount-2)].childNodes[0].id;
		var tabindex = $("#"+tabindex).attr("tabindex");
		
        //alert(table.rows[0].innerHTML);
		
        // var nut=Number(table.rows[rowCount-1].cells[1].childNodes[0].value);
        nut = inc;
        for(var i=0; i<colCount; i++)
		{
            var newcell = row.insertCell(i);
            //newcell.childNodes[0].insertBefore('hello');
            newcell.innerHTML = table.rows[1].cells[i].innerHTML;
            var ind = newcell.getElementsByTagName('input');
            if(ind[0].title=='chedk')
            {
                newcell.setAttribute('class', 'check');
                newcell.setAttribute('style', 'display:none !important');
            }
            //alert(newcell.childNodes[0].id);
            if(ind[0].title == '')
				var ids=ind[0].id;
			else
				var ids=ind[0].title;
            ind[0].id=ids+nut;
			if(ids != "chedk")
				ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");
            if(ind[0].title=='MATERIAL')
            {
                var re=  newcell.getElementsByTagName('div');
                var met='MATERIAL'+nut;
            /*    re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
                re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");

            }
			
            if(ind[0].title=='PLANT')
            {
                var re=  newcell.getElementsByTagName('div');
                var plant='PLANT'+nut;
                re[0].setAttribute("onclick","lookup('Plant', '"+plant+"', 'plant')");

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
		var row = "ids_"+inc;
		$("."+row).find("input[type=hidden]").remove();
		$("."+row).find("span").show();
		$("."+row).find("input[type=text]").each(function(index) {
			if(index != 0)
				$(this).prop("readonly", false);
			
			tabindex++;
			$(this).attr("tabindex", tabindex);
		});
		tabindex++;
		$("#btn-submit").attr("tabindex", tabindex);
    }
	
    function deleteRow(tableID)
	{
        if($(document).width()<100)
        {
            var num = 1;
            $('.nudf').each(function(index, element)
			{
                // alert($(this).css('display'));
                $(this).attr('id','ids_'+num);
                num++;
            });
			
            $('.nudf').each(function(index, element)
			{
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
                    if(ids=='ids_1')
                    {
                        jAlert('<b>At least one item is required.</b>', 'Message');
                        return false;
                    }
                    var sio=ids.split('_');
                    $(this).remove();
                    var cll=$('#ids_'+(sio[1]-1)).attr('class');
					
                    if(cll=='ids_1 nudf')
                    {
                        $('#pre').hide();
                        $('#pre1').show();
                        var gd=0;
                        $('.iph').find('thead th').each(function(index, element) {
                            gd=gd+1;
                            var text=$(this).text();
                            $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
                        });
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
				var colCount = (table.rows[1].cells.length-1);
                for(var i=0; i<rowCount; i++)
				{
                    var row = table.rows[i];
                    var chkbox = row.cells[colCount].childNodes[0];
					
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
                    for(var i=0; i<rowCount; i++)
					{
						var row = table.rows[i];
						var chkbox = row.cells[colCount].childNodes[0];
						
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
            }catch(e) {
             
            }
        }
		
		var num=0;
		$('#'+tableID+" tbody tr").each(function(index, element) 
		{
			$(this).attr('class','ids_'+num);
			$(this).attr('onclick', 'select_row("ids_'+num+'")');
			var tds = $(this).find('td');
			
			if(index > 0)
			{
				$(this).find('input').each(function(inpindex, inpelement)
				{
					var num = (10 * index);
					if(inpindex == 0)
						$(this).val((num+10));
					
					var id = $(this).attr("id");
					var newid = id.replace(/\d+$/, num);
					$(this).attr('id', newid);
					if(inpindex > 0)
						$(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");
					if(inpindex == 2)
						$(this).attr("onchange","jspt_new('"+newid+"',this.value,event)");
				});
				
				$(this).find('span').each(function(spanindex, spanelement)
				{
					var num = (10 * index);
					var id = $(this).prev().attr("id");
					var newid = id.replace(/\d+$/, num);
					
					if(spanindex == 0)
                        $(this).attr("onclick", "lookup('Material', '"+newid+"', 'material');");
						/*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+newid+"','3@MAT1L');");*/

					if(spanindex == 1)
						$(this).attr("onclick", "lookup('Plant', '"+newid+"', 'plant')");
				});
			}
			else
			{
				$(this).find('input').each(function(inpindex, inpelement)
				{
					if(inpindex == 0)
						$(this).val(10);
					
					var id = $(this).attr("id");
					var newid = id.replace(/\d+$/, "");
					$(this).attr('id', newid);
					if(inpindex > 0)
						$(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");
					if(inpindex == 2)
						$(this).attr("onchange","jspt_new('"+newid+"',this.value,event)");
				});
				
				$(this).find('span').each(function(spanindex, spanelement)
				{
					var id = $(this).prev().attr("id");
					var newid = id.replace(/\d+$/, "");
					
					if(spanindex == 0)
						$(this).attr("onclick", "lookup('Material', '"+newid+"', 'material');");
                    /*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+newid+"','3@MAT1L');");*/
					if(spanindex == 1)
						$(this).attr("onclick","lookup('Plant', '"+newid+"', 'plant')");
				});
			}
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
        var lenft=$('.nudf').length;
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
        $('.nudf').each(function(index, element)
		{
            // alert($(this).css('display'));
            $(this).attr('id','ids_'+num);
            num++;
        });
		
        $('.nudf').each(function(index, element)
		{
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
	
    function create_po()
    {
        var de=0;
        if(de!=1)
        {}
		
        $('#loading').show();
        $("body").css("opacity","0.4"); 
        $("body").css("filter","alpha(opacity=40)"); 
        $.ajax({
            type:'POST', 
            url: 'create_purchase_order/create_purchase_order', 
            data:$('#validation1').serialize(), 
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
        
    $("#validation1").bind("keypress", function (e)
	{
		if (e.keyCode == 13)
		{
			$("#btnSearch").attr('value');
            //add more buttons here
            return false;
        }
    });
</script>
<style>
    /*.table th,
    .table td
    {
        min-width:1px;
    }*/
    .bb
    {
        background:#cecece !important;

    }
    .bb:hover
    {
        background:#cecece !important;
    }
	/*.table th:nth-child(-n+6), .table td:nth-child(-n+6){
        display:table-cell;
    }*/
    .check
    {
        display:none !important;
    }
</style>
<?php
$comp_code  = "";
$matetial 	= "";
$vendor 	= "";
$purch_org 	= "";
$pur_group 	= "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210' && !isset($_REQUEST['po']))
{
	$comp_code 	= "1000";
    $vendor		= "300001";
    $purch_org	= "1000";
    $pur_group	= "100";
	$ref 		= "ref123";
	
    $matetial	= "H11";
    $plant		= "1000";
    $qut		= "2";
    $unit		= "ea";
}

if(isset($_REQUEST['po'])){
    global $rfc, $fce;
    $h_companyCode = array();
    $h_purch_group = array();
    $h_vendor = array();
    $h_purch_org = array();
    $PO = substr($_REQUEST['po'], 0, -1);
    $Arr_PO = explode("@", $PO);
    foreach($Arr_PO as $key=>$val)
    {
        $values = explode(",", $val);
        /*$purch_group = $values[3];
        $plant = $values[5];
        $vendor = $values[8];
        $purch_org = $values[9];*/
        $b1 = new Bapi();
        $b1->bapiCall('PLANT_GET_DETAIL');
        
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $res = $fce->invoke(['PLANT'=>$values[5],
                            'WITH_COMPANY_CODE'=>'X'],$options);
      
        $result = $res['PLANT_GENERAL_DATA'];
        array_push($h_companyCode, $result['COMPANY_CODE']);
        array_push($h_purch_group, $values[3]);
        array_push($h_vendor, $values[8]);
        array_push($h_purch_org, $values[2]);

    }

    if (count(array_unique($h_purch_group)) === 1) {
        $pur_group = $h_purch_group[0];
    }
    if (count(array_unique($h_purch_org)) === 1) {
        $purch_org = $h_purch_org[0];
    }
    if (count(array_unique($h_vendor)) === 1) {
        $vendor = $h_vendor[0];
    }
    if (count(array_unique($h_companyCode)) === 1) {
        $comp_code = $h_companyCode[0];
    }
}


if(isset($_REQUEST['vendor']))
	$vendor = $_REQUEST['vendor'];

if(isset($_REQUEST['ORDER_NUMBER']))
{
    $json 		= $_REQUEST['json'];
    $json_de 	= json_decode($json, true);
    $matetial 	= $json_de['MATERIAL'];
    $vendor 	= $json_de['VENDOR'];
    $purch_org 	= $json_de['PURCH_ORG'];
    $pur_group 	= $json_de['PUR_GROUP'];
	
    ?>
	<script>
        $(document).ready(function(e)
		{
            parent.titl('<?php echo $_REQUEST["titl"]; ?>');
            parent.subtu('<?php echo $_REQUEST["tabs"]; ?>');
		});
	</script>
	<?php
}
if(isset($_REQUEST['titl']))
{
	?>
	<script>
        $(document).ready(function(e)
		{
            parent.titl('<?php echo $_REQUEST["titl"]; ?>');
            parent.subtu('<?php echo $_REQUEST["tabs"]; ?>');
		});
	</script>
	<?php
}
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<?php $customize = $model; ?>
<section id="formElement" class="utopia-widget utopia-form-box section">
	<div class="row-fluid">
		<div class="utopia-widget-content myspace">
			<form id="validation1" action="javascript:create_po()" class="form-horizontal">
				<div class="span5 utopia-form-freeSpace">
					<fieldset>
						<div class="control-group">
							<input type="hidden" name='page' value="bapi">
							<input type="hidden" name="url" value="createpurchaseorder"/>
							<input type="hidden" name="key" value="createpurchaseorder"/>
							<label class="control-label cutz" for="date" alt="Company Code" style="min-width:170px;"><?php echo Controller::customize_label('Company Code'); ?><span> *</span>:&nbsp;&nbsp;</label>
							<div class="controls">
								<input alt="Company Code" type="text" class="input-fluid  validate[required] getval" name="COMP_CODE" tabindex="1" onKeyUp="jspt('COMP_CODE',this.value,event)" value="<?php echo $comp_code; ?>" autocomplete="off" id="COMP_CODE">
                                <!--<span  class='minw3' onclick="tipup('BUS0002','GETLIST','COMPANYCODELIST','COMP_CODE','Company Code','COMP_CODE','0')" >&nbsp;</span>-->
                                <span class='minw' onclick="lookup('Company Code', 'COMP_CODE', 'company_code')" >&nbsp;</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label cutz" for="input01" style="min-width:170px;" alt='Vendor Number'><?php echo Controller::customize_label('Vendor Number'); ?><span> *</span>:&nbsp;&nbsp;</label>
							<div class="controls">
								<input  alt="Vendor Number" type="text" class="input-fluid validate[required] getval" name='VENDOR'  tabindex="2" onKeyUp="jspt('VENDOR',this.value,event)" value="<?php echo $vendor; ?>" autocomplete="off" id="VENDOR" ><!--<span  class='minw3' onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label cutz" for="input01" style="width:170px;" alt='Purchasing Organization'><?php echo Controller::customize_label('Purchasing Organization'); ?><span> *</span>:&nbsp;&nbsp;</label>
							<div class="controls">
								<input alt="Purchasing Organization" type="text" class="input-fluid validate[required] getval" name='PURCH_ORG'  tabindex="3" onKeyUp="jspt('PURCH_ORG',this.value,event)" value="<?php echo $purch_org; ?>" autocomplete="off" id="PURCH_ORG" >
                                <span class='minw' onclick="lookup('Purchasing Organization', 'PURCH_ORG', 'purch_org')" >&nbsp;</span>
                                <!--<span  class='minw3' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PURCH_ORG','Purchasing Organization','PURCH_ORG','0')" >&nbsp;</span>-->
							</div>
						</div>
					</fieldset>
				</div>
				<div class="span5 utopia-form-freeSpace rid">
					<fieldset>
						<div class="control-group">
							<label class="control-label cutz" for="input01" alt='Purchasing Group' style="min-width:170px;"> <?php echo Controller::customize_label('Purchasing Group'); ?><span> *</span>:&nbsp;&nbsp;</label>
							<div class="controls">
								<input alt="Purchasing Group" type="text" class="input-fluid validate[required] getval" name='PUR_GROUP' tabindex="4" onKeyUp="jspt('PUR_GROUP1',this.value,event)" style="min-width:170px;" value="<?php echo $pur_group; ?>" autocomplete="off" id="PUR_GROUP1" >
                                <span class='minw' onclick="lookup('Purchasing Group', 'PUR_GROUP1', 'purch_group')" >&nbsp;</span>
                                <!--<span class='minw3' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PUR_GROUP','Purchasing Group','PUR_GROUP1','0')" >&nbsp;</span>-->
							</div>
						</div>
						<div class="control-group">
							<label class="control-label cutz" for="input01" alt='Reference' style="min-width:170px;"><?php echo Controller::customize_label('Reference'); ?>&nbsp:&nbsp;&nbsp;</label>
							<div class="controls">
								<input alt="Reference" type="text" class="input-fluid getval" name='OUR_REF' tabindex="5" onKeyUp="jspt('OUR_REF',this.value,event)" value="<?php echo $ref; ?>" autocomplete="off" id="OUR_REF">
							</div>
						</div>
					</fieldset>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<div class="utopia-widget-content spaceing max_width">
							<div>
								<a class="btn" onclick="addRow('dataTable')">Add item</a>
								<a class="btn" onclick="deleteRow('dataTable')">
									<i class="icon-trash icon-white"></i>
									Delete item
								</a>
							</div>
							<br>
							<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
							<table class="table table-bordered " id="dataTable">
								<thead>
									<tr>
										<th class="cutz" alt="Item Number"><?php echo Controller::customize_label('Item Number'); ?></th>
										<th class="cutz" alt="Material"><?php echo Controller::customize_label('Material'); ?></th>
										<th class="cutz" alt="Plant"><?php echo Controller::customize_label('Plant'); ?></th>
										<th class="cutz" alt="Quantity"><?php echo Controller::customize_label('Quantity'); ?></th>
										<th class="cutz" alt="UOM"><?php echo Controller::customize_label('UOM'); ?></th>
										<th class="check"><input class="utopia-check-all" type="checkbox" id="head"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if(!isset($_REQUEST['po']))
										{
											?>
											<tr onClick="select_row('ids_1')" class="ids_1 nudf">
												<td><input type="text" name='PO_ITEM[]' value="10" style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' readonly id='itms' tabindex="6"/></td>
												<td><input type="text" id='MATERIAL' name='MATERIAL[]' class="input-fluid validate[required] getval radiu" title="MATERIAL"  alt="MULTI" tabindex="7" style="width:55% !important" value="<?php echo $matetial; ?>"/>
                                                    <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                                    <div class='minws1' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</div>
                                                </td>
												<td><input type="text" id='PLANT'  class="input-fluid validate[required] getval" name='PLANT[]' title="PLANT" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" alt="MULTI" style="width:55% !important" value="<?php echo $plant; ?>" tabindex="8"/>
                                                    <div class='minws1' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</div></td>
												<td><input type="text" style="width:90%;" id='QUANTITY' class="input-fluid validate[required] getval radiu" name='QUANTITY[]' title="QUANTITY" onKeyUp="jspt('QUANTITY',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $qut; ?>" tabindex="9"/></td>
												<td><input type="text" style="width:90%;" id='PO_UNIT' class="input-fluid validate[required] getval radiu" name='PO_UNIT[]' title="PO_UNIT" onKeyUp="jspt('PO_UNIT',this.value,event)" autocomplete="off" alt="MULTI" value="<?php echo $unit; ?>" tabindex="10"/></td>
												<td class="check" style="display:none !important"><input class="chkbox" type="checkbox" name="checkbox[]" title="chedk" id="chedk"></td>
											</tr>
											<?php
										}
										else
										{
											$i = 1;
											$item = 10;
											$PO = substr($_REQUEST['po'], 0, -1);
											$Arr_PO = explode("@", $PO);

											foreach($Arr_PO as $key=>$val)
											{
												$item = 10 *$i;
												$cusLenth = count($item);
												if($cusLenth < 6) { $item = str_pad((int) $item, 6, 0, STR_PAD_LEFT); }
												else { $item = substr($item, -6); }
												$values = explode(",", $val);
												$purch_req = $values[0];
												$purch_req_item = $values[1];
                                                $purch_group = $values[3];
												$matetial = $values[4];
												$plant = $values[5];
												$unit = $values[6];
												$uom = $values[7];
                                                $sty = '';
                                                if($i===count($Arr_PO)){
                                                    $sty = 'style=""';
                                                }else{
                                                    $sty = 'style="display:none;"';
                                                   ?>
                                                    <script>
                                                    $('#pre').show();
                                                    </script>
                                                <?php
                                                }
                                                ?>
												<tr onClick="select_row('ids_<?php echo $i;?>')" <?php echo $sty; ?> class="ids_<?php echo $i;?> nudf">
													<td>
														<input type="text" name='PO_ITEM[]' readonly value="<?php echo $item; ?>" style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' id='itms<?php echo $i;?>' tabindex="6"/>
														<input type="hidden" name="PURCH_REQ[]" value="<?php echo $purch_req; ?>" />
														<input type="hidden" name="PURCH_REQ_ITEM[]" value="<?php echo $purch_req_item; ?>" />
													</td>
													<td><input type="text" id='MATERIAL<?php echo $i;?>' name='MATERIAL[]' readonly class="input-fluid validate[required] getval radiu" title="MATERIAL" alt="MULTI" tabindex="7" style="width:50%" value="<?php echo $matetial; ?>"/>
                                                        <!--<span class='minw9' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL<?php /*echo $i;*/?>','3@MAT1L')" style="display: none;" >&nbsp;</span>-->
                                                        <div class='minws1' onclick="lookup('Material', 'MATERIAL<?php echo $i;?>', 'material')" >&nbsp;</div>
                                                    </td>

													<td><input type="text" id='PLANT<?php echo $i;?>' readonly class="input-fluid validate[required] getval" name='PLANT[]' title="PLANT" onKeyUp="jspt('PLANT<?php echo $i;?>',this.value,event)" value="<?php echo $plant; ?>" autocomplete="off" alt="MULTI" style="width:50%" tabindex="8"/><div class='minws1' onclick="lookup('Plant', 'PLANT', 'plant'<?php echo $i;?>','0')" style="display: none;" >&nbsp;</div></td>
													<td><input type="text" style="width:90%;" readonly id='QUANTITY<?php echo $i;?>' class="input-fluid validate[required] getval radiu" name='QUANTITY[]' title="QUANTITY" onKeyUp="jspt('QUANTITY<?php echo $i;?>',this.value,event)" value="<?php echo $uom; ?>" autocomplete="off" alt="MULTI" tabindex="9"/></td>
													<td><input type="text" style="width:90%;" readonly id='PO_UNIT<?php echo $i;?>' class="input-fluid validate[required] getval radiu" name='PO_UNIT[]' title="PO_UNIT" onKeyUp="jspt('PO_UNIT<?php echo $i;?>',this.value,event)" value="<?php echo $unit; ?>" autocomplete="off" alt="MULTI" tabindex="10"/></td>
													<td class="check" style="display: none !important;"><input class="chkbox" type="checkbox" name="checkbox[]" title="chedk" id="chedk"></td>
												</tr>
												<?php
												$i++;
											}
										}
										?>
								</tbody>
							</table>
							</div>
							<table width="100%">
								<tr>
									<td>
										<span onclick="pre()" id="pre" class="btn" style="display:none">Previous</span>
										<span id="pre1" class="btn" style="display:none">Previous</span>
									</td>
									<td>
										<span onclick="nxt()" id="nxt" class="btn" style="float:right;display:none">Next</span>
										<span id="nxt1" class="btn" style="float:right;display:none">Next</span>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div>
					<br><input type="submit" value="<?php echo _SUBMIT ?>" id="btn-submit" class='btn btn-primary bbt'/>
				</div>
			</form>
		</div>
	</div>
</section>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
	function number(num)
	{		
		if(num!="")
		{
			var str = '' + num;
			while (str.length < 10) {
				str = '0' + str;
			}
			document.getElementById('VENDOR').value=str;
		}
	}
	$(document).ready(function() {
		jQuery("#validation1").validationEngine();
	});
</script>