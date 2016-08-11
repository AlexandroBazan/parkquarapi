<?php 
namespace Entities\Routes;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

use Illuminate\Http\Request;

class Routes extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable;
    
    /**
     * Atributos que van ha poder ser filtrados
     * 
     * @var array
     */
	protected $attributes = [
		'app_id',
	];

    /**
     * Relaciones que van hacer activadas en el render
     * 
     * @var array
     */
	protected $relations = [
		'app'
	];

    /**
     * Atributos que van a ser modificados en primera
     * instancia
     * 
     * @var array
     */
    protected $fillable = [
        'description',
        'app_id',
    ];

    protected $hidden = [
        'app_id'
    ];

    /**
     * Mensaje de error de busqueda
     * 
     * @var string
     */
	protected $messageOneError = 'No existe una ruta con ese identificador';

    /**
     * Mensaje de error de busqueda por eliminacion
     * 
     * @var string
     */
	protected $messageRemoveError = 'La ruta no existe o ya fue eliminada';
}