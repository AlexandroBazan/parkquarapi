<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Entities\ParkingLogs\ParkingLogs;

class ParkingLogsController extends Controller
{
    private $parkingLogs;

    public function __construct(ParkingLogs $parkingLogs)
    {
    	$this->parkingLogs = $parkingLogs;
    }

    public function collection(Request $request)
    {
    	return response()->json($this->parkingLogs->collection($request), $this->parkingLogs->status());
    }

    public function one(Request $request, $id)
    {
    	return response()->json($this->parkingLogs->one($id, $request), $this->parkingLogs->status());
    }

    public function insert(Request $request)
    {
    	return response()->json($this->parkingLogs->ingress($request), $this->parkingLogs->status());
    }

    public function edit(Request $request, $id)
    {
    	return response()->json($this->parkingLogs->egress($id, $request), $this->parkingLogs->status());
    }
} 