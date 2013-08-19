<?php

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Start the session
session_start();

define( 'INSTAGRAM_DIR', __DIR__ . '/Instagram/' );

require( __DIR__ . '/SplClassLoader.php' );
require( __DIR__ . '/config.php' );

// Include all Lib files
foreach (glob(__DIR__ . '/Lib/*.php') as $filename)
{
    include $filename;
}

$cache   = new AppCache('./cache.json');
$browser = new Browser();
$loader  = new SplClassLoader( 'Instagram', dirname( INSTAGRAM_DIR ) );

$loader->register();


// $dbLink = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// /* check connection */
// if (mysqli_connect_errno()) {
//     printf("Connect failed: %s\n", mysqli_connect_error());
//     exit();
// }

// $dbLink->select_db( DB_NAME );