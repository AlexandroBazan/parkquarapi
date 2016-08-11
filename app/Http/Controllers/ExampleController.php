<?php

namespace App\Http\Controllers;

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


class ExampleController extends Controller
{
    

    public function aa(Request $request, $id)
    {
        
        $users = new Users(
            new Model, 
            new Filter, 
            new Validator(app()->make('validator')), 
            new UsersMutator, 
            new Timestamps(new TimestampsModel),
            new HttpErrorReporter 
        );  

        return response()->json($users->edit($id, $request), $users->status());
    }
}
