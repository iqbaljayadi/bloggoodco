jQuery(document).ready(function() {	
	jQuery('.wp_insert_uploader_button').click(function() {
		formfield = jQuery(this).prev().attr("name");
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery("input[name=\'"+formfield+"\']").val(imgurl);
		tb_remove();
	}
	
	jQuery("#wp_insert_form textarea.chitika").focus(function() {
		jQuery(this).after("<div title='Click Here to Insert Chitika Ad Code' class='chitikaButton' onclick='wpInsertChitikaPopUpHandler(\""+jQuery(this).attr('id')+"\")'></div>");
		jQuery(".chitikaButton").delay(100).animate({"opacity": "1"}, 500);
		return true;
	});
	
	jQuery("#wp_insert_form textarea.chitika").blur(function() {
		jQuery(".chitikaButton").animate({"opacity": "0"}, 500);
		setTimeout(function(){jQuery(".chitikaButton").remove()}, 200);
		return true;
	});
});