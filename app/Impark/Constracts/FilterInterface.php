<?php 
namespace Impark\Constracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface FilterInterface
{
	public function count();

	public function all();

	public function find($id, $by = 'id');

	public function dependencies(Model $model, Request $request);

	public function relations(array $relations);

	public function hidden(array $hidden);

	public function attributes(array $attributes);
}