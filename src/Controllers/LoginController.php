<?php

require_once "../../vendor/autoload.php";

use Dod\Authentication\Login;

// if (!isset($_SERVER["PHP_AUTH_USER"]) 
// 		|| !isset($_SERVER["PHP_AUTH_PW"])) {
// 	echo json_encode(array(
// 		"error"  => true,
// 		"reason" => "You must fill in both the username and password fields"
// 	));
// 	die;
// }

// $username = trim(filter_var($_SERVER["PHP_AUTH_USER"]));
// $password = trim(filter_var($_SERVER["PHP_AUTH_PW"]));

$login = new Login();
$success = $login->login();

// if ($success) {
// 	echo json_encode(array(
// 		"error" => false
// 	));
// } else {
// 	echo json_encode(array(
// 		"error"  => true,
// 		"reason" => "Login failed"
// 	));
// }