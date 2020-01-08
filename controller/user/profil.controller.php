<?php

global $current_user;

$current_user->meta = new stdClass();
$current_user->meta->avatar = get_user_meta('user_avatar');

$TWIGdata['current_user'] = $current_user;

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$wp_id = $current_user->ID;
	$display_name = $_POST['form_display_name'];
	$desc = $_POST['description'];
	$img = $_POST['avatar_image'];
	// Img kan være usatt

	if ($display_name && $desc && $wp_id) {
		// All info finnes, oppdater bruker.
		$args = array(
			'ID' => $wp_id,
			'display_name' => $display_name,
			'nickname' => $display_name
			);
		#update_user_meta($wp_id, 'nickname', $display_name);
		$res = wp_update_user($args);
		if ( is_wp_error($res) ) {
			die('Klarte ikke å oppdatere brukeren.');
		}

		if($img) {
			update_user_meta($wp_id, 'user_avatar', $img);
		}

		update_user_meta($wp_id, 'description', $desc);
		header('Location: '.$_SERVER['REDIRECT_URL']);
	}
}

/*

DETTE VAR TIDLIGERE I controller/monstring/dashboard

if ($deltakerbruker) {
	// Liste over blogger brukeren har rettigheter til.
	$blogs = get_blogs_of_user($current_user->ID);
	$TWIGdata['blogs'] = $blogs;
	$TWIGdata['current_blog_id'] = get_current_blog_id();
	$TWIGdata['user_avatar'] = get_avatar($current_user->ID);
}

$TWIGdata['user_avatar'] = get_avatar($current_user->ID);
$TWIGdata['current_user'] = $current_user->ID;

*/