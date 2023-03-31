<style>
.table th:nth-child(-n+15), .table td:nth-child(-n+15){

   display:table-cell;
   
   }  

</style>

<?php
global $rfc,$fce;
$maxColNumber = 14;
$paymentTerms = "";
$paymentTermsDesc = "";
$sales_org = "";
$sold_to = "";
$pmntterms = "";
$PURCH_NO = "";
$sel = "";
$distr_chan = "";
$doc_type = "";
$division = "";
$headCurrency = "";
$btn = "";
$h_text="";
$percentage_discount="";
$amount_discount="";
$i_txt="";
$s_txt="";
$item_categ="";
$iv="";
$count=5;
$a=0;
$b=0;
if (isset($_REQUEST['I_VBELN'])) {
   $customer = $_REQUEST['I_VBELN'];
   
   $cusLenth = count($customer);
   if($cusLenth < 10 && $customer != "") { $customer = str_pad($customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
   
   //$imp = new BapiImport();
   //GEZG 06/22/2018
   //Changing SAPRFC methods
   $options = ['rtrim'=>true];
   $importTableSALESDOCUMENTS = array();

   $I_BAPI_VIEW = array('HEADER' => 'X', 'ITEM' => 'X','SDSCHEDULE' => 'X','BUSINESS' => 'X','PARTNER' => 'X','ADDRESS' => 'X','STATUS_H' => 'X','STATUS_I' => 'X','SDCOND' => 'X','SDCOND_ADD' => 'X','CONTRACT' => 'X','TEXT' => 'X','FLOW' => 'X','BILLPLAN' => 'X','CONFIGURE' => 'X','CREDCARD' => 'X','INCOMP_LOG' => 'X');

   //$imp->setImport("I_BAPI_VIEW", $I_BAPI_VIEW);
   $SALES_DOCUMENTS = array("VBELN" => $customer);
   array_push($importTableSALESDOCUMENTS, $SALES_DOCUMENTS);
   $res = $fce->invoke(["I_BAPI_VIEW"=>$I_BAPI_VIEW,
                        "SALES_DOCUMENTS"=>$importTableSALESDOCUMENTS],$options);     

   $ORDER_HEADERS_OUT = $res['ORDER_HEADERS_OUT'];
   $ORDER_BUSINESS_OUT = $res['ORDER_BUSINESS_OUT'];
   $ORDER_ITEMS_OUT = $res['ORDER_ITEMS_OUT'];
   $ITEM_PRICE=$res['ORDER_CONDITIONS_OUT'];
   $ORDER_PARTNERS_OUT = $res['ORDER_PARTNERS_OUT'];
   $ORDER_ADDRESS_OUT  = $res['ORDER_ADDRESS_OUT'];
   $ORDER_TEXT         = $res['ORDER_TEXTLINES_OUT'];

   $paymentTerms = $res['ZTERM'];        
   $paymentTermsDesc = $res['PAY_DESCRIPTION'];           


   $itemNumberAux    = "";
   $lineAmount       = "";
   $lineCurrency     = "";
   $lineCurrencyAux  = "";
   $conditionFound   = false;
   $i                = 0;
   $arrLength        = count($ITEM_PRICE);

   foreach($ITEM_PRICE as $am)
   {      
      if($itemNumberAux == ""){
         $itemNumberAux =  $am['ITM_NUMBER'];
      }
      if($itemNumberAux != $am['ITM_NUMBER'] || $i == ($arrLength-1)){        
         if(!$conditionFound){
            //$amount[]=array('COND_VALUE'=>0);
            $currency[]=array('CURRENCY'=>$lineCurrencyAux);            
            $lineCurrencyAux = "";
         }else{
            $amount[]=array('COND_VALUE'=>$lineAmount);
            $currency[]=array('CURRENCY'=>$lineCurrency);
            $lineCurrency = "";
            $lineAmount = ""; 
            $conditionFound = false;
         }         
         $itemNumberAux =  $am['ITM_NUMBER'];         
      }
      $lineCurrencyAux = ($am['CURRENCY']!=""?$am['CURRENCY']:$lineCurrencyAux);
      if($am['COND_TYPE']=='PR00')
      {
         $lineAmount     = $am['COND_VALUE'];
         $lineCurrency   = $am['CURRENCY'];
         $conditionFound = true;         
      }  
      if($am['COND_TYPE']=='ZRA0')
      {
         $percentage_discount    = $am['COND_VALUE'];       
         $disc          = false;
         if(strpos($percentage_discount, "-") >= 0 ){
            str_replace("-", "", $percentage_discount);
            $disc = true;
          }  
          $percentage_discount = number_format((float)$percentage_discount,2,'.','');
          if($disc){
            $percentage_discount = $percentage_discount."-";
          }
      }
      if($am['COND_TYPE']=='ZHB2')
      {
         $amount_discount    = $am['COND_VALUE'];       
         $disc          = false;
         if(strpos($amount_discount, "-") >= 0 ){
            str_replace("-", "", $amount_discount);
            $disc = true;
          }  
          $amount_discount = number_format((float)$amount_discount,2,'.','');
          if($disc){
            $amount_discount = $amount_discount."-";
          }
      }    
      $i++;
   }   

   $setHeaderText = false;
   foreach ($ORDER_ITEMS_OUT as $order) {
      $i_text[$a]       = "";
      $s_text[$a]       = "";
      $lineNumber       = intval($order["ITM_NUMBER"]);            
      foreach($ORDER_TEXT as $order_txt){                     
         $textLineNumber = intval(substr($order_txt["TEXT_NAME"],10));             
         if($order_txt['TEXT_ID']=='ZN01' && !$setHeaderText){
            $h_text=$h_text.$order_txt['LINE']; 
            $setHeaderText = true;                 
         }
         if($textLineNumber == $lineNumber){
            if($order_txt['TEXT_ID']=='ZQ01'){
               $i_text[$a] = $order_txt['LINE'];                     
            }else if($order_txt['TEXT_ID']=='0001'){
               $s_text[$a]=$order_txt['LINE'];
            }
            $lang=$order_txt['LANGU'];
         }
         if($lang == ""){
            $lang=$order_txt['LANGU'];
         }         
      }      
      $a=$a+1;
   }   

   
   /*foreach($ORDER_TEXT as $order_txt)
   {

   if($order_txt['TEXT_ID']=='ZN01')
   {
      $h_text=$h_text.$order_txt['LINE'];
      $lang=$order_txt['LANGU'];
   }elseif($order_txt['TEXT_ID']=='ZQ01')
   {
      if($iv=="")
      {
         $i_txt=$order_txt['LINE'];
         $i_text[$a]=$i_txt;
      }
      if($iv!=$order_txt['TEXT_NAME'] && $iv!="")
      {
         $i_text[$a]=$i_txt;
         $a=$a+1;
         $i_text[$a]=$order_txt['LINE'];
         $i_txt=$order_txt['LINE'];
      }
      if($iv==$order_txt['TEXT_NAME'])
      {
         $i_txt=$order_txt['LINE'];
         $i_text[$a]=$i_txt;
      }
      $lang=$order_txt['LANGU'];
      $iv=$order_txt['TEXT_NAME'];
   }elseif($order_txt['TEXT_ID']=='0001')
   {
      if($iv=="")
      {
         $s_txt=$order_txt['LINE'];
         $s_text[$a]=$s_txt;
      }
      if($iv!=$order_txt['TEXT_NAME'] && $iv!="")
      {
         $s_text[$a]=$s_txt;
         $a=$a+1;
         $s_text[$a]=$order_txt['LINE'];
         $s_txt=$order_txt['LINE'];
      }
      if($iv==$order_txt['TEXT_NAME'])
      {
         $s_txt=$s_txt.$order_txt['LINE'];
         $s_text[$a]=$s_txt;
      }
      $lang=$order_txt['LANGU'];
      $iv=$order_txt['TEXT_NAME'];
   }
   elseif($lang=="")
      $lang=$order_txt['LANGU'];
   }*/
   
  foreach ($ORDER_ITEMS_OUT as $k=>$keys) {      
      
      $vas[] = array('ITM_NUMBER' => $keys['ITM_NUMBER'], 'MATERIAL' => $keys['MATERIAL'], 'HG_LV_ITEM' => $keys['HG_LV_ITEM'],'ITEM_CATEG' => $keys['ITEM_CATEG'], 'SHORT_TEXT' => $keys['SHORT_TEXT'], 'REQ_QTY' => $keys['REQ_QTY'],'COND_VALUE'=>$amount[$k]['COND_VALUE'], 'TARGET_QU' => $keys['TARGET_QU'],'COND_P_UNT'=> $keys['COND_P_UNT'],'COND_UNIT'=> $keys['COND_UNIT'], 'CURRENCY' => ($currency[$k]['CURRENCY'] != ""?$currency[$k]['CURRENCY']:$keys["CURRENCY"]),'PLANT'=> $keys['PLANT'],'LINE'=>$i_text[$k],'SALES_LINE'=>$s_text[$k],'NET_PRICE' => $keys['NET_PRICE'],'NET_VALUE' => $keys['NET_VALUE'], 'SALES_UNIT' => $keys['SALES_UNIT'], 'DOC_NUMBER' => $keys['DOC_NUMBER'], 'MAT_ENTRD' => $keys['MAT_ENTRD'], 'PR_REF_MAT' => $keys['PR_REF_MAT'], 'BATCH' => $keys['BATCH'], 'MATL_GROUP' => $keys['MATL_GROUP'], 'SHORT_TEXT' => $keys['SHORT_TEXT'],  'ITEM_TYPE' => $keys['ITEM_TYPE'], 'REL_FOR_BI' => $keys['REL_FOR_BI'], 'PROD_HIER' => $keys['PROD_HIER'], 'OUT_AGR_TA' => $keys['OUT_AGR_TA'], 'TARGET_QTY' => $keys['TARGET_QTY'], 'T_UNIT_ISO' => $keys['T_UNIT_ISO'], 'PLANT' => $keys['PLANT'], 'TARG_QTY_N' => $keys['TARG_QTY_N'], 'BASE_UOM' => $keys['BASE_UOM'], 'SCALE_QUAN' => $keys['SCALE_QUAN'], 'ROUND_DLV' => $keys['ROUND_DLV'], 'ORDER_PROB' => $keys['ORDER_PROB'], 'CREAT_DATE' => $keys['CREAT_DATE']);
   }

   if (isset($ORDER_HEADERS_OUT[0])) {
      $PURCH_NO = $ORDER_HEADERS_OUT[0]['PURCH_NO'];
      $sales_org = $ORDER_HEADERS_OUT[0]['SALES_ORG'];
      $sold_to = ltrim($ORDER_HEADERS_OUT[0]['SOLD_TO'], "0");
      $sel = $ORDER_HEADERS_OUT[0]['REQ_DATE_H'];
      $distr_chan = $ORDER_HEADERS_OUT[0]['DISTR_CHAN'];
      $doc_type = $ORDER_HEADERS_OUT[0]['DOC_TYPE'];
      $division = $ORDER_HEADERS_OUT[0]['DIVISION'];
      $headCurrency = $ORDER_HEADERS_OUT[0]['CURRENCY'];
      $netvalue = $ORDER_HEADERS_OUT[0]['NET_VAL_HD'];
     $df=$ORDER_HEADERS_OUT[0]['QT_VALID_F'];
     $dt=$ORDER_HEADERS_OUT[0]['QT_VALID_T'];
      if($doc_type == 'TA')
         $doc_type = 'OR';

      $dd = substr($df, -2);
      $mm = substr($df, -4, 2);
      $year = substr($df, -8, 4);
      $date_from = $mm . "/" . $dd . "/" . $year;
     
      $dd = substr($dt, -2);
      $mm = substr($dt, -4, 2);
      $year = substr($dt, -8, 4);
      $date_to = $mm . "/" . $dd . "/" . $year;
   }
   $btn = "btn-primary";
   foreach($ORDER_PARTNERS_OUT as $key=>$val)
{
if($val['PARTN_ROLE']=='AG')
{
   $sold=ltrim($val['CUSTOMER'],"0");
   $addr=$val['ADDRESS'];
}
   if($val['PARTN_ROLE']=='WE')
   $ship=ltrim($val['CUSTOMER'],"0");
if($val['PARTN_ROLE']=='ZS')
   $sales=ltrim($val['CUSTOMER'],"0"); 
}

   foreach($ORDER_ADDRESS_OUT as $key=>$val)
{
if($val['ADDRESS']==$addr)
{
   $sold_name=$val['NAME'];
   break;
}
}
}

$I_VBELN = "";

$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if ($sysnr . '/' . $sysid . '/' . $clien == '10/EC4/210') {
   $I_VBELN_TXT = $I_VBELN = "10000351";
   $SalesLenth = count($I_VBELN);
   if ($SalesLenth < 10 && $I_VBELN != '') {
      $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT);
   } else {
      $I_VBELN = substr($I_VBELN, -10);
   }
}
if (isset($_REQUEST['I_VBELN'])) {
   $I_VBELN = $_REQUEST['I_VBELN'];
   $I_VBELN_TXT = $_REQUEST['I_VBELN'];
   $SalesLenth = count($I_VBELN);
   if ($SalesLenth < 10 && $I_VBELN != '') {
      $I_VBELN = str_pad((int) $I_VBELN, 10, 0, STR_PAD_LEFT);
   } else {
      $I_VBELN = substr($I_VBELN, -10);
   }
}
$this->renderPartial('smarttable',array('count'=>$count));
$customize = $model;
?>
<style>
.table { width:1270px !important; max-width:1270px !important } 
.info-img
{
margin-left:-30px !important;
}
/*.table th, .table td { min-width:75px !important; }*/
.bb { background:#cecece !important; }
.bb:hover { background:#cecece !important; }
.check { display:none !important; }
</style>
<div id="tarea" style="display:none;"></div>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
   <div class="row-fluid">
      <div class="utopia-widget-content">
         
         <form id="validation3" action="javascript:submit_form('validation3')" class="form-horizontal">

            <div  class="form-horizontal">

               <div class="span5 utopia-form-freeSpace">

                  <fieldset>
                     <div class="control-group" >

                        <label class="control-label cutz" for="input01" style='min-width:170px;' alt='Sale Order Number' ><?php echo Controller::customize_label(_SALEQUOTATIONNUMBER); ?><span> *</span>:&nbsp;</label>
                        <input type="hidden" name='page' value="bapi">
                        <input type="hidden" name="url" value="editsalesquotation_sold"/>
                        <input type="hidden" name="key" value="editsalesquotation"/>
                        <input type="hidden" name="jum" value="/KYK/SERPSLS_GENDOC_FLAGS_STS"/>
                        <input type="hidden" name="values" value="/KYK/SERPSLS_GENDOC_FLAGS_STS"/>

                        <div class="controls">
                           <input style='min-width:170px;' id='SALES_DOCUMENT' class="input-fluid validate[required] " type="text" name='I_VBELN' value="<?php echo $I_VBELN_TXT; ?>" readonly/>
                           <!--<span class='minw' onclick="lookup('<?=_SALESDOCUMENT?>', 'SALES_DOCUMENT', 'sales_document')" >&nbsp;</span><!-- onChange="numdef(this.value,this.id)">-->
                        </div>

                     </div>
                  </fieldset></div>
               <?php
               if (!isset($_REQUEST['titl'])) {
                  ?>
                  <div>
                     <!--<input class="btn btn-primary back_b iphone_sales_disp <?php //echo $btn; ?>" name="btnsubmit" type="submit" value="<?php echo _SUBMIT ?>" style="margin-left:100px;margin-top:20px">-->
                <button class="span2 btn btn-primary back_b iphone_sales_disp <?php echo $btn; ?>" type="submit" id='submit' style='margin-left:100px;margin-top:20px'><?=_SUBMIT?></button>
                  </div>
                  <?php
               }
               ?>
            </div>
         </form>
      </div>
   </div>
</section>

<?php if (isset($_REQUEST['I_VBELN']) && $ORDER_ITEMS_OUT != NULL) {
   ?>
   <form action="javascript:orders();" method="post" id='validation7' class="form-horizontal" enctype="multipart/form-data" autocomplete="on">
   <input type="hidden" name="bapiName" id="bapiName" value="BAPI_CUSTOMERQUOTATION_CHANGE"/>
   <input type="hidden" name="I_VBELN" id="I_VBELN" value="<?php echo $I_VBELN; ?>"/>
   
   <div id="form_edit_values" class="utopia-widget-content myspace inval35 spaceing row-fluid" style="margin-top:11px;">
         <div class="span5 utopia-form-freeSpace myspace" >
         <div style="position:absolute; float:right;right:50px;margin-top:-20px;"><a href="#" onclick="strpdf()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png"/><?=_SALESQUOTATION?></a></div>
            <fieldset>
            
            <div class="control-group">
                  <label class="control-label cutz" for="input01" id='PARTN_NUMB_LABEL' alt="Sold to Party"><?php echo Controller::customize_label(_SOLDPARTY); ?><span> *</span>:</label>
                  <div class="controls">
                <input alt="Sold to Party" type="text" name='PARTN_NUMB' id='PARTN_NUMB' class="input-fluid validate[required,custom[customer]] getval radius" onchange="number(this.value)" value='<?php echo $sold; ?>' onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=_SOLDPARTY?>', 'PARTN_NUMB', 'sold_to_customer')" >&nbsp;</span>
                  </div></div>
              <div class="control-group">
                  <label class="control-label cutz" for="input01" id='PARTN_NUMB_LABEL' alt="Ship to Party"><?php echo Controller::customize_label(_SHIPPARTY); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Ship to Party" type="text" name='PARTN_NUMB1' id='PARTN_NUMB1' class="input-fluid validate[required,custom[customer]] getval radius" onchange="number(this.value)" value='<?php echo $ship; ?>' onKeyUp="jspt('PARTN_NUMB1',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=_SHIPPARTY?>', 'PARTN_NUMB1', 'ship_to_customer')" >&nbsp;</span>
                  </div></div>
               <div class="control-group">
                  <label class="control-label cutz in_custz" alt="Sales Organization" for="input01" id='SALES_ORG_LABEL'><?php echo Controller::customize_label(_SALESORGANIZATION); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Sales Organization" type="text" name='SALES_ORG' id='SALES_ORG' class="input-fluid validate[required,custom[salesorder]] getval radius" value='<?php echo $sales_org; ?>' onKeyUp="jspt('SALES_ORG',this.value,event)" autocomplete="off"/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','SALES_ORG','Sales Organization','SALES_ORG','0')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('<?=_SALESORGANIZATION?>', 'SALES_ORG', 'sales_org')" >&nbsp;</span>
                
                  </div>
               </div>
               
               <div class="control-group">
                  <label class="control-label cutz" for="input01" id='DISTR_CHAN_s' alt='Distribution. Channel'><?php echo Controller::customize_label(_DISTRIBUTIONCHANNEL); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Distribution. Channel" type="text" name='DISTR_CHAN' id='DISTR_CHAN' class="input-fluid validate[required,custom[dis]] getval radius" value='<?php echo $distr_chan; ?>' onKeyUp="jspt('DISTR_CHAN',this.value,event)" autocomplete="off"/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DISTR_CHAN','Distribution Channel','DISTR_CHAN','1')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('<?=_DISTRIBUTIONCHANNEL?>', 'DISTR_CHAN', 'dist_chan')" >&nbsp;</span>
                  </div></div>
               <div class="control-group" id="NET_VAL_HD_hide">
                  <label class="control-label cutz" for="input01" id='NET_VAL_HD_s' alt='Net Value'><?php echo Controller::customize_label(_NETVALUES); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Net Value" type="text" name='NET_VAL_HD' id='NET_VAL_HD' class="input-fluid validate[required,custom[dis]] getval radius" value='<?php echo number_format(trim($netvalue), 2) ?>' onKeyUp="jspt('NET_VAL_HD',this.value,event)" autocomplete="off"/></div></div>
               <div class="control-group">
                  <label class="control-label cutz" alt="Sold to Name" for="input01" id='PARTN_NAME_LABEL'><?php echo Controller::customize_label(_SOLDPARTYNAME);?>:</label>
                        <div class="controls">
                            <input alt="Sold to Name" type="text" name='PARTN_NAME' id='PARTN_NAME' class="input-fluid  getval radius" readonly   autocomplete="off" value="<?php echo $sold_name; ?>" />
                           
                        </div>
                    </div> 
                 <div class="control-group" >
                    <label class="control-label cutz" for="input01" style='width:150px;' alt='Quotation To Date'><?=Controller::customize_label(_PAYMENTTERMS); ?><span> *</span>:</label>
                    <div class="controls">
                        <input alt="Payment terms" type="text" id="PMNTTERMS" name='PMNTTERMS'  class="input-fluid getval radius" value="<?php echo $paymentTerms; ?>"/>
                    </div>
               </div>

               <div class="control-group">
                       <label class="control-label cutz" alt="Customer PO number" for="input01" id='PURCH_NO_LABEL'><?=Controller::customize_label(_CUSTOMERPONO);?>:</label>
                       <div class="controls">
                           <input alt="Customer PO number" type="text" name='PURCH_NO' id='PURCH_NO' class="input-fluid  getval radius" readonly   autocomplete="off" value="<?php echo $PURCH_NO; ?>" />
                       </div>
                  </div>               
            </fieldset>
         </div>
         <div class="span5 utopia-form-freeSpace">
            <fieldset>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"  style='width:150px;'  id="DOC_TYPE_s" alt='Sales Document Type'><?php echo Controller::customize_label(_SALESDOCTYPE); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Sales Document Type" type="text" name="DOC_TYPE" id='DOC_TYPE' class="input-fluid validate[required] getval radius" onKeyUp="jspt('DOC_TYPE',this.value,event)" autocomplete="off" value='<?php echo $doc_type; ?>'/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DOC_TYPE','Sales Document Type','DOC_TYPE','0')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('<?=_SALESDOCTYPE?>', 'DOC_TYPE', 'sales_order_types')" >&nbsp;</span>
                  </div></div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"  style='width:150px;'  id="DIVISION_s" alt='Division'><?php echo Controller::customize_label(_DIVISION); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Division" type="text" name='DIVISION' id='DIVISION' class="input-fluid validate[required,custom[divi]] getval radius" onKeyUp="jspt('DIVISION',this.value,event)" autocomplete="off" value='<?php echo $division; ?>'/>
                      <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERHEADERIN','DIVISION','Division','DIVISION','2')" >&nbsp;</span>-->
                      <span class='minw' onclick="lookup('<?=_DIVISION?>', 'DIVISION', 'division')" >&nbsp;</span>
                  </div></div>
              <div class="control-group">
                  <label class="control-label cutz" for="input01" id='SALES_PERSON' alt="Sales Person"><?php echo Controller::customize_label(_SALESPERSON); ?><span> *</span>:</label>
                  <div class="controls">
                <input alt="Sales Person" type="text" name='PARTN_NUMB2' id='PARTN_NUMB2' class="input-fluid validate[required,custom[customer]] getval radius" onchange="number(this.value)" value='<?php echo $sales; ?>' onKeyUp="jspt('PARTN_NUMB',this.value,event)" autocomplete="off"/><!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','PARTN_NUMB','4@DEBIA')" >&nbsp;</span>--><span class='minw' onclick="lookup('<?=_SALESPERSON?>', 'PARTN_NUMB2', 'sales_person')" >&nbsp;</span>
                  </div></div>
               <div class="control-group" >
                  <label class="control-label cutz" for="input01" style='width:150px;' alt='Quotation From Date'><?php echo Controller::customize_label(_QUOTATIONFROMDATE); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Quotation From Date" type="text" id="datepicker" name='QFDate'  class="input-fluid getval radius" value="<?php echo $date_from; ?>"/>
                  </div></div>
                             <div class="control-group" >
                  <label class="control-label cutz" for="input01" style='width:150px;' alt='Quotation To Date'><?php echo Controller::customize_label(_QUOTATIONTODATE); ?><span> *</span>:</label>
                  <div class="controls">
                     <input alt="Quotation To Date" type="text" id="datepicker1" name='QTDate'  class="input-fluid getval radius" value="<?php echo $date_to; ?>"/>
                  </div></div>
                  
                   <div class="control-group">
                        <label class="control-label cutz" alt="Sold to Name" for="input01" id='SOLD_TO_NAME'><?=Controller::customize_label(_PAYMENTTERMSDESC);?>:</label>
                        <div class="controls">
                            <input type="text" alt="Payment terms" type="text" name='ZTERM_DESC' id='ZTERM_DESC' class="input-fluid radius getvals" readonly   autocomplete="off" value="<?php echo $paymentTermsDesc; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label cutz" alt="Sold to Name" for="input01" id='SOLD_TO_NAME'><?=Controller::customize_label(_CURRENCY);?>:</label>
                        <div class="controls">
                            <input type="text" alt="<?=_CURRENCY?>" type="text" name='HEAD_CURRENCY' id='HEAD_CURRENCY' class="input-fluid radius getvals" readonly   autocomplete="off" value="<?php echo $headCurrency; ?>" />
                        </div>
                    </div>
                  
            <div class="control-group" >
                  <input type="hidden"  name="HEADER_TEXT" id="HEADER_TEXT" value="<?php echo $h_text; ?>" />
                     <input type="button" name="header_text" onClick="enterText('HEADER_TEXT','')" value="<?=_HEADERTXT?>" class="btn" />

                     <!-- 
                           GEZG 02/06/19 
                           Adding percentage discount button
                    -->
                    <input type="hidden"  name="PERCENTAGE_DISCOUNT" class="getval" value="<?php echo $percentage_discount; ?>" id="PERCENTAGE_DISCOUNT" />
                    <input type="hidden"  name="AMOUNT_DISCOUNT" class="getval" value="<?php echo $amount_discount; ?>" id="AMOUNT_DISCOUNT" />
                     <input type="button" onClick="enterValue('PERCENTAGE_DISCOUNT','','AMOUNT_DISCOUNT','','<?=Controller::customize_label(_DISCOUNT);?>','<?=Controller::customize_label(_PERCENTAGE);?>','<?=Controller::customize_label(_OR);?>','<?=Controller::customize_label(_FIXEDAMOUNT);?>')" value="<?=Controller::customize_label(_DISCOUNT);?>" class="btn" />



                 <input type="button" name="copy_form_data" id="copy_form_data" value="<?=_COPYSALESQUOTATION?>" class="btn btn-primary" />
                <input type="hidden"  name="LANGUAGE" id="LANGUAGE" value="<?php echo $lang; ?>" />
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
                  <span class='cutz sub_titles' alt='Items'><?php echo Controller::customize_label(_ITEMS);?></span>
               </div>
               <div class="utopia-widget-content items" >
                  <div>
                     <span class="btn" id="addRow" onclick="addRow('dataTable','A')" ><?=_ADDITEM?></span>
                     <span class="btn"  id="deleteRow" onclick="deleteRow('dataTable')">
                        <i class="icon-trash icon-white"></i><?=_DELETEITEM?>
                     </span>
                  </div>
                  <br>
                  <!--<table class="table  table-bordered iph" id="dataTable" >-->
                  <div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;overflow-y:scroll">
                  <table class="table  table-bordered" id="dataTable" >
                     <thead>
                        <tr>
                           <th class='cutz' alt='tableItems'><?php echo Controller::customize_label(_ITEM);?></th>
                           <th class='cutz large' alt='Material'><?php echo Controller::customize_label(_MATERIAL);?></th>
                           <th class='cutz' alt='High level item'><?php echo Controller::customize_label(_HIGHTITEM);?></th>
                           <th class='cutz' alt='Free goods'><?php echo Controller::customize_label(_FREEGOODS);?></th>
                           <th class='cutz large' alt='Description'><?php echo Controller::customize_label(_DESCRIPTION);?></th>
                           <th class='cutz' alt='Order Quantity'><?php echo Controller::customize_label(_ORDERQUANTITY);?></th>
                           <th class='cutz' alt='Price'><?php echo Controller::customize_label(_AMOUNT);?></th>
                           <th class='cutz' alt='SU'><?php echo Controller::customize_label(_SU);?></th>
                           <th class='cutz' alt='SU'><?php echo Controller::customize_label(_PRICINGUNIT);?></th>
                           <th class='cutz' alt='COND_UNIT'><?=Controller::customize_label(_UOM);?></th>
                           <th class='cutz' alt='SU'><?php echo Controller::customize_label(_CURRENCY);?></th>
                           <th class='cutz' alt='SU'><?php echo Controller::customize_label(_PLANT);?></th>
                           <th class='cutz' alt='Item Text'><?php echo Controller::customize_label(_ITEMTXT);?></th>
                           <th class='cutz' alt='Sales Text'><?php echo Controller::customize_label(_SALESTXT);?></th>
                           <th class='cutz' alt='Sales Text'><?=Controller::customize_label(_PRODUCTAVAILABILITY);?></th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr onClick="select_row('ids_0')" class="ids_0 nudf" >
                           <td><input class="chkbox check" type="checkbox" name="checkbox[]"
                                               title="che" id="chedk" value="U" onkeyup="jspt('chedk',this.value,event)">
                                        <input  type="text" name='item[]' 
                              <?php if(!isset($customerNo))
                                        { ?>value="10"<?php } else { ?> value="" <?php } ?>
                                                title="item" class='input-fluid validate[required,custom[number]] flgs'  alt="Items" id="ITM_NUMBER" readonly="readonly"/></td>
                           <td>
                               <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/info.png" style="margin-left:-30px !important  ; cursor: pointer;" />
                               <input type="text"  id='MATERIAL' name='material[]' class="input-fluid validate[required] getval radiu" title="MATERIAL" alt="MULTI"  onKeyUp="jspt('MATERIAL',this.value,event)" autocomplete="off"  onchange="getMatDescBOM('MATERIAL',this,event,'dataTable')"/>
                                        <!--<span class='minw9' onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','MATERIAL','Material','MATERIAL','3@MAT1L')" >&nbsp;</span>-->
                                        <div class='minws1' id="table_lookup" onclick="lookup('Material', 'MATERIAL', 'material')" >&nbsp;</div>
                                       
                           </td>
                           <td>
                              <input type="text"  id='HIGH_LEVEL_ITEM'  title="high_level_item" name='high_level[]'  class="input-fluid" onChange="setComponent(this)" value="" />
                           </td>
                           <td>
                              <input type="checkbox" id='IS_FREE_CHARGE'  name='IS_FREE_CHARGE[]' alt="IS_FREE_CHARGE" title="is_free_charge"  onchange="setFreeCharge(this);" />
                              <input type="hidden" id='FREE_CHARGE'  name='FREE_CHARGE[]' alt="FREE_CHARGE" title="free_charge" />
                              <input type="hidden" title="is_component" id='IS_COMPONENT'  name='component[]' />
                              <input type="hidden" title="item_categ" id='ITEM_CATEG'  name='category[]' alt="ITEM_CATEG" />
                           </td>
                           <td>
                              <input type="text" id='SHORT_TEXT'  class="input-fluid validate[required,custom[number]] getval" name='description[]' alt="SHORT_TEXT" onKeyUp="jspt('SHORT_TEXT',this.value,event)" autocomplete="off" value=''/>
                           </td>
                           <td>
                              <input type="text" id='REQ_QTY'  class="input-fluid validate[required] getval" name='Order_quantity[]' title="order_quantity" alt="REQ_QTY" onKeyUp="jspt('REQ_QTY',this.value,event)" autocomplete="off" value='' onchange="getMatDescBOM('MATERIAL',this,event,'dataTable')"/>
                           </td>
                           <td>
                              <input type="text" id='COND_VALUE'  class="input-fluid validate[required] getval" name='Price[]' title="descript" alt="PRICE" onKeyUp="jspt('PRICE',this.value,event)" autocomplete="off" value=''/>
                              <!--<input type="hidden" name="Currency[]" title="curr" id="CURRENCY"/>-->
                           </td>
                           <td  style="padding-right: 25px">
                              <input type="text" id='TARGET_QU' class="input-fluid validate[required] getval radiu" name='su[]' title="su" alt="MULTI" onKeyUp="jspt('TARGET_QU',this.value,event)" autocomplete="off" value=''/>
                                        <!--<span  class='minw9'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERITEMSIN','TARGET_QU','SU','TARGET_QU','0')" >&nbsp;</span>-->
                                        <div  class='minws1' id="table_lookup" onclick="lookup('<?=_SU?>', 'TARGET_QU', 'uom')" >&nbsp;</div>

                                    </td>
                           <td >
                              <input type="text" id='COND_P_UNT'  class="input-fluid validate[required] getval" name='per_unit[]' title="per_unit" alt="COND_P_UNT" onKeyUp="jspt('COND_P_UNT',this.value,event)" autocomplete="off" value=''/>
                           </td>
                           <td  style="padding-right: 25px">
                              <input type="text"  id='COND_UNIT' class="input-fluid validate[required] getval radiu" name='unit_of_measure[]' title="COND_UNIT" alt="MULTI" onKeyUp="jspt('COND_UNIT',this.value,event)" autocomplete="off" value=''/>
                              <div  class='minws1' id="table_lookup" onclick="lookup('<?=_UOM?>', 'COND_UNIT', 'uom')" >&nbsp;</div>
                           </td>

                           <td>
                              <input type="text" id='CURRENCY'  class="input-fluid validate[required]  getval" name='currency[]' title="per_unit" alt="CURRENCY" onKeyUp="jspt('CURRENCY',this.value,event)" autocomplete="off" value=''/>
                           </td>

                           <td  style="padding-right: 25px">
                              <input type="text" id='PLANT'  class="input-fluid validate[required]  getval" name='Plant[]' title="plant" alt="PLANT" onKeyUp="jspt('PLANT',this.value,event)" autocomplete="off" onchange="setChildPlant(this);" value=''/>
                               <div  class='minws1' onclick="lookup_plant('<?=_PLANT?>', 'PLANT')" >&nbsp;</div>
                           </td>


                           <td><input type="hidden"  name="ITEM_TEXT[]"  title="item_text" id="LINE" ids="LINE" class="ITM_TXT" /><div class="txt"  
                           onClick="enterText('LINE','')"></div></td>
                           <td><input type="hidden"  name="SALES_TEXT[]"  title="sales_text" id="SALES_LINE" ids="SALES_LINE" class="ITM_TXT" /><div class="txt"  
                           onClick="enterText('SALES_LINE','')"></div></td>
                            
                            <td style="display: none;">
                             <div class="prodAvQuotationButton" onclick="poductAvailabityQuotation(this)"></div>
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
                           <span onclick="pre()" id="pre" class="btn" style="display:none"><?=_PREVIOUS?></span>
                           <span id="pre1" class="btn" style="display:none"><?=_PREVIOUS?></span>
                        </td>
                        <td>
                           <span onclick="nxt()" id="nxt" class="btn" style="float:right;display:none"><?=_NEXT?></span>
                           <span id="nxt1" class="btn" style="float:right;display:none"><?=_NEXT?></span>
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
            <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'><?=_CANCEL?></button>
            <button class="btn" id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;"><?=_SUBMIT?></button>
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
            <div style="border:1px solid #FAFAFA;overflow-y:scroll;overflow-x:scroll;">
            <table class="table table-striped table-bordered" id="example7" alt="editsalesorder">
            <?php
               $technical = $model;
               $tec_name = 'BAPISDIT';
               $t_headers = Controller::technical_names($tec_name);
               $r = "";
               //print_r($vas);
               for ($i = 0; $i < count($vas); $i++)
               {
                  $SalesOrders = $vas[$i];                  
                  $columnCount = 0;
                  if ($i == 0)
                  {
                     ?>
                     <thead>
                        <tr>
                        <?php
                           foreach ($SalesOrders as $keys => $vales)
                           {
                              if($columnCount == $maxColNumber){
                                 break;
                              }
                              if($keys == "ITEM_CATEG"){
                                 ?>
                                 <th>
                                    <div class="truncated example7_is_free_charge cutz" title="is_free_charge" alt='is_free_charge'><?php echo Controller::customize_label(_FREEGOODS); ?></div>
                                    <div class="example7_th example7_is_free_charge_hid" style="display:none;" name="is_free_charge"><?=_FREEGOODS?></div>
                                    <div class="example7_tech" style="display:none;">is_free_charge@Free goods</div>
                                 </th>
                              <?php
                              }
                              else{
                              ?>
                              <th>
                                 <div class="truncated example7_<?php echo $keys; ?> cutz" title="<?php echo $t_headers[$keys]; ?>" alt='<?php echo $t_headers[$keys]; ?>'><?php echo Controller::customize_label($t_headers[$keys]); ?></div>
                                 <div class="example7_th example7_<?php echo $keys; ?>_hid" style="display:none;" name="<?php echo $keys; ?>"><?php echo $t_headers[$keys]; ?></div>
                                 <div class="example7_tech" style="display:none;"><?php echo $keys . "@" . $t_headers[$keys]; ?></div>
                              </th>
                              <?php
                              }
                              $columnCount++;
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
                  <tr id="<?php echo $r; ?>" >
                  <?php
                     $col = 0;     
                     $itemNumber = 0;         

                     foreach ($SalesOrders as $keys => $vales)
                     {

                        if($col == $maxColNumber){
                         break;
                        } 
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
                           if($keys == "ITM_NUMBER"){
                              $itemNumber = (int)$vales;
                              $r = $itemNumber-10;
                              if($r == 0){
                                 $r = "";
                              }
                           }
                           if($keys == "DOC_NUMBER")
                           {
                              ?>
                              <div id="<?php echo trim($id . '_' . $col); ?>" style="cursor:pointer;color:#00AFF0;">
                                 <div onClick="show_menu('<?php echo trim($id . '_' . $col); ?>','<?php echo $jon; ?>','/KYK/SERPSLS_GENDOC_FLAGS_STS','sales_workbench')"><?php echo $vales; ?></div>
                              </div>
                              <?php
                           }
                           elseif($keys == 'MATERIAL')
                           {
                              $plant = $SalesOrders['PLANT'];
                              $vals=preg_replace("/[^A-Za-z0-9]/", "", $vales);
                              ?>
                              <div id="<?php echo $i.'_'.trim($vals); ?>" style="cursor:pointer;color:#00AFF0;">
                                 <div onClick="show_prod('<?php echo $i.'_'.$vals; ?>','<?php echo $plant; ?>','product_availability_quotation',1);" title=""><?php echo $vales; ?></div>
                              </div>
                              <?php
                           }

                           

                           elseif($keys == 'LINE')
                              echo "<div class='txt'  onClick=\"enterText('LINES".$r."','')\"></div>";
                           elseif($keys == 'SALES_LINE')
                              echo "<div class='txt'  onClick=\"enterText('SALES_LINES".$r."','')\"></div>";
                           elseif($keys == 'HG_LV_ITEM')
                              echo ($vales!=0?$vales:"");
                           elseif($keys == 'ITEM_CATEG')
                              echo "<input type='checkbox' disabled  ".($vales=="AGNN"?"checked":"")."/>";
                           else
                              echo $vales;
                           
                           if($keys=='LINE' || $keys=='SALES_LINE')
                           {
                           
                              echo '<input type="hidden" ids="' . $keys.$r. '" id="'. $keys.'S'.$r. '" name="' . $keys . '" value="' . $vales . '" alt="true">';
                           }                              
                           elseif(is_numeric(trim($vales)) && $keys != 'MATERIAL' && $keys != "HG_LV_ITEM")
                           {
                              echo '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys . '" name="' . $keys . '" value="' . round(trim($vales), 2) . '" alt="true">';
                           }                           
                           elseif($keys == "HG_LV_ITEM"){
                               echo '<input type="hidden" ids="HIGH_LEVEL_ITEM'.$r. '" id="HIGH_LEVEL_ITEM" name="HIGH_LEVEL_ITEM" value="' . $vales . '" alt="true">';
                                echo '<input type="hidden" ids="IS_COMPONENT'.$r. '" id="IS_COMPONENT" name="IS_COMPONENT" value="' . ($vales!=""&&$vales!=0?"1":"0") . '" alt="true">';
                           }
                           else
                           {
                              if($keys != "ITEM_CATEG"){                                 
                                 echo '<input type="hidden" ids="' . $keys.$r. '" id="' . $keys. '" name="' . $keys . '" value="' . $vales . '" alt="true">';
                              }else{
                                  echo '<input type="hidden" ids="IS_FREE_CHARGE'.$r. '" id="IS_FREE_CHARGE" name="IS_FREE_CHARGE" value="' . $vales . '" alt="true">';
                                  echo '<input type="hidden" ids="ITEM_CATEG'.$r. '" id="ITEM_CATEG" name="ITEM_CATEG" value="' . $vales . '" alt="true">';                                 
                              }

                           }
                        ?>                                                         
                        </td>
                        <?php
                        $col++;
                     }
                  ?>         
                  <td style="display: none;">
                     <div class="prodAvQuotationButton" onclick="poductAvailabityQuotation(this)"></div>    
                  </td>         
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
            echo _NOITEMFOUND;
         }
      ?>
      </div>
   </div>
   
   
   
   
   <br />
   <div class="controls" style="margin-left:0px;">
                     <input type="button" name="edit_salesorder" id="edit_salesorder" value="<?=_EDIT?>" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="save_salesorder" id="save_salesorder" value="<?=_SAVE?>" onClick="save_quotation()" style="display:none;" class="btn btn-primary iphone_sales_disp" />
                     <input type="button" name="cancel_salesorder" id="cancel_salesorder" value="<?=_CANCEL?>" style="display:none;" class="btn iphone_sales_disp" />
                  </div>
              </div>
              </form>
               <?php
               if (isset($_REQUEST['I_VBELN'])) {
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
   elseif(isset($_REQUEST['I_VBELN']) && $ORDER_ITEMS_OUT == NULL)
   {
      ?>
         <div class="tab-content tab-con">Sales quotation doesn't exist.</div>
      <?php
   }
   ?>
<!-- javascript placed at the end of the document so the pages load faster -->
<div class="material_pop" ></div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js"></script>
<script type="text/javascript">
   $(document).ready(function() { 
   var flgs='';
   $('.flgs').each(function(index, element) {
   flgs +=$(this).val()+'G1SU,';
});

   $('#flag').val(flgs);
      $('.getval').attr('readonly','readonly');   
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();
      if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = mm+'/'+dd+'/'+yyyy;
      // $('#datepicker').val(today);
      $('#datepicker').datepicker({
         format: 'mm/dd/yyyy',
         weekStart: '0',
         autoclose:true
      }).on('changeDate', function()
      {
         $('.datepickerformError').hide();
      });
      jQuery("#validation3").validationEngine();
   });
   

   $(document).ready(function(e) 
   {
      $("#copy_form_data").click(function() 
      {        
         var str = '';        
         $("#form_edit_values").find(":input").each(function()
         {
            id = $(this).attr('id');               
            name = $(this).attr('name');
            val = $(this).attr('value');

            //console.log('id: '+id+'name: '+name+'val: '+val);

            if(id != undefined && name != undefined && val != undefined && id != "bapiName" && id != "NET_VAL_HD" && id != "copy_form_data")
               str = str + name + '=' + val + '&';
            
            console.log(str);
         });
         $("#example7_today").find(":input").each(function()
         {
            id = $(this).attr('id');               
            name = $(this).attr('name');
            val = $(this).attr('value');

            if(id != undefined && name != undefined && val != undefined && id != "bapiName")
               str = str + name + '=' + val + '&';
         });         
         $.cookie("formdata", str);
         window.location.href = '#create_sales_quotation_sold';
      });
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
    
    $("#dataTable").on('click', 'img', function() {
        var val   = $(this).closest("td").find("input").val();
        $sales_org = $("#SALES_ORG").val();
        if(val != "")
            show_prod_avail_quotation(val,$sales_org,'product_availability_quotation');
        else
            jAlert("<?=_SELECTMATERIALFIRST?>");
    })
});
var delete_val='';
var inc = 0;
var nut = 0;   
function addRow(tableID,t,lineNumber){    
   if($(document).width()<100){
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
   nut = parseInt(lastItemNumber/10)*10; 
   inc = (rowCount-1);
   if(t=='A')
   {
      var itm=table.rows[inc].cells[0].childNodes[2];
      //in_vals=($('#'+itm.id).val()/10);
      in_vals = nut/10;
   }else{
      in_vals=inc+"_"+lineNumber;
      nut = lineNumber;
   }
      
   row.setAttribute('onclick', 'select_row("ids_'+in_vals+'")');
   row.setAttribute('class', 'ids_'+in_vals+' nudf');
      
   var colCount = table.rows[1].cells.length;
      
   for(var i=0; i<colCount; i++){
        var newcell = row.insertCell(i);          
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;                
        var ind=newcell.getElementsByTagName('input');        
      
       if(ind[0] != undefined && (ind[0].title=='su' || ind[0].title=='plant' || ind[0].title == "COND_UNIT")){    
         newcell.style.paddingRight="25px"; 
        }
      if(t != "U")
         ind[0].removeAttribute('readonly');     

      if(ind[0] != undefined){    
         var ids=ind[0].id;      
         ind[0].id=ids+nut;
         ind[0].setAttribute("onKeyUp","jspt('"+ids+nut+"',this.value,event)");  
         if(ind[0].title=='MATERIAL'){
            ind[0].setAttribute("onchange","getMatDescBOM('"+ids+nut+"',this,event,'dataTable')");
            var re=  newcell.getElementsByTagName('div');
            var met='MATERIAL'+nut;           
            re[0].style.display=''
            re[0].setAttribute("onclick","lookup('Material', '"+met+"', 'material');");
         }        
         if(ind[0].title=='su'){
               var re=  newcell.getElementsByTagName('div');
               var su='TARGET_QU'+nut;           
               re[0].style.display=''
               re[0].setAttribute("onclick","lookup('SU', '"+su+"', 'uom');");
         }
         if(ind[0].title=='plant'){     
            ind[0].removeAttribute("readonly");                
            ind[0].setAttribute("onchange","setChildPlant(this)");
            ind[0].value = ""; 
            var re=  newcell.getElementsByTagName('div');
            var met='PLANT'+nut;            
            re[0].setAttribute("onclick","lookup_plant('<?=_PLANT?>', '"+met+"');");
        }
        if(ind[0].title == "COND_UNIT"){
            ind[0].removeAttribute("readonly");                            
            var re=  newcell.getElementsByTagName('div');
            var met='COND_UNIT'+nut;            
            re[0].setAttribute("onclick","lookup('<?=_UOM?>', '"+met+"', 'plant','plant');");
        }
         if(ind[0].title=='order_quantity'){
             ind[0].setAttribute("onchange","getMatDescBOM('MATERIAL"+nut+"',this,event,'dataTable')");
            newcell.firstElementChild.removeAttribute("onfocus");           
         }      
         if(ind[0].title=='item_text'){
            ind[0].setAttribute("id","LINE"+nut);
            var re=  newcell.getElementsByTagName('div');
            var et='LINE'+nut;          
            re[0].setAttribute("onclick","enterText('LINE', '"+nut+"');");
           }
           if(ind[0].title=='sales_text'){
            ind[0].setAttribute("id","SALES_LINE"+nut);
               var re=  newcell.getElementsByTagName('div');
               var et='SALES_LINE'+nut;            
               re[0].setAttribute("onclick","enterText('SALES_LINE', '"+nut+"');");
           }                
           if(ind[0].title=='is_free_charge'){
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
         if(ind[0].title == "currency"){         
            ind[0].removeAttribute("readonly");
         } 
         if(ind[(ind.length-1)].title=='item'){
            var numb=newcell.childNodes[0].value;
            var ids=ind[(ind.length-1)].id;
            ind[(ind.length-1)].id=ids+nut;
            ind[(ind.length-1)].value=(nut+10);
            ind[(ind.length-1)].setAttribute("readonly", true);
            var vflag=document.getElementById('flag').value;
            document.getElementById('flag').value=vflag+(nut+10)+'G1S'+t+',';
         }
         else{
            ind[0].value = "";
         }
         if($(document).width()<100){
               var test=$('.iph').find('thead th:nth-child('+(i+1)+')').text();
               $('#'+ids+nut).before('<label class="labls">'+test+'<span> *</span>:</label>');            
           }
       }
      $('.ids_'+inc+' .minw9').show();
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
                    jAlert('<b><?=_ONEITEMREQUIRED?></b>', '<?=_MESSAGE?>');
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
         var j=0;
            var table = document.getElementById(tableID);
         var rowCount = table.rows.length;
         var strs='';
         for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                var parentComponent = row.classList.contains("parentBOM");  
                 var childComponent  = row.classList.contains("childBOM");                
            // var ind=nwcell.getElementsByTagName('input');
            
            //alert(nwcell);
            if(chkbox.id!='head')
                {
                    if(chkbox.checked)
                    {                     
                  if(chkbox.title=='che')
                  {
                     var vflag=document.getElementById('flag').value;
                     var str = vflag.split(',');
                     //i-1 is added for table length count including header and vflag split for corresponding deleted row.
                     var laststr=str[i-1];
                     var sde=laststr.split('G1S');
                     if(sde[1]=='U')
                     {
                        var lst=document.getElementById('flag_d').value;
                        //document.getElementById('flag_d').value=lst+laststr+',';
                        $(table.rows[i]).find(":input").each(function()
                        {
                           id = $(this).attr('id');
                           val=$('#'+id).val();
                           id_vals = id.match(/(\d+|[^\d]+)/g);
                           name = $(this).attr('name');
                           if(id != undefined && name != undefined && id != "bapiName")
                           {
                           if(delete_val=='')
                              delete_val=id_vals[0] + '=' + val;
                           else
                              delete_val = delete_val + '&' + id_vals[0] + '=' + val;
                           }
                        });
                     }
                     if(strs=='')
                        strs=vflag.replace(str[i-1]+',','');
                     else
                        strs=strs.replace(str[i-1]+',','');
                     
                  }
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
                           var parentLineNumber = row.cells[0].childNodes[2].value;
                           var numComponents = $(".component_"+parentLineNumber).length;                          
                           cunt += numComponents;
                        }
                    }
                }
            }
            if(cunt >= rowCount-1)
            {
                jAlert('<b><?=_ONEITEMREQUIRED?></b>', '<?=_MESSAGE?>');
            }
            else
            {
                for(var i=0; i<rowCount; i++) 
                {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    var parentComponent = row.classList.contains("parentBOM");                    
               //alert(row.cells[0].getElementsByTagName('input'));
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
         if(delete_val!='')
         {
         $.cookie("deldata",delete_val);
         }
         if(strs!='')
            document.getElementById('flag').value=strs;
        }
        catch(e) {
        }
    }
   var num=0;
   
   
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
                    $('.iph').find('tbody td:nth-child('+gd+')').children('input[type!="hidden"]').before('<label class="sda">'+text+'<span> *</span>:</label>');
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
      $('#head_tittle').html("Edit Sales Order");
      var tblexample7Len = $('#example7 >tbody >tr').length;
      var tbldataTableLen = $('#dataTable >tbody >tr').length;
      
      $("#edit_salesorder").hide();
      $("#save_salesorder").show();
      $("#cancel_salesorder").show();
      $("#copy_form_data").hide();
      $("#NET_VAL_HD_hide").hide();
      $("#add_row_table").css("display","block");
      $(".tab-con").css("display","none");     
      $(".prodAvQuotationButton").parent().show();    
      if(tbldataTableLen < tblexample7Len){
         rowlen = tblexample7Len-tbldataTableLen;                 
         for(l=0;l<rowlen;l++){            
            var lineNumber = $("#example7")[0].rows[l+3].cells[0].childNodes[1].value;
            lineNumber = parseInt(lineNumber)-10;
            if(lineNumber == 0){
               lineNumber = "";
            }
            addRow('dataTable','U',lineNumber);
         }
      }        
      $("#dataTable tbody tr").each(function(rind){                          
         if(rind < tblexample7Len){
            $(this).find("input[type=text]").each(function(){                
               /*if($(this).attr("id").indexOf("TARGET_QU") >= 0)
                  if($(this).is("[readonly]"))
                     $(this).next().hide();*/
               if($(this).attr("id").indexOf("REQ_QTY") >= 0 || $(this).attr("id").indexOf("COND_VALUE") >= 0 ||  $(this).attr("id").indexOf("COND_P_UNT") >= 0 || $(this).attr("id").indexOf("COND_UNIT") >= 0 || $(this).attr("id").indexOf("SHORT_TEXT") >= 0 ||  $(this).attr("id").indexOf("CURRENCY") >= 0 || $(this).attr("id").indexOf("PLANT") >= 0 || $(this).attr("id").indexOf("MATERIAL") >= 0  ||  $(this).attr("id").indexOf("TARGET_QU") >= 0) {
                  $(this).attr("readonly", false);
                    }
            });
         }
         else{
            $(this).find("input[type=text]").each(function(tindex){
               if(tindex > 0)
                  $(this).attr("readonly", false);
            });
         }
      });
      
      var str = '';
      // $("#example7_tbody input[type=hidden]").each(function(){
      $("#example7_tbody").find("input[type=hidden]").each(function(){
         id = $(this).attr('ids');              
         val = $(this).attr('value');

         if(id != undefined) 
            str = str + id + '=' + val + '&';
      });
      
      var values = str.split("&");  
      var isParent = false;
      var isChild = false;
      var itemNumberParent = "";    
      var itemNumber = "";
      $("#dataTable input[type=text],#dataTable input[type=hidden],#dataTable input[type=checkbox],#CURRENCY,#PLANT,.ITM_TXT").each(function()
      {
         var id = $(this).attr('id');
         var ids=$(this).attr('ids');         


         for(var j=0; j < values.length; j++)
         {
            var value = values[j].split("=");            
            if(id == value[0])
            {  

               if(id.indexOf("ITM_NUMBER")>=0){                             
                  itemNumber = value[1];
                  $(this).attr("value",itemNumber);                  
               }
               if(id.indexOf("IS_FREE_CHARGE")>=0){
                  if(value[1] == "AGNN"){
                     $(this).prop("checked","checked");
                     this.nextElementSibling.value = "1";
                  }
               }
               if(id.indexOf("ITEM_CATEG")>=0){
                  isParent = false;                  
                  if(value[1] == "ZTAQ"){           
                     itemNumberParent = itemNumber;                              
                     $(this).closest("tr").addClass("parentBOM");
                     isParent = true;
                  }
               }               
               if(id.indexOf("HIGH_LEVEL_ITEM")>=0){                  
                  isChild = false;                  
                  if(value[1] != "" && value[1] != 0){                     
                     $(this).closest("tr").addClass("childBOM");
                     $(this).closest("tr").addClass("component_"+parseInt(value[1]));  
                     $(this).val(value[1]);     
                     isChild = true;                
                  }
               }
               else{
                 $(this).val(value[1]);
              }

              if(id.indexOf("REQ_QTY")>=0){
                  if(isParent){                     
                     $(this).attr("onfocus","saveOrigQty(this.value)");
                     $(this).attr("onchange","calcItemsQty('"+itemNumberParent+"',this)");
                  }else if(isChild){
                     this.classList.add("reqQty_"+itemNumberParent);
                  }
              }

            }
            
         }
      });
   });
   
   $("#cancel_salesorder").click(function() 
   {
      $('#head_tittle').html("Display Sales Order")
      $("#edit_salesorder").show();
      $("#save_salesorder").hide();
      $("#cancel_salesorder").hide();
      $(".prodAvQuotationButton").parent().hide();

      $("#copy_form_data").show();
      $("#NET_VAL_HD_hide").show();
      
      $("#add_row_table").css("display","none");
      $(".tab-con").css("display","block");
      
      $("#validation7 input[type=text]").each(function(){
         $(this).attr("readonly", true);
         //$(".minw").css("display","none");
      });
   });
});

function change_disp_mode()
{
   $("#dataTable tbody tr").each(function(rindex) {
      newrow = false;
      $(this).find("[title='MATERIAL']").each(function() {
         ctrl_attr = $(this).attr("readonly");
         if(ctrl_attr == undefined)
            newrow = true;
      });
      if(newrow)
      {
         rowval = $(this).find("[type='text'],[type='hidden']").serialize();
         rowval = rowval.replace(/%5B%5D/gi, "");
         var values = rowval.split("&");
         row_id = eval($("#example7 tbody tr:last").attr("id"))+(10*(rindex+1));
         row_id = (10*rindex);
         $("#example7 tbody tr:first").clone().find("td").each(function(index) {
            $(this).find("input").attr({
               'ids': function(_, ids) { return ids + row_id }
            });
            if(index == 0)
            {
               tdhtml = $(this).html();
               $(this).html(tdhtml.replace(/10/gi, (row_id+10)));
            }
            else
            {
               tdtext = $(this).text().trim();
               tdhtml = $(this).html().trim();
               var re = new RegExp(tdtext, 'gi');
               
               inpctrl = $(this).find("input");
               if(values[index] != undefined)
               {
                  var value = values[index].split("=");
                  if(value[0] == "Currency")
                  {
                     var value = values[(index-1)].split("=");
                     $(this).html(tdhtml.replace(re, urldecode(value[1])));
                     tdtext = inpctrl.val().trim();
                     tdhtml = $(this).html().trim();
                     var re = new RegExp(tdtext, 'gi');
                     $(this).html(tdhtml.replace(re, urldecode(value[1])));
                  }
                  else if(value[0] == "Price")
                  {
                     var qty = values[(index-1)].split("=");
                     x = (urldecode(value[1])*qty[1]);
                     rate = x.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                     $(this).html(tdhtml.replace(re, rate));
                  }
                  else if(value[0] == "su")
                  {
                     $(this).html(tdhtml.replace(re, value[1]));
                     tdtext = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").text().trim();
                     tdhtml = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html().trim();
                     var re = new RegExp(tdtext, 'gi');
                     $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html(tdhtml.replace(re, value[1]));
                  }
                  else
                     $(this).html(tdhtml.replace(re, value[1]));
               }
            }
         }).end().appendTo("#example7");
         $("#example7 tbody tr:last").attr("id", row_id);
      }
      else
      {
         rowval = $(this).find("[type='text'],[type='hidden']").serialize();
         rowval = rowval.replace(/%5B%5D/gi, "");
         var values = rowval.split("&");
         if(rindex == 0)
            row_id = 10;
         else
            row_id = (10*rindex);
         // console.log(row_id);
         // console.log($("#example7 tbody tr:nth-child("+(rindex+1)+")").find("td:first").text().trim());
         // return;
         $("#example7 tbody tr:nth-child("+(rindex+1)+")").find("td").each(function(index) {
            if(index == 0)
            {
               // tdhtml = $(this).html();
               // $(this).html(tdhtml.replace(/10/gi, (row_id+10)));
            }
            else
            {
               tdtext = $(this).text().trim();
               tdhtml = $(this).html().trim();
               var re = new RegExp(tdtext, 'gi');
               
               inpctrl = $(this).find("input");
               if(values[index] != undefined)
               {
                  var value = values[index].split("=");
                  if(value[0] == "Currency")
                  {
                     var value = values[(index-1)].split("=");
                     $(this).html(tdhtml.replace(re, urldecode(value[1])));
                     tdtext = inpctrl.val().trim();
                     tdhtml = $(this).html().trim();
                     var re = new RegExp(tdtext, 'gi');
                     $(this).html(tdhtml.replace(re, urldecode(value[1])));
                  }
                  else if(value[0] == "Price")
                  {
                     var qty = values[(index-1)].split("=");
                     x = (urldecode(value[1])*qty[1]);
                     rate = x.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                     $(this).html(tdhtml.replace(re, rate));
                  }
                  else if(value[0] == "su")
                  {
                     $(this).html(tdhtml.replace(re, value[1]));
                     tdtext = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").text().trim();
                     tdhtml = $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html().trim();
                     var re = new RegExp(tdtext, 'gi');
                     $(this).closest("tr").find("[name='TARGET_QU']").closest("td").html(tdhtml.replace(re, value[1]));
                  }
                  else
                     $(this).html(tdhtml.replace(re, value[1]));
               }
            }
         });
      }
   });
}
function save_quotation()
{
    //alert('hi');
   // console.log($('#validation7').serialize());
   // change_disp_mode();
   // return false;

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
   // alert($('#validation7').serialize());
    $.ajax({
        type: 'POST', 
        data: $('#validation7').serialize(), 
        url: 'editsalesquotation_sold/save_sales_quotation',         
        success: function(response) 
        {                           

         $('#loading').hide();
            $("body").css("opacity","1");       
            var spt = response.split("@");
         var n = spt[0].indexOf("System error");
         var type = spt[1];
         // alert(n);
         // if(n < 0)
         if(type != "E")
         {
            jConfirm('<b><?=_SAPSYSTEMMESSAGE?>: </b><br>'+ spt[0], '<?=_SALESQUOTATIONCHANGE?>', function(r) {
               if(r)
               {
                  $('#loading').show();
                  $("body").css("opacity","0.4");
                  $("body").css("filter","alpha(opacity=40)");
                  $.ajax({
                     type:'POST',
                     data:$('#validation7').serialize(),
                     url: 'editsalesquotation_sold/commit',
                     success: function(response)
                     {
                        
                        //submit_form('validation3');
                        if($.cookie("deldata"))
                        {
                           $.cookie("deldata", null);
                        }
                        $('#loading').hide();
                        $("body").css("opacity","1");
                        $("#cancel_salesorder").trigger("click");
                        jAlert('<b><?=_SAPSYSTEMMESSAGE?>: </b><br> <?=_SAPSYSTEMMESSAGECS?>', '<?=_SALESQUOTATIONCHANGE?>');
                     }
                  });
               }
            });
            $("#popup_ok").val('<?=_CLICKTOCONFIRM?>');
         }
         else
            jAlert('<b><?=_SAPSYSTEMMESSAGE?>: </b><br>'+ spt[0], '<?=_SALESQUOTATIONCHANGE?>');
        }
    });
}

function orders()
{
}

function strpdf()
{
   $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
   $.ajax({
      type:'POST',
      data:'order_num='+number($('#I_VBELN').val())+'&bapi=editsalesquotation_doc',
      url:'editsalesquotation_sold/stringpdf',
      success:function(data){
      // alert(data);
      $('#loading').hide();
            $("body").css("opacity","1");
         if($.trim(data)!='')
         {
            jAlert(data,'<?=_MESSAGE?>');
         }
         else
         {
            var tab=window.open('common/Pdfurl');
            tab.focus();
         }
      }
   });   
}

function setFreeCharge(checkbox){   
   if(checkbox.checked){
      $("#FREE_CHARGE"+checkbox.id.split("CHARGE")[1]).val("1");     
      $("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).val("0");
      $("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");      
      $("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");
      $("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).val("0");      
      $("#COND_UNIT"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");
      $("#COND_UNIT"+checkbox.id.split("CHARGE")[1]).val("0");      
      $("#KONWA"+checkbox.id.split("CHARGE")[1]).prop("readonly","readonly");    
      $("#ITEM_CATEG"+checkbox.id.split("CHARGE")[1]).val("AGNN");      
   }else{
      $("#FREE_CHARGE"+checkbox.id.split("CHARGE")[1]).val("0");     
      $("#NET_PRICE"+checkbox.id.split("CHARGE")[1]).prop("readonly","");     
      $("#COND_P_UNT"+checkbox.id.split("CHARGE")[1]).prop("readonly",""); 
      $("#COND_UNIT"+checkbox.id.split("CHARGE")[1]).prop("readonly","");    
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
        jAlert("<?=_SELECTAMATERIAL?>","Message",);
    }else if(plant == undefined || plant == null || plant.trim() == ""){
        jAlert("<?=_SELECTPLANT?>","Message");
    }else{
        show_prod_avail_quotation(material,plant,"product_availability_quotation",true);
    }
}

</script>