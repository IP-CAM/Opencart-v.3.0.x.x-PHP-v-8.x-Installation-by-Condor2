<?php

$squareup_dir = __DIR__;

require_once $squareup_dir . DIRECTORY_SEPARATOR . 'cron_functions.php';

if ($index = squareup_init($squareup_dir)) {
	require_once $index;
}
