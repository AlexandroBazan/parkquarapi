<?php

namespace Impark\Error;

use Impark\Constracts\HttpErrorInterface;

class HttpErrorReporter implements HttpErrorInterface
{
	/**
	 * Codigo HTTP del error, solo puede ser 400 o 401
	 * 
	 * @var integer
	 */
	private $httpCode = 400;

	/**
	 * define si se a enviado un error o no, en caso de haber error
	 * cambia el estado a true
	 * 
	 * @var boolean
	 */
	private $state = false;
	
	/**
	 * Contiene el cuerpo del mensaje, solo contiene los atributos
	 * definidos en el arreglo
	 * 
	 * @var array
	 */
	private $response = [
		'message'                => '',
		'code'                   => '',
		'type'                   => '',
		'user_error_title'       => '',
		'user_error_description' => ''
	];

	/**
	 * verifica que no haya algun error con las key del arreglo enviado
	 * 
	 * @param  array  $message
	 * @return void
	 */
	private function checkKey(array $message)
	{
		if (count($this->response) < count($message)) {
			throw new \Exception("El arreglo contiene propiedades no soportadas por ErrorReporter::send()", 1);
		}

		if (count($this->response) > count($message)) {
			throw new \Exception("El arreglo no tiene todas las propiedades soportadas por ErrorReporter::send()", 1);
		}

		foreach ($message as $key => $value) {
			if (!array_key_exists($key, $this->response)) {
				throw new \Exception("La propiedad '{$key}' no es soportada en el metodo ErrorReporter::send()", 1);
			}
		}
	}

	/**
	 * verifica que no hayan errores de formato en el arreglo enviado
	 * 
	 * @param  array  $message
	 * @return void
	 */
	private function checkFormat(array $message)
	{
		$this->checkKey($message);
		
		if (!is_string($message['message'])) {
			throw new \Exception("La propiedad 'message' solo acepta tipo String y no el tipo " . gettype($message['message']), 1);
		}

		if (!is_int($message['code'])) {
			throw new \Exception("La propiedad 'code' solo acepta tipo Integer y no del tipo " . gettype($message['code']), 1);
		}

		if (!is_string($message['type'])) {
			throw new \Exception("La propiedad 'type' solo acepta tipo String y no el tipo " . gettype($message['type']), 1);
		}

		if (!is_string($message['user_error_title'])) {
			throw new \Exception("La propiedad 'user_error_title' solo acepta tipo String y no del tipo " . gettype($message['user_error_title']), 1);
		}

		if (!is_string($message['user_error_description']) && !is_array($message['user_error_description'])) {
			throw new \Exception("La propiedad 'user_error_description' solo acepta tipo String o Array y no del tipo " . gettype($message['user_error_description']), 1);
		}
	}

	/**
	 * verifica que el codigo de error enviado sea un codigo Http valido
	 * 
	 * @param  integer $code
	 * @return void
	 */
	private function checkHttpCode($code)
	{
		if ($code != 400 && $code != 401) {
			throw new \Exception("Solo se aceptan los codigos http 400 y 401 en el metodo ErrorReporter::send()", 1);
		}
	}

	/**
	 * crea un error y da formato al cuerpo y codigo http del error
	 * 
	 * @param  array   $message
	 * @param  integer $code
	 * @return void
	 */
	public function send(array $message, $code = 400)
	{
		$this->checkFormat($message);
		$this->checkHttpCode($code);

		$this->response = $message;
		$this->httpCode = $code;
		$this->state = true;
	}

	/**
	 * retorna true si existe algun error enviado
	 * 
	 * @return boolean
	 */
	public function has()
	{
		return $this->state;
	}

	/**
	 * retorna el el cuerpo del error
	 * 
	 * @return response/array
	 */
	public function response()
	{
		return $this->response;
	}

	/**
	 * Retorna el codigo HTTP del error
	 * 
	 * @return HttpCode/int
	 */
	public function httpCode()
	{
		return $this->httpCode;
	}

}