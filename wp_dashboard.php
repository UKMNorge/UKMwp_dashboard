<?php

use UKMNorge\Nettverk\Administrator;
use UKMNorge\OAuth2\ArrSys\AccessControlArrSys;

/* ****************************************************************
Omkring linje 12 i wp-admin/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMwp_dashboard/wp_dashboard.php');
-------------
*******************************************************************
*/
global $current_user;

update_user_option($current_user->ID, 'admin_color', 'light', true);

// If update user data-query
if (isset($_POST['form_display_name'])) {
	require_once('controller/profil.controller.php');
}

if( !defined('UKM_WP_INNHOLD_PATH') ) {
	die('SYSTEM-ERROR: <code>UKM_WP_INNHOLD_PATH</code> er ikke satt. Kan plugin <code>UKMwp_innhold</code> være deaktivert?');
}
require_once( UKM_WP_INNHOLD_PATH . 'controller/kommentarer.controller.php');


require_once('UKM/inc/twig-admin.inc.php');

require(ABSPATH . 'wp-admin/admin-header.php');

if( is_user_admin() ) {
	$current_admin = new Administrator(get_current_user_id());
	$omrader = $current_admin->getOmrader();
	$user_arrangementer = [];
	foreach($omrader as $omrade) {
		foreach($omrade->getKommendeArrangementer()->getAll() as $arrangement) {
			$user_arrangementer[$arrangement->getId()] = $arrangement;
		}
	}

	$TWIGdata['user_arrangementer'] = $user_arrangementer;
	$TWIGdata['isFylkeAdmin'] = AccessControlArrSys::hasFylkeAccess();


	require_once('controller/user/dashboard.controller.php');
	echo TWIG('user/dashboard.html.twig', $TWIGdata, dirname(__FILE__));
} else {
	if( get_option('pl_id') && (current_user_can('editor') || current_user_can('administrator')) ) {

		if(get_current_blog_id() != LANDSFESTIVALEN_ID) {
			UKMmonstring::renderAdmin();
		} else {
			// Redirect to UKM Landsfestivalen home admin page
			$redirect = get_site_url( LANDSFESTIVALEN_ID ) . '/wp-admin/index.php?page=UKMArrangementAdmin';
			echo '<script>window.location.replace("' . $redirect . '");</script>';
			die;
		}
    } else {
        echo TWIG('dashboard.html.twig', [], dirname(__FILE__));
    }
}



require(ABSPATH . 'wp-admin/admin-footer.php');
die();