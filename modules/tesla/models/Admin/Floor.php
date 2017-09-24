<?php

namespace Admin;

use models\Model as Model;

class Floor extends Model
{	
	public $table = 'tesla_floors';

	public $fields_rules = [
		'num' => 'Номер|empty|length',
	];

	public $fields_get_all = 'id, num';
	public $fields_show = 'id, num';
	public $order_by = 'id';
}