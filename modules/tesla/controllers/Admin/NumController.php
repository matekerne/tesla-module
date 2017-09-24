<?php

namespace Admin;

use controllers\Controller as Controller;

class NumController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Num';

	public $path_to_view = '/modules/tesla/views/admin/num';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Номер квартиры создан';
	public $message_on_update = 'Номер квартиры обновлен';
	public $message_on_delete = 'Номер квартиры удалён';

	public $url_on_update = '/module/tesla/admin/nums';
}