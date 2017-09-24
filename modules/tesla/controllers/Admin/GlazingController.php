<?php

namespace Admin;

use controllers\Controller as Controller;

class GlazingController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'Glazing';

	public $path_to_view = '/modules/tesla/views/admin/glazing';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Вид остекления создан';
	public $message_on_update = 'Вид остекления обновлен';
	public $message_on_delete = 'Вид остекления удалён';

	public $url_on_update = '/module/tesla/admin/glazings';
}