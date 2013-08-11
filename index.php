<?php

// Turn on error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Start the session
session_start();

define( 'INSTAGRAM_DIR', __DIR__ . '/instagram' );

require( __DIR__ . '/SplClassLoader.php' );
require( __DIR__ . '/config.php');

$loader = new SplClassLoader( 'Instagram', dirname( INSTAGRAM_DIR ) );
$loader->register();

$cache = './cache.json';

// if(file_exists($cache) /*&& filemtime($cache) > time() - 60*60*/ ){
//   // If a cache file exists, and it is newer than 1 hour, use it
//     $mediaData = json_decode(file_get_contents($cache),true); //Decode as an json array
//     //var_dump($mediaData);
//     foreach ($mediaData as $k => $mediaDatum) {
//     	$m = new Media\Instagram;
//     //	$m->setData($mediaDatum);
//     }
// }
// else{

	$loader = new SplClassLoader( 'Instagram', dirname( INSTAGRAM_DIR ) );
	$loader->register();

	$instagram = new Instagram\Instagram;

	// $auth_config = array(
	//     'client_id'         => '096e2b444cfe451c9b7ab8f0da3f58bf',
	//     'client_secret'     => 'edf4fb0ab0d94bbaa75befdcdf294e29',
	//     'redirect_uri'      => 'http://localhost:8888',
	//     'scope'             => array( 'likes', 'comments', 'relationships' )
	// );

	//$auth = new Instagram\Auth( $auth_config );
	//$auth->authorize();
	//$code = $_GET['code'] // '60a58ca70f7449319d01e059fcecd0ef' <- Something like this
	//$accessToken = $auth->getAccessToken( '60a58ca70f7449319d01e059fcecd0ef'));

	$instagram->setAccessToken( $accessToken );

	$location = $instagram->getLocation( $target['id'] );
	$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

	// Create Cache
	$file_contents = array();
	foreach($media->getData() as $mData){
		$file_contents[] = (array)$mData;
	}
	file_put_contents( $cache, json_encode($file_contents) );

	require( 'views/_header.php' );
	require( 'views/location.php' );
	require( 'views/_footer.php' );
//}