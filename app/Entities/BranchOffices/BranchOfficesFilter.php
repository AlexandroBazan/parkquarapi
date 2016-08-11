<?php
namespace Entities\BranchOffices;

use Impark\Filter\Filter;

class BranchOfficesFilter extends Filter
{
	/**
	 * Filtro para la relacion profiles para el campo
	 * id del perfil.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filProfileAttribute__($value)
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
	protected function filProfile_activeAttribute__($value)
	{
		return $this->model->whereHas('profiles', function ($query) use ($value) {
		    $query->where('active', '=', $value);
		});
	}
}