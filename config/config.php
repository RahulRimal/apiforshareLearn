<?php
//DB Params
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "share_learning");

define("SITE_TITLE", "Share Your Learning");

//Paths
// define ('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/shareLearning/');

define('BASE_URI', 'http://' . $_SERVER['SERVER_NAME'] . '/ProjectShareBooks/');

date_default_timezone_set("Asia/Kathmandu");

header('Content-type:application/json;');

header('Access-Control-Allow-Origin: *');
header('Access-Control_Allow_Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Accept");
