<?php

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Start the session
session_start();

define( 'INSTAGRAM_DIR', __DIR__ . '/Instagram/' );
define( 'LIB_DIR', __DIR__ . '/Lib' );

require( __DIR__ . '/SplClassLoader.php' );
require( __DIR__ . '/config.php' );
require( LIB_DIR . '/Utils.php' );

$loader = new SplClassLoader( 'Instagram', dirname( INSTAGRAM_DIR ) );
$loader->register();