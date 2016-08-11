<?php
namespace Entities\ParkingLogs;

use Impark\Filter\Filter;

class ParkingLogsFilter extends Filter
{
	protected $deleteMode = false;
	/**
	 * Filtro para la relacion profiles para el campo
	 * id del perfil.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filProfileAttribute($value)
	{
		return $this->model->whereHas('profile', function ($query) use ($value) {
		    $query->where('id', '=', $value);
		});
	}

	/**
	 * Filtro para la relacion profiles para el campo
	 * group_id del perfil.
	 * 
	 * @param  mixin  $value valor del filtro
	 * @return Model
	 */
	protected function filGroupAttribute__($value)
	{
		return $this->model->whereHas('profile', function ($query) use ($value) {
		    $query->where('group_id', '=', $value);
		});
	}

	protected function filBranch_officeAttribute__($value)
	{
		return $this->model->whereHas('branch_office', function ($query) use ($value) {
		    $query->where('id', '=', $value);
		});
	}
	
	protected function relationsByProfile()
	{
		return ['profile.group'];
	}

	public function whereProfileId($id)
	{
		$this->model = $this->model->where('profile_id', '=', $id);

		return $this;
	}
}