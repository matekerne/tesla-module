<?php

return array(
	// Upload csv
	'module/tesla/admin/prices/upload' => 'Admin\Price/upload',
	'module/tesla/admin/prices/index' => 'Admin\Price/index',

	// Reserve
	'module/tesla/admin/reserve/delete' => 'Admin\Reserve/delete',
	'module/tesla/admin/reserve/update' => 'Admin\Reserve/update',
	'module/tesla/admin/reserve/edit/[0-9]+' => 'Admin\Reserve/edit',
	'module/tesla/admin/reserve/create' => 'Admin\Reserve/create',
	'module/tesla/admin/reserves' => 'Admin\Reserve/index',

	// Glazing
	'module/tesla/admin/glazing/delete' => 'Admin\Glazing/delete',
	'module/tesla/admin/glazing/update' => 'Admin\Glazing/update', 
	'module/tesla/admin/glazing/edit/[0-9]+' => 'Admin\Glazing/edit',
	'module/tesla/admin/glazing/create' => 'Admin\Glazing/create',
	'module/tesla/admin/glazings' => 'Admin\Glazing/index',

	// Floor
	'module/tesla/admin/floor/delete' => 'Admin\Floor/delete',
	'module/tesla/admin/floor/update' => 'Admin\Floor/update', 
	'module/tesla/admin/floor/edit/[0-9]+' => 'Admin\Floor/edit',
	'module/tesla/admin/floor/create' => 'Admin\Floor/create',
	'module/tesla/admin/floors' => 'Admin\Floor/index',

	// Type
	'module/tesla/admin/type/delete' => 'Admin\Type/delete',
	'module/tesla/admin/type/update' => 'Admin\Type/update', 
	'module/tesla/admin/type/edit/[0-9]+' => 'Admin\Type/edit',
	'module/tesla/admin/type/create' => 'Admin\Type/create',
	'module/tesla/admin/types' => 'Admin\Type/index',

	// Total area
	'module/tesla/admin/total/area/delete' => 'Admin\Total/Area/delete',
	'module/tesla/admin/total/area/update' => 'Admin\Total/Area/update', 
	'module/tesla/admin/total/area/edit/[0-9]+' => 'Admin\Total/Area/edit',
	'module/tesla/admin/total/area/create' => 'Admin\Total/Area/create',
	'module/tesla/admin/total/areas' => 'Admin\Total/Area/index',

	// Window
	'module/tesla/admin/window/delete' => 'Admin\Window/delete',
	'module/tesla/admin/window/update' => 'Admin\Window/update', 
	'module/tesla/admin/window/edit/[0-9]+' => 'Admin\Window/edit',
	'module/tesla/admin/window/create' => 'Admin\Window/create',
	'module/tesla/admin/windows' => 'Admin\Window/index',

	// Num
	'module/tesla/admin/num/delete' => 'Admin\Num/delete',
	'module/tesla/admin/num/update' => 'Admin\Num/update', 
	'module/tesla/admin/num/edit/[0-9]+' => 'Admin\Num/edit',
	'module/tesla/admin/num/create' => 'Admin\Num/create',
	'module/tesla/admin/nums' => 'Admin\Num/index',

	// Apartments
	'module/tesla/admin/apartment/delete' => 'Admin\Apartment/delete',
	'module/tesla/admin/apartment/update' => 'Admin\Apartment/update', 
	'module/tesla/admin/apartment/edit/[0-9]+' => 'Admin\Apartment/edit',
	'module/tesla/admin/apartment/create' => 'Admin\Apartment/create',
	'module/tesla/admin/apartments' => 'Admin\Apartment/index',

	// Buyers
	'module/tesla/buyer/show' => 'Site\Buyer/show',

	'module/tesla/apartments/actualize' => 'Site\Apartment/actualize',
	'module/tesla/apartment/lead' => 'Site\Apartment/lead',
	'module/tesla/apartment/reserve' => 'Site\Apartment/reserve',
	'module/tesla/apartment/withdraw-reserve' => 'Site\Apartment/withdraw_reserve',
	'module/tesla/apartment/auto-withdraw-reserve' => 'Site\Apartment/auto_withdraw_reserve',
	'module/tesla/apartments' => 'Site\Apartment/index',

	'module/tesla/home' => 'Site\Home/index',
);