<?php
namespace Entities\Profiles;

use Impark\Mutator\Mutator;

class ProfilesMutator extends Mutator
{
	public function mutInputName($value)
	{
		return strtolower($value);
	}
}