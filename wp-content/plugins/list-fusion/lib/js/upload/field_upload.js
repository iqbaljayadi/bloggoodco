/*global jQuery, document, redux_upload, formfield:true, preview:true, tb_show, window, imgurl:true, tb_remove, $relid:true*/
/*
This is the uploader for wordpress starting from version 3.5
*/
jQuery(document).ready(function(){

    jQuery("img[src='']").attr("src", listfusion_upload.url);

    jQuery(".wrap").on('click', '.listfusion_img_upload', function( event ) {
	var activeFileUploadContext = jQuery(this).parent();
	var relid = jQuery(this).attr('rel-id');

	event.preventDefault();

	// if its not null, its broking custom_file_frame's onselect "activeFileUploadContext"
	custom_file_frame = null;

	// Create the media frame.
	custom_file_frame = wp.media.frames.customHeader = wp.media({
	    // Set the title of the modal.
	    title: jQuery(this).data("choose"),

	    // Tell the modal to show only images. Ignore if want ALL
	    library: {
		type: 'image'
	    },
	    // Customize the submit button.
	    button: {
		// Set the text of the button.
		text: jQuery(this).data("update")
	    }
	});

	custom_file_frame.on( "select", function() {
	    // Grab the selected attachment.
	    var attachment = custom_file_frame.state().get("selection").first();

	    // Update value of the targetfield input with the attachment url.
	    jQuery('.listfusion_upload_image_preview',activeFileUploadContext).attr('src', attachment.attributes.url);
	    jQuery('#' + relid ).val(attachment.attributes.url).trigger('change');

	    jQuery('.listfusion_img_upload',activeFileUploadContext).hide();
	    jQuery('.listfusion_upload_image_preview',activeFileUploadContext).show();
	    jQuery('.listfusion_img_upload_remove',activeFileUploadContext).show();
	});

	custom_file_frame.open();
    });

    jQuery(".wrap").on('click', '.listfusion_img_upload_remove', function( event ) {  
		var activeFileUploadContext = jQuery(this).parent();
		var relid = jQuery(this).attr('rel-id');
	
		event.preventDefault();
	
		jQuery('#' + relid).val('');
		jQuery(this).prev().fadeIn('slow');
		jQuery('.listfusion_upload_image_preview',activeFileUploadContext).fadeOut('slow');
		jQuery(this).fadeOut('slow');
		jQuery('.listfusion_img_upload').show('slow');
    });

});
