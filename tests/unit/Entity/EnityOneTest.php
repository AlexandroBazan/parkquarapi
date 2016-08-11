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

class EntityOneTest extends TestCase
{
    public function testOneRegisterExist()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->one($username, $request), $users->status());
        });

        $user = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->where('users.delete', '=', 0)->first();

        $username = $user->username;

        $status = $this->call('GET', $ruta.'/'.$username)->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'/'.$username, 'GET'));

        $this->get($ruta.'/'.$username)
             ->seeJsonStructure([
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
             ]);

        $this->assertEquals($user->id, $response->getData()->id); 
        $this->assertEquals($user->dni, $response->getData()->dni); 
        $this->assertEquals($user->username, $response->getData()->username); 
        $this->assertEquals($user->delete, 0); 
        $this->assertEquals($user->firstname, $response->getData()->firstname); 
        $this->assertEquals($user->lastname, $response->getData()->lastname); 
        $this->assertEquals($user->active, $response->getData()->active); 
        $this->assertEquals($user->gender, $response->getData()->gender); 
        $this->assertEquals($user->image, $response->getData()->image); 
        $this->assertEquals($user->birthday, $response->getData()->birthday); 
    }

    public function testOneRegisterDelete()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->one($username, $request), $users->status());
        });

        $user = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->where('users.delete', '=', 1)->first();

        $username = $user->username;

        $status = $this->call('GET', $ruta.'/'.$username.'?delete=on')->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'/'.$username.'?delete=on', 'GET'));

        $this->get($ruta.'/'.$username.'?delete=on')
             ->seeJsonStructure([
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
             ]);

        $this->assertEquals($user->id, $response->getData()->id); 
        $this->assertEquals($user->dni, $response->getData()->dni); 
        $this->assertEquals($user->username, $response->getData()->username); 
        $this->assertEquals($user->delete, 1); 
        $this->assertEquals($user->firstname, $response->getData()->firstname); 
        $this->assertEquals($user->lastname, $response->getData()->lastname); 
        $this->assertEquals($user->active, $response->getData()->active); 
        $this->assertEquals($user->gender, $response->getData()->gender); 
        $this->assertEquals($user->image, $response->getData()->image); 
        $this->assertEquals($user->birthday, $response->getData()->birthday); 
    }

    public function testOneRegisterNoExist()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->one($username, $request), $users->status());
        });

        $username = '$$usuarioconCaracteresNoValidos';

        $status = $this->call('GET', $ruta.'/'.$username)->status();

        $this->assertEquals(400, $status);

        $this->get($ruta.'/'.$username)
             ->seeJson([
                "message"                => "no se ha encontrado un registro activo con el identificador {$username}",
                "code"                   => 101,
                "type"                   => "OneError",
                "user_error_title"       => "No hay registros",
                "user_error_description" => "No existe un usuario con ese nombre de usuario"
             ]);
    }

    public function testOneRegisterExistWithTimestamps()
    {
        $ruta = '/'.__FUNCTION__;

        $this->app->get($ruta.'/{username}', function (Request $request, $username) {
            $users = new Users(
                new Model, 
                new Filter, 
                new Validator(app()->make('validator')), 
                new UsersMutator, 
                new Timestamps(new TimestampsModel),
                new HttpErrorReporter 
            );
            
            return response()->json($users->one($username, $request), $users->status());
        });

        $user = (new Model)->join('persons', 'users.person_id', '=', 'persons.id')
                    ->select('users.*', 
                        'persons.dni', 
                        'persons.firstname', 
                        'persons.lastname', 
                        'persons.gender', 
                        'persons.image', 
                        'persons.birthday'
                    )->where('users.delete', '=', 0)->first();

        $username = $user->username;

        $status = $this->call('GET', $ruta.'/'.$username.'?timestamps=on')->status();

        $this->assertEquals(200, $status);

        $response = $this->app->handle(Request::create($ruta.'/'.$username.'?timestamps=on', 'GET'));

        $this->get($ruta.'/'.$username.'?timestamps=on')
             ->seeJsonStructure([
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
             ]);

        $this->assertEquals($user->id, $response->getData()->id); 
        $this->assertEquals($user->dni, $response->getData()->dni); 
        $this->assertEquals($user->username, $response->getData()->username); 
        $this->assertEquals($user->delete, 0); 
        $this->assertEquals($user->firstname, $response->getData()->firstname); 
        $this->assertEquals($user->lastname, $response->getData()->lastname); 
        $this->assertEquals($user->active, $response->getData()->active); 
        $this->assertEquals($user->gender, $response->getData()->gender); 
        $this->assertEquals($user->image, $response->getData()->image); 
        $this->assertEquals($user->birthday, $response->getData()->birthday); 
    }
}
