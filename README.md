Blue Wall
========

Instagram photo stream for the Girth™ Lab space in downtown LA.


To get the accesstoken, first authorize, and save the code that comes back

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