<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Users\Users;

class UsersController extends Controller
{
    private $users;

    public function __construct(Users $users)
    {
    	$this->users = $users;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->users->collection($request), $this->users->status());
    }

    public function one(Request $request, $username)
    {
    	return response()->json($this->users->one($username, $request), $this->users->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->users->insert($request), $this->users->status());
    }

    public function edit(Request $request, $username)
    {
    	return response()->json($this->users->edit($username, $request), $this->users->status());
    }

    public function remove(Request $request, $username)
    {
    	return response()->json($this->users->remove($username, $request), $this->users->status());
    }
} 