<?php
namespace Impark\Validator;

use Illuminate\Validation\Factory as NativeValidator;
use Impark\Constracts\ValidatorInterface;

abstract class Validator implements ValidatorInterface
{
	/**
	 * Contenedor del validador nativo de laravel.
	 * 
	 * @var Validator
	 */
	protected $validator;

	/**
	 * Arreglo de errores lanzados por el validador.
	 * 
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Arreglo que define los mensajes que se mostraran
	 * al usuario dependiendo del campo y tipo de error.
	 * 
	 * @var array
	 */
	protected $messages;

	/**
	 * Asignacion del objeto Validator a su contenedor.
	 * 
	 * @param  NativeValidator $validator
	 * @return void
	 */
	public function __construct(NativeValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Metodo para aplicar una validacion, este metodo setea
	 * los mensajes de error en caso de haberlos y retorna
	 * true si no hay problemas de validacion, en caso contrario
	 * retorna false.
	 *
	 * @see    Validator::make()
	 * @see    Validator::errors()
	 * @see    Validator::fails()
	 * @param  array  $input
	 * @param  array  $ruls
	 * @param  array  $messages
	 * @return boolean
	 */
	protected function make(array $input, array $ruls, array $messages)
	{
		$validator = $this->validator->make($input, $ruls, $messages);
		
		$this->errors = $validator->errors();

		return !$validator->fails();
	}

	/**
	 * Validador para las reglas de creacion de una
	 * entidad.
	 * 
	 * @param  array  $input
	 * @return boolean
	 */
	public function create(array $input)
	{
		return $this->make($input, $this->createRuls, $this->messages);
	}

	/**
	 * Validador para las reglas de edicion de una
	 * entidad.
	 * 
	 * @param  array  $input
	 * @return boolean
	 */
	public function update(array $input)
	{
		return $this->make($input, $this->updateRuls, $this->messages);
	}

	/**
	 * Metodo que retorna los mensajes de error del validador
	 * 
	 * @return array
	 */
	public function errors()
	{
		return $this->errors->toArray();
	}
}