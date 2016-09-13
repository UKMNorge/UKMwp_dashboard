<?php

function get_urls() {
	# Fetch this places paths:
	if(get_option('site_type') == 'kommune') {
		$realpath = '/pl'.get_option('pl_id').'/';
		$sql = new SQL("SELECT * FROM `ukmno_wp2012`.`ukm_uri_trans`
						WHERE `realpath` = '#realpath'", 
						array("realpath" => $realpath));
		$res = $sql->run();
		
		$urls = array();
		if(false == $res) 
			return false;
		while($row = mysql_fetch_assoc($res)) {
			$url = new stdClass();
			$url->name = 'http://ukm.no'.$row['path'];
			$url->realpath = $row['realpath'];
			$urls[] = $url;
		}
	} else {
		require_once('UKM/monstring.class.php');
		$pl_id = get_option('pl_id');
		$pl = new monstring_v2($pl_id);
		$url = new stdClass();
		$url->name = 'http:'.$pl->getLink();
		$url->realpath = $pl->getLink();
		$urls[] = $url;
	} 
	
	return $urls;
}