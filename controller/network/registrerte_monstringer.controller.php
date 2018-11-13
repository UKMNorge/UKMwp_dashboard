<?php

require_once('UKM/monstringer.class.php');
$registrert = monstringer_v2::getAntallRegistrerte( get_site_option('season') );
$uregistrert = monstringer_v2::getAntallUregistrerte( get_site_option('season') );

if( $uregistrert >= $registrert ) {
	$status = 'danger';
} elseif( $uregistrert > 15 ) {
	$status = 'warning';
} elseif( $uregistrert < 5 ) {
	$status = 'success';
} else {
	$status = 'info';
}

$TWIGdata['registrerte_monstringer'] = array('registrert' => $registrert,
											 'uregistrert'=> $uregistrert,
											 'status' => $status
											);


// I sesong, sjekk antall uregistrerte mønstringer
if( in_array( (int)date('m'), array(11,12,1,2) ) ) {
	if( 15 < $uregistrert ) {
		$MESSAGES[] = array(
			'level' 	=> 'alert-'. $status,
			'module'	=> 'System',
			'header'	=> 'Det er '. $uregistrert .' uregistrerte mønstringer ',
			'link'		=> 'admin.php?page=UKMrapport_admin&network=monstringer_uregistrert'
		);
	}
}