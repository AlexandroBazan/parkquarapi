<?php
namespace Impark\Constracts;

use Illuminate\Http\Request;

interface RemovingInterface
{
	public function remove($id, Request $request);
}