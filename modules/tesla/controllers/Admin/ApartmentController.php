<?php

namespace Admin;

use controllers\Controller as Controller;

class ApartmentController extends Controller
{
	public $apartment;
	public $num;
	public $type;
	public $total_areas;
	public $living_areas;
	public $floor;
	public $window;
	public $glazing;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);
		
		$this->apartment = new Apartment;
		$this->type = new Type;
		$this->total_areas = new TotalArea;
		$this->floor = new Floor;
		$this->window = new Window;
		$this->num = new Num;
		$this->glazing = new Glazing;
	}

	public function index()
	{
		$apartments = $this->apartment->get_all();
		$types = $this->type->get_all();
		$total_areas = $this->total_areas->get_all();
		$floors = $this->floor->get_all();
		$windows = $this->window->get_all();
		$nums = $this->num->get_all();
		$glazings = $this->glazing->get_all();

		$this->check_response($apartments, $types, $total_areas, $floors, $nums, $windows, $glazings);

		require_once(ROOT . "/modules/tesla/views/admin/apartment/index.php");
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['type_id'] = $_POST['type_id'];
		$data['total_area_id'] = $_POST['total_area_id'];
		$data['factual_area'] = $_POST['factual_area'];
		$data['floor'] = $_POST['floor'];
		$data['num'] = $_POST['num'];
		$data['price'] = $_POST['price'];
		$data['discount'] = $_POST['discount'];
		$data['status'] = $_POST['status'];
		$data['window'] = $this->get_select2_value('window', $_POST);
		$data['glazing'] = $this->get_checkbox_value('glazing', $_POST);

		
		$this->fill_session_fields($data);
		$apartment = $this->apartment->create($data);
		$this->check_response($apartment);
		$this->clean_session_fields($data);

		return $this->redirect('Квартира создана');
	}

	public function edit()
	{
		$id = \Router::get_id();

		$apartment = $this->apartment->show($id);
		
		$types = $this->type->get_all();
		$total_areas = $this->total_areas->get_all();
		$floors = $this->floor->get_all();
		$windows = $this->window->get_all();
		$nums = $this->num->get_all();
		$glazings = $this->glazing->get_all();
		$apart_glazings = explode(', ', $apartment['glazings']);
		$apart_windows = $this->create_select2_data('windows', $apartment['windows']);
		// var_dump($apartment['windows']); die();

		$this->check_response($apartment, $types, $total_areas, $floors, $nums, $windows, $glazings);

		require_once(ROOT . '/modules/tesla/views/admin/apartment/edit.php');
		return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['id'] = $_POST['id'];
		$data['type_id'] = $_POST['type_id'];
		$data['total_area_id'] = $_POST['total_area_id'];
		$data['factual_area'] = $_POST['factual_area'];
		$data['floor'] = $_POST['floor'];
		$data['num'] = $_POST['num'];
		$data['price'] = $_POST['price'];
		$data['discount'] = $_POST['discount'];
		$data['status'] = $_POST['status'];
		$data['window'] = $this->get_select2_value('window', $_POST);
		$data['glazing'] = $this->get_checkbox_value('glazing', $_POST);

		$this->fill_session_fields($data);
		$apartment = $this->apartment->update($data);
		$this->check_response($apartment);
		$this->clean_session_fields($data);
		
		return $this->redirect('Квартира обновлена', '/module/tesla/admin/apartments');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = (int) $_POST['id'];
		$apartment = $this->apartment->delete($id);
		
		$this->check_response($apartment);

		return $this->redirect('Квартира удалёна');
	}

	public function get_checkbox_value(string $field, array $data)
	{
		if (array_key_exists($field, $data)) {
			return $_POST["$field"];
		} else {
			return $data["$field"] = '';
		}
	}
}