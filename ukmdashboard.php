<?php  
/* 
Plugin Name: UKM Dashboard
Plugin URI: http://www.ukm-norge.no
Description: Modifiserer Wordpress admin index for å inkludere eget WP-dashboard
Author: UKM Norge / M Mandal 
Version: 1.0 
Author URI: http://mariusmandal.no
*/

add_action( 'admin_init', 'UKMWP_dash' );
add_action( 'admin_enqueue_scripts', 'UKMWP_dash_scriptsandstyles' );
add_action('admin_menu', 'UKMwpd_menu');
add_action('network_admin_menu', 'UKMwpd_network_menu');

function UKMwpd_menu() {
	if( in_array( get_option('site_type'), array('kommune','fylke','land')) ) {
		$page = add_menu_page('Dokumenter', 'Dokumenter', 'editor', 'UKMdokumenter', 'UKMdokumenter', 'http://ico.ukm.no/news-16.png',3);
		add_action( 'admin_print_styles-' . $page, 'UKMdokumenter_sns' );	
	
		$page = add_menu_page('Stimuleringsmidler', 'Stimuleringsmidler', 'editor', 'UKMstimulering', 'UKMstimulering', 'http://ico.ukm.no/cash-menu.png',4);
		$subpage1 = add_submenu_page('UKMstimulering', 'Søknadsskjema', 'Søknadsskjema', 'editor', 'UKMstimulering_sok', 'UKMstimulering_sok');
		$subpage2 = add_submenu_page('UKMstimulering', 'Rapport', 'Rapportskjema', 'editor', 'UKMstimulering_rapport', 'UKMstimulering_rapport');
		$subpage3 = add_submenu_page('UKMstimulering', 'Idébank', 'Idébank', 'editor', 'UKMstimulering_idebank', 'UKMstimulering_idebank');
		add_action( 'admin_print_styles-' . $page, 'UKMdokumenter_sns' );	
		add_action( 'admin_print_styles-' . $subpage1, 'UKMdokumenter_sns' );	
		add_action( 'admin_print_styles-' . $subpage2, 'UKMdokumenter_sns' );	
		add_action( 'admin_print_styles-' . $subpage3, 'UKMWP_support_scriptsandstyles' );	
	
		$supportpage = add_submenu_page('index.php', 'Brukerstøtte', 'Brukerstøtte', 'subscriber', 'UKMwpd_support', 'UKMwpd_support');
		$supportpage2 = add_submenu_page('index.php', 'Brukerstøtte', 'Brukerstøtte', 'author', 'UKMwpd_support', 'UKMwpd_support');
		$supportpage2 = add_submenu_page('index.php', 'Brukerstøtte', 'Brukerstøtte', 'editor', 'UKMwpd_support', 'UKMwpd_support');
		#$supportpage2 = add_submenu_page('index.php', 'Brukerstøtte', 'Brukerstøtte', 'administrator', 'UKMwpd_support', 'UKMwpd_support');

		add_action( 'admin_print_styles-' . $supportpage, 'UKMWP_support_scriptsandstyles' );
		add_action( 'admin_print_styles-' . $supportpage2, 'UKMWP_support_scriptsandstyles' );

		// Add notification about dates!
		add_filter('UKMWPDASH_messages', 'UKMstimulering_message');
	}
	
}

function UKMwpd_network_menu() {
	$page = add_menu_page('Stimuleringsmidler', 'Stimuleringsmidler', 'superadmin', 'UKMsmadmin', 'UKMsmadmin', 'http://ico.ukm.no/cash-menu.png');
	add_action( 'admin_print_styles-' . $page, 'UKMWP_support_scriptsandstyles' );
}


function UKMdokumenter_sns() {
	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
}

function UKMstimulering() {
	require_once('UKM/inc/twig-admin.inc.php');
	$TWIGdata = array();
	$PAGE_SLUG = 'stimuleringsmidler';
	require_once('controller/page.controller.php');
	echo TWIG('page.twig.html', $TWIGdata, dirname(__FILE__));
}

