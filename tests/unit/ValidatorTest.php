<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

use Impark\Validator\test\UserValidator as Validator;
//use Impark\Validator\Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Application;

class ValidatorTest extends TestCase
{
    public function testCreateTrue()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'username' => 'alekandero35',
            'password' => '123456789',
            'dni'      => '58624545',
            'firstname'=> 'alexandro',
            'lastname' => 'bazan ladines',
            'emails'   => [
                'juan@gmail.com',
            ],
        ];

        $valid = $validator->create($input);
        
        $this->assertEquals(true, $valid);
    }

    public function testCreateFalse()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'username' => 'alekandero35',
            'password' => '123456789',
            'dni'      => '58624545',
            'firstname'=> 'alexandro',
            'lastname' => 'bazan ladines',
            'emails'   => [
                'juan',
            ],
        ];

        $valid = $validator->create($input);

        $this->assertEquals(false, $valid);
    }

    public function testErrorsCreateFails()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'username' => 'alekandero35',
            'password' => '123456789',
            'dni'      => '58624545',
            'firstname'=> 'alexandro',
            'lastname' => 'bazan ladines',
            'emails'   => [
                'juan',
            ],
        ];

        $validator->create($input);

        $this->assertEquals([
            'emails.0' => [
                    'El formato del correo es incorrecto'
                ]
            ], 
            $validator->errors()
        );
    }

    public function testUpdateTrue()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'emails'   => [
                'juan@gmail.com',
            ],
        ];

        $valid = $validator->update($input);

        $this->assertEquals(true, $valid);
    }

    public function testUpdateFalse()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'emails'   => [
                'juan',
            ],
        ];

        $valid = $validator->update($input);

        $this->assertEquals(false, $valid);
    }

    public function testErrorsUpdateFails()
    {
        $validator = new Validator(app()->make('validator'));

        $input = [
            'emails'   => [
                'juan',
            ],
        ];

        $validator->update($input);

        $this->assertEquals([
            'emails.0' => [
                    'El formato del correo es incorrecto'
                ]
            ], 
            $validator->errors()
        );
    }
}
