<?php 
namespace Entities\Groups;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;

use Entities\Profiles\Models\Profile;
use Entities\Groups\Models\Group;
use Entities\Permissions\Models\Permission;

class Groups extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable {
        Removable::remove as NativeRemove;
    }
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
		'name',
        'active',
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'profiles'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
    ];

    /**
     * Atributo identificador de busqueda
     * 
     * @var string
     */
    protected $findKey = 'name';

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un grupo con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El grupo no existe o ya fue eliminado';

    /**
     * Metodo reescrito para eliminar los perfiles asiciados
     * al grupo a eliminar.
     * 
     * @param  mixin   $id
     * @param  Request $request
     * @return Error/null
     */
    public function remove($id, Request $request)
    {
        $deletedId = $this->timestamps->delete($request);
        
        $groupId = (new Group)->where('name', '=', $id)->first()->id;

        (new Profile)->where('group_id', '=', $groupId)
                     ->update([
                        'delete'     => 1, 
                        'deleted_id' => $deletedId
                     ]); 
                
        (new Permission)->whereHas('profile', function ($query) use ($groupId) {
            $query->where('group_id', '=', $groupId);
        })->update(['delete' => 1]);

        return $this->NativeRemove($id, $request);
    }
}