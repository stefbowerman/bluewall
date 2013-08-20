<?php

require( __DIR__ . '/bootstrap.php');

	// Move this back into bootstrap once the DB is set up on the live site

	$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	//$results = $db->query("TRUNCATE TABLE instagram_media");

	// Return 1
	$results = $db->query("SELECT data FROM instagram_media ORDER BY created_at DESC LIMIT 1");
	$media = $results[0]['data'];
	$media = unserialize(stripslashes($media));

	// Return 10
	$dbData = new stdClass();
	$dbData->data = array();

	$results = $db->query("SELECT data FROM instagram_media ORDER BY created_at DESC LIMIT 10");
	foreach($results as $r){
		$dbData->data[] = unserialize(stripslashes($r['data']));
	}
	$mediaCollection = New Instagram\Collection\MediaCollection();
	$mediaCollection->setData($dbData);

// $result = $dbLink->query("SELECT data FROM instagram_media 	ORDER BY created_at DESC LIMIT 1");

// $serializedMedia = $result->fetch_row();
// $serializedMedia = $serializedMedia[0];

// $dbData = new stdClass();
// $dbData->data = array(unserialize($serializedMedia));

// $mediaCollection = New Instagram\Collection\MediaCollection();
// $mediaCollection->setData($dbData);

// $media = $mediaCollection->getLast();

require( 'Views/_header.php' );
//require( 'Views/location.php' );
require( 'views/locationArray.php');
require( 'Views/_footer.php' );