function UKMsmadmin() {
	$TWIGdata = array();
	require_once('controller/network/smadmin.controller.php');
	$TWIGdata['frister'] = UKMstimulering_frister();
	$TWIGdata['f'] = UKMsmadmin_page();
	#var_dump($TWIGdata);
	echo TWIG('network/smadmin.twig.html', $TWIGdata, dirname(__FILE__));

}

function UKMstimulering_message( $MESSAGES ) {
	require_once('controller/network/smadmin.controller.php');
	$frister = UKMstimulering_frister();

	#var_dump($frister);

	$today = date("c");
	#$d = new DateTime();
	#$d->setDate(date("Y"), "12", "27");
	#$today = $d->getTimestamp();
	$redDate = $today+7*3600*24; // 7 days from today
	$yellowDate = $today+21*3600*24; // 3 weeks from today
	foreach ($frister as $frist) {
		#echo '<br />';
		#var_dump($frist->getTimestamp()); var_dump($today);
		if ($today < $frist->getTimestamp() && $redDate >= $frist->getTimestamp()) {
			$MESSAGES[] = array(
				'level' => 'alert-danger',
				'header' => 'Snart frist for stimuleringsmidler',
				'body' => 'Under én uke til fristen går ut!<br />Søknadsfrist '.$frist->format("d.m").'.',
			);
		} 
		elseif ($today < $frist->getTimestamp() && $yellowDate >= $frist->getTimestamp()) {
			$MESSAGES[] = array(
				'level' => 'alert-warning',
				'header' => 'Snart frist for stimuleringsmidler',
				'body' => 'Søknadsfrist '.$frist->format("d.m").'.'
			);
		}
	}

	return $MESSAGES;
}


function UKMstimulering_idebank() {
	require_once('UKM/inc/twig-admin.inc.php');
	$TWIGdata = array();
	$POST_QUERY = 'cat=74';
	require_once(dirname(__FILE__).'/controller/news.controller.php');
	echo TWIG('stimuleringsmidler_idebank.twig.html', $TWIGdata, dirname(__FILE__));
}
function UKMstimulering_sok() {
	require_once('UKM/inc/twig-admin.inc.php');
	$TWIGdata = array();
	$PAGE_SLUG = 'stimuleringsmidler/stimuleringsmidler-soknadsskjema';
	require_once('controller/page.controller.php');
	echo TWIG('page.twig.html', $TWIGdata, dirname(__FILE__));
}
function UKMstimulering_rapport() {
	require_once('UKM/inc/twig-admin.inc.php');
	$TWIGdata = array();
	$PAGE_SLUG = 'stimuleringsmidler/stimuleringsmidler-rapportskjema';
	require_once('controller/page.controller.php');
	echo TWIG('page.twig.html', $TWIGdata, dirname(__FILE__));
}


function UKMdokumenter() {
	require_once('UKM/inc/twig-admin.inc.php');
	$TWIGdata = array();
	require_once('controller/dokumenter.controller.php');
	echo TWIG('dokumenter.twig.html', $TWIGdata, dirname(__FILE__));
}

function UKMwpd_support() {
	require_once('UKM/inc/twig-admin.inc.php');
	require_once('wp_dashboard_functions.php');
	$TWIGdata = array('site_type' => get_option('site_type'),
					  'kontakter' => UKMWP_kontakter()
					 );
	echo TWIG('kontakt.twig.html', $TWIGdata, dirname(__FILE__));
}

function UKMWP_dash() {
	global $wp_version;
	$wpdash_version = get_site_option('ukmwp_dash_version');
	// If WP is updated, rewrite wp-admin/index.php
	if($wp_version != $wpdash_version)
		UKMWP_dash_update();
}

