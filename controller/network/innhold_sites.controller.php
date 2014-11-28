<?php
	require_once('news.controller.php');
	
	$sites = array();

	// UKM for ungdom	
	$site = new stdClass();
	$site->ID = 1;
	$site->title = 'UKM for ungdom';
	$site->link_add = 'http://'. UKM_HOSTNAME .'/wp-admin/post-new.php';
	$site->link_panel = 'http://'. UKM_HOSTNAME .'/wp-admin/';
	$site->posts = posts( $site->ID );
	
	$sites[] = $site;
	
	// UKM for voksne og presse
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 12 : 880;
	$site->title = 'UKM for voksne og presse';
	$site->link_add = 'http://'. UKM_HOSTNAME .'/om/wp-admin/post-new.php';
	$site->link_panel = 'http://'. UKM_HOSTNAME .'/om/wp-admin/';
	$site->posts = posts( $site->ID );
	
	$sites[] = $site;
	
	// UKM for ambassadører
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 12 : 377;
	$site->title = 'UKM for ambassadører';
	$site->link_add = 'http://'. UKM_HOSTNAME .'/ambassador/wp-admin/post-new.php';
	$site->link_panel = 'http://'. UKM_HOSTNAME .'/ambassador/wp-admin/';
	$site->posts = posts( $site->ID, 1 );
	
	$sites[] = $site;
	
	// UKM internasjonalt
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 12 : 387;
	$site->title = 'UKM internasjonalt';
	$site->link_add = 'http://'. UKM_HOSTNAME .'/internasjonalt/wp-admin/post-new.php';
	$site->link_panel = 'http://'. UKM_HOSTNAME .'/internasjonalt/wp-admin/';
	$site->posts = posts( $site->ID, 1 );
	
	$sites[] = $site;
	
	$TWIGdata['sites'] = $sites;
	
	
	// UKM for arrangorer
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 13 : 881;
	$site->title = 'UKM internasjonalt';
	$site->link_add = 'http://'. UKM_HOSTNAME .'/internasjonalt/wp-admin/post-new.php';
	$site->link_panel = 'http://'. UKM_HOSTNAME .'/internasjonalt/wp-admin/';
	$site->posts = posts( $site->ID, 3 );
	
	$site->links = [];
	$site->links[] = array('url' => 'http://ukm.no/arrangor/wp-admin/post.php?post=3245&action=edit', 'text' => 'Stimuleringsmidler');
	$site->links[] = array('url' => '#', 'text' => 'Dokumenter');
	
	$TWIGdata['site_arrangor'] = $site;