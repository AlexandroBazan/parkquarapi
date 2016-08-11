<?php
namespace Entities\Vehicles;

use Impark\Mutator\Mutator;

class VehiclesMutator extends Mutator
{
	public function mutInputRegistation_plate($value)
	{
		return strtoupper($value);
	}
}