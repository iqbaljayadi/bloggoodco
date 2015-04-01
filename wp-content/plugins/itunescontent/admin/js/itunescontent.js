jQuery(document).ready(function($) {
	$('#itunes_shortcode').focus(function() {
		$(this).select();
		
		window.setTimeout(function() {
			$(this).select();
		}, 1);
		
		// Work around WebKit's little problem
		function mouseUpHandler() {
			// Prevent further mouseup intervention
			$(this).off('mouseup', mouseUpHandler);
			return false;
		}
		
		$(this).mouseup(mouseUpHandler);
	});
});