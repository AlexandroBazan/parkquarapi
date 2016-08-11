<?php
namespace Entities\Vehicles;

use Impark\Mutator\Mutator;

class BrandsMutator extends Mutator
{
	public function mutInputName($value)
	{
		return strtolower($value);
	}
}