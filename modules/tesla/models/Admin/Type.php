<?php

namespace Admin;

use models\Model as Model;

class Type extends Model
{	
	public $table = 'tesla_types';

	public $fields_rules = [
		'type' => 'Тип|empty|length',
	];

	public $fields_get_all = 'id, type';
	public $fields_show = 'id, type';
	public $order_by = 'id';
}