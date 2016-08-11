<?php
namespace Entities\BranchOffices;

use Impark\Validator\Validator;

class BranchOfficesValidator extends Validator
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
					'unique:brach_offices,name'
				],
		
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'name'    => [
					'regex:/^([a-zñáéíóúÑÁÉÍÓÚ]+\s|[a-zñáéíóúÑÁÉÍÓÚ]){4,35}+$/i', 
					'unique:brach_offices,name'
				],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'        => 'Este campo es requerido',
		'name.regex'      => 'solo acepta entre 4 a 35 caracteres entre espacios y letras',
		'name.unique'     => 'El nombre del establecimiento ya ha sido registrado anteriormente y no se puede repetir',
	];
}