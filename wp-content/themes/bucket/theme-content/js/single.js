(function($, window, undefined) {
	
	//scan through the post meta tags and try to find the post image
	function getArticleImage() { 
		var metas = document.getElementsByTagName('meta'); 

		for (i=0; i<metas.length; i++) { 
		   if (metas[i].getAttribute("property") == "og:image") { 
			  return metas[i].getAttribute("content"); 
		   } else if (metas[i].getAttribute("property") == "image") { 
			  return metas[i].getAttribute("content");  
		   } else if (metas[i].getAttribute("property") == "twitter:image:src") { 
			  return metas[i].getAttribute("content");  
		   }
		}

		return "";
	}
	
	/* --- $AUTORESIZE TEXTAREA --- */

	/* Autosize v1.18.1 - 2013-11-05
	* Automatically adjust textarea height based on user input.
	* (c) 2013 Jack Moore - http://www.jacklmoore.com/autosize
	* license: http://www.opensource.org/licenses/mit-license.php
	*/
	(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

	 /* --- $SHARRRE --- */

	 /*  Sharrre.com - Make your sharing widget!
	 *  Version: beta 1.3.5
	 *  Author: Julien Hany
	 *  License: MIT http://en.wikipedia.org/wiki/MIT_License or GPLv2 http://en.wikipedia.org/wiki/GNU_General_Public_License
	 */
	 (function($,window,document,undefined){var pluginName="sharrre",defaults={className:"sharrre",share:{googlePlus:false,facebook:false,twitter:false,digg:false,delicious:false,stumbleupon:false,linkedin:false,pinterest:false},shareTotal:0,template:"",title:"",url:document.location.href,text:document.title,urlCurl:sharrre_urlCurl,count:{},total:0,shorterTotal:true,enableHover:true,enableCounter:true,enableTracking:false,hover:function(){},hide:function(){},click:function(){},render:function(){},buttons:{googlePlus:{url:"",urlCount:false,size:"medium",lang:"en-US",annotation:""},facebook:{url:"",urlCount:false,action:"like",layout:"button_count",width:"",send:"false",faces:"false",colorscheme:"",font:"",lang:"en_US"},twitter:{url:"",urlCount:false,count:"horizontal",hashtags:"",via:"",related:"",lang:"en"},digg:{url:"",urlCount:false,type:"DiggCompact"},delicious:{url:"",urlCount:false,size:"medium"},stumbleupon:{url:"",urlCount:false,layout:"1"},linkedin:{url:"",urlCount:false,counter:""},pinterest:{url:"",media:"",description:"",layout:"horizontal"}}},urlJson={googlePlus:"",facebook:"https://graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=%27{url}%27&callback=?",twitter:"http://cdn.api.twitter.com/1/urls/count.json?url={url}&callback=?",digg:"http://services.digg.com/2.0/story.getInfo?links={url}&type=javascript&callback=?",delicious:"http://feeds.delicious.com/v2/json/urlinfo/data?url={url}&callback=?",stumbleupon:"",linkedin:"http://www.linkedin.com/countserv/count/share?format=jsonp&url={url}&callback=?",pinterest:"http://api.pinterest.com/v1/urls/count.json?url={url}&callback=?"},loadButton={googlePlus:function(self){var sett=self.options.buttons.googlePlus;$(self.element).find(".buttons").append('<div class="button googleplus"><div class="g-plusone" data-size="'+sett.size+'" data-href="'+(sett.url!==""?sett.url:self.options.url)+'" data-annotation="'+sett.annotation+'"></div></div>');window.___gcfg={lang:self.options.buttons.googlePlus.lang};var loading=0;if(typeof gapi==="undefined"&&loading==0){loading=1;(function(){var po=document.createElement("script");po.type="text/javascript";po.async=true;po.src="//apis.google.com/js/plusone.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(po,s);})();}else{gapi.plusone.go();}},facebook:function(self){var sett=self.options.buttons.facebook;$(self.element).find(".buttons").append('<div class="button facebook"><div id="fb-root"></div><div class="fb-like" data-href="'+(sett.url!==""?sett.url:self.options.url)+'" data-send="'+sett.send+'" data-layout="'+sett.layout+'" data-width="'+sett.width+'" data-show-faces="'+sett.faces+'" data-action="'+sett.action+'" data-colorscheme="'+sett.colorscheme+'" data-font="'+sett.font+'" data-via="'+sett.via+'"></div></div>');var loading=0;if(typeof FB==="undefined"&&loading==0){loading=1;(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return;}js=d.createElement(s);js.id=id;js.src="//connect.facebook.net/"+sett.lang+"/all.js#xfbml=1";fjs.parentNode.insertBefore(js,fjs);}(document,"script","facebook-jssdk"));}else{FB.XFBML.parse();}},twitter:function(self){var sett=self.options.buttons.twitter;$(self.element).find(".buttons").append('<div class="button twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'+(sett.url!==""?sett.url:self.options.url)+'" data-count="'+sett.count+'" data-text="'+self.options.text+'" data-via="'+sett.via+'" data-hashtags="'+sett.hashtags+'" data-related="'+sett.related+'" data-lang="'+sett.lang+'">Tweet</a></div>');var loading=0;if(typeof twttr==="undefined"&&loading==0){loading=1;(function(){var twitterScriptTag=document.createElement("script");twitterScriptTag.type="text/javascript";twitterScriptTag.async=true;twitterScriptTag.src="//platform.twitter.com/widgets.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(twitterScriptTag,s);})();}else{$.ajax({url:"//platform.twitter.com/widgets.js",dataType:"script",cache:true});}},digg:function(self){var sett=self.options.buttons.digg;$(self.element).find(".buttons").append('<div class="button digg"><a class="DiggThisButton '+sett.type+'" rel="nofollow external" href="http://digg.com/submit?url='+encodeURIComponent((sett.url!==""?sett.url:self.options.url))+'"></a></div>');var loading=0;if(typeof __DBW==="undefined"&&loading==0){loading=1;(function(){var s=document.createElement("SCRIPT"),s1=document.getElementsByTagName("SCRIPT")[0];s.type="text/javascript";s.async=true;s.src="//widgets.digg.com/buttons.js";s1.parentNode.insertBefore(s,s1);})();}},delicious:function(self){if(self.options.buttons.delicious.size=="tall"){var css="width:50px;",cssCount="height:35px;width:50px;font-size:15px;line-height:35px;",cssShare="height:18px;line-height:18px;margin-top:3px;";}else{var css="width:93px;",cssCount="float:right;padding:0 3px;height:20px;width:26px;line-height:20px;",cssShare="float:left;height:20px;line-height:20px;";}var count=self.shorterTotal(self.options.count.delicious);if(typeof count==="undefined"){count=0;}$(self.element).find(".buttons").append('<div class="button delicious"><div style="'+css+'font:12px Arial,Helvetica,sans-serif;cursor:pointer;color:#666666;display:inline-block;float:none;height:20px;line-height:normal;margin:0;padding:0;text-indent:0;vertical-align:baseline;"><div style="'+cssCount+'background-color:#fff;margin-bottom:5px;overflow:hidden;text-align:center;border:1px solid #ccc;border-radius:3px;">'+count+'</div><div style="'+cssShare+'display:block;padding:0;text-align:center;text-decoration:none;width:50px;background-color:#7EACEE;border:1px solid #40679C;border-radius:3px;color:#fff;"><img src="http://www.delicious.com/static/img/delicious.small.gif" height="10" width="10" alt="Delicious" /> Add</div></div></div>');$(self.element).find(".delicious").on("click",function(){self.openPopup("delicious");});},stumbleupon:function(self){var sett=self.options.buttons.stumbleupon;$(self.element).find(".buttons").append('<div class="button stumbleupon"><su:badge layout="'+sett.layout+'" location="'+(sett.url!==""?sett.url:self.options.url)+'"></su:badge></div>');var loading=0;if(typeof STMBLPN==="undefined"&&loading==0){loading=1;(function(){var li=document.createElement("script");li.type="text/javascript";li.async=true;li.src="//platform.stumbleupon.com/1/widgets.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(li,s);})();s=window.setTimeout(function(){if(typeof STMBLPN!=="undefined"){STMBLPN.processWidgets();clearInterval(s);}},500);}else{STMBLPN.processWidgets();}},linkedin:function(self){var sett=self.options.buttons.linkedin;$(self.element).find(".buttons").append('<div class="button linkedin"><script type="in/share" data-url="'+(sett.url!==""?sett.url:self.options.url)+'" data-counter="'+sett.counter+'"><\/script></div>');var loading=0;if(typeof window.IN==="undefined"&&loading==0){loading=1;(function(){var li=document.createElement("script");li.type="text/javascript";li.async=true;li.src="//platform.linkedin.com/in.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(li,s);})();}else{window.IN.init();}},pinterest:function(self){var sett=self.options.buttons.pinterest;$(self.element).find(".buttons").append('<div class="button pinterest"><a href="http://pinterest.com/pin/create/button/?url='+(sett.url!==""?sett.url:self.options.url)+"&media="+sett.media+"&description="+sett.description+'" class="pin-it-button" count-layout="'+sett.layout+'">Pin It</a></div>');(function(){var li=document.createElement("script");li.type="text/javascript";li.async=true;li.src="//assets.pinterest.com/js/pinit.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(li,s);})();}},tracking={googlePlus:function(){},facebook:function(){fb=window.setInterval(function(){if(typeof FB!=="undefined"){FB.Event.subscribe("edge.create",function(targetUrl){_gaq.push(["_trackSocial","facebook","like",targetUrl]);});FB.Event.subscribe("edge.remove",function(targetUrl){_gaq.push(["_trackSocial","facebook","unlike",targetUrl]);});FB.Event.subscribe("message.send",function(targetUrl){_gaq.push(["_trackSocial","facebook","send",targetUrl]);});clearInterval(fb);}},1000);},twitter:function(){tw=window.setInterval(function(){if(typeof twttr!=="undefined"){twttr.events.bind("tweet",function(event){if(event){_gaq.push(["_trackSocial","twitter","tweet"]);}});clearInterval(tw);}},1000);},digg:function(){},delicious:function(){},stumbleupon:function(){},linkedin:function(){function LinkedInShare(){_gaq.push(["_trackSocial","linkedin","share"]);}},pinterest:function(){}},popup={googlePlus:function(opt){window.open("https://plus.google.com/share?hl="+opt.buttons.googlePlus.lang+"&url="+encodeURIComponent((opt.buttons.googlePlus.url!==""?opt.buttons.googlePlus.url:opt.url)),"","toolbar=0, status=0, width=900, height=500");},facebook:function(opt){window.open("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent((opt.buttons.facebook.url!==""?opt.buttons.facebook.url:opt.url))+"&t="+opt.text+"","","toolbar=0, status=0, width=900, height=500");},twitter:function(opt){window.open("https://twitter.com/intent/tweet?text="+encodeURIComponent(opt.text)+"&url="+encodeURIComponent((opt.buttons.twitter.url!==""?opt.buttons.twitter.url:opt.url))+(opt.buttons.twitter.via!==""?"&via="+opt.buttons.twitter.via:""),"","toolbar=0, status=0, width=650, height=360");},digg:function(opt){window.open("http://digg.com/tools/diggthis/submit?url="+encodeURIComponent((opt.buttons.digg.url!==""?opt.buttons.digg.url:opt.url))+"&title="+opt.text+"&related=true&style=true","","toolbar=0, status=0, width=650, height=360");},delicious:function(opt){window.open("http://www.delicious.com/save?v=5&noui&jump=close&url="+encodeURIComponent((opt.buttons.delicious.url!==""?opt.buttons.delicious.url:opt.url))+"&title="+opt.text,"delicious","toolbar=no,width=550,height=550");},stumbleupon:function(opt){window.open("http://www.stumbleupon.com/badge/?url="+encodeURIComponent((opt.buttons.delicious.url!==""?opt.buttons.delicious.url:opt.url)),"stumbleupon","toolbar=no,width=550,height=550");},linkedin:function(opt){window.open("https://www.linkedin.com/cws/share?url="+encodeURIComponent((opt.buttons.delicious.url!==""?opt.buttons.delicious.url:opt.url))+"&token=&isFramed=true","linkedin","toolbar=no,width=550,height=550");},pinterest:function(opt){window.open("http://pinterest.com/pin/create/button/?url="+encodeURIComponent((opt.buttons.pinterest.url!==""?opt.buttons.pinterest.url:opt.url))+"&media="+encodeURIComponent(opt.buttons.pinterest.media)+"&description="+opt.buttons.pinterest.description,"pinterest","toolbar=no,width=700,height=300");}};function Plugin(element,options){this.element=element;this.options=$.extend(true,{},defaults,options);this.options.share=options.share;this._defaults=defaults;this._name=pluginName;this.init();}Plugin.prototype.init=function(){var self=this;if(this.options.urlCurl!==""){urlJson.googlePlus=this.options.urlCurl+"?url={url}&type=googlePlus";urlJson.stumbleupon=this.options.urlCurl+"?url={url}&type=stumbleupon";}$(this.element).addClass(this.options.className);if(typeof $(this.element).data("title")!=="undefined"){this.options.title=$(this.element).attr("data-title");}if(typeof $(this.element).data("url")!=="undefined"){this.options.url=$(this.element).data("url");}if(typeof $(this.element).data("text")!=="undefined"){this.options.text=$(this.element).data("text");}$.each(this.options.share,function(name,val){if(val===true){self.options.shareTotal++;}});if(self.options.enableCounter===true){$.each(this.options.share,function(name,val){if(val===true){try{self.getSocialJson(name);}catch(e){}}});}else{if(self.options.template!==""){this.options.render(this,this.options);}else{this.loadButtons();}}$(this.element).hover(function(){if($(this).find(".buttons").length===0&&self.options.enableHover===true){self.loadButtons();}self.options.hover(self,self.options);},function(){self.options.hide(self,self.options);});$(this.element).click(function(event){self.options.click(self,self.options);event.preventDefault();});};Plugin.prototype.loadButtons=function(){var self=this;$(this.element).append('<div class="buttons"></div>');$.each(self.options.share,function(name,val){if(val==true){loadButton[name](self);if(self.options.enableTracking===true){tracking[name]();}}});};Plugin.prototype.getSocialJson=function(name){var self=this,count=0,url=urlJson[name].replace("{url}",encodeURIComponent(this.options.url));if(this.options.buttons[name].urlCount===true&&this.options.buttons[name].url!==""){url=urlJson[name].replace("{url}",this.options.buttons[name].url);}if(url!=""&&self.options.urlCurl!==""){$.getJSON(url,function(json){if(typeof json.count!=="undefined"){var temp=json.count+"";temp=temp.replace("\u00c2\u00a0","");count+=parseInt(temp,10);}else{if(json.data&&json.data.length>0&&typeof json.data[0].total_count!=="undefined"){count+=parseInt(json.data[0].total_count,10);}else{if(typeof json[0]!=="undefined"){count+=parseInt(json[0].total_posts,10);}else{if(typeof json[0]!=="undefined"){}}}}self.options.count[name]=count;self.options.total+=count;self.renderer();self.rendererPerso();}).error(function(){self.options.count[name]=0;self.rendererPerso();});}else{self.renderer();self.options.count[name]=0;self.rendererPerso();}};Plugin.prototype.rendererPerso=function(){var shareCount=0;for(e in this.options.count){shareCount++;}if(shareCount===this.options.shareTotal){this.options.render(this,this.options);}};Plugin.prototype.renderer=function(){var total=this.options.total,template=this.options.template;if(this.options.shorterTotal===true){total=this.shorterTotal(total);}if(template!==""){template=template.replace("{total}",total);$(this.element).html(template);}else{$(this.element).html('<div class="box"><a class="count" href="#">'+total+"</a>"+(this.options.title!==""?'<a class="share" href="#">'+this.options.title+"</a>":"")+"</div>");}$(document).trigger("share-box-rendered");};Plugin.prototype.shorterTotal=function(num){if(num>=1000000){num=(num/1000000).toFixed(2)+"M";}else{if(num>=1000){num=(num/1000).toFixed(1)+"k";}}return num;};Plugin.prototype.openPopup=function(site){popup[site](this.options);if(this.options.enableTracking===true){var tracking={googlePlus:{site:"Google",action:"+1"},facebook:{site:"facebook",action:"like"},twitter:{site:"twitter",action:"tweet"},digg:{site:"digg",action:"add"},delicious:{site:"delicious",action:"add"},stumbleupon:{site:"stumbleupon",action:"add"},linkedin:{site:"linkedin",action:"share"},pinterest:{site:"pinterest",action:"pin"}};_gaq.push(["_trackSocial",tracking[site].site,tracking[site].action]);}};Plugin.prototype.simulateClick=function(){var html=$(this.element).html();$(this.element).html(html.replace(this.options.total,this.options.total+1));};Plugin.prototype.update=function(url,text){if(url!==""){this.options.url=url;}if(text!==""){this.options.text=text;}};$.fn[pluginName]=function(options){var args=arguments;if(options===undefined||typeof options==="object"){return this.each(function(){if(!$.data(this,"plugin_"+pluginName)){$.data(this,"plugin_"+pluginName,new Plugin(this,options));}});}else{if(typeof options==="string"&&options[0]!=="_"&&options!=="init"){return this.each(function(){var instance=$.data(this,"plugin_"+pluginName);if(instance instanceof Plugin&&typeof instance[options]==="function"){instance[options].apply(instance,Array.prototype.slice.call(args,1));}});}}};})(jQuery,window,document);
	 
	// Calculate total shares
	var shareTypes = 0;

	function shareBox() {
		//get the via username for twitter share
		var twitterVia = $('.sbt_twitter').data('via');
		
		$('.sbt_twitter').sharrre({
			share: {
			  twitter: true
			},
			template: '<div class="share-item__icon"><i class="pixcode pixcode--icon icon-e-twitter"></i></div>',
			enableHover: false,
			enableTracking: false,
			shorterTotal: false,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('twitter');
			},
			buttons: {
				twitter: {via: twitterVia}
			}
		}).each(function() { shareTypes++; });

		$('.sbt_facebook').sharrre({
		  share: {
			facebook: true
		  },
		  template: '<div class="share-item__icon"><i class="pixcode pixcode--icon icon-e-facebook"></i></div>',
		  enableHover: false,
		  enableTracking: false,
		  shorterTotal: false,
		  click: function(api, options){
			api.simulateClick();
			api.openPopup('facebook');
		  }
		}).each(function() { shareTypes++; });
		
		$('.sbt_linkedin').sharrre({
		  share: {
			linkedin: true
		  },
		  template: '<div class="share-item__icon"><i class="pixcode pixcode--icon icon-e-linkedin"></i></div>',
		  enableHover: false,
		  enableTracking: false,
		  shorterTotal: false,
		  click: function(api, options){
			api.simulateClick();
			api.openPopup('linkedin');
		  }
		}).each(function() { shareTypes++; });
		
		$('.sbt_gplus').sharrre({
			share: {
				googlePlus: true
			},
			template: '<div class="share-item__icon"><i class="pixcode pixcode--icon icon-e-gplus"></i></div>',
			enableHover: false,
			enableTracking: false,
			shorterTotal: false,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('googlePlus');
			}
		}).each(function() { shareTypes++; });
		
		$('.sbt_pinterest').sharrre({
			share: {
				pinterest: true
			},
			template: '<div class="share-item__icon"><i class="pixcode pixcode--icon icon-e-pinterest"></i></div>',
			enableHover: false,
			enableTracking: false,
			shorterTotal: false,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('pinterest');
			},
			buttons: {
				pinterest: {
					media: getArticleImage(),
					description: $('#pinterest').data('text')
				} 
			}
		}).each(function() { shareTypes++; });
		
	}

	$('#share-box .share-total__value').sharrre({
	  share: {
		facebook: true,
		twitter: true,
		linkedin: true,
		pinterest: true,
		googlePlus: true
	  },
	  template: '{total}',
	  enableTracking: true,
	  enableHover: false
	});
	
	/* format total numbers like 1.2k or 5M
	 ================================================== */
	var wpgrade_shorterTotal = function (num) {
		if (num >= 1e6){
			num = (num / 1e6).toFixed(2) + "M"
		} else if (num >= 1e3){
			num = (num / 1e3).toFixed(1) + "k"
		}
		return num;
	};
	
	$(function(){
		shareBox();	
	
		//Set textareas to autosize
		if($("textarea").length) { $("textarea").autosize(); }
	});
	
})(jQuery, window);