$(document).ready(function() {
	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	

	//JS For Song Nguyen:
	$('.nav .item-with-ul').hover(function(){		
      	$('.nav .item-with-ul').removeClass('active');
      	$(this).children('ul').stop(true,true).slideDown(400);
      	$(this).addClass('active');
    },function(){
      	$(this).children('ul').stop(true,true).fadeOut('fast');
      	$(this).removeClass('active');
    });

    //Popup:
    $('.link-popup.inline').colorbox({
		inline:true,
		width:"75%", 
		height:"70%",
		onComplete: function(){
			$('#cboxLoadedContent').makeCustomScroll(false);
		}
	});
	$('.link-popup.contact').colorbox({
		inline:true,
		width:"1000px", 
		height:"620px"
	});
	$('.link-popup.iframe').colorbox({
		iframe:true,
		width:"85%", 
		height:"90%"
	});

	if($('.content-list').children('.box5').length > 5){
		$('.content-list').jcarousel({
			auto: 3,
			animation:'500',
			wrap:'first',
			itemFallbackDimension: 300
	    });
	}	
	if($('.content-list').children('.box3').length > 3){
		$('.content-list').jcarousel({
			auto: 3,
			animation:'500',
			wrap:'first',
			itemFallbackDimension: 300
	    });
	}

	//Slider:
	$('#slider').nivoSlider(); 
	//Intro popup:
	var introPopup = $('.popup-intro').first();
	if(introPopup.length > 0) {
		var hrefTo = '#' + introPopup.attr('id');
		$.colorbox({
				width:"900px",
				height:"630px",
				inline:true, 
				href: hrefTo,
				onClosed: function() {
					$('.popup-intro').remove();
				}
			}
		);
	}

	//Email sub:
	$('#email-sub h2').click(function(){
		var container = $('#email-sub').find('.container');
		if($(this).hasClass('open')) {
			container.slideUp();
			$(this).removeClass('open');
		}else {
			container.slideDown();
			$(this).addClass('open');
		}
	});
	$('#email-sub form').submit(function(){
		var email = $(this).find('input#reg-email');
		var msg = $(this).find('.error-msg');	
		var suc_msg = $(this).find('.success-msg');
		if(email.val().length == 0) {
			email.focus();
			return false;
		}else {
			msg.hide();
			suc_msg.hide();
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    		if(!pattern.test(email.val())){
    			msg.show();
    			return false;
    		}else {
    			$.ajax({
					url: $(this).data('url'),
					type: 'POST',
					dataType: 'json',
					data: {'reg-email': email.val()},
					success: function(json) {
						if (json.message != 'ok') {
							msg.show();
						}else {
							email.val('');
							suc_msg.slideDown(500).delay(2000).slideUp(400, function(){
								$('#email-sub h2').trigger('click');
							});
						}
					},
					error: function (xhr, error) {	
					alert(xhr.responseText);					
					}
				});
				return false;
    		} 		
		}
	});
});

function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

jQuery.fn.makeCustomScroll = function(isHonrizontal) {
	$(this).mCustomScrollbar({
		set_width:false, /*optional element width: boolean, pixels, percentage*/
		set_height:false, /*optional element height: boolean, pixels, percentage*/
		horizontalScroll: isHonrizontal, /*scroll horizontally: boolean*/
		scrollInertia:950, /*scrolling inertia: integer (milliseconds)*/
		mouseWheel:true, /*mousewheel support: boolean*/
		mouseWheelPixels:"auto", /*mousewheel pixels amount: integer, "auto"*/
		autoDraggerLength:true, /*auto-adjust scrollbar dragger length: boolean*/
		autoHideScrollbar:true, /*auto-hide scrollbar when idle*/
		scrollButtons:{ /*scroll buttons*/
			enable:false, /*scroll buttons support: boolean*/
			scrollType:"continuous", /*scroll buttons scrolling type: "continuous", "pixels"*/
			scrollSpeed:"auto", /*scroll buttons continuous scrolling speed: integer, "auto"*/
			scrollAmount:40 /*scroll buttons pixels scroll amount: integer (pixels)*/
		},
		advanced:{
			updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
			updateOnContentResize:false, /*auto-update scrollbars on content resize (for dynamic content): boolean*/
			autoExpandHorizontalScroll:false, /*auto-expand width for horizontal scrolling: boolean*/
			autoScrollOnFocus:true, /*auto-scroll on focused elements: boolean*/
			normalizeMouseWheelDelta:false /*normalize mouse-wheel delta (-1/1)*/
		},
		contentTouchScroll:true, /*scrolling by touch-swipe content: boolean*/
		callbacks:{
			onScrollStart:function(){}, /*user custom callback function on scroll start event*/
			onScroll:function(){}, /*user custom callback function on scroll event*/
			onTotalScroll:function(){}, /*user custom callback function on scroll end reached event*/
			onTotalScrollBack:function(){}, /*user custom callback function on scroll begin reached event*/
			onTotalScrollOffset:0, /*scroll end reached offset: integer (pixels)*/
			onTotalScrollBackOffset:0, /*scroll begin reached offset: integer (pixels)*/
			whileScrolling:function(){} /*user custom callback function on scrolling event*/
		},
		theme:"dark" /*"light", "dark", "light-2", "dark-2", "light-thick", "dark-thick", "light-thin", "dark-thin"*/
	});
}