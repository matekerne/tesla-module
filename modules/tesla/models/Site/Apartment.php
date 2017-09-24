<?php

namespace Site;

use \models\Model as Model;

class Apartment extends Model
{
	private $contact;
	private $lead;

	public function __construct()
	{
		$this->lead = new Lead;
		$this->contact = new Contact;
	}

	public function get_all(string $condition='')
	{
		$db = \DB::get_connection();

		$sql = "SELECT a.id, a.factual_area, a.floor, a.num, a.price, a.status, t.type, t_a.total_area, GROUP_CONCAT(DISTINCT w.name SEPARATOR ', ') AS windows FROM tesla_apartments a JOIN tesla_types t ON a.type_id = t.id JOIN tesla_total_areas t_a ON a.total_area_id = t_a.id JOIN tesla_apartments_windows a_w ON a.id = a_w.apartment_id JOIN tesla_windows w ON a_w.window_id = w.id $condition GROUP BY a.id ORDER BY a.num";

		$query = $db->prepare($sql);
		if ($query->execute()) {
			$apartments = [];

			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$apartments[$i]['id'] = $row['id'];
				$apartments[$i]['floor'] = $row['floor'];
				$apartments[$i]['num'] = $row['num'];
				$apartments[$i]['price'] = $row['price'];
				$apartments[$i]['status'] = $row['status'];
				$apartments[$i]['type'] = $row['type'];
				$apartments[$i]['total_area'] = $row['total_area'];
				$apartments[$i]['factual_area'] = $row['factual_area'];
				$apartments[$i]['windows'] = $row['windows'];
				$i++;
			}
		} else {
			return false;
		}
		
