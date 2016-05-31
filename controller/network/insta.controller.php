<?php

require_once('UKM/sql.class.php');

$monday = new DateTime('this monday');
$qry = new SQL("SELECT COUNT(*) FROM `ukm_insta_bilder` WHERE `created_time` > '#weekstart'", array('weekstart' => $monday->format("U")));
#echo $qry->debug();
$UKMinsta = new stdClass();
$UKMinsta->posts_this_week = $qry->run("field", "COUNT(*)");

$TWIGdata['UKMinsta'] = $UKMinsta;
