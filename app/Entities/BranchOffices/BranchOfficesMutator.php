<?php
namespace Entities\BranchOffices;

use Impark\Mutator\Mutator;
use Entities\Profiles\Models\Profile;
use Entities\Groups\Models\Group;

class BranchOfficesMutator extends Mutator
{
	public function mutInputName($value)
	{
		return strtolower($value);
	}
}