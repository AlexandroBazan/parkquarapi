<?php
namespace Entities\Accesses;

use Impark\Validator\Validator;

class AccessesValidator extends Validator
{
	/**
	 * reglas de creacion
	 * 
	 * @var array
	 */
	protected $createRuls = [
		'route_id'   => ['required', 'exists:routes,id,delete,0'],
		'profile_id' => ['required', 'exists:profiles,id,delete,0'],
		'active'     => ['required', 'boolean'],
	];

	/**
	 * Reglas de edicion
	 * 
	 * @var array
	 */
	protected $updateRuls = [
		'route_id'   => ['exists:routes,id,delete,0'],
		'profile_id' => ['exists:profiles,id,delete,0'],
		'active'     => ['boolean'],
	];

	/**
	 * Mensajes de error personalizados
	 * 
	 * @var array
	 */
	protected $messages = [
		'required'          => 'Este campo es requerido',
		'active.boolean'    => 'Debe marcar si el acceso estara activo o no ',
		'profile_id.exists' => 'El perfil no es valido o no existe',
		'route_id.exists'   => 'La ruta no es valida o no existe',
	];
}