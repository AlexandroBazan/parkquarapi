<?php
namespace Entities\Routes;

use Impark\Mutator\Mutator;

class RoutesMutator extends Mutator
{
	public function mutInputDescription($value)
	{
		return strtolower($value);
	}
}