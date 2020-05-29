<style>
.table th:nth-child(-n+5), .table td:nth-child(-n+5){

    display:table-cell;
    
    }   
</style>
<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div><?php 
$this->renderPartial('smarttable',array('count'=>$count));
$customize = $model;
?><section id='utopia-wizard-form' class="utopia-widget utopia-form-box" >
    <div class="row-fluid">
        <div class="utopia-widget-content wid_mess">
            <h4 class="filter_note" >
              <?=_NOTEFILTER?>
            </h4>
            <form id="validation_cus" action="" class="form-horizontal" >
                <fieldset class="span12" >
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Customer Number">
                            <?=Controller::customize_label(_CUSTOMERNUMBER);?>:</label>                  
                            <input alt="1" class="input-fluid ner validate[custom[customer]]" type="text" name='customer' id="customer" value="<?php echo $customer; ?>">
                            <!--<span  class='minw'  onclick="tipup('BUS2032','CREATEFROMDAT2','ORDERPARTNERS','PARTN_NUMB','Customer Number','customer','4@DEBIA')" >&nbsp;</span>-->
                            <span  class='minw' onclick="lookup('<?=Controller::customize_label(_CUSTOMERNUMBER);?>', 'customer', 'sold_to_customer')" >&nbsp;</span><input type="hidden" value="table" name="types" id="types">
                            <!-- onchange="number(this.value)" -->
                        </fieldset>
                    </div>
                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <input type="hidden" name="url" value="search_customers"/>
                            <input type="hidden" name="url_nearby" value="search_customers_nearby"/>
                            
                            <input type="hidden" class='tbName_example' value='BAPICUSTOMER_ADDRESSDATA'>
                            <label class="control-label1 cutz" for="date" alt="Name"><?=Controller::customize_label(_NAME);?>:</label>
                            <input alt="3" type="text" class="input-fluid  ner" id="sname" name="sname" value="<?php echo $sname?>">
                        </fieldset>
                    </div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="City"><?=Controller::customize_label(_CITY);?>:</label>
                            <input alt='6' class="input-fluid  ner" type="text" name='scity'  id="scity" value="<?php echo $scity?>">
                        </fieldset>
                    </div>

                    <div class="span3 utopia-form-freeSpace">
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Postal Code"><?= Controller::customize_label(_POSTALCODE);?>:</label>
                            <input alt='7' class="input-fluid" type="text" name='postal_code' value="<?php $postal_code?>" id="scountry">
                            <input type="hidden" name='postal_code_list' id="scountry_list">
                        </fieldset>
                    </div>
                </fieldset>

                <fieldset class="span12" style="padding:0px;margin:0px;">
                    <div class="span3 utopia-form-freeSpace" >
                        <fieldset>
                            <label class="control-label1 cutz" for="input01" alt="Search Term"><?= Controller::customize_label(_SEARCHTERM);?>:</label>
                            <input  alt="2" class="input-fluid ner" type="text" name='search_term' id="search_term" value="<?php echo $search_term?>">
                        </fieldset>
                    </div>
                    <br>
                    <div class="utopia-form-freeSpace mitf span4" style="float:right;min-width:350px; white-space:nowrap;">
                        <input type="hidden" name='searched' value='yes'>
                        <input type="hidden" name='searched_type' value='list' id="ser_ty">
                        <table  class="table_buttons">
                            <tr>
                                <td><button  class="label label-primary btn btn-primary spanbt back_b" type="submit" onclick='return getBapitable("table_today_seach_customer","BAPICUSTOMER_ADDRESSDATA","example","L","show_cus@<?php echo $s_wid;?>","Search_customers","submit")' id='list'>
                                <?=_SUBMIT?></button></td>      
                                <!--<td><button class="btn spanbt back_b" type="submit" onclick='return getBapitable("table_today_seach_customer","BAPICUSTOMER_ADDRESSDATA","example","L","show_cus@<?php // echo $s_wid;?>","Search_customers","submit")' id='list'>List</button></td>
                                <td><button class="btn spanbt back_b" type="button" onClick="nearby_table()" id='n_list'>Nearby List</button></td>
                                <td><button class="btn spanbt back_b" type="button" onClick="map()" id='map_list'>Map</button></td>
                                <td><button class="btn spanbt back_b" type="button" onClick="nearby()" id='n_map_list'>Nearby Map</button></td>
                                <td><button class="btn spanbt reset" type="reset">Reset</button></td>-->
                                <!--  onClick="resetform(this);" -->
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </form>
            <div style="padding-bottom:1px;">&nbsp;</div>
        </div>
    </div>
