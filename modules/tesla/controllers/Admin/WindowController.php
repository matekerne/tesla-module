<?php

namespace Admin;

use controllers\Controller as Controller;

class WindowController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Window';

	public $path_to_view = '/modules/tesla/views/admin/window';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Окно создано';
	public $message_on_update = 'Окно обновлено';
	public $message_on_delete = 'Окно удалёно';

	public $url_on_update = '/module/tesla/admin/windows';	
}