<?php
namespace Entities\Accesses;

use Impark\Filter\Filter;

class AccessesFilter extends Filter
{
	protected $except = [
		'route.app'
	];
	
	protected function relationsByProfile()
	{
		return ['profile.group'];
	}

	protected function relationsByRoute()
	{
		return ['route.app'];
	}

	public function whereProfileId($id)
	{
		$this->model = $this->model->where('profile_id', '=', $id);

		return $this;
	}
}