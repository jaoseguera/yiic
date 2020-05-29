<?php
/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class Search_vendorsForm extends CFormModel
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
		$vender = $_REQUEST['vendor'];
		$sname  = $_REQUEST['sname'];
		$scity  = $_REQUEST['scity'];
		$postal_code = $_REQUEST['postal_code'];
		$search_term = $_REQUEST['search_term'];

		if(isset($_REQUEST['searched'])) 
			$searched = $_REQUEST['searched'];
		else 
			$searched = "";

		$em_ex = array("LIFNR" => $vender, "MCOD1" => $sname, "MCOD3" => $scity, "PSTLZ" => $postal_code, "SORTL" => $search_term);		
		$EXPLICIT_SHLP = array("SHLPNAME" => "KREDA", "SHLPTYPE" => "SH", "TITLE" => "", "REPTEXT" => "");
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$importTableHelpValues = array();
						
		foreach($em_ex as $keys => $values) 
		{
			$vals = strtoupper($values);
			if($vals != "") 
			{
				$SELECTION_FOR_HELPVALUES = array("SELECT_FLD" => $keys, "SIGN" => "I", "OPTION" => "CP", "LOW" => $vals . "*", "HIGH" => "");
				array_push($importTableHelpValues, $SELECTION_FOR_HELPVALUES);
			}
		}
		$res = $fce->invoke(["OBJTYPE"=> "BUS2093", // BUS2012
						"OBJNAME"=> "",
						"METHOD"=> "GETDETAIL1", // CREATEFROMDATA
						"PARAMETER"=> "RESERVATIONITEMS", // POHEADER
						"FIELD"=> "VENDOR",
						"EXPLICIT_SHLP"=> $EXPLICIT_SHLP,
						"SELECTION_FOR_HELPVALUES"=>$importTableHelpValues],$options);

		$rowsagt1 = count($res["DESCRIPTION_FOR_HELPVALUES"]);
		for($j = 0; $j < $rowsagt1; $j++) 
		{
			$SalesOrdert1 = $res["DESCRIPTION_FOR_HELPVALUES"][$j];
			$offset[] = $SalesOrdert1['OFFSET'];
			$leng[] = $SalesOrdert1['LENG'];
			$text[] = $SalesOrdert1['FIELDNAME'];
		}
		$rowsagt = count($res["HELPVALUES"]);			
		if($rowsagt == 0) { ?><input type="hidden" name="rowsagt" id="rowsagt" value="<?php echo $rowsagt; ?>" /><?php }
		if($rowsagt != 0) { ?><input type="hidden" name="rowsagt" id="rowsagt" value="<?php echo $rowsagt; ?>" /><?php }
		if($rowsagt != 0) 
		{
			for($j = 0; $j < $rowsagt; $j++) 
			{
				$SalesOrdert = $res["HELPVALUES"][$j];
				foreach($SalesOrdert as $form) 
				{
					$metrial = substr($form, 9, 40);
					$t_len = 0;	
					for($i = 0; $i < $rowsagt1; $i++) 
					{
						$form1[$i] = substr($form, $offset[$i], $leng[$i]);
						$we[$text[$i]] = $form1[$i];
					}		
					$metrial = str_replace(" ", "", $metrial);
				}
				$sdw[$j] = $we;
				$form1 = NULL;
				$form = NULL;
			}
			
			$SalesOrder = $sdw;
			$ids=1;	
			$table_labels = "LIFNR,SORTL,PSTLZ,MCOD3,MCOD1";
			$labels       = "LIFNR,SORTL,PSTLZ,MCOD3,MCOD1";
			$tableField1 = $screen.'_Search_vendors';
			if(isset($doc->customize->$tableField1->Table_order))
			{			
				$labels=$doc->customize->$tableField1->Table_order;
			}			
			$exps1 = explode(',',$table_labels);
			$exp   = explode(',',$labels);
			if(count($exp)<6)
			{
				for($j=count($exp)-1;$j<count($exps1);$j++)
				{
						$exp[$j]=$exps1[$j];
				}
			}
			foreach($SalesOrder as $keys=>$value)
			{
				$sdq[$ids] = array($exp[0]=>$value[$exp[0]],$exp[1]=>$value[$exp[1]],$exp[2]=>$value[$exp[2]],$exp[3]=>$value[$exp[3]],$exp[4]=>$value[$exp[4]]);			
				$ids++;
			}
			//................................................................................
			$SalesOrderr = $sdq;
		
			$_SESSION['table_today_search_vendors'] = $SalesOrderr;
			//var_dump( $_SESSION['table_today_search_vendors']);
			//exit;
			$rowsag1 = count($SalesOrder);
		}
	}
	public function _actionColumncount($doc, $screen)
    {
			$table_inf  = "LIFNR,SORTL,PSTLZ,MCOD3,MCOD1,";
            $labels_inf        = "LIFNR,SORTL,PSTLZ,MCOD3,MCOD1,";
		$tableField1  = $screen.'_Search_vendors';
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