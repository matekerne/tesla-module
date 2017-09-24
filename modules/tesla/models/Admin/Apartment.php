<?php

namespace Admin;

use models\Model as Model;

class Apartment extends Model
{	
	public function get_all()
	{
		$apartments = [];
		
		$db = \DB::get_connection();

		/* Вывести когда забью apartments_windows и total_area_id*/
		$sql = "SELECT a.id, a.type_id, a.total_area_id, a.factual_area, a.floor, a.num, a.price, a.discount, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.id, w.name SEPARATOR ', ') AS windows FROM tesla_apartments a JOIN tesla_apartments_windows a_w ON a.id = a_w.apartment_id JOIN tesla_windows w ON a_w.window_id = w.id JOIN tesla_types t ON a.type_id = t.id JOIN tesla_total_areas t_a ON a.total_area_id = t_a.id GROUP BY a.id ";
		// ORDER BY a.id DESC

		$query = $db->prepare($sql);
		
		if ($query->execute()) {
			
			$i = 0;
			while($row = $query->fetch()) {
				$apartments[$i]['id'] = $row['id'];
				$apartments[$i]['type'] = $row['type'];
				$apartments[$i]['total_area'] = $row['total_area'];
				$apartments[$i]['factual_area'] = $row['factual_area'];
				$apartments[$i]['floor'] = $row['floor'];
				$apartments[$i]['num'] = $row['num'];
				$apartments[$i]['price'] = $row['price'];
				$apartments[$i]['discount'] = $row['discount'];
				$apartments[$i]['status'] = $row['status'];
				$apartments[$i]['windows'] = $row['windows'];

				$i++;
			}
			// var_dump($apartments); die();
			return $apartments;
		} else {
			return false;
		}
	}


	public function get_available()
	{
		$db = \DB::get_connection();
		$sql = "SELECT id, num FROM tesla_apartments WHERE status = 1 ORDER BY id DESC";
		$query = $db->prepare($sql);

		if ($query->execute()) {
			$available_apartments = [];

			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$available_apartments[$i]['id'] = $row['id'];
				$available_apartments[$i]['num'] = $row['num'];
				$i++;
			}
		} else {
			return false;
		}

