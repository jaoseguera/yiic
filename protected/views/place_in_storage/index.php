<?php
global $rfc,$fce;
$doc_date = "";
$doc_no = "";
$doc_year = "";



if (isset($_REQUEST['MATERIAL_DOC'])) {
   $doc_no = $_REQUEST['MATERIAL_DOC'];
   $doc_year = $_REQUEST['DOC_YEAR'];


    //GEZG 06/22/2018
	//Changing SAPRFC methods
	$options = ['rtrim'=>true];
	$res = $fce->invoke(["MATERIALDOCUMENT"=>$doc_no,
						"MATDOCUMENTYEAR"=>$doc_year],$options);    

   $ORDER_HEADERS_OUT=$res['GOODSMVT_HEADER'];
   $ORDER_ITEMS_OUT = $res['GOODSMVT_ITEMS'];
   //var_dump($ORDER_ITEMS_OUT);

   foreach ($ORDER_ITEMS_OUT as $keys) {
       if($keys['X_AUTO_CRE'] === 'X'){
        $vas[] = array('MATERIAL' => $keys['MATERIAL'], 'PLANT' => $keys['PLANT'], 'STGE_LOC' => $keys['STGE_LOC'],
           'BATCH' => $keys['BATCH'], 'ENTRY_QNT' => $keys['ENTRY_QNT'], 'ENTRY_UOM' => $keys['ENTRY_UOM']);
       }
   }

   //var_dump($ORDER_ITEMS_OUT);
   if (isset($ORDER_HEADERS_OUT)) {
      $doc_date = $ORDER_HEADERS_OUT['DOC_DATE'];

      $dd = substr($doc_date, -2);
      $mm = substr($doc_date, -4, 2);
      $year = substr($doc_date, -8, 4);
      $date_formate = $mm . "/" . $dd . "/" . $year;
   }
   $btn = "btn-primary";
}



/*$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');*/

$this->renderPartial('smarttable',array('count'=>6));
$customize = $model;
?>
<script>


</script>
<style>
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.check { display:none !important; }
.table th:nth-child(-n+6), .table td:nth-child(-n+6){
	display:table-cell;
	}

