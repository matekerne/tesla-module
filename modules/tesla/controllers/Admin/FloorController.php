<?php

namespace Admin;

use controllers\Controller as Controller;

class FloorController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Floor';

	public $path_to_view = '/modules/tesla/views/admin/floor';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Этаж создан';
	public $message_on_update = 'Этаж обновлен';
	public $message_on_delete = 'Этаж удалён';

	public $url_on_update = '/module/tesla/admin/floors';
}