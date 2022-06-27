$(document).ready(function(){
	$('input, textarea').placeholder();
	$('input').iCheck();

	isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
	
	if(isMobile){
		$(document).on('click', '#main-menu ul li a', function(e){
			if($(this).parent().find('>ul').length > 0){
				return false;
			}
		});
	}
	
	if($('#title-home .news .list-flash').length <= 0){
		$('#title-home').remove();
	}
	
	if($('#headband img').length <= 0){
		$('#headband').append('<img src="fileadmin/images/DSC_0594.jpg" alt=""/>');
	}
	
	/**** COOKIES BAR ****/
	// $('.cookie-message').cookieBar({
		// path: '/'
	// });
	/**** COOKIES BAR ****/
	
	if($('.wrap-center #right-wrap article >div').length <= 0){
		$('.wrap-center #right-wrap').remove();
	}
	
	var indice = 0;
	$('#main-wrap form .layout2').each(function(e){
		if(indice == 1){
			$(this).after('</div>');
			// $(this).css({paddingRight: 0});
		}
		else{
			$(this).before('<div class="input-flex">');
			// $(this).css({paddingLeft: 0});
		}
		indice++;
		if(indice == 2){indice = 0;}
		$(this).appendTo($(this).prev());
	});
	$('#main-wrap form .layout3').each(function(e){
		if(indice == 0){
			// $(this).css({paddingLeft: 0});
		}
		if(indice == 2){
			// $(this).css({paddingRight: 0});
		}
		indice++;
		if(indice == 3){indice = 0;}
	});
	$('#main-wrap form .layout4').each(function(e){
		if(indice == 0){
			// $(this).css({paddingLeft: 0});
		}
		if(indice == 3){
			// $(this).css({paddingRight: 0});
		}
		indice++;
		if(indice == 4){indice = 0;}
	});
	
	
	/** INPUT FILE NAME **/
	$('.form-std input[type="file"]').change(function(e){
		$(this).parents('.input-file').find('.txt-file').html(e.target.files[0].name+'<br>(Maximum 8Mo)');
		// $(this).parents('.powermail_field').append('<span class="txt">'+e.target.files[0].name+'</span>');
	});
	/** FIN INPUT FILE NAME **/
	
	
	/** FILTER CHECKBOX FORMATION **/
	$('#list-category input').on('ifChecked', function(event){
		$('#list-formation .item.'+$(this).attr('id')).stop().fadeIn();
	});
	$('#list-category input').on('ifUnchecked', function(event){
		$('#list-formation .item.'+$(this).attr('id')).stop().fadeOut();
	});
	/** END FILTER CHECKBOX FORMATION **/
	
	
	
	/** ADD FORMATION/EXPERIENCE **/
	var indexForm = 0;
	var indexExp = 0;
	$(document).on('click', '.form-std .link-add', function(){
		var obj = $(this).parents('.block-script');
		if($(this).parents('.block-script').hasClass('block-diplome')){
			indexForm++;
		}else{
			indexExp++;
		}
		var elementClone = $(this).parents('.input-label').find('.field-hidden').clone();
		if(elementClone.hasClass('field-hidden')){
			elementClone.removeClass('field-hidden').addClass('field-new');
		}
		$(this).parents('.input-label').find('.field-hidden').before(elementClone);
		$(elementClone).find('input, textarea').each(function(){
			var name;
			name = $(this).attr('name');
			if(obj.hasClass('block-diplome')){
				name = name.replace(/\[[0-9]+\]/g, '['+indexForm+']');
			}else{
				name = name.replace(/\[[0-9]+\]/g, '['+indexExp+']');
			}
			$(this).attr('name',name);
			console.log($(this).attr('name'));
		});
		if(indexForm >= 4){
			$('.block-diplome').find('.link-add').remove();
			// return false;
		}
		if(indexExp >= 4){
			$('.block-experience').find('.link-add').remove();
			// return false;
		}
		return false;
	});
	/** FIN ADD FORMATION/EXPERIENCE **/
	
	
	var isIE11 = !!navigator.userAgent.match(/Trident.*rv[ :]*11\./)
	if($.browser['msie'] || isIE11){
		$('html').addClass('ie');
	}
	
	
	/**** SCROLL MENU FIXED ****/
	var positionMenu = $('#main-menu').offset().top;
	$(window).scroll(function(e){
		var st = $(this).scrollTop();
		if($(window).scrollTop() > positionMenu){
			$('body').addClass('scrolled');
		}
		else{
			$('body').removeClass('scrolled');
		}
	});
	/**** FIN SCROLL MENU FIXED ****/
	
	
	/****** SELECT $ UI ******/
	$('select').selectmenu({
		create: function( event, ui ) {
			$(this).after($('#'+$(this).attr('id')+'-menu').parent());
		}
	});
	/****** SELECT $ UI ******/
	
	
	/****** DATEPICKER $ UI ******/
	$('.datepicker').datepicker({
		autoSize: false,
		dayNames: [ "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche" ],
		dayNamesMin: [ "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim" ],
		monthNames: [ "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre" ],
		monthNamesShort: [ "Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec" ],
		showOtherMonths: true,
		dateFormat: "dd/mm/yy",
		firstDay: 1
	});
	/****** DATEPICKER $ UI ******/
		

	/****** UNVEIL ******/
	/*$(function() {
		if($(".loading-img").size()>0){
			$(".loading-img img").unveil(3000, function(){});
		}
    });*/
	$(function() {
		if($(".loading-img").size()>0){
			$('.loading-img img').lazy({
				// works even for 'srcset' entries
				imageBase: '',
				afterLoad: function(element) {
					$('#header').css({
						height : $('#background-header .ce-column:first img').height()+"px"
					});
				},
			});
		}
    });
	/****** FIN UNVEIL ******/	

	/****** SLIDER WEBCAM ******/
	if($(".list-flash.owl-carousel").length > 0){
		slideshow_home = $(".list-flash.owl-carousel").owlCarousel({
			items : 1,
			autoplay: true,
			autoplayTimeout: 5000,
			navigation : true, // Show next and prev buttons
			singleItem:false,
			autoplayHoverPause: true,
			addClassActive: true,
			autoHeight: false,
			nav: false,
			dots: false,
			autoplaySpeed: 1000,
			slideSpeed: 1000,
			navSpeed: 1000,
			dotsSpeed: 1000,
			dragEndSpeed: 1000,
			loop: true,
			mouseDrag: true
		});
		setTimeout(function(){
			slideshow_home.trigger('refresh.owl.carousel');
		},100);
	}
	/****** FIN SLIDER WEBCAM ******/
	
	/****** SLIDER NEWS ******/
	if($(".slideshow-news .owl-carousel").length > 0){
		slideshow_news = $(".slideshow-news .owl-carousel").owlCarousel({
			items : 1,
			autoplay: true,
			autoplayTimeout: 5000,
			navigation : true, // Show next and prev buttons
			singleItem:false,
			autoplayHoverPause: true,
			addClassActive: true,
			autoHeight: true,
			nav: true,
			dots: false,
			autoplaySpeed: 1000,
			slideSpeed: 1000,
			navSpeed: 1000,
			dotsSpeed: 1000,
			dragEndSpeed: 1000,
			loop: true,
			mouseDrag: true
		});
		setTimeout(function(){
			slideshow_news.trigger('refresh.owl.carousel');
		},100);
	}
	/****** FIN SLIDER NEWS ******/
	
	$(document).on('click', '.ui-widget-overlay', function(){
		$('.ui-dialog .lightbox-std, .ui-dialog .csc-textpic-imagewrap').dialog('destroy');
	});
	
	$(document).on('click', '#wrap .menu-typo >ul >li >a', function(){
		if($(this).parent().find('>ul').length > 0){
			$('#wrap .menu-typo >ul >li >ul').stop().slideUp('normal');
			if($(this).parent().hasClass('active')){
				$(this).parent().removeClass('active');
			}
			else{
				$('#wrap .menu-typo >ul >li').removeClass('active');
				$(this).parent().addClass('active');
			}
			$(this).parent().find('>ul').stop().slideToggle('normal');
			return false;
		}
	});
	
	$('#main-menu .content-menu').height($(window).height() - $('header').height());
				
	$('.go-top').click(function(){
		$('html, body').stop().animate({scrollTop: 0});
	});
	
	$('.link-dialog').click(function(){
		dialog($(this));
		return false;
	});
	
	
	$(document).on('click', '#top-home .menu .submenu >ul >li >a', function(e){
		if($(this).parent().hasClass('submenu-item')){
			return false;
		}
	});
});

