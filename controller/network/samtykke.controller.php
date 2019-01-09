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

$data = [
    'ikke_send' => 0,
    'ikke_sendt' => 0,
    'ikke_sett' => 0,
    'ikke_svart' => 0,
    'ikke_godkjent' => 0,
    'godkjent' => 0
];
while( $row = SQL::fetch( $res ) ) {
    $data[ $row['status'] ] = $row['antall'];
}

$TWIGdata['samtykke'] = $data;