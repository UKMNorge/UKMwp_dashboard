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

function UKMwpd_menu() {
	$page = add_menu_page('Dokumenter', 'Dokumenter', 'editor', 'UKMdokumenter', 'UKMdokumenter', 'http://ico.ukm.no/news-16.png',3);
	add_action( 'admin_print_styles-' . $page, 'UKMdokumenter_sns' );	
	$supportpage = add_submenu_page('index.php', 'Brukerstøtte', 'Brukerstøtte', 'editor', 'UKMwpd_support', 'UKMwpd_support');
	add_action( 'admin_print_styles-' . $supportpage, 'UKMWP_support_scriptsandstyles' );	
}

function UKMdokumenter_sns() {
	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
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
	if($wp_version != $wpdash_version || true)
		UKMWP_dash_update();
}

// Will re-write wp-admin/index.php to use custom dashboard
function UKMWP_dash_update() {
	global $wp_version;

	$admind_path = ABSPATH.'wp-admin/index.php';
	
	$admind_content = file_get_contents($admind_path);
	require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

	$admind_dash_orig = "ABSPATH . 'wp-admin/includes/dashboard.php'";
	$admind_dash_ukm  = "'". plugin_dir_path( __FILE__ ).'wp_dashboard.php'."'";

	$admind_content = str_replace($admind_dash_orig, $admind_dash_ukm, $admind_content);

	if( $_SERVER['REMOTE_ADDR'] == '81.0.146.162' ) {
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		var_dump($admind_path);
		$fp = fopen($admind_path, 'w');
		fwrite($fp, $admind_content);
		fclose($fp);
	}
	
	update_site_option('ukmwp_dash_version', $wp_version);
}


function UKMWP_support_scriptsandstyles() {
	wp_enqueue_style('UKMwp_dashboard_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_dashboard.css');
	
	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
}

function UKMWP_dash_scriptsandstyles() {
	$screen = get_current_screen();
	
	if( $screen->base == 'dashboard' ) {
		wp_enqueue_style('UKMwp_dashboard_css', plugin_dir_url( __FILE__ ) .'/css/UKMwp_dashboard.css');
		
		wp_enqueue_script('WPbootstrap3_js');
		wp_enqueue_style('WPbootstrap3_css');
	}
}
?>