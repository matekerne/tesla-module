<?php

namespace Site;

use \controllers\Controller as Controller;

class BuyerController extends Controller
{
	private $buyer;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin', 'senior_manager', 'manager', 'realtor'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);
		$this->buyer = new Buyer();
	}

	public function show()
	{
		$apartment_id = (int) $_GET['apartment_id'];
		$buyers = $this->buyer->show($apartment_id);
		// var_dump($buyers == true); die();
		$response = [];
		if ($buyers) {
			$response['status'] = 'success';

			$i = 0;
			foreach ($buyers as $buyer) {			
				$response[$i]['id'] = $buyer['id'];
				$response[$i]['reservator_id'] = $buyer['reservator_id'];
				$response[$i]['name'] = $buyer['name'];
				$response[$i]['surname'] = $buyer['surname'];
				$response[$i]['phone'] = $buyer['phone'];
				$response[$i]['email'] = $buyer['email'];

				$i++;
			}
		} elseif (count($buyers) <= 0) {
			$response['status'] = 'fail_amo';
			$response['message'] = 'Квартира забронированна в amoCRM. Снимите бронь в amoCRM, перейдите в шахматку и сделайте актуализацию. После этого вы можете создать новую бронь в шахматке.';
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, порпобуйте позже';
		}

		echo json_encode($response);
	}
}