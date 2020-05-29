
<?php
$VENDOR="";
$MATERIAL="";
$PLANT="";

$SYSNR = Yii::app()->user->getState('SYSNR');
$SYSID = Yii::app()->user->getState('SYSID');
$CLIENT = Yii::app()->user->getState('CLIENT');

if($SYSNR.'/'.$SYSID.'/'.$CLIENT=='10/EC4/210')
{
	$VENDOR="300000";
	$VENDORLenth = count($VENDOR);
	if($VENDORLenth < 10 && $VENDOR!='') { $VENDOR = str_pad((int) $VENDOR, 10, 0, STR_PAD_LEFT); } else { $VENDOR = substr($VENDOR, -10); }
	$MATERIAL="NIPRO001";
	$PLANT="1000";
}
?><div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$this->renderPartial('smarttable');
$customize = $model;
?><section id="formElement" class="utopia-widget utopia-form-box section" style="padding-bottom:20px;">
    <div class="row-fluid">
        <div class="utopia-widget-content" >
        <h4 class="filter_note">Note : Use at least one filter for fast search results</h4>
		 <form id="validation" action="" class="form-horizontal" >
               
        <div class="span12 utopia-form-freeSpace">
                
                      <fieldset>
                      <div class="span3 utopia-form-freeSpace">
              
                   <fieldset>
   <label class="control-label1 cutz" alt="Vendor Number" for="input01"><?php echo Controller::customize_label('Vendor Number');?>:</label>
                                <input type="hidden" name='page' value="bapi">
                                <input type="hidden" name="url" value="inforecords"/>
                                <input type="hidden" name="bapiName" value="BAPI_INFORECORD_GETLIST"/>
				<input type="hidden" class="tbName_example" value="BAPIEINA"/>
 <input alt="Vendor Number" class="input-fluid validate[required,custom[ven]]" type="text" name='VENDOR'  value="<?php echo $VENDOR;?>" tabindex="1" onKeyUp="jspt('VENDOR',this.value,event)" autocomplete="off" id="VENDOR" onchange="number(this.value)">
 <!--<span  class='minw3'  onclick="tipup('BUS2093','GETDETAIL1','RESERVATIONITEMS','VENDOR','Vendor Number','VENDOR','4@KREDA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Vendor Number', 'VENDOR', 'vendor')" >&nbsp;</span>
                                          </fieldset></div>
                                          
                                           <div class="span3 utopia-form-freeSpace">
              
                   <fieldset>
                               <label class="control-label1 cutz" alt="Material" for="input01"><?php echo Controller::customize_label('Material');?>:</label>
                              
<input alt="Material" type="text" style="width:90%;" id='MATERIAL' name='MATERIAL' class="input-fluid validate[required] getval radiu" title="Material" tabindex="2" onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" value="<?php echo $MATERIAL;?>"/>
<!--<span  class='minw3'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                       <span class='minw' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>

                                          </fieldset></div>
                       
                       
                                                                <div class="span3 utopia-form-freeSpace">
              
                   <fieldset>
                               <label class="control-label1 cutz" alt="Plant" for="input01"><?php echo Controller::customize_label('Plant');?>:</label>
                              
 <input alt="Plant" class="input-fluid validate[required,custom[pla]]" type="text" name='PLANT'  value="<?php echo $PLANT;?>" tabindex="3" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" id="PLANT">
                       <span class='minw3' onclick="lookup('Plant', 'PLANT', 'plant')" >&nbsp;</span>
 <!--<span  class='minw3'  onclick="tipup('BUS2012','CREATEFROMDATA','POITEMS','PLANT','Plant','PLANT','0')" >&nbsp;</span>-->
                                          </fieldset></div>
                       
                                  <div class="span3 utopia-form-freeSpace">
              
                   <fieldset>                         
                           
 <button class="btn btn-primary span3 bbt iphone_inf_rec" type="submit" id="subt" style="min-width:80px;margin-top: 23px;" tabindex="4" onclick='return getBapitable("info_gen","BAPIEINA","example","L","nones@<?php echo $s_wid;?>","Inforecords","submit")'>Submit</button>
                                          </fieldset></div>
								
                  
                        </fieldset>
                
            </div>
           
                           
       
      
</form>
        </div>
    </div>
    </section>
        <?php
	/*if(isset($_REQUEST['VENDOR'])&&$SalesOrder2==NULL)
{ */
	?>
     <div class="utopia-widget-content utopia-form-tabs" id="tabShow" style="display:none;">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab" id='link1'>Inforecord General</a></li>
                            <li><a href="#tab2" data-toggle="tab" id='link2' onClick='return getBapitable("info_pur","BAPIEINE","example2","L","nones@<?php echo $s_wid;?>","Inforecord_Purchase_Org","tab")'>Inforecord Purchase Org</a></li>
                        </ul>
                        <div class="tab-content">
                         <div class="labl pos_pop">
<div class='pos_center'>
</div>
<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
<button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>

</div>
<!--<div id="exp_pop" style="display:none;" class="labl">
 <div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:5px;'><img src="../images/csv.png">&nbsp;Csv</div>
<div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:5px;'><img src="../images/excel.png">&nbsp;Excel</div>
<div class='pdf_link exp_link'  style='padding:5px;'><a href="../pdf/pdf.php"   target="_blank"><img src="../images/pdf.png">&nbsp;Pdf</a></div>
</div>-->

