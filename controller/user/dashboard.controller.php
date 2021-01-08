<?php
use UKMNorge\Nettverk\Omrade;
global $current_user;

$TWIGdata['blogs'] = get_blogs_of_user( $current_user->ID );
$TWIGdata['kurskommune'] = Omrade::getByKommune( UKM_HOSTNAME == 'ukm.dev' ? 5441 : 3303);

/* NEWS */
$POST_QUERY = 'cat=-2';
require_once( UKMwp_innhold::getPluginPath() .'controller/news.controller.php');

require_once('profil.controller.php');
