<?php
global $rfc,$fce;
$customer = "";
$sname    = "";
$scity    = "";
$searched = "";
$search_term = "";
$i = 0;

if(isset($_REQUEST['searched'])) $searched=$_REQUEST['searched'];
if(isset($_REQUEST['customer'])) $a['customer']=$customer=$_REQUEST['customer'];
if(isset($_REQUEST['sname'])) $a["NAME"]=$sname=strtoupper($_REQUEST['sname']);
if(isset($_REQUEST['scity'])) $a["CITY"]=$scity=strtoupper($_REQUEST['scity']);
if(isset($_REQUEST['postal_code'])) $a["POSTL_COD1"]=$postal_code=strtoupper($_REQUEST['postal_code']);
if(isset($_REQUEST['search_term'])) $a["search_term"]=$ssearch_term=strtoupper($_REQUEST['search_term']);

$rte=0;
$em_ex = array("KUNNR"=>trim($customer),"MCOD1"=>trim($sname),"MCOD3"=>trim($scity),"PSTLZ"=>trim($postal_code),"SORTL"=>trim($ssearch_term));

//GEZG 06/22/2018
//Changing SAPRFC methods
$options = ['rtrim'=>true];
$importTableHELPVALUES = array();

$EXPLICIT_SHLP = array("SHLPNAME"=>"DEBIA","SHLPTYPE"=>"SH","TITLE"=>"","REPTEXT"=>"");
$create_from   = $_REQUEST['method'];
$BUS           = $_REQUEST['obj'];

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
                array_push($importTableHELPVALUES, $SELECTION_FOR_HELPVALUES);
            }
        }
        else
        {
            $SELECTION_FOR_HELPVALUES=array("SELECT_FLD"=>$keys,"SIGN"=>"I","OPTION"=>"CP","LOW"=>$vals."*","HIGH"=>"");
            array_push($importTableHELPVALUES, $SELECTION_FOR_HELPVALUES);
        }
    }
}
          
$res = $fce->invoke(["OBJTYPE"=>"BUS2032",
                "OBJNAME"=>"",
                "METHOD"=>"CREATEFROMDAT2",
                "PARAMETER"=>"ORDERPARTNERS",
                "FIELD"=>"PARTN_NUMB",
                "EXPLICIT_SHLP"=>$EXPLICIT_SHLP,
                "SELECTION_FOR_HELPVALUES"=>$importTableHELPVALUES],$options);          

$rowsagt1 = count($res["DESCRIPTION_FOR_HELPVALUES"]);
//................................................................................
$tech_name=array("KUNNR"=>"CUSTOMER","MCOD1"=>"NAME","MCOD3"=>"CITY","PSTLZ"=>"POSTL_COD1","SORTL"=>"SORT1");
for ($j=1;$j<=$rowsagt1;$j++)
{
    $SalesOrdert1 = $res["DESCRIPTION_FOR_HELPVALUES"][$j];
    $offset[]=$SalesOrdert1['OFFSET'];
    $leng[]=$SalesOrdert1['LENG'];
    $text[]=$tech_name[$SalesOrdert1['FIELDNAME']];    
}
//.............................................................................................................
$rowsagt = count($res["HELPVALUES"]);
$sit=2;
$sde=0;
for ($j=1;$j<=$rowsagt;$j++)
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
    if(trim($we['POSTL_COD1'])!=NULL&&trim($we['POSTL_COD1'])!='0'&&$sde<20)
    {
        $sdw[$j]=$we;
        $sde++;
    }
    $form1=NULL;
    $form=NULL;
}
if($_REQUEST['customer']!=NULL)
{
    $sit=8;
    if(trim($sdw[1]['CITY'])==NULL&&trim($sdw[1]['POSTL_COD1'])==NULL)
    {
    }
}
//................................................................................
$SalesOrder=$sdw;
$_SESSION['table_today']=$SalesOrder;
$rowsag1=count($SalesOrder);

$customer_number=10;
if($rowsag1<10)
{
    $customer_number=$rowsag1;
}
?>
<body style="overflow:hidden;">
<link class="theme-css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/utopia-white.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/utopia-responsive.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/alerts.css" type="text/css" rel="stylesheet">
<?php
$cs = Yii::app()->getClientScript(); $cs->registerCoreScript('jquery'); Yii::app()->clientScript->registerCoreScript('jquery.ui'); // Include Jquery for this page 

foreach($SalesOrder as $hs=>$ej)
{
    $enb=0;
    if($ej["POSTL_COD1"]!=0)
    {
        if(strpos($ej["POSTL_COD1"],'-') !== false)
        {
            $zips=explode("-",$ej["POSTL_COD1"]);
            if(strpos($sstate,trim($zips[0])) !== false)
            {
                $enb=1;
            }
        }
        else
        {
            if(strpos($sstate,trim($ej["POSTL_COD1"])) !== false)
            {
                $enb=1;
            }
        }
    }
    $maps[]=$ej;
}

