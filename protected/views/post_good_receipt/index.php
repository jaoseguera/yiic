<style>
.table th,
.table td
{
	min-width:160px;
}
.bb
{
	background:#cecece !important;
}
.bb:hover
{
	background:#cecece !important;
}
.table th, .table tbody td{
display:table-cell;
}
.check
{
	display:none !important;
}
.input-fluid {
    height: 18px;
    width: 55% !important;
}
</style>
<script>
	$(document).ready(function(e) {
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

    var inc=0;
    var nut=0;
    function addRow(tableID)
	{
		inc=inc+1;
		
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
		var row = table.insertRow(rowCount);
		row.setAttribute('onclick', 'select_row("ids_'+inc+'")');
		row.setAttribute('class', 'ids_'+inc+' nudf');
		var colCount = table.rows[1].cells.length;
		//alert(table.rows[0].innerHTML);
		// var nut=Number(table.rows[rowCount-1].cells[1].childNodes[0].value);
		nut=nut+10;
		for(var i=0; i<colCount; i++)
		{
			var newcell = row.insertCell(i);
			//newcell.childNodes[0].insertBefore('hello');
			newcell.innerHTML = table.rows[1].cells[i].innerHTML;
			var ind=newcell.getElementsByTagName('input');
			if(ind[0].title=='che')
			{
				newcell.setAttribute('class', 'check');
			}
			
			//alert(newcell.childNodes[0].id);
			var ids=ind[0].id;
			ind[0].id=ids+nut;
			ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");
			if(ind[0].title=='Material')
			{
				var re=  newcell.getElementsByTagName('div');
				var met='MATERIAL'+nut;
				ind[0].setAttribute("onchange","jspt_new('"+met+"',this.value,event)");
				/*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
                re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");
			}
			if(ind[0].title=='PLANT')
			{
				var re=  newcell.getElementsByTagName('div');
				var plant='PLANT'+nut;
				re[0].setAttribute("onclick","lookup('Plant', '"+plant+"', 'plant')");
			}
			if(ind[0].title=='PO_NUMBER')
			{
				var re=  newcell.getElementsByTagName('div');
				var po_num='po_num'+nut;
				re[0].setAttribute("onclick","lookup('Purchase order number', '"+po_num+"', 'po_number');");
			}
			if(ind[0].title=='UOM')
			{
				var re=  newcell.getElementsByTagName('div');
				var entry='entry'+nut;
				re[0].setAttribute("onclick","lookup('UOM', '"+entry+"', 'uom');");
			}
			if(ind[0].title=='stge')
			{
				var re=  newcell.getElementsByTagName('div');
				var stge='stge'+nut;
				re[0].setAttribute("onclick","lookup('Storage Location', '"+stge+"', 'storgae_loc')");
                 			}
			if(ind[0].title=='item')
			{
				var numb=ind[0].value;
				ind[0].value='000'+(nut+10);
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
	
	function jspt_new(ids,myKey,e)
	{
		var id_append = ids.replace(/[^0-9\.]/g, '');
		if(ids.indexOf("MATERIAL") >= 0 && myKey.trim() != "")
		{
			$('#loading').show();
			$("body").css("opacity","0.4");
			$.ajax({
				type: "POST",
				url: "common/materialdes",
				data: "val="+myKey,
				success: function(html) 
				{
					//alert(html);
					$('#loading').hide();
					$("body").css("opacity","1"); 
					var str=html.split('@');
					if(str[0]=='S')
					{
						// $('#'+ids).parent('td').next('td').children('input').val(str[1]);
						$('#entry'+id_append).val(str[2]);
					}
					else
					{
						//jAlert(str[1],'Message');
					}
				}
			});
		}
	}
	
	function deleteRow(tableID)
	{
		if($(document).width()<100)
		{
			var num=0;
			$('.nudf').each(function(index, element)
			{
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
                                $('#ids_'+(sio[1]-1)).show();
						});
					}
				}
				nur++;
			});
		}
		else
		{
			try
			{
				var cunt=0;
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				for(var i=0; i<rowCount; i++)
				{
					var row = table.rows[i];
					var chkbox = row.cells[0].childNodes[0];
					if(chkbox.id!='head')
					{
						if(chkbox.checked)
							cunt=cunt+1;
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
			}catch(e)
			{
			}
		}
	}
	
	function number(num)
	{
		if(num!="")
		{
			var str = '' + num;
			while (str.length < 10)
			{
				str = '0' + str;
			}
			document.getElementById('PARTN_NUMB').value=str;
		}
	}
	
	function select_row(ids)
	{
		if($('.'+ids).hasClass('bb'))
		{
			$('.'+ids).removeClass('bb');
			$('.'+ids).find('input:checkbox').attr('checked', false);
		}
		else
		{
			$('.'+ids).addClass('bb');
			$('.'+ids).find('input:checkbox').attr('checked', true);
		}
	}
	
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
	
	function create_post_goods()
	{
        /*
		var de=0;
		if(de!=1)
		{
			$('#validation input').each(function(index, element) {
			var names=$(this).attr('name');
			if($(this).attr('alt')=='MULTI')
			{
				names=$(this).attr('id');
			}
			var values=$(this).val();
			
			if(values!="")
			{
				var cook=$.cookie(names);
				var name_cook=values;
				if(cook!=null)
				{
					name_cook=cook+','+values;
				}
				if($.cookie(names))
				{
					var str=$.cookie(names);
					var n=str.search(values);
					if(n==-1)
					{
						$.cookie(names,name_cook);
					}
				}
				else
				{
					$.cookie(names,name_cook,{ expires: 365 });
				}
			}
			});
		}
		*/
		$('#loading').show();
		$("body").css("opacity","0.4"); 
        $("body").css("filter","alpha(opacity=40)"); 
		$.ajax({
			type:'POST', 
			url: 'post_good_receipt/post_good_receipt', 
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
</script>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$customize = $model;

?><div style="font-size:14px; color:#900; margin:0px 0px 30px 60px;"></div>
<section id="formElement" class="utopia-widget utopia-form-box section">
    <div class="row-fluid">
		<div class="utopia-widget-content">
            <h4 class="filter_note" >Note : All fields are mandatory</h4>
			<form id="validation" action="javascript:create_post_goods()" class="form-horizontal">
				<input type="hidden" name='page' value="bapi">
				<input type="hidden" name="url" value="goodsreceipt"/>
				<input type="hidden" name="key" value="goodsreceipt"/>
				<!--
					<div class="span5 utopia-form-freeSpace">
						<fieldset>
							<div class="control-group">
								<label class="control-label cutz" alt="Reference Number" for="date"><?php // echo Controller::customize_label('Reference Number');?><span> *</span>:</label>
								<div class="controls">
									<input type="text" class="input-fluid  validate[required]" name="REF_DOC_NO" value="" tabindex="1" onKeyUp="jspt('REF_DOC_NO',this.value,event)" autocomplete="off" id="REF_DOC_NO">
								</div>
							</div>
						</fieldset>
					</div>
				-->
				<div class="row-fluid">
					<div class="span12">
						<div class="utopia-widget-content">
							<div class="row-fluid">
								<div>
									<input type="button" value="Add New Lines" class='btn' onclick="addRow('dataTable')"/>
									<a class="btn" href="#" onclick="deleteRow('dataTable')">
										<i class="icon-trash icon-white"></i>Delete item
									</a>
								</div>
								<br>
								<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
								<table class="table table-bordered" id="dataTable">
									<thead>
										<tr>
											<th class="check"><input class="utopia-check-all" type="checkbox" id="head"></th>
											<th>PO Number</th>
											<th>PO Item Number</th>
											<th>Material</th>
											<th>Quantity</th>
											<th>UOM</th>
											<th>Plant</th>
											<th>Storage Location</th>
										</tr>
									</thead>
									<tbody>
										<tr onClick="select_row('ids_0')" class="ids_0 nudf" >
											<td class="check"><input class="chkbox" type="checkbox" name="checkbox[]" title="che" id="chedk"></td>
											<td><input type="text"  class="input-fluid validate[required,custom[number]] getval" name='PO_NUMBER[]' id="po_num" onKeyUp="jspt('po_num',this.value,event)" autocomplete="off" title="PO_NUMBER" style="width: 55% !important;" alt="MULTI" tabindex="8"/><div onclick="lookup('Purchase order number', 'po_num', 'po_number');" class="minws1">&nbsp;</div></td>
											<td><input type="text" name='PO_ITEM[]' value="00010"  title="item" class='input-fluid validate[required,custom[number]]' id="it" tabindex="2"/></td>
											<td><input type="text"  id='MATERIAL' name='MATERIAL[]' style="width: 55% !important;" class="input-fluid validate[required] getval radiu" title="Material" onKeyUp="jspt('MATERIAL',this.value,event)" onchange="jspt_new('MATERIAL',this.value,event)" autocomplete="off" alt="MULTI" tabindex="3"/>
                                                <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                                <div class='minws1' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</div>
                                            </td>
											<td><input type="text"  id='ENTRY_QNT' class="input-fluid validate[required] getval radiu" name='ENTRY_QNT[]' title="UNIT" onKeyUp="jspt('ENTRY_QNT',this.value,event)" autocomplete="off" alt="MULTI" tabindex="6"/></td>
											<td><input type="text"  class="input-fluid validate[required] getval" name='ENTRY_UOM[]' id="entry" title="UOM" onKeyUp="jspt('entry',this.value,event)" autocomplete="off" alt="MULTI" style="width: 55% !important;" tabindex="7"/><div onclick="lookup('UOM', 'entry', 'uom');" class="minws1">&nbsp;</div></td>
											<td><input type="text" id='PLANT'  class="input-fluid validate[required] getval" name='PLANT[]' style="width: 55% !important;" title="PLANT" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" alt="MULTI" tabindex="4"/>
                                                <!--<span  class='minw9'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span></td>-->
                                            <div class='minws1' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</div>
											<td><input type="text"  class="input-fluid validate[required,custom[number]] getval" style="width: 55% !important;" name='STGE_LOC[]' id="stge" onKeyUp="jspt('stge',this.value,event)" autocomplete="off" alt="MULTI" tabindex="5" title="stge"/>
                                                <div class='minws1' onclick="lookup('Storage Location', 'stge', 'storgae_loc')" >&nbsp;</div>
                                                <!--<span  class='minw9'  onclick="tipup('BUS2017','CREATEFROMDATA','GOODSMVTITEM','STGE_LOC','Storage Location','stge','1')" >&nbsp;</span>--></td>
										</tr>
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
							<div>
								<br>
								<input type="submit" value="<?php echo _SUBMIT ?>" class='btn btn-primary' tabindex="9"/>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		jQuery("#validation").validationEngine();
	});
</script>