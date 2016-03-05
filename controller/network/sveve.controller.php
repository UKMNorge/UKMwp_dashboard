<?php

require_once('UKM/curl.class.php');
if( UKM_HOSTNAME == 'ukm.no' ) {
	$curl = new UKMcurl();
	$res = $curl->request('https://sveve.no/SMS/AccountAdm?cmd=sms_count&user='. UKM_SVEVE_ACCOUNT );
	$TWIGdata['sveve'] = trim($res);
} else {
	$TWIGdata['sveve'] = 'N/A';
}