<?php

use Dod\Authentication\Login;

class LoginController {
	
	public function render() {
		echo Template::instance()->render('ui/login.html');
	}
	
	public function attemptLogin() {
		$login = new Login();
		$result = $login->login();
		if ($result->getStatusCode() === 200) {
			$f3 = Base::instance();
			$f3->clear("SESSION");
			$f3->set("SESSION.oauth", $result->getParameters());
		} else {
			echo $result;
		}
	}
	
	public function logout() {
		$f3 = Base::instance();
		
		$f3->clear('SESSION');
	}
	
}