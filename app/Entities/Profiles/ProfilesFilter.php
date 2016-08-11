<?php
namespace Entities\Profiles;

use Impark\Filter\Filter;

class ProfilesFilter extends Filter
{
	/**
	 * Filtro para la relacion group para el campo
	 * id del grupo.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filGroupAttribute($value)
	{
		return $this->model->whereHas('group', function ($query) use ($value) {
		    $query->where('id', '=', $value);
		});
	}

	/**
	 * Filtro para la relacion group para el campo
	 * name del grupo.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filGroup_nameAttribute($value)
	{
		return $this->model->whereHas('group', function ($query) use ($value) {
		    $query->where('name', '=', $value);
		});
	}

	/**
	 * Filtro para la relacion group para el campo
	 * active del grupo.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filGroup_activeAttribute($value)
	{
		return $this->model->whereHas('group', function ($query) use ($value) {
		    $query->where('active', '=', $value);
		});
	}
}