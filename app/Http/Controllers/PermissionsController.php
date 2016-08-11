<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Permissions\Permissions;

class PermissionsController extends Controller
{
    private $permissions;

    public function __construct(Permissions $permissions)
    {
    	$this->permissions = $permissions;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->permissions->collection($request), $this->permissions->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->permissions->one($id, $request), $this->permissions->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->permissions->insert($request), $this->permissions->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->permissions->remove($id, $request), $this->permissions->status());
    }
}
