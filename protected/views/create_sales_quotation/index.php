<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

	display:table-cell;
	
	}	
	
</style>
<?php
$sales_org  = "";
$cust       = "";
$distr_chan = "";
$sales_doc  = "";
$divi       = "";
$dt			= "";
$meterial   = "";
$dmeterial  = "";
$order_q    = "";
$su         = "";
$PURCH_NO_C = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if(isset($_COOKIE['formdata']))
{
	$arr = explode("&", substr($_COOKIE['formdata'], 0, -1));
	$ctrl_arr = ["SALES_ORG" => "sales_org", "PARTN_NUMB" => "cust", "DISTR_CHAN" => "distr_chan", "DOC_TYPE" => "sales_doc", "DIVISION" => "divi", "QFDate"=>"dt","QTDate" => "dt1"];
	$rows_arr = ["ITM_NUMBER", "MATERIAL", "SHORT_TEXT", "REQ_QTY", "TARGET_QU"];
	
	foreach($arr as $ak => $av)
	{
		$ctrl_id = strstr($av, "=", true);
		$ctrl_val = substr(strstr($av, "=", false), 1);
		
		if(array_key_exists($ctrl_id, $ctrl_arr))
			$ctrl_arr[$ctrl_id] = $ctrl_val;
		elseif(in_array($ctrl_id, $rows_arr))
		{
			$ctrl[] = $ctrl_id;
			$arr_val[$ctrl_id][] = $ctrl_val;
		}
	}
	unset($_COOKIE['formdata']);
	$it_num=0;
}
elseif(isset($customerNo) && $customerNo!='')
{
    $cust       = $customerNo;
    $sales_org  = "";    
    $cusLenth   = count($cust);
    //if($cusLenth < 10 && $cust!='') { $cust = str_pad((int) $cust, 10, 0, STR_PAD_LEFT); } else { $cust = substr($cust, -10); }
    $distr_chan = "";
    $sales_doc  = "";
    $divi       = "";
    $meterial   = "";
    $dmeterial  = "";
    $order_q    = "";
    $su         = "";
    $PURCH_NO_C = "";
}
else if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210')
{
    $sales_org  = "1000";
    $cust       = "10000051";
    $cusLenth   = count($cust);
    //if($cusLenth < 10 && $cust!='') { $cust = str_pad((int) $cust, 10, 0, STR_PAD_LEFT); } else { $cust = substr($cust, -10); }
    $distr_chan = "10";
    $sales_doc  = "ZOR";
    $divi       = "10";
    $meterial   = "nipro001";
    $dmeterial  = "Sales Kit";
    $order_q    = "2";
    $su         = "ea";
    $PURCH_NO_C = "SAPin Test PO";
}
if(isset($_REQUEST['titl']))
{
    ?><script>
    $(document).ready(function()
    {
        parent.titl('<?php echo $_REQUEST["titl"];?>');
        parent.subtu('<?php echo $_REQUEST["tabs"];?>');
    })
    </script><?php


}
if(is_array($ctrl_arr)){
    $cust = $ctrl_arr["PARTN_NUMB"];
    $sales_org = $ctrl_arr["SALES_ORG"];
    $distr_chan = $ctrl_arr["DISTR_CHAN"];
    $divi = $ctrl_arr["DIVISION"];
    $sales_doc = $ctrl_arr["DOC_TYPE"];
    $dt = $ctrl_arr["QFDate"];
    $dt1 = $ctrl_arr["QTDate"];
}
?>
<style>
.table th, .table td { min-width:50px; }
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.table th, .table tbody td{ display:table-cell; }
.check { display:none !important; }
label { min-width:150px; }
</style><?php
$customize = $model;
?>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
    <div class="utopia-widget-content myspace inval35 spaceing" style="margin-top:11px;">
        <form action="javascript:create_quotation();" method="post" id='validation' class="form-horizontal" enctype="multipart/form-data" autocomplete="on">
            <input type="hidden" name="url" value="create_sales_quotation"/>
           
            <div class="span5 utopia-form-freeSpace">
                <?php // print_r($_SESSION['BAPI_SALESORDER_CREATEFROMDAT2']); ?>

                <fieldset>
                    <div class="control-group">
                        <label class="control-label cutz" for="input01" id='PARTN_NUMB_s' alt="Customer Number"><?php echo Controller::customize_label('Customer Number');?><span> *</span>:</label>
                        <div class="controls">
							<input alt="Customer Number" type="text" name='PARTN_NUMB' id='PARTN_NUMB' class="input-fluid validate[required,custom[customer]] getval radius"  value='<?php echo $cust;?>' onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('Customer Number', 'PARTN_NUMB', 'sold_to_customer')" >&nbsp;</span>
                            <!-- onchange="number(this.value)" -->
                        </div>
					</div>
                    <div class="control-group">
						<label class="control-label cutz" alt="Sales Organization" for="input01" id='SALES_ORG_s'><?php echo Controller::customize_label('Sales Organization');?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Sales Organization" type="text" name='SALES_ORG' id='SALES_ORG' class="input-fluid validate[required,custom[salesorder]] getval radius" value='<?php echo $sales_org;?>' onKeyUp="jspt('SALES_ORG',this.value,event)" autocomplete="off"/>
                            <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
                            <span class='minw' onclick="lookup('Sales Organization', 'SALES_ORG', 'sales_org')" >&nbsp;</span>
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label cutz" for="input01" id='DISTR_CHAN_s' alt='Distribution. Channel'><?php echo Controller::customize_label('Distribution. Channel');?><span> *</span>:</label>
                        <div class="controls">
							<input alt="Distribution. Channel" type="text" name='DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required] getval radius" value='<?php echo $distr_chan;?>' onKeyUp="jspt('DISTR_CHAN',this.value,event)" autocomplete="off"/>
                            <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>-->
                            <span class='minw' onclick="lookup('Distribution Channel', 'DISTR_CHAN', 'dist_chan')" >&nbsp;</span>
                        </div>
					</div>
                    <div class="control-group">
						<label class="control-label cutz" for="input01" id="DIVISION_s" alt='Division'><?php echo Controller::customize_label('Division');?><span> *</span>:</label>
						<div class="controls">
							<input alt="Division" type="text" name='DIVISION' id='DIVISION' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DIVISION',this.value,event)" autocomplete="off" value='<?php echo $divi;?>'/>
							<!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','DIVISION','2')" >&nbsp;</span>-->
							<span class='minw' onclick="lookup('Division', 'DIVISION', 'division')" >&nbsp;</span>
						</div>
					</div>
                </fieldset>
            </div>
            <div class="span5 utopia-form-freeSpace">
                <fieldset>
                    <div class="control-group">
						<label class="control-label cutz" for="input01" id="DOC_TYPE_s" alt='Sales Document Type'><?php echo Controller::customize_label('Sales Document Type');?><span> *</span>:</label>
						<div class="controls">
							<input alt="Sales Document Type" type="text" name="DOC_TYPE" id='DOC_TYPE' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DOC_TYPE',this.value,event)" autocomplete="off" value='<?php echo $sales_doc;?>'/>
							<!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DOC_TYPE','Sales Document Type','DOC_TYPE','0')" >&nbsp;</span>-->
							<span class='minw' onclick="lookup('Sales Document Type', 'DOC_TYPE', 'sales_order_types')" >&nbsp;</span>
						</div>
					</div>
					<div class="control-group">
                        <label class="control-label cutz" for="input01"  alt='Valid From Date'><?php echo Controller::customize_label('Valid From Date');?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Valid From Date" type="text" name='ValidfromDate' id='datepicker1' value='<?php echo $dt;?>' class="input-fluid validate[required,custom[date]] getval radius" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label cutz" for="input01"  alt='Valid To Date'><?php echo Controller::customize_label('Valid To Date');?><span> *</span>:</label>
						<div class="controls">
							<input alt="Valid To Date" type="text" name='ValidtoDate' id='datepicker' value='<?php echo $dt1;?>' class="input-fluid validate[required,custom[date]] getval radius" />
						</div>
					</div>
                </fieldset>
            </div>

            <div class="row-fluid">
                <div class="span12" >
                    <section class="utopia-widget spaceing max_width">
                        <div class="utopia-widget-title">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
                            <span class='cutz sub_titles' alt='Items'><?php echo Controller::customize_label('Items');?></span>
                        </div>
                        <div class="utopia-widget-content items" >
                            <div><a class="btn" id="addRow" onclick="addRow('dataTable')" >Add item</a>
                                <a class="btn" id="deleteRow" onclick="deleteRow('dataTable')">
                                <i class="icon-trash icon-white"></i>
                                Delete item
                                </a>
                            </div>
                            <br>
							<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
                            <table class="table  table-bordered" id="dataTable" >
                                <thead>
                                    <tr>
                                        <th class='cutz' alt='tableItems'><?php echo Controller::customize_label('tableItems');?></th>
                                        <th class='cutz' alt='Material'><?php echo Controller::customize_label('Material');?></th>
                                        <th class='cutz' alt='Order Quantity'><?php echo Controller::customize_label('Order Quantity');?></th>
                                        <th class='cutz' alt='SU'><?php echo Controller::customize_label('SU');?></th>
										<th class='cutz' alt='Description'><?php echo Controller::customize_label('Description');?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
									<?php if(!is_array($arr_val)): ?>
										<tr onClick="select_row('ids_0')" class="ids_0 nudf" >
											<!--<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk"><input type="text" name='item[]' <?php if(!isset($customerNo)) { ?>value="000010"<?php } else {?>value=""<?php }?> style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER"/></td>-->
											<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk">
                                                <input type="text" name='item[]' value="10" style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER"/></td>
											<td><input type="text" id='MATERIAL' name='material[]' class="input-fluid validate[required] getval radiu " title="MATERIAL" alt="MULTI" onchange="jspt_new('MATERIAL',this.value,event)" onKeyUp="jspt('MATERIAL',this.value,event)" style="width: 70%" autocomplete="off" value='<?php echo $meterial;?>'/>
											<!--<span class='minw9' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                                <span class='minw6' onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</span>
                                                <img class="info-img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png"/>

                                                </td>
											<td ><input type="text" id='REQ_QTY' style="width:90%;" class="input-fluid validate[required,custom[number]] getval" name='Order_quantity[]' alt="MULTI" onKeyUp="jspt('REQ_QTY',this.value,event)" autocomplete="off" value='<?php echo $order_q;?>'/></td>
											<td><input type="text" style="width:90%;" id='TARGET_QU' class="input-fluid validate[required] getval radiu" name='su[]' title="su" alt="MULTI"
											onKeyUp="jspt('TARGET_QU',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>
                                                <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','TARGET_QU','0')" >&nbsp;</span>-->
                                                <span  class='minw5' onclick="lookup('SU', 'TARGET_QU', 'uom')" >&nbsp;</span></td>	
											<td><input type="text" id='SHORT_TEXT' style="width:90%;" class="input-fluid validate[required] getval" name='description[]' title="descript" alt="MULTI" onKeyUp="jspt('SHORT_TEXT',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/></td>
											
										</tr>
									<?php else: foreach($arr_val['ITM_NUMBER'] as $avk => $avv) { ?>
										<?php
											if($it_num==0)
												$id_num='';
											else	
												$id_num	= 10*$it_num;
											$meterial	= $arr_val['MATERIAL'][$avk];
											$dmeterial	= $arr_val['SHORT_TEXT'][$avk];
											$order_q	= $arr_val['REQ_QTY'][$avk];
											$su			= $arr_val['TARGET_QU'][$avk];
										?>
										<tr onClick="select_row('ids_<?php echo $avk; ?>')" class="ids_<?php echo $avk; ?> nudf" >
											<!--<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk"><input type="text" name='item[]' <?php if(!isset($customerNo)) { ?>value="000010"<?php } else {?>value=""<?php }?> style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER"/></td>-->
											<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk"><input type="text" name='item[]' value="<?php echo $id_num+10;?>" style="width:90%;" title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER<?php echo $id_num; ?>"/></td>
											<td><input type="text" id='MATERIAL<?php echo $id_num; ?>' name='material[]' class="input-fluid validate[required] getval radiu " title="MATERIAL" alt="MULTI" onchange="jspt_new('MATERIAL<?php echo $id_num; ?>',this.value,event)" onKeyUp="jspt('MATERIAL<?php echo $id_num; ?>',this.value,event)" autocomplete="off" style="width: 70%" value='<?php echo $meterial;?>'/>
											<!--<span class='minw9' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL<?php /*echo $id_num; */?>','3@MAT1L')" >&nbsp;</span>-->
                                                <span class='minw6' onclick="lookup('Material', 'MATERIAL<?php echo $id_num; ?>', 'material')" >&nbsp;</span>

											<img class="info-img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png"/></td>
											<td><input type="text" id='SHORT_TEXT<?php echo $id_num; ?>' style="width:90%;" class="input-fluid validate[required] getval" name='description[]' title="descript" alt="MULTI" onKeyUp="jspt('SHORT_TEXT<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/></td>
											<td ><input type="text" id='REQ_QTY<?php echo $id_num; ?>' style="width:90%;" class="input-fluid validate[required,custom[number]] getval" name='Order_quantity[]' alt="MULTI" onKeyUp="jspt('REQ_QTY<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $order_q;?>'/></td>
											<td><input type="text" style="width:90%;" id='TARGET_QU<?php echo $id_num; ?>' class="input-fluid validate[required] getval radiu" name='su[]' title="su" alt="MULTI"
											onKeyUp="jspt('TARGET_QU<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>
                                                <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','TARGET_QU--><?php /*echo $id_num; */?><!--','0')" >&nbsp;</span>-->
                                                <span  class='minw5' onclick="lookup('SU', 'TARGET_QU', 'uom')" >&nbsp;</span>
                                            </td>
										</tr>
										<?php $it_num	= $it_num+1;  } endif; ?>
                                </tbody>
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
                </section>
            </div>
        </div>
    <div >
        <br><input type="submit" value="<?php echo _SUBMIT ?>" class='btn btn-primary bbt' />
    </div>
    <div class="material_pop"></div>
