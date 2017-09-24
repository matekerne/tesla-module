<?php

namespace Site;

use \models\Model as Model;

class Buyer extends Model
{	
	public function show(int $id)
	{
		// var_dump($id); die();
		$db = \DB::get_connection();

		$sql = 'SELECT b.id, b.name, b.surname, b.phone, b.email, b_a.reservator_id FROM tesla_buyers_reservators_apartments b_a LEFT JOIN tesla_buyers b ON b_a.buyer_id = b.id WHERE b_a.apartment_id = :id';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);

		if ($query->execute()) {
			$buyers = [];

			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$buyers[$i]['id'] = $row['id'];
				$buyers[$i]['reservator_id'] = $row['reservator_id'];
				$buyers[$i]['name'] = $row['name'];
				$buyers[$i]['surname'] = $row['surname'];
				$buyers[$i]['phone'] = $row['phone'];
				$buyers[$i]['email'] = $row['email'];
				$i++;
			}
		} else {
			return false;
		}

		return $buyers;
	}
}