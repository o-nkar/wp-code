/* plugin JS code */
(function($){
	console.log( '%c wpCode code loaded...', 'color:#000;background-color:yellow;padding:4px;' );
	$(document).on('click', '.wp_promotion_close', function(event) {
		event.preventDefault();
		var $this = $(this);
		$.post( ajaxurl, {
				action: 'wp-code_dismiss_wpCode_notices',
				nonce: $this.data('nonce')
		});
		$('.wp_promotion_close').parents('.notice-container').fadeOut();
	});
})(jQuery);
