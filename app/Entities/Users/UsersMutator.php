<?php
namespace Entities\Users;

use Impark\Mutator\Mutator;
use Entities\Profiles\Models\Profile;
use Entities\Groups\Models\Group;

use Impark\Timestamps\Timestamps;
use Impark\Timestamps\TimestampsModel;

class UsersMutator extends Mutator
{
	protected $generables = ['person_id'];

	public function getPersonId()
	{
		$id = $this->request->route()[2]['id'];

		return app('db')->table('users')
					    ->where('id',$id)
					    ->first()
					    ->person_id;
	}

	public function mutInputPassword($value)
	{
		return app('hash')->make($value);
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
	        //'image',//por que lo coge como request->file('image')
	        'birthday',
	        'timestamps',
	        'emails'
		];
	}

	public function genInputPerson_id($inputs)
	{
		$timestamps = (new Timestamps(new TimestampsModel))->create($this->request);
		//var_dump($inputs);
		$personParams = [
			'dni'       => $inputs['dni'],
			'firstname' => $inputs['firstname'],
			'lastname'  => $inputs['lastname'],
			'gender'    => $inputs['gender'],
			'image'     => md5($inputs['dni']).'.png',
			'birthday'  => $inputs['birthday'],
			'created_id'=> $timestamps,
			'updated_id'=> $timestamps,
			'deleted_id'=> $timestamps,
		];

		//app('storage')->disk('local')->put(, );

		$personId = app('db')->table('persons')
						   ->insertGetId($personParams);

		$this->saveEmail($inputs['emails'], $personId, $timestamps);

		return $personId;
	}

	private function saveEmail(array $emails, $personId, $timestamps)
	{
		//var_dump($emails);
		foreach ($emails as $key => $value) {
			$raw = $value;
			$edit = explode('@', $value);

			app('db')->table('emails')
					 ->insert([
					 		'person_id'  => $personId,
					 		'description'=> $raw,
					 		'username'   => $edit[0],
					 		'domain'     => $edit[1],
					 		'created_id' => $timestamps,
							'updated_id' => $timestamps,
							'deleted_id' => $timestamps,
					 	]);
		}
	}
}