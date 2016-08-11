<?php 
namespace Entities\Profiles;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;

use Entities\Permissions\Models\Permission;

class Profiles extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable{
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
        'group_id'
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'group'
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
        'group_id'
    ];

    /**
     * Atributos ocultos al render
     * 
     * @var array
     */
    protected $hidden = ['group_id'];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un perfil con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El perfil no existe o ya fue eliminado';

    public function remove($id, Request $request)
    {
        $deletedId = $this->timestamps->delete($request);
                
        (new Permission)->where('profile_id', '=', $id)->update(['delete' => 1]);

        return $this->NativeRemove($id, $request);
    }
}