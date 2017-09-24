<?php

namespace Admin;

use models\Model as Model;

class Price extends Model
{
	public function upload(array $apartments)
	{
		$db = \DB::get_connection();
		$sql = 'UPDATE tesla_apartments SET price = :price WHERE num = :num';
		$query = $db->prepare($sql);

		foreach ($apartments as &$apartment) {
			$query->bindParam(':price', $apartment['price']);
			$query->bindParam(':num', $apartment['num']);
			
			$query->execute();
		}
		
		return $query->execute();
	}
}