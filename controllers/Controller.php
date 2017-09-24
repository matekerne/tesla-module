<?php

namespace controllers;

use components\Validator as Validator;
use components\Helper as Helper;

class Controller
{
	use Validator, Helper;

	public $model_namespace = '';
	public $model_name = '';
	private $model;

	// public $module_name = '';
	// public $folder_view = '';
	public $path_to_view = '';
	public $method_get_all = '';

	public $message_on_create = '';
	public $message_on_update = '';
	public $message_on_delete = '';

	public $url_on_update = '';
	
	public $access_roles = '';
	public $access_groups = '';

	public function __construct()
	{
		$roles_groups = [
			'roles' => ["$this->access_roles"],
			'groups' => ["$this->access_groups"]
		];
		$this->check_access($roles_groups);

		$class_name = $this->model_namespace . '\\' . $this->model_name; 
		$this->model = new $class_name();
		// var_dump($class_name); die();

	}

	/**
	 * Show page with all data any essence
	 *
	 */
	public function index()
	{
		// Какие данные нужны?

		$method_name = $this->method_get_all;
		$essences = $this->model->$method_name();

		// var_dump($this->model); die();
		$this->check_response($essences);

		// require_once(ROOT . "/modules/$this->module_name/views/$this->folder_view/index.php");
		require_once(ROOT . "$this->path_to_view/index.php");
		return true;
	}

	/**
	 * Create new essence
	 *
	 */
	public function create()
	{
		$this->check_request($_POST);

		$arr = [$_POST];
		$data = [];
		foreach ($arr as $key => $item) {
			foreach ($item as $key => $value) {
				$data[$key] = $value;
			}
		}

		$this->fill_session_fields($data);
		$essence = $this->model->create($data);

		$this->check_response($essence);
		$this->clean_session_fields($data);

		return $this->redirect("$this->message_on_create");
	}

	/**
	 * Show page for edit essence
	 *
	 */
	public function edit()
	{
		$id = \Router::get_id();
		$essence = $this->model->show($id);

		$this->check_response($essence);
		// var_dump($essence); die();
		// require_once(ROOT . "/modules/$this->module_name/views/$this->folder_view/edit.php");
		require_once(ROOT . "$this->path_to_view/edit.php");
		return true;
	}

	/**
	 * Update essence to db
	 *
	 */
	public function update()
	{
		$this->check_request($_POST);

		$arr = [$_POST];
		$data = [];

		foreach ($arr as $key => $item) {
			foreach ($item as $key => $value) {
				$data[$key] = $value;
			}
		}
		
		$this->fill_session_fields($data);
		$essence = $this->model->update($data);

		$this->check_response($essence);
		$this->clean_session_fields($data);

		return $this->redirect("$this->message_on_update", "$this->url_on_update");
	}
	
	/**
	 * Delete essence to db
	 *
	 */
	public function delete()
	{
		$this->check_request($_POST);

		$id = $_POST['id'];
		$essence = $this->model->delete($id);

		$this->check_response($essence);

		return $this->redirect("$this->message_on_delete");
	}
}