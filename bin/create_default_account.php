<?php

require_once '/var/www/wmoffitt/vendor/autoload.php';

use Dod\Utils\UserUtils;
use PhpRbac\Rbac;
use Dod\Rbac\RoleConstants;

$rbac = new Rbac();

if (!UserUtils::checkUserExists("admin") 
		&& $rbac->Roles->returnId(RoleConstants::getAdminRoleName()) !== null) {
	$user = new User();
	$user->setFirstname("admin");
	$user->setLastname("admin");
	$user->setEmailAddress("admin@dod.gov");
	$user->setUsername("admin");
	$user->setPassword(password_hash("p@zzw0rd!", PASSWORD_BCRYPT));
	$user->save();

	$rbac->Users->assign(RoleConstants::getAdminRoleName(), $user->getId());
}