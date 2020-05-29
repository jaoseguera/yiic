<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Create_deliveryForm extends CFormModel
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


    public function _actionSubmit($fce)
    {
        global $rfc;
        $ref_doc  = strtoupper($_REQUEST['REF_DOC']);
        $cusLenth = count($ref_doc);
        if($cusLenth < 10 && $ref_doc!='') { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $imporTableOrderItems = array();
        $SALES_ORDER_ITEMS=array("REF_DOC"=>strtoupper($ref_doc));
        array_push($imporTableOrderItems, $SALES_ORDER_ITEMS);

        $res = $fce->invoke(['SALES_ORDER_ITEMS'=>$imporTableOrderItems],$options);        

        $SalesOrder=$res['SALES_ORDER_ITEMS'];  
        $SalesOrder1=$res['SERIAL_NUMBERS'];
        $SalesOrder2=$res['EXTENSION_IN'];
        $SalesOrder3=$res['DELIVERIES'];
        $SalesOrder4=$res['CREATED_ITEMS'];
        $SalesOrder5=$res['EXTENSION_OUT'];
        $SalesOrder6=$res['RETURN'];
        $deliv = $res['DELIVERY'];

        $msg="";
        $type=0;
        $er_msg="";
		$msgtype = "S";
        $restype = array();
            foreach($SalesOrder6 as $keys)
            {
                $restype[] = $keys['TYPE'];
				//$msg.=$keys['MESSAGE']."<br>";
                if($keys['TYPE']=='E' || $keys['TYPE']=='A'){
                    $er_msg.=$keys['MESSAGE']."<br>";
                    $type=1;
                }elseif($keys['TYPE']=='W' || $keys['TYPE']=='I'){
                    $msg.=$keys['MESSAGE']."<br>";
                }
            }

            if($type==0){
                if(in_array("I", $restype) || in_array("W", $restype)){
                    $msg.=$ref_doc." Please confirm to create a Delivery.";
                }else{
                    $msg=$ref_doc." Please confirm to create a Delivery.";
                }
                ?><script>
                    $(document).ready(function() {
                        //$('#validation input:text').val("");
                    });
                </script><?php
            }
        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $fce = $rfc->getFunction('BAPI_TRANSACTION_ROLLBACK');
        $fce->invoke();

		if($type!=0):
			?>
				<script>
					$(document).ready(function(e) {
						jAlert("<b>SAP System Message:</b><br><?php echo $er_msg;?>", "Message");
                        $("#popup_ok").click( function() {
                            $('#validation input:text').val("");
                        });
					});
				</script>
			<?php
		else:
			?>
				<script>
					$(document).ready(function(e) {
						// jAlert("<b>SAP System Message:</b><br><?php echo $msg;?>", "Message");
						jConfirm("<b>SAP System Message: </b><br><?php echo $msg;?>", "Message", function(r) {
						if(r)
						{
							$('#loading').show();
							$("body").css("opacity","0.4");
							$("body").css("filter","alpha(opacity=40)");
							$.ajax({
								type:'POST',
								data:$('#validation').serialize(),
								url: 'create_delivery/commit',
								success: function(response)
								{
									$('#loading').hide();
									$("body").css("opacity","1");
									jAlert("<b>SAP System Message:</b><br>"+response, "Message");
                                    $("#popup_ok").click( function() {
                                        $('#validation input:text').val("");
                                    });

								}
							});
						}else{$('#validation input:text').val("");}

					});
					});
				</script>
			<?php
		endif;


    }

    public function _actionCommit($fce)
    {
        global $rfc;

        $ref_doc  = strtoupper($_REQUEST['REF_DOC']);
        $cusLenth = count($ref_doc);
        if($cusLenth < 10 && $ref_doc!='') { $ref_doc = str_pad((int) $ref_doc, 10, 0, STR_PAD_LEFT); } else { $ref_doc = substr($ref_doc, -10); }

        //GEZG 06/22/2018
        //Changing SAPRFC methods
        $options = ['rtrim'=>true];
        $imporTableOrderItems = array();
        $SALES_ORDER_ITEMS=array("REF_DOC"=>strtoupper($ref_doc));
        array_push($imporTableOrderItems, $SALES_ORDER_ITEMS);

        $res = $fce->invoke(['SALES_ORDER_ITEMS'=>$imporTableOrderItems],$options);        

        $SalesOrder=$res['SALES_ORDER_ITEMS'];
        $SalesOrder1=$res['SERIAL_NUMBERS'];
        $SalesOrder2=$res['EXTENSION_IN'];
        $SalesOrder3=$res['DELIVERIES'];
        $SalesOrder4=$res['CREATED_ITEMS'];
        $SalesOrder5=$res['EXTENSION_OUT'];
        $SalesOrder6=$res['RETURN'];
        $deliv = $res['DELIVERY'];
        $msg="";
        $er_msg="";
        $res_msg="";
        $type=0;
        /*$restype = array();

            foreach($SalesOrder6 as $keys)
            {
                $restype[] = $keys['TYPE'];
                if($keys['TYPE']=='S')
                {
                    $msg.=$keys['MESSAGE']."<br>";
                }
            }*/
        $restype = array();
        foreach($SalesOrder6 as $keys)
        {
            $restype[] = $keys['TYPE'];
            //$msg.=$keys['MESSAGE']."<br>";
            if($keys['TYPE']=='E' || $keys['TYPE']=='A'){
                $er_msg.=$keys['MESSAGE']."<br>";
                $type=1;
            }elseif($keys['TYPE']=='S'){
                $res_msg.=$keys['MESSAGE']."<br>";
            }
        }

        if($type==0){
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_COMMIT');
            $fce->invoke();
        }else{
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_TRANSACTION_ROLLBACK');
            $fce->invoke();
            $res_msg = $er_msg;
        }


       echo $res_msg;

    }
}