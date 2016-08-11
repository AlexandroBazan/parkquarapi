<?php
namespace Impark\Constracts;

use Illuminate\Http\Request;

interface EditingInterface
{
	public function edit($id, Request $request);
}