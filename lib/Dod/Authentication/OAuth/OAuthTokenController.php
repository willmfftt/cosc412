<?php

namespace Dod\Authentication\OAuth;

require_once "/var/www/wmoffitt/vendor/autoload.php";

use OAuth2\Request;
use Dod\Authentication\OAuth\OAuthServer;

class OAuthTokenController 
{
	private $server;
	
	public function __construct()
	{
		$this->server = OAuthServer::getServer();
	}
	
	public function handleTokenRequest()
	{
		return $this->server->handleTokenRequest(Request::createFromGlobals());
	}
	
	public function getAccessTokenData()
	{
		return $this->server->getAccessTokenData(Request::createFromGlobals());
	}
}