<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use Impark\Filter\test\UserFilter as Filter;
use Impark\Filter\test\User as Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Application;

class FilterTest extends TestCase
{
    public function testDependenciesSetModel()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $filter->dependencies($model, $request);

        $this->assertEquals($model, $filter->getModel());
    }

    public function testDependenciesSetTable()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $filter->dependencies($model, $request);

        $this->assertEquals(with($model)->getTable(), $filter->getTable());
    }

    public function testDependenciesReturnThis()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');


        $this->assertEquals(get_class($filter), get_class($filter->dependencies($model, $request)));
    }

    public function testDependenciesSetRequest()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $this->assertEquals($request, $filter->dependencies($model, $request)->getRequest());
    }

    public function testDependenciesSetFilterParamRequest()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');
        $filter->dependencies($model, $request);

        $this->assertEquals(with($model)->getTable(), app('cache')->store('file')->get('table'));
    }

    public function testRelations()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $filter->dependencies($model, $request)
               ->relations($relations);

        $this->assertEquals($relations, $filter->getRelations());
    }

    public function testAttributes()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $filter->dependencies($model, $request)
               ->attributes($attributes);

        $this->assertEquals($attributes, $filter->getAttributes());
    }

    public function testHidden()
    {
        $filter = new Filter;
        $model = new Model;
        $request = app('request');

        $hidden = ['person_id', 'permissions.profile_id'];

        $filter->dependencies($model, $request)
               ->hidden($hidden);

        $this->assertEquals($hidden, $filter->getHidden());
    }

    public function testAllNotFilter()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });


        $this->get($ruta)
             ->seeJsonStructure([
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
             ]);
    }

    public function testAllDeleteFilterValueOn()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'on']));


        $this->get($ruta.'?delete=on')
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $register = app()->make('db')->table('users')->find($response->getData()[0]->id);

        $this->assertEquals(true, $register->delete);
    }

    public function testAllDeleteFilterValueJoin()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join']));


        $this->get($ruta.'?delete=join')
             ->seeJsonStructure([
                 '*' => [
                   'id',
                   'username',
                   'firstname',
                   'lastname',
                   'dni',
                   'active',
                   'delete',
                   'gender',
                   'image',
                   'birthday',
                   'emails',
                   'permissions',
                   'addresses',
                   'phones'
               ]
             ]);

        $registerDeleteFalse = app()->make('db')->table('users')->where('delete','=', false)->first();
        $registerDeleteTrue  = app()->make('db')->table('users')->where('delete','=', true)->first();

        $this->assertEquals($response->getData()[$registerDeleteFalse->id-1]->delete, false);
        $this->assertEquals($response->getData()[$registerDeleteTrue->id-1]->delete, true);
    }


    public function testAllFieldsFilterWithAttributes()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $this->get($ruta.'?fields=id,active,username')
             ->seeJsonStructure([
                 '*' => [
                   'id',
                   'active',
                   'username'
               ]
             ]);
    }

    public function testAllFieldsFilterWithRelations()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $this->get($ruta.'?fields=id,active,username,permissions')
             ->seeJsonStructure([
                 '*' => [
                   'id',
                   'active',
                   'username',
                   'permissions'
               ]
             ]);
    }

    public function testAllTimestampsFilter()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $this->get($ruta.'?timestamps=on')
             ->seeJsonStructure([
                 '*' => [
                   'id',
                   'active',
                   'username',
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
             ]);
    }


    public function testAllAtrributeFilter()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $active = 1;

        $this->get($ruta.'?delete=join&active='.$active)
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join', 'active' => '1']));

        $this->assertEquals($active,$response->getData()[0]->active);
        $this->assertEquals(100,count($response->getData()));
    }

    public function testAllRelationFilter()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $profile = 1;

        $this->get($ruta.'?delete=join&profile='.$profile)
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join', 'profile' => $profile]));

        $count = (new Model)->with($relations)
                    ->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->whereHas('permissions', function ($query) use ($profile) {
                        $query->where('profile_id', '=', $profile);
                    })->count();

        $profileResponse = null;

        foreach ($response->getData()[0]->permissions as $key => $value) {
            if ($value->profile->id == $profile) {
                $profileResponse = $profile;
            }
        }

        $this->assertEquals($profile,$profileResponse);
        $this->assertEquals($count,count($response->getData()));
    }

    public function testAllSortFilterAsc()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $attribute = 'username';
        $sort = '+'.$attribute;

        $this->get($ruta.'?delete=join&sort='.$sort)
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join', 'sort' => $sort]));

      

        $this->assertEquals(100,count($response->getData()));
    }

    public function testAllSortFilterDesc()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $attribute = 'username';
        $sort = '-'.$attribute;

        $this->get($ruta.'?delete=join&sort='.$sort)
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join', 'sort' => $sort]));

        
        $this->assertEquals(100,count($response->getData()));
    }

    public function testAllPagingFilter()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->all());
        });

        $offset=2;
        $limit =100;

        $this->get($ruta.'?delete=join&offset='.$offset.'&limit='.$limit)
             ->seeJsonStructure([
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
                   'phones'
               ]
             ]);

        $response = $this->app->handle(Request::create($ruta, 'GET', ['delete' => 'join', 'offset' => $offset, 'limit' => $limit]));

        $count = (new Model)->take($limit)
                            ->offset($offset)->get()->count();

        $this->assertEquals($count,count($response->getData()));
    }


    public function testFindReturnRegister()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{id}', function ($id, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return $filter->dependencies(new Model, $request)->find($id);
        });

        $id = (new Model)->where('delete', '=', '0')->first()->id;

        $register = $this->app->handle(Request::create($ruta.'/'.$id, 'GET'))
                         ->getOriginalContent()
                         ->toArray();

        $this->assertEquals($id, $register['id']);

        $this->get($ruta.'/'.$id)
             ->seeJson([
                   'id' => $register['id'],
                   'username' => $register['username'],
                   'firstname'=> $register['firstname'],
                   'lastname' => $register['lastname'],
                   'dni' => $register['dni'],
                   'active' => $register['active'],
                   'gender' => $register['gender'],
                   'image' => $register['image'],
                   'birthday' => $register['birthday'],
                   'emails' => $register['emails'],
                   'permissions' => $register['permissions'],
                   'addresses'=> $register['addresses'],
                   'phones' => $register['phones'],
             ]);
    }

    public function testFindReturnRegisterWithOtherAttibute()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{username}', function ($username, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return $filter->dependencies(new Model, $request)->find($username, 'username');
        });

        $username = (new Model)->where('delete', '=', 0)->first()->username;

        $register = $this->app->handle(Request::create($ruta.'/'.$username, 'GET'))
                         ->getOriginalContent()
                         ->toArray();

        $this->assertEquals($username, $register['username']);

        $this->get($ruta.'/'.$username)
             ->seeJson([
                   'id' => $register['id'],
                   'username' => $register['username'],
                   'firstname'=> $register['firstname'],
                   'lastname' => $register['lastname'],
                   'dni' => $register['dni'],
                   'active' => $register['active'],
                   'gender' => $register['gender'],
                   'image' => $register['image'],
                   'birthday' => $register['birthday'],
                   'emails' => $register['emails'],
                   'permissions' => $register['permissions'],
                   'addresses'=> $register['addresses'],
                   'phones' => $register['phones'],
             ]);
    }

    public function testFindReturnRegisterDeleteOn()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{id}', function ($id, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return $filter->dependencies(new Model, $request)->find($id);
        });

        $id = (new Model)->where('delete', '=', 1)->first()->id;

        $register = $this->app->handle(Request::create($ruta.'/'.$id.'?delete=on', 'GET'))
                         ->getOriginalContent()
                         ->toArray();

        $this->assertEquals($id, $register['id']);

        $this->get($ruta.'/'.$id.'?delete=on')
             ->seeJson([
                   'id' => $register['id'],
                   'username' => $register['username'],
                   'firstname'=> $register['firstname'],
                   'lastname' => $register['lastname'],
                   'dni' => $register['dni'],
                   'active' => $register['active'],
                   'gender' => $register['gender'],
                   'image' => $register['image'],
                   'birthday' => $register['birthday'],
                   'emails' => $register['emails'],
                   'permissions' => $register['permissions'],
                   'addresses'=> $register['addresses'],
                   'phones' => $register['phones'],
             ]);
    }

    public function testFindReturnRegisterWithTimestamps()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{id}', function ($id, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return $filter->dependencies(new Model, $request)->find($id);
        });

        $id = (new Model)->where('delete', '=', 0)->first()->id;

        $register = $this->app->handle(Request::create($ruta.'/'.$id.'?timestamps=on', 'GET'))
                         ->getOriginalContent()
                         ->toArray();

        $this->assertEquals($id, $register['id']);

        $this->get($ruta.'/'.$id.'?timestamps=on')
             ->seeJson([
                   'id' => $register['id'],
                   'username' => $register['username'],
                   'firstname'=> $register['firstname'],
                   'lastname' => $register['lastname'],
                   'dni' => $register['dni'],
                   'active' => $register['active'],
                   'gender' => $register['gender'],
                   'image' => $register['image'],
                   'birthday' => $register['birthday'],
                   'emails' => $register['emails'],
                   'permissions' => $register['permissions'],
                   'addresses'=> $register['addresses'],
                   'phones' => $register['phones'],
                   'timestamps' => $register['timestamps'],
             ]);

        $this->get($ruta.'/'.$id.'?timestamps=on')
             ->seeJsonStructure([
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
             ]);

    }

    public function testFindReturnNull()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{id}', function ($id, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->find($id));
        });

        $id = (new Model)->where('delete', '=', 1)->first()->id;

        $response = $this->app->handle(Request::create($ruta.'/'.$id, 'GET'));

        $this->assertEquals('{}',   $response->content());
    }

    public function testFindReturnNullDeleteOn()
    {
        $relations = [
            'permissions', 
            'emails',
            'addresses',
            'phones'
        ];

        $attributes = [
            'id',
            'username',
            'firstname',
            'lastname',
            'dni',
            'active',
            'gender',
            'image',
            'birthday'
        ];

        $hidden = [
            'person_id', 
            'permissions.profile_id'
        ];

        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{id}', function ($id, Request $request) use ($relations, $attributes, $hidden) {
            $filter = new Filter;
            $filter->hidden($hidden);
            $filter->relations($relations);

            $filter->attributes($attributes);

            return response()->json($filter->dependencies(new Model, $request)->find($id));
        });

        $id = (new Model)->where('delete', '=', 0)->first()->id;

        $response = $this->app->handle(Request::create($ruta.'/'.$id.'?delete=on', 'GET'));

        $this->assertEquals('{}',   $response->content());
    }

    public function testCountNoDeleteRegister()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $filter = new Filter;

            return $filter->dependencies(new Model, $request)->count();
        });

        $response = $this->app->handle(Request::create($ruta, 'GET'));

        $count = app('db')->table('users')->where('delete', '=', 0)->count();


        $this->assertEquals($count, $response->content());
    }

    public function testCountDeleteRegister()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $filter = new Filter;

            return $filter->dependencies(new Model, $request)->count();
        });

        $response = $this->app->handle(Request::create($ruta.'?delete=on', 'GET'));

        $count = app('db')->table('users')->where('delete', '=', 1)->count();


        $this->assertEquals($count, $response->content());
    }


    public function testCountAllRegister()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta, function (Request $request) {
            $filter = new Filter;

            return $filter->dependencies(new Model, $request)->count();
        });

        $response = $this->app->handle(Request::create($ruta.'?delete=join', 'GET'));

        $count = app('db')->table('users')->count();


        $this->assertEquals($count, $response->content());
    }
}
