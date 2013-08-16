<?php

require( __DIR__ . '/bootstrap.php');

	// Move this back into bootstrap once the DB is set up on the live site

	$dbLink = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$dbLink->select_db( DB_NAME );

$result = $dbLink->query("SELECT data FROM instagram_media 	ORDER BY created_at DESC LIMIT 1");

$serializedMedia = $result->fetch_row();
$serializedMedia = $serializedMedia[0];

$dbData = new stdClass();
$dbData->data = array(unserialize($serializedMedia));

$mediaCollection = New Instagram\Collection\MediaCollection();
$mediaCollection->setData($dbData);

$media = $mediaCollection->getLast();

require( 'Views/_header.php' );
require( 'Views/location.php' );
require( 'Views/_footer.php' );
