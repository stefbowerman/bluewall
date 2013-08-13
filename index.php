<?php

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Start the session
session_start();

define( 'INSTAGRAM_DIR', __DIR__ . '/Instagram/' );

require( __DIR__ . '/SplClassLoader.php' );
require( __DIR__ . '/config.php');

$loader = new SplClassLoader( 'Instagram', dirname( INSTAGRAM_DIR ) );
$loader->register();

$cache = './cache.json';

if( file_exists($cache) && filemtime($cache) > time() - 60*60 ){
  // If a cache file exists, and it is newer than 1 hour, use it
	$arraySerials = json_decode(file_get_contents($cache),false);
	$collection = array();
	foreach ($arraySerials as $key => $serial)
		$collection[] = unserialize($serial);

	$cacheData = new stdClass();
	$cacheData->data = $collection; // setData needs the $arg to respond to $arg->data
	$media = New Instagram\Collection\MediaCollection();
	$media->setData($cacheData);

}
else{

	$instagram = new Instagram\Instagram;
	$instagram->setAccessToken( $accessToken );

	$location = $instagram->getLocation( $target['id'] );
	$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

	$file_contents = array();
	foreach($media->getData() as $mediaInstance){
	 	$file_contents[] = serialize( $mediaInstance );
	}
	file_put_contents( $cache, json_encode($file_contents) );
}

require( 'views/_header.php' );
require( 'views/location.php' );
require( 'views/_footer.php' );
