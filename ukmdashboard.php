<?php
/* 
Plugin Name: UKM Dashboard
Plugin URI: http://www.ukm-norge.no
Description: Modifiserer Wordpress admin index for å inkludere eget WP-dashboard
Author: UKM Norge / M Mandal 
Version: 2.0 
Author URI: http://mariusmandal.no
*/

require_once('UKM/wp_modul.class.php');

class UKMwp_dashboard extends UKMWPmodul
{
	public static $action = 'dashboard';
	public static $path_plugin = null;

	public static function hook()
	{
		add_action('admin_init', ['UKMwp_dashboard', 'admin_init']);
		add_action('admin_enqueue_scripts', ['UKMwp_dashboard', 'scripts_and_styles']);
		add_action('user_admin_menu', ['UKMwp_dashboard', 'meny']);
	}

	/**
	 * Sjekker om dashboard er aktivert, eller om wordpress er oppdatert siden 
	 * sist override, og dermed krever en ny modifisering av wp-admin/index.php
	 *
	 * @return void
	 */
	public static function admin_init()
	{
		global $wp_version;
		$wpdash_version = get_site_option('ukmwp_dash_version');
		// If WP is updated, rewrite wp-admin/index.php
		if ($wp_version != $wpdash_version) {
			static::doUpdateIndexFile();
		}
	}

	/**
	 * Legg til menyelementer
	 *
	 * @return void
	 */
	public static function meny()
	{
        $support = add_submenu_page(
            'index.php',
            'Brukerstøtte',
            'Brukerstøtte',
            'subscriber',
            'UKMwpd_support',
            ['UKMwp_dashboard', 'renderSupport']
        );

        add_action(
            'admin_print_styles-' . $support,
            ['UKMwp_dashboard', 'support_scripts_and_styles']
        );
	}

	/**
	 * Render brukerstøtte-siden
	 *
	 * @return void
	 */
	function renderSupport()
	{
		echo TWIG('kontakt.html.twig', [], dirname(__FILE__));
	}

	/**
	 * Script og styles for support-siden (kontakt)
	 *
	 * @return void
	 */
	public static function support_scripts_and_styles()
	{
		wp_enqueue_style(
			'UKMwp_dashboard_css',
			plugin_dir_url(__FILE__) . 'css/UKMwp_dashboard.css'
		);

		wp_enqueue_script('WPbootstrap3_js');
		wp_enqueue_style('WPbootstrap3_css');
	}

	/**
	 * Scripts og styles som trengs for de ulike dashboardene
	 *
	 * @return void
	 */
	public static function scripts_and_styles()
	{
        wp_register_style(
            'UKMwp_dash_css',
            plugin_dir_url(__FILE__) . 'css/UKMwp_dash.css'
        );

        $screen = get_current_screen();

		/**
		 * ALLE DASHBOARD
		 */
		if (in_array($screen->base, ['dashboard', 'dashboard-network', 'dashboard-user'])) {
            wp_enqueue_style('UKMwp_dash_css');
            wp_enqueue_style('UKMwp_innhold_style');
			wp_enqueue_script('WPbootstrap3_js');
			wp_enqueue_style('WPbootstrap3_css');

			/**
			 * STANDARD-DASHBOARD
			 */
			if ($screen->base == 'dashboard') {
				wp_enqueue_style(
					'UKMwp_dashboard_css',
					plugin_dir_url(__FILE__) . 'css/UKMwp_dashboard.css'
				);
				wp_enqueue_script(
					'GOOGLEchart',
					'https://www.google.com/jsapi'
				);
				wp_enqueue_script('jquery');
				wp_enqueue_script(
					'jqueryGoogleUI',
					'//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'
				);

				wp_enqueue_script(
					'pushtofront',
					plugin_dir_url(__FILE__) . '/js/pushtofront.jquery.js'
				);
				wp_enqueue_script(
					'blogvalg',
					plugin_dir_url(__FILE__) . '/js/blogvalg.jquery.js'
				);

				wp_enqueue_media();
				wp_enqueue_style('UKMresources_tabs');
				wp_enqueue_script(
					'UKMWPdash_profil',
					plugin_dir_url(__FILE__) . '/js/profil.jquery.js'
				);

				wp_enqueue_style(
					'UKMWPdash_tribute_css',
					plugin_dir_url(__FILE__) . '/css/tribute.css'
				);
				wp_enqueue_script(
					'UKMWPdash_tribute_js',
					plugin_dir_url(__FILE__) . '/js/tribute.min.js'
				);
			}
			/**
			 * NETTVERK-DASHBOARD
			 */
			if ($screen->base == 'dashboard-network') {
				wp_enqueue_style(
					'UKMwp_network_dashboard_css',
					plugin_dir_url(__FILE__) . 'css/UKMwp_network_dashboard.css'
				);
				wp_enqueue_script(
					'UKMwp_network_dashboard_timagojs',
					plugin_dir_url(__FILE__)  . 'js/timeago.jquery.js'
				);
				wp_enqueue_script(
					'UKMwp_network_dashboard_fastlivefilterjs',
					plugin_dir_url(__FILE__)  . 'js/fastlivefilter.jquery.js'
				);
				wp_enqueue_script(
					'UKMwp_network_dashboard_js',
					plugin_dir_url(__FILE__)  . 'js/wp_network_dashboard.js'
				);
			}
		}
	}




