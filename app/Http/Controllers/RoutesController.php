<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Routes\Routes;

class RoutesController extends Controller
{
    private $routes;

    public function __construct(Routes $routes)
    {
    	$this->routes = $routes;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->routes->collection($request), $this->routes->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->routes->one($id, $request), $this->routes->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->routes->insert($request), $this->routes->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->routes->edit($id, $request), $this->routes->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->routes->remove($id, $request), $this->routes->status());
    }
} 