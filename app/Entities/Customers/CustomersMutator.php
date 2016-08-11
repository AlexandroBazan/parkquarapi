<?php
namespace Entities\Customers;

use Impark\Mutator\Mutator;
use Entities\Profiles\Models\Profile;
use Entities\Groups\Models\Group;

use Impark\Timestamps\Timestamps;
use Impark\Timestamps\TimestampsModel;

class CustomersMutator extends Mutator
{
	protected $generables = ['person_id'];

	public function getPersonId()
	{
		$id = $this->request->route()[2]['id'];

		return app('db')->table('customers')
					    ->where('id',$id)
					    ->first()
					    ->person_id;
	}

	public function mutInputDni($value)
	{
		if ($this->request->isMethod('put')) {
			app('db')->table('persons')
					 ->where('id', $this->getPersonId())
					 ->update([
					 	'dni' => $value
					 ]);
		}

		return $value;
	}

	public function mutInputLastname($value)
	{
		if ($this->request->isMethod('put')) {
			app('db')->table('persons')
					 ->where('id', $this->getPersonId())
					 ->update([
					 	'lastname' => strtolower($value)
					 ]);
		}

		return strtolower($value);
	}

	public function mutInputFirstname($value)
	{
		if ($this->request->isMethod('put')) {
			app('db')->table('persons')
					 ->where('id', $this->getPersonId())
					 ->update([
					 	'firstname' => strtolower($value)
					 ]);
		}

		return strtolower($value);
	}

	public function mutInputBirthday($value)
	{
		if ($this->request->isMethod('put')) {
			app('db')->table('persons')
					 ->where('id', $this->getPersonId())
					 ->update([
					 	'birthday' => $value
					 ]);
		}

		return $value;
	}

	public function mutInputGender($value)
	{
		if ($this->request->isMethod('put')) {
			app('db')->table('persons')
					 ->where('id', $this->getPersonId())
					 ->update([
					 	'gender' => $value
					 ]);
		}

		return $value;
	}

	public function hasGenPresetInputPerson_id()
	{
		return [
	        'dni',
	        'firstname',
	        'lastname',
	        'gender',
	        'image',
	        'birthday',
	        'timestamps'
		];
	}

	public function genInputPerson_id($inputs)
	{
		$timestamps = (new Timestamps(new TimestampsModel))->create($this->request);

		$personParams = [
			'dni'       => $inputs['dni'],
			'firstname' => $inputs['firstname'],
			'lastname'  => $inputs['lastname'],
			'gender'    => $inputs['gender'],
			'image'     => 'none',
			'birthday'  => $inputs['birthday'],
			'created_id'=> $timestamps,
			'updated_id'=> $timestamps,
			'deleted_id'=> $timestamps,
		];

		$person = app('db')->table('persons')
						   ->insertGetId($personParams);

		var_dump('entro');

		return $person;
	}
}