	/**
	 * Skriv over wp-admin/index.php med våre modifikasjoner
	 *
	 */
	// Will re-write wp-admin/index.php to use custom dashboard
	public static function doUpdateIndexFile()
	{
		global $wp_version;

		// UPDATE STANDARD DASHBOARD
		$admind_path = ABSPATH . 'wp-admin/index.php';

		$admind_content = file_get_contents($admind_path);
		require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

		$admind_dash_orig = "ABSPATH . 'wp-admin/includes/dashboard.php'";
		$admind_dash_ukm  = "'" . plugin_dir_path(__FILE__) . 'wp_dashboard.php' . "'";

		$admind_content = str_replace($admind_dash_orig, $admind_dash_ukm, $admind_content);

		if (!is_writable($admind_path))
			static::update_error('File not writeable');
		$fp = fopen($admind_path, 'w');

		if (!$fp)
			static::update_error('File open denied');
		if (!fwrite($fp, $admind_content))
			static::update_error('File write error');

		fclose($fp);

		// UPDATE NETWORK DASHBOARD
		$admind_path = ABSPATH . 'wp-admin/network/index.php';

		$admind_content = file_get_contents($admind_path);

		$admind_dash_orig = "ABSPATH . 'wp-admin/includes/dashboard.php'";
		$admind_dash_ukm  = "'" . plugin_dir_path(__FILE__) . 'wp_network_dashboard.php' . "'";

		$admind_content = str_replace($admind_dash_orig, $admind_dash_ukm, $admind_content);

		if (!is_writable($admind_path))
			static::update_error('File not writeable');
		$fp = fopen($admind_path, 'w');

		if (!$fp)
			static::update_error('File open denied');
		if (!fwrite($fp, $admind_content))
			static::update_error('File write error');

		fclose($fp);

		update_site_option('ukmwp_dash_version', $wp_version);
	}

	public static function update_error($source = 'ukjent')
	{
		require_once('UKM/mail.class.php');
		$mail = new UKMmail();
		$mail->to('support@ukm.no,marius@ukm.no,jardar@ukm.no')
			->subject('WORDPRESS UPDATE ERROR!')
			->text(
				'<h3>Under oppdatering av wordpress feilet oppdateringen av index.php, '
					. 'som medfører at UKM-dashboardet ikke lenger er tilgjengelig.</h3>'
					. '<p style="font-weight:bold;color:#ff0000;">Dette må fikses ASAP!</p>'
					. '<p><strong>Feilkilde: </strong>' . $source . '</p>'
					. '<p><em>Funksjonalitet for dette ligger i UKMwp_dashboard.git, filen ukmdashboard.php</em></p>'
			)
			->ok();
	}
}
UKMwp_dashboard::init( __DIR__ );
UKMwp_dashboard::hook();