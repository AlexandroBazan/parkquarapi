<?php 
namespace Entities\Permissions;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;

class Permissions extends Entity implements RemovingInterface, InsertingInterface
{
    use Insertable, Removable;
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
		'user_id',
        'profile_id',
        'branch_office_id',
        'active',
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'profile',
		'branch_office'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'profile_id',
        'branch_office_id',
        'active',
    ];

    /**
     * Atributos ocultos al render
     * 
     * @var array
     */
    protected $hidden = ['profile_id', 'branch_office_id'];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un permiso con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El permiso no existe o ya fue eliminado';

	/**
	 * Retorna todos los registros filtrados por perfil, con el formato
	 * preestablecido
	 * 
	 * @param  mixin   $id
	 * @param  Request $request
	 * @return Collection
	 */
	public function byProfile($id, Request $request)
	{
		$count  = $this->filter->dependencies($this->model, $request)->whereProfileId($id)->count();
		
		$items  = $this->allByProfileId($id, $request);
		
		return $this->prepareCollectionResponse($request, $items, $count);
	}

	/**
	 * Retorna todos los permisos filtrados por el id de perfil
	 * 
	 * @param  mixin   $id
	 * @param  Request $request
	 * @return Model::all()
	 */
	protected function allByProfileId($id, Request $request)
	{
		return $this->filter
					->dependencies($this->model, $request)
					->attributes($this->attributes)
					->relations(['branch_office'])
					->hidden($this->hidden)
					->whereProfileId($id)
					->all();
	}
}