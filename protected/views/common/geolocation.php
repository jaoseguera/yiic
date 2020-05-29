<?php
function getIP(){
    // here we check if the user is coming through a proxy
    // NOTE: Does not always work as proxies are not required
    // to provide this information
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        //reg ex pattern
        $pattern = "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/";
        // now we need to check for a valid format
        if(preg_match($pattern, $_SERVER["HTTP_X_FORWARDED_FOR"])){
            //valid format so grab it
            $userIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else{
            //invalid (proxy provided some bogus value
            //so just use REMOTE_ADDR and hope for the best
            $userIP = $_SERVER["REMOTE_ADDR"];
        }
    }
    //not coming through a proxy (or the proxy
    //didnt provide the original IP)
    else{
        //grab the IP
        $userIP = $_SERVER["REMOTE_ADDR"];
    }
    //return the IP address
    return $userIP;
}
$ipaddr = getIP();
$ipaddr = "71.77.29.217";
// $iplocation = file_get_contents('http://api.ip2location.com/?ip='.$ipaddr.'&key=demo&package=WS10&format=json');
// $meta_tags = json_decode($iplocation, true);
// print_r($meta_tags);
$meta_tags = get_meta_tags('http://www.geobytes.com/IPLocator.htm?GetLocation&template=php3.txt&IPAddress='.$ipaddr) or die('Error getting meta tags');
// if(isset($meta_tags['longitude']) && $meta_tags['longitude'] != "-")
if($meta_tags['longitude'] != "Limit Exceeded")
{
	$lng=$meta_tags['longitude'];
	$lat=$meta_tags['latitude'];
	//echo $meta_tags['fips104'].',';
	//echo $meta_tags['region'].',';
	$zip_codes = file_get_contents('http://api.geonames.org/findNearbyPostalCodesJSON?lat='.$lat.'&lng='.$lng.'&radius=30&maxRows=10&username=vamshi');
	$nearby_zipcodes=json_decode($zip_codes, true);
	$nearby_zip = "";
	foreach($nearby_zipcodes as $keys=>$value)
	{
		foreach($value as $zips)
		{
			$nearby_zip .= $zips['postalCode'].",";
		}
	}
	echo substr($nearby_zip, 0, -1);
}
/*echo 'US,';
echo 'NC,';
$zip_codes = file_get_contents('http://api.geonames.org/findNearbyPostalCodesJSON?lat=35.8003&lng=-78.6412&radius=30&maxRows=100&username=vamshi');
$nearby_zipcodes=json_decode($zip_codes,true);
foreach($nearby_zipcodes as $keys=>$value)
{
    foreach($value as $zips)
    {
        echo $nearby_zip=$zips['postalCode'].",";
    }
	
}*/
?>