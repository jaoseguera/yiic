<?php
if(isset($_SESSION['total_line_items']))
{
	for($j=1;$j<=$_SESSION['total_line_items'];$j++)
	{
		unset($_SESSION['line_item_'.$j]);
	}
	unset($_SESSION['total_line_items']);
}
$customize = $model;
?>
<style>
			.minw { background:url(../images/tipup.png) no-repeat; height:10; width:11px; position:absolute; margin-left:-18px; margin-top:11px; cursor:pointer; }
			.minw3 { background:url(../images/tipup1.png) no-repeat; height:10; width:11px; margin-top:15px; padding-right:7px; margin-left:-18px; cursor:pointer; }
			.minw4 { background:url(../images/tipup1.png) no-repeat; height:10; width:11px; padding-right:7px; margin-top:-20px; position:absolute; cursor:pointer; margin-left:53px; }
			#digs { width:800px; height:477px; display:none; position:fixed; margin-left:9%; z-index:1000px; background:#fff;border:1px solid #cecece;border-radius:5px;top:90px;}
			#dialog { width:790px; height:385px; overflow:auto; margin-top:0px; margin-left:10px; border-bottom:1px solid #cecece;}
			.tip_cls { margin-top:10px !important;margin-right:10px !important; }
			.c_bt { margin-top:7px; float:right; margin-right:20px; z-index:10; font-weight:bold; padding:5px; width:80px; cursor:pointer; }
			#loading { width:100%; padding-top:25%; text-align: center; margin:auto; display: none; z-index:10; position:absolute; }
			#title { width:95%; padding:11px; margin-top:0px; cursor:move; color:#333333; font-weight:bold; font-size:16px; margin-left:1px; }
			
			.create_2:hover td
			{
			background-color:#fff !important;
			}
			.nudf:hover td
			{
				background-color:#f3f3f3 !important;
			}
			.color_two,
			.color_one
			{
				display:none !important;
			}
			select,
			input[type=text]
			{
				width:90px;
				min-width:0px !important;
				padding:0px !important;
				margin:0px !important;
				border-radius:0px !important;
				height:auto !important;
			}
			input[type=button]
			{
				padding:2px 5px 2px 5px !important;
			}
			.table_cols div
			{
				 display: table-cell;
				 padding-right:5px;
			}
			.label_wid
			{
				width:90px;
				text-align:right;
			}
			.label_wids
			{
				width:100px;
				text-align:right;
			}
			.flash fieldset
			{
				
				border:1px solid #cecece !important;
				 padding:5px !important;
				 border-radius:3px !important;
				 margin-top:5px !important;
			}
			.flash legend
			{
				font-size:13px !important;
				border:none !important;
				border-bottom: none !important;
				 line-height:0px !important;
				 margin:0px !important;
				 width:auto !important;
				
			}
			.nav-tabs > li > a {
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
    line-height: 0px !important;
    padding-bottom:8px !important;
    padding-top:8px !important;
}
.profit_an div
{
	margin-top:-4px !important;
	
}
.flashpopup tr td
{
	margin-top:-4px !important;
}
.marg_height div
{
	margin-top:-3px;
}
.marg_heights div
{
	margin-top:-0.5px;
}
.forward_en,
.back_en
{
	cursor:pointer;
}
.compr div
{
	margin-top:-8px;
}
.compr input[type=text]
{
	height:15px !important;
	
}
.need_by,
.book_wk
{
	background:#fff url(../img/icons/Calendar-icon.png) no-repeat;
	background-position:center right;
}
		</style>

		<div id='digs' >
        <input type="button" value="" class="c_bt tip_cls" id="clse"/>
			<div id='title' style="padding-right:30px;margin:0px !important;"></div>
			<div id="dialog" ></div>
			<input type="button" value="Cancel" class="c_bt" id="clse1"/> <input type="button" value="Ok" class="c_bt" id='ok_it'/>
		</div>

					
							
							<div class="utopia-widget-content" style="height:auto !important;padding:0px;margin:0px;">
								
									
										<div class="tabbable" style="width:100% !important;padding:0px;margin-top:-5px;">
											<ul class="nav nav-tabs" style="margin:0px !important;">
												<li class="active"><a href="#tab-below-ct1" data-toggle="tab">Header</a></li>
												<li><a href="#tab-below-ct2" data-toggle="tab">Lines</a></li>
											</ul>
											
											<div class="tab-content" style="border-top:none;background-color:#edeeff;">
												<div class="tab-pane active" id="tab-below-ct1">
													<form action="javascript:subt_form()" id="validation">
                                                      <fieldset class="span12" >
  <div class="span3 utopia-form-freeSpace">
              <fieldset>
                               <label class="control-label1 cutz" for="input01" alt="Sales Organization"><?php echo Controller::customize_label('Sales Organization');?><span>*</span>:</label>

                                                                 
      <input alt="Sales Organization" type="text" name='SALES_ORG' id='SALES_ORG' class="input-fluid validate[required,custom[salesorder]] getval radius" value='1000' onKeyUp="jspt('SALES_ORG',this.value,event)" autocomplete="off" style="width:185px;"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
  
                                          </fieldset></div>
<div class="span3 utopia-form-freeSpace">
              
                   <fieldset>

 <label class="control-label1 cutz" for="date" alt="Name"><?php echo Controller::customize_label('Customer Number');?><span>*</span>:</label>
 <input alt="Customer Number" type="text" name='PARTN_NUMB' id='PARTN_NUMB' class="input-fluid validate[required,custom[customer]] getval radius" onchange="number(this.value)" value='0000100000' onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off" style="width:185px;"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>-->
         </fieldset></div>




