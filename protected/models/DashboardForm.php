<?php

/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class DashboardForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    /**
    * Declares the validation rules.
    * The rules state that username and password are required,
    * and password needs to be authenticated.
    **/
    
    public function rules()
    {
        return array(
            // array('username','email'),
            // username and password are required
            // array('username, password', 'required'),
            // rememberMe needs to be a boolean
            // array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }

    public function _actionSubmit($doc, $screen, $fce)
    {
        global $rfc;
        if($_REQUEST['table_name'] == 'Inforecords')
        {
            ?><script>$('#tabShow').show();</script><?php
            if(!isset($_SESSION['info_gen']))
            {
                $VENDOR=strtoupper($_REQUEST['VENDOR']);
                $VENDORLenth = count($VENDOR);
                if($VENDORLenth < 10 && $VENDOR!='') { $VENDOR = str_pad((int) $VENDOR, 10, 0, STR_PAD_LEFT); } else { $VENDOR = substr($VENDOR, -10); }
                $MATERIAL=strtoupper($_REQUEST['MATERIAL']);
                $PLANT=strtoupper($_REQUEST['PLANT']);
                $options = ['rtrim'=>true];
                $res = $fce->invoke(['VENDOR'=>$VENDOR,
                                    'MATERIAL'=>$MATERIAL,
                                    'PLANT'=>$PLANT,
                                    'INFO_TYPE'=>'0',
                                    'PURCHORG_DATA'=>'X',
                                    'GENERAL_DATA'=>'X',
                                    'PURCHORG_VEND'=>'X'],$options);                
                $SalesOrder=$res['INFORECORD_GENERAL'];
                $SalesOrder1=$res['INFORECORD_PURCHORG'];
                $SalesOrder2=$res['RETURN'];
                //////////////////////////////////////////////////////////////////////////////////
                $sw=1;
                $result=NULL;
                if(count($SalesOrder)!=0)
                {
                    $table_inf  = "MATERIAL,VENDOR,SHORT_TEXT,SALES_PERS,POINTS";
                    $labels_inf = "MATERIAL,VENDOR,SHORT_TEXT,SALES_PERS,POINTS";
                    $tableField1  = $screen.'_Inforecords';
                    if(isset($doc->customize->$tableField1->Table_order))
                    {
                        $labels_inf=$doc->customize->$tableField1->Table_order;
                    }
                    $exps1 = explode(',',$table_inf);
                    $exp=explode(',',$labels_inf);
                    if(count($exp)<6)
                    {
                        for($j=count($exp)-1;$j<count($exps1);$j++)
                        {
                            $exp[$j]=$exps1[$j];
                        }
                    }
                    foreach($SalesOrder as $val_t=>$retur)
                    {
                        $order_t=array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
                        unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
                        $today=$retur;
                        $result[$sw] = array_merge((array)$order_t, (array)$today);
                        $sw++;
                    }
                }
                $sw1=1;
                $result1=NULL;
                if(count($SalesOrder1)!=0)
                {
                    $table_infc="PURCH_ORG,PLANT,PUR_GROUP,PLND_DELRY,NET_PRICE";
                    $labels_infc="PURCH_ORG,PLANT,PUR_GROUP,PLND_DELRY,NET_PRICE";
                    $tableField1  = $screen.'_Inforecord_Purchase_Org';
                    if(isset($doc->customize->$tableField1->Table_order))
                    {
                        $labels_infc=$doc->customize->$tableField1->Table_order;
                    }
                    $exps1 = explode(',',$table_infc);
                    $exp=explode(',',$labels_infc);
                    if(count($exp)<6)
                    {
                        for($j=count($exp)-1;$j<count($exps1);$j++)
                        {
                            $exp[$j]=$exps1[$j];
                        }
                    }

                    foreach($SalesOrder1 as $val=>$bill)
                    {
                        $order_b=array($exp[0]=>$bill[$exp[0]],$exp[1]=>$bill[$exp[1]],$exp[2]=>$bill[$exp[2]],$exp[3]=>$bill[$exp[3]],$exp[4]=>$bill[$exp[4]]);
                        unset($bill[$exp[0]],$bill[$exp[1]],$bill[$exp[2]],$bill[$exp[3]],$bill[$exp[4]]);
                        $billing=$bill;
                        $result1[$sw1] = array_merge((array)$order_b, (array)$billing);
                        $aert[$sw1]=array_merge((array)$result[$sw1], (array)$result1[$sw1]);
                        $sw1++;
                    }
                }
                $_SESSION['info_gen']=$result;
                $_SESSION['info_pur']=$result1;
                $_SESSION['combine'] =$aert;
                $count_g=count($SalesOrder);
                $count_p=count($SalesOrder1);
                if($count_g>10)
                {
                    $count_g=10;
                }
                if($count_p>10)
                {
                    $count_p=10;
                }
                if($SalesOrder2!=NULL)
                {
                    $dt=0;
                    $hs="";
                    foreach($SalesOrder2 as $keys)
                    {
                        $hs.=$keys['MESSAGE']."<br>";
                        $ty=$keys['TYPE'];
                        if($ty!='S')
                        {
                                $dt=1;
                        }
                    }
                    if($dt==0)
                    { 
                        ?><script>
                        $(document).ready(function(e) 
                        {   
                            $('#validation input:text').val("");
                        });
                        </script><?php 
                    }
                    ?><script>
                    $(document).ready(function(e) 
                    { 
                        var sapSystemMessage =  '<?=Controller::customize_label(_SAPSYSTEMMESSAGE);?>';
                        var message =  '<?=Controller::customize_label(_MESSAGE);?>';
                        jAlert(sapSystemMessage+"<?php echo $hs;?>", Message);
                    });
                    </script><?php
                }
            }
        }
        
        if($_REQUEST['table_name'] == 'Sales_orders')
        {
            $customer = $_REQUEST['CUSTOMER_ID'];
            $cusLenth = count($customer);
            if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }
            // echo $customer; exit;
            $btn = $_REQUEST['btn'];
            //GEZG 06/22/2018
            //Changing SAPRFC methods            
            $options = ['rtrim'=>true];
            $importTableIDRANGE = array();
            $IDRANGE   = array("OPTION"=>"EQ","LOW"=>$customer);
            array_push($importTableIDRANGE, $IDRANGE);

            $res = $fce->invoke(["MAXROWS"=>'0',
                                "CPDONLY"=>'',
                                "IDRANGE"=>$importTableIDRANGE],$options);            
      
                        
           
            $edit_cus  = $res['ADDRESSDATA'];
            $_SESSION['edit_cus']=$edit_cus;
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_SALESORDER_GETLIST');
            $options = ['rtrim'=>true];
            $res = $fce->invoke(['CUSTOMER_NUMBER'=>$customer,
                                'SALES_ORGANIZATION'=>1000],$options);            
                                    
            $SalesOrder = $res['SALES_ORDERS'];
            $sd=1;
            foreach($SalesOrder as $keys)
            {
                $result[$sd]=$keys;
                $sd++;  
            }
            $_SESSION['example40_today'] = $result;
            $rowsag1  = count($result);
            $cust_num = $edit_cus[0]['CUSTOMER'];            
        }
    }
}