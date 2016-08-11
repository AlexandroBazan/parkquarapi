<?php 
namespace Entities\Accesses;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;

class Accesses extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable;
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
		'profile_id',
		'route_id',
		'active',
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'profile', 'route'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'profile_id',
		'route_id',
		'active',
    ];

    protected $hidden = [
        'profile_id',
        'route_id',
    ];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un acceso con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El acceso no existe o ya fue eliminado';

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
                    ->relations(['route'])
                    ->hidden($this->hidden)
                    ->whereProfileId($id)
                    ->all();
    }
}