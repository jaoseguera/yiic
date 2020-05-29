<?php
global $rfc,$fce;
$I_VBELN = "";
$sysnr = Yii::app()->user->getState('SYSNR');
$sysid = Yii::app()->user->getState('SYSID');
$clien = Yii::app()->user->getState('CLIENT');

if($sysnr.'/'.$sysid.'/'.$clien == '10/EC4/210') { $I_VBELN="90000008"; }
if(isset($_REQUEST['BILLINGDOC']))
{
    $I_VBELN     = $_REQUEST['BILLINGDOC'];
	$cusLenth=count($I_VBELN);
    if($cusLenth < 10) { $I_VBELN  = str_pad((int) $I_VBELN , 10, 0, STR_PAD_LEFT); } else { $I_VBELN  = substr($I_VBELN , -10); }
	//GEZG 06/22/2018
    //Changing SAPRFC methods
    $options = ['rtrim'=>true];
    $res = $fce->invoke(['BILLINGDOCUMENT'=>$I_VBELN],$options);

	$SalesOrder=$res['BILLINGDOCUMENTDETAIL'];
    //$SalesOrder  = $res_table-> getTable('BILLINGDOCUMENTDETAIL');	
    //$SalesOrder2 = $res_table-> getTable('RETURN');
    
    $_SESSION['table_today'] = $SalesOrder;
    $rowsag1 = count($SalesOrder);
}
$customize = $model?>
<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <form id="validation" action="javascript:submit_form('validation')" class="form-horizontal">
                <div class="form-horizontal">
                    <div class="span12 utopia-form-freeSpace">
                        <fieldset class="span4">
                            <div class="control-group">

                                <input type="hidden" name='page' value="bapi">
                                <input type="hidden" name="url" value="display_billing_list"/>
                                <input type="hidden" name="key" value="display_billing_list"/>
                                <input type="hidden" name="jum" value="BAPIVBRKOUT"/>
                                <label class="control-label cutz" for="input01" alt='Sale Order Number' style="min-width:160px;"><?php echo Controller::customize_label('Billing document number');?><span> *</span>:&nbsp;</label>
                                <div class="controls">
                                    <input style='min-width:170px;' id="BILLINGDOC" class="input-fluid validate[required]" type="text" name='BILLINGDOC' value="<?php echo $I_VBELN;?>" ><span class='minw' onclick="lookup('Billing Document Number', 'BILLINGDOC', 'billing_document')" >&nbsp;</span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="span1">
                            <div class="control-group">
								<input class="btn btn-primary back_b iphone_bill_list " style='margin-left:25px;' type="submit" name="submit" value="<?php echo _SUBMIT ?>">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php

$hs=$SalesOrder;

if(isset($_REQUEST['BILLINGDOC']))
{ 
    ?>
     
    <section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div style="position:absolute; float:right;right:100px;margin-top:0px;"><a style="cursor: pointer;" onclick="strpdf()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png"/>Invoice</a></div>
        <div class="row-fluid">
            <div class="utopia-widget-content" style="margin-top:10px;z-index:100;"><?php 
            if($hs==NULL) { echo "No match found"; exit; }
            
            $client = Controller::couchDbconnection();
            $doc    = $client->getDoc('table_headers');            
            //print_r($doc->BAPIVBRKOUT);
            //$t_headers = $doc->$_REQUEST['jum'];
            //GEZG 06/26/2018
            //Changing way for getting labels
            $t_headers = $doc->BAPIVBRKOUT;
            $hsr       = json_encode($t_headers);
            $t_headers = json_decode($hsr,true);
            
            foreach($hs as $sd=>$hd)
            {   
				if($sd == "TAX_VALUE" || $sd == "NET_VALUE")
					$hd = number_format($hd, 2);
				elseif($sd == "BILLINGDOC")
					$hd = ltrim($hd, 0);
                ?><div class="span5 edit_sale" style="padding:0px;margin:0px;">
                    <label class="control-label1 cutz" for="input01" alt='<?php echo $t_headers[$sd]." ".$sd;?>'><?php echo Controller::customize_label($t_headers[$sd]);?>:</label>
                    <input class="input-fluid read" type="text" name='scountry' value="<?php echo $hd;?>">
                </div><?php 
            }
            ?><div class="span6" ></div>
            </div>
        </div>
    </section><?php
}

?><script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript">
if($.cookie("css")) {
    $('link[href*="utopia-white.css"]').attr("href",$.cookie("css"));
    $('link[href*="utopia-dark.css"]').attr("href",$.cookie("css"));
}
$(document).ready(function() 
{
    $('#loading').hide(); 
    $("body").css("opacity","1"); 
    $(".theme-changer a").on('click', function() {
        $('link[href*="utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
    
    $(".read").attr('readonly','readonly');
    $('#edit').click(function () {
        $(".input-fluid").removeAttr('readonly');
        $('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit">Save</button>');
    });
    
    $('#clse').click(function() { $('#digs').hide('slow'); });
    $('#ok_it').click(function() { 
        $('.radius').css({ color:'#000' })    
        $('.radiu').css({color:'#000'})
        $('#digs').hide('slow');
    });
    
    $('#edit').click(function () 
    {    
        $(".input-fluid").removeAttr('readonly');
        $('#edit').replaceWith('<button class="btn btn-primary spanbt span2" type="submit">Save</button>');
    });
    jQuery("#validation").validationEngine();
});

/*
function tipup(type,order,title,ids)
{
    $('#digs').show();
    $('#title').html(title)
    $('#dialog').html('loding...');
    var datavar = 'bapiName=ZBAPI_HELPVALUES_GET_SEARCHELP&type='+type+'&order='+order+'&ids='+ids;
    $.ajax({
        type:'POST',
        url: 'common/lookup',
        data: datavar, 
        success: function(data) {
            $('#dialog').html(data);
        }
    });
}

function opps(sh,type,para,ids)
{
    var emails=new Array();
    var className=new Array();
    var j=0;
    $(".fut").each(function(){
        emails[j]=$(this).val()
        className[j] = $(this).attr('name');
        j++;
    });
    $('#dialog').html('Loading...');
    $('#dialog').load('common/help?bapiName=BAPI_HELPVALUES_GET&val='+emails+'&em='+className+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids)
}
function getval(vals,type,met,ids,id)
{
    if(type=='MATERIAL') $('#D'+id).val(met);
    
    $('#df'+ids).click(function() { 
        $('.ort').css({ background:'' });
        $('#df'+ids).css({ background:'#f5f5f5' });
    });
    $('#'+id).css({ color:'#fff' });
    $('#'+id).val(vals);
    $('#dialog').dialog("close");
}
*/

function cancels()
{
    $('.cancel').hide();
}

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) {
            str = '0' + str;
        }
        return str;
    }
}
function strpdf()
{
	
$('#loading').show();
	$("body").css("opacity","0.4"); 
	$("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
		type:'POST',
		data:'order_num='+number($('#BILLINGDOC').val())+'&bapi=display_billing_list_doc',
		url:'display_billing_list/stringpdf',
		success:function(data){
			//	alert(data);
			$('#loading').hide();
			$("body").css("opacity","1");
			if($.trim(data)!='')
			{
				jAlert(data,'Message');
			}
			else
			{
				var tb=window.open('common/Pdfurl');
				// setTimeout(function(){ 
					// tb.close(); 
				// },3000);
			}
			//tab.focus();
		}
	});	
}
</script>