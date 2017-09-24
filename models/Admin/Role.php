<?php

namespace Admin;

use \models\Model as Model;

class Role extends Model
{
	public function get_roles($condition='')
	{
		$roles = [];

		$db = \DB::get_connection();

		$sql = "SELECT id, name FROM roles $condition ORDER BY id DESC";

		$query = $db->prepare($sql);
		if ($query->execute()) {
			$i = 0;	
			while ($row = $query->fetch()) {
				$roles[$i]['id'] = $row['id'];
				$roles[$i]['name'] = $row['name'];
				$i++;
			}
			
			return $roles;
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

		$sql = 'INSERT INTO roles (name) VALUES (:name)';

		$query = $db->prepare($sql);
		$query->bindParam(':name', $data['name']);

		return $query->execute();
	}

	public function show(int $id)
	{
		$db = \DB::get_connection();

		$sql = 'SELECT id, name FROM roles WHERE id = :id';

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

		$sql = 'UPDATE roles SET name = :name WHERE id = :id';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $data['id']);
		$query->bindParam(':name', $data['name']);

		return $query->execute();
	}

	public function delete(int $id): bool
	{
		$db = \DB::get_connection();
		$sql = 'SELECT id FROM users WHERE role_id = :id';
		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);
		$query->execute();

		// Для проверки на связь пользователя с ролью (если у какого-либо пользователя есть данная роль, то нельзя её удалить)
		if ($query->fetch()) {
			return 0;
		} else {
			$sql = 'DELETE FROM roles WHERE id = :id';
			$query = $db->prepare($sql);
			$query->bindParam(':id', $id);

			return $query->execute();
		}
	}
}