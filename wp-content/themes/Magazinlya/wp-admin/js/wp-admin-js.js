/*

    tagDiv wp-admin js

 */
jQuery().ready(function() {



    /*  ----------------------------------------------------------------------------
        Sidebar manager
     */
    jQuery('.td_rename').click(function(event){
        event.preventDefault();
        jQuery('.td-modal').hide('fast');
        jQuery(jQuery(this).attr('href')).show('fast');
    });


    jQuery('.td_modal_cancel').click(function(event){
        event.preventDefault();
        jQuery('.td-modal').hide('fast');
    });
});

//@todo
function td_show_element_on_selected(select_el, on_value, show_el) {
    var cur_template = jQuery('#page_template option:selected').text();

    if(cur_template.indexOf(on_value) !== -1) {
        //show element
        show_el.slideDown('fast');
    } else {
        //hide element
        show_el.hide();
    }
}