</section>

<div id="maps" class="edge"></div><?php                 
/*
if($searched!="")
{
    if($rowsagt!=0)
    {   
    */          
        ?><!--<div class="container-fluid" id="tables">-->
<div class="" id="tables">          
          <div class="row-fluid">
            <!-- Body start -->
            <div>
                <div class="row-fluid">
                    <div class="span12 edge"><?php
                        $this->renderPartial('tabletop');
                        ?><div id='table_today_seach_customer'></div><?php 
                        /*if($rowsag1>10)
                        { */
                                ?><div class='testr table_today_seach_customer' style="display:none;" onClick='getBapitable("table_today_seach_customer","BAPICUSTOMER_ADDRESSDATA","example","S","show_cus@<?php echo $s_wid;?>","Search_customers","show_more")'><?=_SHOWMORE?></div>
                                <div id='example_num' style="display:none;">10</div><?php 
                        // } 
                        ?></div>
                    </div>
                </div><!-- Body end -->
            </div><!-- Maincontent end -->
        </div><!-- end of container -->

        <div id='export_table' style="display:none"></div>
        <div id='export_table_view_pdf' style="display:none"></div>
        <!--<div id='example_table' style="display:none"><?php
        /*$technical = $model;
        $t_headers = Controller::technical_names('BAPICUSTOMER_ADDRESSDATA');
        foreach($SalesOrder as $number_keys => $array_values)
        {
            foreach($array_values as $header_values => $row_values)
            {
                $header_values1 = $t_headers[$header_values];
                unset ($array_values[$header_values]);
                $array_values[$header_values1] = $row_values;
            }
            $SalesOrder[$number_keys] = $array_values;
        }
        echo json_encode($SalesOrder);*/
        ?></div>-->
        <script>
        $(document).ready(function(e) 
        {
            $('.search_int').keyup(function () 
            {
                sear($(this).attr('alt'),$(this).val(),$(this).attr('name'))
            })
            data_table('example');
            $('#example').each(function()
            {
                $(this).dragtable(
                {
                    placeholder: 'dragtable-col-placeholder test3',
                    items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                    appendTarget: $(this).parent(),
                    tableId: 'example',
                    tableSess: 'table_today',
                    scroll: true
                });
            })

            $('.head_fix').css({display:'none'});
            $(document).scroll(function()
            {
                $('.head_fix').css({display:'none'});
                $('#examplefix').css({display:'block'});
            });
            var wids=$('.table').width();
            $('.head_icons').css({ width:wids+'px' });
        });
        </script><?php          
    /*
    }
    else
    {
        echo "Match not Found";
    }           
}   
*/      
?><!-- javascript placed at the end of the document so the pages load faster -->

<script type="text/javascript">
$(document).ready(function() {
    jQuery("#validation_cus").validationEngine();
    $(".head_icons").hide();
    $(".testr").text('');

    $('#list').click(function() {
        $('#ser_ty').val('list');
        $('.back_b').removeClass('btn-primary');
        $('#list').addClass('btn-primary');
        $('#near_list').attr('class', 'btn spanbt back_b');
    });

    $('#n_list').click(function() {
        $('#near_list').addClass('btn-primary'); 
        $('#list').attr('class', 'btn spanbt back_b');
    });         
});
</script>

