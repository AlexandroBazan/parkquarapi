<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group([
	'prefix'    => '/v1/groups', 
	'namespace' => 'App\Http\Controllers', 
], function () use ($app) {
	$app->get('/', [
		'as' => 'groups::collection', 
		'uses'=>'GroupsController@collection'
	]);
		
	$app->get('/{name}', [
		'as' => 'groups::one', 
		'uses'=>'GroupsController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'groups::insert', 
		'uses'=>'GroupsController@insert'
	]);

	$app->put('/{name}', [
		'middleware' => 'timestamps', 
		'as' => 'groups::edit', 
		'uses'=>'GroupsController@edit'
	]);

	$app->delete('/{name}', [
		'middleware' => 'timestamps', 
		'as' => 'groups::remove', 
		'uses'=>'GroupsController@remove'
	]);		
});

$app->group([
	'prefix'    => '/v1/profiles', 
	'namespace' => 'App\Http\Controllers', 
], function () use ($app) {
	$app->get('/', [
		'as' => 'profiles::collection', 
		'uses'=>'ProfilesController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'profiles::one', 
		'uses'=>'ProfilesController@one'
	]);

	$app->get('/{id}/permissions', [
		'as' => 'profiles::permissions', 
		'uses'=>'ProfilesController@permissions'
	]);

	$app->get('/{id}/accesses', [
		'as' => 'profiles::accesses', 
		'uses'=>'ProfilesController@accesses'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'profiles::insert', 
		'uses'=>'ProfilesController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'profiles::edit', 
		'uses'=>'ProfilesController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'profiles::remove', 
		'uses'=>'ProfilesController@remove'
	]);
});

$app->group([
	'prefix'    => '/v1/permissions', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'permissions::collection', 
		'uses'=>'PermissionsController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'permissions::one', 
		'uses'=>'PermissionsController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'permissions::insert', 
		'uses'=>'PermissionsController@insert'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'permissions::remove', 
		'uses'=>'PermissionsController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/routes', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'routes::collection', 
		'uses'=>'RoutesController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'routes::one', 
		'uses'=>'RoutesController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'routes::insert', 
		'uses'=>'RoutesController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'routes::edit', 
		'uses'=>'RoutesController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'routes::remove', 
		'uses'=>'RoutesController@remove'
	]);	
});


$app->group([
	'prefix'    => '/v1/accesses', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'accesses::collection', 
		'uses'=>'AccessesController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'accesses::one', 
		'uses'=>'AccessesController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'accesses::insert', 
		'uses'=>'AccessesController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'accesses::edit', 
		'uses'=>'AccessesController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'accesses::remove', 
		'uses'=>'AccessesController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/customers', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'customers::collection', 
		'uses'=>'CustomersController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'customers::one', 
		'uses'=>'CustomersController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'customers::insert', 
		'uses'=>'CustomersController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'customers::edit', 
		'uses'=>'CustomersController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'customers::remove', 
		'uses'=>'CustomersController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/users', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'users::collection', 
		'uses'=>'UsersController@collection'
	]);

	$app->get('/{username}', [
		'as' => 'users::one', 
		'uses'=>'UsersController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'users::insert', 
		'uses'=>'UsersController@insert'
	]);

	$app->put('/{username}', [
		'middleware' => 'timestamps', 
		'as' => 'users::edit', 
		'uses'=>'UsersController@edit'
	]);

	$app->delete('/{username}', [
		'middleware' => 'timestamps', 
		'as' => 'users::remove', 
		'uses'=>'UsersController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/vehicles', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'vehicles::collection', 
		'uses'=>'VehiclesController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'vehicles::one', 
		'uses'=>'VehiclesController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'vehicles::insert', 
		'uses'=>'VehiclesController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'vehicles::edit', 
		'uses'=>'VehiclesController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'vehicles::remove', 
		'uses'=>'VehiclesController@remove'
	]);	
});


$app->group([
	'prefix'    => '/v1/brands', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'brands::collection', 
		'uses'=>'BrandsController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'brands::one', 
		'uses'=>'BrandsController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'brands::insert', 
		'uses'=>'BrandsController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'brands::edit', 
		'uses'=>'BrandsController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'brands::remove', 
		'uses'=>'BrandsController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/branch-offices', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'branchoffices::collection', 
		'uses'=>'BranchofficesController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'branchoffices::one', 
		'uses'=>'BranchofficesController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'branchoffices::insert', 
		'uses'=>'BranchofficesController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'branchoffices::edit', 
		'uses'=>'BranchofficesController@edit'
	]);

	$app->delete('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'branchoffices::remove', 
		'uses'=>'BranchofficesController@remove'
	]);	
});

$app->group([
	'prefix'    => '/v1/parking-logs', 
	'namespace' => 'App\Http\Controllers',
], function () use ($app) {
	$app->get('/', [
		'as' => 'parkinglogs::collection', 
		'uses'=>'ParkingLogsController@collection'
	]);

	$app->get('/{id}', [
		'as' => 'parkinglogs::one', 
		'uses'=>'ParkingLogsController@one'
	]);

	$app->post('/', [
		'middleware' => 'timestamps', 
		'as' => 'parkinglogs::insert', 
		'uses'=>'ParkingLogsController@insert'
	]);

	$app->put('/{id}', [
		'middleware' => 'timestamps', 
		'as' => 'parkinglogs::edit', 
		'uses'=>'ParkingLogsController@edit'
	]);
});

$app->get('/v1', function() {

	$adapter = new League\Flysystem\Adapter\Local(storage_path('app'));
	$filesystem = new League\Flysystem\Filesystem($adapter);
	//var_dump($filesystem);
	
	//$filesystem->write('texto.txt', 'nuevo mensaje');

	return response()->json(app()->getRoutes());
});	