<div id="exp_pop" style="display:none;" class="labl">
    <div  style='padding:1px;'><h4 style="color:#333333">Export All</h4></div>
    <div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
    <div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
    <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
    <div  style='padding:1px;'><h4 style="color:#333333">Export View</h4></div>
    <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
    <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
    <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
</div>

<div class="tab-pane active" id="tab1">
<div class="head_icons">
<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example')"></span>
<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example_table')"></span></td>
<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example')"></span></td>
<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example')"></span></td>
<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example')"></span></td>
<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example_table')"></span></td>
</tr></table>
 
 
</div>
<div id='info_gen'>
                                <!--
								<table  class="table table-striped table-bordered" id="example" alt="Inforecords">
<?php 

$technical=$model;
$t_headers=Controller::technical_names('BAPIEINA');
$hs=0;
for($i=1;$i<=$count_g;$i++)
{
	
	
	$json_de=urlencode(json_encode($aert[$i]));
	//var_dump($json_de);
	$ej=$result[$i];
	if($hs==0) { 
?>
      <thead>
	<tr>
	<?php 
	foreach($ej as $inner=>$value)
	{
		?>
	<th onclick="rowShort('<?php echo $inner;?>',this,'BAPIEINA','info_gen')"><div class="example_<?php  echo $inner;?> cutz" alt='<?php echo $t_headers[$inner];?>'><span class="ddrg dragtable-drag-handle">&nbsp;</span><span class="notdraggable"><?php echo Controller::customize_label($t_headers[$inner]);?></span></div>
    <div class="example_th example_<?php  echo $inner;?>_hid" style="display:none;" name="<?php  echo $inner;?>"><?php  echo $t_headers[$inner];?></div>
	<div class="example_tech" style="display:none;"><?php  echo $inner."@".$t_headers[$inner];?></div>
    </th>
	<?php
	 } 
	 ?>
	</tr>
    </thead>
    <?php
	 } 
	 if($hs==0) {?>
     <tbody>
    <?php } ?>

<tr Onclick="thisrow(this,'<?php echo $i;?>',event)">
<?php
	foreach($ej as $inner=>$value)
	{
		
?>
	<td><?php if($inner=='MATERIAL')
		{ ?>
        
        <div  id="<?php echo trim($value);?>" style="cursor:pointer;color:#00AFF0;">
    
<div  onClick="show_info_rec('<?php echo $value;?>','<?php echo $json_de;?>','inforecords')" title=""><?php echo $value;?></div>
</div>
		<?php }
		else
		{
	 if (is_numeric(trim($value))) {
	             echo round(trim($value),2);
				}
		     else
				{
			echo $value;
				}
	 
		}?></td>
	<?php

	}
	
	?>
    </tr>
       <?php
	if($hs==(count($SalesOrder)-1)) {?>
    </tbody>
<?php }
$hs++;
}

?>

</table>
-->
</div>
<?php
// if(count($SalesOrder)>10){ ?>
<div class='testr info_gen' onClick='return getBapitable("info_gen","BAPIEINA","example","S","show_info_rec@<?php echo $s_wid;?>","Inforecords","show_more")'>Show more</div>
  <div id='example_num' style="display:none;">10</div>
  <?php
//}
  ?>
</div>
<div class="tab-pane" id="tab2">
<input type="hidden" class="tbName_example2" value="BAPIEINE"/>
<div class="head_icons" >
<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example2')"></span>
<table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
<td><span id='mailto' tip="Send as Mail" class="yellow" onClick="mailto('example_table2')"></span></td>
<td ><span id='tech' tip='Technical Names' class="yellow" onClick="tech('example2')"></span></td>
<td ><span id='sumr' tip="Sum of Netvalues" class="yellow" onClick="ssum('example2')"></span></td>
<td class="tab_lit"><span id='sort' tip='Multi Sort' class="yellow" onClick="sorte('example2')"></span></td>
<td ><span id='excel' tip=" &nbsp;Export " class="yellow" onClick="eporte('example2_table')"></span></td>
</tr></table>
</div>
<div id="info_pur"></div>
<?php
// if(count($SalesOrder1)>10) { ?>
<div class='testr info_pur' onClick='return getBapitable("info_pur","BAPIEINE","example2","S","nones@<?php echo $s_wid;?>","Inforecords","show_more")'>Show more</div>
  <div id='example2_num' style="display:none;">10</div>
  <?php
//}
?>
</div>
</div>
</div>
</div>
 
<div id='export_table' style="display:none"></div>
<div id='export_table_view_pdf' style="display:none"></div>
           <script>
		   $(document).ready(function() {
			   data_table('example');
			  $('#example').each(function(){
	
		$(this).dragtable({
		placeholder: 'dragtable-col-placeholder test3',
		items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
		appendTarget: $(this).parent(),
		tableId: 'example',
		tableSess: 'info_gen',
		scroll: true
	});
})
				$('#link1').click(function() {
                    $('.head_fix').remove();
                });
				$('#link2').click(function() {
                    $('.head_fix').remove();
                });
				
			   $('.head_fix').css({display:'none'});
				$(document).scroll(function()
			{
             $('.head_fix').css({display:'none'});
			$('#examplefix').css({display:'block'});
			});
			var wids=$('.table').width();
	$('.head_icons').css({
			width:wids+'px'
     });
		   });
           </script> 
                            <?php
// }
                            ?>




</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
  

       // jQuery("#validation").validationEngine();
    });

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

</script>