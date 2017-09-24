<?php

namespace Site;

use \controllers\Controller as Controller;

class HomeController extends Controller
{
	public $apartment;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin', 'senior_manager', 'manager', 'realtor'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);

		$this->apartment = new Apartment;
	}

	public function index()
	{
		$floors_types_aparts = $this->apartment->get_floors_types_aparts();
		$apartments = $this->apartment->get_all();
		$general_info_apartments = $this->apartment->get_general_info_apartments();
		// var_dump($general_info_apartments); die();
		$this->check_response($general_info_apartments, $floors_types_aparts, $apartments);

		require_once(ROOT . '/modules/tesla/views/site/index.php');
		return true;
	}
}