</style>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
   <div class="row-fluid">
      <div class="utopia-widget-content">
      
         <form id="validation3" action="javascript:submit_form('validation3')" class="form-horizontal">

            <div  class="form-horizontal">

               <div class="span5 utopia-form-freeSpace">
                  <fieldset>
                     <div class="control-group" >
                        <input type="hidden" name='page' value="bapi">
                        <input type="hidden" name="url" value="place_in_storage"/>
                        <input type="hidden" name="key" value="place_in_storage"/>
                         <label class="control-label cutz" for="input01" style="min-width: 190px;" alt='Material Document Number' ><?php echo Controller::customize_label('Material Document Number'); ?><span> *</span>:&nbsp;</label>

                        <div class="controls">
                           <input  id='MATERIAL_DOC' class="input-fluid validate[required] getval" type="text" name='MATERIAL_DOC' value="<?php echo $doc_no; ?>">
                            <span class='minw' onclick="material_doc_lookup('Material Document', 'MATERIAL_DOC','material_document_number')" >&nbsp;</span>
                        </div>
                     </div>

                  </fieldset>
               </div>
                <div class="span4 utopia-form-freeSpace">
                    <fieldset>
                        <div class="control-group" >
                            <label class="control-label cutz" for="input01" alt='Document Year' ><?php echo Controller::customize_label('Document Year'); ?><span> *</span>:&nbsp;</label>

                            <div class="controls">

                                <select id="DOC_YEAR" class="input-fluid validate[required] minw1 read"
                                        name="DOC_YEAR" style="height:30px;">
                                    <option value=""></option>
                                    <?php
                                    $current_year = date("Y");
                                    $range = range(($current_year-10), ($current_year + 4));
                                    foreach($range as $r)
                                    {
                                        echo '<option value="'.$r.'">'.$r.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </fieldset>
                </div>
               <?php
               if (!isset($_REQUEST['titl'])) {
                  ?>
                  <div>
					 <button class="span2 btn btn-primary back_b iphone_sales_disp <?php echo $btn; ?>" type="submit" id='submit' style='margin-left:100px;margin-top:20px'>Submit</button>
                  </div>
                  <?php
               }
               ?>
            </div>
         </form>
      </div>
   </div>
</section>

<?php if (isset($_REQUEST['MATERIAL_DOC']) && $ORDER_ITEMS_OUT != NULL) {
   ?>
   <form action="javascript:save_storage();" method="post" id='validation7' class="form-horizontal" enctype="multipart/form-data" autocomplete="on">
   <input type="hidden" name="bapiName" id="bapiName" value="material_transfer"/>
   <input type="hidden" name="MATERIAL_DOC" id="MATERIAL_DOC" value="<?php echo $doc_no; ?>"/>
   
   <div id="form_edit_values" class="utopia-widget-content myspace inval35 spaceing row-fluid" style="margin-top:11px;">
         <div class="span4 utopia-form-freeSpace myspace" >
         <!--<div style="position:absolute; float:right;right:50px;margin-top:-20px;"><a href="#" onclick="strpdf()"><img src="<?php /*echo Yii::app()->request->baseUrl; */?>/images/pdf.png"/>Sales order Confirmation</a></div>-->
            <fieldset>
            
               <div class="control-group">
                  <label class="control-label cutz in_custz" style="min-width: 170px;" alt="Document Date" for="input01" id='MAT_DOC_DATE'><?php echo Controller::customize_label('Document Date'); ?>:&nbsp;</label>
                  <div class="controls">
                     <input alt="Document Date" type="text" name='MAT_DOC_DATE' id='MAT_DOC_DATE' readonly="readonly" class="input-fluid validate[required] getval radius" value="<?php echo $date_formate; ?>" onKeyUp="jspt('MAT_DOC_DATE',this.value,event)" autocomplete="off"/>
					 
                  </div>
               </div>


            </fieldset>
         </div>
      
   </div>
	<span id="add_row_table" style="display:block;">
		<div class="row-fluid">
			<div class="span12" >
				<section class="utopia-widget spaceing max_width" style="margin-bottom:0px;">
					<div class="utopia-widget-title">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
						<span class='cutz sub_titles' alt='Items'><?php echo Controller::customize_label('Items');?></span>
					</div>
					<div class="utopia-widget-content items" >
						<div>
							<span class="btn" style="display: none" id="addRow" onclick="addRow('dataTable','A')" >Add item</span>
							<span class="btn"  id="deleteRow" onclick="deleteRow('dataTable')">
								<i class="icon-trash icon-white"></i>Delete item
							</span>
						</div>
						<br>
						<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
						<table class="table  table-bordered" id="dataTable" >
							<thead>
								<tr>
								    <!--<th class='cutz' alt='tableItems'><?php /*echo Controller::customize_label('tableItems');*/?></th>-->
                                    <th class="check"><input class="utopia-check-all" type="checkbox" id="head"></th>
									<th class='cutz' alt='Material'><?php echo Controller::customize_label('Material');?></th>
                                    <th class='cutz' alt='Plant'><?php echo Controller::customize_label('Plant');?></th>
									<th class='cutz' alt='Stor. Location'><?php echo Controller::customize_label('Stor. Location');?></th>
									<th class='cutz' alt='Batch'><?php echo Controller::customize_label('Batch');?></th>
                                    <th class='cutz' alt='Quantity'><?php echo Controller::customize_label('Quantity');?></th>
									<th class='cutz' alt='Unit of Entry'><?php echo Controller::customize_label('Unit of Entry');?></th>
								</tr>
							</thead>
							<tbody>
								<tr onClick="select_row('ids_0')" class="ids_0 nudf" >
									<!--<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk" value="U">
                                        </td>-->
                                    <td class="check"><input class="chkbox" type="checkbox" name="checkbox[]" title="che" id="che" value="U"/></td>
									<td>
										<input type="text"  id='MATERIAL' name='material[]' class="input-fluid validate[required] getval radiu"  style="width:90%;" title="MATERIAL" alt="MULTI"  onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off" value='<?php echo $meterial;?>'/>

									</td>

									<td>
										<input type="text" id='PLANT' style="width:90%;" class="input-fluid validate[required] getval" name='plant[]' title="PLANT" alt="PLANT" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/>
									</td>
									<td>
										<input type="text" id='STGE_LOC' style="width:50%;" class="input-fluid validate[required] getval" name='stge_loc[]' title="Storage_location" alt="STGE_LOC" onKeyUp="jspt('STGE_LOC',this.value,event)" autocomplete="off" value=''/>
                                        <div class='minws' id="table_lookup"  onclick="lookup('Storage Location', 'STGE_LOC', 'storgae_loc')" >&nbsp;</div>
									</td>
									<td>
										<input type="text" style="width:90%;" id='BATCH' class="input-fluid validate[required] getval radiu" name='batch[]' title="BATCH" alt="MULTI" onKeyUp="jspt('BATCH',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>

                                    </td>
                                    <td>
                                        <input type="text" style="width:90%;" id='ENTRY_QNT' class="input-fluid validate[required] getval radiu" name='entry_qnt[]' title="Entry_Qty" alt="ENTRY_QNT" onKeyUp="jspt('ENTRY_QNT',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>

                                    </td>
                                    <td>
                                        <input type="text" style="width:90%;" id='ENTRY_UOM' class="input-fluid validate[required] getval radiu" name='entry_uom[]' title="Entry_UOM" alt="ENTRY_UOM" onKeyUp="jspt('ENTRY_UOM',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>

                                    </td>
								</tr>
							</tbody>
						</table>
						</div>
						<input type="hidden" name="flag" id="flag"/>
						<input type="hidden" name="flag_d" id="flag_d"/>
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
                </section>
            </div>
        </div>
	</span>
	<div class="tab-content tab-con">
		<h3>Items</h3>
		<?php
		if ($ORDER_ITEMS_OUT != NULL)
		{
			?>
			<div class="labl pos_pop">
				<div class='pos_center'></div>
				<button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'>Cancel</button>
				<button class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;">Submit</button>
			</div>
			<div class="head_icons">
				<span id='post' tip="Table columns" class="yellow post_col" onClick="table_cells('example7')" ></span>
			</div>
			<?php
		}
		?>
		<div id='example7_today'>
		<?php
			if ($ORDER_ITEMS_OUT != NULL)
			{
				?>
				<div class="display_sales_header"></div>
				<input type="hidden" id="tableordersaveUrl" value="<?php echo Yii::app()->createAbsoluteUrl("common/tableorder") ?>" />
				<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
				<table class="table table-striped table-bordered" id="example7" alt="editsalesorder">
				<?php
					$technical = $model;
					$tec_name = 'BAPI2017_GM_ITEM_SHOW';
                    $headers = Controller::technicalNames($tec_name,"");
					$t_headers = Controller::technical_names($tec_name);

					$r = "";
					//print_r($vas);
					for ($i = 0; $i < count($vas); $i++)
					{
						$SalesOrders = $vas[$i];
						if ($i == 0)
						{
							?>
							<thead>
								<tr>
								<?php
									foreach ($SalesOrders as $keys => $vales)
									{
										?>
										<th>
											<div class="truncated example7_<?php echo $keys; ?> cutz" title="<?php echo $t_headers[$keys]; ?>" alt='<?php echo $t_headers[$keys]; ?>'><?php echo Controller::customize_label($t_headers[$keys]); ?></div>
											<div class="example7_th example7_<?php echo $keys; ?>_hid" style="display:none;" name="<?php echo $keys; ?>"><?php echo $t_headers[$keys]; ?></div>
											<div class="example7_tech" style="display:none;"><?php echo $keys . "@" . $t_headers[$keys]; ?></div>
										</th>
										<?php
									}
								?>
								</tr>
								<tr style="display:none;" class="example7_filter">
								<?php
									$j = 1;
									foreach ($SalesOrders as $keys => $vales)
									{
										?>
										<th><input type="text"  class="search_int" value="" alt='<?php echo $j; ?>' name="table_today@example7"></th>
										<?php
										$j++;
									}
								?>
								</tr>
							</thead>
							<tbody id='example7_tbody'>
							<?php
						}
						?>
						<tr id="<?php echo $r; ?>">
						<?php
							$col = 0;
							foreach ($SalesOrders as $keys => $vales)
							{
								$jon = urlencode(json_encode($SalesOrders));
								
								$date = Controller::dateValue($t_headers, $keys, $vales);
								if($date != false)
									$vales = $date;
								else
								{
									$num = Controller::numberFormat($t_headers, $keys, $vales);
									if($num != false)
										$vales = $num;
								}
								$id = $vales;
								?>
								<td class="example7_cl<?php echo $col; ?>">
								<?php

										echo $vales;


										echo '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys . '" name="' . $keys . '" value="' . $vales . '" alt="true">';

								?>
								</td>
								<?php
								$col++;
							}
						?>
						</tr>
						<?php
							//var_dump($SalesOrder);
							//  }
							if($r=="") { $r = 0; }
							$r = $r + 10;
					}
				?>
				</tbody>
				</table>
				</div>
				<?php
			}
			else
			{
				echo "No Items Found";
			}
		?>
		</div>
	</div>

   
   <br />
   <div class="controls" style="margin-left:0px;">
                     <input type="button" name="edit_salesorder" id="edit_salesorder" value="Edit" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="save_salesorder" id="save_salesorder" value="Save" onClick="save_storage()" style="display:none;" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="cancel_salesorder" id="cancel_salesorder" value="Cancel" style="display:none;" class="btn iphone_sales_disp" />
                  </div>
				  </div>
				  </form>
               <?php
               if (isset($_REQUEST['MATERIAL_DOC'])) {
                  ?>
      <script>
         $(document).ready(function()
         {      	
            //data_table('example');  		
         })
      </script>
         <?php
         }
      }
      if (isset($_REQUEST['titl'])) {
         ?>
   <script>
      $(document).ready(function()
      {
         parent.titl('<?php echo $_REQUEST["titl"]; ?>');
         parent.subtu('<?php echo $_REQUEST["tabs"]; ?>');
      })
   </script>
<?php
	}
	elseif(isset($_REQUEST['MATERIAL_DOC']) && $ORDER_ITEMS_OUT == NULL)
	{
		?>
			<div class="tab-content tab-con">Material Document doesn't exist.</div>
		<?php
	}
	?>
<!-- javascript placed at the end of the document so the pages load faster -->
<div class="material_pop" ></div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
   $(document).ready(function() {


    var currentYear = (new Date).getFullYear();
    $('#DOC_YEAR').val(currentYear);
      jQuery("#validation3").validationEngine();
   });
   

$(document).ready(function(e) 
{
    if($(document).width()<100)
    {
        $('#nxt1').css({color:'#cecece'});
        var gd=0;
        $('.iph').find('thead th').each(function(index, element) 
        {
            gd = gd+1;
            var text=$(this).text();
            $('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
            //$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
        });
    }
    

});

var inc = 0;
var nut = 0;		

function addRow(tableID,t) 
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
    var row = table.insertRow(rowCount);
	inc = (rowCount-1);
    row.setAttribute('onclick', 'select_row("ids_'+inc+'")');
    row.setAttribute('class', 'ids_'+inc+' nudf');
    var colCount = table.rows[1].cells.length;

    nut = 10 * inc;

    for(var i=0; i<colCount; i++)
    {
        var newcell = row.insertCell(i);
        //newcell.childNodes[0].insertBefore('hello');
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        //alert(newcell.innerHTML);
        var ind=newcell.getElementsByTagName('input');
        //alert(ind[0].title);

        /*if(ind[0].title=='che')
        {
            newcell.setAttribute('class', 'check');
        }*/

		if(t != "U")
			ind[0].removeAttribute('readonly');
		
        if(ind[0].title=='che')
        {
            newcell.setAttribute('class', 'check');
        }

        var ids=ind[0].id;
        ind[0].id=ids+nut;

        ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");


        if(ind[0].title=='Storage_location')
        {
            var re=  newcell.getElementsByTagName('span');
            var su='STGE_LOC'+nut;
            re[0].style.display=''
            re[0].setAttribute("onclick","lookup('Storage Location', '"+su+"', 'storgae_loc');");
        }

        ind[0].value = "";

        if($(document).width()<100)
        {
            var test=$('.iph').find('thead th:nth-child('+(i+1)+')').text();
            $('#'+newcell.childNodes[0].id).before('<label class="labls">'+test+'<span> *</span>:</label>');
            //$('#'+newcell.childNodes[0].id).after('<br><br>');
        }
    }
	$('.ids_'+inc+' .minw9').show();
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
               var newid = id.replace(/\d+$/, num);
               if(index == 0)
                   var newid = id.replace(/\d+$/, "");
               else
                   var newid = id.replace(/\d+$/, num);
               $(this).attr('id', newid);

               $(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");
               /*if(inpindex == 3)
                   $(this).attr("onchange","jspt_new('"+newid+"',this.value,event)");*/
           });

           $(this).find('span').each(function(spanindex, spanelement)
           {
               var num = (10 * index);
               var id = $(this).prev().attr("id");
               if(index == 0)
                   var newid = id.replace(/\d+$/, "");
               else
                   var newid = id.replace(/\d+$/, num);


               if(spanindex == 3)
                   $(this).attr("onclick", "lookup('Storage Location', '"+newid+"', 'storgae_loc')");

           });
           num++;
       });
   }


