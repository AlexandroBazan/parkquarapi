<?php
namespace Entities\Profiles;

use Impark\Validator\Validator;

class ProfilesValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'name'     => ['required', 'regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){4,35}+$/i'],
		'group_id' => ['required', 'exists:groups,id,delete,0'],
		'active'   => ['required', 'boolean'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'name'     => ['regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){4,35}+$/i'],
		'group_id' => ['exists:groups,id,delete,0'],
		'active'   => ['boolean'],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'        => 'Este campo es requerido',
		'name.regex'      => 'solo acepta entre 4 a 35 caracteres entre espacios y letras',
		'active.boolean'  => 'Debe marcar si el perfil esta activo o no',
		'group_id.exists' => 'No existe un grupo con ese identificador',
	];
}