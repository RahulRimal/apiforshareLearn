<?php
//DB Params
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "share_learning");

define("SITE_TITLE", "Share Your Learning");

//Paths
define ('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/apiforshareLearn/');
// define ('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/sabaikoBooks/');
define ('BASE_FOLDER', $_SERVER['SERVER_NAME'].'/apiforshareLearn/');


define('POST_FOLDER', 'http://'.$_SERVER['SERVER_NAME'].'/apiforshareLearn/images/posts/');