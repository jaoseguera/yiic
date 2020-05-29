<?php
$doc_num = "";
$itm_num = "";

$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
    $doc_num = "10000526";
    $itm_num = "";
}
if(isset($_REQUEST['DOC_NUM']) && $_REQUEST['DOC_NUM'] != "")
{
    $doc_num = $_REQUEST['DOC_NUM'];
    $itm_num = "";
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
        <form id="validation_new" method="post" onsubmit='return getBapitable("table_todays1","DOCUMENT_FLOW_ALV_STRUC","example1","L","nones@<?php echo $s_wid; ?>","Document_flow","submit");' class="form-horizontal" >
            <input type="hidden" name='page' value="bapi">
            <input type="hidden" name="url" value="document_flow"/>
            
            <input type="hidden" class="tbName_example" value="DOCUMENT_FLOW_ALV_STRUC"/>
			<fieldset class="span12 iphone_sales_textBox" >
				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Document Number" for="input01"><?php echo Controller::customize_label('Document Number');?><span> *</span>:</label>
						<input alt="Document Number" class="input-fluid validate[required] radius" type="text" name='DOCUMENT_NUMBER' value="<?php echo $doc_num;?>" id="DOCUMENT_NUMBER" autocomplete="off">
					</fieldset>
				</div>

				<div class="span3 utopia-form-freeSpace">
					<fieldset>
						<label style="text-align: left;" class="control-label cutz" alt="Item Number" for="inputError"><?php echo Controller::customize_label('Item Number');?>:</label>
						<input alt="Item Number" id='ITEM_NUMBER' type="text" name='ITEM_NUMBER' class="input-fluid radius" value="<?php echo $itm_num;?>" autocomplete="off">
					</fieldset>
				</div>
			</fieldset>

			<div class="span3 utopia-form-freeSpace" style="margin-bottom:10px; float:right; padding-left:33px;">
				<input type="submit" name="submit" id="submit" class="btn btn-primary span3 bbt back_b iphone_sales_submit iphone_Sale_submit" style="min-width:90px;" value="<?php echo _SUBMIT ?>" />
			</div>
        </form>
    </div>
</div>
</section>
	<div class="container-fluid" style="display:none;">
		<div class="row-fluid edge2">
			<div class="span12">
				<ul id="menu_tab" class="nav nav-tabs menu_tab" >
						<li id='df_li_1' class="active count_li">
							<a href="#tab1" data-toggle="tab" id='t1' onClick='return getBapitable("table_todays1","DOCUMENT_FLOW_ALV_STRUC","example1","L","nones@<?php echo $s_wid; ?>","Document_flow","submit")'>Header</a>
						</li>
						<li id='df_li_2' class="count_li">
							<a href="#tab2" data-toggle="tab" id='t2' onClick='getBapitable("table_deliv1","DOCUMENT_FLOW_ALV_STRUC","example2","L","nones@<?php echo $s_wid;?>","Document_flow","tab")'>Items</a>
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
						<div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
						<div class='csv_link exp_link tab_lit' onClick="csv('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link exp_link tab_lit' onClick="excel('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
						<div  style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
						<div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
						<div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example1_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
						<div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
					</div>
					
					<div class="tab-pane active edge1" id="tab1" style="overflow-y:hidden;padding-bottom:75px;">			
							<div class="head_icons" style="width:981px"><span id='post' tip="Table columns" class="yellow" onClick="table_cells('example1')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head">
									<tr>
										<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example1_table')"></span></td>
										<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example1')"></span></td>
										<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example1')"></span></td>
										<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example')"></span></td>
										<td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example1_table')"></span></td>
										<td><span id='filtes1' tip='&nbsp; Filters '  class="yellow" onClick="filtes1('example1')"></span></td>
									</tr>
								</table>
							</div>								
							<div id='table_todays1'></div>
							<div class='testr table_todays1' onClick='getBapitable("table_todays1","BAPIEBANC","example1","S","nones@<?php echo $s_wid; ?>","Search_purchase_requisition","show_more")'>Show more</div>
							<div id='example1_num' style="display:none;">10</div>
					</div>
					<div class="tab-pane" id="tab2" style="overflow-y:hidden;padding-bottom:75px;">
						<input type="hidden" class="tbName_example2" value="BAPIDLVHDR" />
						<div class="row-fluid edge1" style="overflow-y:hidden;padding-bottom:55px;">
							<div class="head_icons"><span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example2')"></span>
								<table cellpadding='0px' cellspacing='0px' class="table_head">
									<tr>
										<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example2_table')"></span></td>	
										<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example2')"></span></td>
										<td><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example2')"></span></td>
										<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example2')"></span></td>
										<td><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example2_table')"></span></td>
										<td><span id='filtes1' tip='&nbsp; Filters ' class="yellow" onClick="filtes1('example2')"></span></td>
									</tr>
								</table>
							</div>
							<div id="table_deliv1"></div>
							<?php /*if($rowsag5>10) 
							{*/
								?><div class='testr table_deliv1' onClick='getBapitable("table_deliv1","BAPIEBANC","example2","S","nones@<?php echo $s_wid;?>","Search_purchase_requisition_Rel","show_more")'>Show More</div><!-- Sales_order_dashboard_delivery -->
								<div id='example2_num' style="display:none;">10</div><?php 
						// } 
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Maincontent end -->
<div id='export_table' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div>
<script>
$(document).ready(function(e) {
    jQuery("#validation_new").validationEngine();
	
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
            tableSess: 'table_todays1',
            scroll: true
        });
    })
    var wids=$('.table').width();
    $('.head_icons').css({
        width:wids+'px'
    });
});
var sd='';
function thisrow(id,ids,event)
{
	var table_name=$(id).closest('table').attr('alt');
	
	if(event.shiftKey==1) {
	if($(id).hasClass('table_items'))
	{
		$(id).removeClass('table_items');
		$(id).children('td').each(function(index, element) {
			//alert($(this).html());
           	if($(this).children('div').hasClass('poc'))
			{
				var ss=sd.replace($(this).children('div').attr('alt')+'@','')
				sd=ss;
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
				sd+=$(this).children('div').attr('alt')+'@';
			}
	 });
		

}
 
  }
  else
  {
	
	  
	  	$(id).parent('tbody').children('tr').each(function(index, element) {
				
        if($(this).hasClass('table_items'))
		{
			$(this).removeClass('table_items');
sd='';
				
		}
    });
	if($(id).hasClass('table_items'))
	{
		$(id).removeClass('table_items');
		sd='';
	
	}
	else
	{
		$(id).addClass('table_items');
		$(id).children('td').each(function(index, element) {
			//alert($(this).html());
           	if($(this).children('div').hasClass('poc'))
			{
				sd+=$(this).children('div').attr('alt')+'@';
			}
	 });
		

}
  
  }
	 // alert(sd);
	$('.table_items').bind("contextmenu",function(e){ return false; });
	$('.ccdiv').remove();
$('.table_items').mousedown(function(event) {
	if(event.which==3)
	{
		//alert(event.pageY);
		$('.ccdiv').remove();
		var y=event.pageY;
		var x=event.pageX;
	$(this).append('<div style="border:1px solid #cecece;cursor:pointer;width:70px;padding:3px;background:#fff;position:absolute;top:'+y+'px;left: '+x+'px;" class="ccdiv" onClick="poc(\''+sd+'\')">Create PO</div>');
		
	}
	else
	{
		//$('.ccdiv').remove();
	}
	
})
	
	

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
			jAlert(html,'SAP System Message');
		}
		});
		}
	});
	
}
$(document).ready(function(e) {
	$('#out_table #menu_tab').find('li').click(function(index) {
		$(this).closest("#menu_tab").find(".count_li").removeClass("active");
		$(this).addClass("active");
		$("#out_table #tab-content .tab-pane").hide();
		ind = eval($(this).index())+1;
		$('#out_table .container-fluid #tab'+ind).show();
		
		if($(this).index() == 0)
		{
			// $('#out_table .container-fluid #tab1').show();
		}
		else
		{
			
		}
		return false;
	});
	<?php
		if(isset($_REQUEST['DOC_NUM']) && $_REQUEST['DOC_NUM'] != "")
			echo 'jQuery("#validation_new #submit").trigger("click");';
			// echo 'jQuery("#validation_new").submit();';
		if(isset($_REQUEST['titl']))
		{
			echo 'parent.titl("'.$_REQUEST["titl"].'");
			parent.subtu("'.$_REQUEST["tabs"].'");';
		}
	?>
});
</script>
<?php // }  ?>