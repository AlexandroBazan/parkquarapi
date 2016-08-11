<?php
namespace Impark\Timestamps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Impark\Constracts\TimestampInterface;

class Timestamps implements TimestampInterface
{	
	/**
	 * Contenedor del modelo Timestamp
	 * 
	 * @var Model
	 */
	private $model;

	/**
	 * Setea el modelo en el evento de creacion del objeto
	 * 
	 * @param  Model $model
	 * @return void
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * Guarda los datos del timestamp con la ayuda del modelo
	 * este metodo es para grabar el guardado de un registro
	 *
	 * @see    Model::create()
	 * @param  Request $request
	 * @return integer
	 */
	public function create(Request $request)
	{
		return $this->model->create([
				'user_id' => $request->input('timestamps.user'),
				'app_id'  => $request->input('timestamps.app'),
				'time'    => Carbon::now(),
				'type'	  => 'create',
				'ip'      => $request->input('timestamps.ip'),
			])->id;
	}

	/**
	 * Guarda los datos del timestamp con la ayuda del modelo
	 * este metodo es para grabar la edicion de un registro
	 * 
	 * @see    Model::create()
	 * @param  Request $request
	 * @return integer
	 */
	public function update(Request $request)
	{
		return $this->model->create([
				'user_id' => $request->input('timestamps.user'),
				'app_id'  => $request->input('timestamps.app'),
				'time'    => Carbon::now(),
				'type'	  => 'update',
				'ip'      => $request->input('timestamps.ip'),
			])->id;
	}

	/**
	 * Guarda los datos del timestamp con la ayuda del modelo
	 * este metodo es para grabar la eliminacion de un registro
	 * 
	 * @see    Model::create()
	 * @param  Request $request
	 * @return integer
	 */
	public function delete(Request $request)
	{
		return $this->model->create([
				'user_id' => $request->input('timestamps.user'),
				'app_id'  => $request->input('timestamps.app'),
				'time'    => Carbon::now(),
				'type'	  => 'delete',
				'ip'      => $request->input('timestamps.ip'),
			])->id;
	}
}