<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Approve_purchase_orderForm extends CFormModel
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
    
    public function _actionSubmit()
    {
        global $fce;
        if(isset($_REQUEST['PURCHASEORDER']))
        {
            $PURCHASEORDER  = strtoupper($_REQUEST['PURCHASEORDER']);
            $release_code   = strtoupper($_REQUEST['PO_REL_CODE']);
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $res = $fce->invoke(['PURCHASEORDER'=>$PURCHASEORDER,
                                'PO_REL_CODE'=>$release_code,
                                'USE_EXCEPTIONS'=> ''],$options);

            $SalesOrder=$res['RETURN'];
			
            $dt = 0;
            $hs = "";
            foreach($SalesOrder as $keys)
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
                $(document).ready(function(e) {	
					$('#validation input:text').val("");
                });
                </script><?php
            }
            if($SalesOrder==NULL)
            {
                $hs = "Purchase Order release successful";
            }
            ?><script>
            $(document).ready(function() { jAlert("<b>SAP System Message: </b><br><?php echo $hs;?>", "Message"); });
            </script><?php
        }
    }
}