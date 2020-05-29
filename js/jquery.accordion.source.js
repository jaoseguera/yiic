/**
*	@name							Accordion
*	@descripton						This Jquery plugin makes creating accordions pain free
*	@version						1.3
*	@requires						Jquery 1.2.6+
*
*	@author							Jan Jarfalk
*	@author-email					jan.jarfalk@unwrongest.com
*	@author-website					http://www.unwrongest.com
*
*	@licens							MIT License - http://www.opensource.org/licenses/mit-license.php
*/

(function(jQuery){
	$('.level-2 li').css({display:'block'});
     jQuery.fn.extend({  
         accordion: function() {       
		
            return this.each(function() {
            	
            	var $ul = $(this);
            	
				if($ul.data('accordiated'))
					return false;
													
				$.each($ul.find('ul, li>div'), function(){
					$(this).data('accordiated', true);
					$(this).hide();
				});
				
				$.each($ul.find('a'), function(){
					$(this).click(function(e){
						activate(this);
						return void(0);
					});
				});
				
				var active = (location.hash)?$(this).find('a[href=' + location.hash + ']')[0]:'';

				if(active){
					activate(active, 'toggle');
					$(active).parents().show();
					$(active).parents().addClass('active');
				}
				
				function activate(el,effect){
				/*var len=$(el).parent('li').children('ul,li').find('.active').length;
						if(len>1)
					{
							$(el).parent('li').children('ul').children('li:first').addClass('active');
					if($(el).parent('li').children('ul').children('li:first').hasClass('active'))
						{
                      
						}
					}
							else
					{
						//	if($(el).parent('li').parent('ul').attr('class')=='level-3')
						//{
							//	$.each($(el).parent('li').parent('ul').children('li'),function(){
								//	if($(this).hasClass('active'))
								//{
                       //alert($(this).html());
							//		}
								//})
						//}
						//else
						//{
							$(el).parent('li').children('ul').children('li:first').children('a').trigger('click');
							$(el).parent('li').children('ul').children('li:first').addClass('active');
							
						//}
						

						
						}*/
						
					
                 // $(el).parent('li').children('ul').children('li:first').toggleClass('active');
					
					$(el).parent('li').toggleClass('active').siblings().removeClass('active').children('ul, li,div').removeClass('active').slideUp('fast');
if($(el).parent('li').parent('ul').hasClass('level-1'))
					{
//alert($(el).parent('li').children('ul').children('li').html());
$.each($(el).parent('li').children('ul').children('li'), function(){

					if($(this).hasClass('active'))
						{
						//alert($(this).children('ul,li').html());
						$.each($(this).children('ul').children('li'),function(){
// alert($(this).hasClass('active'));
  if($(this).hasClass('active'))
							{
	 
  $(this).toggleClass('active');
          // var uh=$(this).children('a').trigger('click');
							}
						});

						
						}
				});
					}
					else
					{
					$.each($(el).parent('li').children('ul').children('li'), function(){
					if($(this).hasClass('active'))
						{
						$(this).toggleClass('active');
						
           // var uh=$(this).children('a').trigger('click');
						}
				});
					}
//					alert($(el).parent('li').children('ul').children('li').hasClass('active').html());
					$(el).siblings('ul, div')[(effect || 'slideToggle')]((!effect)?'fast':null);
				}
				
            });
        } 
    }); 
})(jQuery);
//...........................................................................................

function setfunction(page)
{
	
	var level=$('#'+page).parent('li').parent('ul').attr('class');
	
	if(level=='level-3')
	{
		if($('#'+page).parent('li').parent('ul').parent('li').parent('ul').parent('li').hasClass('active'))
		{
			if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
		}
		else
		{
			$('#'+page).parent('li').parent('ul').parent('li').parent('ul').parent('li').children('a').trigger('click');
			if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
				
			}
			
		}
	}
	if(level=='level-2')
	{
		if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
	}
	
if(level=='accordion level-1')
	{

$('#'+page).parent('li').children('a').trigger('click');
				//$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
	}

}
function subtu(page)
{
	//$('ul').accordion();
	
	var level=$('#'+page).parent('li').parent('ul').attr('class');
	var level=$('#'+page).parent('li').parent('ul');
	
	if(level.hasClass('level-3'))
	{
		if($('#'+page).parent('li').parent('ul').parent('li').parent('ul').parent('li').hasClass('active'))
		{
			if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				$.each($('#'+page).parent('li').parent('ul').children('li'),function(){
					if($(this).hasClass('active'))
					{
                       $(this).removeClass('active');
					}
				});
					
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
		}
		else
		{
			$('#'+page).parent('li').parent('ul').parent('li').parent('ul').parent('li').children('a').trigger('click');
			if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				//$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				//$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
				
			}
			
		}
	}
	else if(level.hasClass('level-2'))
	{
		
		if($('#'+page).parent('li').parent('ul').parent('li').hasClass('active'))
			{
				$('#'+page).parent('li').parent('ul').children('li').each(function(index, element) {
					
                    if($(this).hasClass('active'))
					{
						$(this).children('a').trigger('click');
					}
                });
				$('#'+page).parent('li').addClass('active');
			}
			else
			{
				$('#'+page).parent('li').parent('ul').parent('li').children('a').trigger('click');
				//$('#'+page).parent('li').children('a').trigger('click');
				$('#'+page).parent('li').addClass('active');
			}
	}
	

}

function formsa2()
{
	$.cookie('forms_dis',0);
	var tr=$.cookie('forms_dis');
return tr;
}
function formsa()
{
	$.cookie('forms_dis',1);
	var tr=$.cookie('forms_dis');
return tr;
}
function formsa1()
{
	
	var tr=$.cookie('forms_dis');
return tr;
}
$(document).ready(function ()
{
	$('.level-3').click(function()
	{
		$.cookie('forms_dis',0);
		
		})
		
		
	
})
function gut()
{
	
	$('#form_b').show();
}
function gut1()
{
	
	$('#form_b').hide();
}