$(window).on('load', function (e) {
	
	$('.loading-img').each(function(){
		$(this).removeClass('loading-img');
	});

	
	if ( window.addEventListener ) {
        window.addEventListener( 'resize', redimensionnement, false );
    } else if ( window.attachEvent ) {
        window.attachEvent( 'onresize', redimensionnement );
		
    } else {
        window['onresize']=redimensionnement;
    }
	redimensionnement();
});


function redimensionnement(e){
	/*$('#wrap #slideshow1 .image').each(function(){
		$(this).find('img').centerImage();
	});*/
	position_footer();
	//console.log(document.documentElement.clientWidth);
}

function position_footer(){
	/****** POSITION FOOTER ******/
	if($('footer').offset().top + $('footer').outerHeight(true) >= $(window).height()){
		$('footer').removeClass('fixed');
	}
	if($('footer').offset().top + $('footer').outerHeight(true) < $(window).height()){
		$('footer').addClass('fixed');
	}
	/****** FIN POSITION FOOTER ******/
}

function dialog(div){
	if($('.ui-widget-overlay')){$('.ui-widget-overlay').hide();}
	$('#'+div.attr('data-dialog')).removeClass('hidden');
	$('#'+div.attr('data-dialog')).dialog({
		modal: true,
		autoOpen: true,
		resizable: false,
		draggable: false,
                show: { effect: "fadeIn", duration: 200 },
		open: function(){		
		}
	});
    return false;
}

