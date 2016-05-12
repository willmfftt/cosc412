<?php

require_once '../vendor/autoload.php';

$f3 = Base::instance();

$f3->set('AUTOLOAD', 'app/controllers/');
$f3->set('DEBUG', '3');

$f3->route('GET /', 'MainController->render');
$f3->route('GET /routeForRole', 'MainController->routeForRole');

$f3->route('GET /login', 'LoginController->render');
$f3->route('POST /login', 'LoginController->attemptLogin');
$f3->route('POST /logout', 'LoginController->logout');

$f3->route('GET /admin', 'AdminController->index');
$f3->route('GET /admin/setBudget', 'AdminController->renderSetBudget');
$f3->route('GET /admin/modifyBudget', 'AdminController->renderModifyBudget');
$f3->route('GET /admin/manageUsers', 'AdminController->renderManageUsers');
$f3->route('GET /admin/getCongressBudget', 'AdminController->getCongressBudget');
$f3->route('POST /admin/setCongressBudget', 'AdminController->setCongressBudget');
$f3->route('GET /admin/getUsersTable', 'AdminController->getUsersTable');
$f3->route('POST /admin/createNewUser', 'AdminController->createNewUser');

$f3->route('GET /supervisor', 'SupervisorController->index');

$f3->route('GET /manager', 'ManagerController->index');
$f3->route('GET /manager/getPAData', 'ManagerController->getPAData');
$f3->route('GET /manager/getTransactionData', 'ManagerController->getTransactionData');

$f3->run();