<div class="span3 utopia-form-freeSpace">
              
                   <fieldset>
                                   
                               <label class="control-label1 cutz" for="input01" alt="City"><?php echo Controller::customize_label('Distribution. Channel');?><span>*</span>:</label>
           <input alt="Distribution. Channel" type="text" name='DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required,custom[dis]] getval radius" value='10' onKeyUp="jspt('DISTR_CHAN',this.value,event)" autocomplete="off" style="width:185px;"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>    --->
            </fieldset></div>
           
           <div class="span3 utopia-form-freeSpace">
              
                   <fieldset>
                               <label class="control-label1 cutz" for="input01" alt="Postal Code"><?php echo Controller::customize_label('Purchase Order Number');?><span>*</span>:</label>
             <input alt="Purchase Order Number" type="text" name='PURCH_NO_C' id='PURCH_NO_C' class="input-fluid validate[required] getval radius" value='0080000009' onKeyUp="jspt('PURCH_NO_C',this.value,event)" autocomplete="off" style="width:185px;"/>
             </fieldset> </div>
           
 </fieldset>
 <fieldset class="span12" style="padding:0px;margin:0px;">

			 <div class="span3 utopia-form-freeSpace" >
			 <fieldset >
     <label class="control-label1 cutz" for="input01" alt="Sales Document Type"><?php echo Controller::customize_label('Sales Document Type');?><span>*</span>:</label>
 <input alt="Sales Document Type" type="text" name="DOC_TYPE" id='DOC_TYPE' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DOC_TYPE',this.value,event)" autocomplete="off" value='TA' style="width:185px;"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DOC_TYPE','Sales Document Type','DOC_TYPE','0')" >&nbsp;</span>-->
                                          </fieldset>
										  </div>
                                          
                                          <div class="span3 utopia-form-freeSpace" >
			 <fieldset >
     <label class="control-label1 cutz" for="input01" alt="Division"><?php echo Controller::customize_label('Division');?><span>*</span>:</label>
 <input alt="Division" type="text" name='DIVISION' id='DIVISION' class="input-fluid validate[required,custom[divi]] getval radius" onKeyUp="jspt('DIVISION',this.value,event)" autocomplete="off" value='10' style="width:185px;"/><!---<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','DIVISION','2')" >&nbsp;</span>--->
                                          </fieldset>
										  </div>
                                          
                                          <div class="span3 utopia-form-freeSpace" >
			 <fieldset >
     <label class="control-label1 cutz" for="input01" alt="Plant"><?php echo Controller::customize_label('Plant');?> <span>*</span>:</label>
 <select  onchange="select_type(this.value)" style="width:185px;" class="input-fluid validate[required] getval radius plant"> 
                                                                <option value="">Select Options</option>
                                                                <option value="CPB" selected="selected">CPB</option>
                                                                <option value="LPB">LPB</option>
                                                                <option value="BMDF">BMDF</option>
                                                                <option value="DPB">DPB</option>
                                                                <option value="MMDF">MMDF</option>
                                                                <option value="EMDF">EMDF</option>
                                                                <option value="SSN">SSN</option>
                                                                <option value="SSM">SSM</option>
                                                                </select>
                                          </fieldset>
										  </div>
                                          
                                          <div class="span3 utopia-form-freeSpace" >
			 <fieldset >
     <label class="control-label1 cutz" for="input01" alt="Requested Delivery Date"><?php echo Controller::customize_label('Requested Delivery Date');?><span>*</span>:</label>
 <input alt="Requested Delivery Date" type="text" name='Delivery' id='datepicker' class="input-fluid validate[required,custom[date]] getval radius" style="width:185px;"/>
                                          </fieldset>
										  </div>
                                          
										  <br>
										  

 </fieldset>
 
 
  <fieldset class="span12" style="padding:0px;margin:0px;">

			 <div class="span3 utopia-form-freeSpace" >
			 <fieldset >
     <label class="control-label1 cutz" for="input01" alt="Sales Document Type"><?php echo Controller::customize_label('Ship to Party');?><span>*</span>:</label>
 <input alt="Sales Document Type" type="text" name="sold_to_party" id='sold_to_party' class="input-fluid validate[required] getval radius" onKeyUp="jspt('sold_to_party',this.value,event)" autocomplete="off" value='00001000000' style="width:185px;"/>
                                          </fieldset>
										  </div>
                                          <br />
                                          </fieldset>
                                       <div class="span3 utopia-form-freeSpace" >
                                          <input type="submit" value="<?php echo _SUBMIT ?>" class='btn btn-primary bbt' />
                                         </div>
                                          </form>
  <!------------------------------------------------------------------------------------------------------------------------------------->                                            
		
												

													
												</div>
												
												<div class="tab-pane" id="tab-below-ct2" >
												<?php $row = 1; ?>
