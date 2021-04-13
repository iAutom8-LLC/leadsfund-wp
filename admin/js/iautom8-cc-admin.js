(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( document ).on( 'ready', function() {
		var clipboard = new ClipboardJS('.btn-copy');

		clipboard.on('success', function (e) {
			console.info(e);
			console.info('Action:', e.action);
			console.info('Text:', e.text);
			console.info('Trigger:', e.trigger);

			$( e.trigger ).addClass( 'success' );

			setTimeout( () => {
				$( e.trigger ).removeClass( 'success' );
			}, 3000 );

			e.clearSelection();
		});

		clipboard.on('error', function (e) {
			console.error('Action:', e.action);
			console.error('Trigger:', e.trigger);
		});
	});

})( jQuery );
