<?php

namespace Dod\Authentication\OAuth;

require_once "/var/www/wmoffitt/vendor/autoload.php";

use OAuth2\Request;
use Dod\Authentication\OAuth\OAuthServer;

class OAuthResourceController 
{	
	public function verifyResourceRequest()
	{
		$server = OAuthServer::getServer();
		if (!$server->verifyResourceRequest(Request::createFromGlobals())) {
			$server->getResponse()->send();
			die;
		}
	}	
}