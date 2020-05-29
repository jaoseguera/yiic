// JavaScript Document
$(document).ready(function(e) {
    $.ajax({
        url: "common/systemmsg",
        success: function(html) {
            $('#pending_sms').html(html);
        }
    });
    
    $('#wigg_left').click(function() {
        all_r();
        $('.widget_left').show();
        $("#backgroundPopup").css("opacity", "0.7");
        $("#backgroundPopup").fadeIn(0001); 
    });
	  
    $('#wigg_right').click(function()
    {
        all_r();
        $('.widget_right').show();
        $("#backgroundPopup").css("opacity", "0.7");
        $("#backgroundPopup").fadeIn(0001); 
		 		 
    });
    
    $('.cls_wid').click(function(e) {
        $('.widget_left').hide();
        $('.widget_right').hide();
        $("#backgroundPopup").fadeOut(0001); 
    });
	
    $("#backgroundPopup").click(function(e) {
        $('.widget_left').hide();
        $('.widget_right').hide();
        $("#backgroundPopup").fadeOut(0001); 
    });

/* $('#delete_weather').mouseover(function(e) {
        $('.cls_we').addClass('close_wegid').removeClass('none_wegid');
		$('#delete_date').mouseover(function(e) {
        $('.cls_ca').addClass('close_wegid').removeClass('none_wegid');
    });
	$('#delete_date').mouseout(function(e) {
        $('.cls_ca').addClass('none_wegid').removeClass('close_wegid');
    });
    });
	$('#delete_weather').mouseout(function(e) {
        $('.cls_we').addClass('none_wegid').removeClass('close_wegid');
    });
	//.......................
	
	//........................................
	$('#delete_feed').mouseover(function(e) {
        $('.cls_fe').addClass('close_wegid').removeClass('none_wegid');
    });
	$('#delete_feed').mouseout(function(e) {
        $('.cls_fe').addClass('none_wegid').removeClass('close_wegid');
    });*/
});

function all_r()
{
    var de=0;
    var dr=0;
    $('.widget_left table').find('tr').each(function(index, element) {
			 
        if($(this).css('display')!='none')
        {
            de=1;
        }
    });
    
    $('#w_le').hide();
    if(de==0)
    {
        $('#w_le').show();
    }
		
    $('.widget_right table').find('tr').each(function(index, element) {
        if($(this).css('display')!='none')
        {
            dr=1;
        }
    });
    
    $('#w_ri').hide();
    if(dr==0)
    {
        $('#w_ri').show();
    }	
}

function delete_weigt(ids)
{
    $('.'+ids).hide();
    $.ajax({
        type: "POST",
        data:"page=welcome_url&type=wegid&wegid_type="+ids+"&display=Add",
        url: "../lib/controller.php",
        success: function(html) {
            $('.'+ids+'_tr').removeClass('none_wegid');
            $('.'+ids+'_tr').show();
            $('#'+ids+'_x').html(html);
            all_r();
        }
    })
}
function add_widget(ids)
{
    $('.'+ids).removeClass('none_wegid').show();
    $.ajax({
        type: "POST",
        data:"page=welcome_url&type=wegid&wegid_type="+ids+"&display=Remove",
        url: "../lib/controller.php",
        success: function(html) {
            $('.'+ids+'_tr').hide();
            $('#'+ids+'_x').html(html);
            all_r();
        }
    })
}

function we_db(type,ids)
{
    if(type=='Remove')
    {
        delete_weigt(ids);
    }
    else
    {
        add_widget(ids);
    }
}