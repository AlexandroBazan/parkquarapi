<?php
namespace Impark\Ent\test;

use Impark\Ent\Entity;

use Impark\Constracts\RemovingInterface;
use Impark\Constracts\EditingInterface;
use Impark\Constracts\InsertingInterface;

use Impark\Ent\Traits\Removable;
use Impark\Ent\Traits\Editable;
use Impark\Ent\Traits\Insertable;

class Users extends Entity implements RemovingInterface, InsertingInterface, EditingInterface
{
    use Insertable, Editable, Removable;
    
	protected $attributes = [
		'id',
        'username',
        'firstname',
        'lastname',
        'dni',
        'active',
        'gender',
        'image',
        'birthday'
	];

	protected $relations = [
		'permissions', 
        'emails',
        'addresses',
        'phones'
	];

    protected $fillable = [
        'username',
        'password',
        'person_id',
        'active',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

	protected $hidden = ['person_id'];

	protected $findKey = 'username';

	protected $messageOneError = 'No existe un usuario con ese nombre de usuario';

	protected $messageRemoveError = 'El usuario no existe o ya fue eliminado';
}