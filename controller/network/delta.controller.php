<?php


if( isset($_GET['deltaApproved'] ) && 'true' == $_GET['deltaApproved'] ) {
    update_site_option('delta_is_tested', get_site_option('season') );
}

$tested = get_site_option('delta_is_tested');

$TWIGdata['deltaStatus'] = ($tested === get_site_option('season') ? 'success':'danger');
$TWIGdata['deltaApproved'] = $tested;
?>