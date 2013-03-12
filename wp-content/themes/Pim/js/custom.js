/*
	Easy plugin to get element index position
	Author: Peerapong Pulpipatnan
	http://themeforest.net/user/peerapong
*/

$.fn.getIndex = function(){
	var $p=$(this).parent().children();
    return $p.index(this);
}

$.fn.setNav = function(){
	jQuery('#top_menu li ul').css({display: 'none'});

	jQuery('#top_menu li').each(function()
	{	
		
		var $sublist = jQuery(this).find('ul:first');
		
		jQuery(this).hover(function()
		{	
			$sublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).slideDown(200, function()
			{
				jQuery(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
			
			jQuery(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$sublist.stop().hide(50, function()
			{	
				jQuery(this).css({overflow:'hidden', display:'none'});
			});
			
			jQuery(this).find('a:first').removeClass('hover');
		});	
		
	});
	
	jQuery('#top_menu li ul li').each(function()
	{
		
		jQuery(this).hover(function()
		{	
			jQuery(this).find('a').addClass('hover');
		},
		function()
		{	
			jQuery(this).find('a').removeClass('hover');
		});	
		
	});
	
	
	jQuery('#main_menu li ul').css({display: 'none'});

	jQuery('#main_menu li').each(function()
	{	
		
		var $sublist = jQuery(this).find('ul:first');
		
		jQuery(this).hover(function()
		{	
			$sublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).slideDown(200, function()
			{
				jQuery(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
			
			jQuery(this).addClass('hover');
		},
		function()
		{	
			$sublist.stop().hide(50, function()
			{	
				jQuery(this).css({overflow:'hidden', display:'none'});
			});
			
			jQuery(this).removeClass('hover');
		});	
		
	});
	
	jQuery('#main_menu li ul li').each(function()
	{
		
		jQuery(this).hover(function()
		{	
			jQuery(this).find('a').addClass('hover');
		},
		function()
		{	
			jQuery(this).find('a').removeClass('hover');
		});	
		
	});
}
	   

$(document).ready(function(){ 

	//$(document).setNav();
	
	$('input[title!=""]').hint();
	
	$('.portfolio_vimeo').fancybox({ 
		padding: 10,
		overlayColor: '#000',
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$('.portfolio_youtube').fancybox({ 
		padding: 10,
		overlayColor: '#000',
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$('.portfolio_image').fancybox({ 
		padding: 10,
		overlayColor: '#000',
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$('.img_frame').fancybox({ 
		padding: 10,
		overlayColor: '#000',
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$('.pp_gallery a').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$('.quick_view').fancybox({ 
		padding: 0,
		overlayColor: '#000',
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8,
		titleShow: false
	});
	
	$.validator.setDefaults({
		submitHandler: function() { 
		    var actionUrl = $('#contact_form').attr('action');
		    
		    $.ajax({
  		    	type: 'POST',
  		    	url: actionUrl,
  		    	data: $('#contact_form').serialize(),
  		    	success: function(msg){
  		    		$('#contact_form').hide();
  		    		$('#reponse_msg').html(msg);
  		    	}
		    });
		    
		    return false;
		}
	});
		    
		
	$('#contact_form').validate({
		rules: {
		    your_name: "required",
		    email: {
		    	required: true,
		    	email: true
		    },
		    message: "required"
		},
		messages: {
		    your_name: "Please enter your name",
		    email: "Please enter a valid email address",
		    agree: "Please enter some message"
		}
	});	
	
	if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 8)
	{
		var zIndexNumber = 1000;
		$('div').each(function() {
			$(this).css('zIndex', zIndexNumber);
			zIndexNumber -= 10;
		});

		$('#thumbNav').css('zIndex', 1000);
		$('#thumbLeftNav').css('zIndex', 1000);
		$('#thumbRightNav').css('zIndex', 1000);
		$('#fancybox-wrap').css('zIndex', 1001);
		$('#fancybox-overlay').css('zIndex', 1000);
	}
	
	$( "#featured_posts" ).accordion({ autoHeight: false });
	
	$(".accordion").accordion({ collapsible: true });
	
	$(".accordion_close").find('.ui-accordion-header a').click();
	
	$(".tabs").tabs();
	
	$('.thumb li a').tipsy();

	$('.social_media li a').tipsy();
});