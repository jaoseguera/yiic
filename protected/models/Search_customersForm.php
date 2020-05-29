<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_customersForm extends CFormModel
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
		$table_name = $_REQUEST['table_name'];
		$from       = $_REQUEST['from'];
		///////////////////////////////////////
		if(strtolower($from) == 'submit')
		{
			$customer = $_REQUEST['customer'];
			$cusLenth = count($customer);
			if($cusLenth < 10 && $customer != "") { $customer = str_pad((int) $customer, 10, 0, STR_PAD_LEFT); } else { $customer = substr($customer, -10); }

			if(isset($_REQUEST['searched'])) $searched=$_REQUEST['searched'];
			if(isset($_REQUEST['customer'])) $a['customer']=$customer=$_REQUEST['customer'];
			if(isset($_REQUEST['sname'])) $a["NAME"]=$sname=strtoupper($_REQUEST['sname']);
			if(isset($_REQUEST['scity'])) $a["CITY"]=$scity=strtoupper($_REQUEST['scity']);
			if(isset($_REQUEST['postal_code_list']) && $_REQUEST['postal_code_list'] != "")
				$a["POSTL_COD1"] = $postal_code = trim($_REQUEST['postal_code_list']);
			else if(isset($_REQUEST['postal_code']))
				$a["POSTL_COD1"] = $postal_code = trim($_REQUEST['postal_code']);
			if(isset($_REQUEST['search_term'])) $a["search_term"]=$ssearch_term=strtoupper($_REQUEST['search_term']);

			$em_ex = array("KUNNR"=>trim($customer),"MCOD1"=>trim($sname),"MCOD3"=>trim($scity),"PSTLZ"=>trim($postal_code),"SORTL"=>trim($ssearch_term));			

			$EXPLICIT_SHLP = array("SHLPNAME"=>"DEBIA","SHLPTYPE"=>"SH","TITLE"=>"","REPTEXT"=>"");
			$create_from = $_REQUEST['method'];
			$BUS = $_REQUEST['obj'];


			$importTable = array();
			
			foreach($em_ex as $keys=>$values)
			{
				$vals = strtoupper($values);
				if($vals != "")
				{
					if($keys == "PSTLZ" && is_array($vals))
					{
						$vals = explode(",", $vals);
						$vals = array_unique($vals);
						foreach($vals as $vk => $vv)
						{
							$SELECTION_FOR_HELPVALUES=array("SELECT_FLD"=>$keys,"SIGN"=>"I","OPTION"=>"CP","LOW"=>$vv,"HIGH"=>"");
							array_push($importTable, $SELECTION_FOR_HELPVALUES);
						}
					}
					elseif($keys == "KUNNR")
					{
						$SELECTION_FOR_HELPVALUES=array("SELECT_FLD"=>$keys,"SIGN"=>"I","OPTION"=>"CP","LOW"=>$vals,"HIGH"=>"");
						array_push($importTable, $SELECTION_FOR_HELPVALUES);
					}
					else
					{
						$SELECTION_FOR_HELPVALUES=array("SELECT_FLD"=>$keys,"SIGN"=>"I","OPTION"=>"CP","LOW"=>$vals."*","HIGH"=>"");
						array_push($importTable, $SELECTION_FOR_HELPVALUES);
					}
				}
			}			
			$options = ['rtrim'=>true];
			$res = $fce->invoke([
					"OBJTYPE"=>"BUS2032",
					"OBJNAME"=>"",
					"METHOD"=>"CREATEFROMDAT2",
					"PARAMETER"=>"ORDERPARTNERS",
					"FIELD"=>"PARTN_NUMB",
					"EXPLICIT_SHLP"=>$EXPLICIT_SHLP,
					"SELECTION_FOR_HELPVALUES"=>$importTable
				],$options);

			$rowsagt1 = count($res["DESCRIPTION_FOR_HELPVALUES"]);
			//................................................................................
			$tech_name=array("KUNNR"=>"CUSTOMER","MCOD1"=>"NAME","MCOD3"=>"CITY","PSTLZ"=>"POSTL_COD1","SORTL"=>"SORT1");
			for ($j=0;$j<$rowsagt1;$j++)
			{
				$SalesOrdert1 = $res["DESCRIPTION_FOR_HELPVALUES"][$j];
				$offset[]=$SalesOrdert1['OFFSET'];
				$leng[]=$SalesOrdert1['LENG'];
				$text[]=$tech_name[$SalesOrdert1['FIELDNAME']];
			}			
			//.............................................................................................................
			$rowsagt = count($res["HELPVALUES"]);
			if($rowsagt==0) { ?><input type="hidden" name="rowsagt" id="rowsagt" value="<?php echo $rowsagt; ?>" /><?php }
			if($rowsagt!=0) { ?><input type="hidden" name="rowsagt" id="rowsagt" value="<?php echo $rowsagt; ?>" /><?php }

			for ($j=0;$j<$rowsagt;$j++)
			{
				$SalesOrdert = $res["HELPVALUES"][$j];
				foreach($SalesOrdert as $form)
				{ 
					$metrial= substr($form,9,40);
					$t_len=0;
					for($i=0;$i<$rowsagt1;$i++)
					{
						$form1[$i]= substr($form,$offset[$i],$leng[$i]);
						$we[$text[$i]]=$form1[$i];
					}
					$metrial=str_replace(" ","",$metrial);
				}
				$sdw[$j]=$we;
				$form1=NULL;
				$form=NULL;
			}
			$ids = 1;
			//////////////////////////////////////////////////////////////////////////////////			
			$table_labels = "CUSTOMER,NAME,CITY,POSTL_COD1,SORT1";
			$labels       = "CUSTOMER,NAME,CITY,POSTL_COD1,SORT1";	
			$tableField1  = $screen.'_Search_customers';
			if(isset($doc->customize->$tableField1->Table_order))
			{			
				$labels=$doc->customize->$tableField1->Table_order;
			}			
			$exps1 = explode(',',$table_labels);
			$exp=explode(',',$labels);
			if(count($exp)<6)
			{
				for($j=count($exp)-1;$j<count($exps1);$j++)
				{
					$exp[$j]=$exps1[$j];
				}
			}
			foreach($sdw as $keys=>$value)
			{
				$sdq[$ids]=array($exp[0]=>$value[$exp[0]],$exp[1]=>$value[$exp[1]],$exp[2]=>$value[$exp[2]],$exp[3]=>$value[$exp[3]],$exp[4]=>$value[$exp[4]]);			
				$ids++;
			}
			//................................................................................			
			$SalesOrder = $sdq;
			$_SESSION['table_today_seach_customer'] = $SalesOrder;
			$rowsag1 = count($SalesOrder);
		}
    }
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "CUSTOMER,NAME,CITY,POSTL_COD1,SORT1,";
            $labels_inf        = "CUSTOMER,NAME,CITY,POSTL_COD1,SORT1,";
		$tableField1  = $screen.'_Customer_open_item';
		if(isset($doc->customize->$tableField1->Table_order))
		{			
			$labels_inf = $doc->customize->$tableField1->Table_order;
		}			
		$exps1 = explode(',',$table_inf);
		$exp = explode(',', $labels_inf);
		if(count($exp)>0)
			$c_c=count($exp)-1;
		else
			$c_c=10;
		$_SESSION['table_todays_count']=$c_c; 	
		return $c_c;	
	}
}