<?php 
namespace Entities\Vehicles;

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

class Vehicles extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable;
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
        'id',
        'registation_plate',
        'customer_id',
        'color_id',
        'type_id',
        'model_id',
	];



    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'model',
        'type',
        'color'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'registation_plate',
        'customer_id',
        'color_id',
        'type_id',
        'model_id',
    ];

    protected $hidden = [
        'model_id',
        'type_id',
        'color_id'
    ];

    /**
     * Atributo identificador de busqueda
     * 
     * @var string
     */
    //protected $findKey = 'username';

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un vehiculo con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El vehiculo no existe o ya fue eliminado';

    
}