<?php
$cols  	  = $_REQUEST['column'];
$sor  	  = $_REQUEST['sor'];
$table    = $_REQUEST['table'];
$tec_name = $_REQUEST['tech'];
$table_id = $_REQUEST['table_id'];
$t_rows	  = $_REQUEST['t_rows'];
//$t_rows	  = $_SESSION['t_rows'];

if($sor == 'no-sort')
{
    $table_id = $_REQUEST['column'];
}

$ses    = $_SESSION[$table];
$count  = count($ses);
$rcount = $t_rows;

if($t_rows>$count)
{
    $rcount=$count;
}
if($t_rows=='null' || $t_rows=='undefined')
{
    $rcount=$count;
}

$i=1;
$j=1;
if($sor!='no-sort')
{
    foreach($ses as $values)
    {
        $sd0[$i]=$values[$cols];
        $i++;
    }
    if($sor=='sorting_asc')
    {
        asort($sd0);
    }
    else
    {
        arsort($sd0);
    }
}
// $t_headers = $model->technical_names($tec_name);

$t_headers = Controller::technicalNames($tec_name,null);

$r=1;

if($sor!='no-sort')
{
    $j = 1; 
    foreach($sd0 as $keys=>$val)
    {
        $rows[$j]=$ses[$keys];
        $j++;
    }
    $_SESSION[$table]=$rows;
}
else
{
    $rows=$ses;
}
// var_dump($rows);
if($rows[1]=='')
{
    if($t_rows<=10)
    {
        $rcount = 11; 
    }
    else
    {
        if($t_rows>10) 
        { 
            $rcount = $t_rows+1; 
        }
    }
}
for($i=1;$i<=$rcount;$i++)
{
    if($tec_name=="ZBAPI_SLS_LIST_ORDERS_OUT" || $tec_name=="/KYK/S_POWL_BILLDUE")
    {
        foreach($rows[$i] as $keys=>$vales)
        {
            $art23[$i][]='['.$keys.']'.$vales;
        }
        $array23[$i]=implode($art23[$i]," ");
    }

    $SalesOrders = $rows[$i];
    $t_id = $table_id;
	$jon = urlencode(json_encode($SalesOrders));
	$table_name = isset($_REQUEST['table_name']) ? $_REQUEST['table_name'] : $_REQUEST['table'];
	$this->renderPartial('/bapi_tablerender/tablebody', array('SalesOrders' => $SalesOrders, 'split_rows' => $split_rows, 't_headers' => $t_headers, 't_id' => $t_id, 'tec_name' => $tec_name, 'table_name' => $table_name, 'array23' => $array23, 'i' => $i));
    $r++;
}?>
<script>
    var $disptablerow = $("#<?php echo $table_id; ?> tbody tr");
    //displaytrimzero($disptablerow);
</script>