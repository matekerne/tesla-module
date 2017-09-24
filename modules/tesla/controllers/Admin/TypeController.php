<?php

namespace Admin;

use controllers\Controller as Controller;

class TypeController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Type';

	public $path_to_view = '/modules/tesla/views/admin/type';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Тип создан';
	public $message_on_update = 'Тип обновлен';
	public $message_on_delete = 'Тип удалён';

	public $url_on_update = '/module/tesla/admin/types';	
}