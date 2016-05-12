<?php

namespace Dod\Rbac;

use PhpRbac\Rbac;

class RbacHelper {
	
	public static function getRoleId(Rbac $rbac, $roleName) {
		return $rbac->Roles->returnId($roleName);
	}
	
	public static function doesUserHaveRole(Rbac $rbac, $roleId, $userId) {
		return $rbac->Users->hasRole($roleId, $userId);
	}
	
}