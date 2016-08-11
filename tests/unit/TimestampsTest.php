<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use Illuminate\Http\Request;
use Laravel\Lumen\Application;


use Impark\Timestamps\TimestampsModel;
use Impark\Timestamps\Timestamps;

use Carbon\Carbon;


class TimestampTest extends TestCase
{
    public function testCreateResponse()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->post($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->create($request);
        });

        $response = $app->handle(Request::create($ruta, 'POST', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->id, $response->getContent());

        $model->delete($register->id);
    }

    public function testCreateInsertData()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->post($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->create($request);
        });

        $response = $app->handle(Request::create($ruta, 'POST', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->user_id, $parameters['user']);
        $this->assertEquals($register->app_id, $parameters['app']);
        $this->assertEquals($register->ip, $parameters['ip']);
        $this->assertEquals($register->type, 'create');
        $this->assertEquals(substr($register->time,0,13), substr(Carbon::now(),0,13));

        $model->delete($register->id);
    }

    public function testUpdateResponse()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->put($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->update($request);
        });

        $response = $app->handle(Request::create($ruta, 'PUT', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->id, $response->getContent());

        $model->delete($register->id);
    }

    public function testUpdateInsertData()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->put($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->update($request);
        });

        $response = $app->handle(Request::create($ruta, 'PUT', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->user_id, $parameters['user']);
        $this->assertEquals($register->app_id, $parameters['app']);
        $this->assertEquals($register->ip, $parameters['ip']);
        $this->assertEquals($register->type, 'update');
        $this->assertEquals(substr($register->time,0,13), substr(Carbon::now(),0,13));

        $model->delete($register->id);
    }

    public function testDeleteResponse()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->delete($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->delete($request);
        });

        $response = $app->handle(Request::create($ruta, 'DELETE', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->id, $response->getContent());

        $model->delete($register->id);
    }

    public function testDeleteInsertData()
    {
        $ruta = '/'.__FUNCTION__;

        $model = app()->make('db')->table('timestamps');

        $parameters = [
                'user' => 1,
                'app'  => 1,
                'ip'   => '192.168.1.43'
            ];
        
        $app = new Application;

        $app->delete($ruta, function (Request $request) {
            $timestamps = new Timestamps(new TimestampsModel);
            return $timestamps->delete($request);
        });

        $response = $app->handle(Request::create($ruta, 'DELETE', ['timestamps' => $parameters]));

        $register = $model->orderBy('id','desc')->first();

        $this->assertEquals($register->user_id, $parameters['user']);
        $this->assertEquals($register->app_id, $parameters['app']);
        $this->assertEquals($register->ip, $parameters['ip']);
        $this->assertEquals($register->type, 'delete');
        $this->assertEquals(substr($register->time,0,13), substr(Carbon::now(),0,13));

        $model->delete($register->id);
    }
}
