<?php
date_default_timezone_set('Asia/Jakarta');

// Set error reporting to display all errors and log them to a file
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// ini_set('log_errors', 1);
// ini_set('error_log', 'error.log');

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

//Database Configuration
$sql_details			= array();
$sql_details['user']    = $_ENV['DB_USER'] ?? '';
$sql_details['pass']    = $_ENV['DB_PASS'] ?? '';
$sql_details['db']      = $_ENV['DB_NAME'] ?? '';
$sql_details['host']    = $_ENV['DB_HOST'] ?? '';

// Connection
$conn = mysqli_connect($sql_details['host'], $sql_details['user'], $sql_details['pass'], $sql_details['db']);
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

//Config
$config['host']				= $_ENV['HOST'];
$config['telegram_token']	= $_ENV['TELEGRAM_TOKEN'];

//Require
include('function.class.php');
include('ssp.class.php');
?>