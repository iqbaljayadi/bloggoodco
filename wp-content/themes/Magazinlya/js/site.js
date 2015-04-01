/*
    tagDiv - 2013
    Our portofolio:  http://themeforest.net/user/tagDiv/portfolio
*/






var td_blocks = []; //here we store all the portfolio items for the current page

var td_is_touch_device = !!('ontouchstart' in window);


var td_is_phone_screen = false;

//update is phone screen
if (jQuery(window).width() < 480 || jQuery(window).height() < 480) {
    td_is_phone_screen = true
}


var td_is_iPad = navigator.userAgent.match(/iPad/i) != null;




function td_resize_videos(parent_this) {

    //@todo viemo in content

    //youtube in content
    jQuery(document).find('iframe[src*="youtube.com"]').each(function() {
        var td_video = jQuery(this);
        td_video.attr('width', '100%');
        var td_video_width = td_video.width();
        td_video.css('height', td_video_width * 0.6, 'important');
    })


    jQuery(document).find('iframe[src*="vimeo.com"]').each(function() {
        var td_video = jQuery(this);
        td_video.attr('width', '100%');
        var td_video_width = td_video.width();
        td_video.css('height', td_video_width * 0.6, 'important');
    })

}


/*  ----------------------------------------------------------------------------
    On load
 */
jQuery().ready(function() {

    //add class to body
    if (td_is_iPad) {
        jQuery('body').addClass('ipad-background');
    }

    //resize all the videos if we have them
    td_resize_videos();


    jQuery('.slide-wrap-active-first').addClass('slide-wrap-active');





    /*  ----------------------------------------------------------------------------
        MENU
     */

    jQuery('#td-top-menu .sf-menu').mobileMenu();

    jQuery('#td-top-menu .sf-menu').supersubs({
        minWidth:    10, // minimum width of sub-menus in em units
        maxWidth:    40, // maximum width of sub-menus in em units
        extraWidth:  1 // extra width can ensure lines don't sometimes turn over
    })

    if (td_is_touch_device) {
        //touch
        jQuery('#td-top-menu .sf-menu').superfish({
            delay:300,
            speed:'fast',
            useClick:true
        });
    } else {
        //not touch
        jQuery('#td-top-menu .sf-menu').superfish({
            delay:400,
            speed:200,
            useClick:false,
            animation:   {opacity:'show',height:'show'},
            speed:         'normal',           // speed of the opening animation. Equivalent to second parameter of jQuery’s .animate() method
            speedOut:      'fast'
        });
    }

    //alert(tds_snap_menu);
    // Menu fixed




    //alert(offset.top);

    var td_menu_offset = 165;


    if (tds_header_style === "2") {
        //no header
        td_menu_offset = 0;
    }


    switch(tds_snap_menu) {
        case 'always':
            jQuery('.td-menu-wrap').affix({
                offset: {
                    top: td_menu_offset
                }
            })
            break;
        case 'never':
            // do nothing? :)
            jQuery('.td-menu-wrap').css('position', 'relative'); //css fix
            break;
        default:
            if (jQuery(window).width() > 480 && jQuery(window).height() > 480) {
                jQuery('.td-menu-wrap').affix({
                    offset: {
                        top: td_menu_offset
                    }
                })
            } else {
                jQuery('.td-menu-wrap').css('position', 'relative'); //css fix
            }
    }







    /*  ----------------------------------------------------------------------------
        AJAX pagination next prev
     */

    jQuery(".td-ajax-next-page").click(function(event){
        event.preventDefault();

        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page++;
        ajax_pagination_request(current_block_obj);
    });

    jQuery(".td_ajax-prev-page").click(function(event){
        event.preventDefault();

        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page--;
        ajax_pagination_request(current_block_obj);
    });


    /*  ----------------------------------------------------------------------------
        AJAX pagination load more
     */

    jQuery(".td_ajax_load_more").click(function(event){
        event.preventDefault();
        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page++;
        ajax_pagination_request(current_block_obj, true);
    });


    /*  ----------------------------------------------------------------------------
        AJAX pagination infinite load
     */
    jQuery('.td_ajax_infinite').waypoint(function(direction) {
        if (direction === 'down') {
            //console.log('loading');
            current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

            current_block_obj.td_current_page++;
            ajax_pagination_request(current_block_obj, true, true);
        }

    }, { offset: '110%' });


    /*  ----------------------------------------------------------------------------
        AJAX sub cat filter
     */
    jQuery(".ajax-sub-cat").click(function(event){ //click on an ajax category filter
        event.preventDefault();


        //get the current block id
        var current_block_id = jQuery(this).data('td_block_id');

        //destroy any iossliders to avoid bugs
        jQuery('#' + current_block_id).find('.iosSlider').iosSlider('destroy');;

        //get current block
        current_block_obj = td_getBlockObjById(current_block_id);

        //change cur cat
        current_block_obj.td_cur_cat = jQuery(this).data('cat_id');

        current_block_obj.td_current_page = 1;

        //do request
        ajax_pagination_request(current_block_obj);
    });


//put focus on search box in blog header
    jQuery('#search-button').click(function(){
        jQuery(this).delay(200).queue(function(){
            document.getElementById("td-header-search").focus();
            jQuery(this).dequeue();
        });
    });


    //retina images
    td_retina();

    //colorbox
    jQuery('.td-featured-img').colorbox({
        maxWidth:"95%",
        maxHeight:"95%",
        fixed:true
    });


    //scroll to top
    jQuery().UItoTop({
        easingType: 'easeOutQuart',
        min:500,
        inDelay:600,
        outDelay:400,
        scrollSpeed: 800
    });


}); //end on load



