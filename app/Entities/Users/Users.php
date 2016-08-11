<?php 
namespace Entities\Users;

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

class Users extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable;
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
        'username',
        'firstname',
        'lastname',
        'dni',
        'gender',
        'image',
        'birthday'
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'emails',
		'permissions',
        'phones',
        'addresses'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'person_id',
        'password',
        'username',
        'firstname',
        'lastname',
        'dni',
        'gender',
        'image',
        'birthday'
    ];

    protected $hidden = ['person_id', 'password'];

    /**
     * Atributo identificador de busqueda
     * 
     * @var string
     */
    protected $findKey = 'username';

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe un cliente con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'El cliente no existe o ya fue eliminado';

    
}