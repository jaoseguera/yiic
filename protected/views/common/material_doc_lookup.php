<?php

?><form action="<?php echo Yii::app()->createAbsoluteUrl('common/material_doc_help'); ?>" method="post" name="JobForm" id='target'>
    <table align="center" border="0">
        <tr><td>Material From :</td>
            <td><input type="text" value="" name='MATERIAL_FROM' class="fut input-fluid"/></td>
        </tr>

        <tr><td>Material To :</td>
            <td><input type="text" value="" name='MATERIAL_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td>Plant From :</td>
            <td><input type="text" value="" name='PLANT_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Plant To :</td>
            <td><input type="text" value="" name='PLANT_TO' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Stor. Location From :</td>
            <td><input type="text" value="" name='STGE_LOC_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Stor. Location To :</td>
            <td><input type="text" value="" name='STGE_LOC_TO' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Batch From :</td>
            <td><input type="text" value="" name='BATCH_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Bach To :</td>
            <td><input type="text" value="" name='BATCH_TO' class="fut input-fluid"/></td>
        </tr>
        <!--<tr><td>Movement Type From :</td>
            <td><input type="text" value="" name='MOVE_TYPE_FROM' class="fut"/></td>
        </tr>
        <tr><td>Movement Type To :</td>
            <td><input type="text" value="" name='MOVE_TYPE_TO' class="fut"/></td>
        </tr>-->
        <tr><td>Special Stock From :</td>
            <td><input type="text" value="" name='SPEC_STOCK_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Special Stock To :</td>
            <td><input type="text" value="" name='SPEC_STOCK_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td>Trans./Event Type From :</td>
            <td><input type="text" value="" name='TR_EV_TYPE_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Trans./Event Type To :</td>
            <td><input type="text" value="" name='TR_EV_TYPE_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td>Posting Date From :</td>
            <td><input type="text" value="" name='PSTNG_DATE_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Posting Date To :</td>
            <td><input type="text" value="" name='PSTNG_DATE_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td>Vendor From :</td>
            <td><input type="text" value="" name='VENDOR_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>Vendor To :</td>
            <td><input type="text" value="" name='VENDOR_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td>User Name From :</td>
            <td><input type="text" value="" name='USERNAME_FROM' class="fut input-fluid"/></td>
        </tr>
        <tr><td>User Name To :</td>
            <td><input type="text" value="" name='USERNAME_TO' class="fut input-fluid"/></td>
        </tr>

        <tr><td colspan="2" align="center">
                <!--<input type="hidden" value="<?php /*echo $shlname."~".$shltype;*/?>" id="help_shname"/>-->
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

function scrt_mat(type)
{
    //alert(type)
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
            var datastr = 'irows='+irows+'&pre='+pre+'&type='+type;

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
                                if($('#back_it').is(':visible')) {

                                    var oTable = $('#help').dataTable();
                                    oTable.fnDestroy();
                                    $('#scr_lod').replaceWith(response);
                                    var oTable = $('#help').dataTable({ "bPaginate": false, "bSort": false, "sDom": 'R' });
                                }

                            }
                        }
                    }
                }
            });
        }
    }
}
</script>