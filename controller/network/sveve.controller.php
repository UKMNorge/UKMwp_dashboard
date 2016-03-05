<?php

require_once('UKM/curl.class.php');

$curl = new UKMcurl();
$res = $curl->request('https://sveve.no/SMS/AccountAdm?cmd=sms_count&user='. UKM_SVEVE_ACCOUNT );# .'&passwd='. UKM_SVEVE_PASSWORD);

var_dump( $curl );

$TWIGdata['sveve'] = $res;