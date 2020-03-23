<?php
/* ****************************************************************
Omkring linje 14 i wp-admin/network/index.php skal require dashboard
 kommenteres ut, og påfølgende linje legges til:
-------------
/* Load WordPress dashboard API 
#require_once(ABSPATH . 'wp-admin/includes/dashboard.php');
require_once(ABSPATH . 'wp-content/plugins/UKMwp_dashboard/wp_network_dashboard.php');
-------------
*******************************************************************
*/

require_once('UKM/inc/twig-admin.inc.php');

require(ABSPATH . 'wp-admin/admin-header.php');

$MESSAGES = array();
$TWIGdata = array();
$TWIGdata['UKM_HOSTNAME'] = UKM_HOSTNAME;
$TWIGdata['plugin_path'] = plugin_dir_url( __FILE__ ).'/';
$TWIGdata['base_path'] = '//'. UKM_HOSTNAME .'/';

#error_reporting(E_ALL);
#ini_set('display_errors',true);

require_once('controller/network/innhold_tema.controller.php');
require_once('controller/network/innhold_sites.controller.php');
require_once('controller/network/support.controller.php');
require_once('controller/network/server_status.controller.php');
require_once('controller/network/sveve.controller.php');
require_once('controller/network/samtykke.controller.php');
require_once('controller/network/delta.controller.php');

$MESSAGES = apply_filters('UKMWPNETWDASH_messages', $MESSAGES);

foreach($MESSAGES as $key => $msg) {
	if($msg['level'] == 'alert-error')
		$MESSAGES[$key]['level'] = 'alert-danger';
}
$TWIGdata['messages'] = $MESSAGES;

#require_once(dirname(__FILE__).'/controller/news.controller.php');

echo TWIG('network/dashboard.html.twig', $TWIGdata, dirname(__FILE__));


require(ABSPATH . 'wp-admin/admin-footer.php');
die();
