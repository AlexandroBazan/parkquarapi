<?php
namespace Impark\Ent\Traits;

use Illuminate\Http\Request;

trait Removable
{
	/**
	 * Elimina simbolicamente un registro de la tabla principal de
	 * la entidad.
	 *
	 * @param  mixin   $id
	 * @param  Request $request
	 * @return Error/null
	 */
	public function remove($id, Request $request)
	{
		$register = $this->findNativeModel($id);

		if (is_null($register)) {
			return $this->getRemoveMessageError($id);
		} else {
			$this->deleteRegister($register, $request);

			return null;
		}
	}
}