/**
 *	Pushtofront.jquery.js
 * Funksjoner for å oppdatere Push to Front fra dashboard uten å måtte forlate siden.
 *
 */

jQuery(document).on('click', '#saveptfbtn', function() {
	console.log('Save new PTF');
	// Innleggs-selectene heter post_1, post_2 og post_3
	url = '?page=UKMpush_to_front';
	jQuery('#saveptfbtn').html('Lagrer...');
	data = [];
	for(i = 1; i < 4; i++) {
		key = 'post_'+i;
		data[i] = jQuery('#'+key).val();	
	}
	console.log(data);
	jQuery.post(url, { post_1: data[1], post_2: data[2], post_3: data[3]}, function() {
		jQuery('#saveptfbtn').html('Lagret');
		setTimeout(function() {
			jQuery('#saveptfbtn').html('Lagre');
		}, 2000);
	});
});