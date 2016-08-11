<?php
namespace Impark\Ent;

use Impark\Ent\Model;
use Impark\Filter\Filter;
use Impark\Validator\Validator;
use Impark\Mutator\Mutator;
use Impark\Timestamps\Timestamps;
use Impark\Error\HttpErrorReporter;
use Illuminate\Http\Request;

use Impark\Constracts\EntityInterface;

abstract class Entity implements EntityInterface
{
	/**
	 * Contenedor del modelo.
	 * 
	 * @var Impark\Ent\Model
	 */
	protected $model;

	/**
	 * Contenedor del filtro.
	 * 
	 * @var Filter
	 */
	protected $filter;

	/**
	 * Contenedor dle validador.
	 * 
	 * @var Impark\Validator\Validator
	 */
	protected $validator;

	/**
	 * Contenedor del mutador.
	 * 
	 * @var Impark\Mutator\Mutator
	 */
	protected $mutator;

	/**
	 * Contenedor del manejador de errores.
	 * 
	 * @var Impark\Error\HttpErrorReporter
	 */
	protected $error;

	/**
	 * Contenedor del timestamps
	 * 
	 * @var Impark\Timestamps\Timestamps
	 */
	protected $timestamps;

	/**
	 * Arreglo de los atributos que pueden ser editables.
	 * 
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Listado de las relaciones que se activan por defecto.
	 * 
	 * @var array
	 */
	protected $relations = [];

	/**
	 * Arreglo de los campos que van ha estar ocultos
	 * 
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Atributo por el cual se haran las busquedas de un unico registro-
	 * 
	 * @var string
	 */
	protected $findKey = 'id';

	/**
	 * Estado de la peticion.
	 * 
	 * @var integer
	 */
	protected $status = 200;

	/**
	 * Mensaje de error cuando no se encuentra un registro
	 * de la entidad para mostrar.
	 * 
	 * @var string
	 */
	protected $messageOneError = 'No se han encontrado registros';

	/**
	 * Mensaje de error cuando no se encuentra un registro
	 * de la entidad eliminar.
	 * 
	 * @var string
	 */
	protected $messageRemoveError = 'El registro que quiere eliminar no existe o ya fue eliminado';

	/**
	 * Mensaje de error cuando no se encuentra un registro
	 * de la entidad eliminar.
	 * 
	 * @var string
	 */
	protected $messageEditError = 'El registro que quiere editar no existe o ya fue eliminado';

	/**
	 * archivos que se pueden editar para el modelo principal
	 * 
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * Seteador de dependencias de la clase.
	 * 
	 * @param  Model             $model
	 * @param  Filter            $filter
	 * @param  Validator         $validator
	 * @param  Mutator           $mutator
	 * @param  Timestamps        $timestamps
	 * @param  HttpErrorReporter $error
	 * @return void
	 */
	public function __construct(
		Model $model, 
		Filter $filter, 
		Validator $validator, 
		Mutator $mutator, 
		Timestamps $timestamps,
		HttpErrorReporter $error 
	) {
		$this->model      = $model;
		$this->filter     = $filter;
		$this->validator  = $validator;
		$this->mutator    = $mutator;
		$this->timestamps = $timestamps;
		$this->error      = $error;
	}

	/**
	 * Retorna el estado http de la peticion.
	 * 
	 * @return int
	 */
	public function status()
	{
		return $this->status;
	}

	/**
	 * Retorna el registro que se quiere encontrar o el
	 * mensaje de error correspondiente
	 *
	 * @param  mixin $id
	 * @return Model/Error
	 */
	public function one($id, Request $request)
	{
		$find = $this->find($id, $request);

		if (is_null($find)) {
			return $this->getOneMessageError($id);
		} else {
			return $find;
		}
	}

