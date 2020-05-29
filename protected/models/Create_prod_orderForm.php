<?php

class Create_prod_orderForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    public function rules()
    {
        return array(
            //array('username','email'),
            // username and password are required
            //array('username, password', 'required'),
            // rememberMe needs to be a boolean
            //array('rememberMe', 'boolean'),
            // password needs to be authenticated
            // array('password', 'authenticate'),
        );
    }
    
    public function _actionSubmit($doc, $screen, $fce)
    {
        global $rfc;
        if(isset($_REQUEST['MATERIAL']))
        {
            $MATERIAL=strtoupper($_REQUEST['MATERIAL']);
            $PLANT=strtoupper($_REQUEST['PLANT']);
            $ORDER_TYPE=strtoupper($_REQUEST['ORDER_TYPE']);
            $BASIC_START_DATE=$_REQUEST['BASIC_START_DATE'];
            $BASIC_END_DATE=$_REQUEST['BASIC_END_DATE'];
            $QUANTITY=strtoupper($_REQUEST['QUANTITY']);
            $QUANTITY_UOM=strtoupper($_REQUEST['QUANTITY_UOM']);
            ($QUANTITY_UOM=='PC')?$QUANTITY_UOM='ST':$QUANTITY_UOM;
            $date_one=explode('/',$BASIC_START_DATE);
            $BASIC_START_DATE=$date_one[2].$date_one[0].$date_one[1];
            $date_two=explode('/',$BASIC_END_DATE);
            $BASIC_END_DATE=$date_two[2].$date_two[0].$date_two[1];
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $ORDERDATA=array("MATERIAL"=>$MATERIAL,"PLANT"=>$PLANT,"ORDER_TYPE"=>$ORDER_TYPE,"BASIC_START_DATE"=>$BASIC_START_DATE,"BASIC_END_DATE"=>$BASIC_END_DATE,"QUANTITY"=>floatval($QUANTITY),"QUANTITY_UOM"=>$QUANTITY_UOM);            
            $res = $fce->invoke(['ORDERDATA'=> $ORDERDATA],$options);            
            $dt=0;
            $hs="";            
            $msg=$res['ORDER_NUMBER'];            
            $error=$res['RETURN'];
            if($msg=="")
            {
            $msg=$error['MESSAGE']."<br>";
            $ty=$error['TYPE'];
            if($ty!='S')
            {
            $dt=1;
            }
            }
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();

            if($dt==0)
            { ?>
            <script>
            $(document).ready(function(e) {	
            $('#validation input:text').val("");
            jAlert("<b>SAP System Message: </b><br><?php echo $msg;?> has been created", "Message");
            });
            </script>
            <?php }
            else
            {
            ?>
            <script>
            $(document).ready(function(e) {
            jAlert("<b>SAP System Message: </b><br><?php echo $msg;?>", "Message");
            });
            </script><?php
            }
        }
    }
    
    
}