</form>
</div>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>

<script type="text/javascript">
$(document).ready(function() 
{
    if($.cookie("formdata"))
    {
        $.cookie("formdata", null);
    }
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
    <?php if(!isset($customerNo) && $dt == "") { ?>
    $('#datepicker').val(today);
    <?php } ?>
    $('#datepicker').datepicker({
        format: 'mm/dd/yyyy',
        weekStart: '0',
        autoclose:true
    }).on('changeDate', function()
    {
        $('.datepickerformError').hide();
    });
	<?php if(!isset($customerNo) && $dt == "") { ?>
    $('#datepicker1').val(today);
    <?php } ?>
    $('#datepicker1').datepicker({
        format: 'mm/dd/yyyy',
        weekStart: '0',
        autoclose:true
    }).on('changeDate', function()
    {
        $('.datepickerformError').hide();
    });
    
    $("#validation").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        $("#btnSearch").attr('value');
            //add more buttons here
            return false;
        }
    });
    
   jQuery("#validation").validationEngine();
    
});


function create_quotation()
{

    var de = 0;
    /*if(de!=1)
    {
        $('#validation input').each(function(index, element) 
        {
            var names = $(this).attr('name');
            if($(this).attr('alt')=='MULTI')
            {
                names = $(this).attr('id');
            }
            var values = $(this).val();
            if(values!="")
            {
                var cook = $.cookie(names);
                var name_cook = values;
                if(cook!=null)
                {
                    name_cook = cook+','+values;
                }
                if($.cookie(names))
                {
                    var str = $.cookie(names);
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
    }*/
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        data:$('#validation').serialize(), 
        url: 'create_sales_quotation/quotation_sales',			
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            var spt=response.split("@");
			var msg=$.trim(spt[1])
			if(msg!='E')
			{
			jPrompt1('Email Id:', '', 'Send Mail', function(r) {
        if( r ) 
        {
		    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 

		var txt = spt[0];
var numb = txt.match(/\d/g);
numb = numb.join("");
		
$.ajax({
        type:'POST', 
        data:'q_no='+numb+'&mail_to='+r, 
        url: 'create_sales_quotation/quotaitonemail?mailcontent='+spt[0],			
        success: function(response) 
        {
		$('#loading').hide();
            $("body").css("opacity","1"); 
		 jAlert('<b>SAP System Message: </b><br>'+spt[0], 'Sales Quotation');
		}
		});
		}});
}else
{
 jAlert('<b>SAP System Message: </b><br>'+spt[0], 'Sales Quotation');
}
            if(msg=='S')
            {
                $('.getval').val("");
            }
        }
    }); 


}

