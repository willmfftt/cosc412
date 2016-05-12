<?php

namespace Dod\Authentication;

require_once '/var/www/wmoffitt/vendor/autoload.php';

use Dod\Authentication\OAuth\OAuthTokenController;

class Login {
	
	public function login()
	{
		$tokenController = new OAuthTokenController();
		return $tokenController->handleTokenRequest();
	}
		
}