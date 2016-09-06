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

function UKMWP_gjestekommune() {
	$m = new monstring(get_option('pl_id'));
	$db = 'ukmno_wp2012';
	if(UKM_HOSTNAME == 'ukm.dev')
		$db = 'ukmdev_dev_wp';
	$sql = new SQL("SELECT `b_name` AS 'brukernavn', `b_password` AS 'passord'
					FROM `#db`.`ukm_brukere`
					WHERE `b_fylke` = '#fylke_id' 
					AND `b_name` LIKE 'gjest_%'
					AND `b_name` NOT LIKE 'Gjester'
					LIMIT 1", array('db' => $db, 'fylke_id' => $m->g('fylke_id')));

	#echo $sql->debug();
	$res = $sql->run('array');
	#var_dump($res);
	return $res;
}
?>