<?

// fallback for cli
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] ?: realpath(__DIR__.'/../../../');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

// load environment
$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();