<?php
namespace Entities\Groups;

use Impark\Filter\Filter;

class GroupsFilter extends Filter
{
	/**
	 * Filtro para la relacion profiles para el campo
	 * id del perfil.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filProfileAttribute($value)
	{
		return $this->model->whereHas('profiles', function ($query) use ($value) {
		    $query->where('id', '=', $value);
		});
	}

	/**
	 * Filtro para la relacion profiles para el campo
	 * active del perfil.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filProfile_activeAttribute($value)
	{
		return $this->model->whereHas('profiles', function ($query) use ($value) {
		    $query->where('active', '=', $value);
		});
	}
}