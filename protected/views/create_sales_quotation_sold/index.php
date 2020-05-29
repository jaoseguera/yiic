<style>
.table th:nth-child(-n+11), .table td:nth-child(-n+11){
	display:table-cell;	
}	

</style>
<?php
$sales_org  = "";
$cust       = "";
$distr_chan = "";
$sales_doc  = "ZMQT";
$divi       = "";
$dt			= "";
$meterial   = "";
$dmeterial  = "";
$order_q    = "";
$su         = "";
$PURCH_NO_C = "";
$pmntterms = "";
$pmntterms_desc = "";
$headCurrency = "";
$Currency="";
$Plant="";
$Net_Price="";
	$Per_Unit="";
$COND_UNIT="";
$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');


if(isset($_COOKIE['formdata']))
{
	$arr = explode("&", substr($_COOKIE['formdata'], 0, -1));	
	$ctrl_arr = ["SALES_ORG" => "sales_org", "PARTN_NUMB" => "sold","PARTN_NAME"=>"sold_name","PARTN_NUMB1" => "ship", "DISTR_CHAN" => "distr_chan", "DOC_TYPE" => "sales_doc", "DIVISION" => "divi","PARTN_NUMB2" => "sales", "QFDate"=>"dt","QTDate" => "dt1","HEADER_TEXT"=>"header_text","LANGUAGE"=>"lang","PMNTTERMS"=>"pmntterms","ZTERM_DESC"=>"pmntterms_desc","HEAD_CURRENCY"=>"headCurrency"];
	$rows_arr = ["ITM_NUMBER", "MATERIAL", "REQ_QTY", "TARGET_QU","SHORT_TEXT", "NET_PRICE","COND_P_UNT","CURRENCY","PLANT","LINE","SALES_LINE","ITEM_CATEG","HIGH_LEVEL_ITEM","COND_VALUE","COND_UNIT"];
	
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

    

	//unset($_COOKIE['formdata']);
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
    $pmntterms = "";
    $pmntterms_desc = "";
	$Currency="";
    $Plant = "";
	$Net_Price="";
	$Per_Unit="";
    $COND_UNIT="";
	$item_text="";
	$sales_text="";
	$item_categ="";
	$header_text="";
    $percentage_discount="";
	$lang="";
	$high_level_item = "";
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
    $pmntterms = "0.00";
	$Net_Price="0.00";
	$Per_Unit="1";
	
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
?>
<style>
.table { width:1270px !important; max-width:1270px !important } 
.info-img
{
margin-left:-30px !important;
}
/*.table th, .table td { min-width:60px !important; }*/
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.table th, .table tbody td{ display:table-cell; }
.check { display:none !important; }

</style><?php
$customize = $model;
if(is_array($ctrl_arr)){
	$sold = $ctrl_arr["PARTN_NUMB"];
	$ship = $ctrl_arr["PARTN_NUMB1"];
	$sales_org = $ctrl_arr["SALES_ORG"];
	$distr_chan = $ctrl_arr["DISTR_CHAN"];
	$sales =  $ctrl_arr["PARTN_NUMB2"];
	$sold_name = $ctrl_arr["PARTN_NAME"];
	$sales_doc = $ctrl_arr["DOC_TYPE"];
	$dt = $ctrl_arr["QFDate"];
	$dt1 = $ctrl_arr["QTDate"];
	$header_text = $ctrl_arr["HEADER_TEXT"];
    $lang = $ctrl_arr["LANGUAGE"];
    $pmntterms = $ctrl_arr["PMNTTERMS"];
    $pmntterms_desc = $ctrl_arr["ZTERM_DESC"];
    $PURCH_NO_C = $ctrl_arr["PURCH_NO_C"];
    $headCurrency = $ctrl_arr["HEAD_CURRENCY"];
    $percentage_discount = $ctrl_arr['PERCENTAGE_DISCOUNT'];
}
?>
<div id="tarea" style="display:none;"></div>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
    <div class="utopia-widget-content myspace inval35 spaceing" style="margin-top:11px;">
        <form action="javascript:create_quotation();" method="post" id='validation' class="form-horizontal" enctype="multipart/form-data" autocomplete="on">
            <input type="hidden" name="url" value="create_sales_quotation"/>
           
            <div class="span5 utopia-form-freeSpace">
              

                <fieldset>
                    <div class="control-group">
                        <label class="control-label cutz" for="input01" id='SOLD_TO_PARTY' alt="Sold to Party"><?=Controller::customize_label(_SOLDPARTY);?><span> *</span>:</label>
                        <div class="controls">
							<input alt="Sold to Party" type="text" name='PARTN_NUMB' id='PARTN_NUMB' class="input-fluid validate[required,custom[customer]] getval radius"  value='<?php echo $sold;?>' onchange="jspt_new('PARTN_NUMB',this.value,event)" onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=Controller::customize_label(_SOLDPARTY);?>', 'PARTN_NUMB', 'sold_to_customer')" >&nbsp;</span>
                            
                        </div>
					</div>
                    <div class="control-group">
                        <label class="control-label cutz" for="input01" id='SHIP_TO_PARTY' alt='Ship to Party'><?=Controller::customize_label(_SHIPPARTY);?><span> *</span>:</label>
                        <div class="controls">
							<input alt="Ship to Party" type="text" name='PARTN_NUMB1' id='PARTN_NUMB1' class="input-fluid validate[required,custom[customer]] getval radius"  value='<?php echo $ship;?>' onKeyUp="jspt('PARTN_NUMB1',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=Controller::customize_label(_SHIPPARTY);?>', 'PARTN_NUMB1', 'ship_to_customer')" >&nbsp;</span>						
						</div>
					</div>
					<div class="control-group">
						<label class="control-label cutz" alt="Sales Organization" for="input01" id='SALES_ORG_L'><?=Controller::customize_label(_SALESORGANIZATION);?><span> *</span>:</label>
                        <div class="controls">
                            <textarea alt="Sales Organization" type="text" name='SALES_ORG' id='SALES_ORG' class="input-fluid validate[required,custom[salesorder]] radius getvals" readonly   autocomplete="off"><?php echo $sales_org;?></textarea>
                           
                        </div>
                    </div>
					<div class="control-group">
                        <label class="control-label cutz" for="input01" id='DISTR_CHAN_L' alt='Distribution. Channel'><?=Controller::customize_label(_DISTRIBUTIONCHANNEL);?><span> *</span>:</label>
                        <div class="controls">
							<textarea alt="Distribution. Channel" type="text" name='DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required] radius getvals" readonly  onKeyUp="jspt('DISTR_CHAN',this.value,event)" autocomplete="off"><?php echo $distr_chan;?></textarea>
                            
                        </div>
					</div>
                    <div class="control-group">
                        <label class="control-label cutz" for="input01" id="DOC_TYPE_L" alt='Payment Terms'><?=Controller::customize_label(_PAYMENTTERMS);?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Payment Terms" type="text" name="PMNTTERMS" id='PMNTTERMS' class="input-fluid validate[required] getval radius" autocomplete="off" onchange="getPaymentTermDesc(this.value);"  value='<?php echo $pmntterms;?>'/>

                            <span class='minw' onclick="lookup('<?=Controller::customize_label(_PAYMENTTERMS);?>', 'PMNTTERMS', 'payment_terms')" >&nbsp;</span>
                        </div>
                    </div>
                    <div class="control-group">
						<label class="control-label cutz" for="input01" id="DIVISION_s" alt='Division'><?=Controller::customize_label(_SALESPERSON);?><span> *</span>:</label>
						<div class="controls">
						<input alt="Sales Person" type="text" name='PARTN_NUMB2' id='PARTN_NUMB2' class="input-fluid validate[required,custom[customer]] getval radius"  value='<?php echo $sales;?>' onKeyUp="jspt('PARTN_NUMB2',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=Controller::customize_label(_SALESPERSON);?>', 'PARTN_NUMB2', 'sales_person')" >&nbsp;</span>						</div>
					</div>
                </fieldset>
            </div>
            <div class="span5 utopia-form-freeSpace">
                <fieldset>
				<div class="control-group">
						<label class="control-label cutz" alt="Sold to Name" for="input01" id='SOLD_TO_NAME'><?=Controller::customize_label(_SOLDPARTYNAME);?>:</label>
                        <div class="controls">
                            <textarea alt="Sold to Name" type="text" name='SOLD_NAME' id='SOLD_NAME' class="input-fluid radius getvals" readonly   autocomplete="off"><?php echo $sold_name; ?></textarea>
                           
                        </div>
                    </div>
                    
					<div class="control-group">
						<label class="control-label cutz" for="input01" id="DOC_TYPE_L" alt='Sales Document Type'><?=Controller::customize_label(_SALESDOCTYPE);?><span> *</span>:</label>
						<div class="controls">
							<input alt="Sales Document Type" type="text" name="DOC_TYPE" id='DOC_TYPE' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DOC_TYPE',this.value,event)" autocomplete="off" value='<?php echo $sales_doc;?>'/>
							
							<span class='minw' onclick="lookup('<?=Controller::customize_label(_SALESDOCTYPE);?>', 'DOC_TYPE', 'sales_order_types')" >&nbsp;</span>
						</div>
					</div>
					<div class="control-group" hidden>
                        <label class="control-label cutz" for="input01"  alt='Valid From Date'><?=Controller::customize_label(_VALIDFROMDATE);?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Valid From Date" type="text" name='ValidfromDate' id='datepicker1' value='<?php echo $dt;?>' class="input-fluid validate[required,custom[date]] getval radius" />
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label cutz" for="input01"  alt='Valid To Date'><?=Controller::customize_label(_VALIDTODATE);?><span> *</span>:</label>
						<div class="controls">
							<input alt="Valid To Date" type="text" name='ValidtoDate' id='datepicker' value='<?php echo $dt1;?>' class="input-fluid validate[required,custom[date]] getval radius" />
						</div>
					</div>
                    <div class="control-group">
                        <label class="control-label cutz" for="input01"  alt='Customer PO number'><?=Controller::customize_label(_CUSTOMERPO);?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Customer PO number" type="text" name='PURCH_NO_C' id='PURCH_NO_C' value='<?php echo $PURCH_NO_C;?>' class="input-fluid validate[required] getval radius"/>
                        </div>
                    </div>   
                    <div class="control-group">
                        <label class="control-label cutz" alt="Sold to Name" for="input01" id='SOLD_TO_NAME'><?=Controller::customize_label(_PAYMENTTERMSDESC);?>:</label>
                        <div class="controls">
                            <textarea alt="Payment terms" type="text" name='ZTERM_DESC' id='ZTERM_DESC' class="input-fluid radius getvals" readonly   autocomplete="off"><?php echo $pmntterms_desc; ?></textarea>                           
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label cutz" alt="Sold to Name" for="HEAD_CURRENCY"><?=Controller::customize_label(_CURRENCY);?><span> *</span>:</label>
                        <div class="controls">
                            <input alt="Currency" type="text" name='HEAD_CURRENCY' id='HEAD_CURRENCY' class="input-fluid validate[required] getval radius" autocomplete="off" onchange="setLinesCurrency(this.value);" value="<?php echo $headCurrency;?>"/>  
                            <span class='minw' onclick="lookup('<?=Controller::customize_label(_CURRENCY);?>', 'HEAD_CURRENCY', 'currency')" >&nbsp;</span>                         
                        </div>
                    </div>                 
					<div class="control-group" >
                  <div class="controls">
				  <input type="hidden"  name="HEADER_TEXT" class="getval" value="<?php echo $header_text; ?>" id="HEADER_TEXT" />
                     <input type="button" name="copy_form_data" onClick="enterText('HEADER_TEXT','')" value="<?=Controller::customize_label(_HEADERTXT);?>" class="btn" />

                     <!-- 
                            GEZG 02/06/19 
                            Adding percentage discount button
                    -->
                    <input type="hidden"  name="PERCENTAGE_DISCOUNT" class="getval" value="<?php echo $percentage_discount; ?>" id="PERCENTAGE_DISCOUNT" />
                     <input type="button" onClick="enterValue('PERCENTAGE_DISCOUNT','')" value="<?=Controller::customize_label(_PERCENTAGEDISCOUNT);?>" class="btn" />

                     
                  <input type="hidden"  name="LANGUAGE" value="<?php echo $lang; ?>" id="LANGUAGE" />
				  </div></div>
                </fieldset>
            </div>

            <div class="row-fluid">
                <div class="span12" >
                    <section class="utopia-widget spaceing max_width">
                        <div class="utopia-widget-title">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/paragraph_justify.png" class="utopia-widget-icon">
                            <span class='cutz sub_titles' alt='Items'><?=Controller::customize_label(_ITEMS);?></span>
                        </div>
                        <div class="utopia-widget-content items" >
                            <div><a class="btn" id="addRow" onclick="addRow('dataTable')" ><?=_ADDITEM?></a>
                                <a class="btn" id="deleteRow" onclick="deleteRow('dataTable')">
                                <i class="icon-trash icon-white"></i>
                                <?=_DELETEITEM?>
                                </a>
                            </div>
                            <br>
							<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;">
                            <table class="table  table-bordered" id="dataTable" >
                                <thead>
                                    <tr>
                                        <th class='cutz' alt='tableItems'><?=Controller::customize_label(_ITEMS);?></th>
                                        <th class='cutz large' alt='Material'><?php echo Controller::customize_label('Material');?></th>
                                        <th class='cutz' alt='High level item'><?=Controller::customize_label(_HIGHTITEM);?></th>
                                        <th class='cutz' alt='Free goods'><?=Controller::customize_label(_FREEGOODS);?></th>
                                        <th class='cutz' alt='Order Quantity'><?=Controller::customize_label(_ORDERQUANTITY);?></th>
                                        <th class='cutz' alt='SU'><?php echo Controller::customize_label('SU');?></th>
										<th class='cutz large' alt='Description'><?=Controller::customize_label(_DESCRIPTION);?></th>
										<th class='cutz' alt='Sales Price'><?=Controller::customize_label(_SALESPRICE);?></th>
										<th class='cutz' alt='Per Unit'><?=Controller::customize_label(_PERUNIT);?></th>
                                        <th class='cutz' alt='UOM'><?=Controller::customize_label(_UOM);?></th>
                                        <th class='cutz' alt='Per Unit'><?=Controller::customize_label(_CURRENCY);?></th>
                                        <th class='cutz' alt='Plant'><?=Controller::customize_label(_PLANT);?></th>
										<th class='cutz' alt='Item Text'><?=Controller::customize_label(_ITEMTXT);?></th>
										<th class='cutz' alt='Sales Text'><?=Controller::customize_label(_SALESTXT);?></th>
                                        <th class='cutz' alt='Sales Text'><?=Controller::customize_label(_PRODUCTAVAILABILITY);?></th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php 
										/*$parentLineNumber = "";
                                        if($dt == ""): */
                                        if(!is_array($arr_val)){
									?>
										<tr onClick="select_row('ids_0')" class="ids_0 nudf" >
											
											<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk">
                                                <input type="text" name='item[]' value="10"  title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER"/></td>
											<td><img class="info-img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png"/><input type="text"  id='MATERIAL'  name='material[]' class="input-fluid validate[required] getval radius " title="MATERIAL" alt="MULTI" onchange="getMatDescBOM('MATERIAL',this,event,'dataTable')" onKeyUp="jspt('MATERIAL',this.value,event)"  autocomplete="off" value='<?php echo $meterial;?>'/>
											
                                                <div class='minws1' onclick="lookup('Material', 'MATERIAL', 'material','SALES_ORG,DISTR_CHAN')" >&nbsp;</div>
                                                </td>
                                            <td>
                                            	<input type="text"  id='HIGH_LEVEL_ITEM'  title="high_level_item" name='HIGH_LEVEL_ITEM[]'  value="<?=$high_level_item?>" class="input-fluid" onChange="setComponent(this)"/>
                                            </td>
                                            <td>
                                            	<input type="checkbox"  id='IS_FREE_CHARGE'  title="is_free_charge" name='IS_FREE_CHARGE[]'  <?=$item_categ == "AGNN"?"checked":"" ?> onchange="setFreeCharge(this);"/>
                                            	<input type="hidden"  id='FREE_CHARGE'  title="free_charge" name='FREE_CHARGE[]' value='<?=($item_categ == "AGNN"?"1":"0")?>'/>
                                            	<input type="hidden" id="IS_COMPONENT" title="is_component" name="IS_COMPONENT[]" value="<?=($high_level_item != ""?"1":"0")?>">
                                            	<input type="hidden" id="ITEM_CATEG" title="ITEM_CATEG" name="ITEM_CATEG[]" value="<?=$item_categ?>">
                                            </td>
											<td ><input type="text" id='REQ_QTY' class="input-fluid validate[required,custom[number]] getval" name='Order_quantity[]' title="order_quantity" alt="MULTI" onKeyUp="jspt('REQ_QTY',this.value,event)" autocomplete="off" value='<?php echo $order_q;?>' onchange="getMatDescBOM('MATERIAL',this,event,'dataTable')" /></td>
											<td style="padding-right: 25px"><input type="text"  id='TARGET_QU' class="input-fluid validate[required] getval radius" name='su[]' title="su" alt="MULTI"
											onKeyUp="jspt('TARGET_QU',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>
                                                
                                                <div  class='minws1' onclick="lookup('SU', 'TARGET_QU', 'uom')" >&nbsp;</div></td>
											<td><input type="text"  id='SHORT_TEXT'  class="input-fluid validate[required] getval" name='description[]' title="description" alt="MULTI" onKeyUp="jspt('SHORT_TEXT',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/></td>
											<td><input type="text"  id='NET_PRICE' class="input-fluid validate[required] getval" name='Net_Price[]' title="net_price" alt="MULTI" onKeyUp="jspt('NET_PRICE',this.value,event)" autocomplete="off" value='<?php echo $Net_Price;?>'/></td>
											<td><input type="text"  id='COND_P_UNT'  class="input-fluid validate[required] getval" name='Per_Unit[]' title="per_unit" alt="MULTI" onKeyUp="jspt('COND_P_UNT',this.value,event)" autocomplete="off" value='<?php echo $Per_Unit;?>'/></td>

                                           <td style="padding-right: 25px"><input type="text"  id='COND_UNIT'  class="input-fluid validate[required] getval" name='COND_UNIT[]' title="COND_UNIT" alt="MULTI" onKeyUp="jspt('COND_UNIT',this.value,event)" autocomplete="off" value='<?php echo $COND_UNIT;?>'/>
                                               <div  class='minws1' onclick="lookup('<?=_UOM?>', 'COND_UNIT', 'uom')" >&nbsp;</div>
                                           </td>

                                            <td>
                                                <input type="text" id='KONWA'  class="input-fluid validate[required]  getval" name='Currency[]' title="currency" alt="MULTI" onKeyUp="jspt('KONWA',this.value,event)" autocomplete="off" value='<?php echo $Currency;?>'/>
                                            </td>

                                            <td style="padding-right: 25px">
                                                <input type="text" id='PLANT'  class="input-fluid validate[required]  getval" name='Plant[]' title="plant" alt="MULTI" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" onchange="setChildPlant(this);" value='<?php echo $Plant;?>' />
                                                <div  class='minws1' onclick="lookup_plant('<?=_PLANT?>', 'PLANT')" >&nbsp;</div>
                                            </td>

										<td><input type="hidden"  name="ITEM_TEXT[]" title="item_text" class="getval" id="ITEM_TEXT" /><div class="txt"  onClick="enterText('ITEM_TEXT','')"></div></td>
										<td><input type="hidden"  name="SALES_TEXT[]" title="sales_text" class="getval" id="SALES_TEXT" /><div class="txt"  onClick="enterText('SALES_TEXT','')"></div></td>
                                        <td>   
                                            <div class="prodAvQuotationButton" onclick="poductAvailabityQuotation(this)"></div>
                                        </td>
										</tr>
                                    <?php } else{ 
                                        foreach($arr_val['ITM_NUMBER'] as $avk => $avv) { 
											$componentClass = "";
											$reqQtyAttr = "";
											$reqQtyChildClass = "";
											
											
											$item_number = $arr_val['ITM_NUMBER'][$avk];
											$meterial	= $arr_val['MATERIAL'][$avk];
											$dmeterial	= $arr_val['SHORT_TEXT'][$avk];
											$order_q	= $arr_val['REQ_QTY'][$avk];
											$su			= $arr_val['TARGET_QU'][$avk];
											$Net_Price	= str_replace(",","",$arr_val['COND_VALUE'][$avk]);
											$Per_Unit	= $arr_val['COND_P_UNT'][$avk];
                                            $COND_UNIT	= $arr_val['COND_UNIT'][$avk];
											$Currency=$arr_val['CURRENCY'][$avk];
                                            $Plant=$arr_val['PLANT'][$avk];
											$item_text=$arr_val['LINE'][$avk];
											$high_level_item = $arr_val['HG_LV_ITEM'][$avk];
											$sales_text=$arr_val['SALES_LINE'][$avk];
											$item_categ = $arr_val['ITEM_CATEG'][$avk];
											$high_level_item =  ($arr_val['HIGH_LEVEL_ITEM'][$avk] != 0?$arr_val['HIGH_LEVEL_ITEM'][$avk]:"");
											if($it_num==0)
												$id_num='';
											else{	
												if($id_num == ""){$id_num = 0;}
												
												if($item_categ == "ZTAE"){													
													$id_num++;
												}
												else{								
													if($id_num < 10){$id_num=10;}
													else{					
														$id_num	= (intval($id_num/10)+1)*10;
													}
												}
											}										
											if($item_categ == "ZTAQ"){
												$parentLineNumber = $item_number;
												$componentClass = " parentBOM ";
												$reqQtyAttr = " onChange='calcItemsQty(\"".$parentLineNumber."\",this)' onFocus='saveOrigQty(this.value)'";
											}else if($high_level_item != ""){
												$componentClass = " childBOM component_".$parentLineNumber." ";
												$reqQtyChildClass = " reqQty_".$parentLineNumber." ";
											}

											if($item_categ != "ZTAQ" && $item_categ != "ZTAE"){
												$parentLineNumber = "";
											}										
										?>
										<tr onClick="select_row('ids_<?php echo $avk; ?>')" class="ids_<?php echo $avk; ?> nudf<?=$componentClass?>" >
										
											<td><input class="chkbox check" type="checkbox" name="checkbox[]" title="che" id="chedk"><input type="text" name='item[]' value="<?php echo $id_num+10;?>" title="item" class='input-fluid validate[required,custom[number]]' readonly alt="Items" id="ITM_NUMBER<?php echo $id_num; ?>"/></td>
											<td><img class="info-img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png"/><input type="text" id='MATERIAL<?php echo $id_num; ?>' style="width:60% !important" name='material[]' class="input-fluid validate[required] getval radius " title="MATERIAL" alt="MULTI" onchange="getMatDescBOM('MATERIAL<?php echo $id_num; ?>',this,event,'dataTable')" onKeyUp="jspt('MATERIAL<?php echo $id_num; ?>',this.value,event)" autocomplete="off"  value='<?php echo $meterial;?>'/>
											    <div class='minws1'  onclick="lookup('Material', 'MATERIAL<?php echo $id_num; ?>', 'material')" >&nbsp;</div>
											</td>
											<td>
												<input type="text" title="high_level_item" id='HIGH_LEVEL_ITEM<?php echo $id_num; ?>'  name='HIGH_LEVEL_ITEM[]'  value="<?=$high_level_item?>" class="input-fluid" onChange="setComponent(this)"/>
											</td>
											<td>
												<input type="checkbox" title="is_free_charge" id='IS_FREE_CHARGE<?php echo $id_num; ?>'  name='IS_FREE_CHARGE[]' <?=$item_categ == "AGNN"?"checked":"" ?>  onchange="setFreeCharge(this);"/>
												<input type="hidden" title="free_charge" id='FREE_CHARGE<?php echo $id_num; ?>'  name='FREE_CHARGE[]' value='<?=($item_categ == "AGNN"?"1":"0")?>' />
												<input type="hidden" title="is_charge" id='IS_COMPONENT<?php echo $id_num; ?>'  name='IS_COMPONENT[]' value='<?=($high_level_item != ""?"1":"0")?>' />
												<input type="hidden" title="item_categ" id='ITEM_CATEG<?php echo $id_num; ?>'  name='ITEM_CATEG[]' value='<?=$item_categ?>' />
											</td>											
											<td><input type="text"  id='REQ_QTY<?php echo $id_num; ?>' class="input-fluid validate[required,custom[number]] getval <?=$reqQtyChildClass?>" name='Order_quantity[]' title='order_quantity' alt="MULTI" onKeyUp="jspt('REQ_QTY<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $order_q;?>' <?=$reqQtyAttr?> onchange="getMatDescBOM('MATERIAL',this,event,'dataTable')"/></td>
											<td><input type="text" style="width:50% !important" id='TARGET_QU<?php echo $id_num; ?>' class="input-fluid validate[required] getval radius" name='su[]' title="su" alt="MULTI"
											onKeyUp="jspt('TARGET_QU<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $su;?>'/>
                                               
                                                <div class='minws1' onclick="lookup('SU', 'TARGET_QU', 'uom')" >&nbsp;</div>
                                            </td>
											<td><input type="text"  id='SHORT_TEXT<?php echo $id_num; ?>' class="input-fluid validate[required] getval" name='description[]' title="description" alt="MULTI" onKeyUp="jspt('SHORT_TEXT<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $dmeterial;?>'/></td>
											
											
                                            <td><input type="text"  id='NET_PRICE'  class="input-fluid validate[required] getval" name='Net_Price[]' title="net_price" alt="MULTI" onKeyUp="jspt('NET_PRICE',this.value,event)" autocomplete="off" value='<?php echo $Net_Price;?>'/></td>
											<td><input type="text" id='COND_P_UNT'  class="input-fluid validate[required] getval" name='Per_Unit[]' title="per_unit" alt="MULTI" onKeyUp="jspt('COND_P_UNT',this.value,event)" autocomplete="off" value='<?php echo $Per_Unit;?>'/></td>

                                            <td><input type="text"  id='COND_UNIT<?php echo $id_num; ?>'  class="input-fluid validate[required] getval" name='COND_UNIT[]' title="COND_UNIT" alt="MULTI" onKeyUp="jspt('COND_UNIT<?php echo $id_num; ?>',this.value,event)" autocomplete="off" value='<?php echo $COND_UNIT;?>'/>
                                                <div class='minws1' onclick="lookup('Unit of Measure', 'COND_UNIT', 'uom')" >&nbsp;</div>
                                            </td>

                                            <td>
                                                <input type="text" id='KONWA'  class="input-fluid validate[required]  getval" name='Currency[]' title="currency" alt="MULTI" onKeyUp="jspt('KONWA',this.value,event)" autocomplete="off" value='<?php echo $Currency;?>'/>
                                            </td>

                                            <td>
                                                <input type="text" id='PLANT<?php echo $id_num; ?>'  class="input-fluid validate[required]  getval" name='Plant[]' title="plant" alt="MULTI" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off"  onchange="setChildPlant(this);" value='<?php echo $Plant;?>' />
                                                 <div class='minws1' onclick="lookup_plant('<?=_PLANT?>', 'PLANT<?php echo $id_num; ?>')" >&nbsp;</div>
                                            </td>

										<td><input type="hidden"  name="ITEM_TEXT[]" title="item_text" class="getval" value="<?php echo $item_text; ?>"  id="ITEM_TEXT<?php echo $id_num; ?>" /><div class="txt"  onClick="enterText('ITEM_TEXT','<?php echo $id_num; ?>')"></div></td>
										<td><input type="hidden"  name="SALES_TEXT[]" title="sales_text" class="getval" value="<?php echo $sales_text; ?>"  id="SALES_TEXT<?php echo $id_num; ?>" /><div class="txt"  onClick="enterText('SALES_TEXT','<?php echo $id_num; ?>')"></div></td>
										<td>
                                            <div class="prodAvQuotationButton" onclick="poductAvailabityQuotation(this)"></div>
                                        </td>
                                        </tr>
                                        <?php 
                                            $it_num	= $it_num+1; 
                                        }}?>
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
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
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
        url: 'create_sales_quotation_sold/quotation_sales',			
        success: function(response) 
        {          	     
            $('#loading').hide();
            $("body").css("opacity","1");             
            var spt=response.split("@");
			var msg=$.trim(spt[1])

if(msg!='E'){
    var sendEMail = '<?=Controller::customize_label(_SENDEMAIL);?>';
	jPrompt1('Email Id:', '', sendEMail, function(r) {
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
                    var sapSystemMessage = '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
                    var salesQuotation = '<?=Controller::customize_label(_SALESQUOTATION);?>';
				 	jAlert(sapSystemMessage+'\n'+spt[0], salesQuotation,function(){
				 		$('.getval').val("");
						$('.getvals').html("");
				 		//Reloading page for cleaning up items table
				 		location.reload();
				 	});
					/*if(msg=='S')
		            {
		                $('.getval').val("");
						$('.getvals').html("");
						var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!
						var yyyy = today.getFullYear();
						if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
						$('#datepicker').val(today);
						$('#datepicker1').val(today);
					}*/
				}
				});
				}});
}else
{
    var sapSystemMessage = '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
    var salesQuotation = '<?=Controller::customize_label(_SALESQUOTATION);?>';
	jAlert(sapSystemMessage+''+spt[0], salesQuotation);
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
        var salesQuotation = '<?=Controller::customize_label(_SELECTMATERIALFIRST);?>';
        jAlert(salesQuotation);
    })
});

