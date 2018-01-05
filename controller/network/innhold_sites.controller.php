<?php
	require_once('news.controller.php');


	function post_status( $site ) {
		if( isset( $site->posts ) && isset( $site->posts[0] ) ) {
			$now = new DateTime();
			$posttime = new DateTime( $site->posts[0]->date );
			$since_last = date_diff( $now, $posttime )->format('%R%a');
			
			if( $site->frequency > abs( $since_last ) ) {
				return 'info';
			}
			if( $site->frequency == abs( $since_last ) ) {
				return 'warning';
			}
			return 'danger';
		}
		return 'warning';
	}	


	$sites = array();

	// ungdom	
	$site = new stdClass();
	$site->key = 'redaksjonelt';
	$site->ID = 3449;
	$site->title = 'redaksjonelt';
	$site->link_add = '//'. UKM_HOSTNAME .'/redaksjonelt/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/redaksjonelt/wp-admin/';
	$site->frequency = 7; #days
	$site->posts = posts( $site->ID );
	$site->status = post_status( $site );
	
	$sites[] = $site;

	// arrangorer
	$site = new stdClass();
	$site->key = 'arrangor';
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 13 : 881;
	$site->title = 'arrangører';
	$site->link_add = '//'. UKM_HOSTNAME .'/arrangor/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/arrangor/wp-admin/';
	$site->posts = posts( $site->ID, 3 );
	if( date('m') > 4 && date('m') < 11 ) {
		$site->frequency = 21; #days
	} else {
		$site->frequency = 7; #days
	}
	$site->posts = posts( $site->ID, 3 );
	$site->status = post_status( $site );
	$sites[] = $site;
	
	// voksne og presse
	$site = new stdClass();
	$site->key = 'organisasjonen';
	$site->ID = 3447;
	$site->title = 'organisasjonen';
	$site->link_add = '//'. UKM_HOSTNAME .'/org/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/org/wp-admin/';
	$site->frequency = 10; # days
	$site->posts = posts( $site->ID );
	$site->status = post_status( $site );
	
	$sites[] = $site;

	// UKM-festivalen
	$site = new stdClass();
	$site->key = 'festivalen';
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 60 : 2173;
	$site->title = 'UKM-festivalen';
	$site->link_add = '//'. UKM_HOSTNAME .'/festivalen/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/festivalen/wp-admin/';
	if( date('m') < 7 && date('m') > 4 ) {
		$site->frequency = 10; #days
	} else {
		$site->frequency = 365; #days
	}
	$site->posts = posts( $site->ID, 1 );
	$site->status = post_status( $site );
	
	$sites[] = $site;
	
	// ungdom	
	$site = new stdClass();
	$site->key = 'ungdom';
	$site->ID = 1;
	$site->title = 'ungdom';
#	$site->link_add = '//'. UKM_HOSTNAME .'/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/wp-admin/';
	$site->frequency = false; #days
	
	$sites[] = $site;
	
/*	// ambassadører
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 12 : 377;
	$site->title = 'ambassadører';
	$site->link_add = '//'. UKM_HOSTNAME .'/ambassador/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/ambassador/wp-admin/';
	$site->frequency = 28; #days
	$site->posts = posts( $site->ID, 1 );
	$site->status = post_status( $site );
	
	$sites[] = $site;
*/	
/*
	// UKM internasjonalt
	$site = new stdClass();
	$site->ID = UKM_HOSTNAME == 'ukm.dev' ? 12 : 387;
	$site->title = 'UKM internasjonalt';
	$site->link_add = '//'. UKM_HOSTNAME .'/internasjonalt/wp-admin/post-new.php';
	$site->link_panel = '//'. UKM_HOSTNAME .'/internasjonalt/wp-admin/';

	$site->posts = posts( $site->ID, 1 );
	
	$sites[] = $site;
*/	
	
	
	$TWIGdata['sites'] = $sites;
