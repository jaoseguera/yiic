//userinfo 
var BaseURL = jQuery('#BaseURL').val();

jQuery('#host_list').click(function(){
	jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user.png');
	if($('.sidebar-toggle').hasClass('user-active-bars'))
            $('#nav_tab').hide();
        
	$('.sidebar-toggle').removeClass('user-active-bars');
	jQuery('.user-info').removeClass('user-active');
        jQuery('.user_list').removeClass('user-active-list');
        jQuery('.user-dropbox').hide();
        jQuery('.user-dropbox-admin').hide();
   if(!jQuery(this).hasClass('user-active-host')) {

       jQuery('.sys_ic').attr('src','images/icons/system-a.png');
        var $userInfo = jQuery(this);
        var $userDrop = jQuery('#d_host_list');
        //jQuery('.user-dropbox').show();

        $userDrop.slideDown('fast');
        $userInfo.addClass('user-active-host');					//add class to change color and background

   } else {
	
       // console.log('has class');
        jQuery(this).removeClass('user-active-host');
        jQuery('#d_host_list').hide();
       jQuery('.sys_ic').attr('src','images/icons/system.png');
    }

   // remove notification box if visible
    jQuery('.notification-counter').removeClass('notification-active');
    jQuery('.notification-box').hide();

    return false;
});


jQuery('#favt').click(function(){
	jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user.png');
    jQuery('.sys_ic').attr('src',BaseURL+'/images/icons/system.png');
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
	jQuery('.user-info').removeClass('user-active');
	jQuery('#his_u').removeClass('user-active-list');
	jQuery('.user-dropbox').hide();
	jQuery('.user-dropbox-admin').hide();
   if(!jQuery(this).hasClass('user-active-list')) {
	
       
        var $userInfo = jQuery(this);
        var $userDrop = jQuery('#d_favt');
		//jQuery('.user-dropbox').show();

       $userDrop.slideDown('fast');
        $userInfo.addClass('user-active-list');					//add class to change color and background

   } else {
	
       // console.log('has class');
        jQuery(this).removeClass('user-active-list');
        jQuery('#d_favt').hide();
    }

   // remove notification box if visible
    jQuery('.notification-counter').removeClass('notification-active');
    jQuery('.notification-box').hide();

    return false;
});

jQuery('#admin_u').click(function(){
    jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user-a.png');
    jQuery('.sys_ic').attr('src',BaseURL+'/images/icons/system.png');
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	//jQuery('.user-info').removeClass('user-active');
		jQuery('.user_list').removeClass('user-active-list');
		jQuery('.user-dropbox').hide();
	jQuery('.user-dropbox-admin').hide();
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
    //alert(jQuery(this).hasClass('user-active'));
    if(!jQuery(this).hasClass('user-active')) {
	
       // console.log('no class');
        var $userInfo = jQuery(this);
        var $userDrop = jQuery('#d_admin_u');
		//jQuery('.user-dropbox').show();

        $userDrop.slideDown('fast');
        $userInfo.addClass('user-active');					//add class to change color and background
        //jQuery('.usr_ic').attr('src','images/icons/user-a.png');

    } else {
	
       // console.log('has class');
        jQuery('.usr_ic').attr('src','images/icons/user.png');
        jQuery(this).removeClass('user-active');
        jQuery('#d_admin_u').hide();
    }

    //remove notification box if visible
    jQuery('.notification-counter').removeClass('notification-active');
    jQuery('.notification-box').hide();

    return false;
});


jQuery('#his_u').click(function(){
	jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user.png');
    jQuery('.sys_ic').attr('src',BaseURL+'/images/icons/system.png');
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
	jQuery('.user-info').removeClass('user-active');
		jQuery('#favt').removeClass('user-active-list');
		jQuery('.user-dropbox').hide();
		jQuery('.user-dropbox-admin').hide();
   if(!jQuery(this).hasClass('user-active-list')) {
	
      
        var $userInfo = jQuery(this);
        var $userDrop = jQuery('#d_his_u');
		//jQuery('.user-dropbox').show();

       $userDrop.slideDown('fast');
        $userInfo.addClass('user-active-list');					//add class to change color and background

   } else {
	//alert('hi');
       // console.log('has class');
        jQuery(this).removeClass('user-active-list');
        jQuery('#d_his_u').hide();
    }

   // remove notification box if visible
    jQuery('.notification-counter').removeClass('notification-active');
    jQuery('.notification-box').hide();

    return false;
});


