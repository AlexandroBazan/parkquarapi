<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Accesses\Accesses;

class AccessesController extends Controller
{
    private $accesses;

    public function __construct(Accesses $accesses)
    {
    	$this->accesses = $accesses;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->accesses->collection($request), $this->accesses->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->accesses->one($id, $request), $this->accesses->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->accesses->insert($request), $this->accesses->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->accesses->edit($id, $request), $this->accesses->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->accesses->remove($id, $request), $this->accesses->status());
    }
} 