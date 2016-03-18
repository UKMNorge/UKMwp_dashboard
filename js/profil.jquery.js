/*jQuery(document).on('click', '#insertMedia', function() {
    if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {
    	console.log(this);
	    var target = jQuery('#insertMedia img');
	    console.log(target);
        wp.media.editor.open( '#UKMptfSelectImage' );
		
		original_send = wp.media.editor.send.attachment;
		wp.media.editor.send.attachment = function( a, b) {
			setImage(target,b)
		};
		window.original_send_to_editor = window.send_to_editor; 
	}
});*/

jQuery(document).ready(function () {
	// Uploading files		
	var mediaUploader;		
  	
  	jQuery('#insertMedia').live('click', function( event ){		
    	//event.preventDefault();		
    	// If the media frame already exists, reopen it.		    
    	if ( mediaUploader ) {		      
    		mediaUploader.open();		      
    		return;		    
    	}		
    	// Create the media frame.		    
    	mediaUploader = wp.media.frames.file_frame = wp.media({
	    	title: 'Velg bilde',
      		button: {
      			text: 'Velg bilde'
    		}, 
    		multiple: false // Set to true to allow multiple files to be selected
    	}); 

    	// When an image is selected, run a callback.		    
    	mediaUploader.on( 'select', function() {
	    	// We set multiple to false so only get one image from the uploader
	    	attachment = mediaUploader.state().get('selection').first().toJSON();		
	    	// Do something with attachment.id and/or attachment.url here
	    	jQuery('#insertMedia img').attr('src', attachment.url);		    
	    	jQuery('#avatar_image').val(attachment.url);
	    });		
	    // Finally, open the modal		    
	    mediaUploader.open();		  
	});
});
