<?php
namespace Impark\Ent\Traits;

use Illuminate\Http\Request;

trait Editable
{
	/**
	 * Retorna mensajes de error de validacion o de registro,
	 * en no haber error retorna el registro editado.
	 * 
	 * @param  mixin   $id
	 * @param  Request $request
	 * @return Error/register
	 */
	public function edit($id, Request $request)
	{
		if ($this->validator->update($request->except(['timestamps']))) {
			return $this->updateRegister($id, $request);
		} else {
			return $this->getEditMessageError();
		}
	}
}