<?php

namespace Auth;

use \controllers\Controller as Controller;
use \Admin\User as User;
use \Auth\Auth as Auth;

class LoginController extends Controller
{

	protected $auth;
	protected $user;

	public function __construct()
	{
		$this->auth = new Auth();
		$this->user = new User();
	}

	public function index()
	{
		if (isset($_SESSION['user'])) {
			header('Location: /');
		}
		
        require_once(ROOT . '/views/auth/login.php');
        return true;
	}

	public function login()
	{
    	$this->check_request($_POST);

    	$data = [];
        $data['login'] = $_POST['login'];
        $data['password'] = $_POST['password'];

        $this->fill_session_fields($data);
		$user = $this->user->check_exists($data);
		// var_dump($user); die();
		if ($user) {
       		$auth = $this->auth->login($data, $user);

       		if ($auth) {   			
				$_SESSION['user'] = $user['id'];
				$_SESSION['role_id'] = $user['role_id'];
				$_SESSION['groups'] = $user['groups'];
				$_SESSION['user_name_surname'] = $user['name'] . ' ' . $user['surname'];
				$_SESSION['role_name'] = $user['role_name'];

	       		$this->clean_session_fields($data);

	       		return $this->redirect('Авторизация прошла успешно!', '/');
       		} else {
       			return $this->redirect('Неправильные логин или пароль');
       		}
		} else {
			return $this->redirect('Неправильные логин или пароль');
		}

    	return true;
	}
}