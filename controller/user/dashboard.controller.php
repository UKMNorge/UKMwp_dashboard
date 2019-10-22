<?php

global $current_user;

$TWIGdata['blogs'] = get_blogs_of_user( $current_user->ID );

require_once('profil.controller.php');