$(document).ready(function(e) 
{
    if($(document).width()<1030)
    {
        $('#nxt1').css({color:'#cecece'});
        var gd=0;
        $('.iph').find('thead th').each(function(index, element) 
        {
            
            var text=$(this).text();
			gd = gd+1;
			
			$('.iph').find('tbody td:nth-child('+gd+')').children('input[type=text]').before('<label class="sda">'+text+'<span> *</span>:</label>');
            
			//$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
        });
    }
    
    $("#dataTable").on('click', 'img', function() {
        var val   = $(this).closest("td").find("input").val();
        $sales_org = $("#SALES_ORG").val();
		// alert(val+" "+$sales_org);
        if(val != "")
            show_prod_avail(val,$sales_org,'product_availability');
        else
            jAlert("You Have to Select Material First");
    })
});

var inc = 0;
var nut = 0;		

function addRow(tableID) 
{
    // inc = inc+1;
    if($(document).width()<1030)
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
        if(ind[0].title=='che')
        {
            //newcell.setAttribute('class', 'check');
        }
        //alert(newcell.childNodes[0].id);
        var ids=ind[0].id;
		//alert(ids);
        ind[0].id=ids+nut;

        if(ids != "chedk")
			ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");
		
        if(ind[0].title=='MATERIAL')
        {
	        ind[0].setAttribute("onchange","jspt_new('"+ids+nut+"',this.value,event)");
            var re=  newcell.getElementsByTagName('span');
            var met='MATERIAL'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");


        }

        if(ind[0].title=='su')
        {
            var re=  newcell.getElementsByTagName('span');
            var su='TARGET_QU'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+su+"','0');");*/
            re[0].setAttribute("onclick","lookup('SU', '"+su+"', 'uom');");

        }
        if(ind[(ind.length-1)].title=='item')
        {
            var numb=newcell.childNodes[0].value;
			var ids=ind[(ind.length-1)].id;
			ind[(ind.length-1)].id=ids+nut;
            // ind[(ind.length-1)].value='0000'+(nut+10);
            ind[(ind.length-1)].value=(nut+10);
	        ind[(ind.length-1)].setAttribute("readonly", true);
        }
        else
        {
            ind[0].value = "";
        }
        if($(document).width()<1030)
        {
            var test=$('.iph').find('thead th:nth-child('+(i+1)+')').text();
            $('#'+newcell.childNodes[0].id).before('<label class="labls">'+test+'<span> *</span>:</label>');
            //$('#'+newcell.childNodes[0].id).after('<br><br>');
        }
    }
}

