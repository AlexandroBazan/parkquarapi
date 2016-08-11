<?php

namespace Impark\Ent;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
	/**
	 * Deshabilitacion de los timestamp predeterminados de
	 * laravel
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Retorno del atrributo prefabricado de timestamps
	 * 
	 * @return Array/Timestamp 
	 */
	public function getTimestampsAttribute()
    {
    	$parameters = ['id','time','ip','user_id','app_id'];
    	return [
    		'created' => $this->created_at()->first($parameters)->toArray(),
    		'updated' => $this->updated_at()->first($parameters)->toArray(),
    		'deleted' => $this->deleted_at()->first($parameters)->toArray(),
    	];
    }

    /**
     * Relacion uno a uno del timestamp de creacion
     * 
     * @return Relationship
     */
    protected function created_at()
    {
    	return $this->hasOne('Impark\Timestamps\TimestampsModel', 'id', 'created_id');
    }

    /**
     * Relacion uno a uno del timestamp de creacion
     * 
     * @return Relationship
     */
    protected function updated_at()
    {
    	return $this->hasOne('Impark\Timestamps\TimestampsModel', 'id', 'updated_id');
    }

    /**
     * Relacion uno a uno del timestamp de creacion
     * 
     * @return Relationship
     */
    protected function deleted_at()
    {
    	return $this->hasOne('Impark\Timestamps\TimestampsModel', 'id', 'deleted_id');
    }

    /**
     * Render del objeto a arreglo modificado de la funcionalidad
     * heredada de la clase padre
     * 
     * @see    Model::addHidden()
     * @param  integer $options 
     * @return parent::toArray()
     */
    public function toArray($options = 0) {
    	
    	$this->inTable($this->table);
    	
    	$this->addHidden(['created_id', 'deleted_id', 'updated_id']);
        return parent::toArray();
    }

    /**
     * Metodo para agregar funcionalidad dependiendo si el modelo
     * pertenece a una tabla predeterminada o no
     *
     * @see    Request::input()
     * @see    Model::addHidden()
     * @param  string $table
     * @return void
     */
    protected function inTable($table) {
    	$tableFilter = app('cache')->store('file')->get('table');


    	$this->callTableRelation($tableFilter);
    	
    	if ($tableFilter == $table) {
    		$this->addTimestamps();
    		$this->hiddenDelete();
    	} else {
    		$this->addHidden(['delete']);
    	}
    }

    /**
     * llama a una funcion tomando en cuenta la tabla que quiere 
     * hacer una relacion
     * 
     * @param  string $table
     * @return void
     */
    protected function callTableRelation($table)
    {
    	$method = 'callRelation' . ucwords($table);

    	if (method_exists($this, $method)) {
    		$this->{$method}();
    	}
    }

    /**
     * Activa el atrributo timestamps si es enviado por filtro
     * GET
     *
     * @see    Request::input()
     * @return void
     */
    protected function addTimestamps()
    {
    	if (app('request')->input('timestamps') == 'on') {
    		array_push($this->appends,'timestamps');
    	}
    }

    /**
     * Oculta el campo delete en caso de que no este activado
     * el filtro GET 'delete' en modo 'join'.
     *
     * @see    Request::input()
     * @see    Model::addHidden()
     * @return void
     */
    protected function hiddenDelete()
    {
    	if (app('request')->input('delete') != 'join') {
    		$this->addHidden(['delete']);
    	}
    }
}