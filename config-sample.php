<?php 

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