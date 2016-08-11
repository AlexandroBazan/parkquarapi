<?php
namespace Entities\Routes;

use Impark\Validator\Validator;

class RoutesValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'description'   => ['required', 'regex:/^([a-z]+\:\:|[a-z]){4,200}+$/i'],
		'app_id'  		=> ['required', 'exists:apps,id'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'description'   => ['regex:/^([a-z]+\:\:|[a-z]){4,200}+$/i'],
		'app_id'  		=> ['exists:apps,id'],

	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'          => 'Este campo es requerido',
		'description.regex' => 'Solo acepta entre 4 a 200 caracteres entre letras y "::" ',
		'app_id.exists'     => 'La aplicacion enviada no es valida o no existe',
	];
}