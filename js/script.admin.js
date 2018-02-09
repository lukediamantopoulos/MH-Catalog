jQuery(document).ready( function($) {
	var mediaUploader;
	var attachment;

	// Uploading Profile Picture
	$( '#upload-button' ).on('click', function(e) {
		e.preventDefault();
		if( mediaUploader ) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Profile Picture',
			button: {
				text: 'Choose Picture',
			},
			multiple: false
		});

		mediaUploader.on('select', function() {
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#profile-picture').val(attachment.url);
			$('#profile-picture-preview').css('background-image', 'url(' + attachment.url + ')');
		});

		mediaUploader.open();
	});

	// Removing Profile Picture
	$( '#remove-picture' ).on('click', function(e) {
		console.log('clicked');
		e.preventDefault();
		var answer = confirm('Are you sure?');
		if ( answer == true ) {
			$('#profile-picture').val('');
			$('.mh-admin-form').submit();
		} 
		return;
	});

});