<?php

namespace Admin;

use \controllers\Controller as Controller;

class UserController extends Controller
{
	protected $role;
	protected $group;
	protected $user;
	protected $apartment;

	public function __construct()
	{
		$roles_groups = [
			'roles' => ['admin', 'senior_manager', 'manager'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);

		$this->role = new Role();
		$this->group = new Group();
		$this->user = new User();
		$this->apartment = new Apartment();
 	}

	public function index()
	{
		$condition_roles = $this->get_condition('roles', 'id');
		$condition_users = $this->get_condition('u', 'role_id');

		$roles = $this->role->get_roles($condition_roles);		
		$users = $this->user->get_users($condition_users);
		$groups = $this->group->get_groups();
		$available_apartments = $this->apartment->get_available();
		
		$this->check_response($roles, $groups, $users, $available_apartments);

		require_once(ROOT . '/views/admin/user/index.php');
		return true;
	}

	public function create()
	{
		$this->check_request($_POST);
				
		$data = [];
		$data['login'] = $_POST['login'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['patronymic'] = $_POST['patronymic'];
		$data['role'] = $_POST['role'];
		$data['group'] = $this->get_select2_value('group', $_POST);
		$data['apartments'] = $this->get_select2_value('apartments', $_POST);
		$data['password'] = $_POST['password'];

		$this->fill_session_fields($data);

		$existing_user = $this->user->check_exists($data);
		if ($existing_user) {
			$_SESSION['errors'] = 'Пользователь с таким логином уже существует';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		}

		$user = $this->user->create($data);

		$this->check_response($user);

		$this->clean_session_fields($data);

		return $this->redirect('Пользователь создан');
	}

	public function edit()
	{
		$id = \Router::get_id();

		$condition_roles = $this->get_condition('roles', 'id');

		$user = $this->user->show($id);

		$all_roles = $this->role->get_roles($condition_roles);
		$all_groups = $this->group->get_groups();
		$all_apartments = $this->apartment->get_all();

		$this->check_response($user, $all_roles, $all_groups);
		
		// Для корректного вывода в select
		$user_roles = $this->create_select2_data('roles', $user['roles']);
		$user_apartments = $this->create_select2_data('apartments', $user['apartments']);

		require_once(ROOT . '/views/admin/user/edit.php');
		return true;
	}

	public function update()
	{
		$this->check_request($_POST);

		$data = [];
		$data['id'] = $_POST['id'];
		$data['login'] = $_POST['login'];
		$data['name'] = $_POST['name'];
		$data['surname'] = $_POST['surname'];
		$data['patronymic'] = $_POST['patronymic'];
		$data['role'] = $_POST['role'];
		// Для того чтобы убрать ошибку с пустым select 2
		$data['group'] = $this->get_select2_value('group', $_POST);
		$data['apartments'] = $this->get_select2_value('apartments', $_POST);
		$data['old_user_apartments'] = $_POST['old_user_apartments'];
		$data['password'] = $_POST['password'];

		// Для проверки на существующего пользователя
		$existing_user = $this->user->check_exists($data);
		if ($existing_user && $existing_user['id'] != $data['id']) {
			$_SESSION['errors'] = 'Пользователь с таким логином уже существует';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		}

		$user = $this->user->update($data);

		$this->check_response($user);

		return $this->redirect('Пользователь обновлен', '/users');
	}

	public function delete()
	{
		$this->check_request($_POST);

		$id = (int) $_POST['user_id'];
		$user = $this->user->delete($id);
		// var_dump($user); die();
		$this->check_response($user);

		return $this->redirect('Пользователь удалён');
	}

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['error_access']);
		header("Location: /login");
    }

    public function get_condition(string $alias, string $field)
    {
        $condition = '';

        switch ($_SESSION['role_id']) {
            case 1:
                $condition = "WHERE $alias.$field = 1 OR $alias.$field = 2 OR $alias.$field = 3 OR $alias.$field = 4 OR $alias.$field = 5";
                break;
            case 2:
                $condition = "WHERE $alias.$field = 3 OR $alias.$field = 4";
                break;
            case 3:
                $condition = "WHERE $alias.$field = 4";
                break;
        }

        return $condition;  
    }
}