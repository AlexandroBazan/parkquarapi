<?php 
namespace Impark\Constracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TimestampInterface
{
	public function __construct(Model $model);

	public function create(Request $request);

	public function update(Request $request);

	public function delete(Request $request);
}