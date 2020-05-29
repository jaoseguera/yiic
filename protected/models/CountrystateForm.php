<?php

/**
 * IndexForm class.
 * IndexForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 **/
class CountrystateForm extends CFormModel
{
    public $bapiName;

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
			'bapiName'=>'Bapi Name',
		);
	}
	
	public function Create_tableheader($formvars)
	{
		global $fce;
		$client = Controller::couchDbconnection();
		$bapiName = $formvars['bapiName'];
		
		$b = new Bapi();
		$b->bapiCall($bapiName);
		
		if($bapiName == "MSR20_MD_COUNTRY_GETLIST")
		{
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$res = $fce->invoke(["PI_LANGU"=> "EN"],$options);
			
			$result = $res['POT_COUNTRY'];
			$disp = "";
			$key = array();
			
			foreach($result as $keys=>$val)
			{
				$text = Controller::htmlXentities($val['LANDX']);
				$disp .= $val['LAND1']." - ".$text."<br />";
				$key[$val['LAND1']] = $text;
			}
			asort($key);
			
			try {
				$doc = $client->getDoc("country");
				$doc->country = $key;
				$client->storeDoc($doc);
				echo "success, ".$disp;
			} 
			catch (Exception $e) {
				if ($e->getCode() == 404) {
					$doc = new stdClass();
					$doc->_id = "country";
					$doc->country = $key;
					$client->storeDoc($doc);
					echo "success, ".$disp;
				}
				else
				{
					echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
				}
			}
		}
		elseif($bapiName == "MSR20_MD_REGION_GETLIST")
		{
			//GEZG 06/22/2018
			//Changing SAPRFC methods
			$options = ['rtrim'=>true];
			$res = $fce->invoke(["PI_LANGU" => "EN",
							"PI_LAND1" => ""],$options);
			
			$result = $res['POT_REGION'];
			$disp = "";
			$key = array();
			
			foreach($result as $keys=>$val)
			{
				$text = Controller::htmlXentities($val['BEZEI']);
				$disp .= $val['LAND1']." - ".$val['BLAND']." - ".$text."<br />";
				$key[$val['LAND1']][$val['BLAND']] = $text;
			}
			asort($key);
			
			try {
				$doc = $client->getDoc("state");
				foreach($key as $keys=>$val)
				{
					asort($val);
					$doc->$keys = $val;
				}
				$client->storeDoc($doc);
				echo "success, ".$disp;
			} 
			catch (Exception $e) {
				if ($e->getCode() == 404) {
					$doc = new stdClass();
					$doc->_id = "state";
					foreach($key as $keys=>$val)
					{
						asort($val);
						$doc->$keys = $val;
					}
					$client->storeDoc($doc);
					echo "success, ".$disp;
				}
				else
				{
					echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
				}
			}
		}
	}
}