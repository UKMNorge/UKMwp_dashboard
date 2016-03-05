<?php

require_once('UKM/curl.class.php');

// Videoconverter
$curl = new UKMCurl();
$curl->timeout(2);
$result = $curl->request('http://videoconverter.'. /*UKM_HOSTNAME*/'ukm.no' .'/api/status.php');
$TWIGdata['videoconverter'] = new stdClass;

if( is_object($result) ) {
	$result->space = graph_diskspace( $result );
	$TWIGdata['videoconverter'] = $result;
	$TWIGdata['videoconverter']->online = true;
} else {
	$TWIGdata['videoconverter']->online = false;
}

// Videoconverter
$curl = new UKMCurl();
$curl->timeout(2);
$result = $curl->request('http://video.'. /*UKM_HOSTNAME*/'ukm.no' .'/api/status.php');
$TWIGdata['video'] = new stdClass;

if( is_object($result) ) {
	$result->space = graph_diskspace( $result );	
	$TWIGdata['video'] = $result;
	$TWIGdata['video']->online = true;
} else {
	$TWIGdata['video']->online = false;
}



// Playback-server
$curl = new UKMCurl();
$curl->timeout(2);
$result = $curl->request('http://playback.'. /*UKM_HOSTNAME*/'ukm.no' .'/api/status.php');
$TWIGdata['playback'] = new stdClass;

if( is_object($result) ) {
	$result->space = graph_diskspace( $result );
	$TWIGdata['playback'] = $result;
	$TWIGdata['playback']->online = true;
} else {
	$TWIGdata['playback']->online = false;
}


function graph_diskspace( $result ) {
	$space = new stdClass;
	$space->free = $result->diskspace;
	$space->used = $result->total_diskspace - $result->diskspace;
	$space->total = $result->total_diskspace;
	
	$space->free = $space->free / (1024*1024*1024);
	$space->used = $space->used / (1024*1024*1024);
	$space->total = $space->total / (1024*1024*1024);
	return $space;
}