<div class="row-fluid" style="margin-top:-5px;">
<div class="span12">
			<table  width="100%" class="flash">
            <tr>
            <td colspan="2">
            <fieldset>
    <legend></legend>
            <table width="100%" ><tr>
            <td>Line Number: </td><td><span><img src="../images/back_end_enabled_hover.png" class="back_en_end"/></span><span><img src="../images/back_enabled_hover.png" class="back_en"/></span><select  name='line_number' class="line_number" onchange="incnumber(this.value)">
            <option value="1" class="line_number_1">1</option>
            <option value="none" style="display:none;" class="appen">none</option>
            </select><span><img src="../images/forward_enabled_hover.png" class="forward_en" /><img src="../images/forward_disabled.png" class="forward_en_des" style="display:none;"/></span><span><img src="../images/forward_end_enabled_hover.png" class="forward_en_end"/><img src="../images/forward_end_des.png" class="forward_en_end_des" style="display:none;"/></span> <span id="prev_cl" style="display:none;">1</span></td>
            <td><input type="button" value="Add Item" class="btn add_item" alt="2" /></td>
            <td>Order MHC: <span><input type='text' name="order_mhc"  class="emt order_mhc" id="order_mhc_1"/></span></td>
            <td>Open Line: <span><input type="checkbox"  name="open_line"class="emt_ch open_line"/></span></td>
            <td>FSC: <span><input type="checkbox"  name="fsc" class="emt_ch fsc"/></span></td>
            <td>FSC Controlled: <span><input type="checkbox" name="fsc_controlled" class="emt_ch fsc_controlled"/></span></td>
            </tr></table>
         </fieldset>
            </td>
            </tr>
            <tr>
            <td colspan='2'>
            <fieldset>
    <legend></legend>
            <table  width="100%" ><tr>
            <td width="390px" class="marg_height">
            <div class="table_cols">
            <div style="width:80px;text-align:right;">Part/Rev:</div>
            <div><input type="text"  name="numbers" class="emt numbers" id="numbers_1"/></div>
            <div><select style="width:100px;" name="sele_numbers" class="em_sel sele_numbers" disabled="disabled"><option>Select</option></select></div>
            <div><input type="button" value="Configure" class="btn configure"  alt='1' onclick="tipup('Configure','test')"/></div>
            </div>
            <div style="margin-left:85px;margin-top:3px !important;"><textarea  rows="1" class="emt text" name="text" id="text_1"></textarea></div>
            <div class="table_cols"><div>Customer Part:</div>
            <div><input type="text" name="customer_part" class="emt customer_part" id="customer_part_1"/></div>
            </div>
            <div style="margin-left:30px;margin-top:5px;">Enter Target MHC to See Required Selling Price</div>
            </td>
            <td class="marg_height">
            <div class="table_cols"><div class="label_wid"></div><div style="width:90px;text-align:center;">Width</div><div style="width:90px;text-align:center;">Length</div></div>
            <div class="table_cols"><div class="label_wid" >Chg As</div><div><input type="text" name="wid_chg_as" class="emt wid_chg_as" id="wid_chg_as_1"/></div><div><input type="text" name="hig_chg_as" class="emt hig_chg_as" id="hig_chg_as_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Raw Part</div><div><input type="text" name="wid_raw_part" class="emt wid_raw_part" id="wid_raw_part_1"/></div><div><input type="text" name="hid_raw_part" class="emt hid_raw_part" id="hid_raw_part_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Side 1 Part</div><div><input type="text" name="wid_side_1_part" class="emt wid_side_1_part" id="wid_side_1_part_1"/></div><div><input type="text" name="hig_side_1_part" class=" emt hig_side_1_part" id="hig_side_1_part_1"/></div><div><input type="text" style="width:30px;" name="side_1_part" class="emt side_1_part" id="side_1_part_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Side 2 Part</div><div><input type="text" name="wid_side_2_part" class="emt wid_side_2_part" id="wid_side_2_part_1"/></div><div><input type="text" name="hig_side_2_part" class="emt hig_side_1_part" id="hig_side_2_part_1"/></div><div><input type="text" style="width:30px;" name="side_2_part" class="emt side_2_part" id="side_2_part_1"/></div></div>
            </td>
            <td class="marg_height">
            <div class="table_cols"><div class="label_wid">On Hand:</div><div><input type="text" name="on_hand" class="emt on_hand" id="on_hand_1" /></div></div>
            <div class="table_cols"><div class="label_wid">Available:</div><div><input type="text" name="available" class="emt available" id="available_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Shipped:</div><div><input type="text" name="shipped" class="emt shipped" id="shipped_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Quote/Line:</div><div><input type="text" name="quote_line" class="emt quote_line" id="quote_line_1"/></div><div><input type="text" style="width:30px;" name="sub_quote" class="emt sub_quote" id="sub_quote_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Last Sold Date:</div><div><input type="text" name="last_sold_date" class="emt last_sold_date" id="last_sold_date_1"/></div></div>
            </td>
            </tr>
            </table>
            </fieldset>
            </td>
            </tr>
            <tr>
            <td valign="top">
            <table  width="100%">
            <tr>
            <td  valign="top">
            <fieldset>
    <legend></legend>
            <table width="100%"><tr>
            <td class="marg_heights">
            <div class="table_cols"><div class="label_wid">Order Quantity:</div><div><input type="text" name="order_qty" class="emt order_qty" id="order_qty_1"/></div><div><input type="text" name="sub_order_qty" class="emt sub_order_qty" id="sub_order_qty_1"/></div></div>
            <div class="table_cols"><div style="width:20px;"><input type="checkbox" /></div><div style="width:65px;">Price/MSF:</div><div><input type="text" name="price_msf" class="emt price_msf" id="price_msf_1"/></div><div><input type="text" name="sub_price_msf" class="emt sub_price_msf" id="sub_price_msf_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Pcs/Unit:</div><div><input type="text" name="pcs_unit" class="emt pcs_unit" id="pcs_unit_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Cust Pcs/Unit:</div><div><input type="text" name="cust" class="emt cust" id="cust_1"/></div></div>
            <div class="table_cols"><div class="label_wid"># of Unit:</div><div><input type="text" name="of_unit" class="emt of_unit" id="of_unit_1"/></div></div>
           <div class="table_cols"><div class="label_wid">Pack Code:</div><div><select style="width:150px;" disabled="disabled"><option>Select option</option></select></div>
            </div>
          <div style="padding:3px;"></div>
           <div><input type="button" value="Lock Unit Price" class="btn"/></div>
            </td>
            <td>
            <div class="table_cols"><div class="label_wid">Unit Price:</div><div><input type="text" name="unit_price" class="emt unit_price" id="unit_price_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Ext Price:</div><div><input type="text" name="ext_price" class="emt ext_price" id="ext_price_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Misc:</div><div><input type="text" name="misc" class="emt misc" id="misc_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Tax:</div><div><input type="text" name="tax" class="emt tax" id="tax_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Total Price:</div><div><input type="text" name="total_price" class="emt total_price" id="total_price_1"/></div></div>
            </td>
            <td>
            <div class="table_cols"><div class="label_wid">Book WK:</div><div><input type="text" value="" id='datepicker2' class="book_wk"/></div></div>
            <div class="table_cols"><div class="label_wid">Need By:</div><div><input type="text" value="" id='datepicker3' class="need_by"/></div></div>
            <div class="table_cols"><div class="label_wid">Referance:</div><div><input type="text" name="referance" class="emt referance" id="referance_1"/></div></div>
            <div class="table_cols"><div class="label_wid">PO Line:</div><div><input type="text" name="po_line" class="emt po_line" id="po_line_1"/></div></div>
            </td>
            </tr>
            </table>
            </fieldset>
            </td>
            </tr>
            <tr>
            <td >
              <fieldset>
    <legend>Square FootageWeights</legend>
    
            <table width="100%"><tr>
            <td><div>Line Weight</div><div><input type="text" name="line_weight" class="emt line_weight" id="line_weight_1"/></div></td>
            <td><div>Charge Sqft</div><div><input type="text" name="charge_sqft" class="emt charge_sqft" id="charge_sqft_1"/></div></td>
            <td><div>Autual Sqft</div><div><input type="text" name="autual_sqft" class="emt autual_sqft" id="autual_sqft_1"/></div></td>
            <td><div>Ship Via Weight</div><div><input type="text" name="ship_via_weight" class="emt ship_via_weight" id="ship_via_weight_1"/></div></td>
            <td><div>Order Weight</div><div><input type="text" name="order_weight" class="emt order_weight" id="order_weight_1"/></div></td>
            <td><div># Loads</div><div><input type="text" name="loads" class="emt loads" id="loads_1"/></div></td>
            </tr>
            
            </table>
            <div style="padding:3px;"></div>
            </fieldset>
            </td>
            </tr>
            </table>
            </td>
            <td valign="top" class="profit_an">
            <fieldset>
    <legend>Profit Analysis</legend>
   
            <div class="table_cols"><div class="label_wid">Price: </div><div><input type="text" name="price" class="emt price" id="price_1" onchange="price_de(this.value)"/></div></div>
            <div class="table_cols"><div class="label_wid">Variable Cost: </div><div><input type="text" name="variable_cost" class="emt variable_cost" id="variable_cost_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Fixed Cost: </div><div><input type="text" name="fixed_cost" class="emt fixed_cost" id="fixed_cost_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Overheads: </div><div><input type="text" name="overheads" class="emt overheads" id="overheads_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Freight: </div><div><input type="text" name="freight" class="emt freight" id="freight_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Packaging: </div><div><input type="text" name="packaging" class="emt packaging" id="packaging_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Total Cost: </div><div><input type="text" name="total_cost" class="emt total_cost" id="total_cost_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Profit: </div><div><input type="text" name="profit" class="emt profit" id="profit_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Profit @ 3/4: </div><div><input type="text" name="profit_3" class="emt profit_3" id="profit_3_1"/></div></div>
            <div class="table_cols"><div class="label_wid">MHC: </div><div><input type="text" name="mhc" class="emt mhc" id="mhc_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Chq Ovr MHC: </div><div><input type="text" name="chq_ovr_mhc" class="emt chq_ovr_mhc" id="chq_ovr_mhc_1"/></div></div>
            <div class="table_cols"><div class="label_wid">Depreciation: </div><div><input type="text" name="depreciation" class="emt depreciation" id="depreciation_1"/></div></div>
           
            </fieldset>
            </td>
            </tr>
            </table>													
	</div>
