Blue Wall
========

Instagram photo stream for the Girth™ Lab space in downtown LA.

View the app live at [bluewall.stefanbowerman.com](http://bluewall.stefanbowerman.com)


To get the access token, first authorize, and save the code that comes back.
```php
$auth_config = array(
	'client_id'         => /* Client ID Goes Here */,
	'client_secret'     => /* Client Secret Goes Here */,
	'redirect_uri'      => /* Redirect URL */,
	'scope'             => array( 'likes', 'comments', 'relationships' )
);

$auth = new Instagram\Auth( $auth_config );
$auth->authorize();

$code = $_GET['code']; // '60a58ca70f7449319d01e059fcecd0ef' <- Something like this
```

Then call getAccessToken to retrieve the token.
```php
$accessToken = $auth->getAccessToken( $code );
```

To setup the DB table
```SQL
CREATE TABLE `instagram_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instagram_id` varchar(255) NOT NULL,
  `data` blob NOT NULL,
  `created_at` int(11) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instagram_id` (`instagram_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

```

To set the location, fill out the id, latitude, and longitude inside config.php 
```php
$target = array(
        'id'           => /* Instagram Location ID */,
        'idFourSquare' => /* FourSquare Location ID (Not Required) */,
        'latitude'     => /* Latitude (Str) */,
        'longitude'    => /* Longitude (Str) */
);
```
