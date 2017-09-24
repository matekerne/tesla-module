<?php

/*
	Статусы квартир:
		- 1 (свободна)
		- 2 (забронирована)
		- 3 (продана)
		- 4 (оплаченная бронь)

	Роли пользователь:
		- 1 (Администратор)
		- 2 (Старший менеджер)
		- 3 (Менеджер)
		- 4 (Риэлтор)
		- 5 (Руководитель)
*/
		
// Config
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Connect files
define('ROOT', dirname(__FILE__));
//define('ROOT', '/home/i/inpkhost/inpk-development.ru_crm/public_html');
require_once(ROOT . '/components/Router.php');

// Start router
$router = new Router();
$router->run();