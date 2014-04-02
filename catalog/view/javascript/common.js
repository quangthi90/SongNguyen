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

    var current_url = window.location.pathname;
    //Popup:
    $('.link-popup.inline').colorbox({
		inline:true,
		width:"75%", 
		height:"70%",
		onComplete: function(){
			$('#cboxLoadedContent').makeCustomScroll(false);
			$('.content-list').trigger('stop');
		},
		onClosed: function() {
			setTimeout(function(){
				$('.content-list').trigger('play', true);
			}, 1000);			
		}
	});
	$('.link-popup.contact').colorbox({
		inline:true,
		width:"1000px", 
		height:"600px",
		onComplete: function(){
			$('#cboxLoadedContent').css('overflow','hidden');
			$('.content-list').trigger('stop');
		},
		onClosed: function() {
			setTimeout(function(){
				$('.content-list').trigger('play', true);
			}, 1000);			
		}
	});
	$('.link-popup.sitemap-ref').colorbox({
		inline:true,
		width:"1000px", 
		height:"620px",
		onComplete: function(){
			$('#cboxLoadedContent').makeCustomScroll(false);
			$('.content-list').trigger('stop');
		},
		onClosed: function() {
			setTimeout(function(){
				$('.content-list').trigger('play', true);
			}, 1000);			
		}
	});
	$('.link-popup.email-subscription').colorbox({
		inline:true,
		width:"600px", 
		height:"300px",
		onComplete: function(){
			$('.content-list').trigger('stop');
		},
		onClosed: function() {
			setTimeout(function(){
				$('.content-list').trigger('play', true);
			}, 1000);			
		}
	});
	$('.link-popup.iframe').colorbox({
		iframe:true,
		width:"90%", 
		height:"95%",
        onOpen: function() {
            window.history.pushState('Test', 'Testtitle', $(this).attr('href'));
        },
		onComplete: function(){
			$('.content-list').trigger('stop');
		},
		onClosed: function() {
			setTimeout(function(){
				$('.content-list').trigger('play', true);
			}, 1000);
            window.history.pushState('Test', 'Testtitle', current_url);
		}
	});
	$('.link-popup.map-item').colorbox({
		width:"95%", 
		height:"95%",
		onClosed: function() {
			$('.link-popup.contact').trigger('click');
		}
	});

	function initScroll() {
		var wrapper = $('.caroufredsel_wrapper');
		var prevBtn = $('#prev-scroll');
		var nextBtn = $('#next-scroll');
		wrapper.width(1000);
		wrapper.append(prevBtn).append(nextBtn);
		prevBtn.fadeOut(10);
		nextBtn.fadeOut(10);
		wrapper.hover(function(){
			prevBtn.fadeIn(200);
			nextBtn.fadeIn(200);
		}, function() {
			prevBtn.fadeOut(10);
			nextBtn.fadeOut(10);
		});	
	}

    /*function processAjaxData(response, urlPath){
        document.getElementById("content").innerHTML = response.html;
        document.title = response.pageTitle;
        window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
    }*/

	if($('.content-list').children('.box5').length > 5){
		$('.content-list').carouFredSel({
			scroll : {
	            items           : 3,
	            duration        : 1000,                  
	            pauseOnHover    : true
	        },
	        prev: '#prev-scroll',
			next: '#next-scroll',
	        auto: {
	        	timeoutDuration: 5000
	        }
		});
		setTimeout(function(){
			initScroll();		
		}, 1000);
	}
	if($('.content-list').children('.box3').length > 3){
		$('.content-list').carouFredSel({
			scroll : {
	            items           : 3,
	            duration        : 1000,                         
	            pauseOnHover    : true
	        },
	        prev: '#prev-scroll',
			next: '#next-scroll',
	        auto: {
	        	timeoutDuration: 5000
	        }
		});
		setTimeout(function(){
			initScroll();
		}, 1000);
	}
	
	//Intro popup:
	var introPopup = $('.popup-intro').first();
	if(introPopup.length > 0) {
		var hrefTo = '#' + introPopup.attr('id');
		if(hrefTo == '#popup-video'){
			$.colorbox({
					width:"900px",
					height:"600px",
					inline:true, 
					href: hrefTo,
					onClosed: function() {
						$('.popup-intro').remove();
					},
					onComplete: function(){
						$('#cboxLoadedContent .popup-intro').makeCustomScroll(false);
					}
				}
			);
		}else if(hrefTo == '#popup-slide-image') {
			//Slider:			
			$.colorbox({
					width:"900px",
					height:"515px",
					inline:true, 
					href: hrefTo,
					onLoad: function() {
						$('#slider').nivoSlider({
							pauseOnHover: true,
							pauseTime: 4000
						});
					},
					onClosed: function() {
						$('.popup-intro').remove();
					}
				}
			);
		}else {
			introPopup.height(550).css({'overflow-y':'auto', 'margin-top':'10px'});
			$.colorbox({
					width:"900px",
					height:"630px",
					inline:true, 
					href: hrefTo,
					onClosed: function() {
						$('.popup-intro').remove();
					},
					onComplete: function(){
						introPopup.makeCustomScroll(false);
						$('#cboxLoadedContent').css('overflow', 'hidden');
					}
				}
			);
		}
	}
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
							suc_msg.slideDown(200).delay(2000).slideUp(200, function(){
								$.colorbox.close();
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