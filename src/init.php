<?php

define("RT", __DIR__ . '/..');

set_include_path(get_include_path() . PATH_SEPARATOR . RT .'/vendor/google/apiclient/src');

require_once RT.'/vendor/autoload.php';

// Call set_include_path() as needed to point to your client library.
require_once RT.'/src/EasyYoutube.php';
require_once RT.'/src/helpers.php';
require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';
session_start();

if(file_exists(RT . '/config.php')){
    require_once(RT . '/config.php');
}

ORM::configure('mysql:host=localhost;dbname=' . $db);
ORM::configure('username', $un);
ORM::configure('password', $pw);


$easy = new EasyYoutube($GOOGLE_KEY, $GOOGLE_SECRET);

