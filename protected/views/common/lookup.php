<?php
//GEZG 06/20/2018 - Alias for SAPRFC library
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

$type        = $_REQUEST['type'];
$parameter   = $_REQUEST['order'];
$ids         = $_REQUEST['ids'];
$create_from = $_REQUEST['method'];
$BUS         = $_REQUEST['obj'];

$lo_value         = $_REQUEST['lo_value'];
$lo_id        = $_REQUEST['lo_id'];

/*GEZG 06/20/2018
Changing SAPRFC methods*/
$options = ['rtrim'=>true];
$res = $fce->invoke(["OBJTYPE"=>$BUS,
                    "OBJNAME"=>"",
                    "METHOD"=>$create_from,
                    "PARAMETER"=> $parameter,
                    "FIELD"=> $type],$options);

$enable = 0;
$sel    = $_REQUEST['sel'];
$findme = '@';
$pos = strpos($sel,$findme);
if($pos!==false)
{
    $ss = explode('@',$sel);
    $field =$ss[0];
    $shlname =$ss[1];
    $enable=1;
}
$rowsag = count($res["SHLP_FOR_HELPVALUES_GET"]);

for ($i=0;$i<$rowsag;$i++)
{
    $Shlrows = $res["SHLP_FOR_HELPVALUES_GET"][$i];
    
    if($enable==1)
    {
        if($shlname == $Shlrows['SHLPNAME'])
            $shltype = $Shlrows['SHLPTYPE'];
    }
    else
    {
        $shltype = $Shlrows['SHLPTYPE'];
    }
}

if($create_from=='SD_DISPLAY')
    $req='required=yes';
else
    $req='';

$rowsag = count($res["DESCRIPTION_FOR_HELPVALUES"]);
$changeDebis = 0;

