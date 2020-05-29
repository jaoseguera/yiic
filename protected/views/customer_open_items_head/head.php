<?php 
global $rfc,$fce;
if(isset($_REQUEST['CUSTOMER_NUMBER']))
{
      $cust_num = $_REQUEST['CUSTOMER_NUMBER'];
      $cusLenth = count($cust_num);
      if($cusLenth < 10 && $cust_num!='') { $cust_num = str_pad((int) $cust_num, 10, 0, STR_PAD_LEFT); } else { $cust_num = substr($cust_num, -10); }
      $sale = $_REQUEST['COMPANY_CODE'];
      $date = $_REQUEST['sales_order_date'];
      $dateto = $_REQUEST['sales_order_dateto'];
      
   
      list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $date)));      
      $date1 = $year.$month.$day;
      //$date = $month.$day.$year;
      if($date1 == ""){$date1 = "00000000";}
      
      list($month, $day, $year) = explode('/', str_replace(".","/",str_replace("-", "/", $dateto)));      
      $dateto = $year.$month.$day;
      if($dateto == ""){$dateto = "00000000";}
      //$dateto = $month.$day.$year;
      //GEZG 06/22/2018
      //Changing SAPRFC methods
      $options = ['rtrim'=>true];
      $res = $fce->invoke(['CUSTOMER'=>$cust_num,
                           'COMPANYCODE'=>$sale,
                           'KEYDATE'=>$date1],$options);

 
      $customer=$res['E_CUSTOMER_NAME'];
      $credit=$res['E_CREDIT_LIMIT'];
      $total=$res['TOTAL'];
      $head=$res['AMOUNTS'];       
      $paymentTermCode = $res["E_ZTERM"];
      $paymentTermDesc = $res["E_ZTERM_DESC"];

      $ids=1;  
         
      $_SESSION['ar_ag']=$total;
      $_SESSION['CREDIT']=$credit;
      $_SESSION['CUSTOMER']=$customer;
      $_SESSION['head']=$head;
      $_SESSION["paymentTermCode"] = $paymentTermCode;
      $_SESSION["paymentTermDesc"] = $paymentTermDesc;
}
?>

                          

                  
<div class="span6 utopia-form-freeSpace myspace" >
    
            <fieldset>
            
            
               <div class="control-group">
                  <label class="control-label cutz in_custz" alt="Customer Name" for="input01" id='CUSTOMER_NAME_LABEL'><?=Controller::customize_label(_CUSTOMERNAME); ?>:</label>
                  <div class="controls">
                     <input alt="Customer Name" type="text" name='CUSTOMER_NUMBER' id='CUSTOMER_NUMBER' class="input-fluid validate[required,custom[salesorder]] getval radius" readonly value='<?php echo $customer; ?>'  autocomplete="off"/>
                      
                  </div>
               </div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01" id='CREDIT_LIMIT_LABEL' alt="Credit Limit"><?=Controller::customize_label(_CREDITLIMIT); ?>:</label>
                  <div class="controls">
                     <input alt="Credit Limit" type="text" name='CREDIT_LIMIT' id='CREDIT_LIMIT' class="input-fluid validate[required,custom[customer]] getval radius" readonly  value='<?php echo $credit; ?>'  autocomplete="off"/>
                  </div></div>
              <!--
               <div class="control-group">
                  <label class="control-label cutz" for="input01" id='UPTO_1_LABEL' alt='Upto 1 days'><?=Controller::customize_label(_UPTO1DAY); ?>:</label>
                  <div class="controls">
                     <input alt="Upto 1 days" type="text" name='UPTO_1_DAYS' id='UPTO_1_DAYS' class="input-fluid validate[required,custom[dis]] getval radius" readonly value='<?php echo $head['UPTO_1_DAYS']; ?>'  autocomplete="off"/>
                  </div></div>
               -->
              <div class="control-group" >
                  <label class="control-label cutz" for="input01"  alt='Upto 30 days'><?=Controller::customize_label(_UPTO30DAY); ?>:</label>
                  <div class="controls">
                     <input alt="Upto 30 days" type="text" id="" name='UPTO_30_DAYS'  class="input-fluid getval radius" readonly value="<?php echo $head['UPTO_30_DAYS']; ?>"/>
                  </div></div>
              <div class="control-group" >
                  <label class="control-label cutz" for="input01"  alt='Upto 60 days'><?=Controller::customize_label(_UPTO60DAY); ?>:</label>
                  <div class="controls">
                     <input alt="Upto 60 days" type="text" id="UPTO_60_DAYS" name='UPTO_60_DAYS'  class="input-fluid getval radius" readonly value="<?php echo $head['UPTO_60_DAYS']; ?>"/>
                  </div></div>
               
               <div class="control-group" >
                  <label class="control-label cutz" for="input01"  alt='Upto 90 days'><?=Controller::customize_label(_UPTO90DAY); ?>:</label>
                  <div class="controls">
                     <input alt="Upto 90 days" type="text" id="UPTO_90_DAYS" name='UPTO_90_DAYS'  class="input-fluid getval radius" readonly value="<?php echo $head['UPTO_90_DAYS']; ?>"/>
                  </div>
               </div>

            </fieldset>
         </div>
         <div class="span6 utopia-form-freeSpace">
            <fieldset>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"    id="AR_AGING_LABEL" alt='AR aging Information'><?= Controller::customize_label(_AGINGINFORMATION); ?>:</label>
                  <div class="controls">
                     <input alt="AR aging Information" type="text" name="AR_AGING" id='AR_AGING' class="input-fluid validate[required] getval radius"  autocomplete="off" readonly value='<?php echo $total; ?>'/>
                  </div></div>
               <div class="control-group">
                  <label class="control-label cutz" for="input01"    id="AMT_DUE_LABEL" alt='Amount Due'><?= Controller::customize_label(_AMOUNTDUE); ?>:</label>
                  <div class="controls">
                     <input alt="Amount Due" type="text" name='AMT_DUE' id='AMT_DUE' class="input-fluid validate[required,custom[divi]] getval radius" onKeyUp="jspt('DIVISION',this.value,event)" readonly autocomplete="off" value='<?php echo $head['AMT_DUE']; ?>'/>
                      
                  </div></div>

               
              <!-- 
              <div class="control-group" >
                  <label class="control-label cutz" for="input01"  alt='Upto 120 days'><?=Controller::customize_label(_UPTO120DAY); ?>:</label>
                  <div class="controls">
                     <input alt="Upto 120 days" type="text" id="UPTO_120_DAYS" name='UPTO_120_DAYS'  class="input-fluid getval radius" readonly value="<?php echo $head['UPTO_120_DAYS']; ?>"/>
                  </div></div>
               -->
              <div class="control-group" id="NET_VAL_HD_hide">
                  <label class="control-label cutz" for="input01" id='MT_120_DAYS_LABEL' alt='More then 120 days'><?=Controller::customize_label(_MORETHEN120DAY); ?>:</label>
                  <div class="controls">
                     <input alt="More then 120 days" type="text" name='MT_120_DAYS' id='MT_120_DAYS' class="input-fluid validate[required,custom[dis]] getval radius" readonly value='<?php echo $head['MT_120_DAYS']; ?>' onKeyUp="jspt('NET_VAL_HD',this.value,event)" autocomplete="off"/>
              </div>
            </div>

               <div class="control-group">
                  <label class="control-label cutz" for="input01"    id="PAYMENT_TERM_CODE_LBL" alt='Payment Term Code'><?= Controller::customize_label(_PAYMENTTERMCODE); ?>:</label>
                  <div class="controls">
                     <input alt="Payment Term Code" type="text" name="PAYMENT_TERM_CODE" id='PAYMENT_TERM_CODE' class="input-fluid validate[required] getval radius"  autocomplete="off" readonly value='<?php echo $paymentTermCode; ?>'/>
                  </div>
               </div>

               <div class="control-group">
                  <label class="control-label cutz" for="input01"    id="PAYMENT_TERM_DESC_LBL" alt='Payment Term Desc'><?= Controller::customize_label(_PAYMENTTERMDESC); ?>:</label>
                  <div class="controls">
                     <input alt="Payment Term Desc" type="text" name="PAYMENT_TERM_DESC" id='PAYMENT_TERM_DESC' class="input-fluid validate[required] getval radius"  autocomplete="off" readonly value='<?php echo $paymentTermDesc; ?>'/>
                  </div>
               </div>
              
            </fieldset>
         </div>

                            

                         
