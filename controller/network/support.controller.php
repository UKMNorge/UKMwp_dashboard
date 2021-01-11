<?php

use UKMNorge\Geografi\Fylke;
use UKMNorge\Geografi\Fylker;

require_once('UKM/Autoloader.php');

$TWIGdata['fylker'] = Fylker::getAllInkludertFalske();
