<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use Impark\Mutator\test\MutatorTestClass as Mutator;
use Illuminate\Http\Request;
use Laravel\Lumen\Application;

class MutatorTest extends TestCase
{
    public function testMakeWithMutableOptions()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setGenerable([]);
                    
            $mutator->make($req);

            return '';
        });


        $parameters = [
                'name' => 'alexandro',
                'username' => 'KnightOfBlade'
            ];

        $response = $app->handle(Request::create($ruta, 'POST', $parameters));

        $this->assertEquals($parameters['username'], $req->input('username'));
        $this->assertEquals(strtoupper($parameters['name']), $req->input('name'));
        $this->assertEquals(false, $req->has('age'));
    } 

    public function testMakeWithoutMutableOptions()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setGenerable([]);
            $mutator->setMutable([]);
                    
            $mutator->make($req);

            return '';
        });


        $parameters = [
                'name' => 'alexandro',
                'username' => 'KnightOfBlade'
            ];

        $response = $app->handle(Request::create($ruta, 'POST', $parameters));

        $this->assertEquals(strtolower($parameters['username']), $req->input('username'));
        $this->assertEquals(strtoupper($parameters['name']), $req->input('name'));
        $this->assertEquals(false, $req->has('age'));
    }

    public function testMakeWithoutMutableParameters()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setGenerable([]);
                    
            $mutator->make($req);

            return '';
        });
        
        $response = $app->handle(Request::create($ruta, 'POST'));

        $this->assertEquals(false, $req->has('username'));
        $this->assertEquals(false, $req->has('name'));
        $this->assertEquals(false, $req->has('age'));
    }

    public function testMakeWithGenerableOptions()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setMutable([]);
                    
            $mutator->make($req);

            return '';
        });


        $parameters = [
                'fecha' => '2013-11-28',
            ];

        list($ano,$mes,$dia) = explode("-",$parameters['fecha']);

        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;

        if ($dia_diferencia < 0 || $mes_diferencia < 0)
        {
            $ano_diferencia--;
        }

        $response = $app->handle(Request::create($ruta, 'POST', $parameters));

        $this->assertEquals($ano_diferencia, $req->input('age'));
    }

    public function testMakeWithoutGenerableOptions()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setMutable([]);
            $mutator->setGenerable([]);
                    
            $mutator->make($req);

            return '';
        });


        $parameters = [
                'fecha' => '2013-11-28',
            ];

        $response = $app->handle(Request::create($ruta, 'POST', $parameters));

        $this->assertEquals(false, $req->has('age'));
    }

    public function testMakeWithoutGenerableParameters()
    {
        $ruta = '/'.__FUNCTION__;

        $app = new Application;
        
        $req = null;

        $app->post($ruta, function (Request $request) use (&$req) {
            
            $req = $request;

            $mutator = new Mutator;

            $mutator->setMutable([]);
                    
            $mutator->make($req);

            return '';
        });

        $response = $app->handle(Request::create($ruta, 'POST'));

        $this->assertEquals(false, $req->has('age'));
    }
}
