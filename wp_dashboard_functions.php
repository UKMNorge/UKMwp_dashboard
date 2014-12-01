<?php
function UKMWP_kontakter() {
	$m = new monstring(get_option('pl_id'));
	$fylke = $m->g('fylke_id');
	
	$fylkeM = new fylke_monstring($m->g('fylke_id'), get_option('season'));
	$fylkeM = $fylkeM->monstring_get();
	$kpobjekter = $fylkeM->kontakter();
	
	$kontaktpersoner = [];
	if( is_array( $kpobjekter ) ) {
		foreach($kpobjekter as $kp) {
			$kparray = array('picture' 	=> $kp->g('picture'),
							 'name'		=> $kp->g('name'),
							 'phone'	=> $kp->g('tlf'),
							 'mail'		=> $kp->g('email'),
							 'title'	=> $kp->g('title'));
			$kontaktpersoner[] = $kparray;
		}
	}
	return $kontaktpersoner;		 
}
?>