function menu_mobile(){
	
	if(isMobile){
		var eventTouch = 'touchend';
	}else{
		var eventTouch = 'click';
	}
	
	$('#main-menu ul li').each(function(){
		if($(this).find('>ul').length > 0){
			$(this).addClass('submenu');
		}
	});
	
	$(document).on('click', '#main-menu .mobile-menu', function(e){
		if(!$('#main-menu').hasClass('active')){
			$('#main-menu, body').addClass('active');
			$('#main-menu nav').stop().slideDown('normal');
		}
		else{
			$('#main-menu, body').removeClass('active');
			$('#main-menu nav').stop().slideUp('normal');
			$('#main-menu nav >ul >li >ul').stop().slideUp('normal');
		}
		$('#main-menu nav >ul >li').removeClass('active');
		return false;
	});
	
	$(document).on(eventTouch, '#main-menu nav >ul >li .content >a', function(e){
		if($(this).parent().find('.submenu-menu').length > 0){
			if(!$(this).parent().parent().hasClass('active')){
				$(this).parent().parent().addClass('active');
				$('#main-menu nav >ul >li .submenu-menu').stop().slideUp('normal');
				$(this).parent().find('.submenu-menu').stop().slideDown('normal');
			}
			else{
				$('#main-menu nav >ul >li').removeClass('active');
				$('#main-menu nav >ul >li .submenu-menu').stop().slideUp('normal');
			}
			return false;
		}
	});
	$(document).on(eventTouch, '#top-home .menu .link >a', function(e){
		$('#top-home .menu .link .submenu').hide();
		$(this).parent().find('.submenu').show();
		return false;
	});
	$(document).on(eventTouch, '#top-home .menu .submenu >ul >li >a', function(e){
		if($(this).parent().hasClass('submenu-item')){
			if(!$(this).parent().hasClass('active')){
				$(this).parent().addClass('active');
				$('#top-home .menu .submenu >ul >li >ul').stop().slideUp('normal');
				$(this).parent().find('>ul').stop().slideDown('normal');
			}else{
				$('#top-home .menu .submenu >ul >li').removeClass('active');
				$('#top-home .menu .submenu >ul >li >ul').stop().slideUp('normal');
			}
			return false;
		}
	});
}

