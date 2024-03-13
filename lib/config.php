<?php
date_default_timezone_set('Asia/Jakarta');

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
$config['host']				= 'https://asisten-tulis.theaxe.net';
$config['telegram_token']	= '1279356572:AAGUZgiXZ71eewOIGoDQe1bcpd_zaEgBGSc';

//Require
include('function.class.php');
include('ssp.class.php');
?>