if($maps==NULL)
{
    echo _NOTEFILTER;
}

foreach($maps as $keys)
{
    $city=$keys['CITY'];
    $city=str_replace('"', "",$city);
    $city=str_replace("'", "",$city);
    $namem=$keys['NAME'];
    $idm=$keys['CUSTOMER'];
    $pstal=$keys['POSTL_COD1'];
    
    //$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$city.'+'.$street.'&sensor=false');
    //$output= json_decode($geocode);
    //$lat = $output->results[0]->geometry->location->lat;
    //$long = $output->results[0]->geometry->location->lng;
    
    if($city!="")
    {
        $dirt[]=$city.",".$pstal;
        $map_n[]=$namem;
        $map_c[]=$city;
        $map_id[]=$idm;
        $map_post[]=$pstal;
    }
}

?>
<div class="container-fluid" id="maping">
    <div class="row-fluid">
        <div class="utopia-widget-content span12">
            <div id="utopia-google-map-2" class="utopia-map"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script>
    $(document).ready(function(e) {
        <?php  
        $rte=0;
        foreach($dirt as $ket=>$values)
        { 
            $rte=$rte+1;
            ?>setMarkerObject("<?php echo htmlspecialchars($values);?>","<?php echo htmlspecialchars($map_n[$ket]);?>","<?php echo htmlspecialchars($map_id[$ket]);?>","<?php echo htmlspecialchars($map_c[$ket]);?>","<?php echo htmlspecialchars($map_post[$ket]);?>","<?php echo htmlspecialchars($rte);?>");<?php
        }
    ?>});

function setMarkerObject(toAddress, name, ids, city, postal, poi) 
{
    var back_to="search_customers";
    var info="";
    info   +="<div style='padding:5px;'>";
    info   +="<div>"+ids+"</div>";
    info   +="<div>"+city+"</div>";
    info   +="<div>"+postal+"</div></div>";
    var searNearBy =  '<?=Controller::customize_label(_SEARCHNEARBY);?>';
    var directions =  '<?=Controller::customize_label(_DIRECTIONS);?>';
    info   +="<div style='margin-top:30px;color:#00AFF0;border-top:1px solid #ededed'><span onClick='ter(\""+toAddress+"\")' style='cursor:pointer;'>"+directions+"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onclick='serach_by(\""+toAddress+"\")' style='cursor:pointer;'>"+searNearBy+"</span></div></div>"
    
    if(poi==1)
    {
        $('#utopia-google-map-2').gmap3({
            action: 'addMarker',
            address: toAddress,
            map:{
                minZoom: 2,
                zoom:<?php echo $sit;?>
            },
            marker: {
                options: {
                    draggable: false
                },
                events: {
                    click: function (marker, event) {
                        $('#utopia-google-map-2').gmap3({
                            action: 'addinfowindow',
                            anchor: marker,
                            options: {
                                content: "<div style='height:160px;width:250px;color:#000;' class='appl'><div id='"+ids+"' class='map_con'><div style='color:#00A8F5' onMouseOver='show_cus_map(\""+ids+"\",\""+back_to+"\")'>"+name+"</div></div>"+info
                            }
                        });
                    }
                }
            },
            infowindow: {
                open: false,
                options: {
                    content: name
                }
            }
        });
    }
    else
    {
        $('#utopia-google-map-2').gmap3({
            action: 'addMarker',
            address: toAddress,
            marker: {
                options: {
                    draggable: false
                },
                events: {
                    click: function (marker, event) {
                        $('#utopia-google-map-2').gmap3({
                            action: 'addinfowindow',
                            anchor: marker,
                            options: {
                                content: "<div style='height:160px;width:250px;color:#000;' class='appl'><div id='"+ids+"' class='map_con'><div style='color:#00A8F5' onMouseOver='show_cus_map(\""+ids+"\",\""+back_to+"\")'>"+name+"</div></div>"+info
                            }
                        });
                    }
                }
            },
            infowindow: {
                open: false,
                options: {
                    content: name
                }
            }
        });
    }
}
</script>

<!-- javascript placed at the end of the document so the pages load faster -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-365466-5']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<script language="JavaScript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/smart_table-<?=isset($_SESSION["USER_LANG"])?strtolower($_SESSION["USER_LANG"]):"en"?>.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/alerts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tags/utopia-tagedit.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tags/autoGrowInput.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cleditor.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/formToWizard.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/maskedinput.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/header.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAeTbCOpuPIKT4i9n8iUQsBHNUt_MWjtog&sensor=false"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/gmap3.js"></script>

<script type="text/javascript">
function map()
{
    $('#types').val('maps');
    $('#validation').submit();
}
</script>
</body>
</html>