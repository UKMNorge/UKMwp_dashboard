<?php
# profil.controller.php
# Updates profile-info associated with a user

/*$updateid = $_GET['updateid'];

if($updateid != $wp_id) {
	echo 'Du prøvde å lagre data til en bruker som ikke er deg!';
	die();
}*/
global $current_user;

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