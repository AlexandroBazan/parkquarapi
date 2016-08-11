<?php
namespace Entities\Vehicles;

use Impark\Validator\Validator;

class BrandsValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'name' 	=> [
					'required', 
					'unique:vehicle_brands,name', 
					'regex:/^([a-zñáéíóúÑÁÉÍÓÚ\-]+\s|[a-zñáéíóúÑÁÉÍÓÚ\-]){4,35}+$/i'
				],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'name' 	=> [
					'unique:vehicle_brands,name', 
					'regex:/^([a-zñáéíóúÑÁÉÍÓÚ\-]+\s|[a-zñáéíóúÑÁÉÍÓÚ\-]){4,35}+$/i',
				],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'        => 'Este campo es requerido',
		'name.regex' => 'El nombre de marca solo acepta letras guiones y espacios entre 4 a 35 caracteres',
		'name.unique' => 'El nombre de marca ya esta registrado',
	];
}