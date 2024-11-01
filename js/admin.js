jQuery(function($){
	$('#widgets-right').find('.widgets-holder-wrap').each(function(){
		var area = $('div:last-child', this).attr('id'),
			active = ( area, scroller.areas ) ? 'active' : '';
		$(this).find('h3').prepend('<img class="scroller '+ active +'" id="scroller-'+ area +'" data-area="'+ area +'" alt="" src="' + scroller.icon + '" />');
	});
	$('.scroller').live('click', function(e){
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: { action: 'widget_area_scroller_activate', area: '' },
			success: function(data){
				console.log(data);
			}
		});
	});
});