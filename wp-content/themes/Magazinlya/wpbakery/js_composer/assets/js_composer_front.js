jQuery(window).load(function(){jQuery(".wpb_flexslider").each(function(){var a=jQuery(this),b=1E3*parseInt(a.attr("data-interval")),c=a.attr("data-flex_fx"),d=!0;0==b&&(d=!1);a.flexslider({animation:c,slideshow:d,slideshowSpeed:b,sliderSpeed:800,smoothHeight:!0})})});jQuery(document).ready(function(){vc_twitterBehaviour();vc_toggleBehaviour();vc_tabsBehaviour();vc_accordionBehaviour();vc_teaserGrid();vc_carouselBehaviour();vc_slidersBehaviour();vc_prettyPhoto();vc_googleplus();vc_pinterest()});
if("function"!==typeof window.vc_twitterBehaviour)var vc_twitterBehaviour=function(){jQuery(".wpb_twitter_widget .tweets").each(function(){var a=jQuery(this),b=a.attr("data-tw_name");tw_count=a.attr("data-tw_count");a.tweet({username:b,join_text:"auto",avatar_size:0,count:tw_count,template:"{avatar}{join}{text}{time}",auto_join_text_default:"",auto_join_text_ed:"",auto_join_text_ing:"",auto_join_text_reply:"",auto_join_text_url:"",loading_text:'<span class="loading_tweets">loading tweets...</span>'})})};
if("function"!==typeof window.vc_googleplus)var vc_googleplus=function(){if(0<jQuery(".wpb_googleplus").length){var a=document.createElement("script");a.type="text/javascript";a.async=!0;a.src="https://apis.google.com/js/plusone.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)}};
if("function"!==typeof window.vc_pinterest)var vc_pinterest=function(){if(0<jQuery(".wpb_pinterest").length){var a=document.createElement("script");a.type="text/javascript";a.async=!0;a.src="http://assets.pinterest.com/js/pinit.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)}};
if("function"!==typeof window.vc_toggleBehaviour)var vc_toggleBehaviour=function(){jQuery(".wpb_toggle").click(function(){jQuery(this).hasClass("wpb_toggle_title_active")?jQuery(this).removeClass("wpb_toggle_title_active").next().slideUp(500):jQuery(this).addClass("wpb_toggle_title_active").next().slideDown(500)});jQuery(".wpb_toggle_content").each(function(){!1==jQuery(this).next().is("h4.wpb_toggle")&&jQuery('<div class="last_toggle_el_margin"></div>').insertAfter(this)})};
if("function"!==typeof window.vc_tabsBehaviour)var vc_tabsBehaviour=function(){jQuery(".wpb_tabs, .wpb_tour").each(function(){var a,b=jQuery(this).attr("data-interval"),c=[];a=jQuery(this).find(".wpb_tour_tabs_wrapper").tabs({show:function(a,b){wpb_prepare_tab_content(a,b)}}).tabs("rotate",1E3*b);jQuery(this).find(".wpb_tab").each(function(){c.push(this.id)});jQuery(this).find('.wpb_tab a[href^="#"]').click(function(b){b.preventDefault();if(jQuery.inArray(jQuery(this).attr("href"),c))return a.tabs("select",
    jQuery(this).attr("href")),!1});jQuery(this).find(".wpb_prev_slide a, .wpb_next_slide a").click(function(b){b.preventDefault();b=a.tabs("option","selected");jQuery(this).parent().hasClass("wpb_next_slide")?b++:b--;0>b?b=a.tabs("length")-1:b>=a.tabs("length")&&(b=0);a.tabs("select",b)})})};
if("function"!==typeof window.vc_accordionBehaviour)var vc_accordionBehaviour=function(){jQuery(".wpb_accordion").each(function(){jQuery(this).attr("data-interval");jQuery(this).find(".wpb_accordion_wrapper").accordion({header:"> div > h3",autoHeight:!1,change:function(a,b){void 0!=jQuery.fn.isotope&&b.newContent.find(".isotope").isotope("reLayout");vc_carouselBehaviour()}})})};
if("function"!==typeof window.vc_teaserGrid)var vc_teaserGrid=function(){var a={fitrows:"fitRows",masonry:"masonry"};jQuery(".wpb_grid .teaser_grid_container:not(.wpb_carousel), .wpb_filtered_grid .teaser_grid_container:not(.wpb_carousel)").each(function(){var b=jQuery(this),c=b.find(".wpb_thumbnails"),d=c.attr("data-layout-mode");c.isotope({itemSelector:".isotope-item",layoutMode:void 0==a[d]?"fitRows":a[d]});b.find(".categories_filter a").data("isotope",c).click(function(a){a.preventDefault();a=
    jQuery(this).data("isotope");jQuery(this).parent().parent().find(".active").removeClass("active");jQuery(this).parent().addClass("active");a.isotope({filter:jQuery(this).attr("data-filter")})});jQuery(window).load(function(){c.isotope("reLayout")})})};
if("function"!==typeof window.vc_carouselBehaviour)var vc_carouselBehaviour=function(){jQuery(".wpb_carousel").each(function(){var a=jQuery(this);if(!0!==a.data("carousel_enabled")&&a.is(":visible")){a.data("carousel_enabled",!0);jQuery(this).width();var a=getColumnsCount(jQuery(this)),b=500;jQuery(this).hasClass("columns_count_1")&&(b=900);var c=jQuery(this).find(".wpb_thumbnails-fluid li");c.css({"margin-right":c.css("margin-left"),"margin-left":0});jQuery(this).find(".wpb_wrapper:eq(0)").jCarouselLite({btnNext:jQuery(this).find(".next"),
    btnPrev:jQuery(this).find(".prev"),visible:a,speed:b}).width("100%");a=jQuery(this).find("ul.wpb_thumbnails-fluid");a.width(a.width()+300);jQuery(window).resize(function(){var a=screen_size;screen_size=getSizeName();a!=screen_size&&window.setTimeout("location.reload()",20)})}})};
if("function"!==typeof window.vc_slidersBehaviour)var vc_slidersBehaviour=function(){jQuery(".wpb_gallery_slides").each(function(){var a=jQuery(this);if(a.hasClass("wpb_slider_nivo")){var b=1E3*a.attr("data-interval");0==b&&(b=9999999999);a.find(".nivoSlider").nivoSlider({effect:"boxRainGrow,boxRain,boxRainReverse,boxRainGrowReverse",slices:15,boxCols:8,boxRows:4,animSpeed:800,pauseTime:b,startSlide:0,directionNav:!0,directionNavHide:!0,controlNav:!0,keyboardNav:!1,pauseOnHover:!0,manualAdvance:!1,
    prevText:"Prev",nextText:"Next"})}else if(a.hasClass("wpb_flexslider"),a.hasClass("wpb_image_grid")){var c=a.find(".wpb_image_grid_ul");c.isotope({itemSelector:".isotope-item",layoutMode:"fitRows"});jQuery(window).load(function(){c.isotope("reLayout")})}})};
if("function"!==typeof window.vc_prettyPhoto)var vc_prettyPhoto=function(){try{jQuery('a.prettyphoto, .gallery-icon a[href*=".jpg"]').prettyPhoto({animationSpeed:"normal",padding:15,opacity:0.7,showTitle:!0,allowresize:!0,counter_separator_label:"/",hideflash:!1,modal:!1,callback:function(){location.href.indexOf("#!prettyPhoto")&&(location.hash="!")},social_tools:""})}catch(a){}};function getColumnsCount(a){for(var b=1;;){if(a.hasClass("columns_count_"+b))return b;b++}}var screen_size=getSizeName();
function getSizeName(){var a="",b=jQuery(window).width();1170<b?a="desktop_wide":960<b&&1169>b?a="desktop":768<b&&959>b?a="tablet":300<b&&767>b?a="mobile":300>b&&(a="mobile_portrait");return a}function loadScript(a,b,c){var d=document.createElement("script");d.type="text/javascript";d.readyState&&(d.onreadystatechange=function(){if("loaded"==d.readyState||"complete"==d.readyState)d.onreadystatechange=null,c()});d.src=a;b.get(0).appendChild(d)}
function wpb_prepare_tab_content(a,b){vc_carouselBehaviour();var c=jQuery(b.panel).find(".isotope"),d=jQuery(b.panel).find(".wpb_gmaps_widget");0<c.length&&c.isotope("reLayout");d.length&&!d.is(".map_ready")&&(c=d.find("iframe"),c.attr("src",c.attr("src")),d.addClass("map_ready"))};