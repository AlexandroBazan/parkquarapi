<?php

use Laravel\Lumen\Testing\DatabaseTransactions;


use Illuminate\Http\Request;

use Impark\Timestamps\TimestampsModel;
use Impark\Timestamps\Timestamps;

use Impark\Filter\test\User as Model;
use Impark\Filter\test\UserFilter as Filter;
use Impark\Validator\test\UserValidator as Validator;
use Impark\Error\HttpErrorReporter;

use Laravel\Lumen\Application;

use Impark\Ent\test\Users;
use Impark\Ent\test\UsersMutator;

use Illuminate\Database\Query\Builder;

class EntityCollectionTest extends TestCase
{
    public function testAllCheckFormat()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);
    }

    public function testAllCheckDefaultOffset()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals(0, $response->getData()->offset);
    }

    public function testAllCheckDefaultLimit()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals(100, $response->getData()->limit);
    }

    public function testAllCheckDefaultFirst()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals(null, $response->getData()->first);
    }

    public function testAllCheckDefaultPrevious()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals(null, $response->getData()->previous);
    }


    public function testAllCheckTotal()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($response->getData()->total, count($response->getData()->items));
    }

    public function testAllCheckLink()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {

            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals('http://localhost'.$ruta, $response->getData()->link);
    }

    public function testAllCheckNext()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {

            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $totalModelRegisterExist = (new Model)->where('delete', '=', 0)->count();

        if ($totalModelRegisterExist < 3) {
        	$this->fail("No hay registros suficientes para ejecutar esta prueba");
        }

        $limit = intval($totalModelRegisterExist/2);

        $status = $this->call('GET', $ruta.'?limit='.$limit)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'?limit='.$limit, 'GET'));

        $next = 'http://localhost'.$ruta.'/?limit='.$limit.'&offset='.$limit;

        $this->assertEquals($next, $response->getData()->next);
    }

    public function testAllCheckNextNull()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {

            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $totalModelRegisterExist = (new Model)->where('delete', '=', 0)->count();

        $status = $this->call('GET', $ruta.'?limit='.$totalModelRegisterExist)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'?limit='.$totalModelRegisterExist, 'GET'));

        $this->assertEquals(null, $response->getData()->next);
    }

    public function testAllCheckLast()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {

            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $totalModelRegisterExist = (new Model)->where('delete', '=', 0)->count();

        if ($totalModelRegisterExist < 3) {
        	$this->fail("No hay registros suficientes para ejecutar esta prueba");
        }

        $limit = intval($totalModelRegisterExist/2);

        $status = $this->call('GET', $ruta.'?limit='.$limit)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'?limit='.$limit, 'GET'));

        $offset = intval($totalModelRegisterExist/$limit) * $limit;

		$offset += ($totalModelRegisterExist%$limit > 0) ? 0 : - $limit;

        $last = 'http://localhost'.$ruta.'/?limit='.$limit.'&offset='.$offset;

        $this->assertEquals($last, $response->getData()->last);
    }

    public function testAllCheckLastNull()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {

            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $totalModelRegisterExist = (new Model)->where('delete', '=', 0)->count();

        $status = $this->call('GET', $ruta.'?limit='.$totalModelRegisterExist)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'?limit='.$totalModelRegisterExist, 'GET'));

        $this->assertEquals(null, $response->getData()->last);
    }

    public function testAllWithTimestamps()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $status = $this->call('GET', $ruta.'?timestamps=on')->status();

        $this->assertEquals(200, $status);

        $this->get($ruta.'?timestamps=on')
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
		                   	'timestamps' => [
		                        'created' => [
		                            'id','ip','user_id','time','app_id'
		                        ],
		                        'updated' => [
		                            'id','ip','user_id','time','app_id'
		                        ],
		                        'deleted' => [
		                            'id','ip','user_id','time','app_id'
		                        ]
		                   ]
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);
    }

    public function testAllWithFilterAttribute()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->where('active','=', 1)
        						  ->where('delete', '=', 0)
        						  ->get();

        $ruta = $ruta.'?active=1&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));

    }

    public function testAllWithFilterRelation()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->whereHas('permissions', function ($query) {
		    $query->where('profile_id', '=', 1);
		})->get();

        $ruta = $ruta.'?delete=join&profile=1&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions' => [
		                   		'*' => [
		                   			'id',
		                   			'profile' => [
		                   				'id',
		                   				'name',
		                   				'active',
		                   				'group_id'
		                   			]
		                   		]
		                   	],
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));

    }

    public function testAllWithDeleteOn()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->where('delete', '=', 1)
        						  ->get();

        $ruta = $ruta.'?delete=on&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));

    }

    public function testAllWithDeleteJoin()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->get();

        $ruta = $ruta.'?delete=join&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));

    }

    public function testAllWithSortAsc()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->orderBy('username','asc')->get();

        $ruta = $ruta.'?delete=join&sort=+username&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));
        $this->assertEquals($collections->first()->username, $response->getData()->items[0]->username);

    }

    public function testAllWithSortDesc()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $collections = (new Model)->orderBy('username','desc')->get();

        $ruta = $ruta.'?delete=join&sort=-username&limit='.$collections->count();

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'firstname',
		                   	'lastname',
		                   	'dni',
		                   	'active',
		                   	'gender',
		                   	'image',
		                   	'birthday',
		                   	'emails',
		                   	'permissions',
		                   	'addresses',
		                   	'phones',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $this->assertEquals($collections->count(), count($response->getData()->items));
        $this->assertEquals($collections->first()->username, $response->getData()->items[0]->username);

    }

    public function testAllWithShowFields()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->collection($request), $users->status());
        });

        $ruta = $ruta.'?delete=join&fields=username,id,person_id,updated_id';

        $status = $this->call('GET', $ruta)->status();

        $this->assertEquals(200, $status);

        $this->get($ruta)
             ->seeJsonStructure([
                   'link',
                   'items' => [
                   		'*' => [
                   			'id',
		                   	'username',
		                   	'person_id',
		                   	'updated_id',
                   		]
                   ],
                   'total',
                   'limit',
                   'offset',
                   'first',
                   'next',
                   'previous',
                   'last'
             ]);
    }
}
