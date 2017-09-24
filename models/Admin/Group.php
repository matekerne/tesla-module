<?php

namespace Admin;

use \models\Model as Model;

class Group extends Model
{
	public function get_groups()
	{
		$groups = [];

		$db = \DB::get_connection();

		$sql = 'SELECT id, name FROM groups ORDER BY id DESC';

		$query = $db->prepare($sql);

		if ($query->execute()) {	
			$i = 0;	
			while ($row = $query->fetch()) { 
				$groups[$i]['id'] = $row['id'];
				$groups[$i]['name'] = $row['name'];
				$i++;
			}
			
			return $groups;
		} else {
			return false;
		}
	}

	public function create(array $data): bool
	{
		$data = $this->validate($data, [
			'name' => 'Имя|empty|length',
		]);

		$db = \DB::get_connection();

		$sql = 'INSERT INTO groups (name) VALUES (:name)';
		$query = $db->prepare($sql);
		$query->bindParam(':name', $data['name']);

		return $query->execute();
	}

	public function show(int $id)
	{
		$db = \DB::get_connection();

		$sql = 'SELECT id, name FROM groups WHERE id = :id';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function update(array $data): bool
	{
		$data = $this->validate($data, [
			'name' => 'Имя|empty|length',
		]);

		$db = \DB::get_connection();

		$sql = 'UPDATE groups SET name = :name WHERE id = :id';
		$query = $db->prepare($sql);
		$query->bindParam(':id', $data['id']);
		$query->bindParam(':name', $data['name']);

		return $query->execute();
	}

	public function delete(int $id): bool
	{
		$db = \DB::get_connection();

		$sql = 'DELETE FROM groups WHERE id = :id';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);

		if ($query->execute()) {
			$sql = 'DELETE FROM users_groups WHERE group_id = :id';

			$query = $db->prepare($sql);
			$query->bindParam(':id', $id);
			
			if ($query->execute()) {
				return $query->execute();
			} else {
				return false;
			}
		} else {
			return false;
		}

	}
}