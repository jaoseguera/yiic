<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Post_incoming_paymentForm extends CFormModel
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
        if(isset($_REQUEST['HEADER_TXT']))
        {
            $header_txt = strtoupper($_REQUEST['HEADER_TXT']);
            $comp_code  = strtoupper($_REQUEST['COMP_CODE']);
            $ref_doc_no = strtoupper($_REQUEST['REF_DOC_NO']);
            $gl_account = strtoupper($_REQUEST['GL_ACCOUNT']);
            $item_text  = strtoupper($_REQUEST['ITEM_TEXT']);
            $customer   = strtoupper($_REQUEST['CUSTOMER']);
            $amt_doccur = strtoupper($_REQUEST['AMT_DOCCUR']);
			
			$cusLenth	= count($customer);
			if($cusLenth < 10) { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }

            $doc = explode("/",$_REQUEST['DOC_DATE']);
            $pst = explode("/",$_REQUEST['PSTNG_DATE']);

            $doc_date   = $doc[2].$doc[0].$doc[1];
            $pstng_date = $pst[2].$pst[0].$pst[1];
            //GEZG 06/22/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];            
            $importTableAccount = array();   
            $importTableAccountReceivable = array();    
            $importTableCurrency = array();        
            $DOCUMENTHEADER = array("USERNAME"=>strtoupper($_SESSION['userName']),"HEADER_TXT"=>$header_txt,"COMP_CODE"=>$comp_code,"DOC_DATE"=>$doc_date,"PSTNG_DATE"=>$pstng_date,"DOC_TYPE"=>"DZ","REF_DOC_NO"=>$ref_doc_no);            
           
            $ACCOUNTGL = array("ITEMNO_ACC"=>"0000000001","GL_ACCOUNT"=>$gl_account,"ITEM_TEXT"=>$item_text,"ACCT_TYPE"=>"S","DOC_TYPE"=>"DZ");
            array_push($importTableAccount, $ACCOUNTGL);
                                            

            $ACCOUNTRECEIVABLE = array("ITEMNO_ACC"=>"0000000002","CUSTOMER"=>$customer);            
            array_push($importTableAccountReceivable, $ACCOUNTRECEIVABLE);

            
            
            $CURRENCYAMOUNT1 = array("ITEMNO_ACC"=>"0000000001","CURRENCY"=>"USD","AMT_DOCCUR"=>floatval($amt_doccur));
            $CURRENCYAMOUNT2 = array("ITEMNO_ACC"=>"0000000002","CURRENCY"=>"USD","AMT_DOCCUR"=>floatval(0-$amt_doccur));
            array_push($importTableCurrency, $CURRENCYAMOUNT1);
            array_push($importTableCurrency, $CURRENCYAMOUNT2);            

            $res = $fce->invoke(['DOCUMENTHEADER'=> $DOCUMENTHEADER,
                                "ACCOUNTGL"=>$importTableAccount,
                                "ACCOUNTRECEIVABLE"=>$importTableAccountReceivable,
                                "CURRENCYAMOUNT"=>$importTableCurrency],$options);
            
            $SalesOrder = $res['RETURN'];
            $dt = 0; $hs = "";
            foreach($SalesOrder as $keys)
            {
                $hs.=$keys['MESSAGE']."<br>";
                $ty=$keys['TYPE'];
                if($ty!='S') { $dt=1; }
            }
            if($dt==0)
            { 
                ?><script> $(document).ready(function() { $('#validation input:text').val(""); }); </script><?php       
            }
            ?><script> $(document).ready(function() { jAlert("<b>SAP System Message: </b><br><?php echo $hs;?>", "Message"); }); </script><?php
        }
    }
   
}