function deleteRow(tableID) 
{
    if($(document).width()<1030)
    {
        var num=0;
        $('.nudf').each(function(index, element) 
        {
            $(this).attr('id','ids_'+num);
            num++;
        });
        
        $('.nudf').each(function(index, element) {
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
                    $('.iph').find('thead th').each(function(index, element) 
                    {
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
        }
        catch(e) {
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
				if(inpindex == 1)
					$(this).val((num+10));
				
				var id = $(this).attr("id");
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
				var newid = id.replace(/\d+$/, num);
				
				if(spanindex == 0)
                    $(this).attr("onclick", "lookup('Material', '"+newid+"', 'material');");
					/*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+newid+"','3@MAT1L');");*/
				if(spanindex == 1)
					$(this).attr("onclick", "lookup('SU', '"+newid+"', 'uom');");
                    /*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+newid+"','0');");*/
			});
		}
		else
		{
			$(this).find('input').each(function(inpindex, inpelement)
			{
				if(inpindex == 1)
					$(this).val(10);
				
				var id = $(this).attr("id");
				var newid = id.replace(/\d+$/, "");
				$(this).attr('id', newid);
				if(inpindex > 1)
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
					$(this).attr("onclick", "lookup('SU', '"+newid+"', 'uom');");
                /*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+newid+"','0');");*/
			});
		}
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
        document.getElementById('PARTN_NUMB').value=str;
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
    var num=0;
    $('.nudf').each(function(index, element) 
    {
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
</script>