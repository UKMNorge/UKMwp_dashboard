<?php
require_once('UKM/sql.class.php');

$fylker = new SQL("SELECT * FROM `smartukm_fylke` ORDER BY `name` ASC");
$fylker = $fylker->run();

$monstringer = array('lokal' => array(), 'fylke' => array() );

while( $fylke = mysql_fetch_assoc( $fylker ) ) {
	$monstring = new fylke_monstring( $fylke['id'], get_site_option('season') );
	$monstring = $monstring->monstring_get();
	
	if( $monstring->get('pl_id') == 0)
		continue;
	
	$fylke = new stdClass();
	$fylke->blog_url = $monstring->get('url').'/';
	$fylke->blog_path = str_replace('http://'. UKM_HOSTNAME, '', $fylke->blog_url );
	$fylke->blog_id = get_blog_id_from_url( UKM_HOSTNAME, '/'. $fylke->blog_path.'/' );
	$fylke->name = $monstring->get('pl_name');
	
	$monstringer['fylke'][$fylke->blog_path] = $fylke;
	
	$lokalmonstringer = $monstring->hent_lokalmonstringer();
	foreach( $lokalmonstringer as $plid ) {
		$lokalmonstring = new stdClass();
		$lokalmonstring->blog_url = 'http://'. UKM_HOSTNAME .'/pl'. $plid .'/';
		$lokalmonstring->blog_path = '/pl'. $plid .'/';
		$lokalmonstring->blog_id = get_blog_id_from_url(UKM_HOSTNAME,$lokalmonstring->blog_path );
		echo UKM_HOSTNAME .' - '. $lokalmonstring->blog_path .' <br />';
		$blog_details = get_blog_details( $lokalmonstring->blog_id, 'blogname' );
		$lokalmonstring->name = $blog_details->blogname;
		$lokalmonstring->fylke = $fylke->name;
		
		$monstringer['lokal'][$lokalmonstring->blog_path] = $lokalmonstring;
	}
	
}

$TWIGdata['monstringer'] = $monstringer;