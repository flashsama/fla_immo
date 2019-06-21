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
	$(function() {
		$('#fla_immo_gallery_button').click(function(e){
			e.preventDefault();
			// Sets up the media library frame
				var meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
					title: 'offres immo gallerie',
					button: { text:  'selectionez photos' },
					library: { type: 'image' },
					multiple: true
			});

			

		

		// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
		meta_gallery_frame.states.add([
				new wp.media.controller.Library({
						id:         'fla-immo-offer-gallery',
						title:      'Select Images for Gallery',
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame.options.library ),
						multiple:   meta_gallery_frame.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
				}),
		]);

		meta_gallery_frame.on('open', function() {
				var selection = meta_gallery_frame.state().get('selection');
				var library = meta_gallery_frame.state('gallery-edit').get('library');
				var ids = jQuery('#fla_immo_gallery').val();
				if (ids) {
						var idsArray = ids.split(',');
						idsArray.forEach(function(id) {
								var attachment = wp.media.attachment(id);
								attachment.fetch();
								selection.add( attachment ? [ attachment ] : [] );
						});
			 }
		});

		meta_gallery_frame.on('ready', function() {
				jQuery( '.media-modal' ).addClass( 'no-sidebar' );
		});

		// When an image is selected, run a callback.
		//meta_gallery_frame.on('update', function() {
		meta_gallery_frame.on('select', function() {
			console.log('selected');
				var imageIDArray = [];
				var imageHTML = '';
				var metadataString = '';
				var images = meta_gallery_frame.state().get('selection');
				imageHTML += '<ul class="gallery_list">';
				images.each(function(attachment) {
						imageIDArray.push(attachment.attributes.id);
						imageHTML += '<li><div class="shift8_portfolio_gallery_container"><span class="shift8_portfolio_gallery_close"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'"></span></div></li>';
				});
				imageHTML += '</ul>';
				metadataString = imageIDArray.join(",");
				if (metadataString) {
						jQuery("#fla_immo_gallery").val(metadataString);
						jQuery("#fla_immo_gallery_src").html(imageHTML);
						setTimeout(function(){
								ajaxUpdateTempMetaData();
						},0);
				}
		});

		// Finally, open the modal
		meta_gallery_frame.open();
		});
	});

})( jQuery );
