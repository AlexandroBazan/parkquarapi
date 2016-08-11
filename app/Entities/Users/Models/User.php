<?php
namespace Entities\Users\Models;

use Impark\Ent\Model;

class User extends Model
{
	protected $table = 'users';

	protected $fillable = [
        'username',
        'password',
        'active',
        'person_id',
        'delete',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    public function emails()
    {
    	return $this->hasMany('Entities\Persons\Models\Email', 'person_id', 'person_id');
    }

    public function permissions()
    {
        return $this->hasMany('Entities\Permissions\Models\Permission', 'user_id', 'id');
    }

    public function phones()
    {
        return $this->hasMany('Entities\Persons\Models\Phone', 'id', 'person_id');
    }

    public function addresses()
    {
        return $this->hasMany('Entities\Persons\Models\Address', 'id', 'person_id');
    }
}