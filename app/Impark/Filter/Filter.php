<?php

namespace Impark\Filter;

use Impark\Constracts\FilterInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


abstract class Filter implements FilterInterface
{
	/**
	 * Contenedor del modelo.
	 * 
	 * @var Model
	 */
	protected $model;

	/**
	 * Contenedor del objeto request.
	 * 
	 * @var Request
	 */
	protected $request;

	/**
	 * Nombre de la tabla principal de la entidad.
	 * 
	 * @var string
	 */
	protected $table;

	protected $deleteMode = true;

	/**
	 * Atributos que estaran ocultos por defecto.
	 * 
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Listado de los atributos que se tendran en cuenta para
	 * el fintrado.
	 * 
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Lista de relaciones de laravel que se activaran gracias
	 * al metodo nativo Model::with([]) de laravel.
	 *
	 * @see Model::with()
	 * @var array
	 */
	protected $relations = [];

	/**
	 * Campos que se mostraran solo si el filtro fields esta activado.
	 * 
	 * @var array
	 */
	protected $fields = [];

	protected $except = [];

	/**
	 * Asigna el modelo y Request, tambien setea el nombre de la tabla principal y 
	 * genera un atributo GET artificail para su uso en la extension del 
	 * modelo modificado de laravel Impark\Ent\Model.
	 *
	 * @see Request::merge()
	 * @param Model   $model
	 * @param Request $request
	 * @return Filter
	 */
	public function dependencies(Model $model, Request $request)
	{
		$this->model = $model;

		$this->table = with($model)->getTable();

		$this->request = $request;

		app('cache')->store('file')->forget('table');
		app('cache')->store('file')->forever('table', $this->table);

		return $this;
	}

	/**
	 * Metodo predefinido para agregar algun join en las subclases.
	 * 
	 * @return Model
	 */
	protected function joins()
	{
		return $this->model;
	}

	/**
	 * Metodo principal que inspecciona y ejecuta todos los
	 * filtros utilizados por las entidades de la api para
	 * su renderizado.
	 * 
	 * @return Model
	 */
	public function all()
	{
		$this->runRelations();
		$this->delete();
		$this->filtering();

		$this->model = $this->joins();

		$this->sorting();
		$this->paging();
		$this->fields();

		return $this->model;
	}

	/**
	 * Retorna un registro si coincide con el identificador enviado.
	 * 
	 * @param  strifg $id 
	 * @param  string $by    atributo por el cual buscar
	 * @return Model
	 */
	public function find($id, $by = 'id')
	{
		$this->model = $this->model->with($this->matchRelation($this->relations));

		$this->delete();

		$this->model = $this->joins()->where($this->table.'.'.$by, '=', $id);

		$this->withoutFields();

		return $this->model->first();
	}

	public function count()
	{
		$this->delete();

		$this->filtering();

		return $this->model->count();
	}

	/**
	 * Verifica si esta activado el filtro de delete en el endpoint
	 * de la api y ejecuta dicho filtro en el caos ser activado.
	 *
	 * @example 'http://EndPoint/?delete=on' solo muestra los eliminados
	 * @example 'http://EndPoint/?delete=join' muestra todos los registros
	 * @see     Request::input()
	 * @see     Model::where()
	 * @return  void
	 */
	final protected function delete()
	{
		if($this->deleteMode == false) {
			return;
		}

		if ($this->request->input('delete') == 'on') {
			$this->model = $this->model->where("{$this->table}.delete", '=', 1);
		} elseif ($this->request->input('delete') == 'join') {

		} else {
			$this->model = $this->model->where("{$this->table}.delete", '=', 0);
		}
	}

	/**
	 * Asigna las relaciones que utilizara el filtro.
	 * 
	 * @param  array $relations
	 * @return Filter
	 */
	public function relations(array $relations)
	{
		$this->relations = $relations;

		return $this;
	}

	/**
	 * Asigna los atributos ocultos por defecto.
	 * 
	 * @param  array  $hidden
	 * @return Filter
	 */
	public function hidden(array $hidden)
	{
		$this->hidden = $hidden;

		return $this;
	}

	/**
	 * Setea los atributos que se tomaran en cuenta para el filtrado.
	 * 
	 * @param  array  $attributes
	 * @return Filter
	 */
	public function attributes(array $attributes)
	{
		$this->attributes = $attributes;

		return $this;
	}

	/**
	 * Verifica y aplica filtros del tipo fields si es que estan
	 * relacionados con alguna relacion de laravel.
	 *
	 * @example 'http://EndPoint/?fields=relationship1,relationship2'
	 * @see     Request::has()
	 * @see     Model::with()
	 * @return  void
	 */
	final protected function runRelations()
	{
		if (!$this->request->has('fields')) {
			$this->model = $this->model->with($this->matchRelation($this->relations));
			return null;
		}

		$this->model = $this->model->with($this->matchRelation($this->getActiveRelations()));
	}

