<?php

$vendor = dirname(dirname(__FILE__)) . '/vendor/';
if (! realpath($vendor)) {
    die('Please install via Composer before running tests.');
}
if (! defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', $vendor . 'autoload.php');
}

require_once $vendor . 'autoload.php';
unset($vendor);

define('PHPUNIT_RUNNING', 1);