	/**
	 * Genera el estatus y retorna el cuerpo del mensaje
	 * de error.
	 * 
	 * @see    HttpErrorReporter::send()
	 * @see    HttpErrorReporter::httpCode()
	 * @see    HttpErrorReporter::response()
	 * @param  mixin  $id
	 * @return HttpErrorReporter::response()
	 */
	final protected function getOneMessageError($id)
	{
		$this->error->send([
	        'message'                => 'no se ha encontrado un registro activo con el identificador '.$id,
	        'code'                   => 101,
	        'type'                   => 'OneError',
	        'user_error_title'       => 'No hay registros',
	        'user_error_description' => $this->messageOneError,
	    ]);

	    $this->status = $this->error->httpCode();
			
		return $this->error->response();
	}

	/**
	 * Retorna solo un registro del identificador enviado
	 * dependiendo del tipo de identificador seteado por
	 * la propiedad $this->findKey.
	 *
	 * @see    Filter::dependencies()
	 * @see    Filter::relations()
	 * @see    Filter::hidden()
	 * @see    Filter::find()
	 * @param  string  $id
	 * @param  Request $request
	 * @return Model
	 */
	final protected function find($id, Request $request)
	{
		return $this->filter
					->dependencies($this->model, $request)
					->relations($this->relations)
					->hidden($this->hidden)
					->find($id, $this->findKey);
	}

	/**
	 * Retorna y serializa una coleccion de registros de la
	 * entidad solicitada y aplica automaticamente los filtros
	 * predeterminados para las entidades.
	 *
	 * @see    Model::count()
	 * @see    Request::fullUrl()
	 * @param  Request $request
	 * @return Model
	 */
	public function collection(Request $request)
	{
		$count  = $this->filter->dependencies($this->model, $request)->count();
		
		$items  = $this->all($request);

		return $this->prepareCollectionResponse($request, $items, $count);
	}

	final protected function prepareCollectionResponse(Request $request, $items, $count)
	{
		$limit  = intval($request->input('limit', 100));
		
		$offset = intval($request->input('offset', 0));
		
		$last   = $this->lastOffset($count, $limit);

		return [
			'link'     => $request->fullUrl(),
			'items'    => $items,
			'limit'    => $limit,
			'total'    => $items->count(),
			'offset'   => $offset,
			'first'    => $this->first($request, $limit),
			'next'     => $this->next($request, $last, $offset, $limit, $items->count()),
			'previous' => $this->previous($request, $last, $offset, $limit),
			'last'     => $this->last($request, $last, $offset, $limit, $items->count())
		];
	}

	/**
	 * Retorna el link con los filtros de paginacion para
	 * la primera pagina de la coleccion en caso que el
	 * total de registros sobrepase el limite establecido.
	 *
	 * @see    Request::input()
	 * @see    Request::fullUrlWithQuery()
	 * @param  Request $request
	 * @param  int     $limit
	 * @return Url/null
	 */
	final protected function first(Request $request, $limit)
	{
		if ($request->input('offset') > 0) {
			return $request->fullUrlWithQuery(['offset' => 0, 'limit' => $limit]);
		}

		return null;
	}

	/**
	 * Retorna el link con los filtros de paginacion para
	 * la ultima pagina de la coleccion en caso que el
	 * total de registros sobrepase el limite establecido.
	 * 
	 * @see    Request::fullUrlWithQuery()
	 * @param  Request $request
	 * @param  int     $last  
	 * @param  int     $offset
	 * @param  int     $limit 
	 * @param  int     $count 
	 * @return Url/null
	 */
	final protected function last(Request $request, $last, $offset, $limit, $count)
	{
		if ($last == $offset || $count != $limit) {
			return null;
		}

		return $request->fullUrlWithQuery(['offset' => $last, 'limit' => $limit]);
	}

	/**
	 * Calcula y retorna el offset para la ultima paginacion.
	 * 
	 * @param  int $count
	 * @param  int $limit
	 * @return int
	 */
	final protected function lastOffset($count, $limit)
	{
		$offset = intval($count/$limit) * $limit;

		$offset += ($count%$limit > 0) ? 0 : - $limit;

		return $offset;
	}

