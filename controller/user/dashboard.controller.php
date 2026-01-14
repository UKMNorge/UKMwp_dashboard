<?php

use UKMNorge\Nettverk\Omrade;
use UKMNorge\UKMWebinar\TeamsUKMWebinarer;

global $current_user;

$TWIGdata['blogs'] = get_blogs_of_user($current_user->ID);
$TWIGdata['kurskommune'] = Omrade::getByKommune(UKM_HOSTNAME == 'ukm.dev' ? 5441 : 9291);

$teamsWebinarer = new TeamsUKMWebinarer();
$TWIGdata['teamsWebinarer'] = $teamsWebinarer->getAlleAcive();
require_once(UKMwp_innhold::getPath() . 'functions/getCategory.function.php');

$category_ids = [];

// Ta ut markedsføringsfilmer
$categories = [
    'markedsforing-filmer' => '-',
    'alle-nyhetsbrev' => '-'
];

foreach( $categories as $category_slug => $action ) {
    $category_data = getCategory($category_slug);
    if( $category_data ) {
        $category_ids[] = $action . $category_data->term_id;
    }
}

/* NEWS */
$POST_QUERY = 'cat=' . implode(',', $category_ids);
require_once(UKMwp_innhold::getPluginPath() . 'controller/news.controller.php');

require_once('profil.controller.php');
