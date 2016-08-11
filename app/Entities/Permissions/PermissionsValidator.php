<?php
namespace Entities\Permissions;

use Impark\Validator\Validator;

class PermissionsValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'profile_id'       => ['required', 'exists:profiles,id,delete,0'],
		'branch_office_id' => ['required', 'exists:branch_offices,id,delete,0'],
		'user_id'          => ['required', 'exists:users,id,delete,0'],
		'active'           => ['required', 'boolean'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'profile_id'       => ['exists:profiles,id,delete,0'],
		'branch_office_id' => ['exists:branch_offices,id,delete,0'],
		'user_id'          => ['exists:users,id,delete,0'],
		'active'           => ['boolean'],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'                => 'Este campo es requerido',
		'active.boolean'          => 'Debe marcar si el perfil esta activo o no',
		'user_id.exists'          => 'No existe un usuario con ese identificador',
		'profile_id.exists'       => 'No existe un perfil con ese identificador',
		'branch_office_id.exists' => 'No existe un establecimiento con ese identificador',
	];
}