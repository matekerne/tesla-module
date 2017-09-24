<?php

namespace Admin;

use models\Model as Model;

class Reserve extends Model
{	
	public $table = 'tesla_reserves';

	public $fields_rules = [
		'realtor' => 'Риэлтор|empty|length',
		'manager' => 'Менеджер|empty|length',
	];

	public $fields_get_all = 'id, realtor, manager';
	public $fields_show = 'id, realtor, manager';
	public $order_by = 'id';
}