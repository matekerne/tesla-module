<?php

namespace Admin;

use controllers\Controller as Controller;

class ReserveController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Reserve';

	public $path_to_view = '/modules/tesla/views/admin/reserve';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Настройки брони созданы';
	public $message_on_update = 'Настройки брони обновлены';
	public $message_on_delete = 'Настройки брони удалёны';

	public $url_on_update = '/module/tesla/admin/reserves';
}