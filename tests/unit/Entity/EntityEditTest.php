<?php

use Laravel\Lumen\Testing\DatabaseTransactions;


use Illuminate\Http\Request;

use Impark\Timestamps\TimestampsModel;
use Impark\Timestamps\Timestamps;

use Impark\Filter\test\User as Model;
use Impark\Filter\test\UserFilter as Filter;
use Impark\Ent\test\UserValidator as Validator;
use Impark\Error\HttpErrorReporter;

use Laravel\Lumen\Application;

use Impark\Ent\test\Users;
use Impark\Ent\test\UsersMutator;

use Illuminate\Database\Query\Builder;

class EntityEditTest extends TestCase
{
	
	public function testEditErrorValidationOneValue()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->put($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->edit($username, $request), $users->status());
        });

        $usuario = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
					->select('users.*', 
						'persons.dni', 
						'persons.firstname', 
						'persons.lastname', 
						'persons.gender', 
						'persons.image', 
						'persons.birthday'
					)->where('users.delete', '=',0)->orderBy('username','desc')->first();

        $param = [
        	'dni' => $usuario->dni,
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];
        
        $status = $this->call('PUT', $ruta.'/'.$usuario->username, $param)->status();

        $this->assertEquals(400, $status);

        $this->put($ruta.'/'.$usuario->username, $param)
        	 ->seeJson([
        	 	'message'                => 'Hay errores en las reglas de validacion',
		        'code'                   => 104,
		        'type'                   => 'ValidatorError',
		        'user_error_title'       => 'Error de validacion',
		        'user_error_description' => [
					"dni"       => ["ya existe un usuario con el mismo DNI"],
		        ],
        	 ]);
	}

	public function testEditErrorValidationTwoValue()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->put($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->edit($username, $request), $users->status());
        });

        $usuario = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
					->select('users.*', 
						'persons.dni', 
						'persons.firstname', 
						'persons.lastname', 
						'persons.gender', 
						'persons.image', 
						'persons.birthday'
					)->where('users.delete', '=',0)->orderBy('username','desc')->first();

        $param = [
        	'dni' => $usuario->dni,
        	'firstname' => '12312312312',
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];
        
        $status = $this->call('PUT', $ruta.'/'.$usuario->username, $param)->status();

        $this->assertEquals(400, $status);

        $this->put($ruta.'/'.$usuario->username, $param)
        	 ->seeJson([
        	 	'message'                => 'Hay errores en las reglas de validacion',
		        'code'                   => 104,
		        'type'                   => 'ValidatorError',
		        'user_error_title'       => 'Error de validacion',
		        'user_error_description' => [
					"dni"       => ["ya existe un usuario con el mismo DNI"],
					"firstname" => ["The firstname format is invalid."]
		        ],
        	 ]);
	}

	public function testEditErrorRegisterNotExist()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->put($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->edit($username, $request), $users->status());
        });

        $usuario = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
					->select('users.*', 
						'persons.dni', 
						'persons.firstname', 
						'persons.lastname', 
						'persons.gender', 
						'persons.image', 
						'persons.birthday'
					)->where('users.delete', '=',0)->orderBy('username','desc')->first();

        $param = [
        	'firstname' => 'luis',
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];
        
        $status = $this->call('PUT', $ruta.'/'.$usuario->username.'@@--@', $param)->status();

        $this->assertEquals(400, $status);

        $this->put($ruta.'/'.$usuario->username.'@@--@', $param)
        	 ->seeJson([
        	 	'message'                => 'No se encuentra el registor con el identificador '.$usuario->username.'@@--@ que se quiere editar',
		        'code'                   => 105,
		        'type'                   => 'EditError',
		        'user_error_title'       => 'No hay registro',
		        'user_error_description' => 'El registro que quiere editar no existe o ya fue eliminado',
        	 ]);
	}

    public function testEditOneTrue()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->put($ruta.'/{id}', function (Request $request, $id) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->edit($id, $request), $users->status());
        });

        $usuario = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->where('users.delete', '=',0)->orderBy('username','desc')->first();

        $faker = \Faker\Factory::create();
        
        $lastname = $faker->lastname;
        
        $param = [
            'lastname' => $lastname,
            'timestamps' => [
                'app' => 1,
                'user'=> 2,
                'ip'  => '192.168.45.32'
            ]
        ];
        
        $response = $this->call('PUT', $ruta.'/'.$usuario->username, $param);

        $editUser = $response->getData();

        $status = $response->status();

        $this->assertEquals(200, $status);

        $this->assertEquals($usuario->username, $editUser->username);
        
        $this->assertEquals($param['lastname']  , $editUser->lastname);
    }

    public function testEditTwoTrue()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->put($ruta.'/{id}', function (Request $request, $id) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->edit($id, $request), $users->status());
        });

        $usuario = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->where('users.delete', '=',0)->orderBy('username','desc')->first();

        $faker = \Faker\Factory::create();
        
        $lastname = $faker->lastname;
        $firstname = $faker->firstname;
        
        $param = [
            'lastname' => $lastname,
            'firstname' => $firstname,
            'timestamps' => [
                'app' => 1,
                'user'=> 2,
                'ip'  => '192.168.45.32'
            ]
        ];
        
        $response = $this->call('PUT', $ruta.'/'.$usuario->username, $param);

        $editUser = $response->getData();

        $status = $response->status();

        $this->assertEquals(200, $status);

        $this->assertEquals($usuario->username, $editUser->username);
        
        $this->assertEquals($param['lastname']  , $editUser->lastname);
        $this->assertEquals($param['firstname']  , $editUser->firstname);
    }
}