</div>

<div>
														
													</div>
													
												<script type="text/javascript">
												function myFunction(value,inc,subt,type)
                                                 {
												
	                                        var w=inc.toString();
	                                        var len=w.split('.');
	                                        var y=value;
                                            var x=parseFloat(y)-Number(subt);
                                            var z=x.toFixed(len[1].length)%inc;
											
										
											if(z.toString().indexOf('.')!=-1)
											{
		 
			jAlert('Value should have increment of '+inc+'','Message',function(r)
			{
				if(r)
				{
					
				   $('.'+type+'_w').val('');
			$('.'+type+'_w').focus();
				}
			});
											}
                                            
                                                    }
												function price_de(value)
												{
												
													$('.price').val(parseFloat(value).toFixed(2));
													$('.price_msf').val(parseFloat(value).toFixed(2));
												}
												function round_math(value)
												{
													return Math.round(value * 100) / 100
												}
												function subt_form()
												{
													$('#loading').show();
	 $("body").css("opacity","0.4"); 
	  $("body").css("filter","alpha(opacity=40)"); 
													var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
															$('.line_number').val(fnl);
															$('.configure').attr('alt',fnl);
														
															submt(fnl);
													
													
												}
												function select_type(value)
												{
													$.cookie('Item_type',value);
												}
												function submt(num)
												{
													
														   //alert(num);
														   var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
														   if(fnl==num)
															{
															$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
															}
															else
															{
																$('.forward_en').show();
															$('.forward_en_des').hide();
															$('.forward_en_end').show();
															$('.forward_en_end_des').hide();

															}
														   
														   //.................
														   var nums=$('#prev_cl').html();
														   $('#prev_cl').html(num);
														   	var variable;
															$('.emt').each(function(index, element) {
                                                                var name=$(this).attr('name');
																var ids=$(this).attr('id',name+'_'+num);
																var value=$(this).val();
																
																variable += name+'_'+nums+'@'+value+',';
																$(this).val('');
                                                            });
															var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
															$.ajax({
															type:'POST', 
															url: '../lib/line_items.php?value='+variable+'&num='+nums+'&get_v='+num+'&frw='+fnl, 
															success: function(response) 
															{
															var sale_org=$('#SALES_ORG').val();
													var part=$('#PARTN_NUMB').val();
													var divis=$('#DIVISION').val();
													var disrt=$('#DISTR_CHAN').val();
													var doc_type=$('#DOC_TYPE').val();
													var prch=$('#PURCH_NO_C').val();
													var devr=$('#datepicker').val();
													$.ajax({
														type:'POST', 
	url: '../lib/controller.php?url=fb_sales_order_create&page=bapi&bapiName=BAPI_SALESORDER_CREATEFROMDAT2&SALES_ORG='+sale_org+'&PARTN_NUMB='+part+'&DISTR_CHAN='+disrt+'&DOC_TYPE='+doc_type+'&DIVISION='+divis+'&PURCH_NO_C='+prch+'&Delivery='+devr,
															success: function(response) 
															{
																$('#loading').hide();
			                                                $("body").css("opacity","1"); 
																//alert(response);
																jAlert(response,'Message')
															}
														}) 
																}});
															
															
															
                                                        
												}
												function incnumber(num)
                                                       {
														   //alert(num);
														   var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
														   if(fnl==num)
															{
															$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
															}
															else
															{
																$('.forward_en').show();
															$('.forward_en_des').hide();
															$('.forward_en_end').show();
															$('.forward_en_end_des').hide();

															}
														   
														   //.................
														   var nums=$('#prev_cl').html();
														   $('#prev_cl').html(num);
														   	var variable;
															$('.emt').each(function(index, element) {
                                                                var name=$(this).attr('name');
																var ids=$(this).attr('id',name+'_'+num);
																var value=$(this).val();
																
																variable += name+'_'+nums+'@'+value+',';
																$(this).val('');
                                                            });
															var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
															$.ajax({
															type:'POST', 
															url: '../lib/line_items.php?value='+variable+'&num='+nums+'&get_v='+num+'&frw='+fnl, 
															success: function(response) 
															{
																
																var count=response.split(',');
															var i=0;
															for(i=0;i<=count.length;i++)
															{
																var spl=count[i].split('@');
																$('#'+spl[0]).val(spl[1]);
															}
																}});
															
															
															
                                                        }	
													$(document).ready(function() 
													{
													$('.numbers').keyup(function() {
														if($(this).val()=='')
														{
															$('.emt').val('');
														}
													});
														$('.order_qty').keyup(function()
														{
															var value=$('.price').val();
															var line=$('.configure').attr('alt');
															var wid=$('#wid_chg_as_'+line).val();
					                             var len=$('#hig_chg_as_'+line).val();	
												 var legth_width=(Number(len))*(Number(wid))/144;
												 $('#ext_price_'+line).val(round_math(($('.order_qty').val()*((Number(value)/1000)*legth_width))));
				
				$('#of_unit_'+line).val(round_math(Number($('.order_qty').val())/Number($('.pcs_unit').val())));
														})
														$('.price').keyup(function(e) {
                                                            var value=$(this).val();
															var line=$('.configure').attr('alt');
															
															$('#price_msf_'+line).val(value);
															var total_cst=$('#total_cost_'+line).val();
															var profit=Number(value)-Number(total_cst);
															$('#profit_'+line).val(round_math(profit));
															
														
															var mch=Number(profit)/Number($('#mhc_'+line).attr('title'));
					$('#mhc_'+line).val(round_math(mch));
					$('#order_mhc_'+line).val(round_math(mch));
					var wid=$('#wid_chg_as_'+line).val();
					var len=$('#hig_chg_as_'+line).val();
						var legth_width=(Number(len))*(Number(wid))/144;
				$('#unit_price_'+line).val(round_math((Number(value)/1000)*legth_width));
				
					$('#ext_price_'+line).val(round_math($('.order_qty').val()*((Number(value)/1000)*legth_width)));
															
															
															
															
                                                        });
														$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
														$('.add_item').click(function()
														{
															var inc=$(this).attr('alt');
															var incs=Number(inc)+1;
									$('.appen').replaceWith("<option value='"+inc+"' selected='selected' class='line_number_"+inc+"'>"+inc+"</option><option class='appen' style='display:none;'></option>");
															$(this).attr('alt',incs);
															$('.configure').attr('alt',inc);
															incnumber(inc);
															$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
														})
														
														var total_len=5;
														var i=0;
														for(i=1;i<=total_len;i++)
														{
															$.cookie('Line_items'+i,'');
															$.cookie('Total_line',1);
														}
														$('.forward_en').click(function()
														{
															
															var ids=$('#prev_cl').html();
															var ds=Number(ids)+1;
															$('.line_number').val(ds);
															$('.configure').attr('alt',ds);
															
															//$('.line_number]').val();
															var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
															if(fnl==ds)
															{
															$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
															}
														incnumber(ds)
															})
														$('.back_en').click(function()
														{
															$('.forward_en').show();
															$('.forward_en_des').hide();
															$('.forward_en_end').show();
															$('.forward_en_end_des').hide();
															var ids=$('#prev_cl').html();
															var ds=Number(ids)-1;
															$('.line_number').val(ds);
															$('.configure').attr('alt',ds);
															//$('.line_number]').val()
														incnumber(ds);
															})
														//............................................................
														
														$('.forward_en_end').click(function() {
															$('.forward_en').hide();
															$('.forward_en_des').show();
															$('.forward_en_end').hide();
															$('.forward_en_end_des').show();
															var forward_end=$('.add_item').attr('alt');
															var fnl=Number(forward_end)-1;
															$('.line_number').val(fnl);
															$('.configure').attr('alt',fnl);
															incnumber(fnl);
															});
														
														$('.back_en_end').click(function() {
															$('.forward_en').show();
															$('.forward_en_des').hide();
															$('.forward_en_end').show();
															$('.forward_en_end_des').hide();
															$('.line_number').val(1);
															$('.configure').attr('alt',1);
															incnumber(1);
															});
														
														
													
														
														$('.numbers').keydown(function(e) {
                                                            if(e.keyCode==13)
															{
																var val=$(this).val();
																
																if(val.search("c_")>=0)
																{
																	tipup(val,'test');
																}
																else
																{
																	$('#loading').show();
	 $("body").css("opacity","0.4"); 
	  $("body").css("filter","alpha(opacity=40)"); 
																	 $.ajax({
				type:'POST', 
				url: '../lib/controller.php?url=popup_bapi&page=bapi&bapiName=ZSD_VARIANT_LOOKUP&mater='+val, 
				success: function(response) 
				{
				
					//$('#dialog').html(response);
					$('#loading').hide();
			  $("body").css("opacity","1"); 
			  var line=$('.configure').attr('alt');
			 
					var spl=response.split('@');
					$('#numbers_'+line).val(spl[0]);
					$('#text_'+line).val(spl[1]);
					$('#wid_chg_as_'+line).val(Number(spl[8])-1);
					$('#hig_chg_as_'+line).val(Number(spl[9])-1);
					$('#on_hand_'+line).val(round_math(spl[10]));
					$('#available_'+line).val(round_math(spl[11]));
					$('#shipped_'+line).val(round_math(spl[12]));
					$('#last_sold_date_'+line).val(spl[13]);
					$('#pcs_unit_'+line).val(round_math(spl[14]));
					$('#variable_cost_'+line).val(round_math(spl[5]));
					$('#fixed_cost_'+line).val(round_math(spl[2]));
					$('#packaging_'+line).val(round_math(spl[3]));
					$('#freight_'+line).val(round_math(spl[4]));
					
					/*Unit Price =(Price Entered/1000)*(length -1)*(width-1);
					Extended price = Order quantity * Unit Price
					*/
					var twn=20*Number(spl[2])/100;
					$('#overheads_'+line).val(round_math(twn));
					var total_cost=Number(spl[5])+Number(spl[2])+Number(twn)+Number(spl[4])+Number(spl[3]);
					$('#total_cost_'+line).val(round_math(total_cost));
					var prc=$('.price').val();
					var profit=Number(prc)-Number(total_cost);
					$('#profit_'+line).val(round_math(profit));
					var mch=Number(profit)/Number(spl[6]);
					$('#mhc_'+line).val(round_math(mch));
					$('#mhc_'+line).attr('title',spl[6]);
					$('#order_mhc_'+line).val(round_math(mch));
					var legth_width=(Number(spl[9])-1)*(Number(spl[8])-1)/144;
					$('#unit_price_'+line).val(round_math((prc/1000)*legth_width));
					$('#ext_price_'+line).val(round_math($('.order_qty').val()*((prc/1000)*legth_width)));
					$('#of_unit_'+line).val(round_math(Number($('.order_qty').val())/Number(spl[14])));
					//$('#digs').hide('slow');
								}
				 });
																}
															}
                                                        });
														//.............................................................
														var today = new Date();
														var dd = today.getDate();
														var mm = today.getMonth()+1; //January is 0!
														var yyyy = today.getFullYear();
													
														if(dd<10){dd='0'+dd} 
														if(mm<10){mm='0'+mm} 
														var today = mm+'/'+dd+'/'+yyyy;
														$('#datepicker').val(today);

														$('#datepicker').datepicker({
															format: 'mm/dd/yyyy',
															weekStart: '0',
															autoclose: true
														}).on('changeDate', function()
	{
		$('.datepickerformError').hide();
	});
														
														

														jQuery("#validation").validationEngine();
													});
													$('#datepicker2').datepicker({
															format: 'mm/dd/yyyy',
															weekStart: '0',
															autoclose: true
														}).on('changeDate', function()
	{
		$('.datepicker2formError').hide();
	});
														
														
