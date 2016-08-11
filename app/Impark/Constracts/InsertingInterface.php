<?php
namespace Impark\Constracts;

use Illuminate\Http\Request;

interface InsertingInterface
{
	public function insert(Request $request);
}