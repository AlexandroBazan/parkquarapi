<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Impark\Error\HttpErrorReporter;

class HttpErrorReporterTest extends TestCase
{
    public function testHttpCode()
    {
        $error = new HttpErrorReporter;

        $code = 401;

        $message = [
                'message'                => 'fallo de validacion',
                'code'                   => 302,
                'type'                   => 'ValidationError',
                'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
                'user_error_description' => [
                    'ejemplo' => 'error de sintaxis'
                ]
            ];

        $error->send($message, $code);
        $this->assertEquals($code, $error->httpCode());
    }

    public function testHttpCodeFail()
    {
        $error = new HttpErrorReporter;

        $code = 200;

        $message = [
                'message'                => 'fallo de validacion',
                'code'                   => 302,
                'type'                   => 'ValidationError',
                'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
                'user_error_description' => [
                    'ejemplo' => 'error de sintaxis'
                ]
            ];

        try {
            $error->send($message, $code);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "Solo se aceptan los codigos http 400 y 401 en el metodo ErrorReporter::send()");
            return;
        }


        $this->fail("espera algun tipo de ecepcion.");
    }

    public function testHas()
    {
        $error = new HttpErrorReporter;

        $message = [
                'message'                => 'fallo de validacion',
                'code'                   => 302,
                'type'                   => 'ValidationError',
                'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
                'user_error_description' => [
                    'ejemplo' => 'error de sintaxis'
                ]
            ];

        $error->send($message);
        $this->assertEquals(true, $error->has());
    }

    public function testResponse()
    {
        $error = new HttpErrorReporter;

        $message = [
            'message'                => 'fallo de validacion',
            'code'                   => 302,
            'type'                   => 'ValidationError',
            'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
            'user_error_description' => [
                'ejemplo' => 'error de sintaxis'
            ]
        ];

        $error->send($message);
        

        $this->assertEquals($message, $error->response());
    }

    public function testSend()
    {
        $error = new HttpErrorReporter;

        $message = [
            'message'                => 'fallo de validacion',
            'code'                   => 302,
            'type'                   => 'ValidationError',
            'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
            'user_error_description' => [
                'ejemplo' => 'error de sintaxis'
            ]
        ];

        $error->send($message);
        

        $this->assertEquals($message, $error->response());
        $this->assertEquals(400, $error->httpCode());
        $this->assertEquals(true, $error->has());
    }

    public function testSendErrorFormatMessage()
    {
        $error = new HttpErrorReporter;

        $message = [
            'message'                => 15,
            'code'                   => 302,
            'type'                   => 'ValidationError',
            'user_error_title'       => 'Los siguientes datos tienen un formato no valido',
            'user_error_description' => [
                'ejemplo' => 'error de sintaxis'
            ]
        ];

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'message' solo acepta tipo String y no el tipo integer");
        }

        $message['message'] = 'string';
        $message['code'] = 18;

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'code' solo acepta tipo Integer y no del tipo string");
        }

        $message['code'] = 302;
        $message['type'] = [];

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'type' solo acepta tipo String y no el tipo array");
        }

        $message['type'] = '';
        $message['user_error_title'] = 302;

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'user_error_title' solo acepta tipo String y no del tipo integer");
        }

        $message['user_error_title'] = '';
        $message['user_error_description'] = 35;

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'user_error_description' solo acepta tipo String o Array y no del tipo integer");
        }

        $message['attribute'] = '';

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "El arreglo contiene propiedades no soportadas por ErrorReporter::send()");
        }

        unset($message['attribute'], $message['code']);

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "El arreglo no tiene todas las propiedades soportadas por ErrorReporter::send()");
        }

        $message['bad'] = '';

        try {
            $error->send($message);
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), "La propiedad 'bad' no es soportada en el metodo ErrorReporter::send()");
            return;
        }


        $this->fail("espera algun tipo de ecepcion.");
    }
}