	/**
	 * Retorna el link con los filtros de paginacion para
	 * la siguiente pagina de la coleccion en caso que el
	 * total de registros sobrepase el limite establecido.
	 * 
	 * @see    Request::fullUrlWithQuery()
	 * @param  Request  $request
	 * @param  int      $last
	 * @param  int      $offset
	 * @param  int      $limit
	 * @param  int      $count
	 * @return Url/null
	 */
	final protected function next(Request $request, $last, $offset, $limit, $count)
	{
		if ($offset < $last && $count == $limit) {
			return $request->fullUrlWithQuery(['offset' => $offset+$limit, 'limit' => $limit]);
		}

		return null;
	}

	/**
	 * Retorna el link con los filtros de paginacion para
	 * la pagina anterior de la coleccion en caso que el
	 * total de registros sobrepase el limite establecido.
	 * 
	 * @see    Request::fullUrlWithQuery()
	 * @param  Request $request
	 * @param  int     $last
	 * @param  int     $offset
	 * @param  int     $limit
	 * @return Url/null
	 */
	final protected function previous(Request $request, $last, $offset, $limit)
	{
		if ($offset <= $last && $offset > 0) {
			return $request->fullUrlWithQuery(['offset' => $offset-$limit, 'limit' => $limit]);
		}

		return null;
	}

	/**
	 * Retorna la coleccion de los registros de la entidad.
	 * 
	 * @see    Filter::dependencies()
	 * @see    Filter::attributes()
	 * @see    Filter::relations()
	 * @see    Filter::hidden()
	 * @see    Filter::all()
	 * @param  Request $request
	 * @return Model
	 */
	final protected function all(Request $request)
	{
		return $this->filter
					->dependencies($this->model, $request)
					->attributes($this->attributes)
					->relations($this->relations)
					->hidden($this->hidden)
					->all();
	}

	

	/**
	 * Genera el estatus y retorna el cuerpo del mensaje
	 * de error.
	 * 
	 * @see    HttpErrorReporter::send()
	 * @see    HttpErrorReporter::httpCode()
	 * @see    HttpErrorReporter::response()
	 * @return HttpErrorReporter::response()
	 */
	final protected function getInsertMessageError()
	{
		$this->error->send([
	        'message'                => 'Hay errores en las reglas de validacion',
	        'code'                   => 103,
	        'type'                   => 'ValidatorError',
	        'user_error_title'       => 'Error de validacion',
	        'user_error_description' => $this->validator->errors(),
	    ]);

	    $this->status = $this->error->httpCode();
			
		return $this->error->response();
	}

	/**
	 * Crea el nuevo registro, setea el status y retorna el
	 * registro creado.
	 * 
	 * @param  Request $request
	 * @return register
	 */
	protected function createRegister(Request $request)
	{
		$this->mutator->make($request);
		//var_dump($request->file('image'));

		$this->status = 201;

		$id = $this->model
				   ->create($this->prepareAttributes($request, $this->createTimestamps($request)))
				   ->{$this->findKey};	
		return $this->one($id, $request);
	}

	/**
	 * Retorna los atributos que se van a guardar en el modelo
	 * principal.
	 *
	 * @param  Request $request
	 * @return input
	 */
	protected function prepareAttributes(Request $request, $preset)
	{
		$input = (count($this->fillable) > 0) 
			   ? array_diff($request->only($this->fillable), [null]) 
			   : $request->except(['timestamps']);

		return array_merge($input, $preset);
	}

	/**
	 * Crea y retorna los Timestamps requeridos para la
	 * creacion del registro.
	 * 
	 * @param  Request $request
	 * @return Timestamps
	 */
	protected function createTimestamps(Request $request)
	{
		$timestamps = $this->timestamps->create($request);

		return [
			'created_id' => $timestamps, 
			'updated_id' => $timestamps, 
			'deleted_id' => $timestamps
		];
	}

