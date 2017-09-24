<?php

namespace Admin;

use models\Model as Model;

class Num extends Model
{	
	public $table = 'tesla_nums';

	public $fields_rules = [
		'num' => 'Номер|empty|length',
	];

	public $fields_get_all = 'id, num';
	public $fields_show = 'id, num';
	public $order_by = 'id';
}