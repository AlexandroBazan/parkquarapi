<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Vehicles\Brands;

class BrandsController extends Controller
{
    private $brands;

    public function __construct(Brands $brands)
    {
    	$this->brands = $brands;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->brands->collection($request), $this->brands->status());
    }

    public function one(Request $request, $id)
    {
    	$id = urldecode($id);

    	return response()->json($this->brands->one($id, $request), $this->brands->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->brands->insert($request), $this->brands->status());
    }

    public function edit(Request $request, $id)
    {
    	$id = urldecode($id);

    	return response()->json($this->brands->edit($id, $request), $this->brands->status());
    }

    public function remove(Request $request, $id)
    {
    	$id = urldecode($id);

    	return response()->json($this->brands->remove($id, $request), $this->brands->status());
    }
}
