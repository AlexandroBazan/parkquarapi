<?php
namespace Entities\Users;

use Impark\Filter\Filter;

class UsersFilter extends Filter
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

	protected function relationsByPermissions()
	{
		return ['permissions.profile','permissions.profile.group','permissions.branch_office'];
	}
}