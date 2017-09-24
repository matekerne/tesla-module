<?php

namespace Admin;

use \controllers\Controller as Controller;

class HomeController
{
	/**
	 *
	 * Show home page and status user
	 *
	*/
	public function index()
	{
		if (!isset($_SESSION['user'])) {
			header('Location: /login');
		} else {
			header('Location: /module/tesla/home');
		}
	    require_once(ROOT . '/views/admin/index.php');
	}
}