		return $apartments;
	}

	public function get_general_info_apartments()
	{
		$db = \DB::get_connection();

		$general_info_apartments = [];

		// Данные для верней части левой панели с информацией о квартирах
		$sql = "SELECT a.type_id, a.total_area_id, t.type, t_a.total_area, COUNT(*) summary, SUM(a.status = 1) free FROM tesla_apartments a JOIN tesla_types t ON a.type_id = t.id JOIN tesla_total_areas t_a ON a.total_area_id = t_a.id GROUP BY a.type_id, a.total_area_id";

		$query = $db->prepare($sql);

		if ($query->execute()) {
			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$general_info_apartments[$i]['total_area_id'] = $row['total_area_id'];
				$general_info_apartments[$i]['total_area'] = $row['total_area'];
				$general_info_apartments[$i]['type_id'] = $row['type_id'];
				$general_info_apartments[$i]['type'] = $row['type'];
				$general_info_apartments[$i]['free'] = $row['free'];
				$general_info_apartments[$i]['summary'] = $row['summary'];
				$i++;
			}
		} else {
			return false;
		}

		return $general_info_apartments;
	}

	public function get_floors_types_aparts()
	{
		$db = \DB::get_connection();

		$floors_types_aparts = [];

		// Данные для нижней части левой панели с информацией о квартирах
		$sql = "SELECT a.floor, SUM(CASE WHEN a.type_id = 1 AND a.status = 1 THEN 1 ELSE 0 END) AS '1', SUM(CASE WHEN a.type_id = 4 AND a.status = 1 THEN 1 ELSE 0 END) AS '4', SUM(CASE WHEN a.type_id = 2 AND a.status = 1 THEN 1 ELSE 0 END) AS '2', SUM(CASE WHEN a.type_id = 3 AND a.status = 1 THEN 1 ELSE 0 END) AS '3' FROM tesla_apartments a GROUP BY a.floor";

		// Если нужно совместить 2 условия
		// SUM(CASE WHEN a_status = 17 AND g_surv_solo = 1 THEN 1 ELSE 0 END ) AS status_17

		$query = $db->prepare($sql);
		
		if ($query->execute()) {
			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$floors_types_aparts[$i]['floor'] = $row['floor'];
				$floors_types_aparts[$i]['1'] = $row['1'];
				$floors_types_aparts[$i]['4'] = $row['4'];
				$floors_types_aparts[$i]['2'] = $row['2'];
				$floors_types_aparts[$i]['3'] = $row['3'];
				$i++;
			}
		} else {
			return false;
		}
		
		return $floors_types_aparts;
	}

	public function reserve(array $data)
	{
		$data = $this->validate($data, [
			'name' => 'Имя|empty|length',
			'surname' => 'Фамилия|empty|length',
		], 'ajax');

		$db = \DB::get_connection();
		$sql = 'INSERT INTO tesla_buyers (name, surname, phone, email) VALUES (:name, :surname, :phone, :email)';

		$query = $db->prepare($sql);

		$num_contract = NULL;
		$query->bindParam(':name', $data['name']);
		$query->bindParam(':surname', $data['surname']);
		$query->bindParam(':phone', $data['phone']);
		$query->bindParam(':email', $data['email']);

		if ($query->execute()) {
			$buyer_id = $db->lastInsertId();

			$sql = 'INSERT INTO tesla_buyers_reservators_apartments (buyer_id, reservator_id, apartment_id, reserve, buy) VALUES (:buyer_id, :reservator_id, :apartment_id, :reserve, :buy)';

			$query = $db->prepare($sql);

			$buy_value = NULL;
			$time_reserve = $data['reserve'];
			$reserve = date('Y-m-d H:i:s', strtotime("+$time_reserve day"));

			$reservator_id = $_SESSION['user'];

			$query->bindParam(':buyer_id', $buyer_id);
			$query->bindParam(':reservator_id', $reservator_id);
			$query->bindParam(':apartment_id', $data['apartment_id']);
			$query->bindParam(':reserve', $reserve);
			$query->bindParam(':buy', $buy_value);

			if ($query->execute()) {
				$sql = 'UPDATE tesla_apartments SET status = 2 WHERE id = :apartment_id';

				$query = $db->prepare($sql);

				$query->bindParam(':apartment_id', $data['apartment_id']);

				if ($query->execute()) {
					$result = $this->contact->create($data);

					if ($result) {
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
	}

	public function withdraw_reserve(int $apartment_id, int $buyer_id)
	{
		$db = \DB::get_connection();

		$sql = 'DELETE FROM tesla_buyers_reservators_apartments WHERE apartment_id = :apartment_id';
		$query = $db->prepare($sql);
		$query->bindParam(':apartment_id', $apartment_id);

		if ($query->execute()) {
			$sql = 'DELETE FROM tesla_buyers WHERE id = :buyer_id';

			$query = $db->prepare($sql);
			$query->bindParam(':buyer_id', $buyer_id);

			if ($query->execute()) {
				$sql = 'UPDATE tesla_apartments SET status = 1 WHERE id = :apartment_id';

				$query = $db->prepare($sql);
				$query->bindParam(':apartment_id', $apartment_id);

				if ($query->execute()) {
					$sql = 'INSERT INTO tesla_unreservators_apartments (unreservator_id, apartment_id) VALUES (:unreservator_id, :apartment_id)';
					$query = $db->prepare($sql);
					$query->bindParam(':unreservator_id', $_SESSION['user']);
					$query->bindParam(':apartment_id', $apartment_id);

					if ($query->execute()) {
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
	}
	
	public function auto_withdraw_reserve()
	{
		$cur_date = date('Y-m-d H:i:s');
		
		$db = \DB::get_connection();

		$sql = 'SELECT buyer_id, apartment_id, reserve FROM tesla_buyers_reservators_apartments WHERE reserve < :cur_date';

		$query = $db->prepare($sql);
		$query->bindParam(':cur_date', $cur_date);

		if ($query->execute()) {
			$buyers_apartments = [];

			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$buyers_apartments[$i]['buyer_id'] = $row['buyer_id'];
				$buyers_apartments[$i]['apartment_id'] = $row['apartment_id'];
				$i++;
			}
			
			if (count($buyers_apartments > 0)) {
				$result = 0;

				foreach ($buyers_apartments as &$buyer_apartment) {
					$sql = 'DELETE FROM tesla_buyers_reservators_apartments WHERE apartment_id = :apartment_id';
					$query = $db->prepare($sql);
					$query->bindParam(':apartment_id', $buyer_apartment['apartment_id']);

					if ($query->execute()) {
						$result += 1;

						$sql = 'DELETE FROM tesla_buyers WHERE id = :buyer_id';
						$query = $db->prepare($sql);
						$query->bindParam(':buyer_id', $buyer_apartment['buyer_id']);

						if ($query->execute()) {
							$result += 1;

							$sql = 'UPDATE tesla_apartments SET status = 1 WHERE id = :apartment_id';
							$query = $db->prepare($sql);
							$query->bindParam(':apartment_id', $buyer_apartment['apartment_id']);

							if ($query->execute()) {
								$result += 1;
							} else {
								$result -= 1;
							}
						} else {
							$result -= 1;
						}
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
				return true;
			}		
		} else {
			return false;
		}
	}

	public function lead($data)
	{
		$data = $this->validate($data, [
			'name' => 'Имя|empty|length',
			'surname' => 'Фамилия|empty|length',
		], 'ajax');

		$result = $this->lead->lead($data);

		if ($result) {
			$db = \DB::get_connection();

			$sql = 'UPDATE tesla_apartments SET status = 3 WHERE num = :num';

			$query = $db->prepare($sql);

			$query->bindParam(':num', $data['apartment_num']);

			if ($query->execute()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function actualize($implement_apartments, $reserve_apartments, $paid_reserve_apartments, $closed_not_implement_apartments)
	{
		$db = \DB::get_connection();

		// Не реализованные
		$closed_not_implement_apartments_sql = 'UPDATE tesla_apartments SET status = 1 WHERE num = :num';
		$query = $db->prepare($closed_not_implement_apartments_sql);

		$result_closed_not_implement_apartments_sql = 0;
		foreach ($closed_not_implement_apartments as $closed_not_implement_apartment_num) {
			$query->bindParam(':num', $closed_not_implement_apartment_num);

			if ($query->execute()) {
				$result_closed_not_implement_apartments_sql += 1;
			} else {
				$result_closed_not_implement_apartments_sql -= 1;
			}
		} 

		if ($result_closed_not_implement_apartments_sql > 0) {
			// Реализованные
			$implement_apartments_sql = 'UPDATE tesla_apartments SET status = 3 WHERE num = :num';
			$query = $db->prepare($implement_apartments_sql);

			$result_implement_apartments_sql = 0;
			foreach ($implement_apartments as $implement_apartment_num) {
				$query->bindParam(':num', $implement_apartment_num);

				if ($query->execute()) {
					$result_implement_apartments_sql += 1;
				} else {
					$result_implement_apartments_sql -= 1;
				}
			}
			// var_dump($implement_apartments); die();
			if ($result_implement_apartments_sql > 0) {
				// Забронированные
				$reserve_apartments_sql = 'UPDATE tesla_apartments SET status = 2 WHERE num = :num';
				$query = $db->prepare($reserve_apartments_sql);

				$result_reserve_apartments_sql = 0;
				foreach ($reserve_apartments as $reserve_apartment_num) {
					$query->bindParam(':num', $reserve_apartment_num);

					if ($query->execute()) {
						$result_reserve_apartments_sql += 1;
					} else {
						$result_reserve_apartments_sql -= 1;
					}
				}
				
				if ($result_reserve_apartments_sql > 0) {
					// Оплаченная бронь
					$paid_reserve_apartments_sql = 'UPDATE tesla_apartments SET status = 4 WHERE num = :num';
					$query = $db->prepare($paid_reserve_apartments_sql);

					$result_paid_reserve_apartments_sql = 0;
					foreach ($paid_reserve_apartments as $paid_reserve_apartment_num) {
						$query->bindParam(':num', $paid_reserve_apartment_num);

						if ($query->execute()) {
							$result_paid_reserve_apartments_sql += 1;
						} else {
							$result_paid_reserve_apartments_sql -= 1;
						}
					}
					
					if ($result_paid_reserve_apartments_sql > 0) {
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
	}
}