<?php
require_once('UKM/monstringer.class.php');
$monstringer = new monstringer( get_site_option('season') );

$registrert = $monstringer->antall_registrerte();
$uregistrert = $monstringer->antall_uregistrerte();

if( $uregistrert >= $registrert ) {
	$status = 'danger';
} elseif( $uregistrert < 15 ) {
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
