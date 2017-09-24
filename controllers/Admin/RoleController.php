<?php

namespace Admin;

use \controllers\Controller as Controller;

class RoleController extends Controller
{
	protected $role;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);

		$this->role = new Role();
	}

	public function index()
	{
		$roles = $this->role->get_roles();
		$this->check_response($roles);

		require_once(ROOT . '/views/admin/role/index.php');
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['name'] = $_POST['name'];
		
		$this->fill_session_fields($data);
		$role = $this->role->create($data);

		$this->check_response($role);
		$this->clean_session_fields($data);

		return $this->redirect('Роль создана');
	}

	public function edit()
	{
		$id = \Router::get_id();
		$role = $this->role->show($id);

		$this->check_response($role);

		require_once(ROOT . '/views/admin/role/edit.php');
		return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['id'] = $_POST['role_id'];
		$data['name'] = $_POST['name'];

		$this->fill_session_fields($data);
		$role = $this->role->update($data);

		$this->check_response($role);
		$this->clean_session_fields($data);

		return $this->redirect('Роль обновлена', '/roles');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = (int) $_POST['role_id'];
		$role = $this->role->delete($id);

		if ($role == 0) {
			return $this->redirect('Роль не может быть удалена, потому что имеет связь с пользователями');
		}

		$this->check_response($role);

		return $this->redirect('Роль удалена');
	}
}