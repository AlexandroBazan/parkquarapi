<?php
namespace Impark\Ent\Traits;

use Illuminate\Http\Request;

trait Insertable
{
	/**
	 * Crea un nuevo registro en el caos se cumplan las
	 * reglas de validacion correspondientes, en caso contrario
	 * envia el mensaje de error correspondiente.
	 *
	 * @see    Validator::create()
	 * @param  Request $request
	 * @return register/Error
	 */
	public function insert(Request $request)
	{
		if ($this->validator->create($request->except(['timestamps']))) {
			return $this->createRegister($request);
		} else {
			return $this->getInsertMessageError();
		}
	}
}