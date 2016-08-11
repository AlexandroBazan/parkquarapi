<?php 
namespace Entities\BranchOffices;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;


class BranchOffices extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
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
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un establecimiento con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El establecimiento no existe o ya fue eliminado';

    
}