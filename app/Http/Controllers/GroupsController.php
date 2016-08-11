<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Groups\Groups;

class GroupsController extends Controller
{
    private $groups;

    public function __construct(Groups $groups)
    {
    	$this->groups = $groups;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->groups->collection($request), $this->groups->status());
    }

    public function one(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->groups->one($name, $request), $this->groups->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->groups->insert($request), $this->groups->status());
    }

    public function edit(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->groups->edit($name, $request), $this->groups->status());
    }

    public function remove(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->groups->remove($name, $request), $this->groups->status());
    }
}
