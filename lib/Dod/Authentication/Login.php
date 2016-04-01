<?php

namespace Dod\Authentication;

require_once '/var/www/wmoffitt/vendor/autoload.php';

use UserQuery;
use User;

class Login {
	
	public function login($username, $password)
	{
		$user = UserQuery::create()->findOneByUsername($username);
		
		if ($user == null) {
			return false;
		}
		
		return password_verify($password, $user->getPassword());
	}
		
}