<script type="text/javascript">
function map()
{           
    $('#maps').show();
    $('#tables').hide();

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)");

    $('.back_b').removeClass('btn-primary');
    $('#map_list').addClass('btn-primary');
    $('#ser_ty').val('map_list');
    $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });
    var data = $('#validation_cus').serialize();            
    var data = data.replace("&url=search_customers","");
    var sid  = $('.wid_mess').width();
    // $('#maps').html('<iframe src="../lib/controller.php?url=customer_map&types=maps&'+data+'" frameBorder="0" id="iframe_map"></iframe>');   
    $('#maps').html('<iframe src="<?php echo Yii::app()->createAbsoluteUrl('search_customers/customermap'); ?>?url=search_customers&types=maps&'+data+'" frameBorder="0" id="iframe_map"></iframe>');
    $('#maps').css({height:'600px'}) 
    $('#iframe_map').css({width:sid+'px'});
    $('#tables').hide();
    $('#loading').hide();
    $("body").css("opacity","1"); 
}

function nearbymap(st)
{
    $(document).find('.head_fix').each(function(index, element) { $(this).remove(); });
    var sid=$('.wid_mess').width();
    
    if(st != "")
    {
        $('#maps').html('<iframe src="<?php echo Yii::app()->createAbsoluteUrl('search_customers/customermap'); ?>?url=search_customers&types=maps&postal_code='+st+'"  frameBorder="0" id="iframe_map"></iframe>');
        $('#maps').css({height:'600px'});
        $('#maps').show();
        $('#tables').hide();
        $('#iframe_map').css({width:sid+'px'});         
    }
    else
    {   var addressNotFound =  '<?=Controller::customize_label(_ADDRESNOTFOUND);?>';
        $('#maps').html("<h4 style='color:#828282;'>"+addressNotFound+"</h4>");
        $('#maps').show();
        $('#tables').hide();
    }
}

$(document).ready(function(e) 
{
    $('#list').click(function() { });
    $(window).resize(function()
    {
        var sid=$('.wid_mess').width();
        $('#iframe_map').css({width:(sid-10)+'px'})
    });
    if($(document).width()<600)
    {
        var sdw=$.cookie('forms_dis');
        if(sdw == 1)
        {
            $('.utopia-form-box').hide();
        }
        $('.back_b').click(function()
        {
            $('#form_b').show();
            $('.edge').show();
            $('.edge2').show();
            $.cookie('forms_dis',1);
            var sdw=$.cookie('forms_dis');
            $('.utopia-form-box').hide();
        })
        $('#form_b').click(function()
        {
            $('.utopia-form-box').show();
            $('.edge').hide();
            $('.edge2').hide();
            $.cookie('forms_dis',0);
            var tr=$.cookie('forms_dis');
            $(document).find('.head_fix').each(function(index, element) 
            {
                $(this).remove();
            });
            $('#form_b').hide();
        });
    }
});

function number(num)
{
    if(num!="")
    {
        var str = '' + num;
        while (str.length < 10) 
        {
            str = '0' + str;
        }
        document.getElementById('customer').value = str;
    }
}

function side_links_map(urls)
{
    $.cookie('sub_out','1');
    var form_values= "";

    $.cookie('form_values',form_values);
    var back_to="search_customers";

    var back_tit=$('#head_tittle').html();
    $(document).find('.head_fix').each(function(index, element) 
    {
        $(this).remove();
    });

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 

    $.ajax(
    {
        type:'POST', 
        url: urls,
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            $('#out_put').hide('slide', {direction: 'left'}, 500);
            $('#out_table').html(response)
            $('#out_table').show('slide', {direction: 'right'}, 500);
        }
    })

    $('#back_to').show();
    $('#back_to').attr('onClick','back_to("'+back_to+'","'+back_tit+'")')
}
</script>