<?php

namespace components;

trait Validator
{
	public function clean($value='')
	{
		if (is_array($value)) {
			$result = [];

			$i = 0;
			foreach ($value as $val) {
				$element = trim($val);
				$element = strip_tags($element);
				$element = stripslashes($element);
				$result[$i] = $element;
				$i++;
			}
		} else {		
			$result = trim($value);
			$result = strip_tags($result);
			$result = stripslashes($result);
		}

		return $result;
	}

	public function check_empty($value, string $field)
	{
		// var_dump($value, $field); die();
		if (!$value) {
			$_SESSION['errors'] = "Заполните все обязательные поля";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		} else {
			return true;
		}
	}

	public function check_empty_file($value, string $field)
	{
		if (count($value) < 1) {
			$_SESSION['errors'] = 'Файл не может быть пустым';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		} else {
			return true;
		}
	}

	public function check_length($value, string $field)
	{
		if (is_array($value)) {
			$result = 0;
			foreach ($value as $val) {
				if (strlen($val) > 255) {
					$result -= 1;
				} else {
					$result += 1;
				}
			}

			if ($result <= 0) {
				$_SESSION['errors'] = "Значение поля $field должно быть меньшей длинны";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				exit();
			}
		} else {		
			if (strlen($value) > 255) {
				$_SESSION['errors'] = "Значение поля $field должно быть меньшей длинны";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				exit();
			} else {
				return true;
			}
		}

	}

	public function check_length_integer(string $value, string $field)
	{
		if (strlen($value) > 11) {
			$_SESSION['errors'] = "Значение поля $field должно быть меньшей длинны";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		} else {
			return true;
		}
	}

	public function check_email(string $value, string $field)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['errors'] = 'Неправильный формат email адреса';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();			
		} else {
			return true;
		}
	}

	public function check_request($request)
	{
		if (!$request) {
			header('Location: /');
		}
	}

	public function check_response(...$response)
	{
		foreach ($response as $keys => $values) {
			if (!is_array($values) && $values != true) {
				require_once(ROOT . '/views/errors/500.php');
				die();
			}
		}

		return true;
	}

    public function check_access(array $roles_groups)
    {
    	// Не тянуть из базы, потому что данные храняться в другом формате (конвертировать не рентабельно)
    	$roles = [
    		'admin' => 1,
    		'senior_manager' => 2,
    		'manager' => 3,
    		'realtor' => 4,
    	];

    	$groups = [
    		'tesla' => 1,
    		'square' => 2,
    		'village' => 3,
    		'security' => 4,
    	];

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
        } else {
			$arr_compare_roles = [];
			$arr_compare_groups = [];

	    	foreach ($roles_groups as $element => $element_values) {
	    		$i = 0;

	    		foreach ($element_values as $element_value) {
					if ($element == 'roles') {
						$arr_compare_roles[$i] = $$element[$element_value];
					} else if ($element == 'groups') {
						$arr_compare_groups[$i] = $$element[$element_value];
					}

					$i++;
	    		}
	    	}

			if (in_array($_SESSION['role_id'], $arr_compare_roles) && strpbrk($_SESSION['groups'], $arr_compare_groups[0])) {
				return true;
			}
        }
    }

	public function validate(array $fields, array $rules): array
	{
		$fields_names = [];

		foreach ($fields as $field => $value) {
			if (array_key_exists($field, $rules)) {			
				$field_name = explode('|', $rules[$field]);
				$fields_names[$field] = $field_name[0];
			}
		}

		$data = [];

		foreach ($fields as $field => $value) {
			if (array_key_exists($field, $rules)) {
				$actions = explode('|', $rules[$field]);

				unset($actions[0]);
				
				foreach ($actions as $action) {
					$prefix = 'check_';
					$function = $prefix . $action;
					// var_dump($fields); die();
					$this->$function($value, $fields_names[$field]);
					$сlean_value = $this->clean($value);
				}

				$data[$field] = $сlean_value;
			} else {
				$data[$field] = $value;
			}
		}

		return $data;
	}
}