		return $available_apartments;
	}

	public function change_status(array $data, string $type, int $status): bool
	{
        foreach ($data["$type"] as $user_apartment) {
        	$db = \DB::get_connection();
            $sql = "UPDATE tesla_apartments a SET a.status = $status WHERE a.id = :user_apartment";
            $query = $db->prepare($sql);
            $query->bindParam(':user_apartment', $user_apartment);

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

	public function create(array $data): bool
	{
		// var_dump($data); die();
		$data = $this->validate($data, [
			'type_id' => 'Тип|empty|length',
			'total_area_id' => 'Общая площадь|empty|length',
			'factual_area' => 'Фактическая площадь|empty|length',
			'floor' => 'Этаж|empty|length',
			'num' => 'Номер|empty|length',
			'price' => 'Цена|empty|length',
			'status' => 'Статус|empty|length',	
			'window' => 'Окна|empty',
			'glazing' => 'Тип остекления|empty',
		]);

		// var_dump($data); die();
		$db = \DB::get_connection();

		$sql = "INSERT INTO tesla_apartments (type_id, total_area_id, factual_area, price, discount, floor, num, status) VALUES (:type_id, :total_area_id, :factual_area, :price, :discount, :floor, :num, :status)";
		$query = $db->prepare($sql);

		if ($data['discount'] == '') {
			$data['discount'] = NULL;
		}

		$query->bindParam(':type_id', $data['type_id']);
		$query->bindParam(':total_area_id', $data['total_area_id']);
		$query->bindParam(':factual_area', $data['factual_area']);
		$query->bindParam(':price', $data['price']);
		$query->bindParam(':discount', $data['discount']);
		$query->bindParam(':floor', $data['floor']);
		$query->bindParam(':num', $data['num']);
		$query->bindParam(':status', $data['status']);

		if ($query->execute()) {
			$apartment_id = $db->lastInsertId();
			// $data['id'] = $id;

			$sql = 'INSERT INTO tesla_apartments_windows (apartment_id, window_id) VALUES (:apartment_id, :window_id)';
			$query = $db->prepare($sql);

			$result = 0;
			foreach ($data['window'] as &$window_id) {		
				$query->bindParam(':apartment_id', $apartment_id);
				$query->bindParam(':window_id', $window_id);

				if ($query->execute()) {
					$result += 1;
				} else {
					$result -= 1;
				}
			}

			if ($result > 0) {
				$sql = 'INSERT INTO tesla_apartments_glazings (apartment_id, glazing_id) VALUES (:apartment_id, :glazing_id)';
				$query = $db->prepare($sql);

				$result = 0;
				foreach ($data['glazing'] as &$glazing_id) {			
					$query->bindParam(':apartment_id', $apartment_id);
					$query->bindParam(':glazing_id', $glazing_id);

					if ($query->execute()) {
						$result += 1;
					} else {
						$result -= 1;
					}
				}

				if ($result > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function show(int $id)
	{
		$db = \DB::get_connection();

		// $sql = "SELECT a.id, a.type_id, a.total_area_id, a.factual_area, a.floor, a.num, a.price, a.discount, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.id, w.name SEPARATOR ', ') AS windows, GROUP_CONCAT(DISTINCT g.id SEPARATOR ', ') AS glazings FROM tesla_apartments a JOIN tesla_apartments_windows a_w ON a.id = a_w.apartment_id JOIN tesla_windows w ON a_w.window_id = w.id JOIN tesla_types t ON a.type_id = t.id JOIN tesla_total_areas t_a ON a.total_area_id = t_a.id JOIN tesla_apartments_glazings a_g ON a.id = a_g.apartment_id JOIN tesla_glazings g ON a_g.glazing_id = g.id WHERE a.id = :id GROUP BY a.id";

		$sql = "SELECT a.id, a.type_id, a.total_area_id, a.factual_area, a.floor, a.num, a.price, a.discount, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.id, w.name SEPARATOR ', ') AS windows, GROUP_CONCAT(DISTINCT g.id SEPARATOR ', ') AS glazings FROM tesla_apartments a LEFT JOIN tesla_apartments_windows a_w ON a.id = a_w.apartment_id LEFT JOIN tesla_windows w ON a_w.window_id = w.id LEFT JOIN tesla_types t ON a.type_id = t.id LEFT JOIN tesla_total_areas t_a ON a.total_area_id = t_a.id LEFT JOIN tesla_apartments_glazings a_g ON a.id = a_g.apartment_id LEFT JOIN tesla_glazings g ON a_g.glazing_id = g.id WHERE a.id = :id GROUP BY a.id";

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
			'type_id' => 'Тип|empty|length',
			'total_area_id' => 'Общая площадь|empty|length',
			'factual_area' => 'Фактическая площадь|empty|length',
			'floor' => 'Этаж|empty|length',
			'num' => 'Номер|empty|length',
			'price' => 'Цена|empty|length',
			'status' => 'Статус|empty|length',	
			'window' => 'Окна|empty',
			'glazing' => 'Тип остекления|empty',
        ]);

        $db = \DB::get_connection();

        $sql = 'UPDATE tesla_apartments SET type_id = :type_id, total_area_id = :total_area_id, factual_area = :factual_area, price = :price, discount = :discount, floor = :floor, num = :num, status = :status WHERE id = :id';

        $query = $db->prepare($sql);

		if ($data['discount'] == '') {
			$data['discount'] = NULL;
		}

		$query->bindParam(':id', $data['id']);
		$query->bindParam(':type_id', $data['type_id']);
		$query->bindParam(':total_area_id', $data['total_area_id']);
		$query->bindParam(':factual_area', $data['factual_area']);
		$query->bindParam(':price', $data['price']);
		$query->bindParam(':discount', $data['discount']);
		$query->bindParam(':floor', $data['floor']);
		$query->bindParam(':num', $data['num']);
		$query->bindParam(':status', $data['status']);

        if ($query->execute()) {
        	(int) $apartment_id = $data['id'];

        	$sql = 'DELETE FROM tesla_apartments_windows WHERE apartment_id = :apartment_id';
        	$query = $db->prepare($sql);
        	$query->bindParam(':apartment_id', $apartment_id);

        	if ($query->execute()) {
        		$sql = 'DELETE FROM tesla_apartments_glazings WHERE apartment_id = :apartment_id';
        		$query = $db->prepare($sql);
        		$query->bindParam(':apartment_id', $apartment_id);

        		if ($query->execute()) {
					$sql = 'INSERT INTO tesla_apartments_windows (apartment_id, window_id) VALUES (:apartment_id, :window_id)';
					$query = $db->prepare($sql);

					$result = 0;
					foreach ($data['window'] as &$window_id) {		
						$query->bindParam(':apartment_id', $apartment_id);
						$query->bindParam(':window_id', $window_id);

						if ($query->execute()) {
							$result += 1;
						} else {
							$result -= 1;
						}
					}

					if ($result > 0) {
						$sql = 'INSERT INTO tesla_apartments_glazings (apartment_id, glazing_id) VALUES (:apartment_id, :glazing_id)';
						$query = $db->prepare($sql);

						$result = 0;
						foreach ($data['glazing'] as &$glazing_id) {			
							$query->bindParam(':apartment_id', $apartment_id);
							$query->bindParam(':glazing_id', $glazing_id);

							if ($query->execute()) {
								$result += 1;
							} else {
								$result -= 1;
							}
						}

						if ($result > 0) {
							return true;
						} else {
							return false;
						}
					} else {
						return false;
					}
        		} else {
        			return false;
        		}
        	} else {
        		return false;
        	}

        	return true;
        } else {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $db = \DB::get_connection();

        $sql = 'DELETE FROM tesla_apartments WHERE id = :id';

        $query = $db->prepare($sql);
        $query->bindParam(':id', $id);

        if ($query->execute()) {
        	(int) $apartment_id = $id;

        	$sql = 'DELETE FROM tesla_apartments_windows WHERE apartment_id = :apartment_id';
        	$query = $db->prepare($sql);
        	$query->bindParam(':apartment_id', $apartment_id);

        	if ($query->execute()) {
        		$sql = 'DELETE FROM tesla_apartments_glazings WHERE apartment_id = :apartment_id';
        		$query = $db->prepare($sql);
        		$query->bindParam(':apartment_id', $apartment_id);

        		if ($query->execute()) {
        			return true;
        		} else {
        			return false;
        		}
        	} else {
        		return false;
        	}

            return true;
        } else {
            return false;
        }
    }
}