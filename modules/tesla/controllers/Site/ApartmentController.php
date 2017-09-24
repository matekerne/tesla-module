<?php

namespace Site;

use \controllers\Controller as Controller;
use \Admin\Reserve as Reserve;

class ApartmentController extends Controller
{
	public $apartment;
	private $reserve;

	public function __construct()
	{
		$this->apartment = new Apartment();
		$this->reserve = new Reserve();
	}

	public function index()
	{
		$condition = $_GET['operator'] . $_GET['field'] . $_GET['symbol'] . $_GET['floor'];
		
		$apartments = $this->apartment->get_all($condition);
		
		$response = [];
		if ($apartments) {
			$response['status'] = 'success';

			$i = 0;
			foreach ($apartments as $apartment) {			
				$response[$i]['id'] = $apartment['id'];
				$response[$i]['floor'] = $apartment['floor'];
				$response[$i]['num'] = $apartment['num'];
				$response[$i]['price'] = $apartment['price'];
				$response[$i]['status'] = $apartment['status'];
				$response[$i]['type'] = $apartment['type'];
				$response[$i]['total_area'] = $apartment['total_area'];
				$response[$i]['factual_area'] = $apartment['factual_area'];
				$response[$i]['windows'] = $apartment['windows'];
				$i++;
			}
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, порпобуйте позже';
		}

		echo json_encode($response);
	}

	public function lead()
	{
		$this->check_request($_POST);

		$data = [];
		$data['apartment_id'] = $_POST['apartment_id'];
		$data['apartment_num'] = $_POST['apartment_num'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['phone'] = $_POST['phone'];
		$data['email'] = $_POST['email'];

		$result = $this->apartment->lead($data);
		
		$response = [];	
		if ($result) {
			$response['status'] = 'success';
			$response['message'] = 'Заявка на покупку отправленна';		
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, попробуйте позже';
		}

		echo json_encode($response);
	}

	public function reserve()
	{
		$this->check_request($_POST);

		$data = [];
		$data['apartment_id'] = $_POST['apartment_id'];
		$data['apartment_num'] = $_POST['apartment_num'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['phone'] = $_POST['phone'];
		$data['email'] = $_POST['email'];

		$reserves = $this->reserve->get_all();
		$last_settings_reserve = array_shift($reserves);

		if ($last_settings_reserve) {
			switch ($_SESSION['role_id']) {
				case '3':
					$data['reserve'] = $last_settings_reserve['manager'];
					break;
				case '4':
					$data['reserve'] = $last_settings_reserve['realtor'];
					break;
				default:
					$data['reserve'] = '3';
			}
		} else {
			$data['reserve'] = '3';
		}
		// var_dump($data); die();
		$apartment = $this->apartment->reserve($data);

		$response = [];
		if ($apartment) {
			$response['status'] = 'success';
			$response['message'] = 'Квартира забронирована';
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, попробуйте позже';
		}

		echo json_encode($response);
	}

	public function withdraw_reserve()
	{
		$this->check_request($_POST);

		$data = [];
		$apartment_id = (int) $_POST['apartment_id'];
		$buyer_id = (int) $_POST['buyer_id'];
		$result = $this->apartment->withdraw_reserve($apartment_id, $buyer_id);
		
		$this->check_response($result);

		$response = [];
		if ($result) {
			$response['status'] = 'success';
			$response['message'] = 'Квартира забронирована';
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, попробуйте позже';
		}

		echo json_encode($response);

		return true;

	}

	public function auto_withdraw_reserve()
	{
		$result = $this->apartment->auto_withdraw_reserve();
		$this->check_response($result);
		return true;
	}

	public function actualize()
	{
		$lead = new Lead();

		$implement_leads = json_decode($lead->get_success_implement(), true);
		$implement_apartments = [];
		foreach ($implement_leads['response']['leads'] as $implement_lead) {
			$name_num_implement_lead = explode('/', $implement_lead['name']);

			if (count($name_num_implement_lead) >= 2) {			
				$num_implement_lead = $name_num_implement_lead[1];
				array_push($implement_apartments, $num_implement_lead);
			}
		}
		
		$reserve_leads = json_decode($lead->get_reserved(), true);
		$reserve_apartments = [];
		foreach ($reserve_leads['response']['leads'] as $reserve_lead) {
			$name_num_reserve_lead = explode('/', $reserve_lead['name']);;

			if (count($name_num_reserve_lead) >= 2) {
				$num_reserve_lead = $name_num_reserve_lead[1];
				array_push($reserve_apartments, $num_reserve_lead);
			}
		}

		$paid_reserve_leads = json_decode($lead->get_paid_reserve(), true);
		$paid_reserve_apartments = [];
		foreach ($paid_reserve_leads['response']['leads'] as $paid_reserve_lead) {
			$name_num_paid_reserve_lead = explode('/', $paid_reserve_lead['name']);;

			if (count($name_num_paid_reserve_lead) >= 2) {
				$num_paid_reserve_lead = $name_num_paid_reserve_lead[1];
				array_push($paid_reserve_apartments, $num_paid_reserve_lead);
			}
		}

		$closed_not_implement_leads = json_decode($lead->get_closed_not_implement(), true);
		$closed_not_implement_apartments = [];
		foreach ($closed_not_implement_leads['response']['leads'] as $closed_not_implement_lead) {
			$name_num_closed_not_implement_lead = explode('/', $closed_not_implement_lead['name']);;

			if (count($name_num_closed_not_implement_lead) >= 2) {
				$num_closed_not_implement_lead = $name_num_closed_not_implement_lead[1];
				array_push($closed_not_implement_apartments, $num_closed_not_implement_lead);
			}
		}

		$result = $this->apartment->actualize($implement_apartments, $reserve_apartments, $paid_reserve_apartments, $closed_not_implement_apartments);
		// var_dump($result); die();

		$response = [];
		if ($result) {
			$response['status'] = 'success';
			$response['message'] = 'Информация обновлена';
		} else {
			$response['status'] = 'fail';
			$response['message'] = 'Что то пошло не так, порпобуйте позже';
		}

		echo json_encode($response);
	}
}