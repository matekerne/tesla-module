<?php

namespace models;

use components\Validator as Validator;
use components\Helper as Helper;

class Model
{
	use Validator, Helper;

	// table with go working
	public $table = '';

	// rules for each field form
	public $fields_rules = [];

	// fields which will be get sql form db where start method get all
	public $fields_get_all = '';

	// fields which will be get sql form db where start method show
	public $fields_show = '';

	// element for sort data
	public $order_by = '';

	/**
	 *	Showing all data for this essence
	 *
	 * @return {array} - array with all data
	*/
	public function get_all()
	{
		$data = [];
		$db = \DB::get_connection();
		$sql = "SELECT $this->fields_get_all FROM $this->table ORDER BY $this->order_by DESC";
		$query = $db->prepare($sql);
		
		if ($query->execute()) {		
			$i = 0;
			while ($arr = $query->fetch(\PDO::FETCH_ASSOC)) {
				foreach ($arr as $key => $value) {
					$data[$i][$key] = $value;
				}
				$i++;
			}

			return $data;
		} else {
			return false;
		}

	}

	/**
	 *	Add new essence
	 *
	 * @param {array} $data - field which need create
	 * @return {boolean} true or false
	*/
	public function create(array $data)
	{
		$data = $this->validate($data,
			$this->fields_rules
		);
		// var_dump($data); die();

		$arr_fields = array_keys($data);
		$string_fields = implode(', ', $arr_fields);

		$string = '';
		foreach ($arr_fields as $field_name) {
			$string .= ', :' . $field_name;
		}
		$string_params = substr($string, 2);

		$db = \DB::get_connection();
		$sql = "INSERT INTO $this->table ($string_fields) VALUES ($string_params)";
		$query = $db->prepare($sql);
		foreach ($data as $field => &$value) {
			$query->bindParam(":$field", $value, \PDO::PARAM_STR);
		}

		return $query->execute();
	}

	/**
	 *	Show one essence
	 *
	 * @param {string} $id - essence id
	 * @return {array} - array with data about this essence
	*/
	public function show(int $id)
	{
		$db = \DB::get_connection();

		$sql = "SELECT $this->fields_show FROM $this->table WHERE id = :id";

		$query = $db->prepare($sql);
		$query->bindParam(":id", $id, \PDO::PARAM_STR);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	/**
	 *	Update essence
	 *
	 * @param {string} $id - essence id
	 * @return {boolean} true or false
	*/
	public function update(array $data): bool
	{
        $data = $this->validate($data,
            $this->fields_rules
        );

		$string = '';
		$arr_fields = array_keys($data);
		foreach ($arr_fields as $field_name) {
			$string .= $field_name . ' = ' . ' :' . $field_name .  ', ';
		}
        $string_fields = substr($string, 0, -2);

		
		$db = \DB::get_connection();

		$sql = "UPDATE $this->table SET $string_fields WHERE id = :id";

		$query = $db->prepare($sql);
		$query->bindParam(':id', $data['id'], \PDO::PARAM_STR);
		foreach ($data as $field => &$value) {
			$query->bindParam(":$field", $value);
		}

		return $query->execute();
	}

	/**
	 *	Update essence
	 *
	 * @param {string} $id - essence id
	 * @return {boolean} true or false
	*/
	public function delete(int $id): bool
	{
		$db = \DB::get_connection();

		$sql = "DELETE FROM $this->table WHERE id = :id";

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id, \PDO::PARAM_STR);

		return $query->execute();
	}

	public function create_from_linked_tables(array $data, array $params): bool
    {
        $db = \DB::get_connection();

        foreach ($params as $param) {
            $table_name = $param["table_name"];
            $insertion_fields = $param["insertion_fields"];
            $related_fields = $param["related_fields"];
            $sql = "INSERT INTO $table_name ($insertion_fields) VALUES ($related_fields)";
            $query = $db->prepare($sql);

            $constant_field = $param['constant_field'];
            $multiple_field = $param['multiple_field'];
            foreach ($data["$multiple_field"] as &$id) {         
                foreach ($param['bind_params'] as &$bind_param) {
                    // var_dump($bind_param); die();
                    $query->bindParam("$constant_field", $data['id']);
                    $query->bindParam("$bind_param", $id);
                }
                
                if ($query->execute()) {
                    $result = 1;
                } else {
                    $result = 0;
                }
            }
        }

        if ($result) {
            return true;
        } else {
            return false;
        }      
    }

    public function delete_from_linked_tables(array $params, int $id)
    {
        $db = \DB::get_connection();

        foreach ($params as $param) {
            $table_name = $param["table_name"];
            $condition_field = $param["condition_field"];

            $sql = "DELETE FROM $table_name WHERE $condition_field = :id";
            $query = $db->prepare($sql);

            $query->bindParam(':id', $id);

            if ($query->execute()) {
                $result = 1;
            } else {
                $result = 0;
            }
        }

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}