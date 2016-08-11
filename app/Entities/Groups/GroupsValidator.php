<?php
namespace Entities\Groups;

use Impark\Validator\Validator;

class GroupsValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'name'    => [
					'required',
					'regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){4,35}+$/i', 
					'unique:groups,name'
				],
		'active'  => ['required', 'boolean'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'name'    => [
					'regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){4,35}+$/i', 
					'unique:groups,name'
				],
		'active'  => ['boolean'],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'        => 'Este campo es requerido',
		'name.regex'      => 'solo acepta entre 4 a 35 caracteres entre espacios y letras',
		'name.unique'     => 'El nombre de grupo ya ha sido registrado anteriormente y no se puede repetir',
		'active.boolean'  => 'Debe marcar si el grupo esta activo o no',
	];
}