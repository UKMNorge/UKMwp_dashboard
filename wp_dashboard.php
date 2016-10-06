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
global $current_user;

update_user_option($current_user->ID, 'admin_color', 'light', true);

// If update user data-query
if (isset($_POST['form_display_name'])) {
	require_once('controller/profil.controller.php');

}
require_once('UKM/inc/twig-admin.inc.php');
require_once('UKM/monstring.class.php');
require_once(dirname(__FILE__).'/wp_dashboard_functions.php');

require(ABSPATH . 'wp-admin/admin-header.php');

/* SHORTCUTS */
$SHORTCUTS = array();
$SHORTCUTS = apply_filters('UKMWPDASH_shortcuts', $SHORTCUTS);

/* MESSAGES */
$MESSAGES = array();
$MESSAGES = apply_filters('UKMWPDASH_messages', $MESSAGES);
foreach($MESSAGES as $key => $MESSAGE) {
	if($MESSAGE['level'] == 'alert-error')
		$MESSAGES[$key]['level'] = 'alert-danger';
}

/* KALENDER */
$KALENDER = array();
$KALENDER = apply_filters('UKMWPDASH_calendar', $KALENDER);

if( in_array( get_option('site_type'), array('kommune','fylke','land') ) ) {
	/* STATISTIKK */
	require_once('UKM/monstring.class.php');
	$pl = new monstring( get_option('pl_id' ) );
	$stat = $pl->statistikk();										  
	$STATISTIKK = $stat->getTotal($pl->get('season'));
} else {
	$STATISTIKK = null;
}	

/* DELTAKERBRUKER ELLER ARRANGØR? */
$qry = new SQL("SELECT COUNT(*) FROM `#table`
				WHERE `wp_id` = '#id'",
				array('table' => 'ukm_wp_deltakerbrukere', 'id' => $current_user->ID)
			);
$res = $qry->run('field', 'COUNT(*)');
if ($res) {
	$shortcuts_available = false;
	$deltakerbruker = true;
}
else { 
	$shortcuts_available = true;
	$deltakerbruker = false;
}

/* HELÅRS-DELTAKERE */
$helarsDeltakere = 0;
if(file_exists(__DIR__.'/../UKMrsvp_admin/class/SecretFinder.php')) {
	require_once(__DIR__.'/../UKMrsvp_admin/class/SecretFinder.php');
	require_once(__DIR__.'/../UKMrsvp_admin/class/EventManager.php');

	$api_key = 'ukmno_rsvp';
	if(get_option('site_type') == 'land')
		$owner = 'UKMNorge';
	else
		$owner = get_option('pl_id');
	$secretFinder = new SecretFinder();
	$eventManager = new EventManager($api_key, $secretFinder->getSecret($api_key));
	$participants = $eventManager->findAllAttending($owner);
	$helarsDeltakere = count($participants->data);
	#var_dump($participants);
}

$TWIGdata = array('site_type' => get_option('site_type'),
				  'kontakter' => UKMWP_kontakter(),
				  'messages'  => $MESSAGES,
				  'block_pre_messages' => array(), // PUTT HTML her for å vise på topp av startsiden
				  'shortcuts' => $SHORTCUTS,
				  'kalender' => $KALENDER,
				  'statistikk' => $STATISTIKK,
				  'kommune' => $TWIG['statistikk_detaljert'],
				  'user' => $current_user,
				  'deltakerbruker' => $deltakerbruker,
				  'helarsDeltakere' => $helarsDeltakere
				  );

if ($deltakerbruker) {
	// Liste over blogger brukeren har rettigheter til.
	$blogs = get_blogs_of_user($current_user->ID);
	#var_dump($blogs);
	$TWIGdata['blogs'] = $blogs;
	#var_dump(get_current_blog_id());
	$TWIGdata['current_blog_id'] = get_current_blog_id();
	$TWIGdata['user_avatar'] = get_avatar($current_user->ID);
	#var_dump($current_user);
	#echo '<br>';
	#var_dump(get_avatar($current_user->ID));
}

/* BRUKER-URLER */
require_once(__DIR__.'/controller/urls.controller.php');
$TWIGdata['urls'] = get_urls();

$TWIGdata['user_avatar'] = get_avatar($current_user->ID);

/* NEWS */
$POST_QUERY = 'cat=-2';
require_once(dirname(__FILE__).'/controller/news.controller.php');



$TWIGdata = apply_filters('UKMwp_dashboard_load_controllers', $TWIGdata);

echo TWIG('dashboard.twig.html', $TWIGdata, dirname(__FILE__));

require(ABSPATH . 'wp-admin/admin-footer.php');
die();
