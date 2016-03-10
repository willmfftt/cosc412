<?php

namespace Dod\Utils;

require_once '/var/www/wmoffitt/vendor/autoload.php';

use UserQuery;

class UserUtils {
	
	public static function checkUserExists($username) {
		return UserQuery::create()->findOneByUsername($username) != null;
	}
	
	public static function getUserId($username) {
		if (!self::checkUserExists($username)) {
			return false;
		}
		
		$user = UserQuery::create()->findOneByUsername($username);
		
		if ($user == null) {
			return false;
		}
		
		return $user->getId();
	}
	
}