/*
	Copyright (c) 2013 
	Willmer, Jens (http://jwillmer.de)	
	
	Permission is hereby granted, free of charge, to any person obtaining
	a copy of this software and associated documentation files (the
	"Software"), to deal in the Software without restriction, including
	without limitation the rights to use, copy, modify, merge, publish,
	distribute, sublicense, and/or sell copies of the Software, and to
	permit persons to whom the Software is furnished to do so, subject to
	the following conditions:
	
	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
	OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
	WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	
	
	feedBackBox: A small feedback box realized as jQuery Plugin.
	@author: Willmer, Jens
	@url: https://github.com/jwillmer/feedBackBox
	@documentation: https://github.com/jwillmer/feedBackBox/wiki
	@version: 0.0.1
*/
; (function ($) {
    $.fn.extend({
        feedBackBox: function (options) {

            // default options
            this.defaultOptions = {
                title: 'Feedback/Help',
                titleMessage: 'Please feel free to leave us feedback or request for Help.',
                userName: '',
                isUsernameEnabled: true,
                message: '',
                ajaxUrl: 'common/feedback',
                successMessage: 'Thank your for your feedback.',
                errorMessage: 'Something wen\'t wrong!'
            };

            var settings = $.extend(true, {}, this.defaultOptions, options);

            return this.each(function () {
                var $this = $(this);
                var thisSettings = $.extend({}, settings);

                var diableUsername;
                if (!thisSettings.isUsernameEnabled) {
                    diableUsername = 'disabled="disabled"';
                }

                // add feedback box
                $this.html('<div id="fpi_feedback"><div id="fpi_title" class="rotate"><h2>'
                    + thisSettings.title
                    + '</h2></div><div id="fpi_content"><div id="fpi_header_message"><h3>'
                    + thisSettings.titleMessage
                    + '</h3></div><form><div><h4>&nbsp;Please select your ticket type <span>&nbsp;*</span></h4>'
					+'<select id="fpi_submit_select" name="select_type"><option value="" id="sele_op">select your ticket type</option>'
					+'<option value="Feedback">Feedback</option><option value="Help">Help</option></select>'
					+'</div><div id="fpi_submit_username"><h4>Subject <span>&nbsp;*</span></h4><input type="text" name="name" '
                    + diableUsername
                    + ' value="'
                    + thisSettings.userName
                    + '"></div><div id="fpi_submit_message"><h4>Message <span>&nbsp;*</span></h4><textarea name="feedback" id="textarea_feed"></textarea></div>'
                    + '<div id="fpi_submit_loading"></div><div id="fpi_submit_submit"><input type="submit" value="<?php echo _SUBMIT ?>">'
					+ '</div></form><div id="fpi_ajax_message"><h2></h2></div></div></div>');

                // remove error indication on text change
				 $('#fpi_submit_select').change(function () {
					 //alert($(this).val());
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
                $('#fpi_submit_username input').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
                $('#fpi_submit_message textarea').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });

                // submit action
                $this.find('form').submit(function () {

                    // validate input fields
					
                    var haveErrors = false;
                    if ($('#fpi_submit_username input').val() == '' && typeof diableUsername == 'undefined') {
                        haveErrors = true;
                        $('#fpi_submit_username input').addClass('error');
                    }
                    if ($('#fpi_submit_message textarea').val() == '') {
						
                        haveErrors = true;
                        $('#fpi_submit_message textarea').addClass('error');
                    } 
                   if ($('#fpi_submit_select').val() == '') {
					    
                        haveErrors = true;
                        $('#fpi_submit_select').addClass('error');
						 
						//alert($('#fpi_submit_select').val());
                    } 
                    // send ajax call
                    if (!haveErrors) {
                        // serialize all input fields
                        var disabled = $(this).find(':input:disabled').removeAttr('disabled');
                        var serialized = $(this).serialize();
                        disabled.attr('disabled', 'disabled');

                        // disable submit button
                        $('#fpi_submit_submit input').attr('disabled', 'disabled');
                        $('#fpi_submit_loading').show();
                        $.ajax({
                            type: 'POST',
                            url: thisSettings.ajaxUrl,
                            data: serialized,
                            success: function (data) {
								$('#fpi_content form').hide();
                                $('#fpi_content #fpi_ajax_message h2').html(thisSettings.successMessage);
								 setTimeout(function() {
                              $('#fpi_title').trigger('click');
                                  }, 1100)
								$('#fpi_submit_username input[type=text]').val('');
								$('#textarea_feed').val('');
								$('#fpi_submit_select option:first').attr('selected','selected');
                            }
                        });
                    }

                    return false;
                });
               
                // open and close animation
                var isOpen = false;
                $('#fpi_title').click(function () {
                    if (isOpen) {
						//alert('1');
						
						$(this).removeClass('rotates').addClass('rotate');
                        $('#fpi_feedback').animate({ "bottom": "-440px" }, "slow")
                        .animate({ "bottom": "-430px" }, "fast");
						
                        isOpen = !isOpen;
                    } else {
						$('#fpi_content').show();
						$(this).removeClass('rotate').addClass('rotates');
                        $('#fpi_feedback').animate({ "bottom": "0px" }, "slow")
                        .animate({ "bottom": "-10px" }, "fast");

                        // reset properties
                        $('#fpi_submit_loading').hide();
                        $('#fpi_content form').show()
                        $('#fpi_content form .error').removeClass("error");
                        $('#fpi_submit_submit input').removeAttr('disabled');
					
                        isOpen = !isOpen;
						
                    }
                });

            });
        },
		 feedBackLog: function (options) {

            // default options
            this.defaultOptions = {
                title: 'Feedback/Help',
                titleMessage: '&nbsp;',
                userName: '',
                isUsernameEnabled: true,
                message: '',
				ajaxUrl: 'common/feedback',
                //ajaxUrl: '../lib/feedback_form.php?login=login',
                successMessage: 'Thank your for your feedback.',
                errorMessage: 'Something wen\'t wrong!'
            };

            var settings = $.extend(true, {}, this.defaultOptions, options);

            return this.each(function () {
                var $this = $(this);
                var thisSettings = $.extend({}, settings);

                var diableUsername;
                if (!thisSettings.isUsernameEnabled) {
                    diableUsername = 'disabled="disabled"';
                }

                // add feedback box
                $this.html('<div id="fpi_feedback"><div id="fpi_title" class="rotate"><h2>'
                    + thisSettings.title
                    + '</h2></div><div id="fpi_content"><div id="fpi_header_messsage"><h4>'
                    + thisSettings.titleMessage
                    + '</h4></div><form id="validation"><div class="fpi_submit_username"><h4>&nbsp;Name<span>&nbsp;*</span></h4>'
					+'<input type="text" name="name" class="validate[required]">'
					+'</div><div class="fpi_submit_username"><h4>Email ID <span>&nbsp;*</span></h4><input type="email" name="email" class="validate[required,custom[email]]"/>'
					+'</div><div class="fpi_submit_username"><h4>Telephone <span>&nbsp;*</span></h4><input type="text" name="tele" class="validate[required, custom[phone]]">'
					+'</div><div id="fpi_submit_message"><h4>Message <span>&nbsp;*</span></h4><textarea name="feedback" id="textarea_feed"></textarea></div>'
                    + '<div id="fpi_submit_loading"></div><div id="fpi_submit_submit"><input type="submit" value="<?php echo _SUBMIT ?>">'
					+ '</div></form><div id="fpi_ajax_message"><h2></h2></div></div></div>');

                // remove error indication on text change
				 $('#fpi_submit_select').change(function () {
					 //alert($(this).val());
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
                $('#fpi_submit_username input').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
                $('#fpi_submit_message textarea').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
             $('.fpi_submit_username input').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });

                // submit action
                $this.find('form').submit(function () {

                    // validate input fields
					
                    var haveErrors = false;
                    if ($('#fpi_submit_username input').val() == '' && typeof diableUsername == 'undefined') {
                        haveErrors = true;
                        $('#fpi_submit_username input').addClass('error');
                    }
					
                    if ($('#fpi_submit_message textarea').val() == '') {
						
                        haveErrors = true;
                        $('#fpi_submit_message textarea').addClass('error');
                    } 
                   if ($('#fpi_submit_select').val() == '') {
					    
                        haveErrors = true;
                        $('#fpi_submit_select').addClass('error');
						 
						//alert($('#fpi_submit_select').val());
                    } 
                    // send ajax call
                    if (!haveErrors) {
                        // serialize all input fields
                        var disabled = $(this).find(':input:disabled').removeAttr('disabled');
                        var serialized = $(this).serialize();
                        disabled.attr('disabled', 'disabled');

                        // disable submit button
                        $('#fpi_submit_submit input').attr('disabled', 'disabled');
                        $('#fpi_submit_loading').show();
                        $.ajax({
                            type: 'POST',
                            url: thisSettings.ajaxUrl,
                            data: serialized,
                            success: function (data) {
								$('#fpi_content form').hide();
                                $('#fpi_content #fpi_ajax_message h2').html(thisSettings.successMessage);
								 setTimeout(function() {
                              $('#fpi_title').trigger('click');
                                  }, 1100)
								$('#fpi_submit_username input[type=text]').val('');
								
								$('#textarea_feed').val('');
								$('#fpi_submit_select option:first').attr('selected','selected');
                            }
                        });
                    }

                    return false;
                });
               
                // open and close animation
                var isOpen = false;
                $('#fpi_title').click(function () {
                    if (isOpen) {
						//alert('1');
						
						$(this).removeClass('rotates').addClass('rotate');
                        $('#fpi_feedback').animate({ "bottom": "-440px" }, "slow")
                        .animate({ "bottom": "-430px" }, "fast");
						
                        isOpen = !isOpen;
                    } else {
						$('#fpi_content').show();
						$(this).removeClass('rotate').addClass('rotates');
                        $('#fpi_feedback').animate({ "bottom": "0px" }, "slow")
                        .animate({ "bottom": "-10px" }, "fast");

                        // reset properties
                        $('#fpi_submit_loading').hide();
                        $('#fpi_content form').show()
                        $('#fpi_content form .error').removeClass("error");
                        $('#fpi_submit_submit input').removeAttr('disabled');
						
					
                        isOpen = !isOpen;
						
                    }
                });

            });
        }
    });
})(jQuery);
