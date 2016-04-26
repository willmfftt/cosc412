<?php

namespace Dod\Authentication\OAuth;

require_once "/var/www/wmoffitt/vendor/autoload.php";

use OAuth2\Storage\AccessTokenInterface;
use OAuth2\Storage\ClientCredentialsInterface;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\UserCredentialsInterface;
use OAuthAccessTokens;
use OAuthAccessTokensQuery;
use OAuthRefreshTokens;
use OAuthRefreshTokensQuery;
use UserQuery;
use User;

class OAuthStorage implements 
	AccessTokenInterface, 
	ClientCredentialsInterface, 
	RefreshTokenInterface, 
	UserCredentialsInterface {
	
	public function getAccessToken($oauth_token)
	{
		$accessToken = $this->getAccessTokenFromDB($oauth_token);
		
		if ($accessToken === null) {
			return null;
		} else {
			return array(
				'expires'   => $accessToken->getExpires(),
				'user_id'   => $accessToken->getUserId(),
				'client_id' => $accessToken->getClientId(),
				'scope'     => $accessToken->getScope()
			);
		}
	}
	
	public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
	{
		$accessToken = $this->getAccessTokenFromDB($oauth_token);
		
		if ($accessToken === null) {
			$accessToken = new OAuthAccessTokens();
		}
		
		$accessToken->setAccessToken($oauth_token);
		$accessToken->setClientId($client_id);
		$accessToken->setUserId($user_id);
		$accessToken->setExpires($expires);
		$accessToken->setScope($scope);
		$accessToken->save();
	}
		
	private function getAccessTokenFromDB($oauth_token)
	{
		return OAuthAccessTokensQuery::create()->findOneByAccessToken($oauth_token);
	}
	
	public function checkClientCredentials($client_id, $client_secret = null)
	{
		return true;
	}
	
	public function isPublicClient($client_id)
	{
		return true;
	}
	
	public function getClientDetails($client_id)
	{
		return null;
	}
	
	public function getClientScope($client_id)
	{
		return null;
	}
	
	public function checkRestrictedGrantType($client_id, $grant_type)
	{
		return in_array($grant_type, ['password', 'refresh']);
	}
	
	public function getRefreshToken($oauth_token)
	{
		$refreshToken = $this->getRefreshTokenFromDB($oauth_token);
		
		if ($refreshToken === null) {
			return null;
		} else {
			return array(
				'refresh_token' => $refreshToken->getRefreshToken(),
				'client_id'     => $refreshToken->getClientId(),
				'user_id'		=> $refreshToken->getUserId(),
				'expires'		=> $refreshToken->getExpires(),
				'scope'			=> $refreshToken->getScope()
			);
		}
	}
	
	public function setRefreshToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
	{
		$refreshToken = $this->getRefreshTokenFromDB($oauth_token);
		
		if ($refreshToken === null) {
			$refreshToken = new OAuthRefreshTokens();
		}
		
		$refreshToken->setRefreshToken($oauth_token);
		$refreshToken->setClientId($client_id);
		$refreshToken->setUserId($user_id);
		$refreshToken->setExpires($expires);
		$refreshToken->setScope($scope);
		$refreshToken->save();
	}
	
	public function unsetRefreshToken($oauth_token)
	{
		$refreshToken = $this->getRefreshTokenFromDB($oauth_token);
		
		if ($refreshToken !== null) {
			$refreshToken->delete();
		}
	}
	
	private function getRefreshTokenFromDB($oauth_token)
	{
		return OAuthRefreshTokensQuery::create()->findOneByRefreshToken($oauth_token);
	}
	
	public function checkUserCredentials($username, $password)
	{
		$user = $this->getUserFromDB($username);
		
		if ($user === null) {
			return false;
		}
		
		return password_verify($password, $user->getPassword());
	}
	
	public function getUserDetails($username)
	{
		$user = $this->getUserFromDB($username);
		
		if ($user === null) {
			return false;
		} else {
			return array(
				'user_id'   	=> $user->getId(),
				'firstname' 	=> $user->getFirstname(),
				'lastname'      => $user->getLastname(),
				'email_address' => $user->getEmailAddress(),
				'username'		=> $user->getUsername()
			);
		}
	}
	
	private function getUserFromDB($username)
	{
		return UserQuery::create()->findOneByUsername($username);
	}
		
}