<div id="head_table">
       <table> <tbody>
              <tr>
                  <td><?=Controller::customize_label(_CUSTOMERNAME); ?></td>
                    <td> <?php echo $customer; ?>
                  </td>
              <td>
                  <?=Controller::customize_label(_AGINGINFORMATION); ?></td>
                  <td>
                     <?php echo $total; ?>
                  </td>
               </tr>
            <tr>
               <td>
                  <?=Controller::customize_label(_CREDITLIMIT); ?></td>
                  <td>
                     <?php echo $credit; ?>
                  </td>
               <td>
                  <?=Controller::customize_label(_AMOUNTDUE); ?></td>
                  <td>
                     <?php echo $head['AMT_DUE']; ?>
                      
                  </td>
              </tr>
              <tr>
               <td>
                  <?=Controller::customize_label(_UPTO1DAY); ?></td>
                  <td>
                     <?php echo $head['UPTO_1_DAYS']; ?>
                  </td>
               <td>
                  <?=Controller::customize_label(_UPTO90DAY); ?></td>
                  <td>
                     <?php echo $head['UPTO_90_DAYS']; ?>
                  </td></tr>
              <tr>
              <td>
                  <?=Controller::customize_label(_UPTO30DAY); ?></td>
                  <td>
                     <?php echo $head['UPTO_30_DAYS']; ?>
                  </td>

                             <td>
                  <?=Controller::customize_label(_UPTO120DAY); ?></td>
                  <td>
                     <?php echo $head['UPTO_120_DAYS']; ?>
                  </td></tr>
              <tr>
                  <td>
                  <?=Controller::customize_label(_UPTO60DAY); ?></td>
                  <td>
                     <?php echo $head['UPTO_60_DAYS']; ?>
                  </td>
           <td>
                  <?=Controller::customize_label(_MORETHEN120DAY); ?></td>
                  <td>
                     <?php echo $head['MT_120_DAYS']; ?>
           </td></tr>
   </tbody>
               </table>
              </div>
              <script>
           $('#head_table').hide();
           </script>
     