<?php

require_once('UKM/curl.class.php');

// Videoconverter
$curl = new UKMCurl();
$curl->timeout(2);
$result = $curl->request('https://videoconverter.'. UKM_HOSTNAME .'/api/status.php');
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
$result = $curl->request('https://video.'. UKM_HOSTNAME .'/api/status.php');
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
$result = $curl->request('https://playback.'. UKM_HOSTNAME .'/api/status.php');
$TWIGdata['playback'] = new stdClass;

if( is_object($result) ) {
	$result->space = graph_diskspace( $result );
	$TWIGdata['playback'] = $result;
	$TWIGdata['playback']->online = true;
} else {
	$TWIGdata['playback']->online = false;
}

// UKMno-server
$curl = new UKMCurl();
$curl->timeout(2);
$result = $curl->request('https://api.'. UKM_HOSTNAME .'/server:diskspace/');
if( !is_object( $result ) ) {
	$result = new stdClass();
}
$result->space = graph_diskspace( $result );
$TWIGdata['ukmno'] = $result; 


function graph_diskspace( $result ) {
	$space = new stdClass;
	$space->free = $result->diskspace;
	$space->used = $result->total_diskspace - $result->diskspace;
	$space->total = $result->total_diskspace;
	
	$space->free = $space->free / (1024*1024*1024);
	$space->used = $space->used / (1024*1024*1024);
	$space->total = $space->total / (1024*1024*1024);
	
	if( $space->total == 0 || $space->free == 0 ) {
		$space->free_percentage = 0;
	} else {
		$space->free_percentage = (100 / $space->total) * $space->free;
	}
	
	return $space;
}