<?php

use Dod\Authentication\OAuth\OAuthStorage;
use Dod\Rbac\RoleConstants;
use DodUserrolesQuery;
use DodRolesQuery;

class MainController {
	
	public function render() {
		$this->routeForRole();
	}
	
	public function beforeroute() {
		$f3 = Base::instance();
		
		if (!$f3->exists('SESSION.oauth')) {
			$f3->reroute('/login');
		}
	}
	
	public function routeForRole() {
		$f3 = Base::instance();
		
		$oauth = $f3->get('SESSION.oauth');
		$oauthStorage = new OAuthStorage();
		$accessToken = $oauthStorage->getAccessToken($oauth['access_token']);
		
		if (empty($accessToken)) {
			echo 'Error finding role';
			$f3->reroute('/login');
		} else {
			
			$userId = $accessToken['user_id'];
			$userRole = DodUserrolesQuery::create()->findOneByUserid($userId);
			$role = DodRolesQuery::create()->findOneById($userRole->getRoleid());
			
			if ($role->getTitle() === RoleConstants::getAdminRoleName()) {
				$f3->reroute('/admin');
			}
			
			if ($role->getTitle() === RoleConstants::getManagerRoleName()) {
				$f3->reroute('/manager');
			}
			
			if ($role->getTitle() === RoleConstants::getSupervisorRoleName()) {
				$f3->reroute('/supervisor');
			}
			
			if ($role->getTitle() === RoleConstants::getAuditorRoleName()) {
				$f3->reroute('/auditor');
			}
			
			if ($role->getTitle() === RoleConstants::getApprovedUserRoleName()) {
				$f3->reroute('/approved-user');
			}
			
			if ($role->getTitle() === RoleConstants::getPurchasingAgentRoleName()) {
				$f3->reroute('/purchasing-agent');
			}
			
			// No role id, go back to login (should show an error)
			$f3->reroute('/login');
		}
	}
	
}