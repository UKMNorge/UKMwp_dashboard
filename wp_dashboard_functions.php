<?php
function UKMWP_kontakter() {
	$m = new monstring(get_option('pl_id'));
	$fylke = $m->g('fylke_id');
	
	$fylkeM = new fylke_monstring($m->g('fylke_id'), get_option('season'));
	$fylkeM = $fylkeM->monstring_get();
	$kpobjekter = $fylkeM->kontakter();
	
	foreach($kpobjekter as $kp) {
		$kparray = array('picture' 	=> $kp->g('picture'),
						 'name'		=> $kp->g('name'),
						 'phone'	=> $kp->g('tlf'),
						 'mail'		=> $kp->g('email'),
						 'title'	=> $kp->g('title'));
		$kontaktpersoner[] = $kparray;
	}
	return $kontaktpersoner;		 
}


function UKMWP_statusliste() {
	$status[] = array(
					  'title'	=>	'Wordpress modifikasjoner',
					  'icon'	=>	'blue',
					  'status'	=> 'Fungerer, mangler merking av innlegg med innslag',
					  'repo'	=> 'UKMwp_admin-tweaks'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress dashboard',
					  'icon'	=>	'blue',
					  'status'	=> 'Fungerer, mangler innhold',
					  'repo'	=> 'UKMwp_dashboard'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress instrato-meny',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK! Vil fungere så fort Instrato får oppdaterte passordlister',
					  'repo'	=> 'UKMinstrato'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress mønstring',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK!',
					  'repo'	=> 'UKMmonstring'
				  );

	$status[] = array(
					  'title'	=>	'Materiellbestilling',
					  'icon'	=>	'red',
					  'status'	=> 'Ikke testet',
					  'repo'	=> ''
				  );


	$status[] = array(
					  'title'	=>	'Rapportsenter',
					  'icon'	=>	'blue',
					  'status'	=> 'Mangler, testet OK',
					  'repo'	=> 'UKMrapporter'
				  );

	$status[] = array(
					  'title'	=>	'RAPPORT: statistikk',
					  'icon'	=>	'red',
					  'status'	=> 'Virker ikke',
					  'repo'	=> 'UKMrapporter'
				  );

	$status[] = array(
					  'title'	=>	'RAPPORT: alle innslag',
					  'icon'	=>	'red',
					  'status'	=> 'Virker ikke',
					  'repo'	=> 'UKMrapporter'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress ambassadør-meny',
					  'icon'	=>	'red',
					  'status'	=> 'Mangler',
					  'repo'	=> 'UKMambassador'
				  );


	return $status;
}
?>