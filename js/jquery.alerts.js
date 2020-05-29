// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .01,                // transparency level of overlay
		overlayColor: '#FFF',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},
		prompt1: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt1';
			$.alerts._show(title, message, value, 'prompt1', function(result) {
				if( callback ) callback(result);
			});
		},
		prompturl: function(message, value, title, callback) {
			if( title == null ) title = 'Prompturl';
			$.alerts._show(title, message, value, 'prompturl', function(result) {
				if( callback ) callback(result);
			});
		},
		prompt_bi: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt_bi';
			$.alerts._show(title, message, value, 'prompt_bi', function(result) {
				if( callback ) callback(result);
			});
		},
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);
			
                        //////------------------------------------------------------------------------------
                        var matched, browser;
                        jQuery.uaMatch = function( ua ) {
                            ua = ua.toLowerCase();

                            var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
                                /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
                                /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
                                /(msie) ([\w.]+)/.exec( ua ) ||
                                ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
                                [];

                            return {
                                browser: match[ 1 ] || "",
                                version: match[ 2 ] || "0"
                            };
                        };

                        matched = jQuery.uaMatch( navigator.userAgent );
                        browser = {};

                        if ( matched.browser ) {
                            browser[ matched.browser ] = true;
                            browser.version = matched.version;
                        }

                        // Chrome is Webkit, but Webkit is also Safari.
                        if ( browser.chrome ) {
                            browser.webkit = true;
                        } else if ( browser.webkit ) {
                            browser.safari = true;
                        }
                        $.browser = browser;
                        //////------------------------------------------------------------------------------
                        
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );
			if($(document).width()<450)
			{
				$("#popup_container").css({ width:'70%' });
			}
			else
			{
				$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});
			}
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" class="post_col"/></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						
						if( callback ) callback(true);
					});
					$("#popup_cancel").click( function() {
						
						$.alerts._hide();
						if( callback ) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
				
				$("#popup_message").append('<br />Client Id:<input type="text" size="30"  name="client" class="popup_prompt" id="popup_prompt"/><br />User Name:<input type="text" size="30" name="user" class="popup_prompt" id="h_user"/><br />Password:<input type="password" size="30" class="popup_prompt" name="pass" id="pass_host"/><br />Language:<select class="popup_prompt" style="width: 208px;" id="initial_language"><option value="EN">EN</option><option value="ES">ES</option></select>').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$(".popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						 var val='';
						 var hidd='';
						$(".popup_prompt").each(function(index, element) {
							if($(this).val()=='')
							{
								$(this).css({border:'1px solid red'});
								hidd=1;
							}
                           val +=$(this).val()+",";
                        });
						if(hidd==1)
						{
							return false;
						}
						else
						{
							$.alerts._hide();
						}
				/*case 'prompt':
					$("#popup_message").append('<br /><input type="password" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();*/
						
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$('.body_con').trigger('click');
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$(".popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value!='no_data')
					{ 
					var sdr=value.split(',');
					
						$("#popup_prompt").val(sdr[0]);
						$("#h_user").val(sdr[1]);
						if(sdr[0]=='210'&&sdr[1]=='msreekanth')
						{
							$('#pass_host').val('admin123');
						}
						$("#popup_ok").focus();
										}
										else
										{
											$("#popup_prompt").focus();
										}
				break;
					case 'prompt1':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $.trim($("#popup_prompt").val());
						if(val=='')
						{
							$('#popup_prompt').css({border:'1px solid red'});
						}
						else
						{
						$.alerts._hide();
						if( callback ) callback( val );
						}
					});
					$("#popup_cancel").click( function() {
						
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
				//..........................................................................................
				
				
				case 'prompturl':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="Save" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $.trim($("#popup_prompt").val());
						//var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
						// var re = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/
						var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
						$('#url_error').remove();
						
						if (re.test(val))
						{
							$.alerts._hide();
							if( callback ) callback( val );
						}
						else
						{
							$('#popup_prompt').css({border:'1px solid red'});
							$("<div id='url_error' class='flash-error'>Please Enter URL with http</div>").insertBefore('#popup_prompt');
						}
					});
					$("#popup_cancel").click( function() {
						
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
				//..........................................................................................
				case 'prompt_bi':
					$("#popup_message").append('User Name: <input type="text" size="30" id="name_prompt" class="popup_prompt"/><br />Password: <input type="password" size="30" id="popup_prompt" class="popup_prompt"/>').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val="";
						var hidd='';
						$(".popup_prompt").each(function(index, element) {					
							if($(this).val()=='')
							{
								$(this).css({border:'1px solid red'});
								hidd=1;
							}                           
                        });
						if(hidd==1)
						{  
							return false; 
						}
						else
						{ 
							$.alerts._hide();
						}
						val += $("#name_prompt").val()+',';
						 val += $("#popup_prompt").val();
						$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value!='no_data' ) 
					{
					$("#name_prompt").val(value);
					$("#popup_ok").focus().select();
					} else {$("#name_prompt").focus().select();}
				break;
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			if($(document).width()<450)
			{
			tops=screen.height/5;
			}
			else
			{
				tops=screen.height/4;
			}
			$("#popup_container").css({
				top: tops + 'px',
				left: left + 'px',
				position:'fixed'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	jPrompt1 = function(message, value, title, callback) {
		$.alerts.prompt1(message, value, title, callback);
	};
	jPrompturl = function(message, value, title, callback) {
		$.alerts.prompturl(message, value, title, callback);
	};
	
	jPrompt_bi = function(message, value, title, callback) {
		$.alerts.prompt_bi(message, value, title, callback);
	};
})(jQuery);
function is_valid_url(url)
{
     return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
}