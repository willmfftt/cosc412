<?php

class SupervisorController {
	
	public function index() {
		echo Template::instance()->render('ui/supervisor/index.html');
	}
	
	public function beforeroute() {
		$f3 = Base::instance();
	
		if (!$f3->exists('SESSION.oauth')) {
			$f3->reroute('/');
		}
	}
	
}