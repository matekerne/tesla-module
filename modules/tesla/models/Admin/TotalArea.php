<?php

namespace Admin;

use models\Model as Model;

class TotalArea extends Model
{	
	public $table = 'tesla_total_areas';

	public $fields_rules = [
		'total_area' => 'Общая площадь|empty|length',
	];

	public $fields_get_all = 'id, total_area';
	public $fields_show = 'id, total_area';
	public $order_by = 'id';
}