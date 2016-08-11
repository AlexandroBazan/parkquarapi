<?php 
namespace Impark\Constracts;

use Illuminate\Http\Request;

interface MutatorInterface
{
	public function make(Request &$request);
}