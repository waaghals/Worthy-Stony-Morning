<?php

use Aggressiveswallow\Tools\Autoloader;

/**
 * @def (string) DS - Directory separator.
 */
define("DS", "/", true);

/**
 * @def (resource) BASE_PATH - get a base path.
 */
define('BASE_PATH', realpath(dirname(__FILE__)) . DS, true);

/**
 * @def (resource) SRC_PATH - path to src files
 */
define('SRC_PATH', BASE_PATH . "src" . DS, true);

/**
 * @def (resource) VENDOR_PATH - path to src files
 */
define('VENDOR_PATH', SRC_PATH . "worthyStonyMorning" . DS, true);

/**
 * @def (resource) VIEW_PATH - path to view files
 */
define('VIEW_PATH', VENDOR_PATH . "views" . DS, true);

setlocale(LC_ALL, 'nl_NL');

require SRC_PATH . "Aggressiveswallow" . DS . "tools" . DS . "autoloader.php";

$loader = new Autoloader();
$loader->setSourceLocation("src");
$loader->register();

require 'register.inc.php';
