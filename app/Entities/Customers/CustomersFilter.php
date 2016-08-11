<?php
namespace Entities\Customers;

use Impark\Filter\Filter;

class CustomersFilter extends Filter
{
	protected function joins()
	{
		return $this->model->join('persons', 'customers.person_id', '=', 'persons.id')
					->select('customers.*', 
						'persons.dni', 
						'persons.firstname', 
						'persons.lastname', 
						'persons.gender', 
						'persons.image', 
						'persons.birthday'
					);
	}
}