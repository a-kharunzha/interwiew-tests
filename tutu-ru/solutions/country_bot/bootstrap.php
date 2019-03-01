<?

// fallback for cli
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] ?: realpath(__DIR__.'/../../../');

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

// load environment
$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

// connect to DB
global $DB;
$DB  = new fDatabase(
    'mysql',
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_HOST'),
    getenv('DB_PORT')
);

// attach connect to ORM
\fORMDatabase::attach($DB);