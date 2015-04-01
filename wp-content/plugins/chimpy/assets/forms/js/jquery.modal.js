var s = jQuery.noConflict();
s(function()
{
	s('.modal-opener').on('click', function()
	{
		if( !s('#sky-form-modal-overlay').length )
		{
			s('body').append('<div id="sky-form-modal-overlay" class="sky-form-modal-overlay"></div>');
		}		
	
		s('#sky-form-modal-overlay').on('click', function()
		{
			s('#sky-form-modal-overlay').fadeOut();
			s('.sky-form-modal').fadeOut();
		});
		
		form = s(s(this).attr('href'));
		s('#sky-form-modal-overlay').fadeIn();
		form.css('top', '50%').css('left', '50%').css('margin-top', -form.outerHeight()/2).css('margin-left', -form.outerWidth()/2).fadeIn();
		
		return false;
	});
	
	s('.modal-closer').on('click', function()
	{
		s('#sky-form-modal-overlay').fadeOut();
		s('.sky-form-modal').fadeOut();
		
		return false;
	});
});