//on resize
jQuery(window).resize(function() {
    td_resize_videos();
});























function slideContentComplete(args) {
    if(!args.slideChanged) return false;
    jQuery(args.currentSlideObject).parent().find('.slide-info-wrap').removeClass('slide-wrap-active');
    jQuery(args.currentSlideObject).children('.slide-info-wrap').addClass('slide-wrap-active');
}

function slideContentLoaded(args) {
    if(!args.slideChanged) return false;

   // console.log('loaded');
    jQuery(args.currentSlideObject).parent().find('.slide-info-wrap').removeClass('slide-wrap-active');
    jQuery(args.currentSlideObject).children('.slide-info-wrap').addClass('slide-wrap-active');
}




function td_getBlockIndex(myID) {
    cnt = 0;
    tmpReturn = 0;
    jQuery.each(td_blocks, function(index, td_block) {
        //console.log("pid = " + portfolioItem.id + "  id = " + parseInt(myID));
        //alert(myID);
        if (td_block.id === myID) {
            tmpReturn = cnt;
            return false; //brake jquery each
        } else {
            cnt++;
        }
    });
    return tmpReturn;
}


function td_getBlockObjById(myID) {
    return td_blocks[td_getBlockIndex(myID)];
}


function td_block() {
    this.id = '';

    this.block_type = 1; //block type id (1-234 etc)

    this.atts = '';
    this.td_cur_cat = '';
    this.td_column_number = '';

    this.td_current_page = 1; //
    this.post_count = 0; //from wp
    this.found_posts = 0; //from wp
    this.max_num_pages = 0; //from wp

}