	/**
	 * Genera el estatus de error y retorna el cuerpo del mensaje
	 * de error.
	 * 
	 * @see    HttpErrorReporter::send()
	 * @see    HttpErrorReporter::httpCode()
	 * @see    HttpErrorReporter::response()
	 * @return HttpErrorReporter::response()
	 */
	final protected function getEditMessageError()
	{
		$this->error->send([
	        'message'                => 'Hay errores en las reglas de validacion',
	        'code'                   => 104,
	        'type'                   => 'ValidatorError',
	        'user_error_title'       => 'Error de validacion',
	        'user_error_description' => $this->validator->errors(),
	    ]);

	    $this->status = $this->error->httpCode();
			
		return $this->error->response();
	}

	/**
	 * Genera el estatus de error y retorna el cuerpo del mensaje
	 * de error.
	 * 
	 * @see    HttpErrorReporter::send()
	 * @see    HttpErrorReporter::httpCode()
	 * @see    HttpErrorReporter::response()
	 * @param  mixin  $id
	 * @return HttpErrorReporter::response()
	 */
	final protected function getEditIdMessageError($id)
	{
		$this->error->send([
	        'message'                => "No se encuentra el registor con el identificador {$id} que se quiere editar",
	        'code'                   => 105,
	        'type'                   => 'EditError',
	        'user_error_title'       => 'No hay registro',
	        'user_error_description' => $this->messageEditError,
	    ]);

	    $this->status = $this->error->httpCode();
			
		return $this->error->response();
	}

	/**
	 * Edita un registro y lo retorna un registro, si este no
	 * se encuentra por el $id correspondiente retorna un
	 * mensaje de error.
	 * 
	 * @param  mixin   $id
	 * @param  Request $request
	 * @return Error/register
	 */
	protected function updateRegister($id, Request $request)
	{
		$this->mutator->make($request);

		$register = $this->findNativeModel($id);

		if (is_null($register)) {
			return $this->getEditIdMessageError($id);
		} else {
			$this->saveUpdateRegister($register, $request);

			return $this->one($register->{$this->findKey}, $request);
		}
	}

	/**
	 * Edita y guarda los atributos del registro.
	 * 
	 * @param  register  $register
	 * @param  Request   $request
	 * @return void
	 */
	protected function saveUpdateRegister($register, Request $request)
	{
		foreach ($this->prepareAttributes($request, $this->updateTimestamps($request)) as $key => $value) {
			$register->{$key} = $value;
		}

		$register->save();
	}

	/**
	 * Crea y retorna los Timestamps requeridos para la
	 * edicion del registro.
	 * 
	 * @param  Request $request
	 * @return Timestamps
	 */
	protected function updateTimestamps(Request $request)
	{
		$timestamps = $this->timestamps->update($request);

		return [ 
			'updated_id' => $timestamps,
		];
	}

	/**
	 * Genera el estatus de error y retorna el cuerpo del mensaje
	 * de error.
	 * 
	 * @see    HttpErrorReporter::send()
	 * @see    HttpErrorReporter::httpCode()
	 * @see    HttpErrorReporter::response()
	 * @param  mixin  $id
	 * @return HttpErrorReporter::response()
	 */
	final protected function getRemoveMessageError($id)
	{
		$this->error->send([
	        'message'                => "El registro con el identificador {$id} no existe o ya se elimino",
	        'code'                   => 102,
	        'type'                   => 'RemoveError',
	        'user_error_title'       => 'No hay registros',
	        'user_error_description' => $this->messageRemoveError,
	    ]);

	    $this->status = $this->error->httpCode();
			
		return $this->error->response();
	}

	/**
	 * Cambia los datos de estado y timestamps de eliminacion
	 * de un registro.
	 * 
	 * @param  register $register
	 * @param  Request  $request
	 * @return void
	 */
	protected function deleteRegister($register, Request $request)
	{
		$register->delete     = 1;
		$register->deleted_id = $this->timestamps->delete($request);
		$register->save();
	}

	/**
	 * Retorna un registro solicitado desde el modelo sin alterar,
	 * la busqueda la hace por el atributo predefinido en $findKey
	 * 
	 * @param  mixin   $id
	 * @param  integer $delete
	 * @return register
	 */
	final protected function findNativeModel($id, $delete = 0)
	{
		return $this->model
					->where('delete', '=', $delete)
					->where($this->findKey,'=',$id)
					->first();
	}
}