$('#datepicker3').datepicker({
															format: 'mm/dd/yyyy',
															weekStart: '0',
															autoclose: true
														}).on('changeDate', function()
	{
		$('.datepicker3formError').hide();
	});
														
														


													function order()
													{
														var de=0;
														if(de!=1)
														{
															$('#validation input').each(function(index, element) 
															{
																var names=$(this).attr('name');
																if($(this).attr('alt')=='MULTI') names=$(this).attr('id');
																
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
														
														$('#loading').show();
														$("body").css("opacity","0.4"); 
														$("body").css("filter","alpha(opacity=40)"); 
														$.ajax({
															type:'POST', 
															url: '../lib/controller.php', 
															data:$('#validation').serialize(), 
															success: function(response) 
															{
																$('#loading').hide();
																$("body").css("opacity","1"); 
																var spt=response.split("@");
																jAlert('<b>SAP System Message: </b><br>'+spt[0], 'Sales Order');
																var msg=$.trim(spt[1])
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
																gd=gd+1;
																var text=$(this).text();
																$('.iph').find('tbody td:nth-child('+gd+')').children('input').before('<label class="sda">'+text+'<span> *</span>:</label>');
																$('.iph').find('tbody td:nth-child('+gd+')').children('input').after('<br><br>');
															});
														}
													});
													
													
													
													var inc = 0;
													var nut = 0;
												
													
													function form_id_arrange()
													{
														arr_id_change('checkbox[]', 0);
														arr_id_change('num[]', 0);
														arr_id_change('orderHmc[]', 0);
														arr_id_change('openLine[]', 0);
														arr_id_change('fsc[]', 0);
														arr_id_change('fscControlled[]', 0);
														arr_id_change('ShowFCT[]', 0);
														arr_id_change('rowCt[]', 0);
														arr_id_change('showForm[]', 0);
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
													
													


			
													
								
													function show_Form(ids)
            {
                showForm(ids);
            }
			 function showForm(rowID)
			{			
                var data = $('#showForm_'+rowID).html();				
                if($('#ShowFCT_'+rowID).attr('alt') == 0)
                {
                    $('#rowCt_'+rowID).after("<tr id='hid_"+rowID+"' class='create_2'><td colspan='7' class='create_2'>"+data+"</td></tr>");
                    $('#ShowFCT_'+rowID).attr('alt',1);					
                    $('#ShowFCT_'+rowID).attr('src','../images/sort_asc1.png');
                }
                else
                {
                    $('#hid_'+rowID).remove();
                    $('#ShowFCT_'+rowID).attr('alt',0);					
                    $('#ShowFCT_'+rowID).attr('src','../images/sort_desc1.png');
                }
            }
			function tipup(title,ids)
		{
			//var type=$.cookie('Item_type');
			$('.emt').val('');
			 var type =$('.plant option:selected').val();
			
			document.getElementById('ok_it').onclick=function(){status(ids,'ok');};
			document.getElementById('clse').onclick=function(){status(ids,'cancel');};
			document.getElementById('clse1').onclick=function(){status(ids,'cancel');};
			$('#digs').show();
			$('#title').mouseover(function (){ $('#digs').draggable(); });
			$('#title').mouseout(function (){ $('#digs').draggable("destroy"); });
			$('#title').html(title).css({'background-color':'#cecece'})
			$('#dialog').html("<img src='../images/loader.gif' style='margin-left:45%;margin-top:15%;'>");

			$.ajax({
				url: 'sub_links/create_popup.php?type='+type,
				success: function(data) 
				{
					$('#dialog').html(data);
				}
			});
		}
		function show_color(ids)
		{
			
		if(ids==1)
			{
				$('.color_one').addClass('active_one');
				$('.active_one').removeClass('color_one');
				$('.active_two').addClass('color_two');
				$('.color_two').removeClass('active_two');
			}
			if(ids==2)
			{
				$('.color_one').addClass('active_one');
				$('.active_one').removeClass('color_one');
				$('.color_two').addClass('active_two');
				$('.active_two').removeClass('color_two');
				
			}
			if(ids=='')
			{
				
				$('.active_one').addClass('color_one');
				$('.color_one').removeClass('active_one');
				$('.active_two').addClass('color_two');
				$('.color_two').removeClass('active_two');
			}
			if(ids!='')
			{
			var type='sand';
			var plant=$('.plant option:selected').val();
			 prt =$('.product_type option:selected').val();
			 $.ajax({
				type:'POST', 
				url: '../lib/selection_options.php?value='+ids+'&type='+type+'&plant='+plant+'&prt='+prt, 
				success: function(response) 
				{
					var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
				}
			})
			}
		}
function status(id,type)
		{
			var ids = id;
			if(type == 'ok')
			{
				var nulval=0;
				$('.check_v').each(function(index, element) {
                    if($(this).val()=='')
					{
						$(this).css({border:'1px solid red'});
						nulval=1;
						return false;
				
					}
                });
				if(nulval==0)
				{
					
					$('#loading').show();
	 $("body").css("opacity","0.4"); 
	  $("body").css("filter","alpha(opacity=40)"); 
				var smrt=$('.smr_str').val();
				 $.ajax({
				type:'POST', 
				url: '../lib/controller.php?url=popup_bapi&page=bapi&bapiName=ZSD_VARIANT_LOOKUP&value=yes&'+$('#create_popup').serialize(), 
				success: function(response) 
				{
				
					//$('#dialog').html(response);
					$('#loading').hide();
			  $("body").css("opacity","1"); 
			  var line=$('.configure').attr('alt');
			 
					var spl=response.split('@');
					$('#numbers_'+line).val(spl[0]);
					$('#text_'+line).val(spl[1]);
					$('#wid_chg_as_'+line).val(Number(spl[8])-1);
					$('#hig_chg_as_'+line).val(Number(spl[9])-1);
					$('#on_hand_'+line).val(round_math(spl[10]));
					$('#available_'+line).val(round_math(spl[11]));
					$('#shipped_'+line).val(round_math(spl[12]));
					$('#last_sold_date_'+line).val(spl[13]);
					$('#pcs_unit_'+line).val(round_math(spl[14]));
					$('#variable_cost_'+line).val(round_math(spl[5]));
					$('#fixed_cost_'+line).val(round_math(spl[2]));
					$('#packaging_'+line).val(round_math(spl[3]));
					$('#freight_'+line).val(round_math(spl[4]));
					
					/*Unit Price =(Price Entered/1000)*(length -1)*(width-1);
					Extended price = Order quantity * Unit Price
					*/
					var twn=20*Number(spl[2])/100;
					$('#overheads_'+line).val(round_math(twn));
					var total_cost=Number(spl[5])+Number(spl[2])+Number(twn)+Number(spl[4])+Number(spl[3]);
					$('#total_cost_'+line).val(round_math(total_cost));
					var prc=$('.price').val();
					var profit=Number(prc)-Number(total_cost);
					$('#profit_'+line).val(round_math(profit));
					var mch=Number(profit)/Number(spl[6]);
					$('#mhc_'+line).val(round_math(mch));
					$('#mhc_'+line).attr('title',spl[6]);
					$('#order_mhc_'+line).val(round_math(mch));
					var legth_width=(Number(spl[9])-1)*(Number(spl[8])-1)/144;
					$('#unit_price_'+line).val(round_math((prc/1000)*legth_width));
					
					$('#ext_price_'+line).val(round_math($('.order_qty').val()*((prc/1000)*legth_width)));
					$('#of_unit_'+line).val(round_math(Number($('.order_qty').val())/Number(spl[14])));
					$('#digs').hide('slow');
								}
				 });
				}
				
								$('#'+ids).css({ color:'#000' })
				
			}
			else
			{
				 $.ajax({
				type:'POST', 
				url: '../lib/controller.php?url=popup_bapi&page=forms&value=none', 
				success: function(response) 
				{
					$('#'+ids).val(" ");
				$('#'+ids).css({ color:'#000' })
				$('#digs').hide('slow');
				}
				 });
				
			}
		}
		
		
		function change_order(value,type,clas)
		{
			var prt=0;
			
			 prt =$('.product_type option:selected').val();
			
			var plant=$('.plant option:selected').val();
			$.ajax({
				type:'POST', 
				url: '../lib/selection_options.php?value='+value+'&type='+type+'&plant='+plant+'&prt='+prt, 
				success: function(response) 
				{
					//alert(response);
					if(type=='FinishType')
					{
						var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
						var spt=sds[0].split('@');
						$('.'+clas).html(spt[0]);
						$('.'+clas+'_sand').html(spt[1]);
						
					}
					else
					{
						
						if(type=='thickness')
						{
							var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
							var spt=sds[0].split('@');
							$('.'+clas).html(spt[0]);
							if(spt[1].search("-sp-")>0)
							{
							var df=spt[1].split('-sp-');
							var df2=spt[2].split('-sp-');
						$('.'+clas+'_w').val('Min '+df[0]+' to Max '+df[1]+' by increment of '+df[2]);
						$('.'+clas+'_l').val('Min '+df2[0]+' to Max '+df2[1]+' by increment of '+df2[2]);
						
						$('.width_id').attr('alt',df[0]+','+df[1]+','+df[2]);
						$('.height_id').attr('alt',df2[0]+','+df2[1]+','+df2[2]);
							}
							else
							{
								$('.'+clas+'_w').val('');
						$('.'+clas+'_l').val('');
						
						$('.width_id').attr('alt','');
						$('.height_id').attr('alt','');
							}
						}
						else
						{
						if(type=='texture')
						{
							$('.sd1').val('NONE');
						$('.sd2').val('NONE');
						var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
							$('.'+clas).html(sds[0]);
						}
						else
						{
							var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
					$('.'+clas).html(sds[0]);
						}
						}
					}
				}
			})
		}
		function sele()
		{
			alert($('.product_type option:selected').val());
		}
		function side_color(ids,type)
		{
		var minm = $('.'+type+'_w').attr('alt').split(',');
		
		if(Number(ids)>=Number(minm[0])&&Number(ids)<=minm[1])
		{
			myFunction(ids,Number(minm[2]),Number(minm[0]),type);
			var plant=$('.plant option:selected').val();
			 prt =$('.product_type option:selected').val();
			 $.ajax({
				type:'POST', 
				url: '../lib/selection_options.php?value='+ids+'&type='+type+'&plant='+plant+'&prt='+prt, 
				success: function(response) 
				{
					
					var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
				}
			})
			
		}
		else
		{

			jAlert('Value should be in between '+Number(minm[0])+' to '+Number(minm[1])+'','Message',function(r)
			{
				if(r)
				{
					
				   $('.'+type+'_w').val('');
			$('.'+type+'_w').focus();
				}
			});
			
		}
			
		}
		function side_colors(ids,type)
		{
		
			var plant=$('.plant option:selected').val();
			 prt =$('.product_type option:selected').val();
			 $.ajax({
				type:'POST', 
				url: '../lib/selection_options.php?value='+ids+'&type='+type+'&plant='+plant+'&prt='+prt, 
				success: function(response) 
				{
					
					var sds=response.split('s@mr');
					$('.smr_str').val(sds[1]);
				}
			})
			
		}
				                               function width_val(value)
														{
															//alert(value);
															 var divi=$('.thick_cl_w').attr('alt');
															 //alert(divi);
															 var compr=value/parseFloat(divi);
															 //alert(compr);
															 //alert(compr.match(/^-?\d*(\.\d+)?$/));
															// if(compr.match(/^-?\d*(\.\d+)?$/))
															// {
																// alert('Wrong');
															 //}
														}
														function height_val(value)
														{
															//alert(value);
															// var divi=$('.thick_cl_l').attr('alt');
															// var compr=value/parseFloat(divi);
															// if(compr.match(/^-?\d*(\.\d+)?$/))
															 //{
															//	 alert('Wrong');
															 //}
														}
													</script>
												</div>
											</div>
										</div>
									
								
							</div>
						