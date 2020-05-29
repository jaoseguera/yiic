<?php
$PUR_GROUP = "";
$MATERIAL = "";
$PLANT = "";

$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
    $PUR_GROUP = "100";
    $MATERIAL = "N100015";
    $PLANT = "1000";
}
?><script>
function cancels()
{
    $('.cancel').hide();
}

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
        document.getElementById('custom').value=str;
    }
}
$(document).ready(function () {
    $(".read").attr('readonly','readonly');
})
$(document).ready(function () {
    $(".read").attr('readonly','readonly');
    $('#edit').click(function () {

        $(".input-fluid").removeAttr('readonly');
        $('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit">Save</button>');
    })
})

</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader2.gif' style="display:none"><?php 
$this->renderPartial('smarttable',array('count'=>$count));
$customize = $model;
$table_th = "";
$table_td = "";
$th_example = '';
?>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box" style="padding-bottom:18px;">
<div class="row-fluid">
    <div class="utopia-widget-content" style="z-index:100;">
        <h4 class="filter_note">Note : Use at least one filter for fast search results</h4>
        
		<form id="validation" action="javascript: check_val();" method="post" class="form-horizontal" >
            <input type="hidden" name='page' value="bapi">
            <input type="hidden" name="url" value="search_purchase_requisition"/>
            <input type="hidden" class="tbName_example" value="BAPIEBANC"/>
			
			<fieldset class="span12 iphone_sales_textBox">
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Requisition Number" for="input01"><?php echo Controller::customize_label('Requisition Number');?>:</label>
						<input alt="Requisition Number" class="input-fluid radius" type="text" name='REQ_NUMBER' value="<?php echo $REQ_NUMBER; ?>" maxlength='10' onKeyUp="jspt('REQ_NUMBER',this.value,event)" autocomplete="off" id="REQ_NUMBER">
					</fieldset>
				</div>
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Purchase Group" for="input01"><?php echo Controller::customize_label('Purchase Group');?><span> *</span>:&nbsp;</label>
						<input alt="Purchase Group" class="input-fluid radius validate[required]" type="text" name='PUR_GROUP' value="<?php echo $PUR_GROUP; ?>" maxlength='4' onKeyUp="jspt('PUR_GROUP',this.value,event)" autocomplete="off" id="PUR_GROUP">
                        <span class='minw3' onclick="lookup('Purchasing Group', 'PUR_GROUP', 'purch_group')" >&nbsp;</span>
                        <!--<span class='minw3' onclick="tipup('BUS2012','CREATEFROMDATA','POHEADER','PUR_GROUP','Purchasing Group','PUR_GROUP','0')" >&nbsp;</span>-->
					</fieldset>
				</div>
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Material" for="inputError"><?php echo Controller::customize_label('Material');?>:</label>
						<input alt="Material" class="input-fluid radius getval" type="text" name='MATERIAL' value="<?php echo $MATERIAL; ?>" id="MATERIAL" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off">
                        <!--<span  class='minw3' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                        <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
					</fieldset>
				</div>
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Plant" for="inputError"><?php echo Controller::customize_label('Plant');?><span> *</span>:&nbsp;</label>
						<input alt="Plant" class="input-fluid radius validate[required]" type="text" name='PLANT' value="<?php echo $PLANT; ?>" maxlength='4' onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT">
                        <span class='minw' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</span>
                        <!--<span class='minw3' onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
					</fieldset>
				</div>
			</fieldset>
			
			<fieldset class="span12 iphone_sales_textBox">
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Release Group" for="input01"><?php echo Controller::customize_label('Release Group');?>:</label>
						<input alt="Release Group" class="input-fluid radius" type="text" name='REL_GROUP' value="<?php echo $REL_GROUP; ?>" maxlength='4' onKeyUp="jspt('REL_GROUP',this.value,event)" autocomplete="off" id="REL_GROUP">
					</fieldset>
				</div>
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Release Code" for="input01"><?php echo Controller::customize_label('Release Code');?>:</label>
						<input  alt="Release Code" class="input-fluid radius" type="text" name='REL_CODE' value="<?php echo $REL_CODE; ?>" maxlength='4' onKeyUp="jspt('REL_CODE',this.value,event)" autocomplete="off" id="REL_CODE">
					</fieldset>
				</div>
			</fieldset>
			
			<div class="span3 utopia-form-freeSpace" style="margin-bottom:10px; float:right; padding-left:33px;">
				<button class="btn btn-primary span1 bbt back_b" type="submit" id='submit' style='min-width:80px;'>Submit</button>
			</div>
        </form>
    </div>
