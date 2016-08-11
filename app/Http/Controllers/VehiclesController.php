<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Vehicles\Vehicles;

class VehiclesController extends Controller
{
    private $vehicles;

    public function __construct(Vehicles $vehicles)
    {
    	$this->vehicles = $vehicles;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->vehicles->collection($request), $this->vehicles->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->vehicles->one($id, $request), $this->vehicles->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->vehicles->insert($request), $this->vehicles->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->vehicles->edit($id, $request), $this->vehicles->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->vehicles->remove($id, $request), $this->vehicles->status());
    }
} 