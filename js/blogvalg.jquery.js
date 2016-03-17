jQuery(document).ready(function() {
	console.log(jQuery('#blogvalg'));
	jQuery('#blogvalg').change(function() {
		console.log(jQuery('#blogvalg').val());
		window.location.href = jQuery('#blogvalg').val();
	});
});