function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
      return str;
    }
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
    var num = 0;
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
    var lenft = $('.nudf').length;
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
	
	function urldecode (str) {
		return decodeURIComponent((str + '').replace(/\+/g, '%20'));
	}

$(document).ready(function(e) {
	//$(".minw").css("display","none");
	$("#add_row_table").css("display","none");
	
	$("#edit_salesorder").click(function() {
        $('#head_tittle').html("Edit Place In Storage");
		var tblexample7Len = $('#example7 >tbody >tr').length;
		var tbldataTableLen = $('#dataTable >tbody >tr').length;


		$("#edit_salesorder").hide();
		$("#save_salesorder").show();
		$("#cancel_salesorder").show();


		$("#NET_VAL_HD_hide").hide();

		$("#add_row_table").css("display","block");
		$(".tab-con").css("display","none");

		$("#validation7 input[type=text]").each(function(){
        });


		/*if(tbldataTableLen < tblexample7Len){
			rowlen = tblexample7Len-tbldataTableLen;
			for(var l=0;l<rowlen;l++)
			{
				addRow('dataTable','U');
			}
		} */


		$("#dataTable tbody tr").each(function(rind){
			if(rind < tblexample7Len)
			{

				$(this).find("input[type=text]").each(function(){
					if($(this).attr("id").indexOf("STGE_LOC") >= 0 || $(this).attr("id").indexOf("ENTRY_QNT") >= 0){
						$(this).attr("readonly", false);
                    }else{
                        $(this).attr("readonly", true);
                    }
				});
			}
			else
			{
				$(this).find("input[type=text]").each(function(tindex){
					if(tindex > 0)
						$(this).attr("readonly", false);
				});
			}
		});

		var str = '';
		$("#example7_tbody").find("input[type=hidden]").each(function(){
			id = $(this).attr('ids');
			val = $(this).attr('value');

			if(id != undefined)
				str = str + id + '=' + val + '&';
		});

		var values = str.split("&");

		$("#dataTable input[type=text]").each(function()
		{
			var id = $(this).attr('id');
			for(var j=0; j < values.length; j++)
			{
				var value = values[j].split("=");
				if(id == value[0])
				{
					$(this).val(urldecode(value[1]));
				}
			}
		});
	});

	
	$("#cancel_salesorder").click(function() 
	{
        $('#head_tittle').html("Place In Storage")
		$("#edit_salesorder").show();
		$("#save_salesorder").hide();
		$("#cancel_salesorder").hide();
		

		$("#NET_VAL_HD_hide").show();
		
		$("#add_row_table").css("display","none");
		$(".tab-con").css("display","block");
		
		$("#validation7 input[type=text]").each(function(){
			$(this).attr("readonly", true);
			//$(".minw").css("display","none");
		});
	});
});


function save_storage()
{

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)");

    $.ajax({
        type: 'POST', 
        data: $('#validation7').serialize(), 
        url: 'place_in_storage/save_storage',
        success: function(response) 
        {
			// alert(response);
			$('#loading').hide();
            $("body").css("opacity","1");			
            var spt = response.split("@");
			//var n = spt[0].indexOf("System error");
			var type = spt[1];
			jAlert('<b>SAP System Message: </b><br>'+ spt[0], 'Place In Storage');
            if(type=='S')
            {
                $('.getval').val("");
                var currentYear = (new Date).getFullYear();
                $('#DOC_YEAR').val(currentYear);
                $("#add_row_table").css("display","none");
                $("#save_salesorder").hide();
                $("#cancel_salesorder").hide();
                $("#form_edit_values").hide();

            }
        }
    });
}

</script>