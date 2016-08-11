<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Profiles\Profiles;
use Entities\Permissions\Permissions;
use Entities\Accesses\Accesses;

class ProfilesController extends Controller
{
    private $profiles;
    private $permissions;
    private $accesses;

    public function __construct(Profiles $profiles, Permissions $permissions, Accesses $accesses)
    {
        $this->profiles = $profiles;
        $this->permissions = $permissions;
    	$this->accesses = $accesses;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->profiles->collection($request), $this->profiles->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->profiles->one($id, $request), $this->profiles->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->profiles->insert($request), $this->profiles->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->profiles->edit($id, $request), $this->profiles->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->profiles->remove($id, $request), $this->profiles->status());
    }

    public function permissions(Request $request, $id)
    {
        return response()->json($this->permissions->byProfile($id, $request), $this->permissions->status());
    }

    public function accesses(Request $request, $id)
    {
        return response()->json($this->accesses->byProfile($id, $request), $this->permissions->status());
    }
}
