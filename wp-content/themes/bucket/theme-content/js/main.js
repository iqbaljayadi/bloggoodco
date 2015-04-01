(function($, window, undefined) {

	/* ====== SHARED VARS ====== */

	var phone, touch, ltie9, lteie9, wh, ww, dh, ar, fonts;

	var ua = navigator.userAgent;
	var winLoc = window.location.toString();

	var is_webkit = ua.match(/webkit/i);
	var is_firefox = ua.match(/gecko/i);
	var is_newer_ie = ua.match(/msie (9|([1-9][0-9]))/i);
	var is_older_ie = ua.match(/msie/i) && !is_newer_ie;
	var is_ancient_ie = ua.match(/msie 6/i);
	var is_mobile = ua.match(/mobile/i);
	var is_OSX = (ua.match(/(iPad|iPhone|iPod|Macintosh)/g) ? true : false);

	var nua = navigator.userAgent;
	var is_android = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));

	var useTransform = true;
	var use2DTransform = (ua.match(/msie 9/i) || winLoc.match(/transform\=2d/i));
	var transform;

	// setting up transform prefixes
	var prefixes = {
		webkit: 'webkitTransform',
		firefox: 'MozTransform',
		ie: 'msTransform',
		w3c: 'transform'
	};

	if (useTransform) {
		if (is_webkit) {
			transform = prefixes.webkit;
		} else if (is_firefox) {
			transform = prefixes.firefox;
		} else if (is_newer_ie) {
			transform = prefixes.ie;
		}
	}

	
	
	/* --- DETECT PLATFORM --- */

	function platformDetect(){
		$.support.touch = 'ontouchend' in document;
		var navUA = navigator.userAgent.toLowerCase(),
		navPlat = navigator.platform.toLowerCase();
		
		var isiPhone = navPlat.indexOf("iphone"),
		isiPod = navPlat.indexOf("ipod"),
		isAndroidPhone = navPlat.indexOf("android"),
		safari = (navUA.indexOf('safari') != -1 && navUA.indexOf('chrome') == -1) ? true : false,
		svgSupport = (window.SVGAngle) ? true : false,
		svgSupportAlt = (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")) ? true : false,
		ff3x = (/gecko/i.test(navUA) && /rv:1.9/i.test(navUA)) ? true : false;
		
		phone = (isiPhone > -1 || isiPod > -1 || isAndroidPhone > -1) ? true : false;
		touch = $.support.touch ? true : false;
		ltie9 = $.support.leadingWhitespace ? false : true;
		lteie9 = typeof window.atob === 'undefined' ? true : false;

		var $bod = $('body');
		
		if (touch) {$bod.addClass('touch');}
		if (safari) $bod.addClass('safari');
		if (phone) $bod.addClass('phone');   
	};




	/* --- $outerHTML Plugin --- */

	$.fn.outerHTML = function(){
	 
		// IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
		return (!this.length) ? this : (this[0].outerHTML || (
		  function(el){
			  var div = document.createElement('div');
			  div.appendChild(el.cloneNode(true));
			  var contents = div.innerHTML;
			  div = null;
			  return contents;
		})(this[0]));
	};



	/* --- $DEBOUNCES RESIZE --- */
	
	/* debouncedresize: special jQuery event that happens once after a window resize
	* https://github.com/louisremi/jquery-smartresize
	* Copyright 2012 @louis_remi
	*/
	(function($){var $event=$.event,$special,resizeTimeout;$special=$event.special.debouncedresize={setup:function(){$(this).on("resize",$special.handler);},teardown:function(){$(this).off("resize",$special.handler);},handler:function(event,execAsap){var context=this,args=arguments,dispatch=function(){event.type="debouncedresize";$event.dispatch.apply(context,args);};if(resizeTimeout){clearTimeout(resizeTimeout);}execAsap?dispatch():resizeTimeout=setTimeout(dispatch,$special.threshold);},threshold:150};})(jQuery);



	/* ====== INTERNAL FUNCTIONS ====== */

	/* --- DETECT VIEWPORT SIZE --- */

	function browserSize(){
		wh = $(window).height();
		ww = $(window).width();
		dh = $(document).height();
		ar = ww/wh;
	};


	/* --- Set Query Parameter--- */
	function setQueryParameter(uri, key, value) {
	  var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
	  separator = uri.indexOf('?') !== -1 ? "&" : "?";
	  if (uri.match(re)) {
	    return uri.replace(re, '$1' + key + "=" + value + '$2');
	  }
	  else {
	    return uri + separator + key + "=" + value;
	  }
	}






	/* ====== INITIALIZE ====== */

	function init() {
		
		/* GLOBAL VARS */
		touch = false;
		
		/* GET BROWSER DIMENSIONS */
		browserSize();
		
		/* DETECT PLATFORM */
		platformDetect();

		if (is_android) {
			$('html').addClass('android-browser');
		} else {
			$('html').addClass('no-android-browser');
		}

		/* Retina Logo */
		var is_retina = (window.retina || window.devicePixelRatio > 1);

		if (is_retina && $('.site-logo--image-2x').length) {
			var image = $('.site-logo--image-2x').find('img');

			if (image.data('logo2x') !== undefined) {
				image.attr('src', image.data('logo2x'));
			}
		}

		/* Mega Menu */
		//megaMenusHover();

		/* ONE TIME EVENT HANDLERS */
		//eventHandlersOnce();
		
		/* INSTANTIATE EVENT HANDLERS */
		//eventHandlers();

		/* INSTANTIATE RILOADR (lazy loading and responsive images) */
		//riloadrInit();
		   
	};





	/* ====== ON DOCUMENT READY ====== */

	$(function(){

		/* --- INITIALIZE --- */
		init();

		/* --- CONDITIONAL LOADING --- */
//		loadUp();
//  		$(".tabs__content").css({opacity:0});
		setTimeout(function(){
		  $('html').addClass('document-ready');
		}, 300);
	});


	/* ====== ON RESIZE ====== */
/*
	$(window).on("debouncedresize", function(e){
		slider_billboard();   
	});
*/


	/* ====== ON SCROLL ======  */

	//$(window).scroll(function(e){});

})(jQuery, window);