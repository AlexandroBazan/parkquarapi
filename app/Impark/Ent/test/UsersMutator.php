<?php 
namespace Impark\Ent\test;

use Impark\Mutator\Mutator;
use Impark\Timestamps\Timestamps;
use Impark\Timestamps\TimestampsModel;

class UsersMutator extends Mutator
{
	protected $generables = ['person_id'];

	public function mutInputPassword($value)
	{
		return app('hash')->make($value);
	}

	public function getUserId()
	{
		$id = $this->request->route()[2]['id'];

		return app('db')->table('users')
					    ->where('username',$id)
					    ->first()
					    ->person_id;
	}

	public function mutInputDni($value)
	{
		if (isset($this->request->route()[2]['id'])) {
			app('db')->table('persons')
					 ->where('id', $this->getUserId())
					 ->update([
					 	'dni' => $value
					 ]);
		}

		return $value;
	}

	public function mutInputLastname($value)
	{
		if (isset($this->request->route()[2]['id'])) {
			app('db')->table('persons')
					 ->where('id', $this->getUserId())
					 ->update([
					 	'lastname' => $value
					 ]);
		}

		return $value;
	}

	public function mutInputFirstname($value)
	{
		if (isset($this->request->route()[2]['id'])) {
			app('db')->table('persons')
					 ->where('id', $this->getUserId())
					 ->update([
					 	'firstname' => $value
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
			'emails',
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

		return $person;
	}
}