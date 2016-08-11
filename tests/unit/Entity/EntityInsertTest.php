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

class EntityInsertTest extends TestCase
{
	public function testInsertErrorValidation()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->post($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->insert($request), $users->status());
        });

        $param = [
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];
        
        $status = $this->call('POST', $ruta, $param)->status();

        $this->assertEquals(400, $status);

        $this->post($ruta, $param)
        	 ->seeJson([
        	 	'message'                => 'Hay errores en las reglas de validacion',
		        'code'                   => 103,
		        'type'                   => 'ValidatorError',
		        'user_error_title'       => 'Error de validacion',
		        'user_error_description' => [
					"active"    => ["Este campo es requerido"],
					"birthday"  => ["Este campo es requerido"],
					"dni"       => ["Este campo es requerido"],
					"emails"    => ["Este campo es requerido"],
					"firstname" => ["Este campo es requerido"],
					"gender"    => ["Este campo es requerido"],
					"image"     => ["Este campo es requerido"],
					"lastname"  => ["Este campo es requerido"],
					"password"  => ["Este campo es requerido"],
					"username"  => ["Este campo es requerido"]
		        ],
        	 ]);
	}

	public function testInsertHttpStatus()
	{
		$faker = \Faker\Factory::create();

		$ruta = '/'.__FUNCTION__;

        $this->app->post($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->insert($request), $users->status());
        });

        $sexo = ['hombre', 'mujer'];

        $dni = $faker->numberBetween(50,60).$faker->numberBetween(4000,5600).$faker->numberBetween(10,99);

        $param = [
			"username"  => $faker->cityPrefix.$faker->buildingNumber,
			"active"    => $faker->boolean,
			"dni"       => $dni,
			"password"  => 'pepete9253',
			"firstname" => $faker->firstname,
			"lastname"  => $faker->lastname,
			"gender"    => $sexo[rand(0,1)],
			"image"     => 'none',
			"birthday"  => $faker->date($format = 'Y-m-d', $max = '1992-02-25'),
			"emails"    => [$faker->email],
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];
        
        $status = $this->call('POST', $ruta, $param)->status();

        $this->assertEquals(201, $status);
	}

	public function testInsertTrueResponse()
	{
		$faker = \Faker\Factory::create();

		$ruta = '/'.__FUNCTION__;

        $this->app->post($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->insert($request), $users->status());
        });

        $sexo = ['hombre', 'mujer'];

        $dni = $faker->numberBetween(50,60).$faker->numberBetween(4000,5600).$faker->numberBetween(10,99);

        $param = [
			"username"  => $faker->cityPrefix.$faker->buildingNumber,
			"active"    => $faker->boolean,
			"dni"       => $dni,
			"password"  => 'pepete9253',
			"firstname" => $faker->firstname,
			"lastname"  => $faker->lastname,
			"gender"    => $sexo[rand(0,1)],
			"image"     => 'none',
			"birthday"  => $faker->date($format = 'Y-m-d', $max = '1992-02-25'),
			"emails"    => [$faker->email],
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];

        $this->post($ruta, $param)
        	 ->seeJsonStructure([
        	 	  "id",
				  "username",
				  "active",
				  "dni",
				  "firstname",
				  "lastname",
				  "gender",
				  "image",
				  "birthday",
				  "permissions",
				  "emails",
				  "addresses",
				  "phones"
        	 ]);


	}

	public function testInsertTrueResponseValue()
	{
		$faker = \Faker\Factory::create();

		$ruta = '/'.__FUNCTION__;

        $this->app->post($ruta, function (Request $request) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->insert($request), $users->status());
        });

        $sexo = ['hombre', 'mujer'];

        $dni = $faker->numberBetween(50,60).$faker->numberBetween(4000,5600).$faker->numberBetween(10,99);

        $param = [
			"username"  => $faker->cityPrefix.$faker->buildingNumber,
			"active"    => $faker->boolean,
			"dni"       => $dni,
			"password"  => 'pepete9253',
			"firstname" => $faker->firstname,
			"lastname"  => $faker->lastname,
			"gender"    => $sexo[rand(0,1)],
			"image"     => 'none',
			"birthday"  => $faker->date($format = 'Y-m-d', $max = '1992-02-25'),
			"emails"    => [$faker->email],
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];

        $this->post($ruta, $param)
        	 ->seeJson([
				  "username" => $param['username'],
				  "active"=> intval($param['active']),
				  "dni"=> $param['dni'],
				  "firstname" => $param['firstname'],
				  "lastname" => $param['lastname'],
				  "gender" => $param['gender'],
				  "image" => 'none',
				  "birthday" => $param['birthday'],
        	 ]);
	}
	
}