?><form action="<?php echo Yii::app()->createAbsoluteUrl('common/help'); ?>" method="post" name="JobForm" id='target' onsubmit="return false;">
    <table align="center" border="0"><?php
        if('DEBIS' == $ss[1]) {
            $debisPosition = array('VKORG', 'KUNNR', 'MCOD1', 'MCOD3', 'SORTL');
            $count = count($debisPosition);
            for ($j=0;$j<$count;$j++) {
               for ($k=0;$k<$rowsag;$k++) {
                    $SalesOrder = $res["DESCRIPTION_FOR_HELPVALUES"][$k];
                    if($debisPosition[$j] == $SalesOrder['FIELDNAME'] && $SalesOrder['TABNAME'] == 'M_DEBIS'){
                        $SalesOrder['SCRTEXT_L'] = ($SalesOrder['SCRTEXT_L'] != "") ? $SalesOrder['SCRTEXT_L'] : $SalesOrder['REPTEXT'];
                        $getAccountGroup = "";
                        $required = "";
                        if($debisPosition[$j] == "VKORG"){                            
                            $required = " required ";
                        }
                    ?>
                        <tr>
                            <td><?php echo $SalesOrder['SCRTEXT_L'];?><?=$required!=""?"*":""?>:</td>
                            <td>
                                <input class='fut input-fluid' <?php echo $req; ?> id='<?php echo removeAccents(str_replace(' ','_',$SalesOrder['SCRTEXT_L'])); ?>' type="text" value="<?php echo $textval;?>" name='<?php echo $SalesOrder['FIELDNAME'];?>' <?=$required?> />                               
                                 <?php
                                    if($debisPosition[$j] == "VKORG"){
                                        $changeDebis = 1;
                                        ?>
                                        <input class='fut input-fluid' type="hidden" name="KTOKD" id="KTOKD" value="">
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr><?php 
                        break 1;
                    }
                }
            }
        }else { 
            for ($i = 0;$i <= $rowsag;$i ++) {
                if($enable == 1) {
                    $SalesOrder = $res["DESCRIPTION_FOR_HELPVALUES"][$i];
                    $SalesOrder['SCRTEXT_L'] = ($SalesOrder['SCRTEXT_L'] != "") ? $SalesOrder['SCRTEXT_L'] : $SalesOrder['REPTEXT'];
                    $textval = "";
                    if($lo_value != "" && $lo_id!="" && $SalesOrder['FIELDNAME']==$lo_id){
                        $textval = $lo_value;
                    }
                    $hiddenRow="";
                    if($SalesOrder['FIELDNAME'] == "SPRAS"){                  
                        $textval = "E";
                        if(isset($_SESSION["USER_LANG"])){
                            if(strtoupper($_SESSION["USER_LANG"]) == "ES"){
                                $textval = "S";
                            }
                        }
                        $hiddenRow = "style='display:none'";
                    }
                    if($ss[1] == $SalesOrder['SHLPNAME'] && $SalesOrder['FIELDNAME'] != "BEGRU") {
                        if($ids == "GL_ACCOUNT"):
                            if($SalesOrder['FIELDNAME'] != "SAKNR"):
                                ?><tr <?=$hiddenRow?>><td><?php echo $SalesOrder['SCRTEXT_L'];?>:</td><td><input class='fut input-fluid' <?php echo $req; ?> type="text" id='<?php echo str_replace(' ','_',$SalesOrder['SCRTEXT_L']);?>' value="" name='<?php echo $SalesOrder['FIELDNAME'];?>' /></td></tr><?php
                            endif;
                        else:
                            ?><tr <?=$hiddenRow?>><td><?php echo $SalesOrder['SCRTEXT_L'];?>:</td><td><input class='fut input-fluid' <?php echo $req; ?> id='<?php echo str_replace(' ','_',$SalesOrder['SCRTEXT_L']);?>' type="text" value="<?php echo $textval; ?>" name='<?php echo $SalesOrder['FIELDNAME'];?>' /></td></tr><?php 
                        endif;
                    }
                }
                else
                {
                    $SalesOrder = $res["DESCRIPTION_FOR_HELPVALUES"][$i];
                    $SalesOrder['SCRTEXT_L'] = ($SalesOrder['SCRTEXT_L'] != "") ? $SalesOrder['SCRTEXT_L'] : $SalesOrder['REPTEXT'];
                    $hiddenRow="";
                    if($SalesOrder['FIELDNAME'] == "SPRAS"){                  
                        $textval = "E";
                        if(isset($_SESSION["USER_LANG"])){
                            if(strtoupper($_SESSION["USER_LANG"]) == "ES"){
                                $textval = "S";
                            }
                        }
                        $hiddenRow = "style='display:none'";
                    }
                    if($type == "PLANT" && $SalesOrder['FIELDNAME'] != "CITY1" && $SalesOrder['FIELDNAME'] != "NAME1" && $SalesOrder['FIELDNAME'] != "BEGRU")
                    {
                        ?>
                        <tr <?=$hiddenRow?> ><td><?php echo $SalesOrder['SCRTEXT_L'];?>:</td><td><input type="text" class='fut input-fluid ' <?php echo $req; ?> value="" id='<?php echo str_replace(' ','_',$SalesOrder['SCRTEXT_L']);?>' name='<?php echo $SalesOrder['FIELDNAME'];?>' /></td></tr>
                        <?php
                    }
                    elseif($type != "PLANT" && $SalesOrder['FIELDNAME'] != "BEGRU")
                    {
                        ?>
                        <tr <?=$hiddenRow?> >
                            <td><?php echo $SalesOrder['SCRTEXT_L'];?>:</td>
                            <td><input type="text" value="" class='fut input-fluid' <?php echo $req; ?> id='<?php echo str_replace(' ','_',$SalesOrder['SCRTEXT_L']);?>' name='<?php echo $SalesOrder['FIELDNAME'];?>' /></td>
                            </tr>
                        <?php
                    }
                }
                $shlname = $SalesOrder['SHLPNAME'];
                $FIELDNAME[]="'".$SalesOrder['SCRTEXT_L']."',";
            }
        }
        if($pos!==false)
        {
            $ss=explode('@',$sel);
            $shlname=$ss[1];
        }
        if($changeDebis == 1){
            $shlname = "DEBIK";   
        }
        ?>
        <tr><td colspan="2" align="center">
        <input type="hidden" value="<?php echo $shlname."~".$shltype;?>" id="help_shname"/>
        <input type="button" value="<?php echo _SUBMIT ?>" class="subut" id="help_submit" /></td></tr>
    </table>
</form>
<script>
$(document).ready(function(e) 
{
    $('#help_submit').click(function(e) 
    {
        // $('#ok_it').show();
        // $('#back_it').show();
    })
});

function scrt()
{
    if ($('.rot_t').height() - $('#dialog').height()<$('#dialog').scrollTop())
    {    
        var pre='';
        $('.look_header').each(function(index, element) 
        {
            if($(this).hasClass('show_header'))
            {
                var alts = $(this).attr('alt');
                var qwe  = alts.split('_');
                pre +=qwe[1]+','
            }
        });
        var irows=$('.ort').length;
        if($('#df'+irows+1).length==0)
        {
            var datastr = 'irows='+irows+'&pre='+pre;
            $.ajax({
                type:'POST', 
                url: 'common/helpload',
                data: datastr,
                success: function(response) 
                {
                    if($('#df'+irows+1).length==0)
                    {
                        if(irows==$('.ort').length)
                        {
                            if(response!='END')
                            {
                                var oTable = $('#help').dataTable();
                                oTable.fnDestroy();
                                $('#scr_lod').replaceWith(response);
                                var oTable = $('#help').dataTable({ "bPaginate": false, "bSort": false, "sDom": 'R' });
                            }
                        }
                    }
                }
            });
        }
    }
}

</script>
<?php
//Remove accents
function removeAccents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
  return str_replace($a, $b, $str);
}

?>