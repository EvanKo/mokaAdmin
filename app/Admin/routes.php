<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
	$router->resource('moka', MokaController::class);
//	$router->resource('role',RoleController::class);
	$router->resource('photogragher',PhotogragherController::class);
	$router->resource('manager', ManagerController::class);
	$router->resource('company',CompanyController::class);
	$router->resource('user', UserController::class);
	$router->resource('model', ModelController::class);
	$router->resource('PayRecord', PayRecordController::class);
	$router->resource('notice', NoticeController::class);
	$router->resource('photo', PhotosController::class);
	$router->resource('album', AlbumController::class);
	$router->resource('undefineUser', UndefineUserController::class);
	$router->resource('order', OrderController::class);
	$router->resource('moments', MomentController::class);
});
