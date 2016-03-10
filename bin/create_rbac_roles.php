<?php

require_once '/var/www/wmoffitt/vendor/autoload.php';

use PhpRbac\Rbac;
use Dod\Rbac\RoleConstants;

$rbac = new Rbac();

// Setup admin role
if (!doesRoleExist($rbac, RoleConstants::getAdminRoleName())) { 
	$rbac->Roles->add(RoleConstants::getAdminRoleName(), "Administrator");
}

// Setup manager role
if (!doesRoleExist($rbac, RoleConstants::getManagerRoleName())) {
	$rbac->Roles->add(RoleConstants::getManagerRoleName(), "Manager");
}

// Setup supervisor role
if (!doesRoleExist($rbac, RoleConstants::getSupervisorRoleName())) {
	$rbac->Roles->add(RoleConstants::getSupervisorRoleName(), "Supervisor");
}

// Setup auditor role
if (!doesRoleExist($rbac, RoleConstants::getAuditorRoleName())) {
	$rbac->Roles->add(RoleConstants::getAuditorRoleName(), "Auditor");
}

// Setup approved user role
if (!doesRoleExist($rbac, RoleConstants::getApprovedUserRoleName())) {
	$rbac->Roles->add(RoleConstants::getApprovedUserRoleName(), "Approved User");
}

// Setup purchasing agent role name
if (!doesRoleExist($rbac, RoleConstants::getPurchasingAgentRoleName())) {
	$rbac->Roles->add(RoleConstants::getPurchasingAgentRoleName(), "Purchasing Agent");
}

function doesRoleExist($rbac, $role) {
	return $rbac->Roles->returnId($role) !== null;
}