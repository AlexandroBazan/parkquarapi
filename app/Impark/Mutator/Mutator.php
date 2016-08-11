<?php 
namespace Impark\Mutator;

use Illuminate\Http\Request;

use Impark\Constracts\MutatorInterface;

abstract class Mutator implements MutatorInterface
{
	/**
	 * almacena el objeto request para su posterior utilizacion
	 * 
	 * @var Request
	 */
	protected $request;
	
	/**
	 * Determina que campos existentes se van a modificar
	 * 	
	 * @var array
	 */
	protected $mutables = [];

	/**
	 * Determina que campos se van a generar a partir de otros
	 * 
	 * @var array
	 */
	protected $generables = [];

	/**
	 * Automatiza la generacion y mutacion de inputs
	 * 
	 * @param  Request $request 
	 * @return void
	 */
	public function make(Request &$request)
	{
		$this->request = $request;
		$this->mutating();
		$this->generate();
	}

	/**
	 * Genera automutadores a partir del objeto Request
	 *
	 * @see  	Request::except()
	 * @return  void
	 */
	final protected function autoMutable()
	{
		if (count($this->mutables) == 0) {
			$this->mutables = array_keys($this->request->except(['timestamps']));
		}
	}

	/**
	 * Ejecuta automaticamente los metodos mutadores de las clases hijas
	 *
	 * @return  void
	 */
	final protected function mutating()
	{
		$this->autoMutable();

		foreach ($this->mutables as $key => $value) {

			if ($this->request->has($value)) {
				$this->runMutableMethod($value);
			}
		}
	}

	/**
	 * Ejecuta metodos mutables en el caso existiersen.
	 *
	 * @example Mutator::mutInputAttribute();
	 * @see     Request::input()
	 * @param   string $key 
	 * @return  void
	 */
	final protected function runMutableMethod($key)
	{
		$method = 'mutInput'.ucwords($key);

		if (method_exists($this, $method)) {
			$this->request->merge([
					$key => $this->{$method}($this->request->input($key))
				]);
		}
	}

	/**
	 * Ejecuta automaticamente los metodos generadores de las clases hijas.
	 *
	 * @return void
	 */
	final protected function generate()
	{
		foreach ($this->generables as $key => $value) {
			if (!$this->request->has($value)) {

				$this->runGenerableMethod($value);
			}
		}
	}

	/**
	 * Ejecuta metodos generables en el caso existiesen y
	 * setea el parametro artificial en el objeto request.
	 *
	 * @example Mutator::genInputAttribute();
	 * @see     Request::merge()
	 * @see     Request::except()
	 * @param   string $key
	 * @return  void
	 */
	final protected function runGenerableMethod($key)
	{
		$method = 'genInput'.ucwords($key);

		//var_dump($this->hasPresetGenerableMethod($key));

		if (method_exists($this, $method) && $this->hasPresetGenerableMethod($key)) {
			$this->request->merge([
				$key => $this->{$method}($this->request->all())
			]);
		}
	}

	/**
	 * Metodo para verificar si los parametros dependientes
	 * de este parametro artificial han sido enviados.
	 *
	 * @example Mutator::hasGenPresetInputAttribute()
	 * @see     Request::has()
	 * @param   string  $key
	 * @return  boolean
	 */
	final protected function hasPresetGenerableMethod($key)
	{
		$hasMethod = 'hasGenPresetInput'.ucwords($key);

		$method = $this->{$hasMethod}();

		if (method_exists($this, $hasMethod) && is_array($method)) {
			
			foreach ($method as $key => $value) {
				if (!$this->request->has($value)) {
		//var_dump($this->request->input($value));
		//var_dump($method);
					return false;
				}
			}
			
			return true;
		}

		return false;
	}
}