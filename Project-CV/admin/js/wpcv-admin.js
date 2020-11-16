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

	$( document ).ready(
		function() {
			$( '#abcvFileTable' ).DataTable();
	});

	$( document ).on(
		'click',
		'.abIsRead',
		function(){
			let id   = $( this ).attr( 'id' );
			var data = {
				action: 'ab_is_reviewed',
				ab_is_read_id: id
			}
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {
				location.reload();
			});
		}
	);

	$( document ).on(
		'click',
		'.abIsNotRead',
		function(){
			let id   = $( this ).attr( 'id' );
			var data = {
				action: 'ab_is_not_reviewed',
				ab_is_not_read_id: id
			}
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {
				location.reload();
			});
		}
	);

	$( document ).on(
		'click',
		'.abCvDelete',
		function(){
			let id   = $( this ).attr( 'id' );
			var data = {
				action: 'ab_cv_delete',
				ab_cv_delete_id: id
			}
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {
				location.reload();
			});
		}
	);

	$( document ).on(
		'click',
		'.abCoverDelete',
		function(){
			let id   = $( this ).attr( 'id' );
			var data = {
				action: 'ab_cover_delete',
				ab_cover_delete_id: id
			}
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {
				location.reload();
			});
		}
	);

})( jQuery );