//notification onclick

jQuery('#setting_w').click(function(){
	jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user.png');
    jQuery('.sys_ic').attr('src',BaseURL+'/images/icons/system.png');
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
	jQuery('.user-info').removeClass('user-active');
		jQuery('.user_list').removeClass('user-active-list');
		jQuery('.user-dropbox').hide();
		jQuery('.user-dropbox-admin').hide();
   if(!jQuery(this).hasClass('user-active-list')) {
	
      
        var $userInfo = jQuery(this);
        var $userDrop = jQuery('#sett');
		//jQuery('.user-dropbox').show();

       $userDrop.slideDown('fast');
        $userInfo.addClass('user-active-list');					//add class to change color and background

   } else {
	//alert('hi');
       // console.log('has class');
        jQuery(this).removeClass('user-active-list');
        jQuery('#d_his_u').hide();
    }

   // remove notification box if visible
    jQuery('.notification-counter').removeClass('notification-active');
    jQuery('.notification-box').hide();

    return false;
});


// Widget hover event
// show arrow image in the right side of the title upon hover
jQuery('.utopia-widget-title').hover(function(){
	
   // jQuery(this).after().append('<span class="collapse-widget">&nbsp;&nbsp;</span>');
}, function(){
    //jQuery(this).children('.collapse-widget').remove()
});

//show/hide widget content when widget title is clicked
jQuery('.utopia-widget-title3').click(function(){
	jQuery(this).css({
			'background-image': 'none',
      
			});
	jQuery(this).children('.collapse-widget').remove()
    if(jQuery(this).next().is(':visible')) {
        jQuery(this).next().slideUp('fast');
        jQuery(this).css('border-bottom','none');
        jQuery(this).addClass('utopia-widget-title-toggle');
		jQuery(this).css({
			'background-image': 'url(../images/down.png)',
    'background-repeat': 'no-repeat',
    'background-position': 'right center'
	
    
			});
		
    } else {
        jQuery(this).next().slideDown('fast');
        jQuery(this).removeClass('utopia-widget-title-toggle');
        jQuery(this).css('border-bottom','1px solid #eee');
		jQuery(this).after().append('<span class="collapse-widget">&nbsp;&nbsp;</span>')
    }

});


jQuery('.search-panel').hover(function(){
    jQuery('.search-box img').hide();
    jQuery('.search-box form').show();
	
}, function(){
    jQuery('.search-box form').hide();
    jQuery('.search-box img').show();
	
});
$(document).keydown(function(e){
	
		if(e.keyCode==27)
	{
		$('.help_thin').hide();
		$('.help_close').hide();
	}
});
var fd=0;
$('.body_con').click(function()
{
	
	jQuery('.usr_ic').attr('src',BaseURL+'/images/icons/user.png');
    jQuery('.sys_ic').attr('src',BaseURL+'/images/icons/system.png');
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	jQuery('.user-info').removeClass('user-active');
		jQuery('.user_list').removeClass('user-active-list');
		jQuery('.user-dropbox').hide();
	jQuery('.user-dropbox-admin').hide();
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
	
	
	
		//$('.hid_b').hide();
		
		if($('#exp_pop').css('display')=='block'||$('#pos_tab').css('display')=='block')
		{
			fd=fd+1;
	
		if(fd==2)
		{
			
			$('#exp_pop').hide();
			$('#pos_tab').hide();
			fd=0;
		}
		
		}
		else
		{
			fd=0;
		}
	
});
function hide_bar()
{
	
	jQuery('#d_host_list').hide();
	jQuery('.host_list').removeClass('user-active-host');
	jQuery('.user-info').removeClass('user-active');
		jQuery('.user_list').removeClass('user-active-list');
		jQuery('.user-dropbox').hide();
	jQuery('.user-dropbox-admin').hide();
	if($('.sidebar-toggle').hasClass('user-active-bars'))
	{
	$('#nav_tab').hide();
	}
	$('.sidebar-toggle').removeClass('user-active-bars');
}
 function help_t()
{
	//$('body').html('<img src="../images/help_thinui.png">');
	//$('.help_close').show();
	$('.help_thin').show();
	$('.help_thin').click(function()
	{
		$(this).hide();
		$('.help_thin').hide();
	})
}
function help_log()
{
	
	var help_en=$.cookie('help_en');
	window.location='../lib/logout.php?helps='+help_en;
}