function ajax_pagination_request(current_block_obj, td_append, td_is_live) {

    //append the content in container instead of replacing it
    td_append = (typeof td_append === "undefined") ? false : td_append;

    //is live? default = false
    td_is_live = (typeof td_is_live === "undefined") ? false : td_is_live;


    //console.log(td_append);

    if(td_is_live === false) {
        ajax_pagination_loading_start(current_block_obj);
    }


    jQuery.ajax({
        type: 'POST',
        url: td_ajax_url,
        data: {
            action: 'td_ajax_block',
            td_atts: current_block_obj.atts,
            td_cur_cat:current_block_obj.td_cur_cat,
            td_block_id:current_block_obj.id,
            td_column_number:current_block_obj.td_column_number,
            td_current_page:current_block_obj.td_current_page,
            block_type:current_block_obj.block_type
        },
        success: function(data, textStatus, XMLHttpRequest){
            //jQuery(this).parent().parent().parent().find('.td_block_inner').html("");
            var td_data_object = jQuery.parseJSON(data); //get the data object

            /*
             td_data_object.td_block_id
             td_data_object.td_data
             td_data_object.td_cur_cat
             */

            //subcategories
            jQuery('.sub-cat-' + td_data_object.td_block_id).removeClass('cur-sub-cat');
            jQuery('#sub-cat-' + td_data_object.td_block_id + '-' + td_data_object.td_cur_cat).addClass('cur-sub-cat');

            //load the content
            if (td_append === true) {
                jQuery('#' + td_data_object.td_block_id).append(td_data_object.td_data); //show content
            } else {

                jQuery('#' + td_data_object.td_block_id).html(td_data_object.td_data); //show content
            }



            if (td_data_object.td_hide_prev === true) {
                jQuery('#prev-page-' + td_data_object.td_block_id).addClass('ajax-page-disabled');
            } else {
                jQuery('#prev-page-' + td_data_object.td_block_id).removeClass('ajax-page-disabled');
            }

            if (td_data_object.td_hide_next === true) {
                jQuery('#next-page-' + td_data_object.td_block_id).addClass('ajax-page-disabled');
            } else {
                jQuery('#next-page-' + td_data_object.td_block_id).removeClass('ajax-page-disabled');
            }


            var  current_block_obj = td_getBlockObjById(td_data_object.td_block_id);
            if (current_block_obj.block_type === 'slide') {
                //make the first slide active (to have caption)
                jQuery('#' + td_data_object.td_block_id + ' .slide-wrap-active-first').addClass('slide-wrap-active');
            }



            //loading effects
            ajax_pagination_loading_end(current_block_obj);

        },
        error: function(MLHttpRequest, textStatus, errorThrown){
            //console.log(errorThrown);
        }
    });
}


function ajax_pagination_loading_start(current_block_obj) {

    var el_cur_td_block_inner = jQuery('#' + current_block_obj.id);

    jQuery('.td-loader-gif').remove(); //remove any remaining loaders


    el_cur_td_block_inner.addClass('td_block_inner_overflow');
    el_cur_td_block_inner.parent().append('<img class="td-loader-gif" src="' + td_get_template_directory_uri + '/images/AjaxLoader.gif" alt=""/>');
    el_cur_td_block_inner.fadeTo('500',0.1, 'easeInOutCubic');

    //auto height => fixed height
    var td_tmp_block_height = el_cur_td_block_inner.height();
    el_cur_td_block_inner.css('height', td_tmp_block_height);
}

function ajax_pagination_loading_end(current_block_obj) {




    jQuery(this).delay(100).queue(function(){


        //jQuery('.td-loader-gif').fadeTo('300',0, 'easeInOutCubic', function(){
            jQuery('.td-loader-gif').remove();
        //});

        jQuery('#' + current_block_obj.id).fadeTo(600, 1, function(){
            jQuery('#' + current_block_obj.id).css('height', 'auto');
            jQuery('.td_block_inner_overflow').removeClass('td_block_inner_overflow');


        });


        jQuery(this).dequeue();
    });

    //refresh waypoints for infinit scroll
    jQuery.waypoints('refresh');
}


/*  ----------------------------------------------------------------------------
 Add retina support
 */

function td_retina() {
    if (window.devicePixelRatio > 1) {
        jQuery('.td-retina').each(function(i) {
            var lowres = jQuery(this).attr('src');
            var highres = lowres.replace(".png", "@2x.png");
            jQuery(this).attr('src', highres);
        });


        //custom logo support
        jQuery('.td-retina-data').each(function(i) {
            jQuery(this).attr('src', jQuery(this).data('retina'));
        });

    }
}
