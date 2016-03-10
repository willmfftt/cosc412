<?php

namespace Dod\Authentication;

require_once '/var/www/wmoffitt/vendor/autoload.php';

use User;
use Propel\Runtime\Exception\PropelException;
use Dod\Utils\UserUtils;
use PhpRbac\Rbac;
use Dod\Rbac\RoleConstants;

class Register {
	
	public function register($firstName, $lastName, $emailAddress
			, $username, $password, $role, User $creator) {
		if (empty($firstName) 
				|| empty($lastName) 
				|| empty($emailAddress) 
				|| empty($username) 
				|| empty($password)
				|| empty($role)
				|| empty($creator)) {
			return false;
		}
		
		$rbac = new Rbac();
		
		// Check that creator has the right to create this user (i.e. admin rights)
		$roleId = $rbac->Roles->returnId(RoleConstants::getAdminRoleName());
		$isAdmin = $rbac->Users->hasRole($roleId, $creator->getId());
		
		// Creator is not an admin
		if (!$isAdmin) {
			return false;
		}
	
		// Creator is an admin, check that the user we are trying to create doesn't already exist
		if (UserUtils::checkUserExists($username)) {
			return false;
		}
		
		// User doesn't exist, create the user
		$user = new User();
		$user->setFirstname($firstName);
		$user->setLastname($lastName);
		$user->setEmailAddress($emailAddress);
		$user->setUsername($username);
		$user->setPassword(password_hash($password, PASSWORD_BCRYPT));
		
		try {
			$user->save();
		} catch (PropelException $ex) {
			syslog(LOG_ERR, $ex->getMessage());
			return false;
		}
		
		// Set the users role
		$roleId = $rbac->Roles->returnId($role);
		$rbac->Users->assign($roleId, $user->getId());
		
		return true;
	}
	
}