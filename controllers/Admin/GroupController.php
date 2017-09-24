<?php

namespace Admin;

use \controllers\Controller as Controller;

class GroupController extends Controller
{
	protected $group;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);

		$this->group = new Group();
	}

	public function index()
	{
		$groups = $this->group->get_groups();
		$this->check_response($groups);
		
		require_once(ROOT . '/views/admin/group/index.php');
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);

		$data = [];
		$data['name'] = $_POST['name'];

		$this->fill_session_fields($data);
		$group = $this->group->create($data);

		$this->check_response($group);
		$this->clean_session_fields($data);

		return $this->redirect('Группа создана');
	}

	public function edit()
	{
		$id = \Router::get_id();
		$group = $this->group->show($id);

		$this->check_response($group);

		require_once(ROOT . '/views/admin/group/edit.php');
		return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['id'] = $_POST['group_id'];
		$data['name'] = $_POST['name'];

		$this->fill_session_fields($data);
		$group = $this->group->update($data);

		$this->check_response($group);
		$this->clean_session_fields($data);

		return $this->redirect('Группа обновлена', '/groups');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = (int) $_POST['group_id'];
		$group = $this->group->delete($id);

		$this->check_response($group);

		return $this->redirect('Группа удалена');
	}
}