var inc = 0;
var nut = 0;		

function addRow(tableID) 
{	
    // inc = inc+1;
    if($(document).width()<100)
    {
        $('#pre').show();
        $('#nxt1').show();
        $('.sda').remove();
        $('.nudf').hide();
        $('#pre1').hide();
    }
    var table = document.getElementById(tableID);    
    //Getting last item number to determine which is next
    var lastItemNumber = table.rows[table.rows.length-1].cells[0].lastElementChild.value;
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
	inc = (rowCount-1);
    row.setAttribute('onclick', 'select_row("ids_'+inc+'")');
    row.setAttribute('class', 'ids_'+inc+' nudf');
    var colCount = table.rows[1].cells.length;
    
    nut = parseInt(lastItemNumber/10)*10;
    for(var i=0; i<colCount; i++) 
    {    	
        var newcell = row.insertCell(i);
        //newcell.childNodes[0].insertBefore('hello');
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        //alert(newcell.innerHTML);
        var ind=newcell.getElementsByTagName('input');
        //alert(ind[0].title);
        if(ind[0] != undefined && (ind[0].title=='su' || ind[0].title=='plant' || ind[0].title == "COND_UNIT")){    
         newcell.style.paddingRight="25px"; 
        }

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
	        ind[0].setAttribute("onchange","getMatDescBOM('"+ids+nut+"',this,event,'dataTable')");
            var re=  newcell.getElementsByTagName('div');
            var met='MATERIAL'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+met+"','3@MAT1L');");*/
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material','SALES_ORG,DISTR_CHAN');");
        }

        if(ind[0].title=='su')
        {
            var re=  newcell.getElementsByTagName('div');
            var su='TARGET_QU'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+su+"','0');");*/
            re[0].setAttribute("onclick","lookup('SU', '"+su+"', 'uom');");

        }
        if(ind[0].title=='plant'){                     
            ind[0].setAttribute("onchange","setChildPlant(this)");
            ind[0].value = ""; 
            var re=  newcell.getElementsByTagName('div');
            var met='PLANT'+nut;            
            re[0].setAttribute("onclick","lookup_plant('Plant', '"+met+"');");
        }

        if(ind[0].title=='order_quantity'){        	
        	ind[0].setAttribute("onchange","getMatDescBOM('MATERIAL"+nut+"',this,event,'dataTable')");
	        newcell.firstElementChild.removeAttribute("onfocus");  	        
	    }  
		if(ind[0].title=='item_text')
        {
			ind[0].setAttribute("id","ITEM_TEXT"+nut);
            var re=  newcell.getElementsByTagName('div');
            var et='ITEM_TEXT'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+su+"','0');");*/
            re[0].setAttribute("onclick","enterText('ITEM_TEXT', '"+nut+"');");

        }
        if(ind[0].title=='high_level_item')
        {
			ind[0].setAttribute("id","HIGH_LEVEL_ITEM"+nut);
            var re=  newcell.getElementsByTagName('div');
            var et='HIGH_LEVEL_ITEM'+nut;                       

        }
        if(ind[0].title=='sales_text')
        {
			ind[0].setAttribute("id","SALES_TEXT"+nut);
            var re=  newcell.getElementsByTagName('div');
            var et='SALES_TEXT'+nut;
            /*re[0].setAttribute("onclick","tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+su+"','0');");*/
            re[0].setAttribute("onclick","enterText('SALES_TEXT', '"+nut+"');");

        }
         if(ind[0].title=='is_free_charge')
        {        	
			ind[0].setAttribute("id","IS_FREE_CHARGE"+nut);
			ind[1].setAttribute("id","FREE_CHARGE"+nut);
			ind[1].setAttribute("value","0");
			ind[2].setAttribute("id","IS_COMPONENT"+nut);
			ind[2].setAttribute("value","0");
			ind[3].setAttribute("id","ITEM_CATEG"+nut);
			ind[3].setAttribute("value","");			
            var re=  newcell.getElementsByTagName('div');
            var et='FREE_CHARGE'+nut;            
        }   
              
        if(ind[0].title == "net_price"){        	
        	ind[0].removeAttribute("readonly");
        }
        if(ind[0].title == "per_unit"){        	
        	ind[0].removeAttribute("readonly");
        }
        if(ind[0].title == "COND_UNIT"){
            ind[0].removeAttribute("readonly");                            
            var re=  newcell.getElementsByTagName('div');
            var met='COND_UNIT'+nut;            
            re[0].setAttribute("onclick","lookup('UOM', '"+met+"', 'plant','plant');");
        }
        if(ind[0].title == "currency"){        	
        	ind[0].removeAttribute("readonly");
        }
        if(ind[(ind.length-1)].title=='item')
        {
            var numb=newcell.childNodes[0].value;
			var ids=ind[(ind.length-1)].id;
			ind[(ind.length-1)].id=ids+nut;
            // ind[(ind.length-1)].value='0000'+(nut+10);
            ind[(ind.length-1)].value=(nut+10);
            $(ind[(ind.length-1)]).attr("value",nut+10);
	        ind[(ind.length-1)].setAttribute("readonly", true);
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
                    var oneItemRequired = '<?=Controller::customize_label(_ONEITEMREQUIRED);?>';
                    var message = '<?=Controller::customize_label(_MESSAGE);?>';
                    jAlert(oneItemRequired, message);
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
                var parentComponent = row.classList.contains("parentBOM");                
                var childComponent  = row.classList.contains("childBOM");                
                if(chkbox.id!='head')
                {
                    if(chkbox.checked)
                    {						            
                    	if(childComponent){
                    		var parentComponentNumber = parseInt(row.cells[2].children[0].value);
                    		var parentIsChecked = $("input[name='item[]'][value='"+parentComponentNumber+"']")[0].previousElementSibling.checked;
                    		if(!parentIsChecked){
                    			cunt=cunt+1;
                    		}
                    	}else{
                        	cunt=cunt+1;
                        }
                        if(parentComponent){                        	
                        	var parentLineNumber = $(row.cells[0]).find("input[name='item[]']")[0].value;
                        	var numComponents = $(".component_"+parentLineNumber).length;                        	
                        	cunt += numComponents;
                        }
                    }
                }
            }
            if(cunt == rowCount-1)
            {
                var oneItemRequired = '<?=Controller::customize_label(_ONEITEMREQUIRED);?>';
                var message = '<?=Controller::customize_label(_MESSAGE);?>';
                jAlert(oneItemRequired, message);
            }
            else
            {
                for(var i=0; i<rowCount; i++) 
                {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    var parentComponent = row.classList.contains("parentBOM"); 
                    if(chkbox.id!='head')
                    {
                        if(null != chkbox && true == chkbox.checked)
                        {
                            table.deleteRow(i);
                            rowCount--;
                            i--;
                            if(parentComponent){
	                        	var parentLineNumber = row.cells[0].childNodes[2].value;
	                        	var components = $(".component_"+parentLineNumber);
	                        	var numComponents = components.length;           	
	                        	components.remove();
	                        	rowCount -= numComponents;
	                        	i-= numComponents;
	                        }
                        }
                    }
                }
            }
        }
        catch(e) {
        }
    }
	var num=0;
	var currentRow = 0;
	$('#'+tableID+" tbody tr").each(function(index, element) 
	{
		var isParent = false;	
		var isChild = false;	
		var matID	= "";
		if(this.classList.contains("parentBOM")){			
			isParent = true;
			var currentLineNumber = $(this.cells[0]).find("input[name='item[]']")[0].value;
		}
		if(this.classList.contains("childBOM")){
			isChild = true;			
		}
		$(this).addClass('ids_'+num);
		if(isParent){
			$(this).addClass('parentBOM');
		}
		if(isChild){
			$(this).addClass('childBOM');	
		}
		$(this).attr('onclick', 'select_row("ids_'+num+'")');
		var tds = $(this).find('td');
		
		if(index > 0)
		{			
			currentRow = num;
			$(this).find('input').each(function(inpindex, inpelement)
			{				
				if(!isChild){										
					if(currentRow == 0){
						num = (10 * index);
					}
					else{
						num = (parseInt((currentRow-1)/10)*10)+10;
					}
				}else{					 
					num = currentRow;	 
				}
				if(inpindex == 1){
					$(this).val((num+10));
					if(isParent){
						var components = $(".component_"+currentLineNumber);
						components.removeClass(".component_"+currentLineNumber);
						components.addClass(".component_"+(parseInt(num)+10).toString());
					}
				}				
				var id = $(this).attr("id");
				var newid = id.replace(/\d+$/, num);
				$(this).attr('id', newid);
				if(inpindex > 1)
					$(this).attr("onKeyUp","jspt('"+newid+"',this.value,event)");
				if(inpindex == 2){					
					matID = newid;
					$(this).attr("onchange","getMatDescBOM('"+newid+"',this,event,'dataTable')");
				}
				if(inpindex == 8){								
					$(this).attr("onchange","getMatDescBOM('"+matID+"',this,event,'dataTable')");
				}
                if(inpindex == 12){                              
                    $(this).attr("onchange","setChildPlant(this)");
                }
			});
			
			$(this).find('.minws1').each(function(spanindex, spanelement)
			{				
				var num = (10 * index);
				var id = $(this).prev().attr("id");
				//var newid = id.replace(/\d+$/, num);				
				//var newid = id.match(/(\d+|[^\d]+)/g);
				if(spanindex == 0)
                    $(this).attr("onclick", "lookup('Material', '"+id+"', 'material');");
					/*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','"+newid+"','3@MAT1L');");*/
				if(spanindex == 1)
					$(this).attr("onclick", "lookup('SU', '"+id+"', 'uom');");
                    /*$(this).attr("onclick", "tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','"+newid+"','0');");*/
			});
			$(this).find('.txt').each(function(spanindex, spanelement)
			{
				var id = $(this).prev().attr("id");
				var newid = id.match(/(\d+|[^\d]+)/g);
				if(spanindex == 0)
					$(this).attr("onClick","enterText('ITEM_TEXT','"+newid[1]+"');");
				if(spanindex == 1)
				$(this).attr("onClick","enterText('SALES_TEXT','"+newid[1]+"');");
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
				if(inpindex == 2){
					matID = newid;
					$(this).attr("onchange","getMatDescBOM('"+newid+"',this,event,'dataTable')");
				}
				if(inpindex == 8){					
					$(this).attr("onchange","getMatDescBOM('"+matID+"',this,event,'dataTable')");
				}
                if(inpindex == 12){                  
                    $(this).attr("onchange","setChildPlant(this)");
                }                
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
        $('.'+ids).find('input:checkbox.chkbox').prop('checked', false);
    }
    else
    {
        $('.'+ids).addClass('bb');
        $('.'+ids).find('input:checkbox.chkbox').prop('checked', true);
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

function setFreeCharge(checkbox){	
	if(checkbox.checked){
		$("#FREE_CHARGE"+checkbox.id.split("CHARGE")[1]).val("1");		
		$("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).val("0");
		$("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");		
		$("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");
		$("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).val("0");		
		$("#KONWA"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");		
		$("#ITEM_CATEG"+checkbox.id.split("CHARGE")[1]).val("AGNN");		
	}else{
		$("#FREE_CHARGE"+checkbox.id.split("CHARGE")[1]).val("0");		
		$("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).prop("readonly","");		
		$("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).prop("readonly","");		
		$("#KONWA"+checkbox.id.split("CHARGE")[1]).prop("readonly","");		
		$("#ITEM_CATEG"+checkbox.id.split("CHARGE")[1]).val("");
	}
}

function setComponent(highLevelItem){
	if(highLevelItem.value != "" && parseInt(highLevelItem.value) != 0){
		$("#IS_COMPONENT"+highLevelItem.id.split("ITEM")[1]).val("1");
		if(!$("#IS_FREE_CHARGE"+highLevelItem.id.split("ITEM")[1]).prop("checked")){
			$("#ITEM_CATEG"+highLevelItem.id.split("ITEM")[1]).val("ZTAE");	
		}
	}
	else{
      $("#IS_COMPONENT"+highLevelItem.id.split("ITEM")[1]).val("0");
      if(!$("#IS_FREE_CHARGE"+highLevelItem.id.split("ITEM")[1]).prop("checked")){
         $("#ITEM_CATEG"+highLevelItem.id.split("ITEM")[1]).val("");   
      }
   }
}

function poductAvailabityQuotation(element){    
    var plant = $(element.closest("tr")).find("input[name='Plant[]']").val();
    var material = $(element).parent().parent().find("input[name='material[]']").val();    
    if(material == undefined || material == null || material.trim() == ""){
        jAlert("Select a material","Message",);
    }else if(plant == undefined || plant == null || plant.trim() == ""){
        jAlert("Select plant","Message");
    }else{
        show_prod_avail_quotation(material,plant,"product_availability_quotation",true);
    }
}

</script>