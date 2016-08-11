<?php
namespace Entities\Groups;

use Impark\Mutator\Mutator;
use Entities\Profiles\Models\Profile;
use Entities\Groups\Models\Group;

class GroupsMutator extends Mutator
{
	/**
	 * Retorna el id del grupo al cual se accede por
	 * la ruta.
	 * 
	 * @return GroupId
	 */
	public function getGroupId()
	{
		$name = $this->request->route()[2]['name'];

		$group = new Group;

		return $group->where('name', '=', $name)->first()->id;
	}

	/**
	 * Metodo mutador del atributo active, cuando
	 * se edite este campo a 0 los perfiles amarrados
	 * a este grupo tambien cambiaran su estado a 0.
	 * 
	 * @param  mixin $value
	 * @return value
	 */
	public function mutInputActive($value)
	{
		if ($this->request->isMethod('put') && $value == 0) {
			$profile = new Profile;

			$profile->where('group_id', '=', $this->getGroupId())
					->update(['active' => $value]);
			
		}

		return $value;
	}

	public function mutInputName($value)
	{
		return strtolower($value);
	}
}