</div>
</section>
<!--
<div>
	<div class="utopia-widget-content edge" style="overflow-y:hidden;margin-top:30px;">
		<?php // $this->renderPartial('tabletop'); ?>
		<div id='table_today1'></div>
		<div class='testr table_today1' onClick='getBapitable("table_today1","BAPIEBANC","example1","S","nones@<?php // echo $s_wid; ?>","approve_purchase_requisition","show_more")'>Show more</div>
		<div id='example1_num' style="display:none;">10</div>
	</div>
</div>
-->
	<div class="container-fluid" style="display:none;">
		<div class="row-fluid edge2">
			<div class="span12">
				<ul id="menu_tab" class="nav nav-tabs menu_tab" >
						<li id='li_1' class="active count_li">
							<a href="#tab1" data-toggle="tab" id='t1' onClick='getBapitable("table_today1","BAPIEBANC","example1","L","nones@<?php echo $s_wid; ?>","approve_purchase_requisition","submit")'>Approve Requisitions</a>
						</li>
						<li id='li_2' class="count_li">
							<a href="#tab2" data-toggle="tab" id='t2' onClick='getBapitable("table_convert_PO","BAPIEBANC","example3","L","nones@<?php echo $s_wid;?>","Search_purchase_requisition_PO","submit")'>Ready for Converting to PO</a>
						</li>
						<li id='menus' class="more_menu" style="float:right; margin-top:-1px; margin-right:10px">
							<div id='pos_tab'></div>
							<span style="display:none;"></span>
						</li>
				</ul>
				<div id="tab-content" class="tab-content">
					<div class="labl pos_pop">
						<div class='pos_center'></div>
						<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
						<button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
					</div>
					<div id="exp_pop" style="display:none;" class="labl">
						<div style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
						<div class='csv_link exp_link tab_lit' onClick="csv('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link exp_link tab_lit' onClick="excel('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
						<div style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
						<div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
					</div>			
					<div class="tab-pane active edge1" id="tab1" style="overflow-y:hidden;padding-bottom:55px;">			
						<div class="head_icons" style="width:981px"><span id='post' tip="Table columns" class="yellow" onClick="table_cells('example1')"></span>
							<table cellpadding='0px' cellspacing='0px' class="table_head">
								<tr>
									<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example1_table')"></span></td>
									<td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example1')"></span></td>
									<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example1')"></span></td>
									<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example1')"></span></td>
									<td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example1_table')"></span></td>
									<td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example1')"></span></td>
								</tr>
							</table>
						</div>								
						<div id='table_today1'></div>
						<div class='testr table_today1' onClick='getBapitable("table_today1","BAPIEBANC","example1","S","nones@<?php echo $s_wid; ?>","approve_purchase_requisition","show_more")'>Show more</div>
						<div id='example1_num' style="display:none;">10</div>
					</div>
					<div class="tab-pane" id="tab2" style="overflow-y:hidden;padding-bottom:55px;">
						<input type="hidden" class="tbName_example3" value="BAPIDLVHDR" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons"><span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example3')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head">
									<tr>
										<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example3_table')"></span></td>	
										<td><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example3')"></span></td>
										<td><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example3')"></span></td>
										<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example3')"></span></td>
										<td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example3_table')"></span></td>
										<td><span id='filtes1' tip='&nbsp; Filters ' class="yellow" onClick="filtes1('example3')"></span></td>
									</tr>
								</table>
							</div>
							<div id="table_convert_PO"></div>
							<?php /*if($rowsag5>10) 
							{*/
								?><div class='testr table_convert_PO' onClick='getBapitable("table_convert_PO","BAPIEBANC","example3","S","nones@<?php echo $s_wid;?>","Search_purchase_requisition_PO","show_more")'>Show More</div><!-- Sales_order_dashboard_delivery -->
								<div id='example3_num' style="display:none;">10</div><?php 
						// } 
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Maincontent end -->
<div id='export_table' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script>
$(document).ready(function() { jQuery("#validation").validationEngine(); });
function check_val()
{
	jQuery("#validation").validationEngine();
	$('#table_today1').html('');
    if($('#li_2').hasClass('active')==true){
        $('#li_1').removeClass('active');
        $('#li_2').addClass('active');
        getBapitable("table_convert_PO","BAPIEBANC","example3","L","nones@<?php echo $s_wid;?>","Search_purchase_requisition_PO","submit");
    }else{
	    getBapitable("table_today1","BAPIEBANC","example1","L","nones@<?php echo $s_wid; ?>","approve_purchase_requisition","submit");
    }
}
$(document).ready(function(e) {
	
    $(".head_icons").hide();
	$(".testr").text('');
    $('.search_int').keyup(function () {
        sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
    })
    data_table('example1');
    $('#example1').each(function(){
        $(this).dragtable({
            placeholder: 'dragtable-col-placeholder test3',
            items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
            appendTarget: $(this).parent(),
            tableId: 'example1',
            tableSess: 'table_today1',
            scroll: true
        });
    })
    var wids=$('.table').width();
    $('.head_icons').css({
        width:wids+'px'
    });
});

var sd = '';
function thisrow(id, ids, event)
{
	var table_name = $(id).closest('table').attr('alt');
	
	// if(event.shiftKey==1)
	if(table_name == 'Search_purchase_requisition_PO')
	{
		if($('.ccdiv').is(':visible') == false)
		{
			if($(id).hasClass('table_items'))
			{
				$(id).removeClass('table_items');
				$(id).children('td').each(function(index, element) {
					//alert($(this).html());
					if($(this).children('div').hasClass('poc'))
					{
						var ss = sd.replace($(this).children('div').attr('alt')+'@','')
						sd = ss;
					}
				});
			}
			else
			{
				$(id).addClass('table_items');
				$(id).children('td').each(function(index, element) {
					//alert($(this).html());
					if($(this).children('div').hasClass('poc'))
					{
						sd += $(this).children('div').attr('alt')+'@';
					}
				});
			}
		}
		
		 //alert(sd);
		$("table[alt='Search_purchase_requisition_PO']").find('tr').bind("contextmenu", function(e){ return false; });
		$('.ccdiv').remove();
		$("table[alt='Search_purchase_requisition_PO']").find('tr').mousedown(function(e) {
			//console.log($(this).attr('class'));
			if(e.which == 3 && $(this).hasClass('table_items'))
			{
				//alert(event.pageY);
				back_name = "approve_purchase_requisition";
				$('.ccdiv').remove();
				var y=e.pageY;
				var x=e.pageX;
				//$(this).append('<div style="border:1px solid #cecece;cursor:pointer;width:70px;padding:3px;background:#fff;position:absolute;top:'+y+'px;left: '+x+'px;" class="ccdiv" onClick="poc(\''+sd+'\')">Create PO</div>');
				doc_s = "<div style='border:1px solid #cecece;cursor:pointer;width:70px;padding:3px;background:#fff;position:absolute;top:"+y+"px;left: "+x+"px;' class='ccdiv exp_menu' id='Create_PO' name='"+back_name+"' onclick='side_links(\"Create_PO\")' alt='create_purchase_order/create_purchase_order/?po="+sd+"&titl=Create Purchase Order&tabs=create_purchase_order'>Create PO</div>";
				$(this).append(doc_s);
			}
			else
			{
				//$('.ccdiv').remove();
			}
		});
	}
	else
	{
		$(id).parent('tbody').children('tr').each(function(index, element) {
			if($(this).hasClass('table_items'))
				$(this).removeClass('table_items');
		});
		
		if($(id).hasClass('table_items'))
			$(id).removeClass('table_items');
		else
			$(id).addClass('table_items');
	}
}
function poc(id)
{
	//alert(id);
	jPrompt1('Reference :','','Please enter reference',function(r)
	{
		if(r)
		{
			$('#loading').show();
			$("body").css("opacity","0.4");
			$("body").css("filter","alpha(opacity=40)");
			$.ajax({
				type:'POST',
				data:'reff='+r+'&po='+id,
				url:'search_purchase_requisition/createpo',
				success:function(html)
				{
					$('#loading').hide();
					$("body").css("opacity","1");
					jAlert(html, 'SAP System Message');
				}
			});
		}
	});
}
</script>
<?php // }  ?>