// Will re-write wp-admin/index.php to use custom dashboard
function UKMWP_dash_update() {
	global $wp_version;

	// UPDATE STANDARD DASHBOARD
	$admind_path = ABSPATH.'wp-admin/index.php';
	
	$admind_content = file_get_contents($admind_path);
	require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

	$admind_dash_orig = "ABSPATH . 'wp-admin/includes/dashboard.php'";
	$admind_dash_ukm  = "'". plugin_dir_path( __FILE__ ).'wp_dashboard.php'."'";

	$admind_content = str_replace($admind_dash_orig, $admind_dash_ukm, $admind_content);

	if( !is_writable( $admind_path ))
		UKMWP_dash_update_error('File not writeable');
	$fp = fopen($admind_path, 'w');
	
	if( !$fp )
		UKMWP_dash_update_error('File open denied');
	if( !fwrite($fp, $admind_content))
		UKMWP_dash_update_error('File write error');
	
	fclose($fp);


	// UPDATE NETWORK DASHBOARD
	$admind_path = ABSPATH.'wp-admin/network/index.php';
	
	$admind_content = file_get_contents($admind_path);

	$admind_dash_orig = "ABSPATH . 'wp-admin/includes/dashboard.php'";
	$admind_dash_ukm  = "'". plugin_dir_path( __FILE__ ).'wp_network_dashboard.php'."'";

	$admind_content = str_replace($admind_dash_orig, $admind_dash_ukm, $admind_content);

	if( !is_writable( $admind_path ))
		UKMWP_dash_update_error('File not writeable');
	$fp = fopen($admind_path, 'w');
	
	if( !$fp )
		UKMWP_dash_update_error('File open denied');
	if( !fwrite($fp, $admind_content))
		UKMWP_dash_update_error('File write error');
	
	fclose($fp);

	update_site_option('ukmwp_dash_version', $wp_version);
}

function UKMWP_dash_update_error($source='ukjent') {
	require_once('UKM/mail.class.php');
	$mail = new UKMmail();
	$mail->to('support@ukm.no,marius@ukm.no,jardar@ukm.no')
		 ->subject('WORDPRESS UPDATE ERROR!')
		 ->text('<h3>Under oppdatering av wordpress feilet oppdateringen av index.php, '
		 	   .'som medfører at UKM-dashboardet ikke lenger er tilgjengelig.</h3>'
		 	   .'<p style="font-weight:bold;color:#ff0000;">Dette må fikses ASAP!</p>'
		 	   .'<p><strong>Feilkilde: </strong>'. $source .'</p>'
   		 	   .'<p><em>Funksjonalitet for dette ligger i UKMwp_dashboard.git, filen ukmdashboard.php</em></p>'
   		 	   )
   		 ->ok();
}

function UKMWP_support_scriptsandstyles() {
	wp_enqueue_style('UKMwp_dashboard_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_dashboard.css');
	
	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
}

function UKMWP_dash_scriptsandstyles() {
	$screen = get_current_screen();
	if( $screen->base == 'dashboard' || $screen->base == 'dashboard-network' ) {
		wp_enqueue_style('UKMwp_dash_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_dash.css');
		wp_enqueue_script('WPbootstrap3_js');
		wp_enqueue_style('WPbootstrap3_css');

		if( $screen->base == 'dashboard' ) {
			wp_enqueue_style('UKMwp_dashboard_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_dashboard.css');
			wp_enqueue_script('GOOGLEchart', 'https://www.google.com/jsapi');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jqueryGoogleUI', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
			
			wp_enqueue_script('pushtofront', plugin_dir_url( __FILE__ ).'/js/pushtofront.jquery.js');
			wp_enqueue_script('blogvalg', plugin_dir_url( __FILE__ ) .'/js/blogvalg.jquery.js');

			wp_enqueue_media();
			wp_enqueue_style('UKMresources_tabs');
			wp_enqueue_script('profil', plugin_dir_url(__FILE__) .'/js/profil.jquery.js');

		}
		if( $screen->base == 'dashboard-network' ) {
			wp_enqueue_style('UKMwp_dashboard_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_network_dashboard.css');
			wp_enqueue_script('UKMwp_network_dashboard_timagojs',  plugin_dir_url( __FILE__ )  . 'js/timeago.jquery.js' );
			wp_enqueue_script('UKMwp_network_dashboard_fastlivefilterjs',  plugin_dir_url( __FILE__ )  . 'js/fastlivefilter.jquery.js' );
			wp_enqueue_script('UKMwp_network_dashboard_js',  plugin_dir_url( __FILE__ )  . 'js/wp_network_dashboard.js' );
	
		}
	}
}
?>
