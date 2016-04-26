<?php

namespace Dod\Authentication\OAuth;

require_once "/var/www/wmoffitt/vendor/autoload.php";

use OAuth2\Server;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\RefreshToken;
use Dod\Authentication\OAuth\OAuthStorage;

class OAuthServer {
	
	public static function getServer() 
	{
		$storage = new OAuthStorage();
		$server = new Server($storage);
		
		$userCredGrant = new UserCredentials($storage);
		$refreshTokenGrant = new RefreshToken($storage, array(
			'always_issue_new_refresh_token' => true
		));
		$server->addGrantType($userCredGrant);
		$server->addGrantType($refreshTokenGrant);
		
		return $server;
	}
	
}