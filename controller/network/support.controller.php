<?php
require_once('UKM/monstringer.collection.php');

$TWIGdata['monstringer'] = [];

$monstringer = new monstringer_v2( get_site_option('season') );
foreach( $monstringer->getAllBySesong() as $monstring ) {

	$path = '/'. str_replace('//'.UKM_HOSTNAME.'/', '', $monstring->getLink() );

	$data = new stdClass();
	$data->blog_url 	= $monstring->getLink();
	$data->blog_id 		= get_blog_id_from_url( UKM_HOSTNAME, $path );
	$data->name 		= $monstring->getNavn();
	try {
		$data->fylke 	= $monstring->getFylke()->getNavn();
	} catch( Exception $e ) {
		$data->fylke	= 'Ukjent';
	}

	$TWIGdata['monstringer'][ $monstring->getType() ][ $path ] = $data;
}