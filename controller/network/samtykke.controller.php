<?php

$sql = new SQL("
    SELECT `status`,
        COUNT(`id`) AS `antall`
    FROM `samtykke_deltaker`
    WHERE `year` = #season
    GROUP BY `status`",
    [
        'season' => get_site_option('season')
    ]
);
$res = $sql->run();

$data = [];
while( $row = SQL::fetch( $res ) ) {
    $data[ $row['status'] ] = $row['antall'];
}

$TWIGdata['samtykke'] = $data;