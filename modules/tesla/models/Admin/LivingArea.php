<?php

namespace Admin;

use models\Model as Model;

class LivingArea extends Model
{	
	public $table = 'tesla_living_areas';

	public $fields_rules = [
		'living_area' => 'Жилая площадь|empty|length',
	];

	public $fields_get_all = 'id, living_area';
	public $fields_show = 'id, living_area';
	public $order_by = 'id';
}