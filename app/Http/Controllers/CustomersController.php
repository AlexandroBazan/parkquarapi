<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\Customers\Customers;

class CustomersController extends Controller
{
    private $customers;

    public function __construct(Customers $customers)
    {
    	$this->customers = $customers;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->customers->collection($request), $this->customers->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->customers->one($id, $request), $this->customers->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->customers->insert($request), $this->customers->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->customers->edit($id, $request), $this->customers->status());
    }

    public function remove(Request $request, $id)
    {
    	return response()->json($this->customers->remove($id, $request), $this->customers->status());
    }
} 