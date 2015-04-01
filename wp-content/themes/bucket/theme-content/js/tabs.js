(function($, window, undefined) {
	/* --- ORGANIC TABS --- */

	// --- MODIFIED
	// https://github.com/CSS-Tricks/jQuery-Organic-Tabs
	$.organicTabs = function (el, options) {
	var base = this;
	base.$el = $(el);
	base.$nav = base.$el.find(".tabs__nav");
	base.init = function () {
		base.options = $.extend({}, $.organicTabs.defaultOptions, options);
		var $allListWrap = base.$el.find(".tabs__content"),
			curList = base.$el.find("a.current").attr("href").substring(1);
		$allListWrap.height(base.$el.find("#" + curList).height());
		base.$nav.find("li > a").click(function(event) {
			
			var curList = base.$el.find("a.current").attr("href").substring(1),
				$newList = $(this),
				listID = $newList.attr("href").substring(1);
			if ((listID != curList) && (base.$el.find(":animated").length == 0)) {
				base.$el.find("#" + curList).css({
					opacity: 0,
					"z-index": 10
				});
				var newHeight = base.$el.find("#" + listID).height();
				$allListWrap.css({
					height: newHeight
				});
				setTimeout(function () {
					base.$el.find("#" + curList);
					base.$el.find("#" + listID).css({
						opacity: 1,
						"z-index": 20
					});
					base.$el.find(".tabs__nav li a").removeClass("current");
					$newList.addClass("current");
				}, 250);
			}
			event.preventDefault();
		});
	};
	base.init();
	};
	$.organicTabs.defaultOptions = {
		speed: 300
	};
	$.fn.organicTabs = function (options) {
		return this.each(function () {
			(new $.organicTabs(this, options));
		});
	};
	
	function popularPostsWidget() {
		$('.wpgrade_popular_posts, .pixcode--tabs').organicTabs();
	}
	
	/* ====== ON DOCUMENT READY ====== */

	$(function(){
		/* --- CONDITIONAL LOADING --- */
  		$(".tabs__content").css({opacity:0});
		setTimeout(function(){
		  $('html').addClass('document-ready');
		}, 300);
	});

	/* ====== ON WINDOW LOAD ====== */
	$(window).load(function(){
		setTimeout(function() { popularPostsWidget(); $(".tabs__content").css({opacity:1}); },1000);
	});


})(jQuery, window);