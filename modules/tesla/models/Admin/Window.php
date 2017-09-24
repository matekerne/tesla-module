<?php

namespace Admin;

use models\Model as Model;

class Window extends Model
{	
	public $table = 'tesla_windows';

	public $fields_rules = [
		'name' => 'Имя|empty|length',
	];

	public $fields_get_all = 'id, name';
	public $fields_show = 'id, name';
	public $order_by = 'id';
}