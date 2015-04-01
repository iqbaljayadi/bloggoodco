/*  ----------------------------------------------------------------------------
 tagDiv live css compiler ( 2013 )
 - this script is used on our demo site to customize the theme live
 - not used on production sites
 */


/*  ----------------------------------------------------------------------------
 On load
 */
jQuery().ready(function() {
    jQuery("#td-theme-set-hide").click(function(event){
        event.preventDefault();
        event.stopPropagation();
        jQuery('#td-theme-settings').addClass('td-theme-settings-small');
    });


    jQuery("#td-theme-settings").click(function(){
        if (jQuery(this).hasClass('td-theme-settings-small')) {
            jQuery('.td-theme-settings-small').removeClass('td-theme-settings-small');
        }
    });

}); //end on load



/*  ----------------------------------------------------------------------------
    Support functions
 */
//add trim for ie8
if (!String.prototype.trim) {
    String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};
}


function td_create_cookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function td_read_cookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function td_erase_cookie(name) {
    createCookie(name, "", -1);
}





/*  ----------------------------------------------------------------------------
    live css compiler @tagDiv 2013
 */

//the settings object
function td_customizer_setting () {
    this.name = '';
    this.value = '';
}

//the sections object
function td_customizer_css_section() {
    this.name = '';
    this.raw_css = '';
    this.compiled_css = '';
}

//css parser class
function td_custom_css_parser(raw_css) {
    this.raw_css = raw_css;
    this.settings = [];
    this.css_sections = [];
    this.style_element_id = '';
    this.compiled_css = ''; //compiled css
}

//load the settings
td_custom_css_parser.prototype.load_setting_raw = function(name, value){
    if (this.get_css_section(name) === false) {
        var new_setting = new td_customizer_setting();
        new_setting.name = name;
        new_setting.value = value;
        this.settings.push(new_setting);
    } else {
        this.update_setting_value(name, value);
    }
}

//split the css in sections
td_custom_css_parser.prototype.split_into_sections = function(){
    //remove style wrapping
    this.raw_css = this.raw_css.replace(/<style>/gi,'');
    this.raw_css = this.raw_css.replace(/<\/style>/gi,'');

    this.raw_css = this.raw_css.trim();

    //explode the sections
    var css_splits = this.raw_css.split('/*');

    var containing_class = this;
    jQuery.each(css_splits, function(index, css_split) {
        var css_split_parts = css_split.split('*/');
        if (typeof css_split_parts[0] !== "undefined" && typeof css_split_parts[1] !== "undefined") {
            var new_css_section = new td_customizer_css_section();
            new_css_section.name = css_split_parts[0].trim();
            new_css_section.raw_css = css_split_parts[1].trim();
            containing_class.css_sections.push(new_css_section);
        }
    });
}


//get setting value
td_custom_css_parser.prototype.get_setting_value = function(name){
    tmpReturn = false;
    jQuery.each(this.settings, function(index, setting) {
        if (setting.name === name) {
            tmpReturn = setting.value;
            return false; //brake jquery each
        }
    });
    return tmpReturn;
}

//get setting value
td_custom_css_parser.prototype.update_setting_value = function(name, value){
    jQuery.each(this.settings, function(index, setting) {
        if (setting.name === name) {
            setting.value = value;
            return false; //brake jquery each
        }
    });
}


//get css section
td_custom_css_parser.prototype.get_css_section = function(name){
    tmpReturn = false;
    jQuery.each(this.settings, function(index, setting) {
        if (setting.name === name) {
            tmpReturn = setting.value;
            return false; //brake jquery each
        }
    });
    return tmpReturn;
}

//compile each section
td_custom_css_parser.prototype.compile_sections = function(){
    if (typeof this.css_sections !== "undefined" && typeof this.settings !== "undefined") {
        var containing_class = this;
        //console.log('start');

        jQuery.each(this.css_sections, function(index, section) {
            jQuery.each(containing_class.settings, function(index, setting) {
                section.raw_css = str_replace("@" + setting.name, setting.value, section.raw_css);
            });
        });
    }
}

//compile the css
td_custom_css_parser.prototype.compile_css = function(){

    this.split_into_sections();
    this.compile_sections();

    var buffy = '';
    var containing_class = this;

    jQuery.each(this.css_sections, function(index, section) {
        if (section.raw_css !== '' && containing_class.get_setting_value(str_replace("@", '', section.name)) !== false) {
            buffy = buffy + section.raw_css;
        }
    });

    this.compiled_css = buffy;
    //alert(buffy);
}


//inject css
td_custom_css_parser.prototype.inject_css = function(){


    var td_style = document.createElement('style');
    td_style.type = 'text/css';
    td_style.innerHTML = this.compiled_css;
    td_style.setAttribute("id", "td_style_inject");
    if (this.style_element_id === '') {
        //new element


        jQuery('head').append(td_style);
        this.style_element_id = 'td_style_inject';
    } else {
        //update old
        jQuery('#td_style_inject').replaceWith(td_style);
    }
}






var td_style_buffer =
    ' <style> /* @header_color */ .td-header-line, .td-menu-wrap, .td-triangle-left-wrap, .td-triangle-right-wrap, .td-rating-bar-wrap div, .sf-menu ul a:hover, .sf-menu ul .sfHover > a, .sf-menu ul .current-menu-ancestor > a, .sf-menu ul .current-menu-item > a { background-color: @header_color; } /* @header_line_color */ .td-menu-wrap, .td-triangle-left-wrap, .td-triangle-right-wrap { border-bottom: 3px solid @header_line_color; } .sf-menu > li:before { background-color: @header_line_color; } /* @link_color */ a { color: @link_color; } .cur-sub-cat { color:@link_color !important; } /* @link_hover_color */ a:hover { color: @link_hover_color; } </style>';


var td_custom_css_parser = new td_custom_css_parser(td_style_buffer);
td_custom_css_parser.load_setting_raw('header_color', 'red');
td_custom_css_parser.load_setting_raw('header_line_color', 'blue');


td_custom_css_parser.load_setting_raw('link_color', 'pink');

//td_custom_css_parser.compile_css();
//td_custom_css_parser.inject_css();


td_custom_css_parser.load_setting_raw('header_color', 'white');
td_custom_css_parser.load_setting_raw('header_line_color', 'gray');
//td_custom_css_parser.compile_css();
//td_custom_css_parser.inject_css();



//alert(td_custom_css_parser.get_setting_value('link_color'));


//console.log(td_custom_css_parser.settings);
//console.log(td_custom_css_parser.css_sections);


//td_custom_css_parser.load_setting_raw('test');












function str_replace (search, replace, subject, count) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   input by: Oleg Eremeev
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Oleg Eremeev
    // %          note 1: The count parameter must be passed as a string in order
    // %          note 1:  to find a global variable in which the result will be given
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }

    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}