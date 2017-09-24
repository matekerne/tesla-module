<?php

namespace Admin;

use controllers\Controller as Controller;

class TotalAreaController extends Controller
{
	public $model_namespace = 'Admin';
	public $model_name = 'TotalArea';

	public $path_to_view = '/modules/tesla/views/admin/total_area';
	public $method_get_all = 'get_all';

	public $access_roles = 'admin';
	public $access_groups = 'tesla';

	public $message_on_create = 'Площадь создана';
	public $message_on_update = 'Площадь обновлена';
	public $message_on_delete = 'Площадь удалёна';

	public $url_on_update = '/module/tesla/admin/total/areas';
}