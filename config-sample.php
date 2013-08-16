<?php 

/** MySQL DB Name */
define('DB_NAME', 'new-db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. */
define('DB_COLLATE', '');

$clientID     = /* Client ID Goes Here */;
$clientSecret = /* Client Secret Goes Here */;
$accessToken  = /* Access Token Goes Here */;

$target = array(
	'id'           => /* Instagram Location ID */,
	'idFourSquare' => /* FourSquare Location ID (Not Required) */,
	'latitude'     => /* Latitude (Str) */,
	'longitude'    => /* Longitude (Str) */
);

$mentionsClosure = function($m){
    return sprintf( '<a href="//instagram.com/%s">%s</a>', $m[1], $m[0] ); /* Do whatever you want with mentions here */
}; 

$timeFormat = 'n.j.Y' ; /* String for time formatting */