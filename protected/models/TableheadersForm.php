<?php

/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class TableheadersForm extends CFormModel
{
    public $bapi_tech_name, $bapiName;

    /**
    * Declares the validation rules.
    * The rules state that username and password are required,
    * and password needs to be authenticated.
    **/
    
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

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'bapi_tech_name'=>'Bapi Technical Name',
		);
	}
	
	public function Create_tableheader($formvars, $displayflag = true)
	{
		global $fce;
		$bapiName = $formvars['bapiName'];
		$techical_name = $formvars['bapi_tech_name'];
		if($techical_name == null){$techical_name = "";}

		$b = new Bapi();
		$b->bapiCall($bapiName);		
		//GEZG 06/22/2018
		//Changing SAPRFC methods
		$options = ['rtrim'=>true];
		$res = $fce->invoke(["TABNAME"=> $techical_name,
							"FIELDNAME"=> "",
							"LANGU"=> "EN",
							"LFIELDNAME"=> "",
							"ALL_TYPES"=> "",
							"GROUP_NAMES"=> "",
							"UCLEN"=> "00"],$options);
		
		$result = $res['DFIES_TAB'];
		$disp = "";
		$key = array();
		
		foreach($result as $keys=>$val)
		{
			/*
			if($val['SCRTEXT_M'] == "")
				$title = $val['FIELDNAME'];
			elseif(in_array($val['SCRTEXT_M'], $key))
				$title = $val['SCRTEXT_M']." - ".$val['FIELDNAME'];
			else
				$title = $val['SCRTEXT_M'];
			
			if($val['SCRTEXT_M'] == "")
			{
				if(in_array($val['FIELDTEXT'], $key))
					$title = $val['FIELDTEXT']." - ".$val['FIELDNAME'];
				else
					$title = $val['FIELDTEXT'];
			}
			else
			{
				if(in_array($val['SCRTEXT_M'], $key))
				{
					// $title = $val['FIELDTEXT'];
					if(in_array($val['FIELDTEXT'], $key))
						$title = $val['FIELDTEXT']." - ".$val['FIELDNAME'];
					else
						$title = $val['FIELDTEXT'];
				}
				else
					$title = $val['SCRTEXT_M'];
			}
			*/
			
			if(in_array($val['SCRTEXT_M'], $key) || $val['SCRTEXT_M'] == "")
			{
				if($val['SCRTEXT_M'] != "")
					$title = $val['SCRTEXT_M']." - ".$val['FIELDNAME'];
				else
				{
					if(in_array($val['FIELDTEXT'], $key))
						$title = $val['FIELDTEXT']." - ".$val['FIELDNAME'];
					else
						$title = $val['FIELDTEXT'];
				}
			}
			else
				$title = $val['SCRTEXT_M'];
			
			$disp .= $val['FIELDNAME']." - ".$title."<br />";
			$key[$val['FIELDNAME']] = $title;
		}
		
		$client = Controller::couchDbconnection();
		try {
			if($displayflag)
				echo "success, ".$disp;
			
			$doc= $client->getDoc("table_headers");
			$doc->$techical_name=$key;
			$client->storeDoc($doc);
		} 
		catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}