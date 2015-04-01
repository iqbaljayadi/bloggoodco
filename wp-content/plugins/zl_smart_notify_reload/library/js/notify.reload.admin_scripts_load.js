;(function($) {
	$(document).ready(function(){
		
		$('.wp-color-picker-field').wpColorPicker();
		$('.zalki-admin-dash-wrap').ZalkiAdminDashboard();

		// MEDIA UPLOADER
function set_uploader(button, field) {

	if($(button) && $(field)) {
		$(button).click(function() {
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			field = $(this).siblings('.zl_reload_icon_upload');
			set_send(field);
			return false;
		});
	};
};
 
function set_send(field) {

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
		imgurl = $('img',html).attr('src');
		field.val(imgurl);
		tb_remove();
	window.send_to_editor = window.original_send_to_editor;
	};
};
 
set_uploader('.zl_reload_upload_button', '.zl_reload_icon_upload');


	$('.zl_reload_icon_upload').each(function(){

		var zl_input_val = $(this).val();

		if( $(this).val() ){
			if(zl_input_val.length > 3){
			$(this).siblings('.zl_reload_span').html('<img src="'+zl_input_val+'" alt="live preview">');
			}; // if length close	
		}else{
			$(this).siblings('.zl_reload_span').html('<em class="little_box">NO IMAGE</em>');
			}; // if close

	});

 		});
} (jQuery) );