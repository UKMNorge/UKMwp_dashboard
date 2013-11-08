<?php
/* ****************************************************************
Omkring linje 12 i wp-admin/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMNorge/wp_dashboard.php');
-------------
*******************************************************************
*/
require_once('UKM/inc/twig-admin.inc.php');
require_once('UKM/monstring.class.php');
require_once(dirname(__FILE__).'/wp_dashboard_functions.php');

require(ABSPATH . 'wp-admin/admin-header.php');

$MESSAGES = array();
$MESSAGES = apply_filters('UKMWPDASH_messages', $MESSAGES);

$TWIGdata = array('site_type' => get_option('site_type'),
				  'kontakter' => UKMWP_kontakter(),
				  'messages'  => $MESSAGES,
				  );

echo TWIG('dashboard.twig.html', $TWIGdata, dirname(__FILE__));

require(ABSPATH . 'wp-admin/admin-footer.php');
die();