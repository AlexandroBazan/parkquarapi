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

class EntityRemoveTest extends TestCase
{
	public function testRemoveRegisterExist()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->delete($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->remove($username, $request), $users->status());
        });

        $username = (new Model)->where('delete', '=', 0)
        					   ->where('id', '>', 3)
        					   ->first()->username;

        $ruta = $ruta.'/'.$username;

        $status = $this->call('DELETE', $ruta, [
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ])->status();

        $this->assertEquals(200, $status);

        $register = (new Model)->where('username', '=', $username)
        					   ->first();

        $this->assertEquals($register->delete, 1);

        $register->delete = 0;
        $register->save();
	}

	public function testRemoveRegisterError()
	{
		$ruta = '/'.__FUNCTION__;

        $this->app->delete($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->remove($username, $request), $users->status());
        });

        $username = (new Model)->where('delete', '=', 1)
        					   ->where('id', '>', 3)
        					   ->first()->username;

        $ruta = $ruta.'/'.$username;

        $param = [
        	'timestamps' => [
        		'app' => 1,
        		'user'=> 2,
        		'ip'  => '192.168.45.32'
        	]
        ];

        $status = $this->call('DELETE', $ruta, $param)->status();

        $this->assertEquals(400, $status);

        $this->delete($ruta, $param)
             ->seeJson([
                "message"                => "El registro con el identificador {$username} no existe o ya se elimino",
                "code"                   => 102,
                "type"                   => "RemoveError",
                "user_error_title"       => "No hay registros",
                "user_error_description" => "El usuario no existe o ya fue eliminado"
             ]);
	}
}