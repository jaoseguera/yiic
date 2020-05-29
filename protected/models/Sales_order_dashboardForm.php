<?php

/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Sales_order_dashboardForm extends CFormModel
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
            $cuid = $_REQUEST['CUSTOMER_NUMBER'];
            $cusLenth = count($customer);
            if($cusLenth < 10 && $cuid != "") 
            { 
                $cuid = str_pad((int) $cuid, 10, 0, STR_PAD_LEFT);
            } 
            else 
            { 
                $cuid = substr($cuid, -10); 
            }    
            //GEZG 06/21/2018
            //Changing SAPRFC methods
            $options = ['rtrim'=>true];
            $res = $fce->invoke(['CUSTOMER_NUMBER'=>$cuid],$options);        
            $SalesOrderr = $res['SALES_ORDERS'];

            $sd = 1;
            //////////////////////////////////////////////////////////////////////////////////
            $labels_sales = "SD_DOC,ITM_NUMBER,MATERIAL,REQ_QTY,SHORT_TEXT";
            $table_labels = "SD_DOC,ITM_NUMBER,MATERIAL,REQ_QTY,SHORT_TEXT";
            $tableField1   = $screen.'_Sales_order_dashboard';			
            if(isset($doc->customize->$tableField1->Table_order))
            {			
                $labels_sales = $doc->customize->$tableField1->Table_order;
            }			
            $exps1 = explode(',',$table_labels);
            $exp   = explode(',',$labels_sales);

            if(count($exp)<6)
            {
                for($j=count($exp)-1;$j<count($exps1);$j++)
                {
                    $exp[$j]=$exps1[$j];
                }
            }			

            foreach($SalesOrderr as $val_t => $retur)
            {
				if($retur['DOC_TYPE'] == 'TA')
					$retur['DOC_TYPE'] = 'OR';
				if(isset($retur['NET_VAL_HD']))
					unset($retur['NET_VAL_HD']);
                $order_t = array($exp[0]=>$retur[$exp[0]],$exp[1]=>$retur[$exp[1]],$exp[2]=>$retur[$exp[2]],$exp[3]=>$retur[$exp[3]],$exp[4]=>$retur[$exp[4]]);
                unset($retur[$exp[0]],$retur[$exp[1]],$retur[$exp[2]],$retur[$exp[3]],$retur[$exp[4]]);
                $today=$retur;
                $SalesOrder[$sd] = array_merge((array)$order_t, (array)$today);
                $sd++;
            }

            $_SESSION['table_today'] = $SalesOrder;
            $rowsag1 = count($SalesOrder);
            //GEZG 06/21/2018
            //Changing SAPRFC methods
            $fce = $rfc->getFunction('BAPI_DELIVERY_GETLIST');
            $IS_DLV_DATA_CONTROL = array("BYPASSING_BUFFER"=>" ","HEAD_STATUS"=>" ","HEAD_PARTNER"=>" ","ITEM"=>"X","ITEM_STATUS"=>" ","DOC_FLOW"=>" ","FT_DATA"=>" ","HU_DATA"=>" ","SERNO"=>" ");  
            $IT_KUNN2 = array("SIGN"=>"I","OPTION"=>"EQ","CUSTOMER_LOW"=>$cuid);
            $importTable = array();
            array_push($importTable, $IT_KUNN2);     
            $options = ['rtrim'=>true];     
            $res = $fce->invoke(['IS_DLV_DATA_CONTROL'=>$IS_DLV_DATA_CONTROL,
                                 'IT_KUNN2'=>$importTable
                                ],$options);            
            $SalesOrder5     = $res['ET_DELIVERY_HEADER'];
            $SalesOrder_item = $res['ET_DELIVERY_ITEM'];	

            $ss = 1;

            $labels_deliv = "VBELN,ERDAT,WADAT,KUNNR,KUNAG";
            $table_deliv  = "VBELN,ERDAT,WADAT,KUNNR,KUNAG";
            $tableField2   = $screen.'_Sales_order_dashboard_delivery';			
            if(isset($doc->customize->$tableField2->Table_order))
            {			
                    $labels_deliv=$doc->customize->$tableField2->Table_order;
            }			
            $exps2 = explode(',',$table_deliv);
            $exp_dv   = explode(',',$labels_deliv);
            if(count($exp>0))
			$_SESSION['table_deliv_count']=count($exp)-1;
			else
			$_SESSION['table_deliv_count']=11;
            if(count($exp)<11)
            {
				for($j=count($exp)-1;$j<count($exps1);$j++)
				{
					$exp[$j]=$exps1[$j];
				}
            }
            foreach($SalesOrder5 as $val=>$bill)
            {
                $order_b=array($exp_dv[0]=>$bill[$exp_dv[0]],$exp_dv[1]=>$bill[$exp_dv[1]],$exp_dv[2]=>$bill[$exp_dv[2]],$exp_dv[3]=>$bill[$exp_dv[3]],$exp_dv[4]=>$bill[$exp_dv[4]]);
                unset($bill[$exp_dv[0]],$bill[$exp_dv[1]],$bill[$exp_dv[2]],$bill[$exp_dv[3]],$bill[$exp_dv[4]]);
                $billing=$bill;
                $SalesOrder1[$ss] = array_merge((array)$order_b, (array)$billing);
                $ss++;
            }

            $rowsag2 = count($SalesOrder1);
            $_SESSION['table_deliv']=$SalesOrder1;
			// print_r($SalesOrder1);
            $_SESSION['row5']=$rowsag5;

            foreach($SalesOrder_item as $values)
            {
                $as=array('VBELN'=>$values['VBELN'],'POSNR'=>$values['POSNR'],'MATNR'=>$values['MATNR'],'LFIMG'=>$values['LFIMG'],'MEINS'=>$values['MEINS']);
                $un[$values['VBELN']][]=array('VBELN'=>$values['VBELN'],'POSNR'=>$values['POSNR'],'MATNR'=>$values['MATNR'],'LFIMG'=>$values['LFIMG'],'MEINS'=>$values['MEINS'],'WERKS'=>$values['WERKS']);
            }
            $_SESSION['VBE'] = $un;            
        
        
    }
    
   
}