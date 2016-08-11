<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\BranchOffices\BranchOffices;

class BranchofficesController extends Controller
{
    private $branchoffices;

    public function __construct(BranchOffices $branchoffices)
    {
    	$this->branchoffices = $branchoffices;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->branchoffices->collection($request), $this->branchoffices->status());
    }

    public function one(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->branchoffices->one($name, $request), $this->branchoffices->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->branchoffices->insert($request), $this->branchoffices->status());
    }

    public function edit(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->branchoffices->edit($name, $request), $this->branchoffices->status());
    }

    public function remove(Request $request, $name)
    {
    	$name = urldecode($name);

    	return response()->json($this->branchoffices->remove($name, $request), $this->branchoffices->status());
    }
}