	/**
	 * Activa lar relaciones hijas desencadenadas por las relaciones
	 * atadas al modelo principal en el caso de que se definan
	 * estas relaciones por un metodo preasignado.
	 *
	 * @example Filter::relationByAttibute() este debe mandar un array con las relaciones hijas.
	 * @param   array  $relations
	 * @return  array
	 */
	final protected function matchRelation(array $relations)
	{
		$relationsBy = [];

		foreach ($relations as $key => $value) {
			$method = 'relationsBy' . ucwords($value);
	
			if (method_exists($this, $method)) {
				$relationsBy = array_merge($relationsBy, $this->{$method}());
			}
		}

		return $this->addFilterRelationDelete(array_merge($relations, $relationsBy));
	}

	/**
	 * Agrega un filtro a las relaciones para que no muestre los
	 * registros de la relaciones que han sido eliminadas
	 * 
	 * @param array $with
	 */
	final protected function addFilterRelationDelete(array $with)
	{
		$relations = [];

		$filter = function($query){
			$query->where('delete', '=', 0);
		};

		foreach ($with as $key => $value) {
			if (!in_array($value, $this->except)) {
				$relations[$value] = $filter;
			} else {
				array_push($relations,$value);
			}
		}

		return $relations;
	}

	/**
	 * Retorna las relaciones activadas en concordancia con el
	 * arreglo de relaciones del objeto Filter
	 *
	 * @see    Request::input()
	 * @return array
	 */
	final protected function getActiveRelations()
	{
		$relations = [];

		$fields = explode(',', $this->request->input('fields'));

		foreach ($this->relations as $key => $value) {
			if (in_array($value, $fields)) {
				array_push($relations, $value);
				
			}
		}

		return $relations;
	}

	/**
	 * Activa los filtros de los atributos mandados via GET, tambien
	 * ejecuta algun metodo donde tenga un filtrado particular,
	 * ya sea si el atributo a filtrar este dentro de alguna de las relaciones
	 *
	 * @example Filter::filExampleAttribute()
	 * @see     Request::except()
	 * @see     Model::where()
	 * @return  void
	 */
	final protected function filtering()
	{
		$filter = $this->request->except(['timestamps','filter','delete','fields', 'sort']);

		foreach ($filter as $key => $value) {
			$method = 'fil'.ucwords($key).'Attribute';

			if (in_array($key, $this->attributes)) {
				$this->model = $this->model->where($key,'=',$value);
			} else if (method_exists($this, $method)) {
				$this->model = $this->{$method}($value);
			}
		}
	}

	/**
	 * Filtro que se encarga de hacer un ordenamiento de mayor a
	 * menor o viceversa dependiendo el atributo.
	 *
	 * @example 'http://EndPoint/?sort=+attribute1,-attribute2'
	 * @see     Request::has()
	 * @see     Request::input()
	 * @see     Model::orderBy()
	 * @return  void
	 */
	final protected function sorting()
	{
		if ($this->request->has('sort')) {
			$sort = explode(',', $this->request->input('sort'));

			foreach ($sort as $key => $value) {
				$attribute = substr($value,1);

				$order = ($value[0] == '-') ? 'desc' : 'asc';

				$this->model = $this->model->orderBy($attribute, $order);
			}
		}
	}

	/**
	 * Filtro de paginacion de registro de una entidad.
	 *
	 * @example 'http://EndPoint/?offset=50&limit=10' los dos parametros deben mandarse juntos.
	 * @see     Model::take()
	 * @see     Model::offset()
	 * @see     Request::input()
	 * @see     Request::has()
	 * @return  void
	 */
	final protected function paging()
	{
		$this->model = $this->model
							->take($this->request->input('limit', 100))
							->offset($this->request->input('offset', 0));
	}

	/**
	 * Filtro que determina que campos se van a mostrar.
	 * 
	 * @example 'http://EndPoint/?fields=attribute1,attibute2'
	 * @see     Request::has()
	 * @return  void
	 */
	final protected function fields()
	{
		$hidden = $this->hidden;
		if ($this->request->has('fields')) {
			$this->withFields();
			return;
		}

		$this->withoutFields();
	}

	/**
	 * Oculta campos predeterminados en la propiedad hidden.
	 *
	 * @see    Model::get()
	 * @see    Model::each()
	 * @return void
	 */
	final protected function withoutFields()
	{
		$this->model = $this->model->get()->each(function($row) {
			$row->addHidden($this->hidden);
		});
	}

	/**
	 * Muestra solo los campos que son enviados por el filtro fields.
	 *
	 * @see    Request::input()
	 * @see    Model::get()
	 * @see    Model::each()
	 * @return void
	 */
	final protected function withFields()
	{
		$this->fields = explode(',', $this->request->input('fields'));

		if(($key = array_search('password', $this->fields)) !== false) {
		    unset($this->fields[$key]);
		}

		$this->model = $this->model->get()->each(function($row) {
			$row->setVisible($this->fields);
		});
	}
}
