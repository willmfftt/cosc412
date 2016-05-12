<?php

use BudgetQuery;
use LocationQuery;
use UserQuery;
use Dod\Authentication\OAuth\OAuthStorage;
use Dod\Authentication\Register;
use DodUserrolesQuery;
use DodRolesQuery;

class AdminController {
	
	public function index() {
		echo Template::instance()->render('ui/admin/index.html');
	}
	
	public function renderSetBudget() {
		echo Template::instance()->render('ui/admin/set-budget.html');
	}
	
	public function renderModifyBudget() {
		echo Template::instance()->render('ui/admin/modify-budget.html');
	}
	
	public function renderManageUsers() {
		echo Template::instance()->render('ui/admin/manage-users.html');
	}
	
	public function beforeroute() {
		$f3 = Base::instance();
		
		if (!$f3->exists('SESSION.oauth')) {
			$f3->reroute('/');
		}
	}
	
	public function getCongressBudget() {
		$location = LocationQuery::create()->findOneByName("White House");
		
		$budgetAmount = 0.00;
		if ($location !== null) {
			$budget = BudgetQuery::create()->findOneByArray(
					array('locationId' => $location->getId(), 'branchId' => null));
				
			if ($budget !== null) {
				$budgetAmount = $budget->getAmount();
			}
		}
		
		echo json_encode(array(
				'budgetId' 	   => $budget->getId(),
				'budgetAmount' => $budgetAmount
		));
	}
	
	public function setCongressBudget() {
		if (!array_key_exists('budgetId', $_POST) || !array_key_exists('budgetAmount', $_POST)) {
			echo json_encode(array(
					'success' => false,
					'reason'  => 'Required parameters not set'
			));
			return;
		}
		
		$budgetId = intval(filter_input(INPUT_POST, 'budgetId'));
		$budgetAmount = doubleval(filter_input(INPUT_POST, 'budgetAmount'));
		
		$budget = BudgetQuery::create()->findOneById($budgetId);
		if ($budget === null) {
			echo json_encode(array(
					'success' => false,
					'reason'  => 'Budget not found'
			));
			return;
		}
		
		$budget->setAmount($budgetAmount);
		$budget->save();
		
		echo json_encode(array(
				'success' => true
		));
	}
	
	public function getUsersTable() {
		$users = UserQuery::create()->find();
		
		if ($users === null) {
			return '';
		}
		
		$headerArr = array('Username', 'First Name', 'Last Name', 'Email Address', 'Account Type', 'Actions');
		
		$html = '<thead><tr>';
		foreach ($headerArr as $header) {
			$html .= '<th>' . $header . '</th>';
		}
		$html .= '</tr></thead>';
		
		$html .= '<tfoot><tr>';
		foreach ($headerArr as $header) {
			$html .= '<th>' . $header . '</th>';
		}
		$html .= '</tr></tfoot>';
		
		$html .= '<tbody>';
		foreach ($users as $user) {
			$userRole = DodUserrolesQuery::create()->findOneByUserid($user->getId());
			$role = DodRolesQuery::create()->findOneById($userRole->getRoleid());
			
			$html .= '<tr>';
			$html .= '<td>' . $user->getUsername() . '</td>';
			$html .= '<td>' . $user->getFirstname() . '</td>';
			$html .= '<td>' . $user->getLastname() . '</td>';
			$html .= '<td>' . $user->getEmailAddress() . '</td>';
			$html .= '<td>' . $role->getDescription() . '</td>';
			$html .= '<td style="text-align: center">';
			$html .= '<div id="editUserBtn" class="fa fa-edit" title="Edit User" data-userId="' . $user->getId() . '" data-toggle="modal" data-target="#editUserModal"></div>';
			$html .= '<div id="deleteUserBtn" class="fa fa-trash" title="Delete User" data-userId="' . $user->getId() . '"  data-toggle="modal" data-target="#deleteUserModal"></div>';
			$html .= '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		
		echo $html;
	}
	
	public function createNewUser() {
		if (!array_key_exists('firstname', $_POST) 
				|| !array_key_exists('lastname', $_POST) 
				|| !array_key_exists('emailAddress', $_POST) 
				|| !array_key_exists('username', $_POST) 
				|| !array_key_exists('password', $_POST)
				|| !array_key_exists('role', $_POST)) {
			echo json_encode(array(
					'success' => false,
					'reason'  => 'Required parameters not set'
			));
			return;
		}
		
		$f3 = Base::instance();
		
		$firstname = filter_input(INPUT_POST, 'firstname');
		$lastname = filter_input(INPUT_POST, 'lastname');
		$emailAddress = filter_input(INPUT_POST, 'emailAddress');
		$username = filter_input(INPUT_POST, 'username');
		$password = filter_input(INPUT_POST, 'password');
		$role = filter_input(INPUT_POST, 'role');
		
		$oauth = $f3->get('SESSION.oauth');
		$oauthStorage = new OAuthStorage();
		$accessToken = $oauthStorage->getAccessToken($oauth['access_token']);
		
		if (empty($accessToken)) {
			$f3->reroute('/login');
		}
		
		$userId = $accessToken['user_id'];
		$user = UserQuery::create()->findOneById($userId);
		
		$register = new Register();
		$result = $register->register($firstname, $lastname, $emailAddress, $username, $password, $role, $user);
		
		echo json_encode(array(
				'success' => $result
		));
	}
	
}