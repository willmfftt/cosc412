<?php

class ManagerController {
	
	public function index() {
		echo Template::instance()->render('ui/manager/index.html');
	}
	
	public function beforeroute() {
		$f3 = Base::instance();
	
		if (!$f3->exists('SESSION.oauth')) {
			$f3->reroute('/');
		}
	}
	
	public function getPAData() {
		
	}
	
	public function getTransactionData() {
		
	}
	
}