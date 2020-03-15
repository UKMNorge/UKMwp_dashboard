jQuery(document).ready(function() {
    jQuery('#blogvalg').change(function() {
        window.location.href = jQuery('#blogvalg').val();
    });
});