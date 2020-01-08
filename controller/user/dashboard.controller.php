<?php

global $current_user;

$TWIGdata['blogs'] = get_blogs_of_user( $current_user->ID );

/* NEWS */
$POST_QUERY = 'cat=-2';
require_once( UKMwp_innhold::getPluginPath() .'controller/news.controller.php');

require_once('profil.controller.php');