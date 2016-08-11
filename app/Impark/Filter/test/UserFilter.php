<?php 
namespace Impark\Filter\test;

use Impark\Filter\Filter;

class UserFilter extends Filter
{
	protected function joins()
	{
		return $this->model->join('persons', 'users.person_id', '=', 'persons.id')
					->select('users.*', 
						'persons.dni', 
						'persons.firstname', 
						'persons.lastname', 
						'persons.gender', 
						'persons.image', 
						'persons.birthday'
					);
	}

	protected function filProfileAttribute($value)
	{
		return $this->model->whereHas('permissions', function ($query) use ($value) {
		    $query->where('profile_id', '=', $value);
		});
	}

	protected function relationsByPermissions()
	{
		return ['permissions.profile', 'permissions.branchOffice'];
	}

	protected function relationsByPhones()
	{
		return ['phones.type'];
	}

	public function getModel()
	{
		return $this->model;
	}

	public function getTable()
	{
		return $this->table;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getRelations()
	{
		return $this->relations;
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function getHidden()
	{
		return $this->hidden;
	}
}