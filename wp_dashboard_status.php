<?php
function UKMWP_statusliste() {
	$status[] = array(
					  'title'	=>	'Wordpress modifikasjoner',
					  'icon'	=>	'blue',
					  'status'	=> 'Fungerer, mangler merking av innlegg med innslag',
					  'repo'	=> 'UKMwp_admin-tweaks'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress dashboard',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK',
					  'repo'	=> 'UKMwp_dashboard'
				  );

	$status[] = array(
					  'title'	=>	'Wordpress instrato-meny',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK! Vil fungere så fort Instrato får oppdaterte passordlister',
					  'repo'	=> 'UKMinstrato'
				  );

				  
	$status[] = array(
					  'title'	=>	'Wordpress ambassadør-meny',
					  'icon'	=>	'green',
					  'status'	=> 'Fungerer',
					  'repo'	=> 'UKMambassador'
				  );

	$status[] = array(
					  'title'	=>	'Materiellbestilling',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK',
					  'repo'	=> ''
				  );

	$status[] = array(
					  'title'	=>	'Passordliste',
					  'icon'	=>	'green',
					  'status'	=> 'Testet OK',
					  'repo'	=> 'UKMpassord'
				  );


	$status[] = array(
					  'title'	=>	'Wordpress mønstring',
					  'icon'	=>	'red',
					  'status'	=> 'Fungerer ikke!',
					  'repo'	=> 'UKMmonstring'
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
				  

	return $status;
}