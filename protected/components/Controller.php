<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 **/
class Controller extends CController
{
    /**
    * @var string the default layout for the controller view. Defaults to '//layouts/column1',
    * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
    **/
    public $layout = '//layouts/column1';
    /**
    * @var array context menu items. This property will be assigned to {@link CMenu::items}.
    **/
    public $menu = array();
    /**
    * @var array the breadcrumbs of the current page. The value of this property will
    * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
    * for more details on how to specify this property.
    **/
    public $breadcrumbs = array();
    
    private static $instance;
	private static $companyinstance;
	private static $userinstance;
	private static $mainuserinstance;
    
    public static function couchDbconnection()
    {
        if (!isset(self::$instance)) 
        {
            self::$instance = new CouchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['thinuidb']);
        }
        return self::$instance;
    }
    
    public static function mainuserDbconnection()
    {
        if (!isset(self::$mainuserinstance)) 
        {
            self::$mainuserinstance = new CouchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['thinuiolddb']);
        }
        return self::$mainuserinstance;
    }
    
	//........companies db...............
	public static function companyDbconnection()
    {
        if (!isset(self::$companyinstance))
        {
            self::$companyinstance = new CouchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['companydb']);
        }
        return self::$companyinstance;
    }
	
	//........user db...............
	
	public static function userDbconnection()
    {
        if (!isset(self::$userinstance))
        {
            self::$userinstance = new CouchClient ('http://'.Yii::app()->params['couchdb']['admin'].Yii::app()->params['couchdb']['host'],Yii::app()->params['couchdb']['userdb']);
        }
        return self::$userinstance;
    }
	
    public static function technicalNames($name,$keys)
    {
        $client = self::couchDbconnection();
        try 
        {
        	$tableHeadersLang = "";
         	if(isset($_SESSION["USER_LANG"]) && strtoupper($_SESSION["USER_LANG"]) == "ES"){
         		$tableHeadersLang = "_ES";
         	}         	
            $doc    = $client->getDoc("table_headers".$tableHeadersLang);
			if(isset($doc->$name))
			{
				$values = $doc->$name;
				$key = get_object_vars($values);
				
				if(!empty($key))
					return $key[$keys];
				else
					return $keys;
			}
			else
			{
				$model = new TableheadersForm;
				
				$formvars['bapiName'] = 'DDIF_FIELDINFO_GET';
				$formvars['bapi_tech_name'] = $name;
				$model->Create_tableheader($formvars, false);
				
				$values = $doc->$name;
				$key = get_object_vars($values);
				
				if(!empty($key))
					return $key[$keys];
				else
					return $keys;
			}
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }
    
    public static function dateValue($t_headers, $keys, $values)
    {
		if($keys == 'AUDAT' || $keys=='CLEAR_DATE' || $keys == 'DATAB' || $keys == 'DATBI' || $keys == 'WADAT' || $keys == 'LEDAT' || $keys == 'FKDAT' || $keys == 'V_FKDAT' || $keys == 'DOC_DATE' || $keys == 'REQ_DATE' || $keys == 'VALID_FROM' || $keys == 'VALID_TO' || $keys == 'GI_DATE' || $keys == 'CREATION_DATE' || $keys == 'ERDAT' || $keys == 'LDDAT' || $keys == 'TDDAT' || $keys == 'LFDAT' || $keys == 'KODAT' || $keys == 'AEDAT' || $keys == 'FKDIV' || $keys == 'CMFRE' || $keys == 'CMNGV' || $keys == 'BLDAT' || $keys == 'WADAT_IST' || $keys == 'PODAT' || $keys == 'PREQ_DATE' || $keys == 'DELIV_DATE' || $keys == 'REL_DATE' || $keys == 'LAST_RESUB' || $keys == 'CREATED_ON' || $keys == 'VPER_START' || $keys == 'VPER_END' || $keys == 'APPLIC_BY' || $keys == 'QUOT_DEAD' || $keys == 'BINDG_PER' || $keys == 'WARRANTY' || $keys == 'QUOT_DATE' || $keys == 'EXPL_DATE' || $keys == 'SCHED_RELEASE_DATE' || $keys == 'ACTUAL_RELEASE_DATE' || $keys == 'FINISH_DATE' || $keys == 'START_DATE' || $keys == 'PRODUCTION_FINISH_DATE' || $keys == 'PRODUCTION_START_DATE' || $keys == 'ACTUAL_START_DATE' || $keys == 'ACTUAL_FINISH_DATE' || $keys == 'ENTER_DATE' || $keys== 'PSTNG_DATE'||$keys=='UDATE' || $keys=='')
		{
			$year = substr($values, 0, 4);
			$mm   = substr($values, 4, 2);
			$dd   = substr($values, 6, 2);
			$date = $mm."/".$dd."/".$year;
			return $date;
		}
		else
			return false;
    }
    
    public static function numberFormat($t_headers, $keys, $values)
    {
		if($keys == 'NETWR' || $keys == 'EXCHG_RATE' || $keys == 'NET_PRICE' || $keys == 'NET_VALUE' || $keys == 'EXCHG_RATE_V' || $keys == 'NET_VAL_HD' || $keys == 'RFMNG' || $keys == 'RFWRT' || $keys == 'RFMNG_FLO' || $keys == 'RFMNG_FLT' || $keys == 'ABGES' || $keys == 'C_AMT_BAPI' || $keys == 'CASH_DISC1' || $keys == 'CASH_DISC2' || $keys == 'EXCH_RATE' || $keys == 'TARGET_VAL' || $keys == 'EXCH_RATE_CM' || $keys == 'PRICE' || $keys=='LC_AMOUNT'  || $keys=='AMOUNT_LC' || $keys=='AMT_DOCCUR' || $keys=='LC_TAX' || $keys=='TX_DOC_CUR' || $keys=='DSC_AMT_LC' || $keys=='DSC_AMT_DC' || $keys=='AMOUNT' || $keys=='NET_AMOUNT' || $keys=='DISC_BASE' || $keys=='DOWNPAY_AMOUNT' || $keys=='OUT_AGR_TA' || $keys=='COST_DOC_C' || $keys=='SUBTOT_PP1' || $keys=='SUBTOT_PP2' || $keys=='SUBTOT_PP3' || $keys=='SUBTOT_PP4' || $keys=='SUBTOT_PP5' || $keys=='SUBTOT_PP6' || $keys=='CREDPRICIT' || $keys=='TAX_AMOUNT' || $keys=='GROSS_VAL' || $keys=='J_SC_CAPITAL' || $keys=='BILLTAX_FC' || $keys=='LABST' || $keys=='SPEME' || $keys=='UMLME' || $keys=='CMPRE' || $keys=='CMKUA' || $keys=='BILLTAX_LC' || $keys=='LC_COL_CHG' || $keys=='COLL_CHARG' || $keys=='DISCT_RATE' || $keys=='COND_VALUE' )
		{
		if(preg_match('/-/',$values))
			return number_format($values, 2).'-';
		else	
			return number_format($values, 2);
		}elseif($keys == 'BRGEW' || $keys == 'VOLUM' || $keys == 'REQ_QTY' || $keys == 'DLV_QTY' || $keys == 'STZKL' || $keys == 'QUANTITY' || $keys == 'TARGET_QUANTITY' || $keys == 'ORDERED' || $keys == 'SCRAP' || $keys == 'CONFIRMED_QUANTITY')
			return round($values, 0);
		elseif($keys == 'UNRESTR_STOCK')
			return round($values, 4);
		elseif($keys == 'MATERIAL' || $keys == 'MATNR')
		{
			if(is_numeric($values))
				return ltrim($values, "0");
			else
				return $values;
		}
		elseif($keys == 'BATCH')
            return $values;
		elseif($values!=0)
			return ltrim($values, "0");
    }
    
    public static function dateValueFormat($headers, $listarray)
    {
        foreach($listarray as $number_keys => $array_values)
        {
            if(is_array($array_values))
            {
                foreach($array_values as $key => $val)
                {
                    $date = self::dateValue($headers, $key, $val);
                    if($date != false)
                        $listarray[$number_keys][$key] = $date;
                }
            }
            else
            {
                $date = self::dateValue($headers, $number_keys, $array_values);
                if($date != false)
                    $listarray[$number_keys] = $date;
            }
        }
        return $listarray;
    }
	
	public static function technical_names($name)
    {  
        $client = Controller::couchDbconnection();
        try 
        {
        	$tableHeadersLang = "";
         	if(isset($_SESSION["USER_LANG"]) && strtoupper($_SESSION["USER_LANG"]) == "ES"){
         		$tableHeadersLang = "_ES";
         	}         	            
            $doc    = $client->getDoc("table_headers".$tableHeadersLang);            
            $values = $doc->$name;
            $key    = json_encode($values);
            return $json_obj = json_decode($key,true);
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }
    
	public static function Bapiname($label)
    {
		$client = self::couchDbconnection();
		if (!Yii::app()->user->getState("bv"))
			$bapi="";
		else	
		{
        $bapi=Yii::app()->user->getState("bv");
		$bapi=($bapi!='v1'?'-'.$bapi:'');
		}
		$doc    = $client->getDoc('bapis'.$bapi);
		return $doc->$label;
	}                       
	
	public static function Bapinamemulity($label,$type)
    {
		$client = self::couchDbconnection();
       $bapi=Yii::app()->user->getState("bv");
		$bapi=($bapi!='v1'?'-'.$bapi:'');
		$doc    = $client->getDoc('bapis'.$bapi);
		return $doc->$label->$type;
	}
    
	public static function getdata($contents)
    {
        $DOM = new DOMDocument;
        $DOM->loadHTML($contents);

        $items = $DOM->getElementsByTagName('tr');

        function tdrows($elements)
        {
            $str = array();
            foreach ($elements as $element)
            {
                $str[] = $element->nodeValue;
            }
            return $str;
        }
        
        foreach ($items as $node)
            $rows[] = tdrows($node->childNodes);
        return $rows;
    }
	
	public static function customize_label($lable)
    {
		global $url;
		$ul  = explode('/',$_SERVER['REQUEST_URI']);
		$url = $ul[2];
		$_SESSION['current_url'] = $url;
        $ids    = str_replace(' ', '_',$lable);
        $label  = str_replace('table', '',$lable);
        
        $userid = Yii::app()->user->getState("user_id");
        $client = self::userDbconnection();
        $doc    = $client->getDoc($userid);
        
        if(isset($doc->customize->$url))
        {
            $sd = json_encode($doc->customize->$url);
            $gs = json_decode($sd,true);
            if(isset($gs[$ids]['lable']))
                return $gs[$ids]['lable'];
            else
                echo $label;
        }
        else
            echo $label;
    }
	
    public static function customize_label_welcome($lable)
    {
        $welcome = 'welcome';
        $ids     = str_replace(' ', '_',$lable);
        $label   = str_replace('table', '',$lable);
        
        $userid = Yii::app()->user->getState("user_id");
		$client = self::userDbconnection();
        $doc    = $client->getDoc($userid);
        if(isset($doc->customize->$welcome))
        {
            $sd = json_encode($doc->customize->$welcome);
            $gs = json_decode($sd,true);
            if(isset($gs[$ids]['lable']))
                return $gs[$ids]['lable'];
            else
                echo $label;
        }
        else
            echo $label;
    }
	
	public static function sentMail($body, $email)
	{
		$subject = "User Details";
		//use 'company' view from views/mail
		$mail = new YiiMailer('company', array('message' => $body, 'name' => CHtml::encode(Yii::app()->name), 'description' => '<br /><p>Your ThinUI account has been created. You can access your ThinUI account at <a href="http://'.$_SERVER['HTTP_HOST'].'" target="_blank">http://'.$_SERVER['HTTP_HOST'].'</a> with the following credentials. You will be prompted to change your password on your first login.</p>'));
		$mail->render();
		//set properties as usually with PHPMailer'));
		$mail->IsSMTP();
		
		if(self::checkHost())
		{
			$mail->Host       = Yii::app()->params['smtpconfig']['mailhost'];
		}
		else
		{
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = Yii::app()->params['smtpconfig']['securetype'];
			$mail->Host       = Yii::app()->params['smtpconfig']['host'];
			$mail->Port       = Yii::app()->params['smtpconfig']['port'];
			$mail->Username   = Yii::app()->params['smtpconfig']['username'];
			$mail->Password   = Yii::app()->params['smtpconfig']['password'];
		}
		
		$mail->From = Yii::app()->params['adminEmail'];
		$mail->FromName = Yii::app()->params['adminName'];
		$mail->Subject = $subject;
		$mail->AddAddress($email);
		
		//send
		if ($mail->Send()) {
			$mail->ClearAddresses();
			return true;
		} else {
			return $mail->ErrorInfo;
		}
	}
	
	public static function getCountryList()
	{
		$client = self::couchDbconnection();
        $doc    = $client->getDoc("country");
		return $doc->country;
		
		$country = array
			(
				"AF"=>"Afghanistan",
				"AX"=>"Aland Islands",
				"AL"=>"Albania",
				"DZ"=>"Algeria",
				"AS"=>"American Samoa",
				"AD"=>"Andorra",
				"AO"=>"Angola",
				"AI"=>"Anguilla",
				"AQ"=>"Antarctica",
				"AG"=>"Antigua and Barbuda",
				"AR"=>"Argentina",
				"AM"=>"Armenia",
				"AW"=>"Aruba",
				"AU"=>"Australia",
				"AT"=>"Austria",
				"AZ"=>"Azerbaijan",
				"BS"=>"Bahamas",
				"BH"=>"Bahrain",
				"BD"=>"Bangladesh",
				"BB"=>"Barbados",
				"BY"=>"Belarus",
				"BE"=>"Belgium",
				"BZ"=>"Belize",
				"BJ"=>"Benin",
				"BM"=>"Bermuda",
				"BT"=>"Bhutan",
				"BO"=>"Bolivia, Plurinational State of",
				"BQ"=>"Bonaire, Sint Eustatius and Saba",
				"BA"=>"Bosnia and Herzegovina",
				"BW"=>"Botswana",
				"BV"=>"Bouvet Island",
				"BR"=>"Brazil",
				"IO"=>"British Indian Ocean Territory",
				"BN"=>"Brunei Darussalam",
				"BG"=>"Bulgaria",
				"BF"=>"Burkina Faso",
				"BI"=>"Burundi",
				"KH"=>"Cambodia",
				"CM"=>"Cameroon",
				"CA"=>"Canada",
				"CV"=>"Cape Verde",
				"KY"=>"Cayman Islands",
				"CF"=>"Central African Republic",
				"TD"=>"Chad",
				"CL"=>"Chile",
				"CN"=>"China",
				"CX"=>"Christmas Island",
				"CC"=>"Cocos (Keeling) Islands",
				"CO"=>"Colombia",
				"KM"=>"Comoros",
				"CG"=>"Congo",
				"CD"=>"Congo, the Democratic Republic of the",
				"CK"=>"Cook Islands",
				"CR"=>"Costa Rica",
				"CI"=>"Cote d'Ivoire",
				"HR"=>"Croatia",
				"CU"=>"Cuba",
				"CW"=>"Curacao",
				"CY"=>"Cyprus",
				"CZ"=>"Czech Republic",
				"DK"=>"Denmark",
				"DJ"=>"Djibouti",
				"DM"=>"Dominica",
				"DO"=>"Dominican Republic",
				"EC"=>"Ecuador",
				"EG"=>"Egypt",
				"SV"=>"El Salvador",
				"GQ"=>"Equatorial Guinea",
				"ER"=>"Eritrea",
				"EE"=>"Estonia",
				"ET"=>"Ethiopia",
				"FK"=>"Falkland Islands (Malvinas)",
				"FO"=>"Faroe Islands",
				"FJ"=>"Fiji",
				"FI"=>"Finland",
				"FR"=>"France",
				"GF"=>"French Guiana",
				"PF"=>"French Polynesia",
				"TF"=>"French Southern Territories",
				"GA"=>"Gabon",
				"GM"=>"Gambia",
				"GE"=>"Georgia",
				"DE"=>"Germany",
				"GH"=>"Ghana",
				"GI"=>"Gibraltar",
				"GR"=>"Greece",
				"GL"=>"Greenland",
				"GD"=>"Grenada",
				"GP"=>"Guadeloupe",
				"GU"=>"Guam",
				"GT"=>"Guatemala",
				"GG"=>"Guernsey",
				"GN"=>"Guinea",
				"GW"=>"Guinea-Bissau",
				"GY"=>"Guyana",
				"HT"=>"Haiti",
				"HM"=>"Heard Island and McDonald Islands",
				"VA"=>"Holy See (Vatican City State)",
				"HN"=>"Honduras",
				"HK"=>"Hong Kong",
				"HU"=>"Hungary",
				"IS"=>"Iceland",
				"IN"=>"India",
				"ID"=>"Indonesia",
				"IR"=>"Iran, Islamic Republic of",
				"IQ"=>"Iraq",
				"IE"=>"Ireland",
				"IM"=>"Isle of Man",
				"IL"=>"Israel",
				"IT"=>"Italy",
				"JM"=>"Jamaica",
				"JP"=>"Japan",
				"JE"=>"Jersey",
				"JO"=>"Jordan",
				"KZ"=>"Kazakhstan",
				"KE"=>"Kenya",
				"KI"=>"Kiribati",
				"KP"=>"Korea, Democratic People's Republic of",
				"KR"=>"Korea, Republic of",
				"KW"=>"Kuwait",
				"KG"=>"Kyrgyzstan",
				"LA"=>"Lao People's Democratic Republic",
				"LV"=>"Latvia",
				"LB"=>"Lebanon",
				"LS"=>"Lesotho",
				"LR"=>"Liberia",
				"LY"=>"Libya",
				"LI"=>"Liechtenstein",
				"LT"=>"Lithuania",
				"LU"=>"Luxembourg",
				"MO"=>"Macao",
				"MK"=>"Macedonia, the former Yugoslav Republic of",
				"MG"=>"Madagascar",
				"MW"=>"Malawi",
				"MY"=>"Malaysia",
				"MV"=>"Maldives",
				"ML"=>"Mali",
				"MT"=>"Malta",
				"MH"=>"Marshall Islands",
				"MQ"=>"Martinique",
				"MR"=>"Mauritania",
				"MU"=>"Mauritius",
				"YT"=>"Mayotte",
				"MX"=>"Mexico",
				"FM"=>"Micronesia, Federated States of",
				"MD"=>"Moldova, Republic of",
				"MC"=>"Monaco",
				"MN"=>"Mongolia",
				"ME"=>"Montenegro",
				"MS"=>"Montserrat",
				"MA"=>"Morocco",
				"MZ"=>"Mozambique",
				"MM"=>"Myanmar",
				"NA"=>"Namibia",
				"NR"=>"Nauru",
				"NP"=>"Nepal",
				"NL"=>"Netherlands",
				"NC"=>"New Caledonia",
				"NZ"=>"New Zealand",
				"NI"=>"Nicaragua",
				"NE"=>"Niger",
				"NG"=>"Nigeria",
				"NU"=>"Niue",
				"NF"=>"Norfolk Island",
				"MP"=>"Northern Mariana Islands",
				"NO"=>"Norway",
				"OM"=>"Oman",
				"PK"=>"Pakistan",
				"PW"=>"Palau",
				"PS"=>"Palestinian Territory, Occupied",
				"PA"=>"Panama",
				"PG"=>"Papua New Guinea",
				"PY"=>"Paraguay",
				"PE"=>"Peru",
				"PH"=>"Philippines",
				"PN"=>"Pitcairn",
				"PL"=>"Poland",
				"PT"=>"Portugal",
				"PR"=>"Puerto Rico",
				"QA"=>"Qatar",
				"RE"=>"Reunion",
				"RO"=>"Romania",
				"RU"=>"Russian Federation",
				"RW"=>"Rwanda",
				"BL"=>"Saint Barthelemy",
				"SH"=>"Saint Helena, Ascension and Tristan da Cunha",
				"KN"=>"Saint Kitts and Nevis",
				"LC"=>"Saint Lucia",
				"MF"=>"Saint Martin (French part)",
				"PM"=>"Saint Pierre and Miquelon",
				"VC"=>"Saint Vincent and the Grenadines",
				"WS"=>"Samoa",
				"SM"=>"San Marino",
				"ST"=>"Sao Tome and Principe",
				"SA"=>"Saudi Arabia",
				"SN"=>"Senegal",
				"RS"=>"Serbia",
				"SC"=>"Seychelles",
				"SL"=>"Sierra Leone",
				"SG"=>"Singapore",
				"SX"=>"Sint Maarten (Dutch part)",
				"SK"=>"Slovakia",
				"SI"=>"Slovenia",
				"SB"=>"Solomon Islands",
				"SO"=>"Somalia",
				"ZA"=>"South Africa",
				"GS"=>"South Georgia and the South Sandwich Islands",
				"SS"=>"South Sudan",
				"ES"=>"Spain",
				"LK"=>"Sri Lanka",
				"SD"=>"Sudan",
				"SR"=>"Suriname",
				"SJ"=>"Svalbard and Jan Mayen",
				"SZ"=>"Swaziland",
				"SE"=>"Sweden",
				"CH"=>"Switzerland",
				"SY"=>"Syrian Arab Republic",
				"TW"=>"Taiwan, Province of China",
				"TJ"=>"Tajikistan",
				"TZ"=>"Tanzania, United Republic of",
				"TH"=>"Thailand",
				"TL"=>"Timor-Leste",
				"TG"=>"Togo",
				"TK"=>"Tokelau",
				"TO"=>"Tonga",
				"TT"=>"Trinidad and Tobago",
				"TN"=>"Tunisia",
				"TR"=>"Turkey",
				"TM"=>"Turkmenistan",
				"TC"=>"Turks and Caicos Islands",
				"TV"=>"Tuvalu",
				"UG"=>"Uganda",
				"UA"=>"Ukraine",
				"AE"=>"United Arab Emirates",
				"GB"=>"United Kingdom",
				"US"=>"United States",
				"UM"=>"United States Minor Outlying Islands",
				"UY"=>"Uruguay",
				"UZ"=>"Uzbekistan",
				"VU"=>"Vanuatu",
				"VE"=>"Venezuela, Bolivarian Republic of",
				"VN"=>"Viet Nam",
				"VG"=>"Virgin Islands, British",
				"VI"=>"Virgin Islands, U.S.",
				"WF"=>"Wallis and Futuna",
				"EH"=>"Western Sahara",
				"YE"=>"Yemen",
				"ZM"=>"Zambia",
				"ZW"=>"Zimbabwe"
			);
		return $country;
	}
	
	public static function getTimezoneList()
	{
		$timezone = array
			(
				'EST'=>'EST',
				'CST'=>'CST',
				'PST'=>'PST',
				'MST'=>'MST'
			);
		return $timezone;
	}
	
	public static function getStateList($country = '')
	{
		$client = self::couchDbconnection();
		$doc    = $client->getDoc("state");
		
		if($country == '')
		{
			$state_list = array
			(
				'AL'=>"Alabama",  
				'AK'=>"Alaska",  
				'AZ'=>"Arizona",  
				'AR'=>"Arkansas",  
				'CA'=>"California",  
				'CO'=>"Colorado",  
				'CT'=>"Connecticut",  
				'DE'=>"Delaware",  
				'DC'=>"District Of Columbia",  
				'FL'=>"Florida",  
				'GA'=>"Georgia",  
				'HI'=>"Hawaii",  
				'ID'=>"Idaho",  
				'IL'=>"Illinois",  
				'IN'=>"Indiana",  
				'IA'=>"Iowa",  
				'KS'=>"Kansas",  
				'KY'=>"Kentucky",  
				'LA'=>"Louisiana",  
				'ME'=>"Maine",  
				'MD'=>"Maryland",  
				'MA'=>"Massachusetts",  
				'MI'=>"Michigan",  
				'MN'=>"Minnesota",  
				'MS'=>"Mississippi",  
				'MO'=>"Missouri",  
				'MT'=>"Montana",
				'NE'=>"Nebraska",
				'NV'=>"Nevada",
				'NH'=>"New Hampshire",
				'NJ'=>"New Jersey",
				'NM'=>"New Mexico",
				'NY'=>"New York",
				'NC'=>"North Carolina",
				'ND'=>"North Dakota",
				'OH'=>"Ohio",  
				'OK'=>"Oklahoma",  
				'OR'=>"Oregon",  
				'PA'=>"Pennsylvania",  
				'RI'=>"Rhode Island",  
				'SC'=>"South Carolina",  
				'SD'=>"South Dakota",
				'TN'=>"Tennessee",  
				'TX'=>"Texas",  
				'UT'=>"Utah",  
				'VT'=>"Vermont",  
				'VA'=>"Virginia",  
				'WA'=>"Washington",  
				'WV'=>"West Virginia",  
				'WI'=>"Wisconsin",  
				'WY'=>"Wyoming"
			);
		}
		else
			$state_list = $doc->$country;
		
		return $state_list;
	}
	
	public static function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		
		$company = self::companyDbconnection();
		$docs	 = $company->getallDocs();
		$arr = array();
		foreach($docs->rows as $key => $val)
			$arr[] = $val->id;
		
		if(in_array($randomString, $arr))
			self::generateRandomString();
		else
			return $randomString;
	}
	
	public static function availableSystems()
	{
		$companyid = Yii::app()->user->getState("company_id");
		$user_host = Yii::app()->user->getState("user_host");
		$client = self::companyDbconnection();
		$doc = $client->getDoc($companyid);
		
		if($user_host)
		{
			$user_id 	= Yii::app()->user->getState("user_id");
			$user 		= self::userDbconnection();
			$hostdoc 	= $user->getDoc($user_id);
		}
		else
			$hostdoc = $doc;
		
		if(isset($hostdoc->host_position))
		{
			$center_position	= json_encode($hostdoc->host_position);
			$center_positions	= json_decode($center_position, true);
		}
		else
		{
			$host	= json_encode($hostdoc->host_id);
			$hosts	= json_decode($host, true);
			
			foreach($hosts as $keys => $values)
				$bi_rep = $keys;
			
			$bi_resop	= explode("_", $bi_rep);
			$cd			= $bi_resop[1];
			
			for($i = 1; $i <= $cd; $i++)
				$center_positions[] = 'host_' . $i;
		}
		
		$host 	= json_encode($hostdoc->host_id);
		$hosts	= json_decode($host, true);
		$count	= count($hosts);
		if(isset($hosts['none']))
			unset($hosts['none']);
		
		$systems['host'] = $hosts;
		$systems['reports'] = $hostdoc->reports;
		
		return $systems;
	}
	
	public static function availableReports()
	{
		$reports['sales']['customer_fact_sheet']					= 'Customer Fact Sheet';
		$reports['sales']['list_of_billing_documents']				= 'List of Billing Documents';
		$reports['sales']['list_of_sales_orders']					= 'List of Sales Orders';
		$reports['sales']['sales_analysis_by_product_or_material']	= 'Sales Analysis by Product or Material';
		$reports['sales']['monthly_sales_dashboard']				= 'Monthly Sales Dashboard';
		$reports['sales']['sales_dashboard']						= 'Sales Dashboard';
		$reports['sales']['sales_organization_analysis']			= 'Sales Organization Analysis';
		$reports['sales']['sales_volume_analysis']					= 'Sales Volume Analysis';
		$reports['sales']['sales_order_analysis']					= 'Sales Order Entry Analysis';
		
		$reports['purchasing']['vendor_fact_sheet']		= 'Vendor Fact Sheet';
		$reports['purchasing']['vendor_analysis']		= 'Vendor Analysis';
		$reports['purchasing']['procurement_dashboard']	= 'Procurement Dashboard';
		$reports['production']['stock_overview']		= 'Stock Overview';
		
		$reports['finance']['gl_statement']						= 'GL Statement';
		$reports['finance']['financial_statement']				= 'Financial Statement';
		$reports['finance']['financial_dashboard']				= 'Financial Dashboard';
		$reports['finance']['controlling_dashboard']			= 'Controlling Dashboard';
		$reports['finance']['ap_open_items']					= 'AP Open Items';
		$reports['finance']['profitability_analysis_dashboard']	= 'Profitability Analysis Dashboard';
		
		return $reports;
	}
	
	public static function htmlXspecialchars($string, $ent=ENT_COMPAT, $charset='ISO-8859-1')
	{
		return htmlspecialchars($string, $ent, $charset);
	}

	public static function htmlXentities($string, $ent=ENT_COMPAT, $charset='ISO-8859-1')
	{
		return htmlentities($string, $ent, $charset);
	}

	public static function htmlX_entity_decode($string, $ent=ENT_COMPAT, $charset='ISO-8859-1')
	{
		return html_entity_decode($string, $ent, $charset);
	}

	public static function checkHost()
	{
		$host_addrs = array("45.79.208.254", "23.239.19.15");
		if($_SERVER['HTTP_HOST'] == "thinui.emergys.net" || in_array($_SERVER['HTTP_HOST'], $host_addrs))
			return true;
		else
			return false;
	}
	public static function encryptIt( $value,$code ) {
    	
    	//$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $code ), $value, MCRYPT_MODE_CBC, md5( md5( $code ) ) ) );
	    //GEZG 07/05/2018
		//Changing mcrypt mehtod due that it is deprecated for PHP7     
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = md5($code);
	    $iv = substr(md5(md5($code)),0,16);
	    $qEncoded      = base64_encode(openssl_encrypt($value, $encrypt_method, $key, 0, $iv));
	    return( $qEncoded );
	}

	public static function decryptIt( $value,$code ) {
    	//GEZG 07/05/2018
		//Changing mcrypt mehtod due that it is deprecated for PHP7
	    //$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $code ), base64_decode( $value ), MCRYPT_MODE_CBC, md5( md5( $code ) ) ), "\0");
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = md5($code);
	    $iv = substr(md5(md5($code)),0,16);
		$qDecoded      = rtrim(openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv), "\0");
	    return( $qDecoded );
	}
}
