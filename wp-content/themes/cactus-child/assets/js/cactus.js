jQuery(document).ready(function($){
	
    $(".site-nav-toggle").click(function(){
        $(".site-nav").toggle();
	});
	
	var stickyTop = function(){
		var stickyTop;
		if ($("body.admin-bar").length) {
			if ($(window).width() < 783) stickyTop = 46;
			else stickyTop = 32;
		} 
		else {
			stickyTop = 0;
		}
		
		return stickyTop;
		
	}
	
	$('.main-header').css({ 'top': 0 });
	
	$('.comment-form #submit').addClass('btn-normal');
	$('.comment-reply-link').addClass('pull-right btn-reply');
	
	$('#back-to-top, .back-to-top').click(function() {
		$('html, body').animate({ scrollTop:0 }, '800');
		return false;
	});
	
	if ($(window).width() < 920) {
		$('li.menu-item-has-children').prepend('<div class="menu-expand"></div>');
	}
	else{
		$('.site-nav .menu-expand').remove();
	}
	
	$('.title-box').css({ 'margin-top': $('.main-header').height() });
	
	$(window).resize(function() {
		$('.title-box').css({ 'margin-top': $('.main-header').height() });
		
		if ($(window).width() < 920) {
			//$('li.menu-item-has-children').prepend('<div class="menu-expand"></div>');
		}
		else{
			//$('.site-nav .menu-expand').remove();
		}
	});
	
	$(document).on('click','.site-nav .menu-expand', function(){
		$(this).siblings('ul').slideToggle();
	});
	
});						