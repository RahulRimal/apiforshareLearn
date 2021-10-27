<?php
//Start Session
session_start();

// define ('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/ProjectShareBooks/');

//Include Configuration
// require_once('config/config.php');
// require_once(BASE_URI.'config/config.php');
require_once(dirname(__FILE__).'/../config/config.php');


//Helper Function Files
// require_once('helpers/system_helper.php');
// require_once('helpers/format_helper.php');
// require_once('helpers/db_helper.php');
require_once(dirname(__FILE__).'/../helpers/system_helper.php');
require_once(dirname(__FILE__).'/../helpers/format_helper.php');
require_once(dirname(__FILE__).'/../helpers/db_helper.php');

//Autoload Classes
// function __autoload($class_name){
// 	require_once('libraries/'.$class_name . '.php');
// }


function my_autoloader($class_name) {
    // include 'libraries/' . $class_name . '.php';
    include dirname(__FILE__).'/../libraries/' . $class_name . '.php';
}

spl_autoload_register('my_autoloader');

// Or, using an anonymous function

// spl_autoload_register(function ($class) {
//     include 'classes/' . $class . '.class.php';
// });